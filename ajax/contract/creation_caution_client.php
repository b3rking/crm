<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");


$contract = new Contract(); 

if ($contract->saveCautionClient($_GET['idclientCaution'],$_GET['montant_caution'],$_GET['monnaie_caution'],$_GET['date_caution'],$_GET['user_creer_caution'],$_GET['note']) >0) 
{
	echo "insertion reussie";
}



?>




