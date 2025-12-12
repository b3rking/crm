<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");

$WEBROOT = $_GET['WEBROOT'];
$equipement = new Equipement();
if ($equipement->deleteStockCarburant($_GET['num_stock']) > 0) 
{
    require_once('reponsestock_carburant.php');
}