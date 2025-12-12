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
if ($contract->deleteFacutre($_GET['id_facture'])) 
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
    $balanceInitiale = ($contract->getBalanceInitiale($_GET['idclient'])->fetch() ? $contract->getBalanceInitiale($_GET['idclient'])->fetch() : 0);
    
    $balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
	$solde = $facture_bif + $balanceInitiale - $paiement_bif;
	$client->updateSoldeClient($_GET['idclient'],$solde);

	$max_next_billing_date = $contract->get_Max_Next_Billing_date_Dun_client_From_Facture($_GET['idclient']);
	if ($max_next_billing_date == '') 
	{
		if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date=NULL) > 0) 
		{
			
		}
	}
	else
	{
		if ($contract->updateNext_billing_date($_GET['idcontract'],$max_next_billing_date) > 0) 
		{
			
		}
	}

	/*if ($historique->setHistoriqueAction($_GET['id_facture'],'facture',$_GET['iduser'],date('Y-m-d'),'supprimer')) 
	{
		//require_once('rep.php');
	}*/

	/*if ($contract->deleteAccountHistory($_GET['id_facture'])) 
	{
		if ($comptabilite->setHistoriqueAction($_GET['id_facture'],'facture',$_GET['userName'],date('Y-m-d'),'supprimer')) 
		{
			require_once('rep.php');
		}
	}
	if ($contract->diminuerBalanceInitiale($res->ID_client,$res->montant) > 0) 
	{
		if ($contract->deleteAccountHistory($_GET['id_facture'])) 
		{
			if ($contract->deleteEcheance($_GET['id_facture'])) 
			{
				//echo "Suppresion reussie";
				if ($comptabilite->setHistoriqueAction($_GET['id_facture'],'facture',$_GET['userName'],date('Y-m-d'),'supprimer')) 
				{
					require_once('rep.php');
				}
			}
		}
	}*/
}