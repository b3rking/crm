<?php
$i = 0;
$y = 0;
$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
foreach ($contract->filtreProformats($condition) as $value) 
{
$i++;
?>
<tr>
    <td><?=$value->date_creation?></td>
    <td><?=$value->numero?></td>
    <td><a href="<?= $WEBROOT;?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->nom_client;?></b></a></td>
    <td>
        <?php
        $serviceName = ''; 
        foreach ($contract->recupererServicesDunProformat($value->facture_id) as $service1)
        {
            $serviceName .=$service1->nomService.', ';
        }
        echo rtrim($serviceName,', ');
        ?>
    </td>
    <td><?=ucfirst($mois[$value->mois_debut])?></td>
    <td><?=number_format(round($value->montant_total)).' '.$value->monnaie?></td>
    <td><?=$value->exchange_rate?></td>
    <td><?=$value->tva?></td>
    <td class="text-nowrap">
        <a href="<?= $WEBROOT;?>printProforma-<?= $value->facture_id;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>
        
        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

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
                        if ($value->enable_discounts == 1) 
                        {
                        ?>
                            <div class="col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <!--<input type="checkbox" value="<?=$i?>" id="enable_discount<?=$i?>" checked onclick="showhide_reduction_facture(this)"> activer reduction-->
                                        <input type="checkbox" value="<?=$i?>" id="enable_discount<?=$i?>" checked> activer reduction
                                    </label> 
                                </div>
                            </div>
                            <!--<div class="col-lg-2 col-md-2" id="divReduction<?=$i?>">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction<?=$i?>" value="<?=$value->reduction?>" min="0"><span class="font-13 text-muted">e.g "99%"</span></div>
                            </div>-->
                        <?php
                        }
                        else
                        {
                        ?>
                            <div class="col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <!--<input type="checkbox" value="<?=$i?>" id="enable_discount<?=$i?>" checked onclick="showhide_reduction_facture(this)"> activer reduction-->
                                        <input type="checkbox" value="<?=$i?>" id="enable_discount<?=$i?>"> activer reduction
                                    </label> 
                                </div>
                            </div>
                            <!--<div class="col-lg-2 col-md-2" id="divReduction<?=$i?>" style="display: none;">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction<?=$i?>" value="<?=$value->reduction?>" min="0"><span class="font-13 text-muted">e.g "99%"</span></div>
                            </div>-->
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if ($value->type_client == "potentiel") 
                    {
                    ?>
                        <input type="text" id="idclient<?=$i?>" value="<?=$value->ID_client?>" hidden>
                        <div class="row">
                            <div class="col-lg-3 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">Nom *</label>
                                <div class="form-group">
                                    <input type="text" id="nomclient<?=$i?>" class="form-control form-control-sm" value="<?=$value->nom_client?>">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label"> phone</label>
                                <div class="form-group">
                                    <input type="text" id="phone<?=$i?>" class="form-control form-control-sm" value="<?=$value->telephone?>">     
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">mail</label>
                                <div class="form-group">
                                    <input type="text" id="mailclient<?=$i?>" class="form-control form-control-sm" value="<?=$value->mail?>">        
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">Adresse</label>
                                <div class="form-group">
                                    <input type="text" id="adresse_client<?=$i?>" class="form-control form-control-sm"  value="<?=$value->adresse?>">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label for="exampleInputuname3" class="control-label">Localisation*</label>
                                <div class="form-group">
                                   <select  class="form-control form-control-sm" id="localisation<?=$i?>">
                                    <?php 
                                    foreach ($localisation->selectionLocalisation() as $loc)
                                    {
                                        if ($value->ID_localisation == $loc->ID_localisation)
                                        {
                                    ?>
                                            <option value="<?php echo $loc->ID_localisation?>" selected><?php echo $loc->nom_localisation?></option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?php echo $loc->ID_localisation?>"><?php echo $loc->nom_localisation?></option>
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
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="row">
                                    <label for="exampleInputEmail3" class="col-sm-3 col-md-2 col-lg-1 col-xl-1 control-label">Client*</label>
                                    <div class="form-group col-sm-9 col-md-10 col-lg-10 col-xl-10">
                                        <input type="text" id="nomclient<?=$i?>" class="form-control form-control-sm" value="<?=$value->nom_client?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden="">
                            <input type="text" id="idclient<?=$i?>" value="<?=$value->ID_client?>">
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label"> phone</label>
                                <div class="form-group">
                                    <input type="text" id="phone<?=$i?>" class="form-control form-control-sm" value="<?=$value->telephone?>">     
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">mail</label>
                                <div class="form-group">
                                    <input type="text" id="mailclient<?=$i?>" class="form-control form-control-sm" value="<?=$value->mail?>">        
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">Adresse</label>
                                <div class="form-group">
                                    <input type="text" id="adresse_client<?=$i?>" class="form-control form-control-sm"  value="<?=$value->adresse?>">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label for="exampleInputuname3" class="control-label">Localisation*</label>
                                <div class="form-group">
                                    <input type="text" id="localisation<?=$i?>" value="<?=$value->ID_localisation?>">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <hr>

<?php 
$j = 0;
foreach ($contract->recupererServicesDunProformat($value->facture_id) as $value2)
{
    $j++;
    $y++;
?>
    <div class="row">
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="control-label">
                Service
            </label>
            <div class="form-group">
                <select class="form-control form-control-sm" id="service<?=$y?>">
                    <?php
                    foreach ($service->recupererServices() as $value3) 
                    {
                        if ($value3->ID_service == $value2->ID_service) 
                        {
                    ?>
                            <option value="<?=$value3->ID_service.'-'.$value3->nomService?>" selected><?=$value3->nomService?></option>
                    <?php
                        }
                        else
                        {
                    ?>
                            <option value="<?=$value3->ID_service.'-'.$value3->nomService?>"><?=$value3->nomService?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <input type="text" id="monnaiservice<?=$y?>" value="<?=$value2->monnaie?>" hidden>
                <input type="text" name="idFs<?=$y?>" id="idFs<?=$y?>" value="<?=$value2->idFs?>" hidden>
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="control-label">Montant*</label>
            <div class="form-group">
                <input type="text" class="form-control form-control-sm" id="montant<?=$y?>" value="<?=$value2->montant?>">
            </div>
        </div>
        <div class="col-lg-1 col-md-3">
            <label for="exampleInputuname3" class="control-label">Quantite*</label>
            <div class="form-group"><input type="number" class="form-control form-control-sm" id="quantite<?=$y?>" value="<?=$value2->quantite?>"></div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="control-label">Bande passante</label>
            <div class="form-group">
               <input type="text" id="bandeP<?=$y?>" class="form-control form-control-sm" value="<?=$value2->bande_passante?>">
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label class="control-label">Billing cycle</label>
            <div class="form-group">
                <select class="form-control form-control-sm" id="Billing_cycle<?=$y?>">
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
        <div class="col-lg-3 col-md-3">
            <label for="exampleInputuname3" class="control-label">Description</label>
            <div class="form-group">
                <textarea class="form-control form-control-sm" id="description<?=$y?>"><?=$value2->description?>
                </textarea>
            </div>
        </div>
    </div>
    <?php
    if ($value2->billing_cycle == 0) 
    {
    ?>
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <label class="control-label">Date debut</label>
                <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="startDate" id="startDate<?=$y?>" value="<?=$value2->startDate?>">
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <label class="control-label">Date fin</label>
                <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="endDate" id="endDate<?=$y?>" value="<?=$value2->endDate?>">
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <hr>
<?php
}
?>
<input type="text" id="nombreServiceUpdate<?=$i?>" value="<?=$j?>" hidden>
<input type="number" id="i<?=$i?>" value="<?=$i?>" hidden>
<input type="number" id="id_dernierService<?=$i?>" value="<?=$y?>" hidden>
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
                <button style="background-color: #8b4513" class="btn waves-effect text-left text-white" onclick="updateProformat('<?=$value->type_client?>',$('#facture_id<?=$i?>').val(),$('#datefacture<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#mois<?=$i?>').val(),$('#annee<?=$i?>').val(),$('#tva<?=$i?>').val(),$('#i<?=$i?>').val(),$('#id_dernierService<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>Modifier
                    </button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger waves-effect text-left" onclick="deleteProformat($('#id_factureDelete<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i>Supprimer
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