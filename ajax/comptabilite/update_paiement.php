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

	if ($comptabilite->update_paiement($_GET['idpaiement'],$numero,$_GET['montantpaye'],$_GET['monnaie'],$_GET['taux_de_change'],$_GET['exchange_currency'],$_GET['montant_converti'],$_GET['methode'],$_GET['reference'],$_GET['tva'],$_GET['datepaiements'],$_GET['iduser'],$idbanque) > 0) 
	{
		/*$montant = $_GET['montantpaye'] - $_GET['old_montant'];
		if ($comptabilite->augmenterMontantGrandeCaisse($montant,$_GET['monnaie']) > 0) {
				# code...
			}*/
        
        if ($_GET['deposed'] == 1) 
		{
			$deposed_amount = $_GET['montantpaye'] - $_GET['old_montant'];
			$versement = $comptabilite->getVersementByIdPayement($_GET['idpaiement'])->fetch();
			if ($comptabilite->augmenterMontant_dans_versement($versement['id'],$deposed_amount) > 0) {
				# code...
			}
		}
		$facture_payee = array();
		foreach ($comptabilite->getFacture_dun_payement($_GET['idpaiement']) as $val) 
		{
		    $facture_payee[] = $val->facture_id;
		}
		foreach ($facture_payee as $id) 
	    {
	        if ($contract->updateResteFacture($id,0)) 
	    	{}
	    }
		$comptabilite->deleteFromFacturePayer($_GET['idpaiement']);
		if (!empty($_GET['facture'])) 
		{
			$montant_converti = $_GET['montant_converti'];
			foreach ($facture_array as $key => $value1) 
			{
				$facture_id = $value1[0];
				$montantFacture = $value1[1];
				$difference = $montant_converti - $montantFacture;
				if ($difference <= 0) 
				{
					$reste = $difference * -1;
					$montantpayer = $montant_converti;
					if ($comptabilite->setFacturePayer($_GET['idpaiement'],$facture_id,$montantpayer,$_GET['taux_de_change'],$_GET['datepaiements'])) 
					{    
						if ($contract->updateResteFacture($facture_id,$reste)) 
						{
						}
					}
				}
				else
				{
					$reste = 0;
					$montantpayer = $montantFacture;
					$montant_converti = $difference;
					if ($comptabilite->setFacturePayer($_GET['idpaiement'],$facture_id,$montantpayer,$_GET['taux_de_change'],$_GET['datepaiements'])) 
					{    
						if ($contract->updateResteFacture($facture_id,$reste)) 
						{
						}
					}
				}
			}
		}
		/*if ($_GET['nombreFacturePayer'] > 0) 
		{
			//$facture = rtrim($_GET['facture'],'/');
			//$factureSelect = preg_split("#[/]+#", trim($facture));

			//$value->facture_id.'-'.$montant.'-'.$value->monnaie.'-'.$value->taux_change_courant.'-'.$reste.'-'.$value->mois_debut.'-'.$value->annee.'-'.$value->montant_payer
			
			for ($i=0; $i < count(($factureSelect)); $i++) 
			{ 
				$facture = preg_split("#[-]+#", trim($factureSelect[$i]));

				$facture_id = $facture[0];
				if ($comptabilite->setFacturePayer($_GET['idpaiement'],$facture_id,$montantpayer=0,$_GET['taux_de_change'],$_GET['datepaiements'])) 
				{   
				}
				/*$old_reste = $facture[4];
				$montant_payer_old = $facture[7];
				$montant_payer_new = $facture[8];

				if ($_GET['exchange_currency'] != $_GET['monnaie']) 
	            {
	                if ($_GET['monnaie'] == 'USD') 
	                {
	                    $montant_payer_new *= $_GET['taux_de_change'];
	                }
	                else
	                {
	                    $montant_payer_new /= $_GET['taux_de_change'];
	                }
	            }
	            else
	            {
	                $montant_payer_new = $montant_payer_new;
	            }

	            $reste = $montant_payer_new - $montant_payer_old;
	            $reste *= -1;

				if ($comptabilite->updateFacturePayer($facture_id,$_GET['idpaiement'],$montant_payer_new) > 0) 
				{    
					if ($contract->updateResteFacture_apres_modification_payement($facture_id,$reste) > 0) 
					{
					}
					//echo "montant_payer_new = ".$montant_payer_new." old_reste = ".$old_reste." reste = ".$reste;
				}*
			}
		}*/

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
        
        
        $balanceInitiale = ($contract->getBalanceInitiale($_GET['idclient'])->fetch() ? $contract->getBalanceInitiale($_GET['idclient'])->fetch() : 0);
        $balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
        $solde = $facture_bif + $balanceInitiale - $paiement_bif;
        $client->updateSoldeClient($_GET['idclient'],$solde);


		if ($historique->setHistoriqueAction($_GET['idpaiement'],'payement',$_GET['iduser'],$created_at,'modifier')) 
		{
			//require 'repPaiement.php';
		}
	}