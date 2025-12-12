
<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");


	$equipement = new Equipement();

    if ($equipement->diminuer_QteAccessoire_stock($_GET['accessoire'],$_GET['quantite'])) 
	{
		if ($equipement->attribuer_accessoire($_GET['idclient'],$_GET['accessoire'],$_GET['date_attribution'],$_GET['user'],$_GET['quantite'],$_GET['motif']))
		{
			echo "L'attribution reussie";
		}
	}
?>