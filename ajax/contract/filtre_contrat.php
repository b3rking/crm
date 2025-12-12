<?php
	require_once("../../model/connection.php");
	require_once("../../model/client.class.php");
	require_once("../../model/contract.class.php");
	require_once("../../model/User.class.php");
	require_once("../../model/comptabilite.class.php");
	require_once("../../model/service.class.php");
	require_once("../../model/article.class.php");

	$client = new Client();
	$contract = new Contract();
	$user = new User();
	$comptabilite = new Comptabilite();
	$service = new Service();
	$article = new Article();

	$l = false;
	$c = false;
	$m = false;
	$s = false;
	if ($d = $user->verifierPermissionDunePage('contrat',$_GET['iduser'])->fetch()) 
	{
	    if ($d['L'] == 1) 
	    {
	        $l = true;
	    }
	    if ($d['C'] == 1) 
	    {
	        $c = true;
	    }
	    if ($d['M'] == 1) 
	    {
	        $m = true;
	    }
	    if ($d['S'] == 1) 
	    {
	        $s = true;
	    }
	}
	foreach ($comptabilite->getMonnaies() as $value) 
	{
	    $tbMonnaie[] = $value->libelle;
	}
	$webroot = $_GET['webroot'];
	$condition = $_GET['condition'];
	require_once('repFiltre.php');
			



