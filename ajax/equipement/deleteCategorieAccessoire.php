
<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");


$equipement = new Equipement();


if ($equipement->deleteCategorieAccessoire($_GET['categorie_id'])) 
{
}
?>