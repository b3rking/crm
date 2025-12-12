<?php
ob_start();
?>
  <div class="row">
    <input type="text" id="iduser"  value="<?= $_SESSION['ID_user']?>"hidden>
    <input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
                <div class="row page-titles">
				    <div class="col-md-5 align-self-center">
				    </div>
				    <div class="col-md-7 align-self-center">
				        <div class="d-flex justify-content-end align-items-center">
				            
				           <button type="button" class="btn btn-chocolate d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>ajouter un prospect</button>

                            <!-- sample modal content -->
                            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau prospect</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal p-t-20">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Type</label>
                                                            <div class="col-sm-9">
                                                                <!--<input type="text" id="entreprise" class="form-control" placeholder="Etse">-->
                                                                <select class="form-control" id="genre">
                                                                    <option value=""></option>
                                                                    <option value="personnel">Particulier</option>
                                                                    <option value="societe">Societé</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                    <div class="form-group row">
                                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Adresse*</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" id="adresprospect" class="form-control">
                                                       </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Nom*</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" placeholder="nom " id="prospect">
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Telephone </label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="portable" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mail</label>
                                                            <div class="col-sm-9">
                                                                <input type="email" id="mailP" class="form-control" placeholder="nom@gmail.fr ">
                                                           </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Rendez vous</label>
                                                            <div class="col-sm-9">
                                                                <input type="date" class="form-control" id="rdv">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date Prospection</label>
                                                            <div class="col-sm-9">
                                                                <input type="date" id="jourEnreg" class="form-control" value="<?=date('Y-m-d')?>"> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                                                        <label for="exampleInputuname3" class="control-label">Commentaire du marketeur</label>
                                                        <div class="form-group">
                                                            <textarea name="commentaire" class="form-control" id="marketeur_comment" placeholder="commentaire du marketeur" ></textarea>
                                                        </div>
                                                    </div>
                                                </div><!-- END ROW-->
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                                                        <label for="exampleInputuname3" class="control-label">Commentaire du prospect</label>
                                                        <div class="form-group">
                                                            <textarea name="commentaire" class="form-control" id="prospect_comment" placeholder="commentaire du prospect" ></textarea>
                                                        </div>
                                                    </div>
                                                </div><!-- END ROW-->
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-chocolate font-light text-white" data-dismiss="modal" onclick="ajouterprospect($('#prospect').val(),$('#adresprospect').val(),$('#portable').val(),$('#mailP').val(),$('#genre').val(),$('#rdv').val(),$('#jourEnreg').val(),$('#marketeur_comment').val(),$('#prospect_comment').val(),$('#iduser').val())"> <i class="fa fa-check"></i> Ajouter prospect</button>
                                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!--/.modal-dialog -->
                            </div>

					        </div>
					    </div>
					</div>
		         <!-- Row -->
                <div class="row">
                    <div class="col-md-6 col-lg-3 col-xlg-2">
                        <div class="card">
                            <div class="box bg- text-center btn-chocolate">
                                <h1 class="font-light text-white"> 
                                <button type="button" class="btn btn-chocolate btn-none d-lg-block m-l-15 text-white" onclick="//retourTousprospect()"><h5>Total prospects <?php $data =$marketing->nombreprospect()->fetch();echo $data['nb'];?></h5></button></h1>
                                <!--<h6 class="text-white">Pages/Session</h6>-->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xlg-2">
                        <div class="card">
                            <div class="box bg- text-center" style="background-color: #ef7f22">
                                <h1 class="font-light text-white"> 
                                 <button type="button" class="btn btn-sm btn-rounded text-white"style="background-color: #ef7f22" onclick="//recupereProspectsparEtat('attente')">prospect en attente &nbsp;<?php $data =$marketing->prospect_attente()->fetch();echo $data['stocknombreprospectAttente'];?>
                                 </button></h1>
                                <!--<h6 class="text-white">Pages/Session</h6>-->
                            </div>
                        </div>
                    </div>
                    <!-- Column class="box bg-megna text-center">-->
                    <div class="col-md-6 col-lg-3 col-xlg-2">
                        <div class="card">
                            <div class="box bg-success text-center">
                                <h1 class="font-light text-white">
                                <button type="button"  class="btn btn-sm btn-rounded btn-success"  onclick="//recupereProspectsparEtat('valider')">prospect valide &nbsp;<?php $data =$marketing->prospectValide()->fetch();echo $data['prospectvalide'];?>
                                </button></h1>
                                <!--<h6 class="text-white">Avg. Session</h6>-->
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-2">
                        <div class="card">
                            <div class="box bg-danger text-center">
                                <h1 class="font-light text-white">
                                    <button type="button" class="btn btn-sm btn-rounded btn-danger" onclick="//recupereProspectsparEtat('annuler')">prospect annuler&nbsp;<?php $data =$marketing->prospectannuler()->fetch();echo $data['annuler'];?>
                                    </button></h1>
                                <!--<h6 class="text-white">Bounce Rate</h6>-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <!-- FILTRE -->
                <form action="<?=WEBROOT?>filtreProspect" method="get" id="filtreProspect">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <label for="exampleInputuname3" class="control-label">Nom prospect</label>
                            <div class="form-group">
                                <input type="text" name="nom" id="nomprospect" class="form-control input-filter" placeholder="NOM">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <label for="exampleInputuname3" class="control-label">Date prospection</label>
                            <div class="form-group">
                                <input type="date" name="dateprospection" id="dateprospection" class="form-control input-filter">
                            </div>
                        </div>
                        <!--<div class="col-lg-2 col-md-2">
                            <label for="exampleInputuname3" class="control-label">Rendez-vous</label>
                            <div class="form-group">
                                <input type="date" name="daterendezvous" id="daterendezvous" class="form-control input-filter">
                            </div>
                        </div>-->
                        <div class="col-lg-2 col-md-2">
                            <label for="exampleInputuname3" class="control-label">Status</label>
                            <div class="form-group">
                                <select name="status" class="form-control input-filter">
                                    <option value=""></option>
                                    <option value="attente">Attente</option>
                                    <option value="annuler">Annuler</option>
                                    <option value="valider">Valider</option>
                                </select>
                            </div>
                        </div>
                        <?php
                        if($_SESSION['profil_id'] == 832 || $_SESSION['profil_id'] == 833)
                        {
                        ?>
                            <div class="col-lg-2 col-md-2">
                                <label for="exampleInputuname3" class="control-label">Suivi par</label>
                                <div class="form-group">
                                    <select name="suivi_par" class="form-control input-filter">
                                        <option value=""></option>
                                        <?php
                                        foreach ($users as $value) 
                                        {
                                        ?>
                                            <option value="<?=$value->ID_user?>"> <?=$value->nom_user?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="col-lg-1 col-md-1">
                            <!--<button type="button" class="btn btn-chocolate btn-sm font-light text-white"  onclick="filtreProspect($('#idprospect').val(),$('#nomprospect').val(),$('#phoneprospect').val(),$('#mailprospect').val(),$('#dateprospection').val())"><i class="ti ti-filter" data-dismiss="modal"></i> Filtrer</button>-->
                            <button type="submit" class="btn btn-chocolate btn-sm font-light text-white"><i class="ti ti-filter"></i> Filtrer</button>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <button type="button" class="btn btn- btn-sm btn-dark" onclick="resetFiltreProspect()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                        </div>
                    </div>
                </form>
		        <div class="table-responsive m-t-0">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Nom</th>
		                        <th>Type</th>
                                <th>Telephone</th>
		                        <th>Adresse</th>
		                        <th>Mail</th>
		                        <th>Date prospection</th>
                                <th>Rendez vous</th>
                                <th>Suivi par</th>
                                <th>Etat</th>
                                <th></th>
                                
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Telephone</th>
                                <th>Adresse</th>
                                <th>Mail</th>
                                <th>Date prospection</th>
                                <th>Rendez vous</th>
                                <th>Suivi par</th>
                                <th>Etat</th>
                                <th></th>
                               
		                    </tr>
		                </tfoot>
		                <tbody id="reponse">
                            <?php
                            $i =0;
                            foreach ($result as $value)
                            {
                                $i++;
                                ?>
                                <tr>
                                <td><?= $value->nom?></td>
                                <td><?= $value->genre?></td>
                                <td><?= $value->telephone?></td>
                                <td><?= $value->adresseProspect?></td>
                                <td><?= $value->mail?></td>
                                <td><?= $value->dateProspection?></td>
                                <td><?= $value->rendezvous?></td>
                                <td><?= $value->nom_user?></td>
                                <td>
                                    <?php if($value->etatduProspect =='attente')
                                {
                                    ?>
                                    <span style="background-color: #ef7f22" class="label"><?php echo $value->etatduProspect?></span>
                                    <?php
                                }
                                elseif ($value->etatduProspect =='valider') 
                                    {
                                        ?>
                                    <span class="label label-success"><?php echo $value->etatduProspect?></span>
                                    <?php
                                }
                                elseif ($value->etatduProspect =='annuler') 
                                    {?>
                                    <span class="label label-danger"><?= $value->etatduProspect?></span>
                                <?php        
                                }
                               ?>
                                </td>
                             
                                <td class="text-nowrap">
                                    <a href="<?=WEBROOT;?>detailprospect-<?= $value->ID_prospect?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i></a>
                                    <?php
                                    if ($value->etatduProspect != 'valider') 
                                    {
                                    ?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                    <?php
                                    }
                                    ?>
                                    <!-- sample modal content -->
                            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Modification du prospect</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal p-t-20">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Type*</label>
                                                            <div class="col-sm-9">
                                                                <!--<input type="text" id="entreprise<=$i?>" class="form-control" value="<= $value->entreprise?>">-->
                                                                <input type="text" id="numprospect<?=$i?>" class="form-control" value="<?= $value->ID_prospect?>"hidden>
                                                                <select class="form-control" id="genre">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    if($value->genre == "personnel")
                                                                    {
                                                                    ?>
                                                                        <option value="personnel" selected>Particulier</option>
                                                                        <option value="societe">Societé</option>
                                                                    <?php
                                                                    }
                                                                    elseif($value->genre == "societe")
                                                                    {
                                                                    ?>
                                                                        <option value="personnel">Particulier</option>
                                                                        <option value="societe" selected>Societé</option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                    <div class="form-group row">
                                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Adresse*</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" id="adresprospect<?=$i?>" class="form-control" value="<?= $value->adresseProspect?>">
                                                       </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Nom*</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="nomprospect<?=$i?>" class="form-control" value="<?= $value->nom?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Telephone </label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="phoneprospect<?=$i?>" class="form-control" value="<?= $value->telephone?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mail</label>
                                                            <div class="col-sm-9">
                                                                <input type="email" id="mailprospect<?=$i?>" class="form-control" value="<?= $value->mail?>">
                                                           </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Rendez vous</label>
                                                            <div class="col-sm-9">
                                                                <input type="date"  id="rdv<?=$i?>" class="form-control" value="<?= $value->rendezvous?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date Prospection</label>
                                                            <div class="col-sm-9">
                                                                <input type="date" id="dateprospection<?=$i?>" class="form-control" value="<?= $value->dateProspection?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-chocolate font-light text-white" data-dismiss="modal" onclick="updateProspect($('#numprospect<?=$i?>').val(),$('#nomprospect<?=$i?>').val(),$('#adresprospect<?=$i?>').val(),$('#phoneprospect<?=$i?>').val(),$('#mailprospect<?=$i?>').val(),$('#genre<?=$i?>').val(),$('#rdv<?=$i?>').val(),$('#dateprospection<?=$i?>').val())"> <i class="fa fa-check"></i> Modifier</button>
                                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!--/.modal-dialog -->
                            </div>


                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce prospect</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="numprospect<?= $i?>" value="<?php echo $value->ID_prospect?>"hidden >
                            Voulez-vous supprimer ce prospect?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn- btn-dark" onclick="supprimerProspect($('#numprospect<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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
/*$home_commercial_content = ob_get_clean();
require_once('vue/admin/home.commercial.php');*/
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?> 