 <?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();


if ($comptabilite->update_type_extrat($_GET['refextrat'],$_GET['libelle'])>0)  
{
	//echo "ok";
	require_once('reponse_type_extrat.php'); 
}
?>