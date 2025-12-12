
<?php
	require_once("../../model/connection.php");
	require_once("../../model/marketing.class.php");

	$marketing = new marketing();
	
	if($marketing->supprimerProspect($_GET['numprospect']) > 0)
	{
	    //require_once('rep.php');
	}
