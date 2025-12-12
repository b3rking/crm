<?php
ob_start(); 
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
			<div class="card-header text-white font-bold" style="background-color: #FF8300;padding: 0.1rem"><h4>HISTORIQUE D'ACTION</h4>
		    </div>
		    <div class="card-body">
		    	<div class="row">
		    		<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
		    			<div class="form-group row">
		                    <label class="col-sm-3 form-control-label" for="type">Type</label>
		                    <div class="col-sm-6 col-md-8 col-lg-8 col-xl-8">
		                    	<select class="form-control form-control-sm" id="type">
		                    		<option value=""></option>
		                    		<option value="client">Client</option>
		                    		<option value="contrat">Contrat</option>
		                    		<option value="facture">Facture</option>
                                    <option value="proformat">Proformat</option>
		                    		<option value="equipement">Equipement</option>
		                    		<option value="payement">Payement</option>
		                    		<option value="banque">Banque</option>
		                    		<option value="versement">Verssement</option>
		                    		<option value="caisse">Caisse</option>
		                    		<option value="depense">Depense</option>
		                    		<option value="extrat">Extrat</option>
		                    		<option value="ticket">Ticket</option>
		                    		<option value="pointAcces">Point d'acces</option>
		                    		<option value="secteur">Secteur</option>
		                    	</select>
		                    </div>
		                </div>
		    		</div>
		    		<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
		    			<div class="form-group row">
		                    <label class="col-sm-3 form-control-label" for="date1">Date1</label>
		                    <div class="col-sm-6 col-md-8 col-lg-8 col-xl-8">
		                        <input type="date" id="date1" name="example-input-small" class="form-control form-control-sm">
		                    </div>
		                </div>
		    		</div>
		    		<div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
		    			<div class="form-group row">
		                    <label class="col-sm-3 form-control-label" for="date2">Date2</label>
		                    <div class="col-sm-6 col-md-8 col-lg-8 col-xl-8">
		                        <input type="date" id="date2" name="date2" class="form-control form-control-sm">
		                    </div>
		                </div>
		    		</div>
		    		<div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
		    			<div class="form-group row">
		                    <label class="col-sm-3 form-control-label" for="action">Action</label>
		                    <div class="col-sm-6 col-md-8 col-lg-8 col-xl-8">
		                    	<select id="historiAction" name="historiAction" class="form-control form-control-sm">
		                    		<option value=""></option>
		                    		<option value="creer">Creer</option>
		                    		<option value="modifier">Modifier</option>
		                    		<option value="supprimer">Supprimer</option>
		                    	</select>
		                    </div>
		                </div>
		    		</div>
		    		<div class="col-lg-1 col-md-1">
		                <button type="button" style="background-color: #8b4513" class="btn waves-effect waves-light btn-rounded btn-sm font-light text-white" onclick="filtreHistorique($('#type').val(),$('#date1').val(),$('#date2').val(),$('#historiAction').val())"><i class="ti ti-filter"></i> Filtrer</button>
		            </div>
		            <div class="col-lg-1 col-md-1">
		                <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-danger" onclick="resetFiltreHistorique()"><i class="mdi mdi-refresh"></i> Reset</button>
		            </div>
		    	</div>
		        <div class="table-responsive m-t-0">
		            <table id="myTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>TYPE</th>
		                        <th>DATE</th>
		                        <th>EFFECTUER PAR</th>
		                        <th>ACTION</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>TYPE</th>
		                        <th>DATE</th>
		                        <th>EFFECTUER PAR</th>
		                        <th>ACTION</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php
		                	foreach ($historique->getHistoriqueActions() as $value) 
		                	{
	                		?>
		                		<tr>
			                        <td><?=$value->type?></td>
			                        <td><?=$value->dateAction?></td>
			                        <td><?=$value->nom_user?></td>
			                        <td><?=$value->action?></td>
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