<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('utilisateur',$_SESSION['ID_user'])->fetch()) 
{
    if ($d['M'] == 1) 
    {
        $m = true;
    }
}
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                  <a href="<?=WEBROOT?>article" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>

                <hr>
                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nom profil</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nom profil</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody id="reponse">
                            
                            <?php 
                            $i =0;
                      
                           foreach ($article->getProfils() as $value) 
                            { 
                                $i++;
                                ?>
                               <tr>
                                <td><?php echo $value->profil_name?></td>
                                
                                <td class="text-nowrap">
                                    
                   <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-md<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>

 <div class="modal fade bs-example-modal-md<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">modifier ce profil</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                                
                                <div class="row">
                                       <input type="text" id="profil_id<?=$i?>" value="<?php echo $value->profil_id?>"hidden>
                                      <div class="col-lg-7 col-md-5">
                                        <div class="row">
                                             <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom profil* </label>
                                            <div class="form-group col-sm-9">

                                                <input type="text" class="form-control" id="profil_name<?=$i?>" value="<?php echo $value->profil_name?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #8b4513"class="btn text-white waves-effect text-left" onclick="updateProfil($('#profil_id<?=$i?>').val(),$('#profil_name<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-pencil"></i>modifier ce profil
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
               <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce profil</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="numprof<?= $i?>" value="<?php echo $value->profil_id?>"hidden >
                            <input type="text" id="user_del" value="<?=$_SESSION['userName']?>"hidden>
                            Voulez-vous supprimer ce profil?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="efface_profil($('#numprof<?= $i?>').val(),$('#user_del').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
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
    </div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>
