
<?php
require_once("../../model/connection.php");
require_once("../../model/marketing.class.php");

$marketing = new Marketing();


if ($marketing->ajoutersponsor($_GET['demande'],$_GET['nature'],$_GET['adrsponsor'],$_GET['phonesponsor'],$_GET['visibilite'],$_GET['datedebut'],$_GET['datefin'])) 
{
	require_once('repSponsor.php');
}
?>
