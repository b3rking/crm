<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/historique.class.php");  

	$historique = new Historique();
	$equipement = new Equipement();
    
	if ($equipement->suppression_accessoire($_GET['idaccessoire'])) 
	{
        /*if (historique->setHistoriqueAction($_GET['idaccessoire'],'accessoire',$_GET['iduser'],date('Y-m-d'),'supprimer')) 
		{
			//require_once('reponseAccessoire.php');
		}*/
    }