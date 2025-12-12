<?php
require_once("../../model/connection.php");
require_once("../../model/vehicule.class.php");
require_once("../../model/comptabilite.class.php");

$vehicule = new Vehicule();
$comptabilite = new Comptabilite();
//$idclient = preg_split("#[-]+#", $_GET['client']);

if ($vehicule->ajouterVehicule($_GET['plaque'],$_GET['modele'],$_GET['marque'])) 
{
	if ($comptabilite->setHistoriqueAction($_GET['plaque'],'vehicule',$_GET['nom_user'],date('Y-m-d'),'creer')) 
	{
		require_once('repVehicule.php');
	}
}

