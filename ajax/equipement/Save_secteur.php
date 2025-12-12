<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php");  

$historique = new Historique();
$equipement = new Equipement();


if ($equipement->NewSecteur($_GET['Code_secteur'],strtoupper($_GET['nom_secteur']),$_GET['adrese_secteur'],$_GET['switch_ip'])) 
{
	$id_secteur = $equipement->getMaxIdSecteur()->fetch()['ID_secteur'];
	if ($historique->setHistoriqueAction($id_secteur,'secteur',$_GET['iduser'],date('Y-m-d'),'creer')) 
	{
		//require_once('repSecteur.php');
	}
}
?>