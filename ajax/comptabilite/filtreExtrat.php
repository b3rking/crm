<?php
	require_once("../../model/connection.php");
	require_once("../../model/comptabilite.class.php");

	$comptabilite = new Comptabilite();
	
	$condition = $_GET['condition'];
	$WEBROOT = $_GET['WEBROOT'];
	
	$i =0;
	foreach ($comptabilite->filtreExtrat($condition) as $value)
    {
	    $i++;?>
	    <tr>
	    	<td><?php echo $value->date_extrat?></td>
	        <td><?php echo $value->ID_type_extrat?></td>
	        <td><?php echo $value->description?></td>
	        <td><?php echo $value->montant .' '.$value->monnaie?></td>
	        <?php
	        if ($value->destination == 'caisse') 
	        {
	        	$caisse = $comptabilite->getCaisseDestinationExtrat($value->ID_extrat)->fetch();
	        ?>
	        	<td><?=$caisse['nomCaisse']?></td>
	      	<?php
	      	}
	      	else
	      	{
	      		$banque = $comptabilite->getBanqueDestinationExtrat($value->ID_extrat)->fetch();
      		?>
      			<td><?=$caisse['nom']?></td>
  			<?php
	      	}
	      	?>
	    </tr>
    <?php
    }
	