<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
//require_once("../../model/contract.class.php");
//require_once("../../model/client.class.php"); 

$comptabilite = new Comptabilite();

if ($comptabilite->closeExtrat($_GET['iduser']) > 0) 
{
	// code...
}