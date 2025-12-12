<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

foreach ($comptabilite->filtreEntrerCaisse($_GET['condition']) as $value) 
{
?>
    <tr>
        <td><?php echo $value->dateEntrer?></td>
        <td><?php echo $value->montantEntrer?></td>
        <td><?php echo $value->devise?></td>
        <td><?php echo $value->provenance?></td>
    </tr>
<?php
}
?>  