<?php
require_once("/var/www/crm.buja/model/connection.php");
require_once("/var/www/crm.buja/model/contract.class.php");
require_once("/var/www/crm.buja/model/comptabilite.class.php");  
require_once("/var/www/crm.buja/model/client.class.php");  

$comptabilite = new Comptabilite();
$contract = new Contract();
$client = new Client();

$date = date_parse(date('Y-m-d'));
//$jour = $date['day'];
$mois_debut = $date['month'];
$annee_debut = $date['year'];

$taux = 1765;
//$taux = 2000;
if ($contract->updateEtatFactureDeMoisCourant(date('Y-m-01')) > 0) 
{
	foreach ($contract->get_Clients_Par_Mois_De_Facturation(date('Y-m-01')) as $value) 
	{
		/*$facture_bif = 0;
		$paiement_bif = 0;
		foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value2) 
		{
			$facture_bif += ($value2->monnaie == 'BIF' ? round($value2->montant) : round($value2->montant)*$taux);
		}
		foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value2) 
		{
			$paiement_bif += ($value2->exchange_currency == 'BIF' ? $value2->montant : $value2->montant*$taux);
		}
        
        $balanceInitiale = ($contract->getBalanceInitiale($value->ID_client)->fetch() ? $contract->getBalanceInitiale($value->ID_client)->fetch() : 0);
	    $balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
        $solde = $facture_bif + $balanceInitiale - $paiement_bif;
        
		$client->updateSoldeClient($value->ID_client,$solde);*/
        
		$facture_bif = 0;
		$paiement_bif = 0;
        foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value2) 
		{
            $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
			$facture_bif += (strtolower($value2->monnaie) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
            $facture_bif += $value2->ott;
		}
        foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value2) 
		{
            $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
			$paiement_bif += (strtolower($value2->exchange_currency) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
		}
//		foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value2) 
//		{
//			$facture_bif += ($value2->monnaie == 'BIF' ? round($value2->montant) : round($value2->montant)*$taux);
//		}
//		foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value2) 
//		{
//			$paiement_bif += ($value2->exchange_currency == 'BIF' ? $value2->montant : $value2->montant*$taux);
//		}
		
		$balanceInitiale = ($contract->getBalanceInitiale($value->ID_client)->fetch() ? $contract->getBalanceInitiale($value->ID_client)->fetch() : 0);
		$balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
		$solde = $facture_bif + $balanceInitiale - $paiement_bif;
		$client->updateSoldeClient($value->ID_client,$solde);
	}
}
