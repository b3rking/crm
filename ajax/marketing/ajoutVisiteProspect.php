<?php
require_once("../../model/connection.php");
require_once("../../model/marketing.class.php");

$marketing = new Marketing();

if ($marketing->visiteProspect($_GET['idprospects'],$_GET['propositionmarketeur'],$_GET['propositionprospect'],$_GET['daterdv'],$_GET['datedujour'])) 
{
	//require_once('rep.php');
}

