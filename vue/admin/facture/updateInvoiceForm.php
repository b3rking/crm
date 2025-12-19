<div class="modal fade bs-example-modal-lgg<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
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
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date*</label>
                                <div class="form-group col-sm-9"><input type="date" class="form-control form-control-sm" id="datefacture<?= $i ?>" value="<?= $value->date_creation ?>"></div>
                                <input type="text" id="facture_id<?= $i ?>" value="<?= $value->facture_id ?>" hidden>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="row"><label for="exampleInputuname3" class="col-sm-3 col-lg-6 control-label">Monnaie</label>
                                <div class="form-group col-sm-9 col-lg-6">
                                    <select class="form-control form-control-sm" id="monnaie<?= $i ?>">
                                        <?php
                                        for ($v = 0; $v < count($tbMonnaie); $v++) {
                                            if ($tbMonnaie[$v] == $value->monnaie) {
                                        ?>
                                                <option value="<?php echo $tbMonnaie[$v]; ?>" selected><?php echo $tbMonnaie[$v]; ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?php echo $tbMonnaie[$v]; ?>"><?php echo $tbMonnaie[$v]; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($value->show_rate == 1) {
                        ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" id="afficheTaux<?= $i ?>" checked=""> affiche taux
                                    </label>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" id="afficheTaux<?= $i ?>"> afficher taux
                                    </label>
                                </div>
                            </div>
                        <?php
                        }
                        if ($value->enable_discounts == 1) {
                        ?>
                            <div class="col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" value="<?= $i ?>" id="enable_discount<?= $i ?>" checked> activer reduction
                                    </label>
                                </div>
                            </div>
                            <!--<div class="col-lg-2 col-md-2" id="divReduction<=$i?>">
											<label for="exampleInputuname3" class="col-sm-3 control-label">Reduction(%)</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction<=$i?>" value="<=$value->reduction?>" min="0"></div>
										</div>-->
                        <?php
                        } else {
                        ?>
                            <div class="col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" value="<?= $i ?>" id="enable_discount<?= $i ?>"> activer reduction
                                    </label>
                                </div>
                            </div>
                            <!--<div class="col-lg-2 col-md-2" id="divReduction<=$i?>">
											<label for="exampleInputuname3" class="col-sm-3 control-label">Reduction(%)</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction<=$i?>" value="<=$value->reduction?>" min="0"></div>
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
                                    <input type="text" id="idclient<?= $i ?>" class="form-control form-control-sm" value="<?= 'ID-' . $value->ID_client . '-' . $value->nom_client ?>" disabled>
                                    <input type="text" id="idcontract<?= $i ?>" value="<?= $data_contract['ID_contract'] ?>" hidden>
                                    <input type="text" id="next_billing_date<?= $i ?>" value="<?= $data_contract['next_billing_date'] ?>" hidden>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <hr>

                    <?php
                    $j = 0;
                    foreach ($contract->recupererServicesDunFacture($value->facture_id) as $value2) {
                        $j++;
                        $y++;
                    ?>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="row">
                                    <label for="exampleInputuname3" class="col-sm-3 control-label">
                                        Service</label>
                                    <div class="form-group col-sm-9">
                                        <!--<input type="text" id="service<=$value->facture_id.$j?>" value="<=$value2->ID_service?>" hidden>
    				<input type="text" class="form-control form-control-sm" id="serviceName<=$value->facture_id.$j?>" value="<=$value2->nomService?>" disabled>
    				<input type="text" id="monnaiservice<=$value->facture_id.$j?>" value="<=$value2->monnaie?>" hidden>-->
                                        <input type="text" name="idFs<?= $value->facture_id . $j ?>" id="idFs<?= $value->facture_id . $j ?>" value="<?= $value2->idFs ?>" hidden>
                                        <select class="form-control form-control-sm" id="service<?= $value->facture_id . $j ?>">
                                            <?php
                                            foreach ($service->recupererServices() as $val) {
                                                if ($value2->ID_service == $val->ID_service) {
                                            ?>
                                                    <option value="<?= $val->ID_service . '-' . $val->nomService ?>" selected><?= $val->nomService ?></option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="<?= $val->ID_service . '-' . $val->nomService ?>"><?= $val->nomService ?></option>
                                                <?php
                                                }
                                                ?>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="form-group row">
                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Montant*</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" id="montant<?= $value->facture_id . $j ?>" value="<?= $value2->montant ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Quantite*</label>
                                <div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="quantite<?= $value->facture_id . $j ?>" value="<?= $value2->quantite ?>"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="row">
                                    <label for="exampleInputuname3" class="col-sm-6 control-label">Bande passante</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" id="bandeP<?= $value->facture_id . $j ?>" class="form-control form-control-sm" value="<?= $value2->bande_passante ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
                                <div class="form-group col-sm-9">
                                    <textarea class="form-control form-control-sm" id="description<?= $value->facture_id . $j ?>"><?= $value2->description ?>
				</textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <label class="control-label">Billing cycle</label>
                                <div class="form-group col-sm-9">
                                    <select class="form-control form-control-sm" id="Billing_cycle<?= $value->facture_id . $j ?>" onchange="setBillingCycleContent($(this).val(),'<?= $value->facture_id . $j ?>')">
                                        <?php
                                        if ($value2->billing_cycle == 0) {
                                        ?>
                                            <option value="0" selected="">jour</option>
                                            <option value="1">mois</option>
                                            <option value="2">une seule fois</option>
                                        <?php
                                        } elseif ($value2->billing_cycle == 1) {
                                        ?>
                                            <option value="0">jour</option>
                                            <option value="1" selected="">mois</option>
                                            <option value="2">une seule fois</option>
                                        <?php
                                        } else {
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
                        <div id="billingCycleContent<?= $value->facture_id . $j ?>">
                            <div>
                                <?php
                                if ($value2->billing_cycle == 0) {
                                ?>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <label class="control-label">Date debut</label>
                                            <div class="form-group col-sm-9">
                                                <input type="date" class="form-control form-control-sm" name="startDate" id="startDate<?= $value->facture_id . $j ?>" value="<?= $value2->startDate ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <label class="control-label">Date fin</label>
                                            <div class="form-group col-sm-9">
                                                <input type="date" class="form-control form-control-sm" name="endDate" id="endDate<?= $value->facture_id . $j ?>" value="<?= $value2->endDate ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2" id="divReduction0">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction(%)</label>
                            <div class="form-group col-sm-9">
                                <input type="number" class="form-control form-control-sm" id="reduction<?= $value->facture_id . $j ?>" value="<?= $value2->rediction ?>" min="0">
                            </div>
                        </div>
                        <hr>
                    <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-2">
                            <input type="text" id="nbservice" value="1" hidden="">
                            <button type="button" style="background-color: #7c4a2f" class="btn text-white " onclick="ajoutServiceToUpdateFacture('<?= $value->facture_id ?>','<?= $i ?>')">
                                Service
                                <i class="ti-plus text"></i>
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div id="service_contener<?= $i ?>"></div>
                    <input type="text" id="nombreServiceUpdate<?= $i ?>" value="<?= $j ?>" hidden>
                    <input type="number" id="i<?= $i ?>" value="<?= $i ?>" hidden>
                    <input type="number" id="id_dernierService<?= $i ?>" value="<?= $y ?>" hidden>
                    <input type="text" id="billing_number<?= $i ?>" value="<?= $value->billing_number ?>" hidden="">
                    <input type="text" id="billing_date<?= $i ?>" value="<?= $value->billing_date ?>" hidden>
                    <div id="service_contener"></div>
                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                                <div class="form-group col-sm-9">
                                    <select id="mois<?= $i ?>" class="form-control form-control-sm">
                                        <?php
                                        for ($l = 1; $l < 13; $l++) {
                                            if ($l == $value->mois_debut) {
                                        ?>
                                                <option value="<?= $l ?>" selected><?= $mois[$l] ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?= $l ?>"><?= $mois[$l] ?></option>
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
                                    <input type="number" id="annee<?= $i ?>" value="<?= $value->annee ?>" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">TVA</label>
                                <div class="form-group col-sm-9">
                                    <input type="number" class="form-control form-control-sm" id="tva<?= $i ?>" value="<?= $value->tva + $value->tvci ?>">
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($value->fixe_rate == 1) {
                        ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" value="<?= $i ?>" id="fixe_rate<?= $i ?>" onclick="showHideFixedRateDiv(this)" checked> fixe taux
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2" id="divTaux<?= $i ?>">
                                <div class="row">
                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Taux</label>
                                    <div class="form-group col-sm-9">
                                        <input type="number" class="form-control form-control-sm" id="taux<?= $i ?>" value="<?= $value->exchange_rate ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2" id="divMonnaie<?= $i ?>">
                                <div class="row">
                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
                                    <div class="form-group col-sm-9">
                                        <select class="form-control form-control-sm" id="exchange_currency<?= $i ?>">
                                            <?php
                                            for ($v = 0; $v < count($tbMonnaie); $v++) {
                                                if ($tbMonnaie[$v] == $value->exchange_currency) {
                                            ?>
                                                    <option value="<?php echo $tbMonnaie[$v]; ?>" selected><?php echo $tbMonnaie[$v]; ?></option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="<?php echo $tbMonnaie[$v]; ?>"><?php echo $tbMonnaie[$v]; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" value="<?= $i ?>" id="fixe_rate<?= $i ?>" onclick="showHideFixedRateDiv(this)"> fixe taux
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2" style="display: none;" id="divTaux<?= $i ?>">
                                <div class="row">
                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Taux</label>
                                    <div class="form-group col-sm-9">
                                        <input type="number" class="form-control form-control-sm" id="taux<?= $i ?>" value="<?= $value->exchange_rate ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2" style="display: none;" id="divMonnaie<?= $i ?>">
                                <div class="row">
                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
                                    <div class="form-group col-sm-9">
                                        <select class="form-control form-control-sm" id="exchange_currency<?= $i ?>">
                                            <?php
                                            for ($v = 0; $v < count($tbMonnaie); $v++) {
                                                if ($tbMonnaie[$v] == $value->exchange_currency) {
                                            ?>
                                                    <option value="<?php echo $tbMonnaie[$v]; ?>" selected><?php echo $tbMonnaie[$v]; ?></option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value="<?php echo $tbMonnaie[$v]; ?>"><?php echo $tbMonnaie[$v]; ?></option>
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
                <span id="msg-update"></span> <label class="btn" style="margin-left:6px;"><input type="checkbox" id="no_ott<?= $i ?>" <?= ($value->exempt_ott == 1 ? 'checked' : '') ?>> Exonérer OTT</label>
                <button style="background-color: #7c4a2f" class="btn text-white waves-effect text-left" onclick="updateFacture($('#idclient<?= $i ?>').val(),$('#facture_id<?= $i ?>').val(),$('#datefacture<?= $i ?>').val(),$('#monnaie<?= $i ?>').val(),$('#mois<?= $i ?>').val(),$('#annee<?= $i ?>').val(),$('#tva<?= $i ?>').val(),$('#billing_number<?= $i ?>').val(),$('#i<?= $i ?>').val(),$('#id_dernierService<?= $i ?>').val(),$('#idcontract<?= $i ?>').val(),$('#next_billing_date<?= $i ?>').val(),$('#billing_date<?= $i ?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>Modifier
                </button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>