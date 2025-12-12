<?php 

$i=0;
foreach($comptabilite->filtreVerssement($condition) as $value)
{
    $i++;
    ?>
    <tr>
                                <td><?php echo $value->date_operation?></td>
                                <td><?php echo $value->reference?></td>
                                <td><?php
                                echo $value->nom;
                                /*if($value->destination == 'banque')
                                {
                                    echo $comptabilite->getBanqueDunVersement($value->ID_versement)->fetch()['nom'];
                                }
                                else
                                {
                                    echo $comptabilite->getCaisseDunVersement($value->ID_versement)->fetch()['nomCaisse'];
                                }*/
                                ?></td>
                                <td><?php echo number_format($value->debit).' '.$value->monnaie?></td>
                                <td>
                                    <?php 
                                    $res = $comptabilite->getNombre_paiement_par_versement($value->id)->fetch();
                                    echo $res['nbPaiement'].' paiements';
                                    ?> 
                                </td>
                    <td class="text-nowrap">
                    <a href="<?=$WEBROOT;?>printVersement-<?=$value->id?>" data-toggle="tooltip" data-original-title="Voir"><i class="mdi mdi-printer"></i></a>

                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                    </a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lgs<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lgs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modification de versement</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal p-t-20">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <input type="text" id="idversement<?=$i?>" value="<?php echo $value->id.'-'.$value->monnaie?>" hidden>
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Banque</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="iddestination<?=$i?>">
                                                        <?php 
                                                foreach ($comptabilite->getBanqqueActive() as $data)
                                                {
                                                    if ($data->ID_banque == $value->ID_banque) 
                                                    {
                                                ?>
                                                        <option value="<?php echo $data->ID_banque."-".$data->montant."-".$data->monnaie."-".$data->nom?>" selected><?php echo $data->nom . "_" . $data->monnaie?>
                                                        </option>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                ?>
                                                        <option value="<?php echo $data->ID_banque."-".$data->montant."-".$data->monnaie."-".$data->nom?>"><?php echo $data->nom . "_" . $data->monnaie?>
                                                        </option>
                                                <?php
                                                    }
                                                }?>
                                                    </select>
                                                    <!--<input type="text" name="iddestination<=$i?>" id="iddestination<=$i?>" value="<=$comptabilite->getBanqueDunVersement($value->ID_versement)->fetch()['ID_banque']?>" hidden>
                                                    <input type="text" class="form-control" value="<=$comptabilite->getBanqueDunVersement($value->ID_versement)->fetch()['nom']?>">-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                              <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Reference</label>
                                                <div class="col-sm-9">
                                                  <input type="text" class="form-control"  id="reference<?=$i?>" value="<?=$value->reference?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date versement</label>
                                                <div class="col-sm-9">
                                                    <input type="date" class="form-control" value="<?=$value->date_operation?>" id="dateversement<?=$i?>">
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                <div class="col-lg-10 col-md-12">
                                <div class="form-group row">
                                    <label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label" class="btn"> Paiement </label>
                                    <div class="col-sm-9 col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span ></span></div>
                                            <?php
                                            foreach($comptabilite->getPaiements_attacher_a_un_versement($value->id) as $value2)
                                            {
                                                $j++;
                                            ?>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="<?=$value2->ID_paiement.'_'.$value2->montant.'_'.$value2->devise?>" id="update_pymt<?=$j?>" checked onclick="verifierSiPayementDecocher(this.id)">
                                                <label class="custom-control-label" for="update_pymt<?=$j?>"><?php echo $value2->datepaiement.$value2->nom_client.'_'.$value2->montant.'_'.$value2->devise?></label>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <input type="text" id="ancien_montant<?=$i?>" value="<?=$value->debit?>" hidden>
                                            <input type="text" id="etat<?=$i?>" value="<?=$value->etat?>" hidden>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" style="background-color: #7c4a2f" class="btn text-white" data-dismiss="modal"onclick="modifierVersement($('#idversement<?=$i?>').val(),$('#reference<?=$i?>').val(),$('#dateversement<?=$i?>').val(),$('#iddestination<?=$i?>').val(),$('#etat<?=$i?>').val())"> <i class="fa fa-check"></i>modifier ce versement</button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce versement</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="idversement_del<?=$i?>" value="<?=$value->id?>" hidden>
                            Voulez-vous supprimer ce versement?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteVerssement($('#idversement_del<?=$i?>').val(),$('#etat<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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