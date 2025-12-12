<?php
    $i=0;
    foreach ($equipement->affichageSecteur() as $data) 
    {
        $i++;
      ?>                   
        <tr>
            <td><?php echo $data->ID_secteur?></td>
            <td><?php echo $data->nom_secteur?></td>
            <td><?php echo $data->adresse_secteur?></td>
            <td>
                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lgs<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lgs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modification secteur</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal p-t-20">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="icon-feed"></i></span></div>
                                                    <input type="text" class="form-control custom-select" id="nom_secteur<?=$i?>" value="<?php echo $data->nom_secteur?>">
                                                    <input type="text" class="form-control custom-select" id="Code_secteur<?=$i?>" value="<?php echo $data->ID_secteur?>" hidden>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Adresse</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                        <input type="text" class="form-control" id="adrese_secteur<?=$i?>" value="<?php echo $data->adresse_secteur?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- END ROW-->
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" onclick="update_Secteur($('#Code_secteur<?=$i?>').val(),$('#nom_secteur<?=$i?>').val(),$('#adrese_secteur<?= $i?>').val())" data-dismiss="modal">modifier
                                </button>
                                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
            
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer secteur</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                                <input type="text" class="form-control" id="Code_secteur<?= $i?>" value="<?php echo $data->ID_secteur?>" hidden>
                                Voulez-vous supprimer ce secteur?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="suppressionSecteur($('#Code_secteur<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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