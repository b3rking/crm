
<?php
	require_once("../../model/connection.php");
	require_once("../../model/marketing.class.php");

	$marketing = new marketing();
	

	if($marketing->supprimerstock($_GET['idstockmarketing']) > 0)
	{
	     require_once('repstockmarketing.php');
	}


