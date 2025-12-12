 <?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");

$equipement = new Equipement();
 
$WEBROOT = $_GET['WEBROOT'];
$res = $equipement->ajouter_carburant($_GET['nature'],$_GET['nblitre'],$_GET['prix_achat'],$_GET['datesachat']);
if($res[1] == 1062)
{
	if ($equipement->AugmenterQuantiteCarburant($_GET['nature'],$_GET['nblitre'])) 
	{
		if ($equipement->historique_ajouter_carburant($_GET['nature'],$_GET['nblitre'],$_GET['prix_achat'],$_GET['datesachat']))
		{
			require_once('reponsestock_carburant.php');
		}
	}	
}

?>
			