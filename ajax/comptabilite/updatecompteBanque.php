<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

$comptabilite = new Comptabilite();
$historique = new Historique();

$oldMontantInitial = $_GET['oldMontantInitial'];
$newMotantInitial = $_GET['montantinitial'];
$montantinitial = $newMotantInitial - $oldMontantInitial;

if ($comptabilite->update_compteBancaire($_GET['idbank'],$_GET['nombanque'],$_GET['numerocompte'],$montantinitial,$_GET['monnaie'],$_GET['statut'],$_GET['show_on_invoice']))  

{
	if ($historique->setHistoriqueAction($_GET['idbank'],'banque',$_GET['iduser'],date('Y-m-d'),'modifier')) 
	{
		//require_once('repbanque.php');
	}
}
