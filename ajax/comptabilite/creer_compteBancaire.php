<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

$comptabilite = new Comptabilite();
$historique = new Historique();

if ($comptabilite->creer_compteBancaire($_GET['nombanque'],$_GET['numerocompte'],$_GET['montantinitial'],$_GET['monnaie'],$_GET['statut'],$_GET['affichefacture'],$_GET['datecreation']))  
{
	$id = $comptabilite->getMaxIdBanque()->fetch()['ID_banque'];
	if ($historique->setHistoriqueAction($id,'banque',$_GET['iduser'],date('Y-m-d'),'creer')) 
	{
		//require_once('repbanque.php');
	}
}

