<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

if ($comptabilite->supprimeCategorie($_GET['numcategorie']))  
{
	//echo "ok";
	require_once('reponse_categoriedepense.php'); 
}


?>