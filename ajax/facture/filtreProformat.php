<?php
	require_once("../../model/connection.php");
	require_once("../../model/contract.class.php");
	require_once("../../model/comptabilite.class.php");
	require_once("../../model/service.class.php");
	require_once("../../model/localisation.class.php");

	$contract = new Contract();
	$comptabilite = new Comptabilite();
	$service = new Service();
	$localisation = new Localisation();
	$condition = $_GET['condition'];
	$WEBROOT = $_GET['WEBROOT'];
	//$m = $_GET['m'];
	//$s = $_GET['s'];
	foreach ($comptabilite->getMonnaies() as $value) 
	{
	    $tbMonnaie[] = $value->libelle;
	}
	require_once('repFiltreProformat.php');
	/*$condition1 = null;
    $condition2 = null;
    $condition3 = null;
    $condition4 = null;
    $condition5 = null;
    $condition6 = null;

    if ($_GET['num_fact'] == '') 
    {
	    $condition1 = '';
    }
    else
    {
	    $condition1 = " fac.facture_id='".$_GET['num_fact']."' ";
	}
	if ($_GET['idclient'] == '') 
	{
		$condition2 = '';
	}
	else
	{
		$condition2 = " cl.ID_client=".$_GET['idclient']." ";
	}
	if ($_GET['mode'] == '') 
	{
		$condition3 = '';
	}
	else
	{
		$condition3 = " co.mode='".$_GET['mode']."' ";
	}
	if ($_GET['date1'] == '') 
	{
		$condition4 = '';
	}
	else
	{
		$condition4 = " fac.date_creation='".$_GET['date1']."' ";
	}
	if ($_GET['date2'] == '') 
	{
		$condition5 = '';
	}
	else
	{
		/*$valDate2 = $_GET['date2'];
		$creation = $valDate1.' AND '.$valDate2.' ';
		$condition5 = " date_description BETWEEN '".$creation."' ";
		//$condition4 = '';*
		if ($_GET['date1'] !== '') 
		{
			//$valDate2 = $_GET['date2'];
			//$creation = $valDate1.' AND '.$valDate2.' ';
			$condition5 = " fac.date_creation BETWEEN '".$_GET['date1']."' AND '".$_GET['date2']."'";
			$condition4 = '';
		}
		else $condition5 = " fac.date_creation='".$_GET['date2']."' ";
	}
	if ($_GET['mois'] == '') 
	{
		$condition6 = '';
	}
	else
	{
		if ($_GET['annee'] != '') 
		{
			$condition6 = " fs.mois_debut='".$_GET['mois']."' AND fs.annee=".$_GET['annee'];
		}
	}

	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
	$condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
	$condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
	$condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
	$condition5 = ($condition5 == '' ? '' : 'AND' .$condition5);
	$condition6 = ($condition6 == '' ? '' : 'AND' .$condition6);

	//on met ensemble les condition pour pouvoir constituer une seule condition
	$condition = $condition1.$condition2.$condition3.$condition4.$condition5.$condition6;

	if ($condition == '') 
	{
		//echo "condition est vide";
		require_once('rep.php');
	}
	else
	{
		//echo $condition;
		//echo "connection : ".$condition;
		//  Si $condtion n'est pas vide c.à.d l'utilisateur a selectinné un ou plusieurs elements pour faire la recherche, on utilise alors cette condition 
		require_once('repFiltre.php');
	}*/
	//echo "num_fact = ".$_GET['num_fact']." idclient = ".$_GET['idclient']." date1 = ".$_GET['date1']." date2 = ".$_GET['date2']." mode = ".$_GET['mode']." mois = ".$_GET['mois']." annee = ".$_GET['annee'];
	//num_fact="+num_fact+"&idclient="+idclient+"&date1="+date1+"&date2="+date2+"&mode="+mode+"&mois="+mois+"&annee="+annee