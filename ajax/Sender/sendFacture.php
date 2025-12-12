<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Define ROOT if not already defined (project root: crm.buja)
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
}

require_once ROOT . 'vendor/autoload.php';
require_once ROOT . 'model/connection.php';
require_once ROOT . 'model/contract.class.php';
require_once ROOT . 'model/comptabilite.class.php';
require_once ROOT . 'config/_config_mail.php';
require_once ROOT . 'controller/mail.controller.php';

$contract = new Contract();
$comptabilite = new Comptabilite();
$banque = $comptabilite->getBanqueActiveAndVisibleOnInvoice();

$mois = $_GET['mois_fact'];
$annee = $_GET['annee_fact'];

$etat = '';
$billing_date = $annee . '-' . $mois . '-01';

$stats = [
    'total' => 0,
    'sent' => 0,
    'skipped_no_email' => 0,
    'skipped_invalid_email' => 0,
    'failed' => 0,
    'errors' => []
];

// Process invoices in batches to avoid timeout (max 100 per batch)
$invoices = $contract->recupereIdfactureToSendOnMail($billing_date);
$batch_size = 100;
$batches = array_chunk($invoices, $batch_size);

foreach ($batches as $batch) {
    foreach ($batch as $value) {
        $facture_id = $value->facture_id;
        $stats['total']++;

        $client = [
            'ID_client' => $value->ID_client,
            'billing_number' => $value->billing_number,
            'nom_client' => $value->nom_client,
            'adresse' => $value->adresse,
            'nif' => $value->nif,
            'assujettiTVA' => $value->assujettiTVA,
            'telephone' => $value->telephone,
            'facture_id' => $value->facture_id,
            'numero' => $value->numero,
            'date_creation' => $value->date_creation,
            'show_rate' => $value->show_rate,
            'exchange_rate' => $value->exchange_rate,
            'tvci' => $value->tvci,
            'mail' => $value->mail
        ];

        // Add safe fallbacks for keys expected by the PDF generator
        $client['Nom_client'] = isset($client['nom_client']) ? $client['nom_client'] : '';
        $client['nomService'] = isset($client['nomService']) ? $client['nomService'] : '';
        $client['bandepassante'] = isset($client['bandepassante']) ? $client['bandepassante'] : '';
        $client['exchange_currency'] = isset($client['exchange_currency']) ? $client['exchange_currency'] : (isset($client['exchange_rate']) ? $client['exchange_rate'] : '');
        $client['billing_date'] = isset($client['billing_date']) ? $client['billing_date'] : $client['date_creation'];

        // Parse emails with multiple delimiters: comma, semicolon, space, slash, dash, pipe
        $emailString = $value->mail;
        $emailString = preg_replace('#[,;\s/\-\|]+#', ',', $emailString); // normalize delimiters to comma
        $emails = array_filter(array_map('trim', explode(',', $emailString)));

        if (empty($emails)) {
            $stats['skipped_no_email']++;
            $stats['errors'][] = "Facture {$value->numero}: Pas d'adresse email";
            continue;
        }

        // Validate email format
        $validEmails = [];
        $invalidEmails = [];
        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $validEmails[] = $email;
            } else {
                $invalidEmails[] = $email;
            }
        }

        if (empty($validEmails)) {
            $stats['skipped_invalid_email']++;
            $stats['errors'][] = "Facture {$value->numero}: Email(s) invalide(s) - " . implode(', ', $invalidEmails);
            continue;
        }

        // Log if some emails were invalid but others were valid
        if (!empty($invalidEmails)) {
            $stats['errors'][] = "Facture {$value->numero}: Adresse(s) invalide(s) ignorée(s) - " . implode(', ', $invalidEmails) . " | Envoi aux adresses valides: " . implode(', ', $validEmails);
        }

        try {
            require_once ROOT . "printing/fiches/imprimerfactureParId.php";

            $pdf = new myPDF();
            $pdf->SetLeftMargin(15.2);
            $pdf->AliasNbPages();
            $pdf->init($client);
            $pdf->setBanque($banque);
            $pdf->AddPage();
            $pdf->headerTable();
            $pdf->SetWidths(array(50, 20, 25, 25, 25, 25));
            $pdf->viewTable($contract, $facture_id);

            $attachment = $pdf->Output('facture_' . $pdf->getClient()['numero'] . '.pdf', 'S');

            // write temporary PDF file
            $tmpDir = ROOT . 'uploads/tmp/';
            if (!is_dir($tmpDir)) {
                @mkdir($tmpDir, 0755, true);
            }

            // sanitize invoice number to avoid slashes or invalid filename chars
            $rawNum = $pdf->getClient()['numero'];
            $safeNum = preg_replace('/[^A-Za-z0-9_\-]/', '_', $rawNum);
            $tmpFile = $tmpDir . 'facture_' . $safeNum . '_' . $facture_id . '.pdf';
            @file_put_contents($tmpFile, $attachment);

            $subject = 'Facture: ' . $pdf->getClient()['numero'];
            $body = 'Bonjour,<br><br>Veuillez trouver ci-joint votre facture pour le mois de ' . $mois . '.<br><br>Cordialement,<br>Équipe Administration';

            // Ensure proper UTF-8 encoding
            if (!mb_check_encoding($body, 'UTF-8')) {
                $body = mb_convert_encoding($body, 'UTF-8');
            }
            if (!mb_check_encoding($subject, 'UTF-8')) {
                $subject = mb_convert_encoding($subject, 'UTF-8');
            }

            $sent = send_email($validEmails, $subject, $body, [$tmpFile], true);
            if ($sent) {
                $stats['sent']++;
                $contract->update_Sent_Facture($pdf->getClient()['facture_id'], 1);
            } else {
                $stats['failed']++;
                $stats['errors'][] = "Facture {$value->numero}: Erreur lors de l'envoi SMTP";
            }

            // cleanup
            if (file_exists($tmpFile)) {
                @unlink($tmpFile);
            }

            unset($pdf);
        } catch (Exception $e) {
            $stats['failed']++;
            $stats['errors'][] = "Facture {$value->numero}: Exception - " . $e->getMessage();
        }

        // Small delay between sends to avoid hitting rate limits
        usleep(100000); // 100ms delay
    }
}

// Return detailed statistics
echo json_encode([
    'success' => $stats['sent'] > 0,
    'stats' => $stats,
    'message' => $stats['sent'] . ' facture(s) envoyée(s), ' . $stats['skipped_no_email'] . ' sans email, ' . $stats['skipped_invalid_email'] . ' emails invalides, ' . $stats['failed'] . ' erreur(s)'
]);
