
<?php
	require_once("../../model/connection.php");
	require_once("../../model/marketing.class.php");

	$marketing = new marketing();
	

	if($marketing->updatestock($_GET['idstockmarketing'],$_GET['materiels'],$_GET['quantite']) > 0)
	{
	    require_once('repstockmarketing.php');
	}
