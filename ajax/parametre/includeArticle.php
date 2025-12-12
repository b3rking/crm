
<?php
require_once("../../model/connection.php");
require_once("../../model/article.class.php");

$article = new Article();
?>

<div class="row">
    
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div id="rep"></div>
    	<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">article</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">gestion article</a></li>
                <li class="breadcrumb-item active">Article</li>
            </ol>
           <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Nouveau Article</button>
<!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau article</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                            	<div class="row">
                            		<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Type contrat</label>
		                                    <div class="form-group col-sm-9">

                	 <select id="typecontrat" class="form-control">
                    	<option value="service">service</option>
                    	<option value="equipement">equipement</option>
                     </select>
		                                        
		                                    </div>
		                                </div>
	                            	</div>
	                                <div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Type article</label>
		                                 <div class="form-group col-sm-9">
                            <select id="typearticle" class="form-control">

                            <option value="statique">Statique</option>
                            <option value="frais">frais</option>
                            <option value="debut">debut</option>
		                     </select>
		                                    </div>
		                                </div>
	                            	</div>
                            	</div><!-- END ROW-->
                            	
	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Numero d'ordre</label>
		                                    <div class="form-group col-sm-9">
        
		                                      <!--<input type="number" class="form-control" id="numero">-->
	                                            	
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Langue</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="langue" class="form-control">
	                                            	<option value="francais">francais</option>
	                                            	<option value="anglais">anglais</option>
	                                            </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row-->
	                            <div class="row">
                    	<div class="col-lg-6 col-md-6">
                    		<div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Titre</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" class="form-control" id="titre">
                                </div>
                            </div>
                    	</div>
	                           	
	                            </div><!-- End row-->
	                           <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
		                                            <textarea class="form-control" placeholder="le corp de l'article" id="corp_article"></textarea>
		                                        </div>
		                                    </div>

                            </form>
                        </div>
                <div class="modal-footer">
<button class="btn btn-success waves-effect text-left" onclick="ajouterArticle($('#numero').val(),$('#typecontrat').val(),$('#typearticle').val(),$('#langue').val(),$('#titre').val(),$('#corp_article').val())" data-dismiss="modal"><i class="fa fa-check"></i>Creer article
</button>
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->





        </div>
    </div>
</div>
		        <!--<h4 class="card-title">Data Export</h4>
		        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                    	<th>Numero d'ordre</th>
		                        <th>Type contrat</th>
		                     
		                        <th>Titre</th>
		                        <th>Corp</th>
		                        <th>Langue</th>
		                        <th>Type article</th>
		                        <th></th><th></th>
		                    </tr>
		                </thead>
		                  <tfoot>
					            <tr>
					                <th>Numero d'ordre</th>
					                <th>Type contrat</th>
					                
					                <th>Titre</th>
					                <th>Corp</th>
					                <th>Langue</th>
					                <th>Type article</th>
					                <th></th><th></th>
					            </tr>
					        </tfoot>
		                    <tbody id="reponse">

	                    <?php 
            
            $i = 0;
            foreach($article->afficheArticle() as $value)
            {?>
            	<?php
            $i++;
            ?>
            <tr>
           

            		<td><?php echo $value->numero_article?></td>
                    <td><?php echo $value->type_contrat?> </td>
                    <td><?php echo $value->titre?></td>
                    <td><?php echo $value->corp?></td>
                    <td><?php echo $value->langue?></td>
                    <td><?php echo $value->type_article?></td>
        
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
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Type contrat</label>
		                                    <div class="form-group col-sm-9">

                	 <select id="typecontrat<?=$i?>" value="<?php echo $value->type_contrat?>" class="form-control">
                    	<option value="service">service</option>
                    	<option value="equipement">equipement</option>
                     </select>
		                                        
		                                    </div>
		                                </div>
	                            	</div>
	                                <div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Type article</label>
		                                 <div class="form-group col-sm-9">
                            <select id="typearticle<?=$i?>" value="<?php echo $value->type_article ?>" class="form-control">

                            <option value="statique">Statique</option>
                            <option value="frais">frais</option>
                            <option value="debut">debut</option>
		                     </select>
		                                    </div>
		                                </div>
	                            	</div>
                            	</div><!-- END ROW-->
                            	
	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Numero d'ordre</label>
		                                    <div class="form-group col-sm-9">
		                                        <input type="number" class="form-control" id="numero<?=$i?>" value="<?php echo $value->numero_article?>">
	                                            	
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Langue</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="langue<?=$i?>" value="<?php echo $value->langue?>" class="form-control">
	                                            	<option value="francais">francais</option>
	                                            	<option value="anglais">anglais</option>
	                                            </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row-->
	                            <div class="row">
                    	<div class="col-lg-6 col-md-6">
                    		<div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Titre</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" class="form-control" id="titre<?=$i?>" value="<?php echo $value->titre?>">
                                </div>
                            </div>
                    	</div>
	                           	
	                            </div><!-- End row-->
	         <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>

<textarea type="text" rows="5" cols="2" class="form-control" id="corp_article<?=$i?>">
	<?php echo $value->corp?>
</textarea>
                              </div>
		                     </div>

                            </form>
                        </div>
                <div class="modal-footer">
<button class="btn btn-success waves-effect text-left" onclick="updateArticle($('#numero<?=$i?>').val(),$('#typecontrat<?=$i?>').val(),$('#typearticle<?=$i?>').val(),$('#langue<?=$i?>').val(),$('#titre<?=$i?>').val(),$('#corp_article<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>modifier article
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer cet article</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                         </div>
<div class="modal-body"> 
<input type="text" class="form-control" id="numero<?=$i?>" value="<?php echo $value->corp?>" hidden>
Voulez-vous supprimer cet article?<br>
<button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteArticle($('#numero<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
</div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
        </td>
                </tr>
            <?php } ?>
         
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>

