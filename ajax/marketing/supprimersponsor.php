
<?php
	require_once("../../model/connection.php");
	require_once("../../model/marketing.class.php");

	$marketing = new marketing();
	

	if($marketing->supprimerSponsor($_GET['numspons']) > 0)
	{
	    require_once('repSponsor.php');
	}
