<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

if ($comptabilite->supprime_tpe_extrat($_GET['num_extrat']))  
{
	
	require_once('reponse_type_extrat.php'); 
}


?>