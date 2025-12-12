
<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

$comptabilite = new Comptabilite();
$historique = new Historique();

if ($comptabilite->supprimercompteBanque($_GET['clebank']) > 0) 
{
	if ($historique->setHistoriqueAction($_GET['clebank'],'banque',$_GET['iduser'],date('Y-m-d'),'supprimer')) 
	{
		//require_once('repbanque.php');
	}
} 		
