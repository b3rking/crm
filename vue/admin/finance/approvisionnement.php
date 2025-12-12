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
$grandecaisse = 'non';
if (count($comptabilite->getGrandeCaisses()) > 0) 
  $grandecaisse = 'oui';
?>

<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser"  value="<?=$_SESSION['ID_user']?>" hidden>
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
            <li class="breadcrumb-item active">approvisionnement</li>
          </ol>

 <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target="#myModalApproviCaisse"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Approvisionner</button>

<!-- sample modal content -->
<div id="myModalApproviCaisse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Approvisionner la caisse</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal p-t-0">
            <div class="modal-body">
                <div class="row">
                  <!--<div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Provenence</label>
                            <div class="col-sm-9">
                              <select class="form-control" id="provenence" onchange="getProvenceApprovionnement($(this).val())">
                                <option value=""></option>
                                <option value="caisse">Caisse</option>
                                <option value="banque">Banque</option>
                              </select>
                            </div>
                        </div>
                      </div>-->
                  <div class="col-lg-12 col-md-12">
                    <div class="form-group row">
                      <label for="exampleInputuname3" class="col-sm-3 control-label">Banque*</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <select class="form-control" id="banque">
                            <?php 
                            foreach ($comptabilite->getBanqqueActive() as $data)
                            {?>
                              <option value="<?php echo $data->ID_banque."_".$data->montant."_".$data->monnaie."_".$data->nom."_".$data->creditLine?>"><?php echo $data->nom . "_" . $data->monnaie?>
                              </option>
                            <?php
                            }?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="form-group row">
                      <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Reference CHQ*</label>
                      <div class="col-sm-9">
                        <input class="form-control" type="text" id="referenceApprovisionne">
                     </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="form-group row">
                      <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Montant*</label>
                      <div class="col-sm-9">
                        <input class="form-control" type="number" id="montantApprovisionne">
                     </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="form-group row">
                      <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Destination*</label>
                      <div class="col-sm-9">
                        <select class="form-control" id="caissedestination">
                          <?php foreach ($comptabilite->getCaisseDepenses() as $value) 
                          {?>
                            <option value="<?php echo $value->ID_caisse.'_'.$value->lignecredit.'_'.$value->devise.'_'.$value->nomCaisse?>"><?php echo $value->nomCaisse .'_'.$value->devise?></option>
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
                      <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation*</label>
                      <div class="col-sm-9">
                        <input type="date" class="form-control" value="<?=date('Y-m-d')?>" id="datevirement">
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button style="background-color: #7c4a2f" type="button" class="btn text-white waves-effect text-left" onclick="approvisionner($('#banque').val(),$('#montantApprovisionne').val(),$('#caissedestination').val(),$('#datevirement').val(),$('#referenceApprovisionne').val(),$('#iduser').val())"><i class="fa fa-plus-circle"></i>Valider
              </button>
              <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

          <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-lock"></i> Cloturer</button>
                
          <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog modal-lgs">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h4 class="modal-title" id="myLargeModalLabel">Cloture d'approvisionnement'</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                      </div>
                      <div class="modal-body">
                          En cloturant l'approvisionnement', aucune action ne pourant etre effectuee apres!
                      </div>
                      <div class="modal-footer">
                          <span id="afficheMontant"></span>
                          <button type="button" style="background-color: #7c4a2f" onclick="cloturerApprovisionnement()"  class="btn text-white waves-effect text-left"><i class="fa fa-lock"></i> Cloturer
                          </button>
                          <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
</div>
            <div class="row">
              <div class="col-lg-3 col-md-3">
                  <div class="form-group">
                      <select class="form-control form-control-sm input-filter" id="banque_filtre" name="banque">
                          <option value="">banque</option>
                          <?php 
                          foreach ($comptabilite->getBanqqueActive() as $data)
                          {?>
                              <option value="<?=$data->ID_banque?>"><?php echo $data->nom . " - " . $data->monnaie?>
                              </option>
                          <?php
                          }?>
                      </select>
                  </div>
              </div>
              <div class="col-lg-2 col-md-3">
                  <div class="form-group">
                  <input type="date" name="date1" id="date1" class="form-control form-control-sm input-filter">
                  </div>
              </div>
              <div class="col-lg-2 col-md-3">
                  <div class="form-group">
                  <input type="date" name="date2" id="date2" class="form-control form-control-sm input-filter">
                  </div>
              </div>
              <div class="col-lg-2 col-md-3">
                <div class="form-group">
                  <select class="form-control form-control-sm input-filter" id="caisse_filtre">
                    <option value="">Caisse</option>
                    <?php foreach ($comptabilite->getCaisseDepenses() as $value) 
                    {?>
                      <option value="<?= $value->ID_caisse?>"><?= $value->nomCaisse .'_'.$value->devise?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-1 col-md-2">
                  <button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtreApprovisionnement($('#banque_filtre').val(),$('#date1').val(),$('#date2').val(),$('#caisse_filtre').val())"><i class="ti ti-filter"></i> Filtrer</button>
              </div>
              <div class="col-lg-1 col-md-2">
                  <button type="button" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltreApprovisionnement()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Annuler</button>
              </div>
            </div>
            <div class="table-responsive m-t-0">
                <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <th>DATE</th>
                          <th>BANQUE</th>
                          <th>REFERENCE</th>
                          <th>MONTANT</th>
                          <th>CAISSE</th>
                          <th>RESPOSABLE</th>
                          <th>ETAT</th>
                          <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>DATE</th>
                        <th>BANQUE</th>
                        <th>REFERENCE</th>
                        <th>MONTANT</th>
                        <th>CAISSE</th>
                        <th>RESPOSABLE</th>
                        <th>ETAT</th>
                        <th></th>
                      </tr>
                    </tfoot>
                    <tbody id="rep">
                       <?php
                        $i=0;
                        foreach ($comptabilite->getApprivisionnements() as $value) 
                        {
                        $i++;
                        ?>
                        <tr>
                          <td><?php echo $value->date_operation?></td>
                          <td><?php echo $value->nom?></td>
                          <td><?php echo $value->reference?></td>
                          <td><?php echo $value->credit.' '.$value->monnaie?></td>
                          <td><?php echo $value->nomCaisse?></td>
                          <td><?php echo $value->nom_user?></td>
                          <td><?php 
                          if ($value->etat == 1) 
                          echo "Fermer";
                          else echo "En attente";
                        ?></td>
                          <td class="text-nowrap">

  <!--<a href="javascript:void(0)" data-toggle="modal" data-target="#myModalApproviCaisse-update<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
  </a>-->

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
                            <input type="text" class="form-control" id="idapro<?=$i?>" value="<?=$value->id?>" hidden>
                            <input type="text" id="etat<?=$i?>" value="<?=$value->etat?>" hidden>
                            Voulez-vous supprimer?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-rounded btn-danger" onclick="deleteAprovisionement($('#idapro<?=$i?>').val(),$('#etat<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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