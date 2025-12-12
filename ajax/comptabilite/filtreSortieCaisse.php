<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

$i =0;
foreach ($comptabilite->filtreSortieCaisse($_GET['condition']) as $value) 
{
	$i++;?>
    <tr>
        <td><?php echo $value->date_sortie?></td>
        <td><?php echo $value->montant_sortie.' '.$value->devise?></td>
        <td><?php echo $value->motif?></td>
        <td><?php echo $value->destination?></td>
        <!--td><php echo $value->reponsableCaisse?></td--> 
    </tr>
<?php
}
?>  