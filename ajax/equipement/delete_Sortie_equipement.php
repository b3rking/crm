 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/comptabilite.class.php");  

	$comptabilite = new Comptabilite();
	$equipement = new Equipement();


	if ($equipement->deleteSortie_equipement($_GET['idSortie']))
	{
	    if ($equipement->updateEquipementUsed($_GET['idequipement'],$used = 'non') > 0) 
		{
			
		}
	}
