<?php
ob_start();

$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('paiement',$_SESSION['ID_user'])->fetch()) 
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

$typeCaisse = ['cd'=>'Caisse Depense','cr'=>'Caisse Recette'];
?>

<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser"  value="<?= $_SESSION['ID_user']?>" hidden>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="l" value="<?=$l?>" hidden>
<input type="text" id="c" value="<?=$c?>" hidden>
<input type="text" id="m" value="<?=$m?>" hidden>
<input type="text" id="s" value="<?=$s?>" hidden>
<div class="row">
  <div class="col-lg-12 col-md-12 col-xl-12">
    <div class="card">
        <div class="card-body">
          <div id="retour"></div>
            <!--<h4 class="card-title">Data Export</h4>
            <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
            <div class="row page-titles">
    <div class="col-md-5 align-self-center">
       <!-- <h4 class="text-themecolor">crm spidernet</h4>-->
    </div>
    <div class="col-md-7 align-self-center ">
        <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Finance</a></li>
            <li class="breadcrumb-item active">caisse</li>
          </ol>
            <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Creer une caisse</button>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Nouvelle caisse</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal p-t-20">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Nom Caisse</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  id="nomcaisse">
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Monnaie</label>
                <div class="col-sm-9">
                  <select class="form-control"  id="devise">
                    <?php
                    for ($l=0; $l < count($tbMonnaie); $l++) 
                    {
                    ?> 
                      <option value="<?=$tbMonnaie[$l]?>">
                        <?=$tbMonnaie[$l]?>
                      </option>
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
                <label for="exampleInputuname3" class="col-sm-3 control-label">Statut</label>
                <div class="col-sm-9">
                  <select class="form-control" id="statut">
                    <option value="active">active</option>
                    <option value="desactive">desactive</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>
                <div class="col-sm-9">
                  <input type="date" class="form-control" value="<?= date('Y-m-d')?>" id="datecreationcaisse">
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
                      <option></option>
                      <?php
                      foreach ($user->afficheUsers() as $value) 
                      {
                      ?>
                        <option value="<?=$value->ID_user?>"><?=$value->nom_user?></option>
                      <?php
                      }
                      ?>
                    </select>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xlg-6">
              <div class="form-group">
                <textarea class="form-control" id="description" placeholder="Commentaire"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-6" hidden="">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Type</label>
                <div class="col-sm-9">
                  <select class="form-control" id="type">
                    <option value="cd">Caisse Depense</option>
                    <!--<option value=""></option>
                    <option value="cr">Caisse Recette</option>-->
                  </select>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" style="background-color: #7c4a2f" class="btn text-white" data-dismiss="modal" onclick="creerCaisse($('#nomcaisse').val(),$('#devise').val(),$('#statut').val(),$('#responsable').val(),$('#datecreationcaisse').val(),$('#iduser').val(),$('#type').val(),$('#description').val())"> <i class="fa fa-check"></i>cree caisse</button>
          <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!--/.modal-dialog -->
</div>
        </div>
    </div>
</div>
            <div class="row">
              <div class="col-lg-3 col-md-3">
                  <div class="form-group">
                  <input type="text" name="caisse_name" id="caisse_name" class="form-control form-control-sm input-filter" placeholder="Nom de la caisse">
                  </div>
              </div>
              <div class="col-lg-3 col-md-3">
                  <div class="form-group">
                      <select class="form-control form-control-sm input-filter" id="caisse_status">
                          <option value="">Status</option>
                          <option value="active">Activer</option>
                          <option value="desactive">Desactiver</option>
                      </select>
                  </div>
              </div>
              <div class="col-lg-1 col-md-2">
                  <button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtreCaisse($('#caisse_name').val(),$('#caisse_status').val())"><i class="ti ti-filter"></i> Filtrer</button>
              </div>
              <div class="col-lg-1 col-md-2">
                  <button type="button" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltreCaisse()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Annuler</button>
              </div>
          </div>
            <div class="table-responsive m-t-0">
                <table id="myTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Montant</th>
                            <th>Monnaie</th>
                            <th>Status</th>
                            <th>Creation</th>
                            <th>Commentaire</th>
                            <th>Type</th>
                            <th>Responsable</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nom</th>
                            <th>Montant</th>
                            <th>Monnaie</th>
                            <th>Status</th>
                            <th>Creation</th>
                            <th>Commentaire</th>
                            <th>Type</th>
                            <th>Responsable</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody id="rep">
                       <?php
                       $i=0;
                       foreach ($comptabilite->getCaisses() as $value) 
                       {
                        $i++;
                        ?>
                        <tr>
                          <td><?=$value->nomCaisse?></td>
                          <td><?= $value->montantCaisse?></td>
                          <td><?= $value->devise?></td>
                          <td><?= $value->etat?></td>
                          <td><?= $value->datecaisse?></td>
                          <td><?= $value->description?></td>
                          <td><?=$typeCaisse[$value->typeCaisse]?></td>
                          <td><?= $value->nom_user?></td>
                            
                          <td class="text-nowrap">
  <a href="<?=WEBROOT;?>detailcaisse-<?php echo $value->ID_caisse?>" data-toggle="tooltip"  data-original-title="Voir"><i class="fa fa-eye text-inverse m-r-10"></i></a>

  <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                          </a>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
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
                  <input type="text" class="form-control"  id="nomcaisse<?=$i?>" value="<?php echo $value->nomCaisse?>">
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Monnaie</label>
                <div class="col-sm-9">
                    <select class="form-control"  id="devise<?=$i?>">
                      <?php
                      for ($l=0; $l < count($tbMonnaie); $l++) 
                      {
                        if ($tbMonnaie == $value->devise) 
                        {
                      ?>
                          <option value="<?=$tbMonnaie[$l]?>" selected>
                          <?=$tbMonnaie[$l]?>
                          </option>
                      <?php
                        }
                        else
                        {
                      ?>
                          <option value="<?=$tbMonnaie[$l]?>">
                          <?=$tbMonnaie[$l]?>
                          </option>
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
            <div class="col-lg-6 col-md-6" hidden>
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Type</label>
                <div class="col-sm-9">
                  <input type="text" id="oldType<?=$i?>" value="<?=$value->typeCaisse?>" hidden>
                  <select class="form-control" id="type<?=$i?>">
                    <?php
                    if ($value->typeCaisse == 'cd') 
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
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Statut</label>
                <div class="col-sm-9">
                  <select class="form-control" id="statut<?=$i?>">
                    <?php
                    if ($value->etat == "active") 
                    {
                    ?>
                      <option value="active" selected="">active</option>
                      <option value="desactive">desactive</option>
                    <?php
                    }
                    else
                    {
                    ?>
                      <option value="active">active</option>
                      <option value="desactive" selected="">desactive</option>
                    <?php
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
                  <input type="date" class="form-control" value="<?=$value->datecaisse?>" id="datecreationcaisse<?=$i?>">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Responsable</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="responsable<?=$i?>">
                      <option value="<?=$value->reponsableCaisse?>"><?php echo $value->nom_user?></option>
                      <?php
                      foreach ($user->afficheUsers() as $value2) 
                      {
                      ?>
                        <option value="<?=$value2->ID_user?>"><?=$value2->nom_user?></option>
                      <?php
                      }
                      ?>
                    </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xlg-6">
              <div class="form-group">
                <textarea class="form-control" id="description<?=$i?>"><?=$value->description?></textarea>
                <input type="text" id="idcaisse<?=$i?>" value="<?= $value->ID_caisse?>" hidden>
              </div>
            </div>
          </div>
        </form>
      </div>
          <div class="modal-footer">
            <button type="button" style="background-color: #7c4a2f" class="btn text-white"data-dismiss="modal" onclick="updateCaisse($('#idcaisse<?=$i?>').val(),$('#nomcaisse<?=$i?>').val(),$('#devise<?=$i?>').val(),$('#statut<?=$i?>').val(),$('#responsable<?=$i?>').val(),$('#datecreationcaisse<?=$i?>').val(),$('#oldType<?=$i?>').val(),$('#type<?=$i?>').val(),$('#description<?=$i?>').val(),$('#iduser').val())"> <i class="fa fa-check"></i>modifier caisse</button>
            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
          </div>
       </div>
    <!-- /.modal-content -->
  </div>
  <!--/.modal-dialog -->
</div>
<!-- /.modal -->


                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette banque</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="idciasse_del<?=$i?>" value="<?php echo $value->ID_caisse?>" hidden>
                            Voulez-vous supprimer cette caisse?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-rounded btn-danger" onclick="deleteCaisse($('#idciasse_del<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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