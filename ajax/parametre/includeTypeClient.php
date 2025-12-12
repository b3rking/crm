<?php
require_once("../../model/connection.php");
require_once("../../model/typeClient.class.php");

$type = new TypeClient();
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
                <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Type client</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" data-target="#responsive-modal"><i class="fa fa-plus-circle"></i> Ajouter type</button>

            <!-- sample modal content -->
            <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Nouveau type</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-xlg-3">
                                            <label for="recipient-name" class="control-label">Entreer type:</label>
                                        </div>
                                        <div class="col-md-6 col-xlg-6 col-lg-6">
                                            <input type="text" class="form-control" id="type">
                                        </div>
                                    </div>                                   
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="ajouterTypeClient($('#type').val())">Ajouter</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->
        </div>
    </div>
</div>
		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Type</th>
		                        <th>Action</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Type</th>
		                        <th>Action</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php
		                	$i = 0;
		                	foreach ($type->recupererTypes() as $value) : $i++; ?>
		                    <tr>
		                        <td><?= $value->libelle?></td>
		                        <td class="text-nowrap">
		                        	<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm-<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-sm-<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Modifier Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
            	<input type="text" class="form-control" id="idtype<?= $i?>" value="<?php echo $value->ID_type?>" hidden>

            	<input type="text" id="type<?= $i?>" class="form-control" value="<?=$value->libelle?>">          	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="updateType($('#idtype<?= $i?>').val(),$('#type<?= $i?>').val())" data-dismiss="modal">Modifier</button>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
            	<input type="text" class="form-control" id="idtype<?= $i?>" value="<?php echo $value->ID_type?>" hidden>
            	Voulez-vous supprimer ce type?<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteType($('#idtype<?= $i?>').val())" data-dismiss="modal">Supprimer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
		                        </td>
		                    </tr>
		                <?php endforeach?>
		                </tbody>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
</div>