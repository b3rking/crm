<?php 
$tbMonnaie = ['USD','BIF'];
$i=0;
foreach($comptabilite->affichageBanque() as $value)
{
    $i++;
    ?>
    <tr>
        <!--<td><php echo $value->ID_banque?></td>-->
        <td><?php echo $value->nom?></td>
        <td><?php echo $value->numero?></td>
        <td><?php echo $value->montantVersser?></td>
        <td><?php echo $value->monnaie?></td>
        <!-- <td><php echo $value->tenucompte?></td>-->
        <td><?php echo $value->statut?></td>
        <td>
            <?php if ($value->affiche_numero =='OUI') 
            {
             ?>
                <span class="label label-success"><?php echo $value->affiche_numero?></span>
            <?php

            }
            elseif ($value->affiche_numero =='NON') 
                {?>
                <span class="label label-danger"><?php echo $value->affiche_numero?></span>
            <?php
            }
             ?>
        </td>
        <td><?php echo $value->date_creation?></td>
        <td class="text-nowrap">
        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
        <a href="<?=WEBROOT;?>detailbanque-<?php echo $value->ID_banque?>" data-toggle="tooltip"  data-original-title="Voir"><i class="fa fa-eye text-inverse m-r-10"></i></a>
        <!-- sample modal content -->
        <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Modifier cette banque</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal p-t-20">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <input type="text" id="idbank<?=$i?>" value="<?php echo $value->ID_banque?>" class="form-control" hidden>
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                            <input type="text" id="nombanque<?=$i?>" value="<?php echo $value->nom?>" class="form-control">
                           
                        </div>
                   </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label">Numero de compte</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div><input type="text" class="form-control" id="numerocompte<?=$i?>" value="<?php echo $value->numero?>">
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputuname3" class="col-sm-3 control-label">Montant initial</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                <input type="text" class="form-control" id="montantinitial<?=$i?>" value="<?php echo $value->montantVersser?>">
                               
                            </div>
                        </div> 
                    </div>
                </div>
            <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label">Monnaie</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"></span>
                            </div>
                            <select class="form-control" id="monnaie<?=$i?>">
                            <?php
                            for ($l=0; $i < count($tbMonnaie); $l++) 
                            {
                                if ($tbMonnaie == $value->monnaie) 
                                {
                            ?>
                                    <option value="<?=$tbMonnaie[$l]?>" selected>
                                    <?=$tbMonnaie[$l]?>
                                    </option>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <option value="<?=$tbMonnaie[$l]?>">
                                    <?=$tbMonnaie[$l]?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputuname3" class="col-sm-3 control-label">Statut</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                <select class="form-control" id="statut<?=$i?>">
                                <option value="<?php echo $value->statut?>"><?php echo $value->statut?></option>
                                <option value="active">active</option>
                                <option value="desactive">desactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
               
        <div class="col-lg-6 col-md-6">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">visible facture</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <div class="input-group-prepend"></div>
                        <select class="form-control" id="caseacocherviewinvoice<?=$i?>">
                        <?php
                        if ($value->affiche_numero == 'OUI') 
                        {
                        ?>
                            <option value="OUI" selected="">OUI</option>
                            <option value="NON">NON</option>
                        <?php
                        }
                        else
                        {
                        ?>
                            <option value="OUI">OUI</option>
                            <option value="NON" selected="">NON</option>
                        <?php
                        }
                        ?>
                        </select>
                        <!--<input type="text"  class="form-control"  id="caseacocherviewinvoice<?=$i?>" >
                        -<input type="text" id="i<?=$i?>" value="<?=$i?>" hidden>-->
                    
                    </div>
                </div>
            </div>
        </div>
        <span id="affichefacture"></span>
            <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                <input type="date" class="form-control"  id="datecreation<?=$i?>" value="<?php echo $value->date_creation?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- END ROW-->
            </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="update_compteBancaire($('#idbank<?=$i?>').val(),$('#nombanque<?=$i?>').val(),$('#numerocompte<?=$i?>').val(),$('#montantinitial<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#statut<?=$i?>').val(),$('#caseacocherviewinvoice<?=$i?>').val(),$('#datecreation<?=$i?>').val())"> <i class="fa fa-check"></i>modifier compte</button>
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette banque</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body" > 
                            <input type="text" class="form-control" id="clebank<?=$i?>" value="<?php echo $value->ID_banque?> " hidden=""><br>
                            <br>
                            Voulez-vous supprimer cette banque?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimercompteBanque($('#clebank<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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