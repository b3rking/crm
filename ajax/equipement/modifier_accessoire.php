<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/comptabilite.class.php");  
	require_once("../../model/historique.class.php");  

$historique = new Historique();

	$comptabilite = new Comptabilite();
	$equipement = new Equipement();
    //idSortie,destination,demander_par,accessoire,quantite,date_sortie,motif,userName,destination_detail

	if ($equipement->updateEntrerAccessoire($_GET['categorie_id'],$_GET['quantite'],$_GET['motif'],$_GET['date_sortie'],$_GET['mouvement'],$_GET['idSortie']) > 0)
{
	/*$id = $equipement->getMaxIdAccessoire()->fetch()['accessory_journal_id'];
	if ($historique->setHistoriqueAction($id,'accessoire',$_GET['iduser'],date('Y-m-d'),'creer')) 
	{
		//require_once('reponseAccessoire.php');
	}*/
}



