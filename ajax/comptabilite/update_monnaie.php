<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");  

	$comptabilite = new Comptabilite();

	
	if ($comptabilite->update_monnaie(strtoupper($_GET['monnaie']),$_GET['id']))  
	{
	}
?>
