<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php");  

$historique = new Historique();

$equipement = new Equipement();

if($equipement->update_Secteur($_GET['id_secteur'],$_GET['code'],strtoupper($_GET['nom_secteur']),$_GET['adrese_secteur'],$_GET['switch_ip']) > 0) 
{
    if ($historique->setHistoriqueAction($_GET['id_secteur'],'secteur',$_GET['iduser'],date('Y-m-d'),'modifier')) 
	{
		//require_once('repSecteur.php');
	}
}
?>