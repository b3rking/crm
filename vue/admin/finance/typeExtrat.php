<?php
ob_start();
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
						    	<div class="row page-titles">
					<div class="col-md-5 align-self-center">
					</div>
					<div class="col-md-7 align-self-center text-right">
					    <div class="d-flex justify-content-end align-items-center">
					    	<ol class="breadcrumb">
					            <li class="breadcrumb-item"><a href="javascript:void(0)">Finance</a></li>
					            <li class="breadcrumb-item active">extrat</li>
					        </ol>
					       
					        <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target="#responsive-modal"><i class="fa fa-plus-circle"></i> Ajouter un type d'extrat</button>
           

            <!-- sample modal content -->
            <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Nouveau type d'extrat</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-xlg-3">
                                            <label for="recipient-name" class="control-label">Libelle type:</label>
                                        </div>
                                        <div class="col-md-6 col-xlg-6 col-lg-6">
                                            <input type="text" class="form-control" id="type">
                                            <input type="text" id="user_extrat" value="<?=$_SESSION['userName']?>" hidden>
                                        </div>
                                    </div>                                   
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" style="background-color: #8b4513" class="btn  waves-effect waves-light font-light text-white" onclick="ajouterTypeExtra($('#type').val(),$('#user_extrat').val())">Ajouter</button>
                            <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
					    </div>
					</div>
					</div>
		        <!--h4 class="card-title">Data Export</h4>
		        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6-->
		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>ID</th>
		                        <th>Nom</th>
		                        <th >Action</th>
		                       
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>ID</th>
		                        <th>Nom</th>
		                        <th >Action</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php
		                	$i=0;
		                	foreach ($comptabilite->get_type_extrat() as $value) 
		                		{$i++;
		                			?>
		                			 <tr>
					                        <td><?=$value->ID_type_extrat?></td>
					                        <td><?=$value->libelle_extrat?></td>
					                        <td class="text-nowrap">
		                        	
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm-<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
									                                    
									<!-- sample modal content -->
									<div class="modal fade bs-example-modal-sm-<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
									    <div class="modal-dialog modal-sm">
									        <div class="modal-content">
									            <div class="modal-header">
									                <h4 class="modal-title" id="mySmallModalLabel">Modifier ce type d'extrat</h4>
									                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									            </div>
									            <div class="modal-body"> 
									            	<input type="text" class="form-control" id="refextrat<?= $i?>" value="<?php echo $value->ID_type_extrat?>" hidden>

									            	<input type="text" id="libelle<?= $i?>" class="form-control" value="<?=$value->libelle_extrat?>">
									            	<input type="text" id="update_extrat" value="<?=$_SESSION['userName']?>" hidden>          	
									            </div>
									            <div class="modal-footer">
									                <button type="button"style="background-color:#8b4513;" class="btn waves-effect waves-light btn-rounded font-light text-white" onclick="update_type_extrat($('#refextrat<?=$i?>').val(),$('#libelle<?=$i?>').val(),$('#update_extrat').val())" data-dismiss="modal">Modifier</button>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce type d'extrat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
            	<input type="text" class="form-control" id="num_extrat<?= $i?>" value="<?php echo $value->ID_type_extrat?>"hidden >
            	<input type="text" id="del_extrat" value="<?=$_SESSION['userName']?>" hidden>
            	Voulez-vous supprimer ce type d'extrat?<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprime_tpe_extrat($('#num_extrat<?= $i?>').val(),$('#del_extrat').val())" data-dismiss="modal">Supprimer</button>
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

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>