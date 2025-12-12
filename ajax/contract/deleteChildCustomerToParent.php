<?php
	require_once("../../model/connection.php");
	//require_once("../../model/contract.class.php");
	require_once("../../model/client.class.php");
	//require_once("../../model/service.class.php");
	//require_once("../../model/User.class.php");
	//require_once("../../model/historique.class.php");  

	//$historique = new Historique();
	$client = new Client();

	if ($client->deleteChildCustomerToParent($_GET['child_id']) > 0) 
	{
		# code...
	}