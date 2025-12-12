<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/ticket.class.php");
require_once("../../model/client.class.php");

$contract = new Contract();
$client = new Client();
if ($contract->saveCoupure($_GET['action'],$observation='',$_GET['idclient'],$_GET['montant'],$_GET['monnaie'],$_GET['mois'],$_GET['annee'],date('Y-m-d'),$_GET['motif'])) 
{
	if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='actif') > 0) 
	{
		echo "ok";
		/*if ($contract->updateEtatFacture($_GET['facture_id'],'derogation') > 0) 
		{
			echo "ok";
		}*/
	}
}
