<?php
	require_once("../../model/connection.php");
	require_once("../../model/client.class.php");

	$client = new Client();

	$condition1 = null;
    $condition2 = null;
    $condition3 = null;
    $condition4 = null;
    $condition5 = null;
    $query = '';
    $url = $_GET['url'];
    $session_user = $_GET['session_user'];
    $profil_name = $_GET['profil_name'];

    if ($_GET['billing_number'] == '') 
    {
    	$condition1 = '';
    }
    else $condition1 = " billing_number=".$_GET['billing_number'];
    if ($_GET['nom_client'] == '') 
    {
	    //$valIdclient = '';
	    $condition2 = '';
    }
    else
    {
	    //$valIdclient = $_GET['idclient'];LIKE '%".$nom."%'
	    $condition2 = " nom_client LIKE '%".$_GET['nom_client']."%' ";
	}
	if ($_GET['secteur'] == '') 
	{
		//$valsecteur = '';
		$condition3 = '';
		/*if ($_GET['idclient'] != '') 
	    {
		    $condition1 = " ID_client='".$valIdclient."' ";
	    }*/
	}
	else
	{
		//$valsecteur = $_GET['secteur'];
		$condition3 = " s.ID_secteur='".$_GET['secteur']."' ";
	}
	if ($_GET['date1'] == '') 
	{
		$valDate1 = '';
		$condition4 = '';
	}
	else
	{
		//$valDate1 = $_GET['date1'];
		$condition4 = " date_creation='".$valDate1."' ";
	}
	if ($_GET['date2'] == '') 
	{
		//$valDate2 = '';
		$condition5 = '';
	}
	else
	{
		if ($_GET['date1'] != '') 
		{
			//$valDate2 = $_GET['date2'];
			$condition5 = " date_creation BETWEEN '".$_GET['date1']."' AND '".$_GET['date2']."'";
			$condition4 = '';
		}
		else $condition5 = " date_creation='".$_GET['date2']."' ";
	}

	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
	$condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
	$condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
	$condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
	$condition5 = ($condition5 == '' ? '' : 'AND' .$condition5);

	//on met ensemble les condition pour pouvoir constituer une seule condition
	$condition = $condition1.$condition2.$condition3.$condition4.$condition5;
	if ($_GET['secteur'] != '') 
	{
		$query = 'SELECT c.ID_client,billing_number,solde,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,commentaire,nif,type_client,langue,assujettiTVA,etat FROM client c,point_acces p,secteur s,installation ins WHERE c.ID_client = ins.ID_client AND p.ID_point_acces = ins.ID_point_acces AND p.secteur = s.ID_secteur '.$condition;
	}
	else
	{
		$query = "SELECT client.ID_client,billing_number,solde,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,commentaire,type_client,nif,langue,assujettiTVA,etat FROM client WHERE ".substr($condition, 3);
	}
	if ($query == '') 
	{
		echo ' Un filtre efectuer';
	}
	else
	{ 
		//echo $query;
		require_once('repFiltre.php');
	}
