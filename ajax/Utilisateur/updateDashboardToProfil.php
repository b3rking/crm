<?php
require_once("../../model/connection.php");
require_once("../../model/User.class.php");
require_once("../../model/comptabilite.class.php");
    $comptabilite = new Comptabilite();

$user = new User();

//$idUser = preg_split("#[-]+#", $_GET['idUser']);

if ($user->updateDashboardToProfil($_GET['profil_id'],$_GET['dashboard'])) 
{
	//require_once('rep.php');
	if ($comptabilite->setHistoriqueAction($_GET['profil_id'],'dashboard',$_GET['userName'],date('Y-m-d'),'modifier'))
	{
	
	echo "ok";
}
}
?>

