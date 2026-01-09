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

error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', 1);


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


// In sendSingleFacture.php, after getting $factureData:

// Get the actual billing_date from the database
$queryDate = $con->prepare("SELECT billing_date, exchange_currency FROM facture WHERE facture_id = ?");
$queryDate->execute(array($facture_id));
$invoiceData = $queryDate->fetch(PDO::FETCH_OBJ);



// In sendSingleFacture.php, AFTER getting $factureData and BEFORE calling require_once for PDF:

// Get the actual billing_date and exchange_currency from the facture table
$queryInvoice = $con->prepare("SELECT billing_date, exchange_currency, monnaie FROM facture WHERE facture_id = ?");
$queryInvoice->execute(array($facture_id));
$invoiceDetails = $queryInvoice->fetch(PDO::FETCH_OBJ);

// Set billing_date - this is CRITICAL
if ($invoiceDetails && $invoiceDetails->billing_date) {
    $client['billing_date'] = $invoiceDetails->billing_date; // Should be YYYY-MM-DD format
} else {
    // Fallback: convert date_creation from d/m/Y to Y-m-d
    $dateObj = DateTime::createFromFormat('d/m/Y', $factureData->date_creation);
    $client['billing_date'] = $dateObj ? $dateObj->format('Y-m-d') : date('Y-m-d');
}

// Set exchange_currency - this is ALSO CRITICAL
if ($invoiceDetails && $invoiceDetails->exchange_currency) {
    $client['exchange_currency'] = strtolower($invoiceDetails->exchange_currency);
} elseif ($invoiceDetails && $invoiceDetails->monnaie) {
    $client['exchange_currency'] = strtolower($invoiceDetails->monnaie);
} else {
    $client['exchange_currency'] = 'bif'; // Default
}

// Remove this line - it's problematic:
// $client['exchange_currency'] = isset($client['exchange_currency']) ? $client['exchange_currency'] : (isset($client['exchange_rate']) ? $client['exchange_rate'] : '');

// Also add quantite if needed (for OTT calculation)
$services = $contract->recupererServicesDunFacture($facture_id);
if (!empty($services)) {
    $client['nomService'] = $services[0]->nomService;
    $client['bandepassante'] = isset($services[0]->bande_passante) ? $services[0]->bande_passante : '';
    $client['quantite'] = isset($services[0]->quantite) ? $services[0]->quantite : 1; // Add this
} else {
    $client['nomService'] = '';
    $client['bandepassante'] = '';
    $client['quantite'] = 1; // Default
}




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

// Get service details for this invoice
$services = $contract->recupererServicesDunFacture($facture_id);
if (!empty($services)) {
    $client['nomService'] = $services[0]->nomService;
    $client['bandepassante'] = isset($services[0]->bande_passante) ? $services[0]->bande_passante : '';
} else {
    $client['nomService'] = '';
    $client['bandepassante'] = '';
}

// Ensure billing_date and exchange_currency are correctly set (prefer explicit invoice fields)
if (isset($invoiceDetails->billing_date) && !empty($invoiceDetails->billing_date)) {
    // Use the DB billing_date (expected format YYYY-MM-DD) so comparisons behave correctly
    $client['billing_date'] = $invoiceDetails->billing_date;
} else {
    // Fallback: convert date_creation (d/m/Y) to Y-m-d for reliable comparisons
    $dateObj = DateTime::createFromFormat('d/m/Y', $client['date_creation']);
    $client['billing_date'] = $dateObj ? $dateObj->format('Y-m-d') : $client['date_creation'];
}

if (isset($invoiceDetails->exchange_currency) && !empty($invoiceDetails->exchange_currency)) {
    $client['exchange_currency'] = strtolower($invoiceDetails->exchange_currency);
} elseif (isset($invoiceDetails->monnaie) && !empty($invoiceDetails->monnaie)) {
    $client['exchange_currency'] = strtolower($invoiceDetails->monnaie);
} else {
    // Last resort: keep a sensible default (BIF) to ensure invoice display logic can run
    $client['exchange_currency'] = (isset($client['exchange_currency']) && in_array(strtolower($client['exchange_currency']), ['usd', 'bif', 'eur'])) ? strtolower($client['exchange_currency']) : 'bif';
}

// Ensure quantity is available (used in OTT calculation)
$servicesForQuant = $contract->recupererServicesDunFacture($facture_id);
if (!empty($servicesForQuant)) {
    $client['quantite'] = $servicesForQuant[0]->quantite ?? 1;
} else {
    $client['quantite'] = 1;
}

// Debug: log service / bandwidth / quantity for diagnosis (temporary)
error_log('sendSingleFacture debug: nomService=' . (isset($client['nomService']) ? $client['nomService'] : '') . ' | bandepassante=' . (isset($client['bandepassante']) ? $client['bandepassante'] : '') . ' | quantite=' . (isset($client['quantite']) ? $client['quantite'] : ''));

require_once ROOT . "printing/fiches/imprimerfactureParId.php";
$pdf = new myPDF();
$pdf->SetLeftMargin(15.2);
$pdf->AliasNbPages();
$pdf->init($client);
$pdf->setBanque($banque);
$pdf->AddPage();
$pdf->headerTable();
$pdf->SetWidths(array(30, 20, 20, 20, 20, 25, 20, 25));
$pdf->viewTable($contract, $facture_id);


$attachment = $pdf->Output('facture_' . $pdf->getClient()['numero'] . '.pdf', 'S');

// ensure temp directory exists
$tmpDir = ROOT . 'uploads' . DIRECTORY_SEPARATOR . 'tmp';
if (!is_dir($tmpDir)) {
    mkdir($tmpDir, 0755, true);
}
if (!is_writable($tmpDir)) {          // ← add this line
    echo json_encode([
        'success' => false,
        'message' => 'Temp directory not writable',
        'type'    => 'error'
    ]);
    exit;
}

// sanitize invoice number to avoid slashes or invalid filename chars
$rawNum = $pdf->getClient()['numero'];
$safeNum = preg_replace('/[^A-Za-z0-9_\-]/', '_', $rawNum);
$tmpFile = $tmpDir . 'facture_' . $safeNum . '_' . $facture_id . '.pdf';

if (file_put_contents($tmpFile, $attachment) === false) {
    echo json_encode([
        'success' => false,
        'message' => 'PDF creation failed',
        'type'    => 'error'
    ]);
    exit;
}



if (!file_exists($tmpFile) || filesize($tmpFile) === 0) {
    echo json_encode([
        'success' => false,
        'message' => 'PDF file missing or empty',
        'type'    => 'error'
    ]);
    exit;
}

// Parse emails with multiple delimiters: comma, semicolon, space, slash, dash, pipe
$emailString = $factureData->mail;
$emailString = preg_replace('#[,;\s/\|]|(?<=\s)-|-(?=\s)#', ',', $emailString);
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

//$sent = send_email($validEmails, $subject, $body, [$tmpFile], true);
try {
    //    $sent = send_email($validEmails, $subject, $body, [$tmpFile], true);
    $sent = send_email($validEmails, $subject, $body, [$tmpFile => 'facture_' . $safeNum . '.pdf'], true);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'type'    => 'error'
    ]);
    exit;
}

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
