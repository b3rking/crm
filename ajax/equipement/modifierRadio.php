
<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/comptabilite.class.php");


	$equipement = new Equipement();
	$comptabilite = new Comptabilite();

	if ($equipement->updateRadio($_GET['id'],$_GET['date_stock'],$_GET['model'],$_GET['fabriquant']) > 0) 
	{
		/*if ($equipement->updateMAC_Radio($_GET['id'],$_GET['mac']))
	    {
			if ($comptabilite->setHistoriqueAction($_GET['id'],'equipement',$_GET['userName'],date('Y-m-d'),'modifier')) 
	        {
	            //require_once('repRadio.php');
	        }
		}*/
		if ($comptabilite->setHistoriqueAction($_GET['id'],'equipement',$_GET['userName'],date('Y-m-d'),'modifier')) 
        {
            //require_once('repRadio.php');
        }
    }
