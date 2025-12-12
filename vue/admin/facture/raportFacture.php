<?php
ob_start();
$date = date_parse(date('Y-m-d'));
$mois = $date['month'];
$annee = $date['year'];
$mois_etiquete = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
$tbMonnaie = ['USD','BIF'];
?>
<input type="text" id="webroot" value="<?=WEBROOT?>" hidden>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">

    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white" onclick="submitRaportFacturePayerIpayer()"><i class="fa fa-file"></i> Génerer rapport</button>

            <form class="form-horizontal p-t-0" action="<?=WEBROOT?>printraport_client_parmois" method="post" id="form-customer">
            	<input type="text" id="cond" name="cond" hidden="">
            	<input type="text" id="type" name="type" hidden="">
            
           
        </div>
    </div>
</div>
  

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div class="row">
                
                    <div class="col-lg-3 col-md-3">
                        <div class="row">
                        	<label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
	                    	<div class="form-group">
		                        <select id="mois_creation" name="mois_creation" class="form-control">
		                        	<option value="">Mois</option>
				                	<option value="1">Janvier</option>
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
				                	<option value="12">Decembre</option>
				                </select>
	                        </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="row">
	                        <label for="exampleInputEmail3" class="col-sm-3 col-lg-5 control-label">Annee</label>
	                        <div class="form-group col-sm-9 col-lg-7">
	                        	<input type="number" class="form-control" name="annee_fact" id="annee_fact" value="<?=date('Y')?>">
	                        </div>
	                    </div>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <button type="button" style="background-color: #8b4513"class="btn waves-effect waves-light btn-rounded btn-sm font-light text-white" onclick="filtrenew_client($('#mois_creation').val(),$('#annee_fact').val())"><i class="ti ti-filter"></i> Filtrer</button>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <button type="button"class="btn waves-effect waves-light btn-rounded btn-sm btn-danger" onclick="resetFiltreRaportFacture()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                    </div></form>
                </div>
                <div id="repCalcul"></div>
		        <div class="table-responsive m-t-0">
		            <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Date</th>
		                        <th>Numero</th>
		                        <th>Client</th>
		                        <th>Etat</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Date</th>
		                        <th>Numero</th>
		                        <th>Client</th>
		                        <th>Etat</th>
		                        
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                <?php
		                $i = 0;
		                $y = 0;
		                $mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
		                foreach ($client->getallClient(date('m'),date('Y')) as $value) 
		                {
		                	$i++;
		                ?>
		                	<tr>
		                        <td><?=$value->date_creation?></td>
		                        <td><?=$value->billing_number?></td>
		                        <td>
		                        	<a href="<?= WEBROOT;?>detailClient-<?= $value->ID_client;?>"><b><?php echo iconv('UTF-8', 'windows-1252', $value->Nom_client);?></b></a>
	                        	</td>
		                        <td><?=$value->etat?></td>
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