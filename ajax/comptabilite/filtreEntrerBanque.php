<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

foreach ($comptabilite->filtreEntrerBanque($_GET['condition']) as $value) 
{
?>
    <tr>
        <td><?php echo $value->montantVersser.' '.$value->monnaie?></td>
        <td><?=$value->provenance?></td>
        <td><?php echo $value->date_creation?></td>
    </tr>
<?php
}
?>  