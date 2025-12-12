<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/historique.class.php");
require_once("../../model/client.class.php");  

$historique = new Historique();
$contract = new Contract();
$client = new Client();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
//$WEBROOT = $_GET['WEBROOT'];
//$res = $contract->getMontantTotalDuneFacture($_GET['id_facture'])->fetchObject();
//idcontract+"&billing_date="+billing_date
foreach ($contract->getInvoicesToDelete($_GET['year'].'-'.$_GET['month'].'-01',$_GET['mode']) as $value) 
{
	/*try
	{
	    $con = connection();

	    //on lance la transaction
	    $con->beginTransaction();*/
		if ($contract->deleteFacutre($value->facture_id)) 
		{
			$taux = 1765;
			//$taux = 2000;
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
            
//			foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value1) 
//			{
//				$facture_bif += ($value1->monnaie == 'BIF' ? round($value1->montant) : round($value1->montant)*$taux);
//			}
//			foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value1) 
//			{
//				$paiement_bif += ($value1->exchange_currency == 'BIF' ? $value1->montant : $value1->montant*$taux);
//			}
			//$balanceInitiale = ($contract->getBalanceInitiale($value->ID_client)->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($value->ID_client)->fetch()['montant']);
			$balanceInitiale = ($contract->getBalanceInitiale($value->ID_client)->fetch() ? $contract->getBalanceInitiale($value->ID_client)->fetch() : 0);
			$balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);

			$solde = $facture_bif + $balanceInitiale - $paiement_bif;
			$client->updateSoldeClient($value->ID_client,$solde);

			$max_next_billing_date = $contract->get_Max_Next_Billing_date_Dun_client_From_Facture($value->ID_client);
			if ($max_next_billing_date == '') 
			{
				if ($contract->updateNext_billing_date($value->ID_contract,$next_billing_date=NULL) > 0) 
				{
					
				}
			}
			else
			{
				if ($contract->updateNext_billing_date($value->ID_contract,$max_next_billing_date) > 0) 
				{
					
				}
			}
		}
		//si jusque là tout se passe bien on valide la transaction
	    //$con->commit();
	/*}
	catch(Exception $e) //en cas d'erreur
	{
	    //on annule la transation
	    $con->rollback();

	    //on affiche un message d'erreur ainsi que les erreurs
	    echo 'Erreur : '.$e->getMessage().'<br />';
	    echo 'N° : '.$e->getCode();

	    //on arrête l'exécution s'il y a du code après
	    exit();
	}*/
}
