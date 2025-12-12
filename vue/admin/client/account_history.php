<?php
if ($value['type_client'] == 'paying' AND $value['etat'] == 'actif')
{
?>
    <div class="row">
    <div class="col-lg-4 col-md-12 col-sm-12 col-xlg-4">
        <div class="card">
            <div class="card-header">
                Actif sans dette
                <span id="msg"></span>
            </div>
            <div class="card-body">
                <!--month_etiquete[$i]-->
                <h6 class="card-title"></h6>
                <div class="table-responsive">
                    <table class="table color-table success-table">
                        <thead>
                            <tr>
                                <th class="font-bold">Mois</th>
                                <th class="font-bold">Etat</th>
                                <th class="font-bold">Solde</th>
                            </tr>
                        </thead>
            <tbody id="rep" class="font-bold">
        <?php
        for ($i=6; $i > 0; $i--) 
        {
            $date = date_parse(date("d-m-Y",strtotime(-$i." Months")));
            $mois = $date['month'];
            $annee = $date['year']; 
            //$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
            $date2 = $annee.'-'.$mois.'-01';
            $month = ($mois < 10 ? '0'.$mois : $mois);
            $year_month = $annee.$month;
            $facture_bif = 0;
            $paiement_bif = 0;
            foreach ($contract->getMontantFactureDunClientDuDebutAuneDate($date2,$id) as $value) 
            {
                $facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
            }
            foreach ($contract->getMontantPayementDunClientDuDebutAuneDate($year_month,$id) as $value) 
            {
                $paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
            }
            $balance = $facture_bif - $paiement_bif + $balance_initiale; 
        ?>   
            <tr>
                <td><?php echo $month_etiquete[$mois].'/'.$annee?></td>
                <td>
                <?php 
                    if($balance <= 0)
                    {
                        echo "Hors Service";
                    }
                    else echo "dero";
                ?>
                    
                </td>
                <td><?php echo number_format($balance).' BIF';?></td>
            </tr>
            <?php
                if ($i == 1) 
                {
                    $date = date_parse(date("d-m-Y"));
                    $mois = $date['month'];
                    $annee = $date['year'];
                    //$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

                    $date2 = $annee.'-'.$mois.'-01';
                    $month = ($mois < 10 ? '0'.$mois : $mois);
                    $year_month = $annee.$month;
                    $facture_bif = 0;
                    $paiement_bif = 0;
                    foreach ($contract->getMontantFactureDunClientDuDebutAuneDate($date2,$id) as $value) 
                    {
                        $facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
                    }
                    foreach ($contract->getMontantPayementDunClientDuDebutAuneDate($year_month,$id) as $value) 
                    {
                        $paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
                    }
                    $balance = $facture_bif - $paiement_bif + $balance_initiale;
            ?>  
                    <tr>
                        <td><?php echo $month_etiquete[$mois].'/'.$annee?></td>
                        <td>
                        <?php 
                            if($balance <= 0)
                            {
                                echo "Hors Service";
                            }
                            else echo "dero";
                        ?>
                        </td>
                        <td><?php echo number_format($balance).' BIF';?></td>
                    </tr>
            <?php 
                }
            }
        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!--<div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Graphe du solde</h4>
                <div id="solde_annuel"></div>
            </div>
        </div>
    </div>-->
     <div class="col-lg-8">
         <div class="card">
            <div class="card-header">
                
                <span id="msg">Graphe du solde</span>
            </div>
            <div class="card-body">
                <h6 class="card-title"></h6>
                <div id="solde_annuel"></div>
            </div>
        </div>
     </div>

    <!-- <div class="col-lg-3 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
            <div class="card-header">
                
                <span id="msg">Detail statut</span>
            </div>
            <div class="card-body">
                <h6 class="card-title"></h6>
                <div class="table-responsive">
                    <table class="table color-table success-table">
                        <thead>
                            <tr>
                                <th class="font-bold">Mois</th>
                                <th class="font-bold">Etat</th>
                            </tr>
                        </thead>
                        <tbody id="rep" class="font-bold">
                            <?php
                            for ($i=6; $i > 0; $i--) 
                            {
                                $date = date_parse(date("d-m-Y",strtotime(-$i." Months")));
                                $mois = $date['month'];
                                $annee = $date['year']; 
                            ?>
                            <tr>
                                <td><?php echo $month_etiquete[$mois].'/'.$annee?></td>
                                <td>
                                    actif
                                        
                                </td>
                            </tr>
                            <?php
                                if ($i == 1) 
                                {
                                    $date = date_parse(date("d-m-Y"));
                                    $mois = $date['month'];
                                    $annee = $date['year'];
                            ?>
                                    <tr>
                                        <td><?php echo $month_etiquete[$mois].'/'.$annee?></td>
                                        <td>
                                            actif
                                                
                                        </td>
                                    </tr>
                            <?php 
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> -->
</div><!-- /.row-->
<?php
}
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
            <div class="card-header" style="background-color: #ef7f22;height: 1.5rem;padding-top: 0.1rem">
                <h6 class="text-white">Historique de compte</h6>
                <span id="msg"></span>
            </div>
            <div class="card-body">
<input type="text" id="page" value="account_history" hidden="">
<div class="table-responsive">
    <table id="smptable" class="table">
        <thead>
            <tr>
                <th>DATE</th>
                <th>DESCRIPTION</th>
                <th>MONTANT</th>
                <th>TAUX PAR DEFAUT</th>
                <th>MONTANT EN BIF</th>
                <th>SOLDE</th>
                <th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>DATE</th>
                <th>DESCRIPTION</th>
                <th>MONTANT</th>
                <th>TAUX PAR DEFAUT</th>
                <th>MONTANT EN BIF</th>
                <th>SOLDE</th>
                <th></th>
            </tr>
        </tfoot>
        <tbody>
<?php

$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
//$taux = 1765;
$solde = 0;
if ($res = $contract->getBalanceInitiale($id)->fetch()) 
{
    //if ($res['montant'] > 0) 
    //{
        $solde += $res['montant'];
?>
        <tr class="font-bold">
            <td><?=$res['date_creer']?></td>
            <td style="background-color: #B5C6E0;"><?=$res['description']?></td>
            <td><?=number_format($res['montant']).' '.$res['monnaie']?></td>
            <td><?=$taux?></td>
            <td><?=number_format($res['montant']).' '.$res['monnaie']?></td>
            <td><?=number_format($res['montant'])?></td>
            <td></td>
        </tr>
<?php
    //}
}
$i = 0;
$y = 0;
$p = 0;
foreach ($contract->getAccountHistory($id) as $account) 
{
    $array = preg_split("#[/]+#", $account->date_creation);
    $date = $array[0];
    $type = $array[1];
    $Idfrom = $array[2];
    if ($type == 'facture') 
    {
        $i++;
        foreach ($contract->recupererAcountHistoryFacture($Idfrom) as $value) 
        {
            $thisRate = $value->exchange_rate >= 500 ? $value->exchange_rate:$taux;
            $facture_bif = (strtolower($value->monnaie) == 'bif' ? $value->montant_total : $value->montant_total*$thisRate);
?>
        <tr class="font-bold"> 
        <td><?=$date?></td>
        <td style="background-color: #EF9688;">
            <?='Facture No :'.$value->numero.' '.$value->nomService?>
        </td>
        <td><?=ceil($value->montant_total).' '.$value->monnaie?></td>
        <td><?=$thisRate?></td>
        <td><?=number_format($facture_bif)?></td>
        <td>
            <?php
            $solde += $facture_bif;
            echo number_format(round($solde));
            /*if ($i == count($contract->getAccountHistory($id))) 
            {
                echo $contract->getSommeTotaleFactureDunClient($id)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($id)->fetch()['montant'];
            }
            else*/
            //echo $contract->getMontantFactureDunClientDuDebutAuneDate($value->date_creation,$id)->fetch()['montant'] - $contract->getMontantPayementDunClientDuDebutAuneDate($value->date_creation,$id)->fetch()['montant'].' '.$value->monnaie
            ?>
        </td>
        <td class="text-nowrap">
            
            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

            <!-- sample modal content -->
            <?php require 'vue/admin/facture/updateInvoiceForm.php'?>

            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

        <!-- sample modal content -->
            <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Suppression de facture</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            Voulez-vous vraiment supprimer cette </br> facture ?
                            <input type="text" id="id_factureDelete<?=$i?>" value="<?= $value->facture_id?>" hidden>
                            <input type="text" id="del_moisdebut<?=$i?>" value="<?=$value->mois_debut?>" hidden>
                            <input type="text" id="del_annedebut<?=$i?>" value="<?=$value->annee?>" hidden>
                            <input type="text" id="del_idclient<?=$i?>" class="form-control form-control-sm" value="<?=$value->ID_client?>" hidden>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger waves-effect text-left" onclick="deleteFacture($('#id_factureDelete<?=$i?>').val(),$('#del_moisdebut<?=$i?>').val(),$('#del_annedebut<?=$i?>').val(),$('#del_idclient<?=$i?>').val(),$('#idcontract<?=$i?>').val(),$('#billing_date<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i>Supprimer
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </td>
    </tr>
<?php
        }
    }
    else
    {
        $p++;
        foreach ($contract->getAccountHistoryPayement($Idfrom) as $data) 
        {
            $thisRate = $data->Taux_change_courant >= 500 ? $data->Taux_change_courant:$taux;
            $paiement_bif = (strtolower($data->exchange_currency) == 'bif' ? $data->montant_converti : $data->montant_converti*$thisRate);
?>
    <tr class="font-bold">
        <td><?=$date?></td>
        <td style="background-color: #B5FCA4"><?='Payement :'.$data->reference.' taux de change :'.$data->taux_change_courant?>
        </td>
        <td><?=number_format($data->montant_converti).' '.$data->exchange_currency?></td>
        <td><?=$thisRate?></td>
        <td><?=number_format($paiement_bif)?></td>
        <td>
            <?php
            $solde -= $paiement_bif;
            echo number_format(round($solde));
            //if ($i == count($contract->getAccountHistory($id))) 
            //{
                //echo $contract->getSommeTotaleFactureDunClient($id)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($id)->fetch()['montant'].' '.$value->devise;
            //}
            //else
            //{
                //$montantF =($contract->getMontantFactureDunClientDuDebutAuneDate($value->datepaiement,$id)->fetch()['montant'] == '' ? 0 : $contract->getMontantFactureDunClientDuDebutAuneDate($value->datepaiement,$id)->fetch()['montant']);

                //echo $montantF- $contract->getMontantPayementDunClientDuDebutAuneDate($value->datepaiement,$id)->fetch()['montant'].' '.$value->devise;
            //}
            ?>
        </td>
        <td class="text-nowrap">
            
            <!--<a href="<=WEBROOT;?>recu_paiement_facture-<=$value->ID_paiement?>" data-toggle="tooltip"  data-original-title="Print"><i class="mdi mdi-printer"></i></a> -->
            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg-paiement<?=$p?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
            <!-- sample modal content -->
            <?php require 'vue/admin/finance/updatePaymentForm.php';?>
            
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm-paiement<?=$p?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

                    <!-- sample modal content -->
<div class="modal fade bs-example-modal-sm-paiement<?=$p?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer paiement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="idpaiement_del-<?= $p?>" value="<?php echo $data->ID_paiement?>" hidden>
                <input type="text" id="del_idclient<?=$p?>" value="<?=$data->ID_client?>" hidden>
                Voulez-vous supprimer ce paiement?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletePaiement($('#idpaiement_del-<?= $p?>').val(),$('#del_idclient<?=$p?>').val(),$('#old_montant<?=$p?>').val(),$('#status<?=$p?>').val(),'<?=$data->deposed?>')" data-dismiss="modal"><i class="ti-trash"></i></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
        </td>
    </tr>
<?php
        }
    }
}
?>
        </tbody>
    </table>
</div>
</div>
        </div>
    </div>
</div><!-- /.row-->