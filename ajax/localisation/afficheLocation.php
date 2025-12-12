<?php
require_once("../../model/connection.php");
require_once("../../model/localisation.class.php");



$rs = $localisation->afficheLocalisation($_GET['locationS']);

if ($rs)
{
?>
<?php
 $i = 0;
foreach ($localisation->afficheLocalisation() as $value)

 	{
      $i++;
    ?>
    
    <tr>
        <td><?php echo $value->ID_localisation?></td>
        <td><?php echo $value->nom_localisation?> </td>
    </tr>

<?php
	}
}
?>  






        
