<?php
require_once("../../model/connection.php");
require_once("../../model/marketing.class.php");

$marketing = new Marketing();
$dateRendezvous = $_GET['rdv'] == ''? null : $_GET['rdv'];
if ($marketing->ajouterprospect(strtoupper($_GET['prospect']),strtoupper($_GET['adresprospect']),$_GET['portable'],$_GET['mailP'],$_GET['genre'],$dateRendezvous,$_GET['jourEnreg'],$_GET['prospect_comment'],$_GET['marketeur_comment'],'attente',$_GET['iduser'])) 
{
	$idprospect = $marketing->getMaxIdProspect();
	if ($marketing->visiteProspect($idprospect,$_GET['marketeur_comment'],$_GET['prospect_comment'],$dateRendezvous,$_GET['jourEnreg'])) 
	{
	}
}

