<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php"); 

$historique = new Historique();
$equipement = new Equipement();

if($equipement->supprimer_point_acces($_GET['nupa']) > 0) 
{
    if ($historique->setHistoriqueAction($_GET['nupa'],'pointAcces',$_GET['iduser'],date('Y-m-d'),'supprimer')) 
	{
		require_once("reponsePointAcces.php");
	}
}

?>