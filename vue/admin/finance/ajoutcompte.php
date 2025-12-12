<?php
ob_start();
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
?>

<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
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
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
          <ol class="breadcrumb">
                <li class="breadcrumb-item active">compte</li>
            </ol>
            <button type="button" style="background-color: #8b4513"class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Creer un compte</button>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lgs">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="myLargeModalLabel">Creation un compte comptable</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal p-t-20">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group row">
                  <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Code compte</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  id="code">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Nom</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control"  id="nomcompte">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-7">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label" class="btn  active">Ligne de credit</label>
                <div class="col-sm-9 col-lg-8">
                    <div class="input-group-prepend"></div>
                    <input type="number" data-validation-required-message="Ce champs est obligatoire" class="form-control" id="lignecredit">
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-6 control-label">Monnaie</label>
                <div class="col-sm-9 col-lg-6">
                  <select class="form-control" id="monnaie">
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
            <div class="col-12">
                <div class="form-group">
                  <input type="text" id="utilisateur"  value="<?php echo $_SESSION['ID_user']?>"hidden>
                  <input type="date" class="form-control" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" id="datecompte" hidden>
                  <textarea class="form-control" id="note" > </textarea>
                </div>
            </div>
          </div><!-- END ROW-->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" style="background-color: #8b4513"class="btn font-light text-white" data-dismiss="modal" onclick="creationCompteComptable($('#code').val(),$('#nomcompte').val(),$('#lignecredit').val(),$('#monnaie').val(),$('#datecompte').val(),$('#note').val(),$('#utilisateur').val())"> <i class="fa fa-check"></i>cree compte</button>
        <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
 <!--<button type="button" class="btn btn-success d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg-appro"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Approvisionner compte</button>-->
  <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg-appro" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Approvisionner compte</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
              
                <form class="form-horizontal p-t-20">
                    <div class="row">
                      <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Provenance</label>
                            <div class="col-sm-9">
                              <div class="input-group">
                                 <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                  <select class="form-control"id="provenance" onchange="inclureProvenenceToApprovisioneCompteComptable($(this).val())">
                                    <option>faire votre choix</option>
                                      <option value="caisse">Caisse</option>
                                      <option value="banque">Banque</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-6" id="divInclubanqueCaisse"></div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                              <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Montant</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                  <div class="input-group-prepend"></div>
                                  <input type="text" class="form-control"  id="montant">
                              </div>
                           </div>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                              <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Destination</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                  <div class="input-group-prepend"></div>
                                  <select class="form-control"  id="destination">
                                    <?php foreach ($comptabilite->getCompteComptables() as $value) 
                                    {?>
                                     <option value="<?php echo $value->ID_compte.'_'.$value->lignecredit.'_'.$value->devise.'_'.$value->nomCompte ?>"><?php echo $value->nomCompte .'_'.$value->devise?></option>
                                      <?php
                                    }
                                    ?>
                                  </select>
                              </div>
                           </div>
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6">
                        <div class="form-group row" hidden>
                          <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>
                          <div class="col-sm-9">
                            <div class="input-group">
                              <div class="input-group-prepend"><span class="input-group-text"></span></div>
                              <input type="date" class="form-control" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" id="dateapprovisionement">
                              <input type="text" id="iduser"  value="<?php echo $_SESSION['ID_user']?>"hidden>
                            </div>
                          </div>
                        </div>
                    </div>
                    </div><!-- END ROW-->
                    </form>
            </div>
            <div class="modal-footer">
              <button type="button" style="background-color: #8b4513" class="btn font-light text-white" data-dismiss="modal" onclick="approvisionnercomptespi($('#provenance').val(),$('#montant').val(),$('#destination').val(),$('#dateapprovisionement').val(),$('#iduser').val())"> <i class="fa fa-check"></i>Valider</button>
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
            <div class="table-responsive m-t-0">
                <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Ligne credit</th>
                            <th>Montant</th>
                            <th>Devise</th>
                            <th>Commentaire</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Code</th>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Ligne credit</th>
                            <th>Montant</th>
                            <th>Devise</th>
                            <th>Commentaire</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody id="rep">
                       <?php
                       $i=0;
                       foreach ($comptabilite->getCompteComptables() as $value) 
                       {
                        $i++;
                        ?>
                        <tr>
                          <td><?php echo $value->code_compte?></td>
                          <td><?php echo $value->dateCompte?></td>
                          <td><?php echo $value->nomCompte?></td>
                          <td><?php echo $value->lignecredit?></td>
                          <td><?php echo $value->montantcompte?></td>
                          <td><?php echo $value->devise?></td>
                          <td><?php echo $value->note?></td>
                          <td class="text-nowrap">
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                    </a>
                    <!--<a href="<  =WEBROOT;?>detail" data-toggle="tooltip"  data-original-title="Voir"><i class="fa fa-eye text-inverse m-r-10"></i></a>-->
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Modifier ce compte</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal p-t-20">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">Code compte</label>
                <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-prepend"></div>
                    <input type="text" class="form-control"  id="code<?=$i?>" value="<?php echo $value->code_compte?>">
                    <input type="text" class="form-control"  id="idcompte<?=$i?>" value="<?php echo $value->ID_compte?>"hidden>
                  </div>
                </div>
              </div>
            </div> 
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">nom</label>
                <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-prepend"></div>
                    <input type="text" class="form-control"  id="nomcompte<?=$i?>" value="<?php echo $value->nomCompte?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label" class="btn  active">ligne de credit</label>
                <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-prepend"></div>
                    <input type="number" data-validation-required-message="Ce champs est obligatoire" class="form-control" id="lignecredit<?=$i?>" value="<?php echo $value->lignecredit?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                  <label for="exampleInputuname3" class="col-sm-3 control-label">Monnaie</label>
                  <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                    <select class="form-control" id="monnaie<?=$i?>" >
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
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation compte</label>
                <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                    <input type="date" class="form-control" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" id="datecompte<?=$i?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">montant compte</label>
                <div class="col-sm-9">
                  <div class="input-group">
                    <div class="input-group-prepend"></div>
                    <input type="number" class="form-control" id="montantcompte<?=$i?>" value="<?php echo $value->montantcompte?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-12">
              <div class="form-group row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                  <div class="input-group">
                    <div class="input-group-prepend"></div>
                    <textarea name="comment" id="commentaire<?=$i?>" class="form-control"><?php echo $value->note?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" style="background-color: #8b4513"class="btn font-light text-white" data-dismiss="modal" onclick="update_comptespi($('#code<?=$i?>').val(),$('#idcompte<?=$i?>').val(),$('#nomcompte<?=$i?>').val(),$('#lignecredit<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#datecompte<?=$i?>').val(),$('#montantcompte<?=$i?>').val(),$('#commentaire<?=$i?>').val())"> <i class="fa fa-check"></i>modifier ce compte</button>
        <button type="button" class="btn btn-dark waves-effect textt-left" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
  </div><!-- /.modal -->
    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i></a>
      <!-- sample modal content -->
      <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce compte</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body"> 
              <input type="text" class="form-control" id="idcompte<?=$i?>" value="<?php echo $value->ID_compte?>"hidden >
              Voulez-vous supprimer ce compte?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteCompteComptable($('#idcompte<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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