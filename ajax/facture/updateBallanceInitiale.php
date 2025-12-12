<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/historique.class.php");  
require_once("../../model/client.class.php");  

$historique = new Historique();
$contract = new Contract();
$client = new Client();

if ($contract->updateBallanceInitiale($_GET['id'],$_GET['montant'],$_GET['monnaie'],$_GET['datebalance'],$_GET['description']) >0) 
{
    
    $taux = 1765;
    //$taux = 2000;
	$facture_bif = 0;
	$paiement_bif = 0;
    foreach ($contract->getSommeTotaleFactureDunClient($_GET['idclient']) as $value2) 
    {
        $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
        $facture_bif += (strtolower($value2->monnaie) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
        $facture_bif += $value2->ott;
    }
    foreach ($contract->getSommeTotalePayementDunClient($_GET['idclient']) as $value2) 
    {
        $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
        $paiement_bif += (strtolower($value2->exchange_currency) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
    }
//	foreach ($contract->getSommeTotaleFactureDunClient($_GET['idclient']) as $value) 
//	{
//		$facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
//	}
//	foreach ($contract->getSommeTotalePayementDunClient($_GET['idclient']) as $value) 
//	{
//		$paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
//	}
	//$balanceInitiale = ($contract->getBalanceInitiale($_GET['idclient'])->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($_GET['idclient'])->fetch()['montant']);

	$balanceInitiale = ($contract->getBalanceInitiale($_GET['idclient'])->fetch() ? $contract->getBalanceInitiale($_GET['idclient'])->fetch() : 0);
	$balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
	
	$solde = $facture_bif + $balanceInitiale - $paiement_bif;
	$client->updateSoldeClient($_GET['idclient'],$solde);
    
	if ($historique->setHistoriqueAction($_GET['id'],'balanceInitiale',$_GET['iduser'],date('Y-m-d'),'modifier')) 
	{
		//require_once('repBalance_initial.php');
	}
}