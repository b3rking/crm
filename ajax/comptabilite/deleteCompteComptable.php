
<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

if ($comptabilite->deleteCompteComptable($_GET['idcompte'])) 
{
	if ($comptabilite->setHistoriqueAction($_GET['idcompte'],'compte',$_GET['userName'],date('Y-m-d'),'supprimer')) 
	{
		require_once('repcompteComptable.php');
	}
} 		
