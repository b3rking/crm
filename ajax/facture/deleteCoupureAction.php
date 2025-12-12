<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");

$contract = new Contract();
$client = new Client();
//$return = 'no';
if ($contract->deleteCoupureAction($_GET['coupure_id'])) 
{
	if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='actif') > 0) 
	{
		//$return = 'ok';
		if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
		{
			
		}
	}
	/*if ($_GET['type_client'] == 'free') 
	{
		if ($client->updateTypeAndEtat($_GET['idclient'],$_GET['type_client'],$etat='actif') > 0) 
		{
			$return = 'ok';
		}
	}
	else
	{
		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='actif') > 0) 
		{
			$return = 'ok';
			if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
    		{
    			if ($contract->setEtatFactureActifAfterDeleteCoupureAction($_GET['idclient'],$_GET['mois'],$_GET['annee']) > 0) 
				{
					$return = 'ok';
				}
    		}
		}
	}*/
	//echo $return;
}

