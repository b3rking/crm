<?php
require_once("../../model/connection.php");
require_once("../../model/client.class.php");
require_once("../../model/historique.class.php");   

$historique = new Historique();
$client = new Client();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
if ($client->deleteClient($_GET['idclient']) > 0) 
{
	if ($client->updateBillingNumberDunClient($_GET['idclient']) > 0) 
	{
		if ($historique->setHistoriqueAction($_GET['idclient'],'client',$_GET['iduser'],$created_at,'supprimer')) 
		{
			//require_once("repClient.php");
		}
	}
}
