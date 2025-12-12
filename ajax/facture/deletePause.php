<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
//require_once("../../model/ticket.class.php");
require_once("../../model/client.class.php");

$contract = new Contract();
$client = new Client();

$date = date_parse($_GET['dateDebut']);
$mois = $date['month'];
$annee = $date['year'];
//$rep = 'no';
if ($_GET['checkDelete'] == 1) 
{
	if ($contract->deletePauseClient($_GET['idPause'])) 
	{
	    if ($client->updateEtatClient($_GET['idclient'],'actif') > 0) 
	    {
	    	//$rep = "ok";
	    }
	    if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
		{
			$facture = $contract->getMoisFactureDunClient($_GET['idclient'],$mois,$annee)->fetchObject();
    			if (!empty($facture))
			{
				if ($contract->updateEtatFacture($facture->facture_id,'actif') > 0) 
				{
					//echo "ok";
				}
			}
		}
	}
}
else
{
	if ($contract->updateStatusPause($_GET['idPause'])) 
	{
	    if ($client->updateEtatClient($_GET['idclient'],'actif') > 0)
	    	//$rep = "ok";
	    if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
			//$rep = "ok";
		if ($contract->updateDateOuverturePause($_GET['idPause'],$_GET['dateOuverture']) > 0)
		{
			$facture = $contract->getMoisFactureDunClient($_GET['idclient'],$mois,$annee)->fetchObject();
    			if (!empty($facture))
			{
				if ($contract->updateEtatFacture($facture->facture_id,'actif') > 0) 
				{
					//echo "ok";
				}
			}
		}
	}
}
