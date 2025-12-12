
<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");
require_once("../../model/service.class.php");
require_once("../../model/User.class.php");


	$contract = new Contract();

    if ($contract->creerfichier_client($_GET['idclientOnContract'],$_GET['nom'],$_GET['fichier'],$_GET['userfile'],$_GET['datecreation'])) 
	{
		require_once('repfichier.php');
	}
?>