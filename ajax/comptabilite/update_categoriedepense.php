 <?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();


if ($comptabilite->updateCategorieDepense($_GET['idCategorie'],$_GET['type_categorie'],$_GET['description'])>0)  
{
	//echo "ok";
	require_once('reponse_categoriedepense.php'); 
}
//idCategorie="+idCategorie+"&type_categorie="+type_categorie+"&description="+description
?>
