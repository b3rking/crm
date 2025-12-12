<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");  
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");
require_once("../../model/historique.class.php");

    date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");
    //$started_at = date('H:i:s');

	$comptabilite = new Comptabilite();
	$contract = new Contract();
	$client = new Client();
    $historique = new Historique();

	$facture = rtrim($_GET['facture'],'/');
	$factureSelect = preg_split("#[/]+#", trim($facture));
	$billing_date_array = array();
	$facture_array = array();
	if (!empty($_GET['facture'])) 
	{
		for ($i=0; $i < count(($factureSelect)); $i++) 
		{ 
			$facture = preg_split("#[=]+#", trim($factureSelect[$i]));
			$facture_array[] = $facture;
			$billing_date_array[] = $facture[6]; 
		}
		array_multisort($billing_date_array, SORT_ASC, $facture_array);
	}
	$date = date_parse($_GET['datepaiements']);
	$mois = ($date['month'] < 10 ? '0'.$date['month'] : $date['month']);
	$numero = $_GET['billing_number'].'/'.$date['year'].$mois.'01';
    $idbanque = ($_GET['idbanque'] == "" ? NULL : $_GET['idbanque']);

	if ($comptabilite->ajout_paiement($_GET['idclient'],$numero,$_GET['montantpaye'],$_GET['devises'],$_GET['methodepaiement'],$_GET['taux_de_change'],$_GET['exchange_currency'],$_GET['montant_converti'],$_GET['reference'],$_GET['tva'],$_GET['datepaiements'],$_GET['iduser'],0,$idbanque))  
	{
		/*if ($comptabilite->augmenterMontantGrandeCaisse($_GET['montantpaye'],$_GET['devises']) > 0) {
				# code...
			}*/
		$idpaiement = $comptabilite->getMaxIdPayement()->fetch()['ID_paiement'];
		if (!empty($_GET['facture'])) 
		{
			//$montant_converti = $_GET['montant_converti'];
            $payed_amount  = $_GET['montant_converti'];
//			foreach ($facture_array as $key => $value1) 
//			{
//				$facture_id = $value1[0];
//				$montantFacture = $value1[1];
//				$difference = $montant_converti - $montantFacture;
//				if ($difference <= 0) 
//				{
//					$reste = $difference * -1;
//					$montantpayer = $montant_converti;
//					if ($comptabilite->setFacturePayer($idpaiement,$facture_id,$montantpayer,$_GET['taux_de_change'],$_GET['datepaiements'])) 
//					{    
//						if ($contract->updateResteFacture($facture_id,$reste)) 
//						{
//						}
//					}
//				}
//				else
//				{
//					$reste = 0;
//					$montantpayer = $montantFacture;
//					$montant_converti = $difference;
//					if ($comptabilite->setFacturePayer($idpaiement,$facture_id,$montantpayer,$_GET['taux_de_change'],$_GET['datepaiements'])) 
//					{    
//						if ($contract->updateResteFacture($facture_id,$reste)) 
//						{
//						}
//					}
//				}
//				/*$facture = preg_split("#[-]+#", trim($factureSelect[$i]));
//
//				$montantFacture = $facture[1];
//				$montantpayer = $facture[6];
//
//				if ($_GET['exchange_currency'] != $_GET['devises']) 
//	            {
//	                if ($_GET['devises'] == 'USD') 
//	                {
//	                    $montantpayer *= $_GET['taux_de_change'];
//	                }
//	                else
//	                {
//	                    $montantpayer /= $_GET['taux_de_change'];
//	                }
//	            }
//	            else
//	            {
//	                $montantpayer = $montantpayer;
//	            }
//
//	            $reste = $montantFacture - $montantpayer;*
//
//				if ($comptabilite->setFacturePayer($idAction,$facture[0],$montantpayer=0,$_GET['taux_de_change'],$_GET['datepaiements'])) 
//				{    
//					/*if ($contract->updateResteFacture($facture[0],$reste)) 
//					{
//					}*
//				}*/
//			}
            foreach ($facture_array as $key => $value1) 
			{
				$facture_id = $value1[0];
				$montantFacture = $value1[1];
				if($payed_amount > 0 )
                {
                    $difference = $payed_amount - $montantFacture;
                    if($difference <= 0)
                    {
                        $reste = $difference * -1;
                        $payed_invoice_amount = $payed_amount;
                        $payed_amount = 0;
                    }
                    else
                    {
                        $reste = 0;
                        $payed_amount = $difference;
                        $payed_invoice_amount = $montantFacture;
                    }
                    if ($comptabilite->setFacturePayer($idpaiement,$facture_id,$payed_invoice_amount,$_GET['taux_de_change'],$_GET['datepaiements'])) 
					{    
						if ($contract->updateResteFacture($facture_id,$reste)) 
						{
						}
					}
                }
			}
			/*for ($i=0; $i < count(($factureSelect)); $i++) 
			{ 
				$facture = preg_split("#[-]+#", trim($factureSelect[$i]));

				/*$montantFacture = $facture[1];
				$montantpayer = $facture[6];

				if ($_GET['exchange_currency'] != $_GET['devises']) 
	            {
	                if ($_GET['devises'] == 'USD') 
	                {
	                    $montantpayer *= $_GET['taux_de_change'];
	                }
	                else
	                {
	                    $montantpayer /= $_GET['taux_de_change'];
	                }
	            }
	            else
	            {
	                $montantpayer = $montantpayer;
	            }

	            $reste = $montantFacture - $montantpayer;*

				if ($comptabilite->setFacturePayer($idAction,$facture[0],$montantpayer=0,$_GET['taux_de_change'],$_GET['datepaiements'])) 
				{    
					/*if ($contract->updateResteFacture($facture[0],$reste)) 
					{
					}*
				}
			}*/
		}
		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='actif') > 0) 
		{	
		}
		if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
		{	
		}
		if ($historique->setHistoriqueAction($idpaiement,'payement',$_GET['iduser'],$created_at,'creer')) 
		{
			# code...
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
//        foreach ($contract->getSommeTotaleFactureDunClient($_GET['idclient']) as $value) 
//        {
//            $facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
//        }
//        foreach ($contract->getSommeTotalePayementDunClient($_GET['idclient']) as $value) 
//        {
//            $paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
//        }
        //$balanceInitiale = ($contract->getBalanceInitiale($_GET['client_parent'])->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($_GET['client_parent'])->fetch()['montant']);
        
        $balanceInitiale = ($contract->getBalanceInitiale($_GET['idclient'])->fetch() ? $contract->getBalanceInitiale($_GET['idclient'])->fetch() : 0);
        $balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
        $solde = $facture_bif + $balanceInitiale - $paiement_bif;
        $client->updateSoldeClient($_GET['idclient'],$solde);
	}
?>
