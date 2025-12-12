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
		    		<div class="col-sm-6 col-md-6 col-lg-6"></div>
		    		<div class="col-lg-6 col-md-6 align-self-center">
		    			<h4 class="text-themecolor">Fiche d'installation</h4>
		    		</div>
			    </div>

			    <form class="form-horizontal p-t-20" action="/crm.buja/genficheinstallation" method="post">
			                                 <!-- Debut premiere ligne-->
			   <div class="row">
			   		<div class="col-sm-3 col-md-3 col-lg-3"></div>
			        <div class="col-lg-6 col-md-6">
			            <div class="row">
			                <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
			                <div class="form-group col-sm-9">
			                    <input type="text" id="idclient" class="form-control" autocomplete="off" name="idclient">
			                        <div id="modal"></div>
			                </div>
			            </div>
			        	<div class="row">
			                <label for="exampleInputEmail3" class="col-sm-3 control-label">Date d'installation</label>
			                <div class="col-sm-9">
			                    <div class="form-group">
			                        <input type="date" class="form-control" id="dateInstallation" name="dateInstallation">
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
			    		<button type="submint" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Fiche D'installation</button>
			    	</div>
			    </div>
			    <hr>
			    </form>
			    <div class="table-responsive m-t-40">
			    	<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Creation</th>
                       			<th>Date installation</th>
                       			<th>Client</th>
                       			<th>Statut</th>
                       			<th></th>    
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Creation</th>
                       			<th>Date installation</th>
                       			<th>Client</th>
                       			<th>Statut</th>
                       			<th></th> 
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                                <?php
                                $i =0;
                                foreach ($ticket->recupererFicheInstallations() as $value) 
                                {
                                    $i++;
                                    ?>
                                    <tr>
                                <td><?php echo $value->date_creation?></td>
                                <td>
                                    <?php echo $value->dateInstallation;?>
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
                                    <a href="/crm.buja/regenficheinstallation-<?php echo $value->ID_fiches?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>
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