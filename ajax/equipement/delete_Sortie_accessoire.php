 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/comptabilite.class.php");  

	$comptabilite = new Comptabilite();
	$equipement = new Equipement();


	/*if ($equipement->deleteSortie_accessoire($_GET['idSortie']))
	{
	    if ($equipement->AugmenterQuantiteAccesoir($_GET['idaccessoire'],$_GET['quantite'])) 
		{
			
		}
	}*/
    if ($equipement->deleteSortie_accessoire($_GET['idSortie']))
	{
	}
	//idSortie="+idSortie+"&idaccessoire="+idaccessoire+"&quantite="+quantite+"&userName="+userName
