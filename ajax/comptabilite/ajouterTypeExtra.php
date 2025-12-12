<?php
require_once("../../model/connection.php"); 
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();


if ($comptabilite->ajouterTypeExtra($_GET['type'])) 
{	
	require_once('reponse_type_extrat.php'); 
}