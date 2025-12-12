<?php
ob_start();
?>
<form class="form-horizontal p-t-20" id="filtreSortieBanque" action="<?=WEBROOT?>bankReport" method="get">
<div class="row">
    <div class="col-lg-2 col-md-3">
        <div class="form-group">
            <input type="date" name="date1" id="dateSortie1" class="form-control form-control-sm input-filter">
        </div>
    </div>
    <div class="col-lg-2 col-md-3">
        <div class="form-group">
        	<input type="date" name="date2" id="dateSortie2" class="form-control form-control-sm input-filter">
        </div>
    </div>
    <div class="col-lg-2 col-md-6">
        <div class="input-group">
            <select class="form-control form-control-sm input-filter"  id="moisSortie" name="mois">
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
    <div class="col-lg-2 col-md-3">
        <div class="form-group">
        <input type="number" name="annee" id="anneeSortie" class="form-control form-control-sm input-filter" value="<?=date('Y')?>">
        <input type="text" name="banque" value="<?=$id?>" hidden>
        </div>
    </div>
    <!--<div class="col-lg-1 col-md-1">
        <button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtreSortieBanque($('#dateSortie1').val(),$('#dateSortie2').val(),$('#moisSortie').val(),$('#anneeSortie').val(),$('#idbanqueSortie').val())"><i class="ti ti-filter"></i> Filtrer</button>
    </div>
    <div class="col-lg-1 col-md-1">
        <button type="button" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltreDepense()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
    </div>-->
    <div class="col-md-1 col-lg-1">
    	<button type="submit" style="background-color: #7c4a2f" class="btn text-white"><i class="mdi mdi-printer"></i> Generer rapport</button>

		<!--<form class="form-horizontal p-t-20" id="filtreSortieBanque" action="<=WEBROOT?>rapportSortieBanque" method="post">
        	<input type="text" name="conditionSortie" id="conditionSortie" hidden="">
        	<input type="text" name="idbanqueSortie" id="idbanqueSortie" value="<=$id?>" hidden>
        </form>-->
    </div>
   </div>
   </form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
    	<div class="card">
			<div class="card-header" style="background-color:#ef7f22; text-align: center;height: 1.2rem;padding-top: 0">
                <h5 class="text-white">Detail entrees <?=$comptabilite->getNomBanque($id)->fetch()['nom']?></h5>
            </div>
		    <div class="card-body">
		    	<!--<div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
	                    <input type="date" id="date1" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                    	<input type="date" name="date2" id="date2" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="input-group">
                        <select class="form-control form-control-sm"  id="mois" name="mois">
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
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                    	<select class="form-control form-control-sm" id="provenance">
                    		<option value="">Provenance</option>
                    		<option value="paiement">Paiement</option>
                    	</select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                    <input type="number" id="annee" class="form-control form-control-sm" value="<=date('Y')?>">
                    </div>
                </div>
                <div class="col-lg-1 col-md-1">
                    <button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtreEntrerBanque($('#date1').val(),$('#date2').val(),$('#mois').val(),$('#provenance').val(),$('#annee').val(),$('#idbanque').val())"><i class="ti ti-filter"></i> Filtrer</button>
                </div>
                <div class="col-lg-1 col-md-1">
                    <button type="button" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltreDepense()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                </div>
                <div class="col-md-1 col-lg-1">
                	<button type="button" class="btn btn-primary" onclick="submitFiltreEntrerBanque()"><i class="mdi mdi-printer"></i></button>

					        <form class="form-horizontal p-t-20" id="filtreEntrerBanque" action="<=WEBROOT?>rapportEntrerBanque" method="post">
	                	<input type="text" name="condition" id="condition" hidden="">
	                	<input type="text" name="idbanque" id="idbanque" value="<=$id?>" hidden>
	                </form>
                </div>
               </div>-->
		        <div class="table-responsive m-t-0">
              <h5><?php
              $banque = $comptabilite->getMontantBanque($id)->fetch();
              echo "Montant disponible : ".$banque['montant']." ".$banque['monnaie'];
              ?></h5>
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
	                <thead>
	                    <tr>
	                    	<th>Date</th>
	                        <th>Montant</th>
	                        <th>Libelle</th>
	                    </tr>
	                </thead>
	                <tfoot>
	                    <tr>
	                    	<th>Date</th>
	                        <th>Montant</th>
	                        <th>Libelle</th>
	                    </tr>
	                </tfoot>
	                <tbody id="repEntrer">
	                    <?php
	                	$i =0;
	                	foreach ($comptabilite->getHistoriqueEntrerBanque($id)as $value) {?>
	                	<tr>
	                		<td><?=$value->date_operation?></td>
	                        <td><?=$value->debit.' '.$value->monnaie?></td>
	                        <td><?=$value->reference?></td>
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

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
    	<div class="card">
			<div class="card-header" style="background-color:#ef7f22; text-align: center;height: 1.2rem;padding-top: 0">
                <h5 class="m-b-0 text-white">Detail sorties <?=$comptabilite->getNomBanque($id)->fetch()['nom']?></h5>
            </div>
		    <div class="card-body">
		    	<!--<div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
	                    <input type="date" id="dateSortie1" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                    	<input type="date" name="date2" id="dateSortie2" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="input-group">
                        <select class="form-control form-control-sm"  id="moisSortie" name="moisSortie">
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
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                    <input type="number" id="anneeSortie" class="form-control form-control-sm" value="<=date('Y')?>">
                    </div>
                </div>
                <div class="col-lg-1 col-md-1">
                    <button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtreSortieBanque($('#dateSortie1').val(),$('#dateSortie2').val(),$('#moisSortie').val(),$('#anneeSortie').val(),$('#idbanqueSortie').val())"><i class="ti ti-filter"></i> Filtrer</button>
                </div>
                <div class="col-lg-1 col-md-1">
                    <button type="button" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltreDepense()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                </div>
                <div class="col-md-1 col-lg-1">
                	<button type="button" class="btn btn-primary" onclick="submitFiltreSortieBanque()"><i class="mdi mdi-printer"></i></button>

					<form class="form-horizontal p-t-20" id="filtreSortieBanque" action="<=WEBROOT?>rapportSortieBanque" method="post">
	                	<input type="text" name="conditionSortie" id="conditionSortie" hidden="">
	                	<input type="text" name="idbanqueSortie" id="idbanqueSortie" value="<=$id?>" hidden>
	                </form>
                </div>
               </div>-->
		        <div class="table-responsive m-t-0">
		            <table id="sotirBanqueTb" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Date</th>
		                        <th>Montant</th>
		                        <th>Libelle</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                    	<th>Date</th>
		                        <th>Montant</th>
		                        <th>Libelle</th>
		                    </tr>
		                </tfoot>
		                <tbody id="repSortie">
		                    <?php
		                	$i =0;
		                	foreach ($comptabilite->getHistoriqueSortieBanque($id)as $value) {?>
		                	<tr>
		                		<td><?= $value->date_operation?></td>
		                        <td><?= $value->credit.' '.$value->monnaie?></td>
		                        <th><?=$value->libelle?></th>
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