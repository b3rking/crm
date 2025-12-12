<?php
ob_start();
?>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<div class="row">
<div class="col-lg-12 col-md-12 col-xl-12">
   <div class="card">
     <div class="card-body">
        <div id="retour"></div>
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
            </div>
            <div class="col-md-7 align-self-center"> 
            <div class="d-flex justify-content-end align-items-center">
            <button type="button" style="background-color: #8b4513" class="btn  d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Ajouter monnaie</button>

        <!-- sample modal content -->
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                         <h4 class="modal-title" id="myLargeModalLabel">Nouvelle monnaie</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal p-t-0" >
                            <div class="row">
                                <div class="col-lg-12 col-md-8">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 col-lg-4 control-label">Monnaie</label>
                                        <div class="col-sm-9 col-lg-8">
                                            <input type="text" id="monnaie_create" class="form-control form-control-sm" placeholder="e.g : USD">
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="background-color: #8b4513" class="btn waves-effect text-left font-light text-white" data-dismiss="modal" onclick="ajout_monnaie($('#monnaie_create').val(),$('#iduser').val())"> <i class="fa fa-check"></i>Ajouter</button>
                        <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
		<div class="table-responsive m-t-0">
			<table id="myTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Monnaie</th>
                        <th>Creer par</th>
                        <th></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Monnaie</th>
						<th>Creer par</th>
						<th></th>
					</tr>
				</tfoot>
				<tbody id="rep">              
					<?php 
                    $i = 0;
					foreach ($comptabilite->getMonnaies() as $data)
					{
                        $i++;
					?>
					    <tr>
						<td><?php echo $data->libelle?></td>
						<td><?php echo $data->nom_user?></td>
						
						<td class="text-nowrap">
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-update<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    <!-- sample modal content -->
<div class="modal fade bs-example-modal-update<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title" id="myLargeModalLabel">Modification de la monnaie</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20" >
                    <div class="row">
                        <div class="col-lg-12 col-md-8">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-4 control-label">Monnaie</label>
                                <div class="col-sm-9 col-lg-8">
                                    <input type="text" id="libelle<?=$i?>" class="form-control form-control-sm" value="<?=$data->libelle?>">
                                    <input type="text" id="id<?=$i?>" class="form-control form-control-sm" value="<?=$data->id?>" hidden>
                               </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" style="background-color: #8b4513" class="btn waves-effect text-left font-light text-white"  data-dismiss="modal" onclick="updateMonnaie($('#id<?=$i?>').val(),$('#libelle<?=$i?>').val())"> <i class="fa fa-check"></i>Modifier</button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
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
                                        <h4 class="modal-title" id="mySmallModalLabel">Supprimer la monnaie</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body"> 
                                        <input type="text" id="id_delete<?=$i?>" class="form-control form-control-sm" value="<?=$data->id?>" hidden>
                                        Voulez-vous supprimer cette monnaie?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteMonnaie($('#id_delete<?= $i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
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