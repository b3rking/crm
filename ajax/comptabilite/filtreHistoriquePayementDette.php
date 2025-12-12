<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

foreach ($comptabilite->filtreHistoriquePayementDette($_GET['condition']) as $value) 
{
?>
    <tr> 
        <td><?=$value->nom?></td>
        <td><?=$value->montant_paie .' USD'?></td>
        <td><?=$value->date_histo?></td>
        <td><?=$value->provenancePayement?></td>
        <td><?=$value->userName?></td>
    </tr>
<?php
}
?>  