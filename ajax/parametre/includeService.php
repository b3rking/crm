<?php
require_once("../../model/connection.php");
require_once("../../model/service.class.php"); 

$service = new Service();
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
                <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Service</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" data-target="#add-contact"><i class="fa fa-plus-circle"></i> Ajouter service</button>
<!-- Modal -->
<div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Nouveau Service</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <from class="form-horizontal form-material">
                    <div class="form-group">
                        <div class="col-md-12 m-b-20">
                            <input type="text" class="form-control" placeholder="Non de service" id="nom"> </div>
                        <div class="col-md-12 m-b-20">
                            <input type="text" class="form-control" placeholder="Montant par defaut" id="montant">
                        </div>
                        <div class="col-md-12 m-b-20">
                            <select id="monnaie" class="form-control">
                                <option value="bif">BIF</option>
                                <option value="usd">USD</option>
                            </select>
                        </div>
                        <div class="col-md-12 m-b-20">
                            <input type="text" class="form-control" placeholder="Description" id="description"> </div>
                    </div>
                </from>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" onclick="ajouterService($('#nom').val(),$('#montant').val(),$('#monnaie').val(),$('#description').val())">Ajouter</button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
        </div>
    </div>
</div>

		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
                                <th>Nom</th>
                                <th>Montant</th>
                                <th>Monnaie</th>
                                <th>Description</th>
		                        <th>Action</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
                                <th>Nom</th>
                                <th>Montant</th>
                                <th>Monnaie</th>
                                <th>Description</th>
		                        <th>Action</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php
		                	$i = 0;
		                	foreach ($service->recupererServices() as $value) : $i++; ?>
		                    <tr>
		                        <td><?= $value->nomService?></td>
                                <td><?= $value->montant?></td>
                                <td><?= $value->monnaie?></td>
                                <td><?= $value->description?></td>
		                        <td class="text-nowrap">
		                        	<a href="javascript:void(0)" data-toggle="modal" data-target="#add-contact<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
<!-- sample modal content -->
<div id="add-contact<?=$i?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Modifier Service</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <from class="form-horizontal form-material">
                    <div class="form-group">
                        <div class="col-md-12 m-b-20">
                            <input type="text" id="idservice<?= $i?>" value="<?= $value->ID_service?>" hidden>
                            <input type="text" class="form-control" placeholder="Non de service" id="nom<?= $i?>" value="<?= $value->nomService?>"> </div>
                        <div class="col-md-12 m-b-20">
                            <input type="number" class="form-control" placeholder="Montant par defaut" id="montant<?= $i?>" value="<?= $value->montant?>">
                        </div>
                        <div class="col-md-12 m-b-20">
                            <select id="monnaie<?= $i?>" class="form-control">
                                <?php
                                if ($value->monnaie == 'bif') 
                                {
                                ?>
                                    <option value="bif">BIF</option>
                                    <option value="usd">USD</option>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <option value="usd">USD</option>
                                    <option value="bif">BIF</option>
                                <?php
                                }
                                ?>                              
                            </select>
                        </div>
                        <div class="col-md-12 m-b-20">
                            <input type="text" class="form-control" placeholder="Description" id="description<?= $i?>" value="<?= $value->description?>">
                        </div>
                    </div>
                </from>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info waves-effect" onclick="updateService($('#idservice<?= $i?>').val(),$('#nom<?= $i?>').val(),$('#montant<?= $i?>').val(),$('#monnaie<?= $i?>').val(),$('#description<?= $i?>').val())" data-dismiss="modal">Modifier</button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->

<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

<!-- sample modal content -->
<div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer Service</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
            	<input type="text" class="form-control" id="idservice<?= $i?>" value="<?php echo $value->ID_service?>" hidden>
                <input type="text" id="dropservice" value="<?=$_SESSION['userName']?>"hidden>
            	Voulez-vous supprimer ce service?<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteService($('#idservice<?= $i?>').val(),$('#dropservice').val())" data-dismiss="modal">Supprimer</button>
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