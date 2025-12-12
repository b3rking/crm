<?php
	require_once("../../model/connection.php");
	require_once("../../model/comptabilite.class.php");

	$comptabilite = new Comptabilite();
	
	$condition = $_GET['condition'];
	$WEBROOT = $_GET['WEBROOT'];
	$l = $_GET['l'];
	$c = $_GET['c'];
	$m = $_GET['m'];
	$s = $_GET['s'];
	$iduser = $_GET['iduser'];
	
	require_once('reponse_filtre.php');
	