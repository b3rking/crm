
<?php
	require_once("../../model/connection.php");
	require_once("../../model/marketing.class.php");

	$marketing = new marketing();
    $dateRendezvous = $_GET['rdv'] == '' ? null : $_GET['rdv'];
    $dateprospection = $_GET['dateprospection'] == '' ? null : $_GET['dateprospection'];

	if($marketing->updateProspect($_GET['numprospect'],$_GET['nomprospect'],$_GET['adresprospect'],$_GET['phoneprospect'],$_GET['mailprospect'],$_GET['genre'],$dateRendezvous,$dateprospection) > 0)
	{
	    //require_once('rep.php');
	}
