 <?php 
    $i =0; 
    foreach ($equipement->afficheEtat_stock_carbrant() as$value) 
    { $i++; 
    ?>
        <tr>
            <td><?php echo $value->ID_stock_carburant?></td>
            <td><?php echo $value->nature?></td>
            <td><?php echo $value->quantite?></td>
            <td><?php echo $value->prix_par_litre?></td>
            <td><?php echo $value->datestock?></td>
            <td class="text-nowrap">
                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                 <a href="<?=$WEBROOT;?>detailcarburant-<?php echo $value->nature?>" data-toggle="tooltip"  data-original-title="Voir"><i class="fa fa-eye text-inverse m-r-10"></i></a>
                </a>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modifier stock carburant</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                    <div class="modal-body">
                        <form class="form-horizontal p-t-20">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Nature* </label><input type="text" id="refstock<?=$i?>" value ="<?php echo $value->ID_stock_carburant?>" hidden>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                <select class="form-control" id="refnature<?=$i?>">
                                                    <option value="<?php echo $value->nature?>"><?php echo $value->nature?></option>
                                                    <option value="essence">Essence</option>
                                                    <option value="mazout">Mazout</option>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite*</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"></div>
                                                <input type="number" class="form-control" id="refnblitre<?=$i?>" value ="<?php echo $value->quantite?>"><span class="input-group-text">litres</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End row-->
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Prix achat*</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa-plus-circle"></i></span></div>
                                                <input type="text" class="form-control" id="refprix_achat<?=$i?>" value ="<?php echo $value->prix_par_litre?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date*</label>
                                            <div class="col-sm-9">   
                                                <div class="form-group">
                                                    <input type="date" class="form-control custom-select" id="refdatesachat<?=$i?>" value ="<?php echo $value->datestock?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="modifier_stock_carburant($('#refstock<?=$i?>').val(),$('#refnature<?=$i?>').val(),$('#refnblitre<?=$i?>').val(),$('#refprix_achat<?=$i?>').val(),$('#refdatesachat<?=$i?>').val())"> <i class="fa fa-check"></i>modifier cette distribution</button>
                           
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
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce stock</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                        <input type="text" class="form-control" id="num_stock<?=$i?>" value="<?php echo $value->ID_stock_carburant?>"hidden><br>
                        <br>
                        Voulez-vous supprimer ce stock?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="suppressionstockCarburant($('#num_stock<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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