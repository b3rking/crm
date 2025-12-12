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

$facture_id = isset($_GET['facture_id']) ? $_GET['facture_id'] : null;

if (!$facture_id) {
    echo "Erreur: ID facture manquant";
    exit;
}

// Get invoice details using existing query method
$con = connection();
$query = $con->prepare("SELECT cl.ID_client,billing_number,nom_client,adresse,nif,assujettiTVA,telephone,fac.facture_id,fac.numero,DATE_FORMAT(fac.date_creation,'%d/%m/%Y') AS date_creation,show_rate,exchange_rate,tvci,mail FROM client cl,facture fac WHERE cl.ID_client = fac.ID_client AND fac.facture_id = ?");
$query->execute(array($facture_id)) or die(print_r($query->errorInfo()));
$factureData = $query->fetch(PDO::FETCH_OBJ);

if (!$factureData) {
    echo "Erreur: Facture non trouvée";
    exit;
}

// Use centralized send_email helper: generate PDF, save to temp file, call send_email
// Prepare client data
$client = [
    'ID_client' => $factureData->ID_client,
    'billing_number' => $factureData->billing_number,
    'nom_client' => $factureData->nom_client,
    'adresse' => $factureData->adresse,
    'nif' => $factureData->nif,
    'assujettiTVA' => $factureData->assujettiTVA,
    'telephone' => $factureData->telephone,
    'facture_id' => $factureData->facture_id,
    'numero' => $factureData->numero,
    'date_creation' => $factureData->date_creation,
    'show_rate' => $factureData->show_rate,
    'exchange_rate' => $factureData->exchange_rate,
    'tvci' => $factureData->tvci,
    'mail' => $factureData->mail
];

// Add safe fallbacks for keys expected by the PDF generator
$client['Nom_client'] = isset($client['nom_client']) ? $client['nom_client'] : '';
$client['nomService'] = isset($client['nomService']) ? $client['nomService'] : '';
$client['bandepassante'] = isset($client['bandepassante']) ? $client['bandepassante'] : '';
$client['exchange_currency'] = isset($client['exchange_currency']) ? $client['exchange_currency'] : (isset($client['exchange_rate']) ? $client['exchange_rate'] : '');
$client['billing_date'] = isset($client['billing_date']) ? $client['billing_date'] : $client['date_creation'];

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

// ensure temp directory exists
$tmpDir = ROOT . 'uploads/tmp/';
if (!is_dir($tmpDir)) {
    @mkdir($tmpDir, 0755, true);
}

// sanitize invoice number to avoid slashes or invalid filename chars
$rawNum = $pdf->getClient()['numero'];
$safeNum = preg_replace('/[^A-Za-z0-9_\-]/', '_', $rawNum);
$tmpFile = $tmpDir . 'facture_' . $safeNum . '_' . $facture_id . '.pdf';
@file_put_contents($tmpFile, $attachment);

// Parse emails with multiple delimiters: comma, semicolon, space, slash, dash, pipe
$emailString = $factureData->mail;
$emailString = preg_replace('#[,;\s/\-\|]+#', ',', $emailString); // normalize delimiters to comma
$emails = array_filter(array_map('trim', explode(',', $emailString)));

// Validate email addresses and collect valid ones
if (empty($emails)) {
    echo json_encode([
        'success' => false,
        'message' => 'Client n\'a pas d\'adresse email. Veuillez configurer l\'email du client.',
        'type' => 'warning'
    ]);
    exit;
}

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
    echo json_encode([
        'success' => false,
        'message' => 'Aucune adresse email valide trouvée pour ce client. Adresses invalides: ' . implode(', ', $invalidEmails),
        'type' => 'error'
    ]);
    exit;
}

$subject = 'Facture: ' . $factureData->numero;
$body = 'Bonjour,<br><br>Veuillez trouver ci-joint votre facture.<br><br>Cordialement,<br>Équipe Administration';

// Ensure proper UTF-8 encoding
if (!mb_check_encoding($body, 'UTF-8')) {
    $body = mb_convert_encoding($body, 'UTF-8');
}
if (!mb_check_encoding($subject, 'UTF-8')) {
    $subject = mb_convert_encoding($subject, 'UTF-8');
}

$sent = send_email($validEmails, $subject, $body, [$tmpFile], true);

if ($sent) {
    $contract->update_Sent_Facture($facture_id, 1);
    echo json_encode([
        'success' => true,
        'message' => 'Facture envoyée avec succès'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors de l\'envoi'
    ]);
}

// cleanup
if (file_exists($tmpFile)) {
    @unlink($tmpFile);
}
