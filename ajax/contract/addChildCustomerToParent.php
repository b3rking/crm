<?php
	require_once("../../model/connection.php");
	//require_once("../../model/contract.class.php");
	require_once("../../model/client.class.php");
	//require_once("../../model/service.class.php");
	//require_once("../../model/User.class.php");
	//require_once("../../model/historique.class.php");  

	//$historique = new Historique();
	$client = new Client();

	if ($client->setCustomerParent($_GET['parent_customer'],$_GET['children_customers']) > 0) 
	{
		# code...
	}