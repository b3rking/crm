	<?php
		                	$i =0;
		                	foreach ($equipement->getsortie_stock($idaccessoire)as $value) {?>
		                	<tr>
		                        <td><?php echo $value->date_sortie?></td>
		                        <td><?php echo $value->categorie?></td>
		                        <td><?php echo $value->quantite?></td>
		                        <td><?php echo $value->motif?></td>
		                        <td><?php echo $value->serviteur?></td>
		                        <td><?php echo $value->Nom_client?></td>
                                <td><?= $value->nom_user?></td>
                                   <td class="text-nowrap">

                
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                        </a>
                  
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier sortie stock</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
                           <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                             <input type="number" id="id_sortie<?= $i?>" value="<?php echo $value->ID_sortie_stock?>" class="form-control" hidden>
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Categorie </label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="mdi mdi-chair-school"></i></span></div>
                            <select id="idaccessoiree<?=$i?>" value="<?php echo $value->categorie?>" class="form-control" disabled>
                                    <option value="<?php echo $value->ID_accessoire?>"><?php echo $value->categorie?></option>
                            <?php foreach ($equipement->selection_Categorie() as $data)
                            {?>
                            <option value="<?php echo $value->ID_accessoire?>"><?php echo $value->categorie?></option>
                            <?php
                            }
                            ?>                                 
                    </select>
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
                                    <input type="number" id="quantite<?= $i?>" value="<?php echo $value->quantite?>" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">date sortie </label>
    <div class="col-sm-9">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="mdi mdi-chair-school"></i></span></div>
                <input type="date" id="date_sortie<?= $i?>" value="<?php echo $value->date_sortie?>" class="form-control" ></div>
            </div>
                </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">motif</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                    <input type="text" id="motif<?= $i?>" value="<?php echo $value->motif?>" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                    </div><!-- END ROW-->
                    
                        </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" style="background-color: #8b4513" data-dismiss="modal" class="btn text-white" onclick="modifier_sortie($('#id_sortie<?=$i?>').val(),$('#quantite<?=$i?>').val(),$('#date_sortie<?=$i?>').val(),$('#motif<?=$i?>').val())"> <i class="fa fa-check"></i> Modifier accessoire</button>
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
                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer accessoire</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body"> 
                                <input type="text" class="form-control" id="idaccessoire<?= $i?>" value="<?php echo $value->ID_accessoire?>"hidden >
                                Voulez-vous supprimer cet accessoire?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="suppression_accessoire($('#idaccessoire<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                                </div>
                            </div>
                            <!--/.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </td>
		                    </tr>
		                	<?php
		                	}
		                	?>