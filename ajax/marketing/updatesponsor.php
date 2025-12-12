
<?php
	require_once("../../model/connection.php");
	require_once("../../model/marketing.class.php");

	$marketing = new marketing();
	

	if($marketing->updateSponsor($_GET['idsponsor'],$_GET['demande'],$_GET['nature'],$_GET['adrsponsor'],$_GET['phonesponsor'],$_GET['datedebut'],$_GET['datefin']) > 0)
	{
	    require_once('repSponsor.php');
	}
