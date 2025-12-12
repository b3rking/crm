<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

	$comptabilite = new Comptabilite();
    $historique = new Historique();

    date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");
    //$started_at = date('H:i:s');
	if ($comptabilite->deleteExtrat($_GET['id_extrat'])) 
	{
		/*if ($_GET['destination'] == 'caisse') 
		{
			if ($comptabilite->reduireMontantCaisse($_GET['idDestination'],$_GET['montant']) > 0) 
			{
				//echo "ok";
			}
		}
		else
		{
			if ($comptabilite->reduireMontantEnBanque($_GET['idDestination'],$_GET['montant']) >0) 
			{
				//echo "ok";
			}
		}*/
		if ($comptabilite->reduireMontantEnBanque($_GET['idDestination'],$_GET['montant']) > 0) 
		{
			if ($historique->setHistoriqueAction($_GET['id_extrat'],'extrat',$_GET['iduser'],$created_at,'supprimer')) 
			{
			}
		}
	}