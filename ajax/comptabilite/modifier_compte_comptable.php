<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();
if ($comptabilite->update_compteComptable($_GET['code'],$_GET['idcompte'],$_GET['nomcompte'],$_GET['lignecredit'],$_GET['monnaie'],$_GET['datecompte'],$_GET['montantcompte'],$_GET['commentaire'])> 0) 
{
	if ($comptabilite->setHistoriqueAction($_GET['idcompte'],'compte',$_GET['userName'],date('Y-m-d'),'modifier')) 
	{
		require_once('repcompteComptable.php');
	}
}
