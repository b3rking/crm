<?php
require_once('model/equipement.class.php');
require_once("model/User.class.php");
require_once("model/client.class.php");
require_once("model/vehicule.class.php");

function inc_point_acces()
{
	$user = new User();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/point_acces.php');
}
function inc_secteur()
{
	$user = new User();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/secteur.php');
}
function switchs()
{
	$user = new User();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/switch.php'); 
}
function trace_materiels()
{
	require_once('ajax/Equipement.ajax/TraceMateriels.php');
}
function inc_routeur()
{
	$user = new User();
	$equipement = new Equipement();
    $models = $equipement->getModels();
	require_once('vue/admin/equipement/routeur.php');
}
function rapport_routeur($marque,$date1,$date2,$mois,$annee)
{
    $mois_etiquete = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
    $marque_condition = "";
    $date_condition_entree = "";
    $date_condition_sortie = "";
    $condition_entree  = "";
    $condition_sortie = "";

    $marque_condition = $marque == '' ? '' : " AND equipement.marque = '".$marque."'";
    
    if($date1 !== '')
    {
        $dateAvantFiltre = $date1;
        $date_condition_entree = " AND date_stock = '".$date1."'";
        $date_condition_sortie = " AND date_sortie = '".$date1."'";
        $periode = 'Période du '.$date1;
    }
    //$condition3 = ($date2 == "") ? "" : " AND operation_date='".$date2."' ";
    $annee = ($date1 !== "" || $date2 !== "") ? "" : $annee;
    
    if($date2 !== '')
    {
        if ($date1 != '') 
        {
            $date_condition_entree = " AND date_stock BETWEEN '".$date1."' AND '".$date2."' ";
            $date_condition_sortie = " AND date_sortie BETWEEN '".$date1."' AND '".$date2."' ";
            $periode = 'Période du '.$date1.' au '.$date2;
        }
        else
        {
            $dateAvantFiltre = $date2;
            $date_condition_entree = " AND date_stock = '".$date2."' ";
            $date_condition_sortie = " AND date_sortie = '".$date2."' ";
            $periode = 'Période du '.$date2;
        } 
    }
    if ($mois !== '' AND $annee !== '') 
    {
        $periode = 'Mois de '.$mois_etiquete[$mois].' '.$annee;
        $mois = $mois < 10 ? '0'.$mois : $mois;
        $dateAvantFiltre = $annee."-".$mois."-01";
        $date_condition_entree = " AND DATE_FORMAT(date_stock, '%Y-%m') = '".$annee."-".$mois."' ";
        $date_condition_sortie = " AND DATE_FORMAT(date_sortie, '%Y-%m') = '".$annee."-".$mois."' ";
    }
    $condition_entree = $marque_condition.$date_condition_entree;
    $condition_sortie = $marque_condition.$date_condition_sortie;
    $equipement = new Equipement();
    $client = new Client();
    $vehicule = new Vehicule();
    $equipements = $equipement->rapport_routeur($condition_entree,$condition_sortie);
    $nbEq = $equipement->getNbRouteurByMarqueBeforeAdate($marque,$dateAvantFiltre);
    $nbOut = $equipement->getNbOutRouteurByMarqueBeforeAdate($marque,$dateAvantFiltre);

    require_once('printing/fiches/routeur_rapport.php');
}
function inc_antenne()
{
	$equipement = new Equipement();
	$user = new User();
    $models = $equipement->getModels();
	require_once('vue/admin/equipement/antenne.php');
}
function rapport_antenne($marque,$date1,$date2,$mois,$annee)
{
	$mois_etiquete = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
    $date_condition_entree = "";
    $date_condition_sortie = "";
    $condition_entree  = "";
    $condition_sortie = "";

    $marque_condition = $marque == '' ? '' : " AND equipement.marque = '".$marque."'";
	
    if($date1 !== '')
    {
    	$dateAvantFiltre = $date1;
    	$date_condition_entree = " AND date_stock = '".$date1."'";
    	$date_condition_sortie = " AND date_sortie = '".$date1."'";
    	$periode = 'Période du '.$date1;
    }
    //$condition3 = ($date2 == "") ? "" : " AND operation_date='".$date2."' ";
    $annee = ($date1 !== "" || $date2 !== "") ? "" : $annee;
    
    if($date2 !== '')
    {
        if ($date1 != '') 
        {
            $date_condition_entree = " AND date_stock BETWEEN '".$date1."' AND '".$date2."' ";
    		$date_condition_sortie = " AND date_sortie BETWEEN '".$date1."' AND '".$date2."' ";
            $periode = 'Période du '.$date1.' au '.$date2;
        }
        else
        {
        	$dateAvantFiltre = $date2;
        	$date_condition_entree = " AND date_stock = '".$date2."' ";
    		$date_condition_sortie = " AND date_sortie = '".$date2."' ";
        	$periode = 'Période du '.$date2;
        } 
    }
    if ($mois !== '' AND $annee !== '') 
    {
        $periode = 'Mois de '.$mois_etiquete[$mois].' '.$annee;
        $mois = $mois < 10 ? '0'.$mois : $mois;
    	$dateAvantFiltre = $annee."-".$mois."-01";
    	$date_condition_entree = " AND DATE_FORMAT(date_stock, '%Y-%m') = '".$annee."-".$mois."' ";
		$date_condition_sortie = " AND DATE_FORMAT(date_sortie, '%Y-%m') = '".$annee."-".$mois."' ";
    }
    $condition_entree = $marque_condition.$date_condition_entree;
    $condition_sortie = $marque_condition.$date_condition_sortie;
    $equipement = new Equipement();
    $client = new Client();
    $vehicule = new Vehicule();
    $equipements = $equipement->rapport_antenne($condition_entree,$condition_sortie);
    $nbEq = $equipement->getNbAntenneByMarqueBeforeAdate($marque,$dateAvantFiltre);
    $nbOut = $equipement->getNbOutAntenneByMarqueBeforeAdate($marque,$dateAvantFiltre);

    require_once('printing/fiches/antenne_rapport.php');
}
function inc_adresse_mac()
{
	$user = new User();
	require_once('vue/admin/equipement/adresse_mac.php');
}
function creerstock()
{
	$user = new User();
	require_once('vue/admin/equipement/creerstock.php');
}
function voirstock()
{
	$equipement = new Equipement();
	$user = new User();
	require_once('vue/admin/equipement/voirStock.php');
}
function technique()
{
	$user = new User();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/dashbordEquipement.php');
}
function inc_radio()
{
	$user = new User();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/radio.php');
}
function inc_categorieAccessoire()
{
	$user = new User();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/categorieAccessoire.php');
}
function in_accessoire()
{
	$user = new User();
	$equipement = new Equipement();
    $result = $equipement->afficheAccessoires();
    
    $categorie_id = "";
    $date1 = "";
	$date2 = "";
	$mois = "";
	$annee = date('Y');
	require_once('vue/admin/equipement/accessoire.php');
}
function filtreAccessoire($categorie_id,$date1,$date2,$mois,$annee,$print)
{
	$user = new User();
	$equipement = new Equipement();
	$client = new Client();
    $vehicule = new Vehicule();

	$condition1 = ""; 
    $condition2 = "";
    $condition3 = "";
    $condition4 = "";
    $condition5 = "";
    $condition6 = ""; 
    $condition  = "";

    $mois_en_lettre = [1=>'Janvier',2=>'Fevriel',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
    //$dateAvantFiltre = date('Y-m-01');
    //$periode = 'Mois de '.$mois_en_lettre[intval(date('m'))].' '.date('Y');

    $condition1 = $categorie_id == "" ? "" : " AND c.categorie_id=".$categorie_id." ";

    if ($date1 == '') 
    {
    }
    else
    {
    	$dateAvantFiltre = $date1;
    	$condition2 = " AND operation_date='".$date1."' ";
    	$periode = 'Période du '.$date1;
    }
    //$condition3 = ($date2 == "") ? "" : " AND operation_date='".$date2."' ";
    $annee = ($date1 !== "" || $date2 !== "") ? "" : $annee;
    
    if ($date2 == '') 
    {
        $condition3 = '';
    }
    else
    {
        if ($date1 != '') 
        {
            $condition3 = " AND operation_date BETWEEN '".$date1."' AND '".$date2."'";
            $condition2 = '';
            $periode = 'Période du '.$date1.' au '.$date2;
        }
        else
        {
        	$dateAvantFiltre = $date2;
        	$condition3 = " AND operation_date='".$date2."' ";
        	$periode = 'Période du '.$date2;
        } 
    }
    if ($mois == '') 
    {
    }
    else
    {
    	$dateAvantFiltre = $annee."-".$mois."-01";
    	$condition4 = " AND MONTH(operation_date)=".$mois." ";
    	$periode = 'Mois de '.$mois_en_lettre[$mois].' '.$annee;
    }
    
    $condition5 = ($annee == "") ? "" : " AND YEAR(operation_date)=".$annee." ";

    $annee = date('Y');
    
    if ($print == 1) 
    {
    	$condition = $condition2.$condition3.$condition4.$condition5;
    	$result= $equipement->raportAccessoires($condition);
    	/*$result_print = [];
    	foreach ($result as $value) 
    	{
    		$sortie_par = $user->getUserById($value->sortie_par)->fetch()['nom_user'];
    		$demander_par = $user->getUserById($value->demander_par)->fetch()['nom_user'];
	    	if ($value->destination == 'client') 
	        {
	            $destination_detail = $client->afficherUnClentSansContract($value->destination_detail)->fetch()['Nom_client'];
	        }
	        elseif ($value->destination == 'relais') 
	        {
	            $destination_detail = $equipement->getSecteurById($value->destination_detail)->fetch()['nom_secteur'];
	        }
	        elseif ($value->destination == 'base') 
	        {
	            $destination_detail = $equipement->getAccessPointById($value->destination_detail)->fetch()['nom'];
	        }
	        elseif ($value->destination == 'vehicule') 
	        {
	            $vehicule_res = $vehicule->getVehiculeById($value->destination_detail)->fetch();
	            $destination_detail = $vehicule_res['modele']."-".$vehicule_res['marque'];
	        }
	        $result_print[] = ['date_sortie'=>$value->operation_date,'categorie'=>$value->categorie,'quantite'=>$value->out_store,'motif'=>$value->description,'destination'=>ucfirst($value->destination).": ".$destination_detail,'demander_par'=>$demander_par,'sortie_par'=>$sortie_par];
	        
    	}*/
    	require_once("printing/fiches/rapport_entree_sortie_accessoire.php");
    }
    else
    {
    	$condition = $condition1.$condition2.$condition3.$condition4.$condition5;
    	
    	$result= $equipement->filteEntreeAccessoires($condition);
    	require_once('vue/admin/equipement/accessoire.php');
    }
}
function etat_Stock()
{
	$user = new User();
	$equipement = new Equipement();
	require_once('printing/fiches/stockDashbord.php');
}
function inc_sortie_accessoire()
{
	$user = new User();
	$equipement = new Equipement();
    $client = new Client();
    $vehicule = new Vehicule();
    
	$result = $equipement->getSortieAccessoires();

	$demander_par= "";
	$destination = "";
	$date1 = "";
	$date2 = "";
	$mois = "";
	$annee = date('Y');
	require_once('vue/admin/equipement/sortie_accessoire.php');
}
function filtreSortieAccessoire($demander_par,$destination,$date1,$date2,$mois,$annee,$print)
{
	$user = new User();
	$equipement = new Equipement();
	$client = new Client();
    $vehicule = new Vehicule();

	$condition1 = ""; 
    $condition2 = "";
    $condition3 = "";
    $condition4 = "";
    $condition5 = "";
    $condition6 = ""; 
    $condition  = "";

    $condition1 = ($demander_par == "") ? "" : " AND demander_par ='".$demander_par."'";
    $condition2 = ($destination == "") ? "" : " AND destination ='".$destination."'";
    $condition3 = ($date1 == "") ? "" : " AND operation_date='".$date1."' ";
    $annee = ($date1 !== "") ? "" : $annee;
    
    if ($date2 == '') 
    {
        $condition4 = '';
    }
    else
    {
        if ($date1 != '') 
        {
            $condition4 = " AND operation_date BETWEEN '".$date1."' AND '".$date2."'";
            $condition3 = '';
        }
        else $condition3 = " AND operation_date='".$date2."' ";
        $annee = "";
    }
    $condition5 = ($mois == "") ? "" : " AND MONTH(operation_date)=".$mois." ";
    $condition6 = ($annee == "") ? "" : " AND YEAR(operation_date)=".$annee." ";

    $condition = $condition1.$condition2.$condition3.$condition4.$condition5.$condition6;

    $annee = date('Y');
    $result= $equipement->filterSortieAccessoires($condition);
    if ($print == 1) 
    {
    	$result_print = [];
    	foreach ($result as $value) 
    	{
    		$sortie_par = $user->getUserById($value->sortie_par)->fetch()['nom_user'];
    		$demander_par = $user->getUserById($value->demander_par)->fetch()['nom_user'];
	    	if ($value->destination == 'client') 
	        {
	            $destination_detail = $client->afficherUnClentSansContract($value->destination_detail)->fetch()['Nom_client'];
	        }
	        elseif ($value->destination == 'relais') 
	        {
	            $destination_detail = $equipement->getSecteurById($value->destination_detail)->fetch()['nom_secteur'];
	        }
	        elseif ($value->destination == 'base') 
	        {
	            $destination_detail = $equipement->getAccessPointById($value->destination_detail)->fetch()['nom'];
	        }
	        elseif ($value->destination == 'vehicule') 
	        {
	            $vehicule_res = $vehicule->getVehiculeById($value->destination_detail)->fetch();
	            $destination_detail = $vehicule_res['modele']."-".$vehicule_res['marque'];
	        }
	        $result_print[] = ['date_sortie'=>$value->operation_date,'categorie'=>$value->categorie,'quantite'=>$value->out_store,'motif'=>$value->description,'destination'=>ucfirst($value->destination).": ".$destination_detail,'demander_par'=>$demander_par,'sortie_par'=>$sortie_par];
	        
    	}
    	require_once("printing/fiches/fiche_de_sortie_accessoire.php");
    }
    else
	require_once('vue/admin/equipement/sortie_accessoire.php');
}
function inc_sortie_equipement()
{
	$user = new User();
	$equipement = new Equipement();
    $client = new Client();
	$vehicule = new Vehicule();
    
    $result = $equipement->getSortieEquipements();
    $demander_par = '';
    $destination = '';
    $type_equipement = '';
    $mac_address = '';
    $date1 = '';
    $date2 = '';
    $mois = '';
    $annee = date('Y');
	require_once('vue/admin/equipement/sortie_equipement.php');
}
function filtreSortie_equipement($demander_par,$destination,$type_equipement,$mac_address,$date1,$date2,$mois,$annee,$print)
{
	$user = new User();
	$equipement = new Equipement();
	$client = new Client();
	$vehicule = new Vehicule();

	$condition1 = ""; 
    $condition2 = "";
    $condition3 = "";
    $condition4 = "";
    $condition5 = "";
    $condition6 = "";
    $condition7 = "";
    $condition  = "";

    $condition1 = ($demander_par == "") ? "" : " AND demander_par ='".$demander_par."'";
    $condition2 = ($destination == "") ? "" : " AND destination ='".$destination."'";
    $condition3 = ($date1 == "") ? "" : " AND date_sortie='".$date1."' ";
    
    if ($date2 == '') 
    {
        $condition4 = '';
    }
    else
    {
        if ($date1 != '') 
        {
            $condition4 = " AND date_sortie BETWEEN '".$date1."' AND '".$date2."'";
            $condition3 = '';
        }
        else $condition3 = " AND date_sortie='".$date2."' ";
    }
    $condition5 = ($mois == "") ? "" : " AND MONTH(date_sortie)=".$mois." ";
    $condition6 = ($annee == "") ? "" : " AND YEAR(date_sortie)=".$annee." ";
    $condition7 = $type_equipement == "" ? "" : " AND e.type_equipement ='".$type_equipement."' ";
    $condition8 = $mac_address == "" ? "" : " AND e.first_adress= '".$mac_address."'";

    $condition = $condition1.$condition2.$condition3.$condition4.$condition5.$condition6.$condition7.$condition8;
    $result = $equipement->filterSortieEquipements($condition);

    if ($print == 1) 
    {
    	$result_print = [];
    	foreach ($result as $value) 
    	{
            $sortie_par = $user->getUserById($value->sortie_par)->fetch()['nom_user'];
	    	if ($value->destination == 'client') 
	        {
	            $destination_detail = $client->afficherUnClentSansContract($value->destination_detail)->fetch()['Nom_client'];
	        }
	        elseif ($value->destination == 'relais') 
	        {
	            $destination_detail = $equipement->getSecteurById($value->destination_detail)->fetch()['nom_secteur'];
	        }
	        elseif ($value->destination == 'base') 
	        {
	            $destination_detail = $equipement->getAccessPointById($value->destination_detail)->fetch()['nom'];
	        }
	        elseif ($value->destination == 'vehicule') 
	        {
	            $vehicule_res = $vehicule->getVehiculeById($value->destination_detail)->fetch();
	            $destination_detail = $vehicule_res['modele']."-".$vehicule_res['marque'];
	        }
            elseif ($value->destination == 'autre') 
            {
                $destination_detail = $value->motif;
            }
	        $result_print[] = ['date_sortie'=>$value->date_sortie,'model'=>$value->model,'destination'=>ucfirst($value->destination).": ".$destination_detail,'demander_par'=>$value->nom_user,'sortie_par'=>$sortie_par,'motif'=>$value->motif];
    	}
    	//die(print_r($result_print));
    	require_once("printing/fiches/fiche_de_stock_equipement.php");
    }
    else
    require_once('vue/admin/equipement/sortie_equipement.php');
}
function equipement_recover_view()
{
	$user = new User();
	$equipement = new Equipement();
	$client = new Client();
	//$result = $equipement->getSortieEquipements();
    $models = $equipement->getModels();
    $makers = $equipement->getMakers();
    //$customers = json_encode($client->getClient_a_recuperer_Equipement());
    $customers = $client->getClient_a_recuperer_Equipement();
    $result = $equipement->getEquipementRecoveries();
    $nom_client = '';
    $date1 = '';
    $date2 = '';
    $mois = '';
    $annee = date('Y');
    $type_equipement = '';
    $mac_address = '';
	require_once('vue/admin/equipement/recuperation_equipement.php');
}
function filtreRecuperation($nom_client,$date1,$date2,$mois,$annee,$type_equipement,$mac_address,$print)
{
    $user = new User();
    $equipement = new Equipement();
    $client = new Client();
    //$result = $equipement->getSortieEquipements();
    $models = $equipement->getModels();
    $makers = $equipement->getMakers();
    //$customers = json_encode($client->getClient_a_recuperer_Equipement());
    $customers = $client->getClient_a_recuperer_Equipement();

    $condition1 = ""; 
    $condition2 = "";
    $condition3 = "";
    $condition4 = "";
    $condition5 = "";
    $condition  = "";

    $condition1 = ($nom_client == "" ? "":" cl.Nom_client LIKE '%".$nom_client."%' ");
    $condition2 = ($date1 == "" ? "" : " r.recovery_date ='".$date1."' ");
    if ($date2 == '') 
    {
        $condition3 = '';
    }
    else
    {
        if ($date1 !== '') 
        {
            $condition3 = " r.recovery_date BETWEEN '".$date1."' AND '".$date2."'";
            $condition2 = '';
        }
        else $condition3 = " r.recovery_date='".$date2."' ";
    }
    if ($mois == '' || $annee == '') 
    {
        $condition4 = '';
        $annee = '';
    }
    else
    {
        $condition4 = " MONTH(r.recovery_date)=".$mois." AND YEAR(r.recovery_date)=".$annee." ";
    }
    $condition5 = ($type_equipement == "" ? "" : " e.type_equipement = '".$type_equipement."' ");
    $condition6 = $mac_address == "" ? "" : " e.first_adress = '".$mac_address."'";
    
    $condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
    $condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
    $condition5 = ($condition5 == '' ? '' : 'AND' .$condition5);
    $condition6 = ($condition6 == '' ? '' : 'AND' .$condition6);
    
    $condition = $condition1.$condition2.$condition3.$condition4.$condition5.$condition6;
    
    $result = $equipement->filtreRecuperation($condition);
    require_once('vue/admin/equipement/recuperation_equipement.php');
}
function attribution_materiel_client()
{	
	$user = new User();
	$client = new Client();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/materielClient.php');
}
function attribuerEquipement()
{
	$user = new User();
	$client = new Client();
	$equipement =new Equipement();
	require_once('vue/admin/equipement/attribution_equipement.php');
}
function getFiche_de_stock_equipement($cond)
{
	$user = new User();
	$equipement = new Equipement();
	require_once("printing/fiches/fiche_de_stock_equipement.php");
}
function getfiche_de_sortie_accessoire($cond)
{
	$user = new User();
	$equipement = new Equipement();
	require_once("printing/fiches/fiche_de_sortie_accessoire.php");
}
function distribution_carburant()
{	
	$user = new User();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/distibution_carburant.php');
}
function ajout_stock_carburant()
{
	$equipement = new Equipement();
	$vehicule = new Vehicule();
	$user = new User();
	require_once('vue/admin/equipement/ajoutstock_carburant.php');
}
function detailcarburant($carburant)
{
	$user = new User();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/detailcarburant.php');
}
function printrapport_carburant($mois,$annee)
{
	$equipement = new Equipement();
	if ($mois == date('m')) 
	{
		$date_debut = $annee.'/'.$mois.'/1';
		$dernierJour = date('d');
		$date_fin = $annee.'/'.$mois.'/'.$dernierJour;
	}
	else
	{
		$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
		$date_debut = $annee.'/'.$mois.'/1';
		$date_fin = $annee.'/'.$mois.'/'.$nombre_jour;
		//echo $date_debut.' '.$date_fin;
	}
	$mois_avec_indice = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
	$mois_en_lettre = $mois_avec_indice[$mois];
	require_once('printing/fiches/rapport_consomation_carburant.php');
}
function nombretotalsecteur()
{

	$user = new User();
	$equipement = new Equipement();
	require_once('printing/fiches/secteurtotal.php');
}
function nombretotalbase()
{

	$user = new User();
	$equipement = new Equipement();
	require_once('printing/fiches/basetotal.php');
}
function inc_detailstock($idaccessoire)
{
	$user = new User();
	$equipement = new Equipement();
	require_once('vue/admin/equipement/detail_stock.php');
}
function imprimerRapportsortie_stock($condition,$idaccessoire)
{
	$user = new User();
	$equipement = new Equipement();
	require_once('printing/fiches/rapport_sortie_stock.php');
}
function generer_pdf_sock($idaccessoire)
{
	//print_r($idaccessoire); die();
	$resuta_tab = explode("-", $idaccessoire);
	$idaccessoire = $resuta_tab[0];
	$categorie = $resuta_tab[2];
	//print_r($idaccessoire.' : '.$categorie); die();
	$user = new User();
	$equipement = new Equipement();
	$recuper_data = array();
	//foreach ($equipement->getsortie_stock($idaccessoire) as $valeur ) 
	//{
		$categorie_accessoire = $categorie;
		//$date_control = $valeur->date_control;
		//$recuper_data[] = $valeur;
	//}
	
	require_once('printing/fiches/imprime_fiche_de_stock.php');
}

function generateMacAddress()
{
    $equipement = new Equipement();
    $mac = '74:4D:28:FB:FE:AB';
    $equipement->ajouterMacAdresse($mac,6927);
    $nbport = 5;
    // MAC Address Increments
    for($i=0;$i < $nbport-1;$i++)
    {
        $dec = hexdec($mac);
        $dec++;
        $mac = dechex($dec);
        $mac = rtrim(strtoupper(chunk_split($mac, 2, ':')),':');
        $equipement->ajouterMacAdresse($mac,6927);
        //echo "{$hexval}<br>";
    }
}
