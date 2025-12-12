<?php
                            $i =0;
                            foreach ($marketing->afficheStockmarketing() as $value)
                            {
                                $i++;
                                ?>
                                <tr>
                                <td><?php echo $value->ID_stock?></td>
                                <td><?php echo $value->materiels?></td>
                                <td><?php echo $value->quantite?></td>
                                <td class="text-nowrap">
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier ce materiel</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                               <form class="form-horizontal p-t-20">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Materiel</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"></span>
                                                    </div>
                                                    <input type="text" id="idstockmarketing<?=$i?>" class="form-control" value="<?php echo $value->ID_stock?>"hidden>
                                                    <input type="text" id="materiels<?=$i?>" class="form-control" value="<?php echo $value->materiels?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                    <input type="number" id="quantite<?=$i?>" value="<?php echo $value->quantite?>" class="form-control" >
                                                     <input type="text" id="idstockmarketing<?=$i?>" value="<?php echo $value->ID_stock?>" class="form-control" hidden>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" onclick="updatestock($('#idstockmarketing<?=$i?>').val(),$('#materiels<?=$i?>').val(),$('#quantite<?=$i?>').val())" data-dismiss="modal">Modifier
                            </button>
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
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce materiel </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="idstockmarketing<?= $i?>" value="<?php echo $data->ID_stock?>" hidden>
                            Voulez-vous supprimer ce materiel<br> dans le stock?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerstock($('#idstockmarketing<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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