<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/historique.class.php");


	$equipement = new Equipement();
	$historique = new Historique();

	if ($equipement->deleteEquipement($_GET['id'])) 
	{
		/*foreach ($equipement->recupereMacAdresses($_GET['id']) as $value) 
        {
            if ($equipement->deleteMacAdresse($value->ID_equipement)) 
            {
            }
            if ($equipement->setHistoriqueMacAdresse($value->ID_equipement,$value->mac)) 
            {
                # code...
            }
        }*/
		/*if ($equipement->deleteMacAdresse($_GET['id'])) 
		{
			require_once('repRouteur.php');
		}*/
		if ($historique->setHistoriqueAction($_GET['id'],'equipement',$_GET['iduser'],date('Y-m-d'),'supprimer')) 
        {
        	//require_once('repRouteur.php');
        }
    }