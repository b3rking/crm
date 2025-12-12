<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

    $contract = new Contract();
    //$date = date_parse($_GET['periode']);
   // $jour = $date['day'];
    $mois_debut = $_GET['mois_debut'];
    $annee = $_GET['annee_debut'];

//echo "Mois : $month; Jour : $day; Année : $year<br />\n";
$i = 0;
$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
foreach ($contract->getFacturesDunMois($mois_debut,$annee) as $value) 
{
    $i++;
?>
    <tr>
        <td><?=$value->date_creation?></td>
        <td><?=$value->facture_id?></td>
        <td><a href="<?= $_GET['webroot'];?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->nom_client;?></b></a></td>
        <td><?=$value->nomService?></td>
        <td><?php
        if (count($contract->getMoisDuneFacture($value->facture_id)) > 1) 
        {
            $k=0;
            foreach ($contract->getMoisDuneFacture($value->facture_id) as $val) 
            {
                if ($val->billing_cycle == 0) 
                {
                    //echo "Du ".$value->startDate." au ".$value->endDate;
                }
                else
                {
                    if ($val->quantite > 1) 
                    {
                        if ($k==0) 
                        {
                            if ($val->annee == $val->annee_fin) 
                            {
                                echo ucfirst($mois[$val->mois_debut]).' au '.ucfirst($mois[$val->mois_fin]).' '.$val->annee;
                            }
                            else
                            {
                                echo ucfirst($mois[$val->mois_debut]).'/'.$val->annee.' au '.ucfirst($mois[$val->mois_fin]).'/'.$val->annee_fin;
                            }
                        }
                    }
                    else
                    {
                        if ($k==0) echo ucfirst($mois[$val->mois_debut]).' '.$val->annee;
                        $k++;
                    }
                }
            }
        }
        else
        {
            if ($value->billing_cycle == 0) 
            {
                echo "Du ".$value->startDate." au ".$value->endDate;
            }
            else
            {
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
                }
            }
        }
        ?>
        </td>
        <td><?=$value->montant.' '.$value->monnaie?></td>
        <td><?=$value->tva?></td>
    </tr>
<?php
}
?>