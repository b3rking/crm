<?php
ob_start();
?>
<div class="card">
        <div style="background-color: #8b4513" class="card-header text-white box text-center">
            Sponsor
        </div>

    <div class="card-body">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center" id="bbb">
                <h4 class="text-themecolor"></h4>
            </div>
            <div class="col-md-7 align-self-center">
                <div class="d-flex justify-content-end align-items-center">
                    <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 btn font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>ajouter un sponsor</button>

                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">Nouveau sponsor</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal p-t-20">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Demande</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                             <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                            <input type="text" id="demande" class="form-control">
                                                        </div>
                                                   </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Offre</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                            <select   id="visibilite"  class="form-control">
                                                                <option></option>
                                                                <?php foreach ($marketing->recuperermaterielstock() as  $value)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $value->materiels?>"><?php echo $value->materiels?></option>
                                                                 <?php   
                                                                } 
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Adresse</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                            <input type="text" class="form-control" placeholder="adresse" id="adrsponsor">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Telephone</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                            <input type="text" class="form-control" id="phonesponsor">
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Date debut</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                            <input type="date" class="form-control"  id="datedebut">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                               <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Nature</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                            <input type="text" id="nature" class="form-control" placeholder="la nature" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Date cloture</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                            <input type="date" class="form-control"  id="datefin">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <span id="msgmm"></span>
                                    <button type="button" style="background-color: #8b4513" class="btn font-light text-white" data-dismiss="modal" onclick="ajoutersponsor($('#demande').val(),$('#nature').val(),$('#adrsponsor').val(),$('#phonesponsor').val(),$('#visibilite').val(),$('#datedebut').val(),$('#datefin').val())"> <i class="fa fa-check"></i> Ajouter ce sponsor</button>
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
        <div class="row">
            <div class="table-responsive m-t-0">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Demande</th>
                                <th>Nature</th>
                                <th>Adresse</th>
                                <th>Telephone</th>
                                <th>Offre</th>
                                <th>Date debut</th>
                                <th>Date fin</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Numero</th>
                                <th>Demande</th>
                                <th>Nature</th>
                                <th>Adresse</th>
                                <th>Telephone</th>
                                <th>Offre</th>
                                <th>Date debut</th>
                                <th>Date fin</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                            $i =0;
                            foreach ($marketing->affichetoutSponsor () as $value)
                            {
                                $i++;
                                ?>
                                <tr>
                                <td><?php echo $value->ID_sponsor?></td>
                                <td><?php echo $value->demande?></td>
                                <td><?php echo $value->nature?></td>
                                <td><?php echo $value->adresse?></td>
                                <td><?php echo $value->telephone?></td>
                                <td><?php echo $value->visibilite?></td>
                                <td><?php echo $value->duredebut?></td>
                                <td><?php echo $value->durefin?></td>
                                <td class="text-nowrap">
                                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier ce sponsor</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal p-t-20">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Demande</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                        <input type="text" id="demande<?=$i?>" value="<?php echo $value->demande?>" class="form-control">
                                                        <input type="text" id="idsponsor<?=$i?>" value="<?php echo $value->ID_sponsor?>" class="form-control" hidden>
                                                    </div>
                                               </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nature </label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                        <input type="text" id="nature<?=$i?>" value="<?php echo $value->nature?>" class="form-control">
                                                    </div>
                                               </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Adresse du sponsor</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                        <input type="text" id="adrsponsor<?=$i?>" value="<?php echo $value->adresse?>" class="form-control">
                                                    </div>
                                               </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Telephone</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                        <input type="text" class="form-control" id="phonesponsor<?=$i?>" value="<?php echo $value->telephone?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Offre</label>
                                                <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                    <input type="text" id="visibilite<?=$i?>" value="<php echo $value->visibilite?>" class="form-control">
                                                </div>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date debut</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                        <input type="date" class="form-control"  id="datedebut<?=$i?>" value="<?php echo $value->duredebut?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date cloture</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                        <input type="date" class="form-control"  id="datefin<?=$i?>" value="<?php echo $value->durefin?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- END ROW-->
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button style="background-color: #8b4513"class="btn font-light text-white" onclick="updateSponsor($('#idsponsor<?=$i?>').val(),$('#demande<?=$i?>').val(),$('#nature<?=$i?>').val(),$('#adrsponsor<?=$i?>').val(),$('#phonesponsor<?=$i?>').val(),$('#datedebut<?=$i?>').val(),$('#datefin<?=$i?>').val())" data-dismiss="modal">Modifier sponsor
                                </button>
                                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce sponsor</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                                <input type="text" class="form-control" id="numspons<?= $i?>" value="<?php echo $value->ID_sponsor?>" hidden>
                                Voulez-vous supprimer ce sponsor?<br><br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerSponsor($('#numspons<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>