 <?php 
                            $i = 0; 
                            $y = 0;
                      foreach($contract->afficherfichier_client_avec_contrat() as $value)
                            {
                                $i++;
                            ?>
                            <tr>
                                
                                <td> <?php echo $value->ID_fichier_client;?></td>
                                <td><a href="<?= WEBROOT;?>detailClient_fichier_contract-<?= $value->ID_client;?>"> <?php echo $value->Nom_client;?></a></td>
                             
                                <td> <?php echo $value->nom;?></td>
                                <!--<td><a href="<?= WEBROOT;?>printContract-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Print">Download </a>-->
                                    <td class="col col-file"><a href="/crm.spidernet/fichier_client_spidernet/<?=$value->fichier?>" download ="<?=$value->fichier?>">Download</a></td>
                               
                                <td><?= $value->date_fichier?></td>
                                <td><?= $value->prenom?></td>
                              
                                <td class="text-nowrap">
                                    <a href="<?= WEBROOT;?>detailContract-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>
                                    <!--<a href="<?= WEBROOT;?>printContract-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>-->
                                    
                                   
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modification d'un contract</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                           <form class="form-horizontal p-t-20">
                            
                    <div class="row">
                        <div class="col-lg-10 col-md-10">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-file"></i></span>
                                        </div>
                                        <input type="number" id="numerofichier<?=$i?>" value="<?php echo $value->ID_fichier_client;?>"hidden>
                                        <input type="text" id="nom_fichier<?=$i?>" class="form-control" value="<?php echo $value->nom?>">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-10 col-md-10">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Attache fichier</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="icon-paper-clip"></i></span></div>
                                        <input type="file" id="fichier_doc<?=$i?>" class="form-control" value="<?php echo $value->fichier?>">
                                    </div>
                               </div>
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
                            <div class="form-group row" >
                                <!--<label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>-->
                                <div class="col-sm-9" hidden="">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span>
                                        </div>
                                        <div> <input type="text" id="userfile"  value="<?php echo $_SESSION['ID_user']?>"></div>
                                        <input type="date" class="form-control" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" id="datecreation">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success  waves-effect" onclick="updatefichierClient($('#numerofichier<?=$i?>').val(),$('#nom_fichier<?=$i?>').val(),$('#fichier_doc<?=$i?>').val())"><i class="fa fa-check"></i>Modifier 
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer Client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="idclient<?= $i?>" value="" hidden>
                Voulez-vous supprimer ce client?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteClient($('#idclient<?= $i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
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
                            ?><!-- END FOREACH-->