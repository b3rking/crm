<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/comptabilite.class.php");  

	$comptabilite = new Comptabilite();
	$equipement = new Equipement();


	if ($equipement->AugmenterQuantiteAccesoir($_GET['idaccessoire'],$_GET['quantite']) > 0) 

	{	if ($equipement->DiminuerQte_sotie($_GET['id_sortie'],$_GET['quantite'])) 
		{
		
			if($equipement->modifier_sortie_stock($_GET['id_sortie']/*,$_GET['quantite']*/,$_GET['date_sortie'],$_GET['motif']))
			{
		        if ($comptabilite->setHistoriqueAction($_GET['idaccessoire'],'accessoire',$_GET['userName'],date('Y-m-d'),'modifier')) 
				{
					require_once('rep_sorti_stock.php');
				}
			}
    }	}
		