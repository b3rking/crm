
<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
 
$equipement = new Equipement();
if($equipement->distribuer_carburant($_GET['nature'],$_GET['idrecepteur'],$_GET['nblitres'],$_GET['datedistribution'],$_GET['distributeur']))
{

	if ($equipement-> DiminuerQuantiteCarburant($_GET['nature'],$_GET['nblitres'])) 
	{
	
		require_once('reponsedistibutiongazoil.php');

	}
}
?>
		