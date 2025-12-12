<?php
                            $i = 0;


                            foreach ($contract->getBalanceInitiales() as $value) 
                            {
                                $i++;
                            ?>
                                <tr>
                                    <td><?=$value->nom_client?></td>
                                    <td><?=$value->montant_total.'_'.$value->monnaie?></td>
                                    <td><?=$value->description?></td>
                                    <td><?=$value->date_creer?></td>
                                    <td>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                        <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg<?=$i?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modifier la balance initiale</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                  
                          <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
                                  <div class="form-group col-sm-9">
                                     <input type="text" name="numbalance<?=$i?>" id="numbalance<?=$i?>" value="<?=$value->id?>" hidden>
                                    <input type="text" class="form-control" value="<?=$value->nom_client?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Montant</label>
                                <div class="form-group col-sm-9">
                                    <input type="number" id="montantbalance<?=$i?>" class="form-control" value="<?=$value->montant_total?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
                                <div class="form-group col-sm-9">
                                    <select class="form-control" id="monnaiebalance<?=$i?>">
                                        <option value="<?=$value->monnaie?>"><?=$value->monnaie?></option>
                                        <option value="FC">FC</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
                                <div class="form-group col-sm-9">
                                    <input type="date" value="<?= $value->date_creer?>" class="form-control" id="datebalance<?=$i?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 form-group">
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <textarea rows="5"  class="form-control " id="note<?=$i?>"><?=$value->description?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                           <div class="modal-footer">
                            <span id="msg_update"></span>
                                <button type="button" class="btn btn-info waves-effect text-left" onclick="updateBallanceInitiale($('#numbalance<?=$i?>').val(),$('#montantbalance<?=$i?>').val(),$('#monnaiebalance<?=$i?>').val(),$('#datebalance<?=$i?>').val(),$('#note<?=$i?>').val())">Modifier
                                        </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                       
                    </div>
                       
                   
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
                            <h4 class="modal-title" id="mySmallModalLabel">Suppression de ballance</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            Voulez-vous vraiment supprimer cette </br> information ?
                            <input type="text" id="idDelete<?=$i?>" value="<?= $value->id?>" hidden>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger waves-effect text-left" onclick="deleteBallance($('#idDelete<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i>Supprimer
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
                            </form>
                            <?php
                            }
                            ?>