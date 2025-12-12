 <?php 
                              $i =0;
                              foreach($equipement->recupereRouteur() as $value)
                    {
                        $i++;
                    ?>
                       <tr>
                            <!--td><php echo $value->ID_equipement?></td-->
                            <td><?php echo $value->fabriquant?> </td>
                            <td><?php echo $value->type_equipement?></td>
                            <td><?php echo $value->model?></td>
                            <td>
                                <?php
                                    foreach ($equipement->recupereMacAdresses($value->ID_equipement) as $mac) 
                                    {
                                        echo "$mac->mac <br>";
                                    }
                                ?>
                            </td>
                            
                            <td><?=$value->date_stock?></td> 
                            <td>
                               
                                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <!--<button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>">edit</button>-->
                             

                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">modifier routeur</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal p-t-20">
                                  
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">ID equipement </label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                    <input type="text" id="type_equipement<?=$i?>" value="<?php echo $value->type_equipement?>" class="form-control" hidden >
                                                    <input type="text" class="form-control" id="id<?=$i?>" value="<?php echo $value->ID_equipement?>">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                 <label for="exampleInputEmail3" class="col-sm-3 control-label">Model</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                        <input type="text" id="model<?=$i?>" value="<?php echo $value->model?>" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Fabriquant</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                        <input type="text" id="fabriquant<?=$i?>" class="form-control" value="<?php echo $value->fabriquant?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">mac adresse</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                        <input type="text" class="form-control"id="mac<?= $i?>" value="<?php echo $mac->mac?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- END ROW-->
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-success" onclick="updateRouteur($('#id<?=$i?>').val(),$('#model<?=$i?>').val(),$('#fabriquant<?=$i?>').val(),$('#type_equipement<?=$i?>').val(),$('#mac<?=$i?>').val())"> <i class="fa fa-check"></i>
                                 Modifier routeur
                                </button>
                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button> 
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!--/.modal-dialog -->
                </div>
                </td>

                <td>
                    
                         <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                <!-- <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>"><i class="mdi mdi-delete-forever"></i></button>-->
                    

                    <!-- sample modal content -->
                    <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer routeur</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                             </div>
                            <div class="modal-body"> 
                                <input type="text" class="form-control" id="idequipement<?=$i?>" value="<?php echo $value->ID_equipement?>" hidden>
                                Voulez-vous supprimer ce routeur?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerRouteur($('#idequipement<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button> 
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