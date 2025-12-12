 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	//require_once("../../model/comptabilite.class.php");  

	$equipement = new Equipement();

	if ($_GET['destination'] == 'client') 
	{
		if($equipement->attribuer_equipement_client($_GET['destination_detail'],$_GET['idequipement'],$_GET['date_sortie'],$_GET['sortie_par']))
	    {
	        if ($equipement->updateStatusToSortieEquipement($_GET['idsortie'],1) > 0) 
			{
				# code...
			}
            if ($equipement->updateEquipementUsed($_GET['idequipement'],$used = 'oui') > 0) 
			{
				
			}
	    }
	}
	else
	{
		if ($equipement->updateStatusToSortieEquipement($_GET['idsortie'],1) > 0) 
		{
			# code...
		}
        if ($equipement->updateEquipementUsed($_GET['idequipement'],$used = 'oui') > 0) 
        {

        }
	}
	
	/*if ($equipement->sortier_equipement_en_stock($_GET['idequipement'],$_GET['motif'],$_GET['date_sortie'],$_GET['sortie_par'],$_GET['demander_par'],$_GET['destination'],$_GET['destination_detail']))
	{
	    if ($equipement->updateEquipementUsed($_GET['idequipement'],$used = 'oui') > 0) 
		{
			
		}
	}*/

