<?php

require_once("/var/www/crm.buja/model/connection.php");
require_once("/var/www/crm.buja/model/contract.class.php");  
require_once("/var/www/crm.buja/model/client.class.php");
require_once("/var/www/crm.buja/model/comptabilite.class.php");


$contract = new Contract();
$client = new Client();
$comptabilite = new Comptabilite();

date_default_timezone_set("Africa/Bujumbura");
$date = date('Y-m-d');
$toDay = date("d");
$month = date("m");
$year = date("Y");
$lastDay = date("t",mktime(0,0,0,$month,1,$year));

if($toDay == $lastDay)
{
    $taux = 1765;
    $dateTime = new DateTime($year.'-'.$month.'-01');
    $dateTime->add(new DateInterval('P1M'));
    $billingDate = $dateTime->format('Y-m-01');
    $created_at = $year."-".$month."-".$lastDay;
    $invoiceCond = " AND fac.billing_date = '".$billingDate."' ";
    
    $invoices_amount = 0;
    $delinquent = 0;
    foreach ($contract->filtreFactures($invoiceCond) as $value) 
    {
        $thisRate = $value->exchange_rate >= 500 ? $value->exchange_rate:$taux;
        $invoices_amount += (strtolower($value->monnaie) == 'bif' ? $value->montant_total : $value->montant_total*$thisRate);
        $invoices_amount += $value->ott;
    }
    
    foreach ($client->getClientDelinquants() as $value) 
    {
        $delinquent += $value->solde;
    }
    
    $tables = " paiement p,client cl,facture fc,facture_payer fp ";
    $paymentCond = " AND p.ID_paiement = fp.ID_paiement AND fc.facture_id = fp.facture_id AND fc.billing_date ='".$billingDate."' ";
    
    $paid_amount = 0;
    foreach ($comptabilite->filtrePayement($paymentCond,$tables) as $value) 
    {
        $thisRate = $value->Taux_change_courant >= 500 ? $value->Taux_change_courant:$taux;
        $paid_amount += (strtolower($value->exchange_currency) == 'bif' ? $value->montant_converti : $value->montant_converti*$thisRate);
        
    }
    
    $total_solde = $invoices_amount + $delinquent;
    $remains_to_be_collected = $total_solde - $paid_amount;
    
    $billingMonth = intval($dateTime->format('m'));
    $billingYear = $dateTime->format('Y');
    $id = $billingMonth.'-'.$billingYear;
    if($comptabilite->setMonthlyAmountToBeCollected($id,$invoices_amount,$delinquent,$total_solde,$paid_amount,$remains_to_be_collected,$created_at))
    {}
//    echo "invoice : $invoices_amount delinquent: $delinquent paid_amount : $paid_amount remains_to_be_collected : $remains_to_be_collected";
}
//else echo "toDay : $toDay lastDay : $lastDay";
