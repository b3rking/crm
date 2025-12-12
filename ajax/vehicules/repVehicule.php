<?php 
$i =0;
foreach ($vehicule->afficheVehicule() as  $value)
{
    $i++; 
?>
    <tr>
        <td><?php echo $value->immatriculation?></td>
        <td><?php echo $value->modele?></td>
        <td><?php echo $value->marque?></td>
        <td>
            <button type="button" class="btn waves-effect waves-light btn-xs btn-success" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>">Edit
            </button>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">modifier vehicule</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">plaque</label>
                                            <div class="form-group col-sm-9">
                                                <input type="text" class="form-control" id="newplaque<?=$i?>" value="<?php echo $value->immatriculation?>">
                                                <input type="text" class="form-control" id="plaque<?=$i?>" value="<?php echo $value->immatriculation?>"hidden>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Modele</label>
                                            <div class="form-group col-sm-9">
                                                <input type="text" class="form-control" id="modele<?=$i?>" value="<?php echo $value->modele?>">
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                                <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Marque</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" class="form-control" id="marque<?=$i?>" value="<?php echo $value->marque?>">
                                        </div>
                                    </div>
                                </div>
                                </div><!-- End row-->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success waves-effect text-left" onclick="updateVehicule($('#plaque<?=$i?>').val(),$('#newplaque<?=$i?>').val(),$('#modele<?=$i?>').val(),$('#marque<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>modifier vehicule
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </td>
        <td>
        <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>">Del</button>
        <!-- sample modal content -->
        <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="mySmallModalLabel">Supprimer vehicule</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body"> 
        <input type="text" class="form-control" id="idservice<?= $i?>" value="<?php echo $value->ID_service?>" hidden>
        Voulez-vous supprimer ce vehicule?<br>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteVehicule($('#plaque<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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