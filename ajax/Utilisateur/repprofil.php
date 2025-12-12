 <?php $i =0;
                                foreach ($user->affiche_user_avec_profil() as $value) 
                                    {
                                        $i++;?>
                                        <tr>
                                   <td><?php echo $value->nom_user?></td>
                                   <td><?php echo $value->prenom?></td>
                                   <td><?php echo $value->email?></td>
                                   <td><?php echo $value->login?></td>
                                   <td><?php echo $value->profil_name?></td>
                                   <td class="text-nowrap">
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier le profil</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                <div class="col-sm-9" >
                    <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"hidden><i class="ti-user"></i></span></div>
                <input type="text" class="form-control" id="iduser<?= $i?>" value="<?php echo $value->ID_user?>"hidden>
                        </div>
                    </div>
                <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label">Nom du profil</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                <select  id="profil_id<?= $i?>" class="form-control">    
                                    <?php foreach ($user->getAllProfilUser() as  $value2)
                                    {
                                    ?>
                                        <option value="<?=$value->profil_id?>"><?php echo $value->profil_name?></option>
                                    <?php   
                                    } 
                                    ?>
                                </select>
        
                            </div>
                            </div>
                        </div>
                </div>
            </div>
                </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" onclick="update_profil($('#iduser<?=$i?>').val(),$('#profil_id<?=$i?>').val())" data-dismiss="modal">changer le profil
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer cet utilisateur</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                                <input type="text" class="form-control" id="iduser_delete<?=$i?>" value="<?=$value->ID_user?>" hidden>
                                Voulez-vous supprimer ce utilisateur?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletecet_utilisateur($('#iduser_delete<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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