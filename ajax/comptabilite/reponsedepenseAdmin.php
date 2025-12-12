<?php
$i =0;
foreach ($comptabilite->getDepenses() as $value) 
    {
    $i++;?>
<tr>
    <td><?php echo $value->nomCaisse?></td>
    <td><?php echo $value->montantdepense?></td>
    <td><?php echo $value->motifdepense?></td>
    <!--<td><php echo $value->ID_user?></td>-->
    <td><?php echo $value->datedepense?></td>
    <td class="text-nowrap">
    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modifier cette depense</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                           <form class="form-horizontal p-t-20">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Montant</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"></span>
                                                </div>
                                               <input type="text" id="refdepensedep<?=$i?>" class="form-control" value="<?php echo $value->ID_depense?>"hidden>
                                                <input type="text" id="montantdep<?=$i?>" class="form-control" value="<?php echo $value->montantdepense?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                <input type="date" id="datedepensedep<?=$i?>" value="<?php echo $value->datedepense?>" class="form-control" >
                                                 
                                            </div>
                                       </div>
                                    </div>
                                </div>
                                     
                                <textarea class="form-control" maxlength="60" id="motifsdep<?=$i?>"> <?php echo $value->motifdepense?></textarea>
                                
                            </div><!-- END ROW-->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" onclick="updatedepense($('#refdepensedep<?=$i?>').val(),$('#montantdep<?=$i?>').val(),$('#datedepensedep<?=$i?>').val(),$('#motifsdep<?=$i?>').val())" data-dismiss="modal">Modifier
                        </button>
                        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm2<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

        <!-- sample modal content -->
        <div class="modal fade bs-example-modal-sm2<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette depense </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body"> 
                        <input type="text" class="form-control" id="id_depnsedel<?=$i?>" value="<?php echo $value->ID_depense?>" hidden>
                        Voulez-vous supprimer cette depense ?<br> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerdepense($('#id_depnsedel<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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