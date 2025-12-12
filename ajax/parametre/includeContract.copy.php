<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/service.class.php");

$contract = new Contract();
$service = new Service();
$rs = $service->recupererServices();
print_r($rs);
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div class="row page-titles">
    <div class="col-md-5 align-self-center">
    	<h4 class="text-themecolor">Contract</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" class="btn btn-info d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Nouveau contract</button>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau Contract</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                            	<div class="row">
                            		<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Numero*</label>
		                                    <div class="form-group col-sm-9">
		                                        <input type="text" class="form-control" id="numero">
		                                    </div>
		                                </div>
	                            	</div>
	                                <div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Type contract</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="typecontract" class="form-control">
	                                            	<option value=""></option>
	                                            	<option value="service">service</option>
	                                            	<option value="equipement">equipement</option>
		                                            </select>
		                                    </div>
		                                </div>
	                            	</div>
                            	</div><!-- END ROW-->
                            	
	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="monnaie" class="form-control">
	                                            	<option value="bif">BIF</option>
	                                            	<option value="usd">USD</option>
	                                            </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Mode</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="mode" class="form-control">
	                                            	<option value="mail">via mail</option>
	                                            	<option value="imprimer">Imprimer</option>
	                                            </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row-->

	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Etat</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="etat" class="form-control">
	                                            	<option value="activer">Activer</option>
	                                            </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
		                                    <div class="form-group col-sm-9">
		                                    	<input type="text" id="idclient" class="form-control" autocomplete="off">
		                                            <div id="modal"></div>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row-->
	                            <hr>
	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Service</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="service" class="form-control">
	                                           	<?php
	                                           	foreach ($service->recupererServices() as $value) 
	                                           {?>
	                                           		<option value="<?= $value->ID_service?>"><?= $value->nomService?></option>
	                                           	<?php
	                                           }
	                                           	?>
	                                           </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Bande passante</label>
		                                    <div class="form-group col-sm-9">
		                                        <input type="text" id="bandepassante" class="form-control">
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!- End row -->


	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Rediction</label>
		                                    <div class="form-group col-sm-9">
		                                        <input type="text" class="form-control" id="rediction" data-mask="99">
		                                        <span class="font-13 text-muted">e.g "99%"</span>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Quantite</label>
		                                    <div class="form-group col-sm-9">
		                                        <input type="text" class="form-control" id="quantite">
		                                    </div>
		                                </div>
	                            	</div>
	                            </div>
	                            <div id="divService"></div>
	                            <!--
	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Service</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="service" class="form-control">
	                                           	<
	                                           	foreach ($service->recupererServices() as $value) :?>
	                                           		<option value="<?= $value->ID_service?>"><?= $value->nomService?></option>
	                                           	<
	                                           endforeach
	                                           	?>
	                                           </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Bande passante</label>
		                                    <div class="form-group col-sm-9">
		                                        <input type="text" id="bandepassante" class="form-control">
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!- End row --

	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Rediction</label>
		                                    <div class="form-group col-sm-9">
		                                        <input type="text" class="form-control" id="rediction" data-mask="99">
		                                        <span class="font-13 text-muted">e.g "99%"</span>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Quantite</label>
		                                    <div class="form-group col-sm-9">
		                                        <input type="text" class="form-control" id="quantite">
		                                    </div>
		                                </div>
	                            	</div>
	                            </div>-->
	                            <!--<div class="row">
	                            	<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3 form-group">
	                            		<input type="text" id="number" hidden="">
	                            		<button type="button" class="btn btn-info form-control" onclick="ajoutService()">
                                            <i class="ti-plus text"></i> Ajouter service
                                        </button>
	                            	</div>
	                            	<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
	                            		<button type="button" class="btn btn-info " onclick="supService($('#number').val())">
                                            <i class="ti-minus text"></i>
                                        </button>
	                            	</div>
	                            </div>-->
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success waves-effect text-left" onclick="saveContract($('#numero').val(),$('#typecontract').val(),$('#monnaie').val(),$('#mode').val(),$('#etat').val(),$('#idclient').val(),$('#service1').val(),$('#bandepassante1').val(),$('#rediction1').val(),$('#quantite1').val())" data-dismiss="modal"><i class="fa fa-check"></i>Enregistrer
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
		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Client</th>
		                        <th>Type contract</th>
		                        <th>Montant</th>
		                        <th>Monnaie</th>
		                        <th>date</th>
		                        <th>Service</th>
		                        <th>Etat</th>
		                        <th></th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Client</th>
		                        <th>Type contract</th>
		                        <th>Montant</th>
		                        <th>Monnaie</th>
		                        <th>date</th>
		                        <th>Service</th>
		                        <th>Etat</th>
		                        <th></th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php 
		                	$i = 0;
		                	foreach($contract->afficherContracts() as $value)
		                	{
		                		$i++;
		                	?>
		                    <tr>
		                        <td><a href="/crm.spidernet/detailClient-<?= $value->ID_client;?>"> <?php echo $value->Nom_client;?></a></td>
		                        <td><?= $value->type?> </td>
		                        <td><?= $value->montant.' '.$value->monnaieService?></td>
		                        <td><?= $value->monnaieContract?></td>
		                        <td><?php echo $value->date_contract?></td>
		                        <td>
		                        	<?php echo $value->nomService?>
		                        </td>
		                        <td><?= $value->etat?></td>
		                        <td class="text-nowrap">
		                        	<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
            	<!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modifier Contract</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                            	<div class="row">
                            		<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Numero*</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" class="form-control" id="numero">
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                                <div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Type contract</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <select id="typecontract" class="form-control">
		                                            	<option value=""></option>
		                                            	<option value="service">service</option>
		                                            	<option value="equipement">equipement</option>
		                                            </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
                            	</div><!-- END ROW-->
                            	
	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <select id="monnaie" class="form-control">
		                                            	<option value="bif">BIF</option>
		                                            	<option value="usd">USD</option>
		                                            </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Mode</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <select id="mode" class="form-control">
		                                            	<option value="mail">via mail</option>
		                                            	<option value="imprimer">Imprimer</option>
		                                            </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row-->

	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Etat</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <select id="etat" class="form-control">
		                                            	<option value="activer">Activer</option>
		                                            </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" id="client" class="form-control">
		                                        </div>

		                                        <!--<div id="bloodhound">
                                    <span class="twitter-typeahead" style="position: relative; display: inline-block;"><input class="typeahead form-control tt-input" type="text" placeholder="Countries" autocomplete="off" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;"><pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: Poppins, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></pre><div class="tt-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"><div class="tt-dataset tt-dataset-states"></div></div></span>
                                </div>-->
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row-->
	                            <hr>
	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Service</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                           <select id="service" class="form-control">
		                                           	<?php
		                                           	foreach ($service->recupererServices() as $value) :?>
		                                           		<option value="<?= $value->ID_service?>"><?= $value->nomService?></option>
		                                           	<?php
		                                           endforeach
		                                           	?>
		                                           </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Bande passante</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" id="bandepassante" class="form-control">
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row -->

	                            <div class="row">
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Rediction</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" class="form-control" id="rediction" data-mask="99">
		                                            <span class="font-13 text-muted">e.g "99%"</span>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Quantite</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" class="form-control" id="quantite">
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div>
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success  waves-effect" onclick="saveContract($('#numero').val(),$('#typecontract').val(),$('#monnaie').val(),$('#mode').val(),$('#etat').val(),$('#client').val(),$('#service').val(),$('#bandepassante').val(),$('#rediction').val(),$('#quantite').val())" data-dismiss="modal"><i class="fa fa-check"></i>Enregistrer
     						</button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer Client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
            	<input type="text" class="form-control" id="idclient<?= $i?>" value="" hidden>
            	Voulez-vous supprimer ce client?<br>
            	<button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteClient($('#idclient<?= $i?>').val())" data-dismiss="modal">Supprimer</button>
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
		               		?><!-- END FOREACH-->
		                </tbody>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
</div>