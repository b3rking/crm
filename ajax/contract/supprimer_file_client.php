
<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");


	$contract = new Contract();
    if ($contract->supprimer_file($_GET['del_file'])) 
	{
		require_once('repfichier.php');
	}
?>