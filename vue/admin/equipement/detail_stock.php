 <?php
ob_start(); 
?>

<div class="row">
    <input type="text" id="idusers"  value="<?php echo $_SESSION['ID_user']?>" hidden>
    <input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
    <input type="text" id="page" value="detail" hidden="">
	<div class="col-lg-12 col-md-12 col-xl-12"> 
		<div class="card">
			<div class="card-header" style="background-color:#8b4513; text-align: center;">
                <h5 class="m-b-0 text-white">Detail sorties </h5>
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
                     text-white"onclick="filtreSortie_stock($('#date1').val(),$('#date2').val(),$('#mois').val(),$('#annee').val(),$('#idaccessoire').val())"><i class="ti ti-filter"></i> Filtrer</button>
                </div>
                <div class="col-lg-2 col-md-1">
                    <button type="button" class="btn btn-sm btn-dark"onclick="resetFiltreDepense()"><i class="mdi mdi-refresh"></i> Reset</button>
                </div>
                <div class="col-md-1 col-lg-1">
                	<button type="button" style="background-color:#ef7f22;"  class="btn btn- text-white" onclick="submitFiltreSortieCaisse()"><i class="mdi mdi-printer"></i>imprimer</button>

					        <form class="form-horizontal p-t-20" id="filtreSortieCaisse" action="<?=WEBROOT?>rapportSortiestock" method="post">
	                	<input type="text" name="condition" id="condition"hidden>
	                	<input type="text" name="idaccessoire" id="idaccessoire" value="<?php echo $idaccessoire?>"hidden >
	                </form>
                </div>
               </div>
		          <div class="table-responsive m-t-0">
		            <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Date </th>
		                        <th>Accessoire</th>
		                        <th>Quantite</th>
		                        <th>Motif</th>
		                        <th>Serveur</th>
		                        <th>Destination</th>
                                <th>Demande</th>
                                <th>Action</th>

		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Date </th>
		                        <th>Accessoire</th>
		                        <th>Quantite</th>
                                <th>Motif</th>
		                        <th>Serveur</th>
		                        <th>Destination</th>
                                <th>Demande</th>
                                <th>Action</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php
		                	$i =0;
		                	foreach ($equipement->getsortie_stock($idaccessoire)as $value) 
                                { $i++;
                                    ?>
		                	<tr>
		                        <td><?php echo $value->date_sortie?></td>
		                        <td><?php echo $value->categorie?></td>
		                        <td><?php echo $value->quantite?></td>
		                        <td><?php echo $value->motif?></td>
		                        <td><?php echo $value->serviteur?></td>
		                        <td><?php echo $value->destination?></td>
                                <td><?= $value->nom_user?></td>
                                   <td class="text-nowrap">

                
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                        </a>
                  
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier sortie stock</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
                           <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                             <input type="number" id="id_sortie<?= $i?>" value="<?php echo $value->ID_sortie_stock?>" class="form-control" hidden>
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Categorie </label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="mdi mdi-chair-school"></i></span></div>
                            <select id="idaccessoire<?=$i?>" value="<?php echo $value->categorie?>" class="form-control" disabled>
                                    <option value="<?php echo $value->ID_accessoire?>"><?php echo $value->categorie?></option>
                            <?php foreach ($equipement->selection_Categorie() as $data)
                            {?>
                            <option value="<?php echo $value->ID_accessoire?>"><?php echo $value->categorie?></option>
                            <?php
                            }
                            ?>                                 
                    </select>
                    </div>
                    </div>
                </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                    <input type="number" id="quantite<?= $i?>"  class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">date sortie </label>
    <div class="col-sm-9">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="mdi mdi-chair-school"></i></span></div>
                <input type="date" id="date_sortie<?= $i?>" value="<?php echo $value->date_sortie?>" class="form-control" ></div>
            </div>
                </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">motif</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                    <input type="text" id="motif<?= $i?>" value="<?php echo $value->motif?>" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                    </div><!-- END ROW-->
                    
                        </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" style="background-color: #8b4513" data-dismiss="modal" class="btn text-white" onclick="modifier_sortie($('#id_sortie<?=$i?>').val(),$('#idaccessoire<?= $i?>').val(),$('#quantite<?=$i?>').val(),$('#date_sortie<?=$i?>').val(),$('#motif<?=$i?>').val())"> <i class="fa fa-check"></i> Modifier accessoire</button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

            
                    <!--a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a-->
               

                    <!-- sample modal content -->
                    <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer accessoire</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body"> 
                                <input type="text" class="form-control" id="idaccessoire<?= $i?>" value="<?php echo $value->ID_accessoire?>"hidden >
                                Voulez-vous supprimer cet accessoire?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="suppression_accessoire($('#idaccessoire<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                                </div>
                            </div>
                            <!--/.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
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
    <!--div class="col-lg-3 col-md-12 col-xl-12"> 
        <div class="card">
            <div class="card-body">
                <h6><?php /*$caisse = $comptabilite->getCaisse($idcaisse)->fetch();
                echo "Montant  : ".$caisse['montantCaisse'].' '.$caisse['devise'];
                ?></h6>
                <h6>
                    <?php echo "Ligne de credit : ".$caisse['lignecredit']?>
                </h6>
                <h6><?='Statut : '.$caisse['etat']?></h6>
                <h6><?='Dimmension : '.$caisse['dimension']*/?></h6>
                <button type="button"  style="background-color:#ef7f22;"  class="btn btn-sm text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-pencil text-inverse m-r-0"></i> Modifier</button>
 
            </div>
        </div>
    </div-->
</div>
<!--div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
			<div class="card-header" style="background-color:#8b4513; text-align: center;">
                <h5 class="m-b-0 text-white">Detail d'Entrees </h5>
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
		                        <th>Accessoire</th>
		                        <th>Quantite</th>
		                        <th>Motif</th>
		                        <th>Responsable</th>
		                </thead>
		                <tfoot>
		                    <tr>
		                    <th>Date </th>
		                        <th>Accessoire</th>
		                        <th>Quantite</th>
		                        <th>Motif</th>
		                        <th>Responsable</th>
		                    </tr>
		                </tfoot>
		                <tbody id="repEntree">
		                	<?php
		                	$i =0;
		                	foreach ($equipement->getHistoriqueEntre_stock(/*$idaccessoire*/)as $value) {?>
		                	<tr>
		                        <td><?php echo $value->date_entre?></td>
		                        <td><?php echo $value->categorie?></td>
		                        <td><?php echo $value->quantite?></td>
		                        <td><?php echo $value->commentaire?></td>
		                         <td><?php echo $value->responsable?></td>
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
</div-->

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>