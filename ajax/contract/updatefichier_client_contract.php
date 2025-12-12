
<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");


	$contract = new Contract();
    if ($contract->updatefichierClient($_GET['numerofichier'],$_GET['nom_fichier'],$_GET['fichier_doc'])) 
	{
		require_once('repfichier.php');
	}
?>