<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");
require_once("../../model/historique.class.php");

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');

$contract = new Contract();
$comptabilite = new Comptabilite();
$client = new Client();
$historique = new Historique();

$facture = array();
foreach ($comptabilite->getFacture_dun_payement($_GET['idpaiement']) as $val) 
{
    $facture[] = $val->facture_id;
}
$versement = $comptabilite->getVersementByIdPayement($_GET['idpaiement'])->fetch();
if ($comptabilite->deletePaiement($_GET['idpaiement'])) 
{
    if ($_GET['deposed'] == 1) 
	{
		if ($comptabilite->diminuerMontant_dans_versement($versement['id'],$_GET['montant']) > 0) 
		{
			# code...
		}
	}
	foreach ($facture as $facture_id) 
    {
        if ($contract->updateResteFacture($facture_id,0)) 
    	{}
    }

	/*$taux = 1765;
	$facture_bif = 0;
	$paiement_bif = 0;
	foreach ($contract->getSommeTotaleFactureDunClient($_GET['idclient']) as $value) 
	{
		$facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
	}
	foreach ($contract->getSommeTotalePayementDunClient($_GET['idclient']) as $value) 
	{
		$paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
	}
	$balanceInitiale = ($contract->getBalanceInitiale($_GET['idclient'])->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($_GET['idclient'])->fetch()['montant']);
	$solde = $facture_bif + $balanceInitiale - $paiement_bif;
	$client->updateSoldeClient($_GET['idclient'],$solde);*/
    
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
//    foreach ($contract->getSommeTotaleFactureDunClient($_GET['idclient']) as $value) 
//    {
//        $facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
//    }
//    foreach ($contract->getSommeTotalePayementDunClient($_GET['idclient']) as $value) 
//    {
//        $paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
//    }
    //$balanceInitiale = ($contract->getBalanceInitiale($_GET['client_parent'])->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($_GET['client_parent'])->fetch()['montant']);
    
    $balanceInitiale = ($contract->getBalanceInitiale($_GET['idclient'])->fetch() ? $contract->getBalanceInitiale($_GET['idclient'])->fetch() : 0);
    $balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
    $solde = $facture_bif + $balanceInitiale - $paiement_bif;
    $client->updateSoldeClient($_GET['idclient'],$solde);
	
	if ($historique->setHistoriqueAction($_GET['idpaiement'],'payement',$_GET['iduser'],$created_at,'supprimer')) 
	{
	}
}