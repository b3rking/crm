<?php
	require_once("../../model/connection.php");
	require_once("../../model/contract.class.php");

	$contract = new Contract();
	if ($_GET['status'] == 'paying') 
	{
		$res = $contract->raportFacturePayer($_GET['condition']);
	}
	else
	{
		$res = $contract->raportFactureImpayer($_GET['condition']);
	}

	$i = 0;
    $y = 0;
    $mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
    foreach ($res as $value) 
    {
    	$i++;
    ?>
    	<tr>
            <td><?=$value->date_creation?></td>
            <td><?=$value->facture_id?></td>
            <td>
            	<a href="<?=$_GET['webroot'];?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->nom_client;?></b></a>
            </td>
            <td><?=$value->nomService?></td>
            <td><?php
            if ($value->quantite > 1) 
			{
				if ($value->annee == $value->annee_fin) 
				{
					echo ucfirst($mois[$value->mois_debut]).' au '.ucfirst($mois[$value->mois_fin]).' '.$value->annee;
				}
				else
				{
					echo ucfirst($mois[$value->mois_debut]).'/'.$value->annee.' au '.ucfirst($mois[$value->mois_fin]).'/'.$value->annee_fin;
				}
			}
			else
			{
				echo ucfirst($mois[$value->mois_debut]).' '.$value->annee;
			}?>
            	
            </td>
            <td><?php
            if ($_GET['status'] != 'paying')
            echo $value->montant+$value->montant_tva.' '.$value->monnaie;
        	else echo $value->montant.' '.$value->monnaie;
        	?>
        	</td>
            <td><?=$value->tva?></td>
        </tr>
    <?php
    }
	?>