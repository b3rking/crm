<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/comptabilite.class.php");


	$equipement = new Equipement();
	$comptabilite = new Comptabilite();

	if ($equipement->updateswitch($_GET['id'],$_GET['model'],$_GET['fabriquant'],$_GET['date_stock']) > 0) 
	{
		/*if ($equipement->updateMAC_Switch($_GET['id'],$_GET['mac']))
	    {
			if ($comptabilite->setHistoriqueAction($_GET['id'],'equipement',$_GET['userName'],date('Y-m-d'),'modifier')) 
	        {
	        	//require_once('reponseSwitch.php');
	        }
		}*/
		if ($comptabilite->setHistoriqueAction($_GET['id'],'equipement',$_GET['userName'],date('Y-m-d'),'modifier')) 
        {
        	//require_once('reponseSwitch.php');
        }
    }
		
