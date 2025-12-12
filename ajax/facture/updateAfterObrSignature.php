<?php

require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();

// Check if required parameters are set
if (!isset($_GET['facture_id']) && !isset($_GET['invoice_signature']) && 
    !isset($_GET['identifier']) && !isset($_GET['date'])) 
{
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters.'
    ]);
    exit;
}

// Call the update method once and store the result
$result = $contract->updateFactureSignature($_GET['facture_id'], 
    $_GET['invoice_signature'], 
    $_GET['identifier'], 
    $_GET['date']);

echo json_encode([
    'success' => $result['result'] === 'ok',
    'message' => $result['msg'],
]);
