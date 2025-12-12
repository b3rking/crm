<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

foreach ($comptabilite->filtreSortieBanque($_GET['condition']) as $value) 
{
?>
    <tr>
        <td><?php echo $value->montantsorti.' '.$value->monnaie?></td>
        <th><?=$value->motif?></th>
        <td><?php echo $value->date_sortie?></td>
    </tr>
<?php
}
?>  