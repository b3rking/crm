<?php
ob_start();
$month_etiquete = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
?>
<div class="row page-titles">
    <input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Coupure</h4>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
        	

            <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-plus-circle"></i> Generer la liste des coupures</button>
            <!--<button type="button" class="btn btn-success text-white d-none d-lg-block m-l-15" onclick="genererClientAderoguer('<=WEBROOT.'creerDerogation'?>')" ><i class="fa fa-plus-circle"></i> Creer derogation</button>-->
           
    <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lgs">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h4 class="modal-title" id="myLargeModalLabel">Nouvelle coupure</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal p-t-0" id="form-creerDerogation">
	                    <div class="row">
	                    	<div class="col-lg-12 col-md-12">
	                            <div class="form-group row">
	                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Date </label>
	                                <div class="col-sm-9">
                                        <input type="date" class="form-control" name="date_coupure" id="date_coupure" value="<?=date('Y-m-d')?>">
	                                </div>
	                            </div>
	                        </div>
	                        <!--<div class="col-lg-12 col-md-12" hidden="">
	                            <div class="form-group row">
	                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Client* </label>
	                                <div class="col-sm-9">
	                                    <div class="input-group">
	                                        <input type="text" class="form-control" name="client" id="clientAcouper">
	                                        <input type="text" name="idclient" id="idclient" hidden="">
	                                        <input type="text" name="type_client" id="type_client" hidden="">
	                                        <div id="modal"></div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>-->
	                    </div>
	                    <!--<div class="row" hidden="">
	                        <div class="col-lg-12 col-md-12">
	                            <div class="form-group row">
	                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Action* </label>
	                                <div class="col-sm-9">
	                                    <div class="input-group">
	                                    	<select class="form-control" id="action">
	                                    		<option value="couper">Couper</option>
	                                    		<option value="recouvrer">Recouvrer</option>
	                                    	</select>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>--
	                    <div class="row" hidden="">
	                    	<div class="col-lg-12 col-md-12">
	                            <div class="form-group row">
	                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Observation </label>
	                                <div class="col-sm-9">
	                                    <div class="input-group">
	                                    	<textarea class="form-control" id="observation"></textarea>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>-->
		            </form>
		        </div>
	            <div class="modal-footer">
	            	<button type="button"  onclick="creerCoupure($('#date_coupure').val())"  class="btn waves-effect text-left text-white" style="background-color: #8b4513">Generer
	                </button>
	                <button type="button"  onclick="ajouterClientAuListeDeCoupure($('#idclient').val(),$('#action').val(),$('#observation').val(),$('#idUser').val())"  class="btn waves-effect text-left text-white" style="background-color: #00A86B;" hidden="">Ajouter
	                </button>
	                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
	            </div>
        	</div>
    	</div>
    </div>

    <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-activeclient-modal-lgs"><i class="fa fa-check-circle"></i> Activer client</button>

    <div class="modal fade bs-activeclient-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lgs">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Activation de client</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal p-t-0">
	                    <div class="row">
	                        <div class="col-lg-12 col-md-12">
	                            <div class="form-group row">
	                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-1 control-label">Client* </label>
	                                <div class="col-sm-9 col-lg-11">
                                        <!--<input type="text" class="form-control" name="client" id="clientActiver" autocomplete="off">
                                        <input type="text" name="idclient" id="idclient" hidden="">
                                        <input type="text" name="type_client" id="type_client" hidden="">
                                        <div id="modal-activeclient"></div>-->

                                        <input type="text" id="seachCustomerToActivate" class="form-control form-control-sm" autocomplete="off">
                        	<select id="selectCustomerToActivate" class="form-control" size="3">
                        		<?php
                        			foreach ($client->getClient_a_activer() as $value) 
                        			{
                				?>
                        				<option value="<?=$value->ID_client?>">
                        					<?=$value->Nom_client.' -- code: '.$value->billing_number?>
                        				</option>
                				<?php
                        			}
                        		?>
                        	</select>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
		            </form>
		        </div>
	            <div class="modal-footer">
	                <button type="button"  onclick="activerClient($('#selectCustomerToActivate').val(),$('#idUser').val())"  class="btn waves-effect text-left text-white" style="background-color: #8b4513">Activer
	                </button>
	                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
	            </div>
        	</div>
    	</div>
    </div>
    <!--
    	<div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lgs">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: chocolate">
                    <h4 class="modal-title" id="myLargeModalLabel">Generer liste des clients</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal p-t-20">
	                    <div class="row">
	                        <div class="col-lg-6 col-md-12">
	                            <div class="form-group row">
	                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Mois </label>
	                                <div class="col-sm-9">
	                                    <div class="input-group">
	                                        <select class="form-control" id="mois">
	                                        	<option value="1">Janvier</option >
	                                        	<option value="2">Fevrier</option>
	                                        	<option value="3">Mars</option>
	                                        	<option value="4">Avril</option>
	                                        	<option value="5">Mai</option>
	                                        	<option value="6">Juin</option>
	                                        	<option value="7">Juillet</option>
	                                        	<option value="8">Aout</option>
	                                        	<option value="9">Septembre</option>
	                                        	<option value="10">Octobre</option>
	                                        	<option value="11">Novembre</option>
	                                        	<option value="12">Decmbre</option>
	                                        </select>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6 col-md-12">
	                            <div class="form-group row">
	                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Annee </label>
	                                <div class="col-sm-9">
	                                    <div class="input-group">
	                                        <input type="number" class="form-control" name="annee" id="annee" value="<php echo date('Y')?>">
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
		            </form>
		        </div>
	            <div class="modal-footer">
	                <button type="button"  onclick="genererClientAcouper($('#idUser').val())"  class="btn waves-effect text-left text-white" style="background-color: chocolate">Generer
	                </button>
	                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
	            </div>
        	</div>
    	</div>
    </div>
    -->
    	<!--<button type="button" class="btn btn-primary text-white d-none d-lg-block m-l-15" onclick="genererClientAcouper($('#idUser').val())"><i class="fa fa-plus-circle"></i> Generer la liste de coupure</button>-->

        <!--button type="button" class="btn btn-success d-none d-lg-block m-l-15 text-white"><i class="fa fa-plus-circle"></i> Raport de mauvais clients</button-->
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body" id="rep">
		        <div class="table-responsive m-t-0">
		            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Date</th>
		                        <th>Nombre de client</th>
		                        <th>Couper</th>
		                        <th>Recouvrer</th>
		                        <th>Confirmer</th>
		                        <th>Action</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Date</th>
		                        <th>Nombre de client</th>
		                        <th>Couper</th>
		                        <th>Recouvrer</th>
		                        <th>Confirmer</th>
		                        <th>Action</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php
		                	$i = 0;
		                	foreach ($contract->getNbClientFromCoupure() as $value) 
		                	{
		                		$i++;
		                	?>
		                		<tr>
		                			<td><?=$value->date?></td>
		                			<td><?=$value->nb_client?></td>
			                        <td>
		                        		<?php
				                        	$data = $contract->getTotalClientParAction('couper',$value->id)->fetch();
				                        	if ($data['nb_client'] == 0) {
				                        		echo $data['nb_client'];
				                        	}
				                        	else
				                        	{
				                        	?>
				                        		<a href="<?=WEBROOT.'couper-'.$value->id?>">
				                        			<?=$data['nb_client'];?>
				                        		</a>
				                        	<?php
				                        	}
				                        ?>
			                        </td>
			                        <td>
		                        		<?php
				                        	$data = $contract->getTotalClientParAction('recouvrer',$value->id)->fetch();
				                        	if ($data['nb_client'] == 0)
				                        		echo $data['nb_client'];
				                        	else
				                        	{
		                        		?>
		                        				<a href="<?=WEBROOT.'recouvrer-'.$value->id?>"><?=$data['nb_client']?></a>
		                        		<?php
				                        	}
				                        ?>
			                        </td>
			                        <td>
			                        	<?php
				                        if ($value->confirmed == 'oui') 
				                        {
			                        	?>
			                        		<h6 class="text-center text-white" style="background-color: #6090DB">
			                        		<?=strtoupper($value->confirmed)?>
			                        		</h6>
			                        	<?php
				                        }
				                        else
				                        {
			                        	?>
			                        		<h6 class="text-center text-white" style="background-color: #808080">
			                        		<?=strtoupper($value->confirmed)?>
			                        		</h6>
			                        	<?php
				                        }
				                        ?>
			                        </td>
			                        <td>
				                        <?php
				                        if ($value->confirmed == 'non') 
				                        {
			                        	?>
			                        		<a href="javascript:void(0)" data-toggle="modal" data-target="#myModalSendefacture<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

			                        		<!-- sample modal content -->
<div id="myModalSendefacture<?=$i?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editer coupure</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal p-t-0">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date :</label>
                            <div class="form-group col-sm-9">
                                <input type="date" class="form-control" id="update_date_coupure<?=$i?>" value="<?=$value->date?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label class="btn">
                                <input type="checkbox" id="confirmed<?=$i?>"> Confirmer les actions de cette liste
                            </label> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button style="background-color: #8b4513" type="button" class="btn text-white waves-effect text-left" onclick="update_cutoff_list($('#update_date_coupure<?=$i?>').val(),'<?= $value->id?>','<?=$i?>')"><i class="fa fa-check"></i>Editer
                </button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
            </div>
            </form>
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
                <h4 class="modal-title" id="mySmallModalLabel">Suppression de la liste</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            	Voulez-vous vraiment effectuer cette action
            	<input type="text" id="cutoff_id_delete<?=$i?>" value="<?= $value->id?>" hidden>
            </div>
            <div class="modal-footer">
            	<button class="btn btn-danger waves-effect text-left" onclick="delete_cutoff_list($('#cutoff_id_delete<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i>Supprimer
					</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
			                        	<?php
				                        }
				                        ?>
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