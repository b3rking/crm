<?php
require_once("../../model/connection.php");
require_once("../../model/historique.class.php");

$historique = new Historique();

foreach ($historique->filtreHistoriqueAction($_GET['condition']) as $value) 
{
?>
	<tr>
        <td><?=strtoupper($value->type)?></td>
        <td><?=$value->dateAction?></td>
        <td><?=strtoupper($value->nom_user)?></td>
        <td><?=$value->action?></td>
    </tr>
<?php
}
?>