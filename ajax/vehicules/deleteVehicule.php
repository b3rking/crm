
<?php
require_once("../../model/connection.php");
require_once("../../model/vehicule.class.php");
require_once("../../model/comptabilite.class.php");

$vehicule = new Vehicule();
$comptabilite = new Comptabilite();
//$idclient = preg_split("#[-]+#", $_GET['client']);

if ($vehicule->deleteVehicule($_GET['plaque']) >0) 
{
	if ($comptabilite->setHistoriqueAction($_GET['plaque'],'vehicule',$_GET['suprimeur'],date('Y-m-d'),'supprimer')) 
	{
		require_once('repVehicule.php');
	}
}