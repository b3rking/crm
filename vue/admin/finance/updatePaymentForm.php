<div class="modal fade bs-example-modal-lg-paiement<?=$p?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title" id="myLargeModalLabel">Modification de paiement</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
        <div class="modal-body">
            <form class="form-horizontal p-t-20" >
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-1 control-label">Client</label>
                            <div class="col-sm-9 col-lg-10">
                                <input type="text" id="idclient_paiement<?=$p?>" class="form-control form-control-sm" value="<?=$data->Nom_client?>" disabled>
                                <input type="text" id="idclient<?=$p?>" value="<?=$data->ID_client?>" hidden>
                                <input type="text" id="idpaiement<?=$p?>" value="<?=$data->ID_paiement?>" hidden>
                                <input type="text" id="billing_number<?=$p?>" value="<?=$data->billing_number?>" hidden>
                                <input type="text" id="status<?=$p?>" value="<?=$data->status?>" hidden>
                                <div id="autocomplete_conteneur"></div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                        <div class="form-group">
                            <select id="facturepayer<?=$p?>" class="form-control" multiple="">
                                <?php
                                foreach ($comptabilite->getFacture_dun_payement($data->ID_paiement) as $value) 
                                {
                                ?>
                                    <option value="<?=$value->facture_id.'='.round($value->montant).'='.$value->monnaie.'='.$value->taux_change_courant.'='.$value->reste.'='.$value->mois_debut.'='.$value->annee.'='.$value->montant_payer.'='.$value->billing_date?>" selected>
                                        <?php echo 'No '.$value->numero.', mois: '.$value->mois_debut.'/'.$value->annee.', montant: '.round($value->montant).' '.$value->monnaie.', taux: '.$value->taux_change_courant?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Montant payé*</label>
                            <div class="col-sm-9 col-lg-7">
                                <!--<input type="number" class="form-control form-control-sm" id="montantpaye<?=$p?>" value="<?=$data->montant?>" <=$disabled?>>-->
                                <input type="number" class="form-control form-control-sm" id="montantpaye<?=$p?>" value="<?=$data->montant?>">
                                <input type="number" class="form-control form-control-sm" id="old_montant<?=$p?>" value="<?=$data->montant?>" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Monnaie*</label>
                            <div class="col-sm-9 col-lg-7">
                                <select class="form-control form-control-sm" id="monnaiepayement<?=$p?>">
                                    <?php
                                    for ($l=0; $l < count($tbMonnaie); $l++) 
                                    {
                                        if ($data->devise == $tbMonnaie[$l]) 
                                        {
                                    ?>
                                            <option value="<?=$tbMonnaie[$l]?>" selected><?=$tbMonnaie[$l]?></option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?=$tbMonnaie[$l]?>"><?=$tbMonnaie[$l]?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Taux*</label>
                            <div class="col-sm-9">
                                <input type="number"  class="form-control form-control-sm" id="taux_de_change<?=$p?>" value="<?=$data->Taux_change_courant?>" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Monnaie converti*</label>
                            <div class="col-sm-9 col-lg-7">
                                <select class="form-control form-control-sm" id="exchange_currencypayement<?=$p?>">
                                    <?php
                                    for ($l=0; $l < count($tbMonnaie); $l++) 
                                    {
                                        if ($data->exchange_currency == $tbMonnaie[$l]) 
                                        {
                                    ?>
                                            <option value="<?=$tbMonnaie[$l]?>" selected><?=$tbMonnaie[$l]?></option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?=$tbMonnaie[$l]?>"><?=$tbMonnaie[$l]?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <label for="exampleInputuname3" class="control-label">Mode* </label>
                        <div class="form-group">
                            <select class="form-control form-control-sm" id="methodepaiement<?=$p?>" onchange="getDestinationPaiementOnUpdate($(this).val(),'<?=$p?>')">
                                <?php
                                if ($data->methode == 'CASH') 
                                {
                            ?>
                                    <option value="CASH" selected="">CASH</option>
                                    <option value="CHEQUE">CHEQUE</option>
                                    <option value="TRANSFERT">TRANSFERT</option>
                            <?php
                                }
                                elseif($data->methode == 'CHEQUE')
                                {
                            ?>
                                    <option value="CASH">CASH</option>
                                    <option value="CHEQUE" selected="">CHEQUE</option>
                                    <option value="TRANSFERT">TRANSFERT</option>
                            <?php
                                }
                                elseif ($data->methode == 'TRANSFERT') 
                                {
                            ?>
                                    <option value="CASH">CASH</option>
                                    <option value="CHEQUE">CHEQUE</option>
                                    <option value="TRANSFERT" selected="">TRANSFERT</option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <label for="exampleInputuname3" class="control-label">Reference</label>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm"  id="reference<?=$p?>" value="<?=$data->reference?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="exampleInputuname3" class="control-label">Date* </label>
                        <div class="form-group">
                            <input type="date" class="form-control form-control-sm" value="<?php echo $data->datepaiement?>" id="datepaiements<?=$p?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="exampleInputuname3" class="control-label">Tci_(%) </label>
                        <div class="form-group">
                            <input type="number" class="form-control form-control-sm" value="<?=$data->tva?>" id="tva<?=$p?>">
                        </div>
                    </div>
                </div>
                <div id="conteneur_banque<?=$p?>">
                <?php
                if ($data->methode != 'CASH') 
                {
                ?>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
                            <label for="exampleInputuname3" class="control-label">Banque *</label>
                            <div class="form-group">
                                <select class="form-control form-control-sm" id="banque<?=$p?>">
                                    <option value=""></option>
                                    <?php 
                                    foreach ($comptabilite->getBanqqueActive() as $banque)
                                    {
                                        if ($data->ID_banque == $banque->ID_banque) 
                                        {
                                    ?>
                                            <option value="<?= $banque->ID_banque.'-'.$banque->monnaie?>" selected><?= $banque->nom . "_" . $banque->monnaie?>
                                            </option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?= $banque->ID_banque.'-'.$banque->monnaie?>"><?= $banque->nom . "_" . $banque->monnaie?>
                                            </option>
                                    <?php
                                        }
                                    }?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php
                }
                else
                {
                ?>
                    <div></div>
                <?php
                }
                ?>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" style="background-color: #8b4513" class="btn text-white waves-effect text-left"  data-dismiss="modal" onclick="update_paiement($('#idclient<?=$p?>').val(),$('#billing_number<?=$p?>').val(),$('#idpaiement<?=$p?>').val(),$('#montantpaye<?=$p?>').val(),$('#old_montant<?=$p?>').val(),$('#monnaiepayement<?=$p?>').val(),$('#methodepaiement<?=$p?>').val(),$('#reference<?=$p?>').val(),$('#tva<?=$p?>').val(),$('#datepaiements<?=$p?>').val(),$('#taux_de_change<?=$p?>').val(),$('#exchange_currencypayement<?=$p?>').val(),'<?=$p?>',$('#iduser').val(),$('#status<?=$p?>').val(),'<?=$data->deposed?>')"> <i class="fa fa-check"></i>Modifier</button>
            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
        </div>
    </div>
</div>
</div>