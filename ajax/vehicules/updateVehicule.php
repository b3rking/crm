
<?php
require_once("../../model/connection.php");
require_once("../../model/vehicule.class.php");
require_once("../../model/comptabilite.class.php");

$vehicule = new Vehicule();
$comptabilite = new Comptabilite();
//$idclient = preg_split("#[-]+#", $_GET['client']);

if ($vehicule->UpdateVehicule($_GET['newplaque'],$_GET['plaque'],$_GET['modele'],$_GET['marque']) >0) 
{
	if ($comptabilite->setHistoriqueAction($_GET['plaque'],'vehicule',$_GET['nom_user'],date('Y-m-d'),'modifier')) 
	{
		require_once('repVehicule.php');
	}
}


		
