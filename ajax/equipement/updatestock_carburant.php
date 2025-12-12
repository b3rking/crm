
<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");

$WEBROOT = $_GET['WEBROOT'];
$equipement = new Equipement();
if ($equipement->modifier_stock_carburant($_GET['refstock'],$_GET['refnature'],$_GET['refnblitre'],$_GET['refprix_achat'],$_GET['refdatesachat'])) 

{
    require_once('reponsestock_carburant.php');
}