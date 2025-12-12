<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

$comptabilite = new Comptabilite();
$historique = new Historique();

if ($_GET['oldType'] == 'cd' && $_GET['type'] == 'cr' && count($comptabilite->getCaisseRecetteByMonnaie($_GET['monnaie'])) > 0) 
{
	echo "Vous ne pouvez pas creer deux caisses recettes en ".$_GET['monnaie'];
}
else
{
	if ($comptabilite->updateCaisse($_GET['idcaisse'],$_GET['nomcaisse'],$_GET['monnaie'],$_GET['statut'],$_GET['responsable'],$_GET['datecreation'],$_GET['type'],$_GET['description'],$_GET['iduser'])) 
	{
		if ($historique->setHistoriqueAction($_GET['idcaisse'],'caisse',$_GET['iduser'],date('Y-m-d'),'modifier')) 
		{
			//require_once('repCaisse.php');
		}
	}
}