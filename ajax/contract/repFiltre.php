<?php
    $mode = ['impression','mail','manuel'];
    $periode = ['mensuele','trimestriele','semestriele','annuele'];
    $etat = ['activer','suspension','pause','terminer'];
    $status = ['active' => 0,'annuler' => 1];
	$i = 0;
	$y = 0; 
	foreach($contract->filtre_contract($condition) as $value)
	{
		$i++;
	?> 
    <tr>
        <td>
            <a class="dropdown-item" href="<?= $webroot;?>detailContract-<?= $value->ID_contract;?>"> <?php echo $value->numero;?></a>
        </td>
        <td><a href="<?= $webroot;?>detailClient-<?= $value->ID_client;?>"> <?php echo $value->billing_number.'/'.$value->Nom_client;?></a></td>
        <!--td><?= $value->type?> </td-->
        <td><?php
        $montant_total = 0;
        $serviceInclu = '';
        foreach ($contract->getServiceToPrintToContract($value->ID_contract) as $value2) 
        {
            if ($value2->status == 0) 
            {
                $montant = $value->montant*$value2->quantite;
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
            <?= round($montant_total).' '.strtoupper ($value->monnaie)?>
        </td>
        <td><?= $value->monnaie?></td>
        <td><?= $value->etat?></td>
        <td class="text-nowrap">
            <a href="<?= $webroot;?>detailContract-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>
            <a href="<?= $webroot;?>printContract-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>
            
            <?php
            if ($m) 
            {?>
                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
            <?php
            }
            ?>
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
                	<input type="text" id="serviceinclu_id<?=$y?>" value="<?=$value3->id?>" hidden>
                	<select class="form-control form-control-sm" id="service<?=$y?>">
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
                    <!--<input type="text" id="service<?=$y?>" value="<?=$value3->ID_service?>" hidden>
    				<input type="text" class="form-control" value="<?=$value3->nomService?>">-->
    			</div>
    		</div>
    	</div>
    	<div class="col-lg-3 col-md-3">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Bande passante</label>
				<div class="form-group col-sm-9 col-lg-8">
					<input type="text" class="form-control form-control-sm" id="bandepassante<?=$y?>" value="<?=$value3->bandepassante?>">
    			</div>
    		</div>
    	</div>
    	<div class="col-lg-3 col-md-3">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Montant</label>
				<div class="form-group col-sm-9 col-lg-8">
					<div class="form-group">
						<input type="number" class="form-control form-control-sm" id="montant<?=$y?>" value="<?=$value3->montant?>">
					</div>
    			</div>
    		</div>
    	</div>
    	<div class="col-lg-2 col-md-4">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Quantite</label><div class="form-group col-sm-9 col-lg-7">
    				<input type="number" class="form-control form-control-sm" id="quantite<?=$y?>" value="<?=$value3->quantite?>" min="0">
    			</div>
    		</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-lg-3 col-md-8">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-1 control-label">Nom</label>
    			<div class="form-group col-sm-9 col-lg-11">
                    <input type="text" id="sous_client<?=$y?>" value="<?=$value3->ID_client?>" hidden>
                    <input type="text" class="form-control form-control-sm" id="nom<?=$y?>" value="<?=$value3->nom?>">
                </div>
    		</div>
    	</div>
    	<div class="col-lg-3 col-md-8">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-1 control-label">Adresse</label>
    			<div class="form-group col-sm-9 col-lg-11">
                    <input type="text" class="form-control form-control-sm" id="adress<?=$y?>" value="<?=$value3->adress?>">
                </div>
    		</div>
    	</div>
    	<div class="col-lg-2 col-md-4">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 col-lg-1 control-label">Status</label>
    			<div class="form-group col-sm-9 col-lg-11">
    				<select id="satus_service<?=$y?>" class="form-control form-control-sm">
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
		        		<input type="checkbox" id="show_on_facture<?=$y?>" checked="">
	        		<?php
		        	}
		        	else
		        	{
	        		?>
	        			<input type="checkbox" id="show_on_facture<?=$y?>">
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
                                    	for ($l=0; $l < count($periode); $l++) 
                                    	{
                                    		if ($periode[$l] == $value->facturation) 
                                    		{
                            			?>
                                    			<option value="<?$periode[$l]?>" selected><?=$periode[$l]?></option>
                            			<?php
                                    		}
                                    		else
                                    		{
                            			?>
                                    			<option value="<?$periode[$l]?>"><?=$periode[$l]?></option>
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