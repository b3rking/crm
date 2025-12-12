<?php
ob_start();
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
?>
<input type="text" id="WEBROOT" value="<?=$WEBROOT?>" hidden>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser"  value="<?= $_SESSION['ID_user']?>" hidden>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div class="row page-titles">
    <div class="col-md-5 align-self-center">
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center"> 
        	<ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="javascript:void(0)">Finance</a></li>
              <li class="breadcrumb-item active">Extrat</li>
          </ol>
          <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Ajouter un extrat</button>
          <!-- sample modal content -->
          <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lgs">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Creation d'extrat</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal p-t-20">
                    <!--<div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 col-lg-2 control-label">Type</label>
                          <div class="col-sm-9 col-lg-10"> 
                            <select class="form-control" id="type_extrat" onchange="includeClientDonnerCaution($('#type_extrat').val())">
                              <option value="">selectionnez type d'extrat</option>
                              <php
                              foreach ($comptabilite->get_type_extrat() as $type) 
                              {
                              ?>
                              <option value="<=$type->ID_type_extrat.'-'.$type->libelle_extrat?>"><=$type->libelle_extrat?></option>
                              <php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" id="contener_client_donner_caution">
                      <div></div>
                    </div>
                    <input type="text" id="idClient" hidden="">-->
                    <div class="row">
                      <div class="col-lg-6 col-md-12">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Montant</label>
                          <div class="col-sm-9 col-lg-8">        
                            <input type="text" id="montant" class="form-control">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-4 control-label">Monnaie</label>
                            <div class="col-sm-9 col-lg-8">
                                <select class="form-control" id="monnaie_extrat">
                                  <?php
                                  for ($l=0; $l < count($tbMonnaie); $l++) 
                                  {
                                  ?> 
                                    <option value="<?=$tbMonnaie[$l]?>"><?=$tbMonnaie[$l]?></option>
                                <?php
                                  }
                                  ?>
                                </select>
                            </div>
                        </div>
                      </div>
                    </div>
                    <!--<div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 col-lg-2 control-label">Destination</label>
                          <div class="col-sm-9 col-lg-10">
                            <select type="text" class="form-control"  id="destination" onchange="recevoir_destination($(this).val())">
                              <option></option>
                                <option value="banque">Banque</option>
                                <option value="caisse">Caisse</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>-->
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row">
                          <label for="exampleInputuname3" class="col-sm-3 col-lg-2 col-md-2 control-label">Banque*</label>
                          <div class="form-group col-sm-9 col-lg-10 col-md-10">
                            <select class="form-control" id="banque">
                              <?php 
                              foreach ($comptabilite->getBanqqueActive() as $data)
                              {?>
                                <option value="<?=$data->ID_banque."_".$data->monnaie?>"><?=$data->nom . "_" . $data->monnaie?>
                                </option>
                              <?php
                              }?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 col-lg-2 control-label">Libelle</label>
                          <div class="col-sm-9 col-lg-10">
                            <input type="text"  class="form-control" id="description" placeholder="libelle">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 col-lg-2 control-label">Date </label>
                          <div class="col-sm-9 col-md-10">
                            <input type="date" class="form-control" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" id="date_extrat" >
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <!--<button type="button" style="background-color: #8b4513" class="btn font-light text-white" data-dismiss="modal" onclick="creationExtrat($('#montant').val(),$('#monnaie_extrat').val(),$('#type_extrat').val(),$('#destination').val(),$('#date_extrat').val(),$('#utilisateur').val(),$('#description').val(),$('#idClient').val())"> <i class="fa fa-check"></i>Enregistrer extra</button>-->
                  <button type="button" style="background-color: #7c4a2f" class="btn font-light text-white" data-dismiss="modal" onclick="creationExtrat($('#montant').val(),$('#monnaie_extrat').val(),$('#banque').val(),$('#date_extrat').val(),$('#description').val(),$('#iduser').val())"> <i class="fa fa-check"></i>Enregistrer extra</button>
                  <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                </div>
              </div>
            </div>
          </div>

      <button type="button" style="background-color: #7c4a2f" class="btn  d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target="#myModal-close"><i class="fa fa-lock"></i> Cloturer</button>

  <!-- sample modal content -->
  <div id="myModal-close" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel">Cloture des paiements du jour</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
                  Une fois cloturer vous aurez pas l'acces a la modification ou suppression
              </div>
              <div class="modal-footer">
                  <span id="msg_sendfact"></span>
                  <button style="background-color: #7c4a2f" type="button" class="btn text-white waves-effect text-left" onclick="close_extrat()"><i class="fa fa-lock"></i> Cloturer
                      </button>
                  <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
        </div>
    </div>
</div>
            <!--<div class="row">
              <div class="col-lg-2 col-md-12">
                <div class="form-group">
                  <select class="form-control form-control-sm input-filter" id="type_extrat_filtre">
                    <option value="">type d'extrat</option>
                    <php
                    foreach ($comptabilite->get_type_extrat() as $type) 
                    {
                    ?>
                      <option value="<=$type->ID_type_extrat?>"><=$type->libelle_extrat?></option>
                    <php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-2 col-md-12">
                <div class="form-group">
                  <input type="date" class="form-control form-control-sm input-filter" id="date1">
                </div>
              </div>
              <div class="col-lg-2 col-md-12">
                <div class="form-group">
                  <input type="date" class="form-control form-control-sm input-filter" id="date2">
                </div>
              </div>
              <div class="col-lg-2 col-md-12">
                <div class="form-group">
                  <select class="form-control form-control-sm input-filter" id="mois">
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
              <div class="col-lg-2 col-md-12">
                <div class="form-group">
                  <input type="number" class="form-control form-control-sm input-filter" value="<=date('Y')?>" id="annee">
                </div>
              </div>
              <div class="col-lg-1 col-md-1">
                <button type="button" style="background-color: #7c4a2f"class="btn btn-sm font-light text-white"onclick="filtreExtrat($('#type_extrat_filtre').val(),$('#date1').val(),$('#date2').val(),$('#mois').val(),$('#annee').val())"><i class="ti ti-filter"></i> Filtrer</button>
              </div>
              <div class="col-lg-1 col-md-1">
                <button type="button" class="btn btn-sm  btn-dark"onclick="resetFiltreExtrat()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
              </div>
            </div>-->
		        <div class="table-responsive m-t-5">
		            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                      <th>Date</th>
                          <th>Libelle</th>
                          <th>Montant</th>
                          <th>Banque</th>
                          <th></th>
		                    </tr>
		                </thead>
		                <tfoot>
	                    <tr>
                        <th>Date</th>
                        <th>Libelle</th>
                        <th>Montant</th>
                        <th>Banque</th>
                        <th></th>
	                    </tr>
		                </tfoot>
		                <tbody id="retour">
                      <?php
                      $i =0;
                      foreach ($comptabilite->getExtrats() as $value)
                       {
                        $i++;
                      ?>
                        <tr>
                          <td><?=$value->date_operation?></td>
                          <td><?=$value->reference?></td>
                          <td><?=$value->debit .' '.$value->monnaie?></td>
                          <td>
                          <?=$value->nom;?>
                          <!--if ($value->destination == 'caisse') 
                          {
                            $caisse = $comptabilite->getCaisseDestinationExtrat($value->ID_extrat)->fetch();
                          ?>
                            <td><=$caisse['nomCaisse']?></td>
                          <php
                          }
                          else
                          {
                            $banque = $comptabilite->getBanqueDestinationExtrat($value->ID_extrat)->fetch();
                          ?>
                            <td><=$banque['nom']?></td>
                        <php
                          }-->
                          </td>
                          <td>
                            <!--<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>-->

                            <!-- sample modal content -->
          <div class="modal fade bs-example-modal-lgs<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lgs">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Modification d'extrat</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal p-t-20">
                    <input type="text" id="id_extrat<?=$i?>" value="<?=$value->id?>" hidden>
                    <!--<div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 control-label">Type</label>
                          <div class="col-sm-9"> 
                            <select class="form-control" id="type_extrat<=$i?>">
                              <php
                              foreach ($comptabilite->get_type_extrat() as $type) 
                              {
                                if ($value->ID_type_extrat == $type->ID_type_extrat) 
                                {
                              ?>
                                  <option value="<=$type->ID_type_extrat?>" selected><=$type->libelle_extrat?></option>
                              <php
                                }
                                else
                                {
                              ?>
                                <option value="<=$type->ID_type_extrat?>"><=$type->libelle_extrat?></option>
                              <php
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>-->
                    <div class="row">
                      <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 control-label">Montant</label>
                          <div class="col-sm-9">       
                            <input type="number" id="montant<?=$i?>" class="form-control" value="<?=$value->debit?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-4 control-label">Monnaie</label>
                            <div class="col-sm-9 col-lg-8">
                                <select class="form-control" id="monnaie_extrat<?=$i?>">
                                  <?php
                                  for ($l=0; $l < count($tbMonnaie); $l++) 
                                  {
                                    if ($value->monnaie == $tbMonnaie[$l]) 
                                    {
                                  ?> 
                                    <option value="<?=$tbMonnaie[$l]?>" selected><?=$tbMonnaie[$l]?></option>
                                  <?php
                                    }
                                    else
                                    {
                                  ?> 
                                    <option value="<?=$tbMonnaie[$l]?>"><?=$tbMonnaie[$l]?></option>
                                  <?php
                                    }
                                  }
                                  ?>
                                </select>
                            </div>
                        </div>
                      </div>
                    </div>
                    <!--<div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                          <label for="exampleInputuname3" class="col-sm-3 control-label">Destination</label>
                          <div class="col-sm-9">
                            <select type="text" class="form-control"  id="destination" onchange="recevoir_destination($(this).val())">
                              <option></option>
                                <option value="banque">Banque</option>
                                <option value="caisse">Caisse</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row" id="conteneur_destination<=$i?>"></div>-->
                      <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                          <div class="row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-2 col-md-2 control-label">Banque*</label>
                          <div class="form-group col-sm-9 col-lg-10 col-md-10">
                            <select class="form-control" id="banque<?=$i?>">
                              <?php 
                              foreach ($comptabilite->getBanqqueActive() as $data)
                              {
                                if ($data->ID_banque == $value->ID_banque) 
                                {
                              ?>
                                  <option value="<?=$data->ID_banque."_".$data->monnaie?>" selected><?=$data->nom . "_" . $data->monnaie?>
                                  </option>
                              <?php
                                }
                                else
                                {
                              ?>
                                  <option value="<?=$data->ID_banque."_".$data->monnaie?>"><?=$data->nom . "_" . $data->monnaie?>
                                  </option>
                              <?php
                                }
                              }?>
                            </select>
                            <input type="text" id="idDestination_old<=$i?>" value="<?=$value->ID_banque?>" hidden>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-2 col-md-2 control-label">Libelle</label>
                            <div class="col-sm-9 col-lg-10 col-md-10">
                              <input type="text"  class="form-control" id="description<?=$i?>" value="<?=$value->reference?>">
                              <!--<input type="text" id="destination<=$i?>" value="<=$value->destination?>" hidden>-->
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12 col-md-12">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 col-lg-2 col-md-2 control-label">Date </label>
                            <div class="col-sm-9 col-lg-10 col-md-10">
                              <input type="date" class="form-control" value="<?=$value->date_operation?>" id="date_extrat<?=$i?>" >
                              
                              <!--<php
                              if ($value->destination == 'caisse') 
                              {
                              ?>
                                <input type="text" id="idDestination<=$i?>" value="<=$caisse['ID_caisse']?>" hidden>
                              <php
                              }
                              else
                              {
                              ?>
                                <input type="text" id="idDestination<=$i?>" value="<=$banque['ID_banque']?>" hidden>
                              <php
                              }
                              ?>-->
                            </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" style="background-color: #7c4a2f"class="btn font-light text-white" data-dismiss="modal" onclick="updateExtrat($('#id_extrat<?=$i?>').val(),$('#montant<?=$i?>').val(),$('#type_extrat<?=$i?>').val(),$('#idDestination<?=$i?>').val(),$('#date_extrat<?=$i?>').val(),$('#utilisateur<?=$i?>').val(),$('#description<?=$i?>').val(),$('#destination<?=$i?>').val())"> <i class="fa fa-check"></i>Enregistrer extra</button>
                  <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                </div>
              </div>
            </div>
          </div>

          <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm2<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-sm2<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Suppression d'extrat </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="id_extratdel<?= $i?>" value="<?=$value->id?>" hidden>
                            <input type="number" id="montant_del<?=$i?>" value="<?=$value->debit?>" hidden>
                            <input type="text" id="idDestinationdel<?=$i?>" value="<?=$value->ID_banque?>" hidden>
                            <!--<input type="text" id="destinationdel<=$i?>" value="<=$value->destination?>" hidden>
                            <php
                              if ($value->destination == 'caisse') 
                              {
                              ?>
                                <input type="text" id="idDestinationdel<=$i?>" value="<=$caisse['ID_caisse']?>" hidden>
                              <php
                              }
                              else
                              {
                              ?>
                                <input type="text" id="idDestinationdel<=$i?>" value="<=$banque['ID_banque']?>" hidden>
                              <php
                              }
                              ?>-->
                            Voulez-vous supprimer cette donneé ? 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteExtrat($('#id_extratdel<?=$i?>').val(),$('#montant_del<?=$i?>').val(),$('#idDestinationdel<?=$i?>').val(),'<?=$value->etat?>')" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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