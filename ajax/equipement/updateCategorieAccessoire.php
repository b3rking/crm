
<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");


$equipement = new Equipement();


if ($equipement->updateCategorieAccessoire($_GET['categorie_id'],$_GET['categorie']) > 0) 
{
}
?>