<?php
  $i=0;
  foreach ($comptabilite->filtreApprivisionnements($condition) as $value) 
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
                            Voulez-vous supprimer cette caisse?
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