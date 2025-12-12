<?php
	require_once("../../model/connection.php");
	require_once("../../model/ticket.class.php");

	$ticket = new ticket();

    $WEBROOT = $_GET['WEBROOT'];

	$l = $_GET['l'];
	$c = $_GET['c'];
	$m = $_GET['m'];
	$s = $_GET['s'];
	$condition = $_GET['condition'];
	require_once('repfiltre.php');