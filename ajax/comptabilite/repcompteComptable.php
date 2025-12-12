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
                      <option value="<?php echo $value->devise?>"><?php echo $value->devise?></option>
                      <option value="FC">FC</option>
                      <option value="USD">USD</option>
                      <option value="BIF">BIF</option>
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
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="update_comptespi($('#code<?=$i?>').val(),$('#idcompte<?=$i?>').val(),$('#nomcompte<?=$i?>').val(),$('#lignecredit<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#datecompte<?=$i?>').val(),$('#montantcompte<?=$i?>').val(),$('#commentaire<?=$i?>').val())"> <i class="fa fa-check"></i>modifier ce compte</button>
        <button type="button" class="btn btn-danger waves-effect textt-left" data-dismiss="modal">Fermer</button>
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