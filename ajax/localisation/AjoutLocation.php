<?php
require_once("../../model/connection.php");
require_once("../../model/localisation.class.php");
require_once("../../model/comptabilite.class.php");
$localisation = new Localisation();
$comptabilite = new Comptabilite();


if ($localisation->NouvelleLocalisation($_GET['locationS'])) 

{
	$idAction = $localisation->getLastLocalisation()->fetch()['ID_localisation'];
	if ($comptabilite->setHistoriqueAction($idAction,'localisation',$_GET['name_user'],date('Y-m-d'),'creer')) 
	{
		require_once('repLocalisation.php');
    }
}
?>
