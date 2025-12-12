<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();
$res = 0;
foreach ($contract->verifiersiunclientAdejaUneFacture($_POST['result']/*,$mois_debut,$annee_debut*/) as $value) 
{
	$res= $value->mois.'_'.$value->annee;
}
echo $res;