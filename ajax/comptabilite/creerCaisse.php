<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

$comptabilite = new Comptabilite();
$historique = new Historique();

/*if ($_GET['dimmension'] == 'grande') 
{
	if (count($comptabilite->getGrandeCaisseByMonnaie($_GET['monnaie']))) 
	{
		echo "Vouz ne pouvez pas creer 2 grande caisses en ".$_GET['monnaie'];
	}
	else
	{
		if ($comptabilite->creerCaisse($_GET['nomcaisse'],$_GET['lignecredit'],$_GET['monnaie'],$_GET['statut'],$_GET['responsable'],$_GET['datecreation'],$_GET['idusers'],$_GET['dimmension'],$_GET['description']))  
		{
			$id = $comptabilite->getMaxIdCaisse()->fetch()['ID_caisse'];
			if ($comptabilite->setHistoriqueAction($id,'caisse',$_GET['userName'],date('Y-m-d'),'creer')) 
			{
				//require_once('repCaisse.php');
			} 
		}
	}
}*/
//else
//{
	/*if ($_GET['type'] == 'cr' && count($comptabilite->getCaisseRecetteByMonnaie($_GET['monnaie'])) > 0) 
	{
		echo "Vous ne pouvez pas creer deux caisses recettes en ".$_GET['monnaie'];
	}
	else
	{*/
		if ($comptabilite->creerCaisse($_GET['nomcaisse'],$_GET['monnaie'],$_GET['statut'],$_GET['responsable'],$_GET['datecreation'],$_GET['iduser'],$_GET['type'],$_GET['description']))  
		{
			$id = $comptabilite->getMaxIdCaisse()->fetch()['ID_caisse'];
			if ($historique->setHistoriqueAction($id,'caisse',$_GET['iduser'],date('Y-m-d'),'creer')) 
			{
				//require_once('repCaisse.php');
			} 
		}
	//}
//}

