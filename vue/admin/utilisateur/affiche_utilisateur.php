<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('utilisateur',$_SESSION['ID_user'])->fetch()) 
{
    if ($d['L'] == 1) 
    {
        $l = true;
    }
    if ($d['C'] == 1) 
    {
        $c = true;
    }
    if ($d['M'] == 1) 
    {
        $m = true;
    }
    if ($d['S'] == 1) 
    {
        $s = true;
    }
}
?>

<div class="row">
    <input type="text" id="iduser_session" value="<?=$_SESSION['ID_user']?>"hidden>
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h6>Liste des utilisateurs</h6>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active"><a href="<?=WEBROOT?>utilisateur">Retour</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                
                <form class="form-horizontal" >
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive m-t-0">
                                <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Mail</th>
                                            <th>Login</th>
                                            <th>Profil</th>
                                            <th>Action</th>
                                            <th>Bloquer</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Mail</th>
                                            <th>Login</th>
                                            <th>Profil</th>
                                            <th>Action</th>
                                            <th>Bloquer</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="reponse">
                    <?php $i =0;
                    foreach ($user->affiche_user_avec_profil() as $value) 
                        {
                            $i++;?>
                            <tr>
                       <td><?= $value->nom_user?></td>
                       <td><?= $value->prenom?></td>
                       <td><?= $value->email?></td>
                       <td><?= $value->login?></td>
                       <td><?= $value->profil_name?></td>
                       <td class="text-nowrap">
                    <?php
                    if ($m) 
                    {?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                    <?php
                    }
                    ?>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lgs<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lgs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Changer le profil d'un utilisateur</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Profil</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="iduser<?= $i?>" value="<?php echo $value->ID_user?>"hidden>
                            <select  id="profil_id<?= $i?>" class="form-control">    
                                <?php foreach ($user->getAllProfilUser() as  $value2)
                                {
                                    if ($value->profil_id == $value2->profil_id) 
                                    {
                                ?>
                                        <option value="<?=$value2->profil_id?>" selected><?= $value2->profil_name?></option>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                    <option value="<?=$value2->profil_id?>"><?php echo $value2->profil_name?></option>
                                <?php
                                    }
                                } 
                                ?>
                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="text" id="nom_user" value="<?=$_SESSION['userName']?>" hidden>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #7c4a2f" class="btn font-light text-left text-white" onclick="update_profil($('#iduser<?=$i?>').val(),$('#profil_id<?=$i?>').val(),$('#nom_user').val())" data-dismiss="modal">changer le profil
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <?php
                if ($s) 
                {?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                <?php
                }
                ?>

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
                                <input type="text" id="effaceur" value="<?=$_SESSION['userName']?>"hidden>
                                Voulez-vous supprimer ce utilisateur?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletecet_utilisateur($('#iduser_delete<?= $i?>').val(),$('#effaceur').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </td>
        <td>    
                <?php
                    if ($value->statut ==1) 
                     {
                            ?><a href="javascript:void(0)" data-toggle="modal" data-target=".active-user<?=$i?>" data-original-title="desactiver"> <label class="text-success"><span class="badge badge-success">activé <i class="fa fa-check "></i></span></label></a>
                <!-- sample modal content -->
                <div class="modal fade active-user<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Changer l'etat</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                                <input type="text" class="form-control" id="iduserToDisable<?=$i?>" value="<?=$value->ID_user?>" hidden>

                                <div class="custom-control custom-checkbox">
                                <?php if($value->statut == 1)
                                {?> 
                                    <input type="checkbox" class="custom-control-input" id="status<?=$value->ID_user?>"  checked=""/>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <input type="checkbox" class="custom-control-input" id="status<?=$value->ID_user?>" name="status<?=$value->ID_user?>"/>
                                <?php
                                }
                                ?>
                                <label class="custom-control-label" for="customCheck1">Etat</label>
                                </div> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="changeUserStatus($('#iduserToDisable<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-lock-outline"></i> </button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <!-- /.modal -->
                        <?php
                     }
                     else
                     {
                         ?>
                         

                           <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sms" data-original-title="activer"><label class="text-danger"><span class="badge badge-danger"> desactivé  <i class="fa fa-ban"></i> </span></label></a>
                <!-- sample modal content -->
                              <div class="modal fade bs-example-modal-sms" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                       <div class="modal-dialog modal-sm">
                                                     <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">activé cet utilisateur</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                                <input type="text" class="form-control" id="iduser<?=$i?>" value="<?=$value->ID_user?>"hidden>
                                <input type="text" class="form-control" id="new_etat" value="1" hidden>
                                Voulez-vous activer
                                </br>
                                 <input type="text" class="form-control"  value="<?php echo $value->nom_user.' '.$value->prenom?> ?">
                                 <input type="text" id="activateur" value="<?=$_SESSION['userName']?>"hidden>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="debloqueruser($('#iduser<?= $i?>').val(),$('#new_etat').val(),$('#activateur').val())" data-dismiss="modal"><i class="mdi mdi-lock-open-outline"></i></button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                          <?php
                     }
                       
                ?>
            
               

                                        </td>
                                    </tr>
                                     <?php
                                }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>
