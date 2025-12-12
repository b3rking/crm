<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/historique.class.php"); 

$historique = new Historique();
$contract = new Contract();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
if ($contract->deleteContract($_GET['num_contract']) > 0) 
{
	//$webroot = $_GET['webroot'];
	if ($historique->setHistoriqueAction($_GET['num_contract'],'contrat',$_GET['iduser'],$created_at,'supprimer')) 
	{
		//require_once("rep.php");
	}
}