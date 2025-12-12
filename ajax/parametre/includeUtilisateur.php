 
<?php
ob_start();
require_once("../../model/connection.php");
require_once("../../model/User.class.php");

$user = new User();
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div id="rep"></div>
    	<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">utilisateur</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">gestion utilisateur</a></li>
                <li class="breadcrumb-item active">utilisateur</li>
            </ol>
           
            <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i>Ajouter utilisateur</button>
 <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouvel utislisateur</h4>
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
                                <input type="text" class="form-control" id="nomuser" placeholder="nom complet">

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
                                <input type="email" class="form-control" id="mail_user" placeholder="mail">
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End row-->
                         <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">mot de passe </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa-plus-circle"></i></span></div>
                                <input type="password" class="form-control" id="password" placeholder="password">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Roles</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
   <select class="form-control custom-select" id="role">

    <option value="role">role</option>
      <option value="owner">owner</option>
        <option value="admin">admin</option>
          

</select>    
            
                                    </div>
                                </div>
                            </div>
                        </div>
                <!--<div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">confirmation</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                <input type="email" class="form-control" id="mail_user" placeholder="confirmation">
                            </div>
                        </div>
                    </div>
                </div>-->
            </div><!-- Endajout_User row-->
             
    
                    </form>
                       
    <div class="modal-footer">
        <button type="button" class="btn btn-info waves-effect text-left" onclick="alert($('#nomuser').val()/*,$('#mail_user').val(),$(' #password')$('#role').val()*/)">Nouveau utilisateur
                    </button>
        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
    </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
         




        </div>
    </div>
</div>
		        <!--<h4 class="card-title">Data Export</h4>
		        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                    	<th>ID_utilisateur</th>
		                        <th>Nom </th>
		                        <th>E-mail</th>
                                <th>Role</th>
		                        <th></th>
                           
		                    </tr>
		                </thead>
		                  <tfoot>
					            <tr>
					           <th>ID_utilisateur</th>
                                <th>Nom </th>
                                <th>E-mail</th>
                                <th>Role</th>
                                <th></th>
                              
					            </tr>
					        </tfoot>
		                    <tbody id="rep">
                            <?php 
                            $i =0;
                            foreach ($user->afficheUsers() as  $value)
                             {?>
                               <?php
                               $i++; ?>
                               <tr>
             
                <td><?php echo $value->ID_user?></td>
                <td><?php echo $value->nom_user?></td>
                <td><?php echo $value->email?></td>
                <td><?php echo $value->role?></td>
                    
        
                    <td><button type="button" class="btn waves-effect waves-light btn-xs btn-success" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>">Edit</button>

          <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">modifier article</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">plaque</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" class="form-control" id="plaque<?=$i?>" value="<?php echo $value->immatriculation?>">
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
<button class="btn btn-success waves-effect text-left" onclick="UpdateVehicule($('#plaque<?=$i?>').val(),$('#modele<?=$i?>').val(),$('#marque<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>modifier vehicule
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce vehicule</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                         </div>
<div class="modal-body"> 
<input type="text" class="form-control" id="plaque<?=$i?>" value="<?php echo $value->immatriculation?>" hidden>
Voulez-vous supprimer cet article?<br>
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
	                    
            
            
         
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>

