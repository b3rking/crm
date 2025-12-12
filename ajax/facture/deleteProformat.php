<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/historique.class.php");

$contract = new Contract();
$historique = new Historique();
//$WEBROOT = $_GET['WEBROOT'];

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
if ($contract->deleteProformat($_GET['facture_id']) > 0) 
{
	if ($historique->setHistoriqueAction($_GET['facture_id'],'proformat',$_GET['iduser'],$created_at,'supprimer')) 
	{
		//echo "ok";
	}
}