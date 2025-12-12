 <?php
                                $i = 0;
                                   foreach ($localisation->nombreClientParLocalisation() as $value) 
                                           {
                                            $i++;
                                            $Nombreclient[] = $value;
                                            ?>
                                    <td><?php echo $value->nom_localisation?></td>
                                    <td><?php echo $value->nb?></td>

                                <td class="text-nowrap">
                                     
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                     
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier cette localisation</h4>
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
                                                    <input type="text" class="form-control" id="idlocalisation<?=$i?>" value="<?php echo $value->ID_localisation?>"hidden>
                                                    <input type="text" class="form-control" id="locationS<?=$i?>" value="<?php echo $value->nom_localisation?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div><!-- END ROW-->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success waves-effect text-left" onclick="Updatelocalisation($('#idlocalisation<?= $i?>').val(),$('#locationS<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>modifier cette localisation
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
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette localisation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="idlocalisation<?= $i?>" value="<?php echo $data->ID_localisation?>" hidden>
                            Voulez-vous supprimer cette localisation?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletelocalisation($('#idlocalisation<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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