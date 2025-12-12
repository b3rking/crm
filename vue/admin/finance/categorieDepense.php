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
					<div class="col-md-7 align-self-center">
					    <div class="d-flex justify-content-end align-items-center">
					    	<ol class="breadcrumb">
					            <li class="breadcrumb-item"><a href="javascript:void(0)">Finance</a></li>
					            <li class="breadcrumb-item active">Categorie depense</li>
					        </ol>
					       
					        <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target="#responsive-modal"><i class="fa fa-plus-circle"></i> Ajouter une categorie</button>
           

            <!-- sample modal content -->
            <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Nouvelle categorie de depense</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                          <label for="exampleInputuname3" class="col-sm-3 control-label">Libelle categorie:</label>
                                          <div class="col-sm-9"> 
                                            <input type="text" class="form-control" id="categoriedepense">
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Type categorie:</label>
                                            <div class="col-sm-9"> 
                                            <select class="form-control" id="type_categorie">
                                                <option value=""></option>
                                                <option value="Fonctionnement">Fonctionnement</option>
                                                <option value="Investissement">Investissement</option>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="background-color: #8b4513" class="btn waves-effect waves-light" onclick="ajoutercategoriedepense($('#categoriedepense').val(),$('#type_categorie').val())">Ajouter cette categorie</button>
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
		         <div class="table-responsive m-t-0">
		            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>ID</th>
		                        <th>Libelle</th>
                                <th>Type Categorie</th>
		                        <th>Action</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>ID</th>
		                        <th>Libelle</th>
                                <th>Type Categorie</th>
		                        <th>Action</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php
		                	$i =0;
		                	foreach ($comptabilite->getCategorieDepenses() as $value) 
	                		{$i++;
                			?>
	                		<tr>
		                        <td><?=$value->ID_categorie_depense?></td>
		                        <td><?=$value->description?></td>
                                <td><?=$value->type_categorie?></td>
                                <td class="text-nowrap">
                    	
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#responsive-modal<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

<!-- sample modal content -->
<div id="responsive-modal<?=$i?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modification de la categorie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                              <label for="exampleInputuname3" class="col-sm-3 control-label">Libelle categorie:</label>
                              <div class="col-sm-9"> 
                                <input type="text" class="form-control" id="description<?=$i?>" value="<?=$value->description?>">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Type categorie:</label>
                                <div class="col-sm-9"> 
                                <select class="form-control" id="type_categorie<?=$i?>">
                                    <?php
                                    if ($value->type_categorie == 'Fonctionnement') 
                                    {
                                    ?>
                                        <option value=""></option>
                                        <option value="Fonctionnement" selected="">Fonctionnement</option>
                                        <option value="Investissement">Investissement</option>
                                    <?php
                                    }
                                    else if($value->type_categorie == 'Investissement')
                                    {
                                    ?>
                                        <option value=""></option>
                                        <option value="Fonctionnement">Fonctionnement</option>
                                        <option value="Investissement" selected="">Investissement</option>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <option value="" selected=""></option>
                                        <option value="Fonctionnement">Fonctionnement</option>
                                        <option value="Investissement">Investissement</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <input type="text" class="form-control" id="idCategorie<?= $i?>" value="<?php echo $value->ID_categorie_depense?>" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" style="background-color: #8b4513" class="btn waves-effect waves-light font-light text-white" onclick="updateCategorieDepense($('#idCategorie<?=$i?>').val(),$('#type_categorie<?=$i?>').val(),$('#description<?=$i?>').val())" data-dismiss="modal">Ajouter cette categorie</button>
                <button type="button" class="btn btn-dark waves-effect" data-dismiss="modal">Fermer</button>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer la categorie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
            	<input type="text" class="form-control" id="numcategorie<?= $i?>" value="<?php echo $value->ID_categorie_depense?>"hidden >
            	Voulez-vous supprimer cette categorie?<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimeCategorie($('#numcategorie<?= $i?>').val())" data-dismiss="modal">Supprimer</button>
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