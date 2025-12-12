<?php
ob_start();

$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('banque',$_SESSION['ID_user'])->fetch()) 
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
?>
 <input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
 <input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
 <input type="text" id="l" value="<?=$l?>" hidden>
 <input type="text" id="c" value="<?=$c?>" hidden>
 <input type="text" id="m" value="<?=$m?>" hidden>
 <input type="text" id="d" value="<?=$d?>" hidden>
<div class="row">
<div class="col-lg-12 col-md-12 col-xl-12">
	<div class="card">
	    <div class="card-body">
	    	<div id="retour"></div>
				<div class="row page-titles">
					<div class="col-md-5 align-self-center">
					<!--<h4 class="text-themecolor">crm spidernet</h4>-->
					</div>
					<div class="col-md-7 align-self-center">
					<div class="d-flex justify-content-end align-items-center">
					<button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i> Ajouter une depense</button>
					<!-- sample modal content -->
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
				    <div class="modal-dialog modal-lgs">
				        <div class="modal-content">
				            <div class="modal-header">
				                <h4 class="modal-title" id="myLargeModalLabel">Nouvelle depense</h4>
				                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				            </div>
				            <div class="modal-body">
				                <form class="form-horizontal p-t-20">
				                	<div class="form-group row">
										<label for="exampleInputuname3" class="col-sm-3 control-label"> Caisse</label>
										<div class="col-sm-9">
											<select class="form-control" id="caisse">
												<?php 
												foreach ($comptabilite->getCaisseDepenseDunUserNotNull($_SESSION['ID_user']) as $data)
												{?>
													<option value="<?php echo $data->ID_caisse."_".$data->montantCaisse."_".$data->devise.'_'.$data->lignecredit?>"><?php echo $data->nomCaisse . "_" . $data->devise?>
													</option>
												<?php
												}?>
											</select>
										</div>
									</div>
				                	<div class="row">
	                                    <div class="col-lg-12 col-md-12" id="conteneur_destination"></div>
	                                </div>
				            		<div class="row">
				            			<div class="col-lg-12 col-md-12">
								            <div class="form-group row">
								                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant </label>
								                <div class="col-sm-9">
							                        <input type="number" class="form-control" id="montantDepense" >
								                </div>
								            </div>
				            			</div>
				            		</div>
			            		    <div class="row">
			            		    	<div class="col-lg-12 col-md-12">
								            <div class="form-group row">
								                <label for="exampleInputuname3" class="col-sm-3 control-label">Categorie </label>
								                <div class="col-sm-9">
				                        <select class="form-control" id="categorie_depense">
				                        	<option value=""></option>
				                        	<?php
				                        	foreach ($comptabilite->getCategorieDepenses() as $categorie) 
				                        	{
			                        		?>
				                        		<option value="<?=$categorie->ID_categorie_depense.'-'.$categorie->description?>"><?=$categorie->description?></option>
			                        		<?php
				                        	}
				                        	?>
				                        </select>
								                </div>
								            </div>
				            			</div>
			            		    </div>
			            		    <div class="row">
				            			<div class="col-lg-12 col-md-12">
								            <div class="form-group row">
								                <label for="exampleInputuname3" class="col-sm-3 control-label">Libelle </label>
								                <div class="col-sm-9">
							                        <input type="text" class="form-control" id="motifs" >
								                </div>
								            </div>
				            			</div>
				            		</div>
				                    <div class="row">
				                    	<div class="col-lg-12 col-md-12">
				                            <div class="form-group row">
				                               <label for="exampleInputuname3" class="col-sm-3 control-label">Date depense</label>
				                               <div class="col-sm-9">
			                                       <input type="date" class="form-control" value="<?php echo date('Y-m-d')?>" id="datedepense">
			                                        <input type="text" id="iduser"  value="<?php echo $_SESSION['ID_user']?>" hidden>
				            					</div>
				            				</div>
				        				</div>
				                    </div>
				                </form>
				            </div>
				            <div class="modal-footer">
				            	<span id="msg"></span>
				                 <button style="background-color: #7c4a2f" type="button" class="btn text-white" onclick="addPetiteDepense($('#caisse').val(),$('#montantDepense').val(),$('#motifs').val(),$('#datedepense').val(),$('#categorie_depense').val(),$('#iduser').val())">Creer dépense
	                            </button>
				                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
				            </div>
				        </div>
				        <!-- /.modal-content -->
				    </div>
				    <!--/.modal-dialog -->
				</div>

				<button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-lock"></i> Cloturer</button>
                
		          <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
		              <div class="modal-dialog modal-lgs">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <h4 class="modal-title" id="myLargeModalLabel">Cloture des depenses'</h4>
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		                      </div>
		                      <div class="modal-body">
		                          En cloturant les depeses, aucune autre action ne pourant etre effectuee apres!
		                      </div>
		                      <div class="modal-footer">
		                          <span id="afficheMontant"></span>
		                          <button type="button" style="background-color: #7c4a2f" onclick="cloturerPetiteDepenses()"  class="btn text-white waves-effect text-left">
		                          	<i class="fa fa-lock"></i> Cloturer
		                          </button>
		                          <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
		                      </div>
		                  </div>
		              </div>
		          </div>

				<button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgg" onclick="submitRapportPetiteDepense($('#rapportDepense').val())"><i class="fa fa-file" class="modal fade" tabindex="-1" role="dialog"></i> Generer PDF</button>
				
				<form class="form-horizontal p-t-20" id="rapportDepense" action="<?=WEBROOT?>rapportPetiteDepense" method="post">
                	<input type="text" name="condition" id="condition" hidden="">
                </form>
			</div>
		</div>
	</div>
			<div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                    <input type="date" id="date1" class="form-control form-control-sm input-filter">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                    <input type="date" name="date2" id="date2" class="form-control form-control-sm input-filter">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                        <select class="form-control form-control-sm input-filter"  id="mois" name="mois">
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
                    <input type="number" id="annee" class="form-control form-control-sm input-filter" value="<?=date('Y')?>">
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                   	    <select class="form-control form-control-sm input-filter" id="categorieFiltre">
                        	<option value="">Categorie</option>
                        	<?php
                        	foreach ($comptabilite->getCategorieDepenses() as $categorie) 
                        	{
                    		?>
                        		<option value="<?=$categorie->ID_categorie_depense?>"><?=$categorie->description?></option>
                    		<?php
                        	}
                        	?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1">
                    <button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtrePetiteDepense($('#date1').val(),$('#date2').val(),$('#mois').val(),$('#annee').val(),$('#categorieFiltre').val())"><i class="ti ti-filter"></i> Filtrer</button>
                </div>
                <div class="col-lg-1 col-md-1">
                    <button type="button" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltreDepense()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                </div>
               </div>
	        <div class="table-responsive m-t-0">
	            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
	                <thead>
	                    <tr>
	                    	<th>DATE DEPENSE</th>
	                        <th>MONTANT</th>
	                        <th>LIBELLE</th>
	                        <th>CATEGORIE</th>
	                        <th>CAISSE</th>
	                        <th>ETAT</th>
	                        <th>ACTION</th>
	                    </tr>
	                </thead>
	                <tfoot>
	                    <tr>
	                        <th>DATE DEPENSE</th>
	                        <th>MONTANT</th>
	                        <th>LIBELLE</th>
	                        <th>CATEGORIE</th>
	                        <th>CAISSE</th>
	                        <th>ETAT</th>
	                        <th>ACTION</th>
	                    </tr>
	                </tfoot>
	                <tbody id="rep">
	                	<?php
	                	$i =0;
	                	foreach ($comptabilite->getPetiteDepenses($_SESSION['ID_user']) as $value) 
	                		{
	                		$i++;?>
	                	<tr>
	                		<td><?php echo $value->datedepense?></td>
	                        <td><?php echo number_format($value->montantdepense).' '.$value->monnaie?></td>
	                        <td><?php echo $value->motifdepense?></td>
	                        <td><?=$value->description?></td>
	                        <td><?php
	                        //$caisse = $comptabilite->getCaisse($value->ID_caisse)->fetch();
	                        	echo $value->nomCaisse;	
	                        ?></td>
	                        <td><?php
	                        if ($value->etat == 1) 
	                        {
	                        	echo "CLOTURER";
	                        }
	                        else echo "EN ANTENTE";
	                        ?></td>
	                        <td class="text-nowrap">
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier cette depense</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal p-t-20">

<div class="form-group row">
	<label for="exampleInputuname3" class="col-sm-3 control-label">Caisse</label>
	<div class="col-sm-9">
		<input type="text" name="oldCaisse<?=$i?>" id="oldCaisse<?=$i?>" value="<?=$value->ID_caisse?>" hidden>
		<select class="form-control" id="caisse<?=$i?>">
			<?php 
			foreach ($comptabilite->getCaisseDepenseDunUserNotNull($_SESSION['ID_user']) as $data)
			{
				if ($value->ID_caisse == $data->ID_caisse) 
				{
			?>
					<option value="<?php echo $data->ID_caisse."_".$data->montantCaisse."_".$data->devise?>" selected><?php echo $data->nomCaisse . "_" . $data->devise?>
					</option>
			<?php
				}
				else
				{
			?>
					<option value="<?php echo $data->ID_caisse."_".$data->montantCaisse."_".$data->devise?>"><?php echo $data->nomCaisse . "_" . $data->devise?>
					</option>
			<?php
				}
			}
			?>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-3 control-label">Montant </label>
            <div class="col-sm-9">
                <input type="number" class="form-control" id="montantDepense<?=$i?>" value="<?=$value->montantdepense?>">
                <input type="number" class="form-control" id="oldMontant<?=$i?>" value="<?=$value->montantdepense?>" hidden>
            </div>
        </div>
	</div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-3 control-label">Categorie</label>
            <div class="col-sm-9">
            	<input type="text" id="iddepense<?=$i?>" class="form-control" value="<?=$value->ID_depense?>"hidden>
                <select class="form-control" id="categorie<?=$i?>">
                	<option value=""></option>
                	<?php
                	foreach ($comptabilite->getCategorieDepenses() as $categorie) 
                	{
                		if ($categorie->ID_categorie_depense == $value->ID_categorie_depense) 
                		{
        			?>
                			<option value="<?=$categorie->ID_categorie_depense.'_'.$categorie->description?>" selected><?=$categorie->description?></option>
        			<?php
                		}
                		else
                		{
        			?>
                			<option value="<?=$categorie->ID_categorie_depense?>"><?=$categorie->description?></option>
        			<?php
                		}
                	}
                	?>
                </select>
           </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
        	<label for="exampleInputEmail3" class="col-sm-3 control-label">Libelle</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="motif<?=$i?>"> <?php echo $value->motifdepense?></textarea>
           </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
            <div class="col-sm-9">
                <input type="date" id="datedepense<?=$i?>" value="<?php echo $value->datedepense?>" class="form-control">
           </div>
        </div>
    </div>
</div>
	                            </form>
	                        </div>
	                        <div class="modal-footer">
	                            <button style="background-color: #7c4a2f" class="btn text-white" onclick="updatePetiteDepense($('#oldCaisse<?=$i?>').val(),$('#oldMontant<?=$i?>').val(),$('#iddepense<?=$i?>').val(),$('#datedepense<?=$i?>').val(),$('#motif<?=$i?>').val(),$('#categorie<?=$i?>').val(),$('#caisse<?=$i?>').val(),$('#montantDepense<?=$i?>').val(),$('#etat<?=$i?>').val())" data-dismiss="modal">Modifier
	                            </button>
	                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
	                        </div>
	                    </div>
                    	<!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm2<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-sm2<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette depense </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="id_depensedel<?= $i?>" value="<?php echo $value->ID_depense?>" hidden>
                            <input type="text" id="etat<?=$i?>" value="<?=$value->etat?>" hidden>
                            Voulez-vous supprimer cette depense ? 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerPetiteDepense($('#id_depensedel<?=$i?>').val(),$('#etat<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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