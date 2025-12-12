<?php
ob_start();
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
                <div id="rep"></div>
		    	<div class="row page-titles">

					    <div class="col-md-5 align-self-center">
					        <h4 class="text-themecolor">Prospection</h4>
					    </div>
					    <div class="col-md-7 align-self-center text-right">
					        <div class="d-flex justify-content-end align-items-center">
					            <!--<ol class="breadcrumb">
					                <li class="breadcrumb-item"><a href="javascript:void(0)">Prospection</a></li>
					                <li class="breadcrumb-item active">Prospection</li>
					            </ol>-->
					           <button type="button" class="btn btn-success d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>ajouter un prospect</button>
					            <!--<button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Importer companie</button>-->
					            <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Nouveau prospect</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                        <input type="text" id="nomprospect" class="form-control" placeholder="Entrer le nom du prospect">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Adresse</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                    <input type="text" id="adresprospect" class="form-control" placeholder="Entrer l'adresse du prospect">
                                </div>
                           </div>
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Telephone</label>
                                <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                    <input type="text" id="phoneprospect" class="form-control" placeholder="Telephone">
                                 
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">mail</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="email" class="form-control" placeholder="@ mail" id="mailprospect">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">entreprise</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text" class="form-control" placeholder="nom de l'entreprise" id="entreprise">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">rendez vous</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text" class="form-control" placeholder="" id="rdv">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">date</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="date" class="form-control"  id="dateprospection">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">commentaire</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <textarea name="comment" class="form-control" id="commentaire" ></textarea>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    </form>
            </div>
            <div class="modal-footer">
                <span id="msg"></span>
                
            	<button type="button" class="btn btn- text-white"style="background-color: #8b4513" data-dismiss="modal" onclick="ajouterprospect($('#nomprospect').val(),$('#adresprospect').val(),$('#phoneprospect').val(),$('#mailprospect').val(),$('#entreprise').val(),$('#rdv').val(),$('#dateprospection').val(),$('#commentaire').val())"> <i class="fa fa-check"></i> Ajouter prospect</button>
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
		        <!--<h4 class="card-title">Prospection</h4>-->
		        <!--<h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Numero</th>
		                        <th>Nom</th>
		                        <th>Entreprise</th>
                                <th>telephone</th>
		                        <th>Adresse</th>
		                        <th>Mail</th>
		                        <th>Date</th>
                                <th>rendez vous</th>
                                <th></th>
                                
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                         <th>Numero</th>
                                <th>Nom</th>
                                <th>Entreprise</th>
                                <th>telephone</th>
                                <th>Adresse</th>
                                <th>Mail</th>
                                <th>Date</th>
                                <th>rendez vous</th>
                                <th></th>
                               
		                    </tr>
		                </tfoot>
		                <tbody id="reponse">
                            <?php
                            $i =0;
                            foreach ($marketing->afficheProspect () as $value)
                            {
                                $i++;
                                ?>
                                <tr>
                                <td><?php echo $value->ID_prospect?></td>
                                <td><?php echo $value->nom?></td>
                                <td><?php echo $value->entreprise?></td>
                                <td><?php echo $value->telephone?></td>
                                <td><?php echo $value->adresseProspect?></td>
                                <td><?php echo $value->mail?></td>
                                <td><?php echo $value->dateProspection?></td>
                                <td><?php echo $value->rendezvous?></td>
                               


                                

                                
                                <td class="text-nowrap">
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier ce prospect</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                        <input type="text" id="numprospect<?=$i?>" class="form-control" value="<?php echo $value->ID_prospect?>"hidden>
                                        <input type="text" id="nomprospect<?=$i?>" class="form-control" value="<?php echo $value->nom?>">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Adresse</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                    <input type="text" id="adresprospect<?=$i?>" class="form-control" value="<?php echo $value->adresseProspect?>">
                                </div>
                           </div>
                        </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Telephone</label>
                                <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                    <input type="text" id="phoneprospect<?=$i?>" class="form-control" value="<?php echo $value->telephone?>">
                                 
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">mail</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="email" id="mailprospect<?=$i?>" class="form-control" value="<?php echo $value->mail?>">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">entreprise</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text" id="entreprise<?=$i?>" class="form-control" value="<?php echo $value->entreprise?>">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">rendez vous</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text"  id="rdv<?=$i?>" class="form-control" value="<?php echo $value->rendezvous?>">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">date</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="date" id="dateprospection<?=$i?>" class="form-control" value="<?php echo $value->dateProspection?>">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
<div class="col-lg-6 col-md-6">
    <div class="form-group row">
        <label for="exampleInputuname3" class="col-sm-3 control-label">commentaire</label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"></span></div>
            <textarea name="comment" id="commentaire<?=$i?>" class="form-control"><?php echo $value->commentaire?></textarea>
              
            </div>
        </div>
    </div>
</div>
                    </div><!-- END ROW-->
                    </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn- text-white" style="background-color: #8b4513" onclick="updateProspect($('#numprospect<?=$i?>').val(),$('#nomprospect<?=$i?>').val(),$('#adresprospect<?=$i?>').val(),$('#phoneprospect<?=$i?>').val(),$('#mailprospect<?=$i?>').val(),$('#entreprise<?=$i?>').val(),$('#rdv<?=$i?>').val(),$('#dateprospection<?=$i?>').val(),$('#commentaire<?=$i?>').val())" data-dismiss="modal">Modifier
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce prospect</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="numprospect<?= $i?>" value="<?php echo $data->ID_prospect?>" hidden>
                            Voulez-vous supprimer ce prospect?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn- btn-dark" onclick="supprimerProspect($('#numprospect<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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
$home_commercial_content = ob_get_clean();
require_once('vue/admin/home.commercial.php');
?>