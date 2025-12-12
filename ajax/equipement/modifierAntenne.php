<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/historique.class.php");


	$equipement = new Equipement();
	$historique = new Historique();


	if ($equipement->updateAntenne($_GET['id'],$_GET['model'],$_GET['mac'],$_GET['date_stock'],$_GET['description'])) 
	{
		if ($equipement->updateMAC($_GET['id'],$_GET['mac']) > 0) 
		{
			# code...
		}
		/*if ($historique->setHistoriqueAction($_GET['numequipement'],'equipement',$_GET['userName'],date('Y-m-d'),'modifier')) 
        {
        	//require_once('repAntenne.php');
        }*/
    }
		