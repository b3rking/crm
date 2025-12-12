<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

if ($comptabilite->creationCompteComptable($_GET['code'],$_GET['nomcompte'],$_GET['lignecredit'],$_GET['monnaie'],$_GET['datecompte'],$_GET['note'],$_GET['utilisateur']))  
{
	if ($comptabilite->setHistoriqueAction($_GET['code'],'compte',$_GET['userName'],date('Y-m-d'),'creer')) 
	{
		require_once('repcompteComptable.php');
	}
}

?>