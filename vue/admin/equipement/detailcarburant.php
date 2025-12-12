<?php
ob_start();
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
            <div class="card-header text-white" style="background-color: orange">
                Detail du carburant : <strong><?= strtoupper($carburant)?></strong>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs customtab2" role="tablist">
                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#entree" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Les entrees</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#sorties" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Distribution</span></a> </li>
                    <!--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Messages</span></a> </li>-->
                </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="entree" role="tabpanel">
                    <div class="p-20">
                    	<div class="table-responsive m-t-0">
				            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
				               <thead>
        		                    <tr>
                                        <th>Quantite en litre</th>
                                        <th>Prix / Litre</th>
                                        <th>Date</th>
        		                    </tr>
        		                </thead>
    		                    <tfoot>
    					            <tr>
                                        <th>Quantite en litre</th>
                                        <th>Prix / Litre</th>
                                        <th>Date</th>
    					            </tr>
    					        </tfoot>
		                        <tbody id="reponse">
                           
                            <?php $i =0; 
                            foreach ($equipement->getHistoStockCarburant($carburant) as$value) 
                            { $i++; 
                                ?>
                                <tr>
                                    <td><?php echo $value->quantite?></td>
                                    <td><?php echo $value->prix_par_litre.' BIF'?></td>
                                    <td><?php echo $value->datestock?></td>
			                    </tr>
		                	<?php
		                	}
		                	?>
		                </tbody>
		            </table>
        		</div>	
            </div>
        </div>
        <div class="tab-pane p-20" id="sorties" role="tabpanel">
            <div class="table-responsive m-t-0">
	            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
	                <thead>
	                    <tr>
	                        <th>Consommateur </th>
                            <th>Quantite en litre</th>
                            <th>Date</th>   
	                    </tr>
	                </thead>
	                <tfoot>
			            <tr>  
                            <th>Consommateur </th>
                            <th>Quantite en litre</th>
                            <th>Date</th>
			            </tr>
			        </tfoot>
                    <tbody id="reponse"> 
         
                    <?php $i =0; 
                    foreach ($equipement->affiche_distribution_par_carburant($carburant) as$value) 
                    { $i++; 
                        ?>
                        <tr>
                            <td><?php echo $value->consommateur?></td>
                            <td><?php echo $value->quantite?></td>
                            <td><?php echo $value->datedistribution?></td>
                        </tr>
	                	<?php
	                	}
	                	?>
	                </tbody>
	            </table>
    		</div>
        </div>
        <div class="tab-pane p-20" id="messages7" role="tabpanel">3</div>
        </div>
    </div>
</div>
</div>
</div>
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>