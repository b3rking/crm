 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	require_once("../../model/comptabilite.class.php");  

	$comptabilite = new Comptabilite();
	$equipement = new Equipement();

	//print_r($_GET['idaccessoire'].'-'.$_GET['categorie'].'-'.$_GET['quantitesortie'].'-'.$_GET['motif'].'-'.$_GET['date_sortie'].'-'.$_GET['userName'].'-'.$_GET['demandeur']); die();
	//$mouvement ='sortie';
 
	/*if ($equipement->sortie_des_accessoire_en_stock($_GET['idaccessoire'],$_GET['categorie'],$_GET['quantitesortie'],$_GET['motif'],$_GET['date_sortie'],$_GET['userName'],$_GET['demandeur']))
	{
		   if ($equipement->diminuer_QteAccessoire_stock($_GET['idaccessoire'],$_GET['quantitesortie'])) 
				{
					
				}
	}*/



	/*if ($equipement->sortie_des_accessoire_en_stock($_GET['idaccessoire'],$_GET['quantitesortie'],$_GET['motif'],$_GET['date_sortie'],$_GET['sortie_par'],$_GET['demander_par'],$_GET['destination'],$_GET['destination_detail']))
	{
		$idSortie = $equipement->getMaxIdSortieAccessoireEnStock()->fetch()['ID_sortie_accessoire'];
	    if ($equipement->diminuer_QteAccessoire_stock($_GET['idaccessoire'],$_GET['quantitesortie'])) 
		{
			if($equipement->SetHisto_accessoire($_GET['idaccessoire'],$_GET['quantitesortie'],$_GET['motif'],$_GET['date_sortie'],null,$_GET['sortie_par'],$idSortie,'sortie'))
			{}
		}
	}*/
    $destination_detail = $_GET['destination'] == 'autre' ? null : $_GET['destination_detail'];
    
    if ($equipement->sortie_des_accessoire_en_stock($_GET['categorie_id'],$_GET['motif'],$_GET['quantitesortie'],$_GET['date_sortie'],$_GET['sortie_par'],$_GET['demander_par'],$_GET['destination'],$destination_detail,'sortie',$_GET['iduser']))
	{
	}
