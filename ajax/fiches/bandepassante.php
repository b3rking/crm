<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");

$ticket = new ticket();
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div class="row">
		    		<div class="col-sm-6 col-md-3 col-lg-3"></div>
		    		<div class="col-lg-6 col-md-6 align-self-center">
		    			<h4 class="text-themecolor">Fiche d'augmentation de bande passante</h4>
		    		</div>
			    </div>

			    <form class="form-horizontal p-t-20" action="/crm.buja/genficheBP" method="post">
			   <div class="row">
			        <div class="col-lg-6 col-md-6">
			        	<div class="row">
			        		<label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
			                <div class="form-group col-sm-9">
			                    <input type="text" id="idclient" class="form-control" autocomplete="off" name="idclient">
			                        <div id="modal"></div>
			                </div>
			        	</div>
		            </div>
			   		<div class="col-sm-6 col-md-6 col-lg-6">
			   			<div class="row">
			   				<label for="exampleInputEmail3" class="col-sm-3 col-md-3 col-lg-3 control-label">Bande passante</label>
			                <div class="col-sm-6 col-md-7 col-lg-7">
			                    <div class="form-group">
			                        <input type="number" class="bootstrapMaterialDatePicker form-control" id="dateInstallation" name="bandepassante" value="1" min="1">
			                    </div>
			                </div>
			                <label for="exampleInputEmail3" class="col-sm-3 col-md-2 col-lg-2 control-label">
			                Mbps</label>
			   			</div>
			   		</div>
			    </div>
			    <div class="row">
			        <div class="col-lg-6 col-md-6">
			        	<div class="row">
			        		<label for="exampleInputEmail3" class="col-sm-3 control-label">Augmenter à partir du</label>
			                <div class="col-sm-9">
			                    <div class="form-group">
			                        <input type="date" class="bootstrapMaterialDatePicker form-control" id="datedebut" name="datedebut">
			                    </div>
			                </div>
			        	</div>
		            </div>
			   		<div class="col-sm-6 col-md-6 col-lg-6">
			   			<div class="row">
			   				<label for="exampleInputEmail3" class="col-sm-3 control-label">Au</label>
			                <div class="col-sm-9">
			                    <div class="form-group">
			                        <input type="date" class="bootstrapMaterialDatePicker form-control" id="datefin" name="datefin">
			                    </div>
			                </div>
			   			</div>
			   		</div>
			    </div>
			    <div class="row">
			    	<div class="col-sm-6 col-md-6 col-lg-6">
			    		<?php
			    			if (isset($msg)) 
			    			{
			    				echo $msg;
			    			}
			    		?>
			    	</div>
			    	<div class="col-sm-3 col-md-3 col-lg-3">
			    		<button type="submit" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Generer</button>
			    	</div>
			    </div>
			    </form>
			    <hr>
			    <div class="table-responsive m-t-40">
			    	<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Creation</th>
                       			<th>Bande P</th>
                       			<th>Debut</th>
                       			<th>Fin</th>
                       			<th>Client</th>
                       			<th>Statut</th>
                       			<th></th>    
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Creation</th>
                       			<th>Bande P</th>
                       			<th>Debut</th>
                       			<th>Fin</th>
                       			<th>Client</th>
                       			<th>Statut</th>
                       			<th></th> 
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                                <?php
                                $i =0;
                                foreach ($ticket->recupererFicheBandepanssantes() as $value) 
                                {
                                    $i++;
                                    ?>
                                    <tr>
                                <td><?php echo $value->date_creation?></td>
                                <td>
                                    <?php echo $value->bandeP;?>
                                </td>
                                <td>
                                    <?php echo $value->dateDebut;?>
                                </td>
                                <td>
                                    <?php echo $value->dateFin;?>
                                </td>
                                <td><?php echo $value->Nom_client;?></td>
                                <td><?php if($value->status=='ouvert')
                                {
                                    ?>
                                    <span class="label label-danger"><?php echo $value->status?></span>
                                    <?php
                                }
                                elseif($value->status == 'fermer') 
                                {?>
                                    <span class="label label-success"> <?php echo $value->status?></span>
                                <?php   
                                }
                                ?>
                                </td>
                                <!--<td><?php  $value->description?></td>-->
                               <!--debut td bouton modification   -->
                                <td class="text-nowrap">
                                    <a href="/crm.buja/regenfichebandepassante-<?php echo $value->ID_fiches?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>
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