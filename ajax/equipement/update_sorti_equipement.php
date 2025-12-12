   
<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	//require_once("../../model/comptabilite.class.php");  

	$equipement = new Equipement();

	//$mouvement ='sortie';


	//if($equipement->SetHisto_accessoire($_GET['categorie'],$_GET['quantitesortie'],$_GET['motif'],$_GET['date_sortie'],$_GET['sortie_par'],$mouvement))
	//{


        $destination_detail = $_GET['destination'] == 'autre' ? null : $_GET['destination_detail'];
		if ($equipement->updateDestinationDetailAndStatusToSortieEquipement($_GET['idSortie'],$_GET['idequipement'],$_GET['motif'],$_GET['date_sortie'],$_GET['sortie_par'],$_GET['demander_par'],$_GET['destination'],$destination_detail,$_GET['status']) > 0)
		{
		    if ($equipement->updateEquipementUsed($_GET['idequipement'],$_GET['used']) > 0) 
			{
				
			}
		}
	//}

