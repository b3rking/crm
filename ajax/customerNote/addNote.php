<?php
require_once("../../model/connection.php");
require_once("../../model/customerNote.class.php");
require_once("../../model/historique.class.php");  

$historique = new Historique();
$note = new CustomerNote();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
//$url = $_GET['url'];

if ($note->addNote($_GET['idclient'],$_GET['description'],$created_at,$_GET['iduser'])) 
{
	/*if ($historique->setHistoriqueAction($_GET['idclient'],'client',$_GET['iduser'],$created_at,'supprimer')) 
	{
	}*/
}
