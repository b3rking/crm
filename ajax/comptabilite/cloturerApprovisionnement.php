<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");  

	$comptabilite = new Comptabilite();

	//date_default_timezone_set("Africa/Bujumbura");
    //$date_appro = date("Y-m-d");

	if ($comptabilite->cloturerAprovisionnement($_GET['iduser']) > 0) 
	{
		//echo "Vous venez de cloturer le versement du ".$_GET['datepaiement'];
	}