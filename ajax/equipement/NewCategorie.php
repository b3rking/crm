
<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");


$equipement = new Equipement();


if ($equipement->ajouterCategorieAccessoire($_GET['categorie'])) 
{
	//require_once('reponseAccessoire.php');
}
?>