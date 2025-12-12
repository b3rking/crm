<?php 
    $i =0;
    foreach ($user->afficheUser() as  $value)
    {
       $i++; 
    ?>
       <tr>
        <td><?php echo $value->ID_user?></td>
        <td><?php echo $value->nom_user?></td>
        <td><?php echo $value->email?></td>
        <td><?php echo $value->role?></td>
        <td>
            <button type="button" class="btn waves-effect waves-light btn-xs btn-success" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>">Edit</button>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Modifier utilisateur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                     <!-- Debut premiere ligne-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                        <input type="text" class="form-control" id="nomuser<?=$i?>"value="<?php echo $value->nom_user?>">
                                        <input type="text" id="iduser<?=$i?>" value="<?php echo $value->ID_user?>"hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Mail</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                        <input type="email" class="form-control" id="mail_user<?=$i?>" value="<?php echo $value->email?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End row-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Roles</label>
                                <div class="col-sm-9">   
                                <div class="form-group">
                                    <select class="form-control custom-select" id="role<?=$i?>"value="<?php echo $value->role?>">
                                        <option value=""></option>
                                            <option value="technicien">technicien</option>
                                            <option value="commercial">commercial</option>
                                        <option value="admin">admin</option>
                                    </select>    
                                </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Endajout_User row-->
                </form>
                <div class="modal-footer">
                    <button type="button" onclick="UpdateUser($('#iduser<?=$i?>').val(),$('#nomuser<?=$i?>').val(),$('#mail_user<?=$i?>').val(),
                    $('#role<?=$i?>').val())" class="btn btn-info waves-effect text-left" data-dismiss="modal">modifier utilisateur
                                </button>
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
            </div>
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
                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer cet utilisateur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body"> 
                    <input type="text" class="form-control" id="iduser<?=$i?>" value="<?php echo $value->ID_user?>" hidden>
                    Voulez-vous supprimer cet utilisateur?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteUser($('#iduser<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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