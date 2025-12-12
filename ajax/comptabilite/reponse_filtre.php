
<?php
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
} 
$i = 0;
$y = 0;
foreach ($comptabilite->filtrePayement($condition) as $data)
{
    $i++;
?>
    <tr>
        <td><?php echo $data->datepaiement?></td>
        <td><?php echo $data->numero?></td>
        <td><a href="<?= $WEBROOT;?>detailClient-<?= $data->ID_client;?>"><b><?php echo $data->Nom_client.'-'.$data->billing_number;?></b></a></td>
        <td><?php echo number_format($data->montant).' '.$data->devise?></td>
        <td><?php echo $data->Taux_change_courant?></td>
        <td><?php echo number_format($data->montant_converti).' '.$data->exchange_currency?></td>
        <td><?php echo $data->methode .'-'.$data->reference?></td>
        <td><?php
        $nb_facture_payer = 0;
        foreach ($comptabilite->getFacture_dun_payement($data->ID_paiement) as $val) 
        {
            $nb_facture_payer ++;
            echo $val->numero."\n";
        }
        ?></td>
                        
        <td class="text-nowrap">
            <a href="<?=$WEBROOT;?>historique-payement-<?=$data->ID_paiement?>" data-toggle="tooltip"  data-original-title="historique"><i class="mdi mdi-eye m-r-10"></i>
            </a>
            <a href="<?=$WEBROOT;?>recu_paiement_facture-<?=$data->ID_paiement?>" data-toggle="tooltip"  data-original-title="Print"><i class="mdi mdi-printer m-r-10"></i>
            </a>
            <?php
            if ($m) 
            {
            ?>
            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
            <?php
            }
            ?>
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
                    <div class="col-lg-12 col-md-8">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-1 control-label">Client</label>
                            <div class="col-sm-9 col-lg-10">
                                <input type="text" id="idclient_paiement<?=$i?>" class="form-control form-control-sm" value="<?=$data->Nom_client?>" disabled>
                                <input type="text" id="idclient<?=$i?>" value="<?=$data->ID_client?>" hidden>
                                <input type="text" id="idpaiement<?=$i?>" value="<?=$data->ID_paiement?>" hidden>
                                <input type="text" id="billing_number<?=$i?>" value="<?=$data->billing_number?>" hidden>
                                <input type="text" id="status<?=$i?>" value="<?=$data->status?>" hidden>
                                <div id="autocomplete_conteneur"></div>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                        <div class="form-group">
                            <select id="facturepayer<?=$i?>" class="form-control" multiple="">
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
                                <input type="number" class="form-control form-control-sm" id="montantpaye<?=$i?>" value="<?=$data->montant?>">
                                <input type="number" class="form-control form-control-sm" id="old_montant<?=$i?>" value="<?=$data->montant?>" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Monnaie*</label>
                            <div class="col-sm-9 col-lg-7">
                                <select class="form-control form-control-sm" id="monnaie<?=$i?>">
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
                                <input type="number"  class="form-control form-control-sm" id="taux_de_change<?=$i?>" value="<?=$data->Taux_change_courant?>" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Monnaie converti*</label>
                            <div class="col-sm-9 col-lg-7">
                                <select class="form-control form-control-sm" id="exchange_currency<?=$i?>">
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
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Mode* </label>
                            <div class="col-sm-9 col-lg-7">
                                <select class="form-control form-control-sm" id="methodepaiement<?=$i?>">
                                <option value="<?=$data->methode?>"><?=$data->methode?></option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="transfert">Transfert</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Reference</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"></div>
                                    <input type="text" class="form-control form-control-sm"  id="reference<?=$i?>" value="<?=$data->reference?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group row" >
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date* </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="date" class="form-control form-control-sm" value="<?php echo $data->datepaiement?>" id="datepaiements<?=$i?>">
                                    <input type="text" id="iduser<?=$i?>"  value="<?= $iduser?>" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" style="background-color: #8b4513" class="btn text-white waves-effect text-left"  data-dismiss="modal" onclick="update_paiement($('#idclient<?=$i?>').val(),$('#billing_number<?=$i?>').val(),$('#idpaiement<?=$i?>').val(),$('#montantpaye<?=$i?>').val(),$('#old_montant<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#methodepaiement<?=$i?>').val(),$('#reference<?=$i?>').val(),$('#datepaiements<?=$i?>').val(),$('#taux_de_change<?=$i?>').val(),$('#exchange_currency<?=$i?>').val(),'<?=$i?>',$('#iduser<?=$i?>').val(),$('#status<?=$i?>').val())"> <i class="fa fa-check"></i>Modifier</button>
            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
        </div>
    </div>
</div>
</div>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer paiement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="idpaiement_del-<?= $i?>" value="<?php echo $data->ID_paiement?>" hidden>
                <input type="text" id="del_idclient<?=$i?>" value="<?=$data->ID_client?>" hidden>
                Voulez-vous supprimer ce paiement?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletePaiement($('#idpaiement_del-<?= $i?>').val(),$('#del_idclient<?=$i?>').val(),$('#old_montant<?=$i?>').val(),$('#status<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
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


