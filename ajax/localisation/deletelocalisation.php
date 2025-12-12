		 <?php
require_once("../../model/connection.php");
require_once("../../model/localisation.class.php");
require_once("../../model/comptabilite.class.php");

$localisation = new Localisation();
$comptabilite = new Comptabilite();
if ($localisation->deletelocalisation($_GET['idlocalisation']) > 0) 

	{
		if ($comptabilite->setHistoriqueAction($_GET['idlocalisation'],'localisation',$_GET['name_user'],date('Y-m-d'),'supprimer')) 
		{
			require_once('repLocalisation.php');
		}
	}
	?>