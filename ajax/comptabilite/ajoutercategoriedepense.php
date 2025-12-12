<?php
require_once("../../model/connection.php"); 
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

if ($comptabilite->setCategieDepense($_GET['categoriedepense'],$_GET['type_categorie'])) 
{	
	require_once('reponse_categoriedepense.php'); 
}