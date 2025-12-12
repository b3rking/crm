<?php 
                    $i = 0;
                    foreach ($comptabilite->affichage_clientAvec_contratpayant_lafacture() as $data)
                    {
                        $i++;
                    ?>
                       <tr>
                        <td><?php echo $data->datepaiement?></td>
                        <td><?php echo $data->ID_paiement?></td>
                        <td><a href="<?= WEBROOT;?>detailClient-<?= $data->ID_client;?>"><b><?php echo $data->Nom_client.'-'.$data->billing_number;?></b></a></td>
                        <td><?php echo $data->montant.' '.$data->devise?></td>
                        <td><?php echo $data->Taux_change_courant?></td>
                        <td><?php echo $data->montant?></td>
                        <td><?php echo $data->methode .'-'.$data->reference?></td>
                        <td><?php echo $data->facture_id?></td>
                        
                        <td class="text-nowrap">
                    <a href="<?=WEBROOT;?>recu_paiement_facture-<?=$data->ID_paiement?>" data-toggle="tooltip"  data-original-title="Print"><i class="mdi mdi-printer"></i></a> 
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title" id="myLargeModalLabel">Modification de paiement</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
        <div class="modal-body">
            <form class="form-horizontal p-t-20" >
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Client</label>
                            <div class="col-sm-9 col-lg-10">
                                <input type="text" id="idclient_paiement<?=$i?>" class="form-control" value="<?=$data->Nom_client?>" disabled>
                                <input type="text" id="idclient<?=$i?>" value="<?=$data->ID_client?>" hidden>
                                <input type="text" id="idpaiement<?=$i?>" value="<?=$data->ID_paiement?>" hidden>
                                <div id="autocomplete_conteneur"></div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-12 col-xlg-12">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Factures</label>
                            <div class="col-sm-9 col-lg-10">
                                <select id="facturepaye<?=$i?>" class="form-control" multiple="" >
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xlg-6">
                        <span id="totalPaier"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Montant payé</label>
                            <div class="col-sm-9 col-lg-7">
                                <input type="number" class="form-control" id="montantpaye<?=$i?>" value="<?=$data->montant?>">
                                <input type="number" class="form-control" id="old_montant<?=$i?>" value="<?=$data->montant?>" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Monnaie</label>
                            <div class="col-sm-9 col-lg-7">
                                <select class="form-control" id="monnaie<?=$i?>">
                                    <option value="$data->devise"><?=$data->devise?></option>>
                                    <option value="FC">FC</option>
                                    <option value="USD" selected="">USD</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Mode paiement</label>
                            <div class="col-sm-9 col-lg-7">
                                <select class="form-control" id="methodepaiement<?=$i?>">
                                <option value="<?=$data->methode?>"><?=$data->methode?></option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="transfert">Transfert</option>
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Reference</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"></div>
                                    <input type="text" class="form-control"  id="reference<?=$i?>" value="<?=$data->reference?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row" >
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date paiement</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="date" class="form-control" value="<?php echo $data->datepaiement?>" id="datepaiements<?=$i?>">
                                    <input type="text" id="iduser<?=$i?>"  value="<?php echo $_SESSION['ID_user']?>" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary waves-effect text-left"  data-dismiss="modal" onclick="update_paiement($('#idclient<?=$i?>').val(),$('#idpaiement<?=$i?>').val(),$('#old_montant<?=$i?>').val(),$('#montantpaye<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#methodepaiement<?=$i?>').val(),$('#reference<?=$i?>').val(),$('#datepaiements<?=$i?>').val(),$('#iduser<?=$i?>').val())"> <i class="fa fa-check"></i>Ajouter du paiment</button>
            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
        </div>
    </div>
</div>
</div>
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

                    <!-- sample modal content -->
<div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer paiement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="idpaiement_del-<?= $i?>" value="<?php echo $data->ID_paiement?>" hidden>
                Voulez-vous supprimer ce paiement?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletePaiement($('#idpaiement_del-<?= $i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
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