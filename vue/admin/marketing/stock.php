<?php
ob_start();
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
            
             <div style="background-color: #8b4513" class="card-header text-white box text-center">
           Stock marketing
        </div>
		    <div class="card-body">
		    	<div class="row page-titles">
					    <div class="col-md-5 align-self-center" id="rep">
					        <h4 class="text-themecolor"></h4>
					    </div>
					    <div class="col-md-7 align-self-center">
					        <div class="d-flex justify-content-end align-items-center">
					           <button type="button" style="background-color: #8b4513"class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>ajouter stock
                               </button>
					            <!--<button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Importer companie</button>-->
					            <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Nouveau stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Materiel</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                        <input type="text" id="materiel" class="form-control" placeholder="ajouter un materiel">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="number" id="quantite" class="form-control" placeholder="le nombre">
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                </form>
            </div>
            <div class="modal-footer">
                <span id="msg"></span>
            	<button type="button" style="background-color: #8b4513" class="btn font-light text-white" data-dismiss="modal" onclick="ajouterstockmarketing($('#materiel').val(),$('#quantite').val())"> <i class="fa fa-check"></i> Enregistrer en stock</button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>
					        </div>
					    </div>
					</div>
		        <div class="table-responsive m-t-0">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Numero</th>
		                        <th>Materiel</th>
		                        <th>Quantite</th>
                                <th></th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Numero</th>
                                <th>Materiel</th>
                                <th>Quantite</th>
                                <th></th>
		                    </tr>
		                </tfoot>
		                <tbody id="reponse">
                            <?php
                            $i =0;
                            foreach ($marketing->afficheStockmarketing() as $value)
                            {
                                $i++;
                                ?>
                                <tr>
                                <td><?php echo $value->ID_stock?></td>
                                <td><?php echo $value->materiels?></td>
                                <td><?php echo $value->quantite?></td>
                                <td class="text-nowrap">
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier ce materiel</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                               <form class="form-horizontal p-t-20">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Materiel</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"></span>
                                                    </div>
                                                    <input type="text" id="idstockmarketing<?=$i?>" class="form-control" value="<?php echo $value->ID_stock?>"hidden>
                                                    <input type="text" id="materiels<?=$i?>" class="form-control" value="<?php echo $value->materiels?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                    <input type="number" id="quantite<?=$i?>" value="<?php echo $value->quantite?>" class="form-control" >
                                                     <input type="text" id="idstockmarketing<?=$i?>" value="<?php echo $value->ID_stock?>" class="form-control" hidden>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #8b4513" class="btn font-light text-white" onclick="updatestock($('#idstockmarketing<?=$i?>').val(),$('#materiels<?=$i?>').val(),$('#quantite<?=$i?>').val())" data-dismiss="modal">Modifier
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
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
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce materiel </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="idstockmarketing<?= $i?>" value="<?php echo $data->ID_stock?>" hidden>
                            Voulez-vous supprimer ce materiel<br> dans le stock?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerstock($('#idstockmarketing<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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
/*$home_commercial_content = ob_get_clean();
require_once('vue/admin/home.commercial.php');*/
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>