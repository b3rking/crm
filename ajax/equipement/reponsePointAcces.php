    <?php 
            $i = 0;
            foreach($equipement->affichagePoint_acces() as $data)
            {
            $i++;
            ?>
            <tr>
                <!--<td><hp echo $data->ID_point_acces?></td>-->
                <td><?php echo $data->secteur?></td>
                <td><?php echo $data->nom?></td>
                <td><?php echo $data->ip?></td>
                <td><?php echo $data->mac?></td>
                <td><?php echo $data->antenne?></td>
                <td><?php echo $data->frequence?></td>
                <td><?php echo $data->SSID?></td>
                <td><?php echo $data->antenne_limite?></td>
                <td class="text-nowrap">
                    
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                 
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier le point d'acces</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                <div class="row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                <div class="col-sm-9" >
                    <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"hidden><i class="ti-user"></i></span>
                </div>
                <input type="text" class="form-control" id="idpa<?= $i?>" value="<?php echo $data->ID_point_acces?>" hidden>
            </div>
        </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Nom</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="nompa<?= $i?>" value="<?php echo $data->nom?>">
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Frequence</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                            <input type="text" class="form-control" id="frequence<?= $i?>" value="<?php echo $data->frequence?>">
                        </div>
                    </div>
                </div>
                </div>
                 <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">IP</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                <input type="text" class="form-control" id="ipa<?= $i?>" value="<?php echo $data->ip?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">limite antenne</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                <input type="text" class="form-control" id="ant_limite_pa<?= $i?>" value="<?php echo $data->antenne_limite?>">
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                </div><!-- END ROW-->
                <div class="row">
                <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">SSID</label>
                    <div class="col-sm-9">

                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                    <input type="text" class="form-control" id="ssidpa<?=$i?>" value="<?php echo $data->SSID?>">
                </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">MAC</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                   <input type="text" class="form-control" id="mac_adress<?=$i?>" value="<?php echo $data->mac?>" >
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div><!-- End row-->
               <!-- End row-->

               <!--<div class="row">
                  <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">MAC</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                <input type="text" class="form-control" id="macpa<?= $i?>" value="<php echo $data->mac?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Antenne</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                <input type="text" class="form-control" id="antene_type_pa<?= $i?>" value="<php echo $data->antenne?>">
                            </div>
                        </div>
                    </div>
                </div>
                </div>-->
                </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" onclick="update_point_acces($('#idpa<?=$i?>').val(),$('#nompa<?=$i?>').val(),$('#frequence<?=$i?>').val(),$('#ipa<?=$i?>').val(),$('#ant_limite_pa<?=$i?>').val(),$('#ssidpa<?=$i?>').val())" data-dismiss="modal">changer
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                    

                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer point d'acces</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="nupa<?= $i?>" value="<?php echo $data->ID_point_acces?>" hidden>
                            Voulez-vous supprimer ce point d'acces?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimer_point_acces($('#nupa<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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
            