<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");  

	$comptabilite = new Comptabilite();

	
	if ($comptabilite->delete_monnaie($_GET['id']))  
	{
	}
?>
