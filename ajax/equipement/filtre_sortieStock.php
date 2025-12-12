<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");

$equipement = new Equipement();

$i =0;
foreach ($equipement->filtreSortie_stock($_GET['condition']) as $value) 
{
	$i++;?>
    <tr>
       <td><?php echo $value->date_sortie?></td>
    <td><?php echo $value->categorie?></td>
    <td><?php echo $value->quantite?></td>
    <td><?php echo $value->motif?></td>
    <td><?php echo $value->serviteur?></td>
    <td><?php echo $value->nom_user?></td>
    </tr>
<?php
}
?>  