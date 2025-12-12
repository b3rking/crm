<?php
	require_once("../../model/connection.php");
	require_once("../../model/comptabilite.class.php");

	$comptabilite = new Comptabilite();
	
	foreach ($comptabilite->getMonnaies() as $value) 
	{
	    $tbMonnaie[] = $value->libelle;
	}
	
	$condition = $_GET['condition'];
	$WEBROOT = $_GET['WEBROOT'];
	$l = $_GET['l'];
	$c = $_GET['c'];
	$m = $_GET['m'];
	$s = $_GET['s'];
	require_once('rep_filtre_banque.php');
	