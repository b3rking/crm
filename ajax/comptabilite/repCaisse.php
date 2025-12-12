
                       <?php
                       $i=0;
                       foreach ($comptabilite->getCaisses() as $value) 
                       {
                        $i++;
                        ?>
                        <tr>
                          <td><?php echo $value->ID_caisse?></td>
                          <td><?php echo $value->nomCaisse?></td>
                          <td><?php echo $value->devise?></td>
                          <td><?php echo $value->lignecredit?></td>
                          <td><?php echo $value->etat?></td>
                          <td><?php echo $value->datecaisse?></td>
                          <td><?php echo $value->description?></td>
                          <td><?php echo $value->nom_user?></td>
                            
                             <td class="text-nowrap">
  <a href="<?=WEBROOT;?>detailcaisse-<?php echo $value->ID_caisse?>" data-toggle="tooltip"  data-original-title="Voir"><i class="fa fa-eye text-inverse m-r-10"></i></a>

  <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
  <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
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
                      <option value="<?php echo $value->devise?>"><?php echo $value->devise?></option>
                      <option value="FC">FC</option>
                      <option value="USD">USD</option>
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
                  <input name="lignecredit" class="form-control" type="number" id="lignecredit<?=$i?>" value="<?php echo $value->lignecredit?>">
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Statut</label>
                <div class="col-sm-9">
                  <select class="form-control" id="statut<?=$i?>">
                    <option value="<?php echo $value->etat?>"><?php echo $value->etat?></option>
                    <option value="active">active</option>
                    <option value="desactive">desactive</option>
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
                <label for="exampleInputuname3" class="col-sm-3 control-label">Dimmension</label>
                <div class="col-sm-9">
                  <select class="form-control" id="dimmension<?=$i?>">
                    <option value="<?=$value->dimension?>"><?=$value->dimension?></option>
                    <option value="petite">Petite</option>
                    <option value="grande">Grande</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xlg-6">
              <div class="form-group">
                <textarea class="form-control" id="description<?=$i?>"><?php echo $value->description?></textarea>
                <input type="text" id="idcaisse<?=$i?>" value="<?php echo $value->ID_caisse?>" hidden>
              </div>
            </div>
          </div>
        </form>
      </div>
            <div class="modal-footer">
                            <button type="button" class="btn btn-success"data-dismiss="modal" onclick="updateCaisse($('#idcaisse<?=$i?>').val(),$('#nomcaisse<?=$i?>').val(),$('#devise<?=$i?>').val(),$('#lignecredit<?=$i?>').val(),$('#statut<?=$i?>').val(),$('#responsable<?=$i?>').val(),$('#datecreationcaisse<?=$i?>').val(),$('#dimmension<?=$i?>').val(),$('#description<?=$i?>').val(),$('#idusers').val())"> <i class="fa fa-check"></i>modifier caisse</button>
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