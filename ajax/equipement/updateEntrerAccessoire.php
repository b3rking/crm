<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php");  

$historique = new Historique();
$equipement = new Equipement();


if ($equipement->updateEntrerAccessoire($_GET['categorie_id'],$_GET['quantite'],$_GET['commentaire'],$_GET['date_entre'],'entree',$_GET['id']) > 0)
{
	/*$id = $equipement->getMaxIdAccessoire()->fetch()['accessory_journal_id'];
	if ($historique->setHistoriqueAction($id,'accessoire',$_GET['iduser'],date('Y-m-d'),'creer')) 
	{
		//require_once('reponseAccessoire.php');
	}*/
}
