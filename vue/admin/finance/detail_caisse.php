<?php
ob_start(); 
?>

<div class="row">
    <input type="text" id="idusers"  value="<?php echo $_SESSION['ID_user']?>" hidden>
    <input type="text" id="page" value="detail" hidden="">
	<div class="col-lg-9 col-md-12 col-xl-12"> 
		<div class="card">
			<div class="card-header" style="background-color:#8b4513; text-align: center;">
                <h5 class="m-b-0 text-white">Detail sorties <?=$comptabilite->getNomCaisse($idcaisse)->fetch()['nomCaisse']?></h5>
            </div>
		    <div class="card-body">
		    	<div class="row">
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
                    <input type="number" id="annee" class="form-control form-control-sm" value="<?=date('Y')?>">
                    </div>
                </div>
                <div class="col-lg-2 col-md-1">
                    <button type="button" style="background-color:#8b4513;"class="btn btn-sm
                     text-white"onclick="filtreSortieCaisse($('#date1').val(),$('#date2').val(),$('#mois').val(),$('#annee').val(),$('#idcaisse').val())"><i class="ti ti-filter"></i> Filtrer</button>
                </div>
                <div class="col-lg-2 col-md-1">
                    <button type="button" class="btn btn-sm btn-dark"onclick="resetFiltreDepense()"><i class="mdi mdi-refresh"></i> Reset</button>
                </div>
                <div class="col-md-1 col-lg-1">
                	<button type="button" style="background-color:#ef7f22;"  class="btn btn- text-white" onclick="submitFiltreSortieCaisse()"><i class="mdi mdi-printer"></i>imprimer</button>

					        <form class="form-horizontal p-t-20" id="filtreSortieCaisse" action="<?=WEBROOT?>rapportSortieCaisse" method="post">
	                	<input type="text" name="condition" id="condition" hidden="">
	                	<input type="text" name="idcaisse" id="idcaisse" value="<?=$idcaisse?>" hidden>
	                </form>
                </div>
               </div>
		          <div class="table-responsive m-t-0">
		            <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Date </th>
		                        <th>Montant</th>
		                        <th>Motif de la depense</th>
		                        <th>Destination</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Date </th>
		                        <th>Montant</th>
		                        <th>Motif de la depense</th>
		                        <th>Destination</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php
		                	$i =0;
		                	foreach ($comptabilite->getHistoriqueSortieDuneCaisse($idcaisse)as $value) {?>
		                	<tr>
		                        <td><?php echo $value->date_sortie?></td>
		                        <td><?php echo $value->montant_sortie.' '.$value->devise?></td>
		                        <td><?php echo $value->motif?></td>
		                        <td><?php echo $value->destination?></td>
		                        <!--td><php echo $value->reponsableCaisse?></td--> 
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
    <div class="col-lg-3 col-md-12 col-xl-12"> 
        <div class="card">
            <div class="card-body">
                <h6><?php $caisse = $comptabilite->getCaisse($idcaisse)->fetch();
                echo "Montant  : ".$caisse['montantCaisse'].' '.$caisse['devise'];
                ?></h6>
                <h6>
                    <?php echo "Ligne de credit : ".$caisse['lignecredit']?>
                </h6>
                <h6><?='Statut : '.$caisse['etat']?></h6>
                <h6><?='Type : '.$typeCaisse[$caisse['typeCaisse']]?></h6>
                <button type="button" class="btn btn-rounded btn-sm btn-danger" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-pencil text-inverse m-r-0"></i> Modifier</button>
                <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Modification de la caisse</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal p-t-20">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Nom Caisse</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  id="nomcaisse" value="<?php echo $caisse['nomCaisse']?>">
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Monnaie</label>
                <div class="col-sm-9">
                    <select class="form-control"  id="devise">
                      <option value="<?php echo $caisse['devise']?>"><?php echo $caisse['devise']?></option>
                      <!--<option value="FC">FC</option>
                      <option value="USD">USD</option>-->
                    </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Ligne de credit</label>
                <div class="col-sm-9">
                  <input name="lignecredit" class="form-control" type="number" id="lignecredit" value="<?php echo $caisse['lignecredit']?>">
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Statut</label>
                <div class="col-sm-9">
                  <select class="form-control" id="statut">
                    <?php
                    if ($caisse['etat'] == 'active') 
                    {?>
                        <option value="active" selected="">active</option>
                        <option value="desactive">desactive</option>
                    <?php
                    }
                    else
                    {?>
                        <option value="active">active</option>
                        <option value="desactive" selected="">desactive</option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Responsable</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="responsable">
                    <?php
                    foreach ($user->afficheUsers() as $value2) 
                    {
                        if ($value2->ID_user == $caisse['reponsableCaisse']) 
                        {
                    ?>
                            <option value="<?=$value2->ID_user?>" selected><?=$value2->nom_user?></option>
                    <?php
                        }
                        else
                        {
                    ?>
                            <option value="<?=$value2->ID_user?>"><?=$value2->nom_user?></option>
                    <?php
                        }
                    }
                    ?>
                    </select>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" value="<?=$caisse['datecaisse']?>" id="datecreationcaisse">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Type</label>
                <div class="col-sm-9">
                  <input type="text" id="oldType" value="<?=$value->typeCaisse?>" hidden>
                  <select class="form-control" id="type">
                    <?php
                    if ($caisse['typeCaisse'] == 'cd') 
                    {
                    ?>
                      <option value="cd" selected="">Caisse Depense</option>
                      <option value="cr">Caisse Recette</option>
                    <?php
                    }
                    else
                    {
                    ?>
                      <option value="cd">Caisse Depense</option>
                      <option value="cr" selected="">Caisse Recette</option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xlg-6">
              <div class="form-group">
                <textarea class="form-control" id="description"><?php echo $caisse['description']?></textarea>
                <input type="text" id="idcaisse" value="<?php echo $caisse['ID_caisse']?>" hidden>
              </div>
            </div>
          </div>
        </form>
      </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success"data-dismiss="modal" onclick="updateCaisse($('#idcaisse').val(),$('#nomcaisse').val(),$('#devise').val(),$('#lignecredit').val(),$('#statut').val(),$('#responsable').val(),$('#datecreationcaisse').val(),$('#oldType<?=$i?>').val(),$('#type').val(),$('#description').val(),$('#idusers').val())"> <i class="fa fa-check"></i>modifier caisse</button>
            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
          </div>
       </div>
    <!-- /.modal-content -->
  </div>
  <!--/.modal-dialog -->
</div>
<!-- /.modal -->
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
			<div class="card-header" style="background-color:#8b4513; text-align: center;">
                <h5 class="m-b-0 text-white">Detail d'Entrees  <?=$comptabilite->getNomCaisse($idcaisse)->fetch()['nomCaisse']?></h5>
            </div>
		    <div class="card-body">
		    	<div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
	                    <input type="date" id="dateEntrer1" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                    	<input type="date" name="dateEntrer2" id="dateEntrer2" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="input-group">
                        <select class="form-control form-control-sm"  id="moisEntrer" name="moisEntrer">
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
                    <input type="number" id="anneeEntrer" class="form-control form-control-sm" value="<?=date('Y')?>">
                    </div>
                </div>
                <div class="col-lg-1 col-md-1">
                    <button type="button" style="background-color:#8b4513;" class="btn btn-sm text-white"onclick="filtreEntrerCaisse($('#dateEntrer1').val(),$('#dateEntrer2').val(),$('#moisEntrer').val(),$('#provenance').val(),$('#anneeEntrer').val(),$('#idcaisse-entreer').val())"><i class="ti ti-filter"></i> Filtrer</button>
                </div>
                <div class="col-lg-1 col-md-1">
                    <button type="button" class="btn btn-sm btn-dark"onclick="resetFiltreDepense()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                </div>
                <div class="col-md-1 col-lg-1">
                	<button type="button"  style="background-color:#ef7f22;" class="btn btn- text-white" onclick="submitFiltreEntrerCaisse()"><i class="mdi mdi-printer">imprimer</i></button>

					        <form class="form-horizontal p-t-20" id="filtreEntrerCaisse" action="<?=WEBROOT?>rapportEntrerCaisse" method="post">
	                	<input type="text" name="conditionEntrees" id="conditionEntrees" hidden="">
	                	<input type="text" name="idcaisseEntree" id="idcaisse-entreer" value="<?=$idcaisse?>" hidden>
	                </form>
                </div>
               </div>
		        <div class="table-responsive m-t-0">
		            <table id="myTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Date </th>
		                        <th>Montant</th>
		                        <th>Monnaie</th>
		                        <th>Provenance</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Date </th>
		                        <th>Montant</th>
		                        <th>Monnaie</th>
		                        <th>Provenance</th>
		                    </tr>
		                </tfoot>
		                <tbody id="repEntree">
		                	<?php
		                	$i =0;
		                	foreach ($comptabilite->getHistoriqueEntrerDuneCaisse($idcaisse)as $value) {?>
		                	<tr>
		                        <td><?php echo $value->dateEntrer?></td>
		                        <td><?php echo $value->montantEntrer?></td>
		                        <td><?php echo $value->monnaie?></td>
		                        <td><?php echo $value->provenance?></td>
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