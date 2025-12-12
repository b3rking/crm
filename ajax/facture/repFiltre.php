<?php
$i = 0;
$y = 0;
$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
foreach ($contract->filtreFactures($condition) as $value) 
{
    $i++;
?>
    <tr>
        <td><?=$value->date_creation?></td>
        <td><?=$value->numero?></td>
        <td><a href="<?= $WEBROOT;?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->nom_client;?></b></a></td>
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
                elseif($val->billing_cycle == 2)
                {}
                else
                {
                    if ($val->quantite > 1) 
                    {
                        //if ($k==0) 
                        //{
                            if ($val->annee == $val->annee_fin) 
                            {
                                echo ucfirst($mois[$val->mois_debut]).' au '.ucfirst($mois[$val->mois_fin]).' '.$val->annee;
                            }
                            else
                            {
                                echo ucfirst($mois[$val->mois_debut]).'/'.$val->annee.' au '.ucfirst($mois[$val->mois_fin]).'/'.$val->annee_fin;
                            }
                        //}
                            break;
                    }
                    else
                    {
                        //if ($k==0) echo ucfirst($mois[$val->mois_debut]).' '.$val->annee;
                        echo ucfirst($mois[$val->mois_debut]).' '.$val->annee;
                        //$k++;
                        break;
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
            elseif($value->billing_cycle == 2)
            {
                echo ucfirst($mois[$value->mois_debut]).' '.$value->annee;
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
        $data_contract = $contract->getNext_billing_date_dun_client($value->ID_client)->fetch();
        ?>
        </td>
        <td><?=round($value->montant_total).' '.$value->monnaie?></td>
        <td><?=$value->tva?></td>
        <td class="text-nowrap">
            <!--<a href="<= WEBROOT;?>detailFacture-<?= $value->facture_id;?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>-->
            <a href="<?=$WEBROOT;?>printfact-<?= $value->facture_id;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>
        <?php
        if ($m) 
        {
        ?>
            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
        <?php
        }
        ?>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lgg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modification de la facture</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-0" name="formaddClient">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3">
                                        <div class="row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date*</label><div class="form-group col-sm-9"><input type="date" class="form-control form-control-sm" id="datefacture<?=$i?>" value="<?=$value->date_creation?>"></div>
                                            <input type="text" id="facture_id<?=$i?>" value="<?=$value->facture_id?>" hidden>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="row"><label for="exampleInputuname3" class="col-sm-3 col-lg-6 control-label">Monnaie</label><div class="form-group col-sm-9 col-lg-6">
                                            <select class="form-control form-control-sm" id="monnaie<?=$i?>">
                                                <?php
                                for ($v=0; $v < count($tbMonnaie); $v++) 
                                { 
                                    if ($tbMonnaie[$v] == $value->monnaie)
                                    {
                                ?>
                                        <option value="<?php echo $tbMonnaie[$v];?>" selected><?php echo $tbMonnaie[$v];?></option>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                        <option value="<?php echo $tbMonnaie[$v];?>"><?php echo $tbMonnaie[$v];?></option>
                                <?php
                                    }
                                }
                                ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ($value->show_rate == 1) 
                                    {
                                    ?>
                                        <div class="col-lg-2 col-md-2">
                                            <div class="form-group">
                                                <label class="btn">
                                                    <input type="checkbox" id="afficheTaux<?=$i?>" checked=""> affiche taux
                                                </label> 
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <div class="col-lg-2 col-md-2">
                                            <div class="form-group">
                                                <label class="btn">
                                                    <input type="checkbox" id="afficheTaux<?=$i?>"> afficher taux
                                                </label> 
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    if ($value->enable_discounts ==1) 
                                    {
                                    ?>
                                        <div class="col-lg-3 col-md-2">
                                            <div class="form-group">
                                                <label class="btn">
                                                    <input type="checkbox" value="<?=$i?>" id="enable_discount<?=$i?>" checked > activer reduction
                                                </label> 
                                            </div>
                                        </div>
                                        <!--<div class="col-lg-2 col-md-2" id="divReduction<=$i?>">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction<=$i?>" value="<=$value->reduction?>" min="0"><span class="font-13 text-muted">e.g "99%"</span></div>
                                        </div>-->
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <div class="col-lg-3 col-md-2">
                                            <div class="form-group">
                                                <label class="btn">
                                                    <input type="checkbox" value="<?=$i?>" id="enable_discount<?=$i?>"> activer reduction
                                                </label> 
                                            </div>
                                        </div>
                                        <!--<div class="col-lg-2 col-md-2" id="divReduction<=$i?>" style="display: none;">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction<=$i?>" value="<=$value->reduction?>" min="0"><span class="font-13 text-muted">e.g "99%"</span></div>
                                        </div>-->
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 col-md-2 col-lg-1 col-xl-1 control-label">Client*</label>
                                            <div class="form-group col-sm-9 col-md-10 col-lg-10 col-xl-10">
                                                <input type="text" id="idclient<?=$i?>" class="form-control form-control-sm" value="<?='ID-'.$value->ID_client.'-'.$value->nom_client?>" disabled>
                                                <input type="text" id="idcontract<?=$i?>" value="<?=$data_contract['ID_contract']?>" hidden>
                                                <input type="text" id="next_billing_date<?=$i?>" value="<?=$data_contract['next_billing_date']?>" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                                <hr>

<?php 
$j = 0;
foreach ($contract->recupererServicesDunFacture($value->facture_id) as $value2)
{
    $j++;
    $y++;
?>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">
                Service</label><div class="form-group col-sm-9">
                    <input type="text" id="service<?=$y?>" value="<?=$value2->ID_service?>" hidden>
                    <input type="text" class="form-control form-control-sm" id="serviceName<?=$y?>" value="<?=$value2->nomService?>" disabled>
                    <input type="text" id="monnaiservice<?=$y?>" value="<?=$value2->monnaie?>" hidden>
                    <input type="text" name="idFs<?=$y?>" id="idFs<?=$y?>" value="<?=$value2->idFs?>" hidden>
                </div></div></div>
        <div class="col-lg-4 col-md-4">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant*</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" id="montant<?=$y?>" value="<?=$value2->montant?>">
                        <div class="input-group-prepend"><span class="input-group-text"><?=$value2->monnaie?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="col-sm-3 control-label">Quantite*</label>
            <div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="quantite<?=$y?>" value="<?=$value2->quantite?>"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-6 control-label">Bande passante</label><div class="form-group col-sm-9">
                    <div class="input-group">
                       <input type="number" id="bandeP<?=$y?>" class="form-control form-control-sm" value="<?=$value2->bande_passante?>">
                       <div class="input-group-prepend"><span class="input-group-text">Mbps</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
            <div class="form-group col-sm-9">
                <textarea class="form-control form-control-sm" id="description<?=$y?>"><?=$value2->description?>
                </textarea>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <label class="control-label">Billing cycle</label>
            <div class="form-group col-sm-9">
                <select class="form-control form-control-sm" id="Billing_cycle<?=$y?>" onchange="setBillingCycleContent($(this).val(),'<?=$y?>')">
                    <?php
                    if ($value2->billing_cycle == 0) 
                    {
                    ?>
                        <option value="0" selected="">jour</option>
                        <option value="1">mois</option>
                        <option value="2">une seule fois</option>
                    <?php
                    }
                    elseif ($value2->billing_cycle == 1) 
                    {
                    ?>
                        <option value="0">jour</option>
                        <option value="1" selected="">mois</option>
                        <option value="2">une seule fois</option>
                    <?php
                    }
                    else
                    {
                    ?>
                        <option value="0">jour</option>
                        <option value="1">mois</option>
                        <option value="2" selected="">une seule fois</option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div id="billingCycleContent<?=$y?>">
        <div>
            <?php
            if ($value2->billing_cycle == 0) 
            {
            ?>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <label class="control-label">Date debut</label>
                        <div class="form-group col-sm-9">
                            <input type="date" class="form-control form-control-sm" name="startDate" id="startDate<?=$y?>" value="<?=$value2->startDate?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="control-label">Date fin</label>
                        <div class="form-group col-sm-9">
                            <input type="date" class="form-control form-control-sm" name="endDate" id="endDate<?=$y?>" value="<?=$value2->endDate?>">
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <hr>
<?php
}
?>
<input type="text" id="nombreServiceUpdate<?=$i?>" value="<?=$j?>" hidden>
<input type="number" id="i<?=$i?>" value="<?=$i?>" hidden>
<input type="number" id="id_dernierService<?=$i?>" value="<?=$y?>" hidden>
                                <input type="text" id="billing_number<?=$i?>" value="<?=$value->billing_number?>" hidden="">
                                <input type="text" id="billing_date<?=$i?>" value="<?=$value->billing_date?>" hidden>
                                <div id="service_contener"></div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-3">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                                            <div class="form-group col-sm-9">
                                                <select id="mois<?=$i?>" class="form-control form-control-sm">
                                        <?php
                                        for ($l=1; $l < 13; $l++)
                                        {
                                            if ($l == $value->mois_debut)
                                            {
                                        ?>
                                                <option value="<?=$l?>" selected><?=$mois[$l]?></option>
                                        <?php
                                            } 
                                            else
                                            {
                                        ?>
                                                <option value="<?=$l?>"><?=$mois[$l]?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee*</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" id="annee<?=$i?>" value="<?=$value->annee?>" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
<div class="col-lg-2 col-md-2">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">TVA</label>
        <div class="form-group col-sm-9">
            <input type="number" class="form-control form-control-sm" id="tva<?=$i?>" value="<?=$value->tva?>">
        </div>
    </div>
</div>
<?php
if ($value->fixe_rate == 1) 
{
?>
<div class="col-lg-2 col-md-2">
    <div class="form-group">
        <label class="btn">
            <input type="checkbox" value="<?=$i?>" id="fixe_rate<?=$i?>" onclick="showHideFixedRateDiv(this)" checked> fixe taux
        </label> 
    </div>
</div>
<div class="col-lg-2 col-md-2" id="divTaux<?=$i?>">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Taux</label>
        <div class="form-group col-sm-9">
                <input type="number" class="form-control form-control-sm" id="taux<?=$i?>" value="<?=$value->exchange_rate?>">
        </div>
    </div>
</div>
<div class="col-lg-2 col-md-2" id="divMonnaie<?=$i?>">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
        <div class="form-group col-sm-9">
            <select class="form-control form-control-sm" id="exchange_currency<?=$i?>">
            <?php
                for ($v=0; $v < count($tbMonnaie); $v++) 
                { 
                    if ($tbMonnaie[$v] == $value->exchange_currency)
                    {
                ?>
                        <option value="<?php echo $tbMonnaie[$v];?>" selected><?php echo $tbMonnaie[$v];?></option>
                <?php
                    }
                    else
                    {
                ?>
                        <option value="<?php echo $tbMonnaie[$v];?>"><?php echo $tbMonnaie[$v];?></option>
                <?php
                    }
                }
            ?>
            </select>
        </div>
    </div>
</div>
<?php
}
else
{
?>
<div class="col-lg-2 col-md-2">
    <div class="form-group">
        <label class="btn">
            <input type="checkbox" value="<?=$i?>" id="fixe_rate<?=$i?>" onclick="showHideFixedRateDiv(this)"> fixe taux
        </label> 
    </div>
</div>
<div class="col-lg-2 col-md-2" style="display: none;" id="divTaux<?=$i?>">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Taux</label>
        <div class="form-group col-sm-9">
                <input type="number" class="form-control form-control-sm" id="taux<?=$i?>" value="<?=$value->exchange_rate?>">
        </div>
    </div>
</div>
<div class="col-lg-2 col-md-2" style="display: none;" id="divMonnaie<?=$i?>">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
        <div class="form-group col-sm-9">
            <select class="form-control form-control-sm" id="exchange_currency<?=$i?>">
            <?php
                for ($v=0; $v < count($tbMonnaie); $v++) 
                { 
                    if ($tbMonnaie[$v] == $value->exchange_currency)
                    {
                ?>
                        <option value="<?php echo $tbMonnaie[$v];?>" selected><?php echo $tbMonnaie[$v];?></option>
                <?php
                    }
                    else
                    {
                ?>
                        <option value="<?php echo $tbMonnaie[$v];?>"><?php echo $tbMonnaie[$v];?></option>
                <?php
                    }
                }
            ?>
            </select>
        </div>
    </div>
</div>
<?php
}
?>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <span id="msg-update"></span>
                            <button style="background-color: #8b4513" class="btn waves-effect text-left text-white" onclick="updateFacture($('#idclient<?=$i?>').val(),$('#facture_id<?=$i?>').val(),$('#datefacture<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#mois<?=$i?>').val(),$('#annee<?=$i?>').val(),$('#tva<?=$i?>').val(),$('#billing_number<?=$i?>').val(),$('#i<?=$i?>').val(),$('#id_dernierService<?=$i?>').val(),$('#idcontract<?=$i?>').val(),$('#next_billing_date<?=$i?>').val(),$('#billing_date<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>Modifier
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <?php
            if ($s) 
            {
            ?>
                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
            <?php
            }
            ?>

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
?>