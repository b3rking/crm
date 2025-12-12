<?php
	require_once("../../model/connection.php");
	require_once("../../model/marketing.class.php");


	$marketing = new marketing();

	$condition1 = null;
    $condition2 = null;
    $condition3 = null;
    $condition4 = null;
    $condition5 = null;


    if ($_GET['idprospect'] == '') 
    {
	    $valIdprospect = '';
	    $condition1 = '';
    }
    else
    {
	    $valIdprospect = $_GET['idprospect'];
	    $condition1 = " ID_prospect='".$valIdprospect."' ";
	}
	if ($_GET['nomprospect'] == '') 
	{
		$valIdnomProspect = '';
		$condition2 = '';
	}
	else
	{
		$valIdnomProspect = $_GET['nomprospect'];
		$condition2 = " nom='".$valIdnomProspect."' ";
	}
	if ($_GET['phoneprospect'] == '') 
	{
		$valphoneProspect = '';
		$condition3 = '';
	}
	else
	{
		$valphoneProspect = $_GET['phoneprospect'];
		$condition3 = " telephone='".$valphoneProspect."' ";
	}
	if ($_GET['mailprospect'] == '') 
	{
		$valmailprospect = '';
		$condition4 = '';
	}
	else
	{
		$valmailprospect  = $_GET['mailprospect'];
		$condition4 = " mail='".$valmailprospect ."' ";
	}
	if ($_GET['dateprospection'] == '') 
	{
		$valDateprospection = '';
		$condition5 = '';
	}
	else
	{
		$valDateprospection  = $_GET['dateprospection'];
		$condition5 = " dateProspection='".$valDateprospection."' ";

	}

	$condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
	$condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
	$condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
	$condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
	$condition5 = ($condition5 == '' ? '' : 'AND' .$condition5);

	//on met ensemble les condition pour pouvoir constituer une seule condition
	$condition = $condition1.$condition2.$condition3.$condition4.$condition5;
	$condition = substr($condition,3);
	if ($condition == '') 
	{
		require_once('rep.php');
	}
	else
	{
		$filtreProspect = '';
		//  Si $condtion n'est pas vide c.à.d l'utilisateur a selectinné un ou plusieurs elements pour faire la recherche ou le filtrage, on l'utilise alors cette condition 
		require_once('rep.php');
	}