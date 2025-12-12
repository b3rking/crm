<?php
require_once("../../model/connection.php");
require_once("../../model/service.class.php");
require_once("../../model/contract.class.php");
require_once("../../model/comptabilite.class.php");

// $_SESSION['userName'];
$service = new Service();
$contract = new Contract();
$comptabilite = new Comptabilite();

$res = $contract->recupererContractLierAunService($_GET['idservice']);
if ($service->deleteService($_GET['idservice'])) 
{
	   foreach ($res as $value) 
	  {
		$contract->deleteContract($value->ID_contract);
         
      }
      if ($comptabilite->setHistoriqueAction($_GET['idservice'],'service',$_GET['userName'],date('Y-m-d'),'supprimer')) 
         {
	     }
	require_once 'rep.php';
}
else echo "Insertion echoue";
?>