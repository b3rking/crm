<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('contrat',$_SESSION['ID_user'])->fetch()) 
{
    if ($d['L'] == 1) 
    {
        $l = true;
    }
    if ($d['C'] == 1) 
    {
        $c = true;
    }
    if ($d['M'] == 1) 
    {
        $m = true;
    }
    if ($d['S'] == 1) 
    {
        $s = true;
    }
}
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
$mode = ['impression','mail','manuel'];
//$periode = ['mensuelle','trimestrielle','semestrielle','annuelle'];
$periode = ['mensuelle' => 1,'trimestrielle' => 3,'semestrielle' => 6,'annuelle' => 12];
$etat = ['activer','suspension','pause','terminer','attente'];
$status = ['active' => 0,'annuler' => 1];
?>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
    	<a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
        	<!--<a href="<=WEBROOT?>printfacture" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> facture de dernier contract</a>-->
        	<?php
        	if ($c) 
    		{?>


            <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Nouveau contract</button>
            <button type="button" class="btn btn-chocolate d-none d-lg-block m-l-15 font-light text-white" onclick="raportContract()"><i class="fa fa-file"></i> Genere raport</button>
            <?php
        	} ?>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau Contract</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body modal-bg-color">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                            	<div class="row">
                            		<div class="col-lg-10 col-md-10">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 col-md-1 col-lg-1 control-label">Client</label>
		                                    <div class="form-group col-sm-9 col-md-11 col-lg-11">
		                                    	<!--<input type="text" id="idclientOnContract" class="form-control form-control-sm" autocomplete="off">
		                                        <div id="modal"></div>
		                                        <input type="text" id="idclient" hidden="">-->
                                                <input id="seachCustomerPayement" class="form-control form-control-sm" onkeyup="filter('idclient',this.value)" placeholder="-- filtrer ici --">
		                                        <select id="idclient" class="form-control" size="3">
		                                            <?php
		                                                foreach ($customers_tot_create_contract as $value) 
		                                                {
		                                            ?>
		                                                    <option value="<?=$value->ID_client?>">
		                                                        <?=$value->Nom_client?>
		                                                    </option>
		                                            <?php
		                                                }
		                                            ?>
		                                        </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-1 col-md-2">
										<div class="form-group">
									        <label class="form-control btn">
									            <input type="checkbox" id="show_rate"> affiche taux
									        </label> 
									    </div>
									</div>
                            	</div><!-- END ROW-->
                            	
	                            <div class="row">
	                            	<div class="col-lg-3 col-md-6">
	                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Contract</label>
	                                    <div class="form-group col-sm-9">
	                                        <select id="monnaie_contract" class="form-control form-control-sm">
                                            	<?php
		                                    	for ($l=0; $l < count($tbMonnaie); $l++) 
		                                    	{
		                                    	?> 
		                                    		<option value="<?=$tbMonnaie[$l]?>"><?=$tbMonnaie[$l]?></option>
		                                		<?php
		                                    	}
		                                    	?>
                                            </select>
	                                    </div>
	                            	</div>
	                            	<div class="col-lg-3 col-md-6">
	                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Facture</label>
	                                    <div class="form-group col-sm-9">
	                                        <select id="monnaie_facture" class="form-control form-control-sm">
                                            	<?php
		                                    	for ($l=0; $l < count($tbMonnaie); $l++) 
		                                    	{
		                                    	?> 
		                                    		<option value="<?=$tbMonnaie[$l]?>"><?=$tbMonnaie[$l]?></option>
		                                		<?php
		                                    	}
		                                    	?>
                                            </select>
	                                    </div>
	                            	</div>
	                            	<div class="col-lg-4 col-md-4">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Mode</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="mode" class="form-control form-control-sm">
                                    	<?php
                                    	for ($l=0; $l < count($mode); $l++) 
                                    	{
                                    	?> 
                                    		<option value="<?=$mode[$l]?>"><?=$mode[$l]?></option>
                                		<?php
                                    	}
                                    	?>
	                                            </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row-->
	                            <div class="row">
	                            	<div class="col-lg-4 col-md-4">
	                            		<div class="row">
	                            			<label for="exampleInputEmail3" class="col-sm-3 control-label">Etat</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="etat" class="form-control form-control-sm">
                                            	<?php
                                            	for ($l=0; $l < count($etat); $l++) 
                                            	{
                                            	?> 
                                            		<option value="<?=$etat[$l]?>"><?=$etat[$l]?></option>
                                        		<?php
                                            	}
                                            	?>
	                                            </select>
		                                    </div>
	                            		</div>
	                            	</div>
	                            	<div class="col-lg-4 col-md-4">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Profil Article*</label>
                                            <div class="form-group col-sm-9">
                                                <select class="form-control form-control-sm" id="profil">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($article->getProfils() as $value)
                                                    {
                                                    ?>
                                                        <option value="<?=$value->profil_id?>"><?=$value->profil_name?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
										<div class="form-group">
									        <label class="form-control btn">
									            <input type="checkbox" id="enable_discount" checked=""> reduction
									        </label> 
									    </div>
									</div>
	                            </div>
	                            <hr>
	                            <div class="row">
	                            	<div class="col-lg-3 col-md-6">
	                            		<div class="row">
	                            			<label for="exampleInputuname3" class="col-sm-3 col-lg-2 control-label">Service</label><div class="form-group col-sm-9 col-lg-10"><select id="serviceInclu1" class="form-control form-control-sm">
	                            				<option value=""></option>
	                            				<?php
	                            				foreach ($service->recupererServices() as $value) 
												{
												?>
													<option value="<?=$value->ID_service?>"><?=$value->nomService?></option>
												<?php
												}
	                            				?>
	                            			</select>
	                            			</div>
	                            		</div>
	                            	</div>
                        			<div class="col-lg-3 col-md-6">
                        				<div class="row">
                        					<label for="exampleInputuname3" class="col-sm-3 control-label">Bande passante</label>
                        					<div class="form-group col-sm-9">
	                                           <input type="text" id="bandepassanteInclu1" class="form-control form-control-sm" autocomplete="">
                        					</div>
	                            		</div>
	                            	</div>
	                            	<div class="col-lg-3 col-md-4">
	                            		<div class="row">
	                            			<label for="exampleInputuname3" class="col-sm-3 control-label">Montant</label><div class="form-group col-sm-9">
	                            				<div class="input-group">
	                            					<input type="number" class="form-control form-control-sm" id="montantInclu1">
	                            				</div>
	                            			</div>
	                            		</div>
	                            	</div>
	                            	<div class="col-lg-3 col-md-4">
	                            		<div class="row">
	                            			<label for="exampleInputuname3" class="col-sm-3 control-label">Quantite</label><div class="form-group col-sm-9">
	                            				<div class="input-group">
	                            					<input type="number" class="form-control form-control-sm" id="quantite1" value="1" min="1">
	                            				</div>
	                            			</div>
	                            		</div>
	                            	</div>
	                            </div>
	                            <div class="row">
	                            	<div class="col-lg-3 col-md-6">
	                            		<div class="row">
	                            			<label for="exampleInputEmail3" class="col-sm-3 control-label">Nom</label>
	                            			<div class="form-group col-sm-9">
	                            				<input type="text" class="form-control form-control-sm" id="nom_client1">
	                            			</div>
	                            		</div>
	                            	</div>
	                            	<div class="col-lg-3 col-md-6">
	                            		<div class="row">
	                            			<label for="exampleInputEmail3" class="col-sm-3 control-label">Adresse</label>
	                            			<div class="form-group col-sm-9">
	                            				<input type="text" class="form-control form-control-sm" id="adresse1">
	                            			</div>
	                            		</div>
	                            	</div>
	                            	<div class="col-lg-2 col-md-2">
										<div class="form-group">
									        <label class="form-control btn">
									            <input type="checkbox" id="show_on_invoice1"> sur facture
									        </label> 
									    </div>
									</div>
									<div class="col-lg-2 col-md-4">
	                            		<div class="row">
	                            			<label for="exampleInputEmail3" class="col-sm-3 control-label">Etat</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="contract_service_status1" class="form-control form-control-sm">
                                            	<?php
						    					foreach ($status as $key => $data) 
						    					{
					    						?>
					    							<option value="<?=$data?>"><?=$key?></option>
								    					
												<?php
						    					}
							    				?>
	                                            </select>
		                                    </div>
	                            		</div>
	                            	</div>
	                            </div>
	                            <div class="row">
								    <div class="col-lg-2">
								        <input type="number" id="nbServiceContract" value="1" hidden="">
								        <button type="button" style="background-color: #7c4a2f" class="btn text-white" onclick="ajoutServiceToContract()">
								            Service
								            <i class="ti-plus text"></i>
								        </button>
								    </div>
								</div>
								<hr>
								<div id="service_contener"></div>
	                            <!--<div id="divService"></div>
	                            <div class="row">
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
	                            <hr>
	                            <div class="row">
	                            	<div class="col-lg-5 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Facturation</label>
		                                    <div class="form-group col-sm-9">
		                                        <select id="facturation" class="form-control form-control-sm">
                                                    <?php
                                                    foreach ($periode as $key => $val) 
                                                    {
                                                    ?> 
                                                        <option value="<?=$val?>"><?=$key?></option>
                                                    <?php
                                                    }
                                                    ?>
	                                            </select>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-5 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Debut contract</label>
		                                    <div class="form-group col-sm-9">
		                     					<input type="date" class="form-control form-control-sm" id="startDateInclu" value="<?= date('Y-m-d')?>">
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-2 col-md-6">
	                            		<div class="row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">TVA</label>
		                                    <div class="form-group col-sm-9">
	                     						<input type="number" class="form-control form-control-sm" id="tvaInclu" value="18">
		                                    </div>
		                                </div>
	                            	</div>
	                            </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                        	<span id="msg"></span>
                            <button style="background-color: #7c4a2f" class="btn waves-effect text-left text-white" onclick="saveContract()"><i class="fa fa-check"></i>Enregistrer
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
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	   	 <!-- FILTRE -->
                <form action="<?=WEBROOT?>filtreContract" method="get" id="filtreContract">
                <div class="row">
                	<div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="numero" id="numero" class="form-control form-control-sm input-filter" autocomplete="on" placeholder="Numero" value="<?=$numero?>">
                        </div>
		            </div>
                	<div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="billing_number" id="billing_number" class="form-control form-control-sm input-filter" autocomplete="on" placeholder="billing number" value="<?=$billing_number?>">
                        </div>
		            </div>
		            <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="nom_client" id="nom_client" class="form-control form-control-sm input-filter" autocomplete="on" placeholder="Nom client" value="<?=$nom_client?>">
                            <div id="modal_contrat"></div>
                        </div>
		            </div>
		            <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <select name="service" id="service" class="form-control form-control-sm input-filter">
                                <option value="">Service</option>
                                <?php
                                foreach ($service->recupererServices() as $value) 
                                {
                                    if ($service_filter == $value->ID_service) {
                                ?>
                                        <option value="<?=$value->ID_service?>" selected><?=$value->nomService?></option>
                                <?php
                                    } else {
                                ?>
                                        <option value="<?=$value->ID_service?>"><?=$value->nomService?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="form-group">
                            <select name="status" id="contract_status" class="form-control form-control-sm input-filter">
                                <option value="">statut</option>
                                <?php
                                for ($l=0; $l < count($etat); $l++) 
                                {
                                	if ($status_filter == $etat[$l]) {
                        		?>
                                		<option value="<?=$etat[$l]?>" selected><?=$etat[$l]?></option>
                                <?php
                                	} else {
                                ?>
                                		<option value="<?=$etat[$l]?>"><?=$etat[$l]?></option>
                                <?php
                                	}
                                }
                                ?>
                            </select>
                        </div>
		            </div>
		            <div class="col-lg-2 col-md-3 col-sm-6">
                        <div class="form-group">
                            <input type="date" class="form-control form-control-sm input-filter" name="datecreation" id="datecreation">
                            <input type="text" name="print" id="print" value="0" hidden="">
                        </div>
		            </div>
		            <div class="col-lg-1 col-md-1">
		                <!--<button type="button" style="background-color: #7c4a2f" class="btn text-white waves-effect btn-rounded btn-sm"  onclick="filtre_contract($('#nom_client').val(),$('#serviceclient').val(),$('#datecreation').val(),$('#numero').val(),$('#billing_number').val())"><i class="ti ti-filter"></i> Filtrer</button>-->
		                <button type="submit" style="background-color: #7c4a2f" class="btn text-white waves-effect btn-rounded btn-sm"><i class="ti ti-filter"></i> Filtrer</button>
		            </div>
		            <div class="col-lg-1 col-md-1">
		                <button type="button" class="btn btn-primary waves-effect btn-rounded btn-sm" onclick="resetFiltreContract()"><i class="mdi mdi-refresh"></i> Reset</button>
		            </div>
		        </div>
		    </form>
		        <div class="table-responsive m-t-0">
		            <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                    	<th>Numero</th>
		                        <th>Client</th>
		                        <!--th>Type contract</th-->
		                        <th>Service</th>
		                        <th>date</th>
		                        <th>Prix mensuel</th>
		                        <th>Monnaie</th>
		                        <th>Etat</th>
		                        <th></th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                    	<th>Numero</th>
		                        <th>Client</th>
		                        <!--th>Type contract</th-->
		                        <th>Service</th>
		                        <th>date</th>
		                        <th>Prix mensuel</th>
		                        <th>Monnaie</th>
		                        <th>Etat</th>
		                        <th></th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php 
		                	$i = 0;
		                	$y = 0; 
		                	foreach($result as $value)
		                	{
		                		$i++;
		                	?> 
		                    <tr>
		                    	<td>
		                    		<a class="dropdown-item" href="<?= WEBROOT;?>detailContract-<?= $value->ID_contract;?>"> <?php echo $value->numero;?></a>
		                    	</td>
		                        <td><a href="<?= WEBROOT;?>detailClient-<?= $value->ID_client;?>"> <?php echo $value->billing_number.' /'. $value->Nom_client;?></a></td>
		                        <!--td><?= $value->type?> </td-->
		                        <td><?php
		                        $montant_total = 0;
		                        $serviceInclu = '';
	                        	foreach ($contract->getServiceToPrintToContract($value->ID_contract) as $value2) 
	                        	{
	                        		if ($value2->status == 0) 
	                        		{
	                        			$montant = $value2->montant*$value2->quantite;
	                        			$prixTva = $montant*$value->tva/100;
	                        			$montant_total += $montant+$prixTva;
	                        		}
	                        	 	$serviceInclu .= $value2->nomService.', ';
	                        	}
	                        	echo rtrim($serviceInclu,', ');
	                        	?>
		                        </td>
		                        <td><?php echo $value->date_creation?></td>
		                        <td>
		                        	<?= number_format(round($montant_total)).' '.strtoupper ($value->monnaie)?>
		                        </td>
		                        <td><?= $value->monnaie?></td>
		                        <td><?= $value->etat?></td>
		                        <td class="text-nowrap">
		                        	<a href="<?= WEBROOT;?>detailContract-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>
		                        	<a href="<?= WEBROOT;?>printContract-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>
		                        	
		                        	<?php
		                        	if ($m) 
	                        		{?>
		                        		<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
	                        		<?php
		                        	}
		                        	?>
		                        	<a href="<?= WEBROOT;?>verso_contrat-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Print"> Verso<i class="mdi mdi-printer-3d text-inverse m-r-10"></i></a>

        	<!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modification d'un contract</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                            	<div class="row">
                            		<div class="col-lg-10 col-md-10">
	                            		<div class="form-group row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 col-md-2 col-lg-1 control-label">Client</label>
		                                    <div class="col-sm-9 col-md-10 col-lg-11">
		                                        <div class="form-group">
		                                            <input type="text" id="client<?=$i?>" value="<?php echo $value->ID_client;?>" hidden>
		                                            <input type="text" class="form-control form-control-sm" value="<?php echo $value->Nom_client;?>" disabled>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-1 col-md-2">
										<div class="form-group">
									        <label class="form-control btn">
									        	<?php
									        	if ($value->show_rate == 'oui') 
									        	{
								        		?>
									        		<input type="checkbox" id="show_rate<?=$i?>" checked> affiche taux
								        		<?php
									        	}
									        	else
									        	{
								        		?>
									        		<input type="checkbox" id="show_rate<?=$i?>"> affiche taux
								        		<?php
									        	}
									        	?>
									        </label> 
									    </div>
									</div>
                            	</div>
	                            <div class="row">
	                            	<div class="col-lg-3 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Contract</label>
		                                    <div class="col-sm-9">
		                                        <div class="form-group">
		                                            <input type="text" class="form-control" id="numero<?=$i?>" value="<?php echo $value->ID_contract;?>" hidden>
                            <select id="monnaie<?=$i?>" class="form-control form-control-sm">
                            	<?php
                            	for ($l=0; $l < count($tbMonnaie); $l++) 
                            	{ 
                            		if ($tbMonnaie[$l] == $value->monnaie)
                            		{
                				?>
                            			<option value="<?php echo $tbMonnaie[$l];?>" selected><?php echo $tbMonnaie[$l];?></option>
                    			<?php
                            		}
                            		else
                            		{
                    			?>
                            			<option value="<?php echo $tbMonnaie[$l];?>"><?php echo $tbMonnaie[$l];?></option>
                    			<?php
                            		}
                            	}
                            	?>
                            </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-4 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 col-lg-6 control-label">Facture</label>
		                                    <div class="col-sm-9 col-lg-6">
		                                        <div class="form-group">
		                                            <select id="monnaie_facture<?=$i?>" class="form-control form-control-sm">
		                                            	<?php
                            	for ($l=0; $l < count($tbMonnaie); $l++) 
                            	{ 
                            		if ($tbMonnaie[$l] == $value->monnaie_facture)
                            		{
                				?>
                            			<option value="<?php echo $tbMonnaie[$l];?>" selected><?php echo $tbMonnaie[$l];?></option>
                    			<?php
                            		}
                            		else
                            		{
                    			?>
                            			<option value="<?php echo $tbMonnaie[$l];?>"><?php echo $tbMonnaie[$l];?></option>
                    			<?php
                            		}
                            	}
                            	?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-4 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Mode</label>
		                                    <div class="col-sm-9">
		                                        <div class="form-group">
		                                            <select id="mode<?=$i?>" class="form-control form-control-sm">
                                        	<?php
                                        	for ($l=0; $l < count($mode); $l++) 
                                        	{ 
                                        		if ($mode[$l] == $value->mode) 
                                        		{
                                			?>
                                        			<option value="<?php echo $mode[$l];?>" selected><?php echo $mode[$l];?></option>
                                			<?php
                                        		}
                                        		else
                                        		{
                                			?>
                                        			<option value="<?php echo $mode[$l];?>"><?php echo $mode[$l];?></option>
                                			<?php
                                        		}
                                        	}
                                        	?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row-->

	                            <div class="row">
	                            	<div class="col-lg-3 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Etat</label>
		                                    <div class="col-sm-9">
		                                        <div class="form-group">
		                                            <select id="etat<?=$i?>" class="form-control form-control-sm">
                                            	<?php
                                            	for ($l=0; $l < count($etat); $l++) 
                                            	{ 
                                            		if ($etat[$l] == $value->etat) 
                                            		{
                                    			?>
                                            			<option value="<?=$etat[$l]?>" selected><?=$etat[$l]?></option>
                                    			<?php
                                            		}
                                            		else
                                            		{
                                    			?>
                                            			<option value="<?=$etat[$l]?>"><?=$etat[$l]?></option>
                                    			<?php
                                            		}
                                            	}
												?>
		                                            </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-5 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Profil Article*</label>
                                            <div class="form-group col-sm-9">
                                                <select class="form-control form-control-sm" id="profil<?=$i?>">
                                            <?php
                                            foreach ($article->getProfils() as $profil)
                                            {
                                            	if ($value->profil_id == $profil->profil_id) 
                                            	{
                                    		?>
                                            		<option value="<?=$profil->profil_id?>" selected><?=$profil->profil_name?></option>
                                    		<?php
                                            	}
                                            	else
                                            	{
                                    		?>
                                            		<option value="<?=$profil->profil_id?>"><?=$profil->profil_name?></option>
                                    		<?php
                                            	}
                                            }
                                            ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
										<div class="form-group">
									        <label class="form-control btn">
									        	<?php
									        	if ($value->enable_discounts == 1) 
									        	{
								        		?>
									        		<input type="checkbox" id="enable_discount<?=$i?>" checked="">
								        		<?php
									        	}
									        	else
									        	{
								        		?>
								        			<input type="checkbox" id="enable_discount<?=$i?>">
								        		<?php
									        	}
									        	?>
									            reduction
									        </label> 
									    </div>
									</div>
	                            </div><!-- End row-->
	                            <hr>

<?php 
$j = 0;
foreach ($contract->getServiceToPrintToContract($value->ID_contract) as $value3) 
{
	$j++;
    $y++;
?>
	<div class="row">
    	<div class="col-lg-4 col-md-4">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 control-label">
                Service</label>
                <div class="form-group col-sm-9">
                	<input type="text" id="serviceinclu_id<?=$value->ID_contract.$j?>" value="<?=$value3->id?>" hidden>
                	<select class="form-control form-control-sm" id="service<?=$value->ID_contract.$j?>">
                		<?php
        				foreach ($service->recupererServices() as $val) 
						{
							if ($value3->ID_service == $val->ID_service) 
							{
						?>
								<option value="<?=$val->ID_service?>" selected><?=$val->nomService?></option>
						<?php
							}
							else
							{
						?>
								<option value="<?=$val->ID_service?>"><?=$val->nomService?></option>
						<?php
							}
						?>
						<?php
						}
        				?>
                	</select>
                    <!--<input type="text" id="service<=$y?>" value="<=$value3->ID_service?>" hidden>
    				<input type="text" class="form-control" value="<=$value3->nomService?>">-->
    			</div>
    		</div>
    	</div>
    	<div class="col-lg-3 col-md-3">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Bande passante</label>
				<div class="form-group col-sm-9 col-lg-8">
					<input type="text" class="form-control form-control-sm" id="bandepassante<?=$value->ID_contract.$j?>" value="<?=$value3->bandepassante?>">
    			</div>
    		</div>
    	</div>
    	<div class="col-lg-3 col-md-3">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Montant</label>
				<div class="form-group col-sm-9 col-lg-8">
					<div class="form-group">
						<input type="number" class="form-control form-control-sm" id="montant<?=$value->ID_contract.$j?>" value="<?=$value3->montant?>">
					</div>
    			</div>
    		</div>
    	</div>
    	<div class="col-lg-2 col-md-4">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Quantite</label><div class="form-group col-sm-9 col-lg-7">
    				<input type="number" class="form-control form-control-sm" id="quantite<?=$value->ID_contract.$j?>" value="<?=$value3->quantite?>" min="0">
    			</div>
    		</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-lg-3 col-md-8">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-1 control-label">Nom</label>
    			<div class="form-group col-sm-9 col-lg-11">
                    <input type="text" id="sous_client<?=$value->ID_contract.$j?>" value="<?=$value3->ID_client?>" hidden>
                    <input type="text" class="form-control form-control-sm" id="nom<?=$value->ID_contract.$j?>" value="<?=$value3->nom?>">
                </div>
    		</div>
    	</div>
    	<div class="col-lg-3 col-md-8">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-1 control-label">Adresse</label>
    			<div class="form-group col-sm-9 col-lg-11">
                    <input type="text" class="form-control form-control-sm" id="adress<?=$value->ID_contract.$j?>" value="<?=$value3->adress?>">
                </div>
    		</div>
    	</div>
    	<div class="col-lg-2 col-md-4">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-1 control-label">Status</label>
    			<div class="form-group col-sm-9 col-lg-11">
    				<select id="satus_service<?=$value->ID_contract.$j?>" class="form-control form-control-sm">
    					<?php
    					foreach ($status as $key => $data) 
    					{
    						if ($value3->status == $data) 
		    				{
							?>
		    					<option value="<?=$data?>" selected><?=$key?></option>
		    				<?php
		    				}
		    				else
		    				{
							?>
		    					<option value="<?=$data?>"><?=$key?></option>
							<?php
		    				}
    					}
	    				?>
    				</select>
    			</div>
    		</div>
    	</div>
    	<div class="col-lg-2 col-md-2">
			<div class="form-group">
		        <label class="form-control btn">
		        	<?php
		        	if ($value3->show_on_facture == 1) 
		        	{
	        		?>
		        		<input type="checkbox" id="show_on_facture<?=$value->ID_contract.$j?>" checked="">
	        		<?php
		        	}
		        	else
		        	{
	        		?>
	        			<input type="checkbox" id="show_on_facture<?=$value->ID_contract.$j?>">
	        		<?php
		        	}
		        	?>
		            Afficher sur facture
		        </label> 
		    </div>
		</div>
    </div>
    <hr>
<?php
}
?>
<div class="row">
    <div class="col-lg-2">
        <button type="button" style="background-color: #7c4a2f" class="btn text-white" onclick="ajoutServiceToUpdateContract('<?=$value->ID_contract?>','<?=$i?>')">
            Service
            <i class="ti-plus text"></i>
        </button>
    </div>
</div>
<hr>
<div id="service_contener<?=$i?>"></div>
<input type="number" id="nombreServiceUpdate<?=$i?>" value="<?=$j?>" hidden>
<input type="number" id="i<?=$i?>" value="<?=$i?>" hidden>
<input type="number" id="id_dernierService<?=$i?>" value="<?=$y?>" hidden>

	                            <div class="row">
	                            	<div class="col-lg-5 col-md-6">
	                            		<div class="form-group">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Facturation</label>
		                                    <div class="col-sm-9">
		                                        <div class="form-group">
		                                           <select id="facturation<?=$i?>" class="form-control form-control-sm">
                                                        <?php
				                                    	foreach ($periode as $key => $val) 
				                                    	{
				                                    		if ($val == $value->facturation) 
				                                    		{
				                            			?>
				                                    			<option value="<?=$val?>" selected><?=$key?></option>
				                            			<?php
				                                    		}
				                                    		else
				                                    		{
				                            			?>
				                                    			<option value="<?=$val?>"><?=$key?></option>
				                            			<?php
				                                    		}
				                                    	}
				                                    	?>

		                                           </select>
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-5 col-md-6">
	                            		<div class="form-group">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Debut debut</label>
		                                    <div class="col-sm-9">
		                                        <div class="form-group">
		                                            <input type="date" id="startDate<?=$i?>" class="form-control form-control-sm" value="<?php echo $value->startDate;?>">
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                            	<div class="col-lg-2 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Tva</label>
		                                    <div class="col-sm-9">
		                                        <input type="number" class="form-control form-control-sm" id="tva<?=$i?>" value="<?=$value->tva?>" min="0">
		                                    </div>
		                                </div>
	                            	</div>
	                            </div><!-- End row -->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #7c4a2f" class="btn text-white waves-effect" onclick="updateContract($('#numero<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#monnaie_facture<?=$i?>').val(),$('#mode<?=$i?>').val(),$('#etat<?=$i?>').val(),$('#client<?=$i?>').val(),$('#facturation<?=$i?>').val(),$('#startDate<?=$i?>').val(),$('#tva<?=$i?>').val(),$('#i<?=$i?>').val(),$('#id_dernierService<?=$i?>').val(),$('#profil<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-pencil"></i>Modifier
     						</button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

<?php
	if ($s) 
	{?>
		<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
	<?php
	}
?>

<!-- sample modal content -->
<div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer Contract</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
            	<input type="text" class="form-control" id="deleteContractNum<?= $i?>" value="<?=$value->ID_contract?>" hidden>
            	Voulez-vous supprimer ce contract?
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteContract($('#deleteContractNum<?= $i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
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

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>