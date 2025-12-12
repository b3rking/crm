<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/comptabilite.class.php");


	$equipement = new Equipement();
	$comptabilite = new Comptabilite();
		
	if ($equipement->updateRouteur($_GET['id'],$_GET['model'],$_GET['fabriquant'],$_GET['date_stock']) > 0) 
	{
		/*if ($equipement->updateMAC($_GET['id'],$_GET['mac']))
	    {
			if ($comptabilite->setHistoriqueAction($_GET['id'],'equipement',$_GET['userName'],date('Y-m-d'),'modifier')) 
	        {
	        	//require_once('repRouteur.php');
	        }
		}*/
		if ($comptabilite->setHistoriqueAction($_GET['id'],'equipement',$_GET['userName'],date('Y-m-d'),'modifier')) 
        {
        	//require_once('repRouteur.php');
        }
    }
		