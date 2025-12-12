<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");

$contract = new Contract();
$client = new Client();
//$return = 'no';
//$date = date_parse($_GET['newDate']);

if ($contract->updateCoupure($_GET['action'],$_GET['observation'],$_GET['coupure_id'])) 
{
	if ($_GET['action'] == 'couper') 
	{
		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='coupure') > 0) 
    	{
            if ($contract->updateEtatContract($_GET['idclient'],'suspension') > 0) 
    		{
    			//$return = 'ok';
    		}
    	}
		/*if ($_GET['motif'] == 'dette') 
    	{
    		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='coupure') > 0) 
	    	{
	    		if ($_GET['facture_id'] != '') 
	    		{
	    			if ($contract->updateEtatFacture($_GET['facture_id'],'coupure') > 0) 
					{
						//$return = 'ok';
					}
	    		}
	    		if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
	    		{
	    			//$return = 'ok';
	    		}
	    	}
    	}
    	elseif ($_GET['motif'] == 'partie') 
    	{
    		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='gone',$etat='coupure') > 0) 
	    	{
	    		if ($_GET['type_client'] == 'paying') 
	    		{
	    			if ($contract->updateEtatContract($_GET['idclient'],'terminer') > 0) 
		    		{
		    			//$return = 'ok';
		    		}
	    		}
	    		//else $return = 'ok';
	    	}
    	}*/
	}
	else
	{
		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='actif') > 0) 
    	{
            if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
    		{}
    		/*if ($data = $contract->getFactureEnCoupureDunClient($_GET['idclient'])->fetch()) 
    		{
    			$date = date_parse($_GET['newDate']);
			    //$jour = $date['day'];
			    $mois = $date['month'];
			    $annee = $date['year'];
    			if ($date['month'] <= $data['mois_fin']) 
    			{
    				$date1 = new DateTime($_GET['date_creation']);
    				$date2 = new DateTime($_GET['newDate']);
                    $nbJoursCoupure = $date1->diff($date2)->days;
                    $prixJournalier = $data['montant']/30;
                    $montantCoupure = $nbJoursCoupure*$prixJournalier;
                    if ($contract->updateMontantTotalDuneFacture($data['facture_id'],ceil($montantCoupure)) > 0) 
                    {
                    	if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
			    		{
			    			if ($contract->updateEtatFacture($data['facture_id'],'actif') > 0) 
							{
								//$return = 'ok';
							}
			    		}
                    }
    			}
    		}//else $return = 'ok';*/
    	}
	}
	/*if ($_GET['old_action'] != $_GET['action'] || $_GET['old_motif'] != $_GET['motif']) 
	{
		$contract->setHistoriqueCoupure($_GET['coupure_id'],$_GET['action'],$_GET['observation'],$_GET['idclient'],$_GET['montant'],$_GET['monnaie'],$date['month'],$date['year'],$_GET['newDate'],$_GET['motif']);
	}
	//echo $return;*/
}
