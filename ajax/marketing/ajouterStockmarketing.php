<?php
require_once("../../model/connection.php");
require_once("../../model/marketing.class.php");

$marketing = new Marketing();


if ($marketing->ajouterstockmarketing($_GET['materiel'],$_GET['quantite'])>0) 

{
	require_once('repstockmarketing.php');
}

?>


