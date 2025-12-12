<?php
ob_start();
?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
    </div>
    <input type="text" id="idUser" value="<?= $_SESSION['ID_user']?>" hidden>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <button type="button"style="background-color: #8b4513" class="btn font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Nouvelle pause</button>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouvelle pause</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                               <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Client*</label>
                                            <div class="form-group col-sm-9 col-md-9 col-lg-10">
                                                <input type="text" id="idclient_suspension" class="form-control" autocomplete="off">
                                                    <div id="modal-suspension"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Debut da la pause*</label>
                                            <div class="form-group col-sm-9">
                                                <input type="date" id="dateDebut" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Fin de la pause</label>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <input type="date" class="form-control" id="dateFin">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Type pause</label>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <select id="type_suspension" class="form-control">
                                                        <option value="demande_par_client">demander pa le client</option>
                                                        <option value="probleme_technique">Probleme technique</option>
                                                    </select>
                                                    <input type="text" value="<?=date('Y-m-d')?>" class="form-control" id="date_creation" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Raison</label>
                                            <div class="form-group col-sm-9">
                                                <input type="text" id="raison" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <span id="msg"></span>
                            <button type="button" style="background-color: #8b4513" class="btn font-light text-white" onclick="creerPause($('#idclient_suspension').val(),$('#dateDebut').val(),$('#dateFin').val(),$('#raison').val(),$('#type_suspension').val(),$('#date_creation').val(),$('#idUser').val())"> Valider
                                        </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-t-0">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Date debut</th>
                                <th>Date fin</th>
                                <th>Raison</th>
                                <th>Type</th>
                                <th>Creer</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Client</th>
                                <th>Date debut</th>
                                <th>Date fin</th>
                                <th>Raison</th>
                                <th>Type</th>
                                <th>Creer</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                            $mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
                            $i=0;
                            foreach ($contract->getClientEnPauses() as $value)
                            {
                                $i++;
                            ?>
                                <tr>
                                    <td><a href="<?= WEBROOT;?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->nom_client;?></b></a></td>
                                    <td><?= $value->date_debut?></td>
                                    <td><?= $value->date_fin?></td>
                                    <td><?= $value->raison?></td>
                                    <td><?= $value->type_pause?></td>
                                    <td><?= $value->date_creer?></td>
                                    <td>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouvelle pause</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                               <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Client</label>
                                            <div class="form-group col-sm-9 col-md-9 col-lg-10">
                                                <input type="text" id="idclient<?=$i?>" class="form-control" value="<?= $value->ID_client;?>" hidden>
                                                <input type="text" class="form-control" value="<?= $value->nom_client;?>" disabled>
                                                <input type="text" id="idPause<?=$i?>" value="<?=$value->id?>" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Debut da la pause</label>
                                            <div class="form-group col-sm-9">
                                                <input type="date" id="dateDebut<?=$i?>" class="form-control" value="<?=$value->date_debut?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Fin de la pause</label>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <input type="date" class="form-control" id="dateFin<?=$i?>" value="<?= $value->date_fin?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Type pause</label>
                                            <div class="col-sm-9">
                                                <div class="form-group">
                                                    <select id="type_pause<?=$i?>" class="form-control">
                                                        <?php
                                                        if ($value->type_pause == 'demande_par_client') 
                                                        {?>
                                                            <option value="demande_par_client" selected="">demander pa le client</option>
                                                            <option value="probleme_technique">Probleme technique</option>
                                                        <?php
                                                        }
                                                        else
                                                        {?>
                                                            <option value="demande_par_client">demander pa le client</option>
                                                            <option value="probleme_technique" selected="">Probleme technique</option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Raison</label>
                                            <div class="form-group col-sm-9">
                                                <input type="text" id="raison<?=$i?>" class="form-control" value="<?=$value->raison?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <span id="msg"></span>
                            <button type="button"style="background-color: #8b4513" class="btn waves-effect text-left font-light text-white" onclick="updatePause($('#idPause<?=$i?>').val(),$('#idclient<?=$i?>').val(),$('#dateDebut<?=$i?>').val(),$('#dateFin<?=$i?>').val(),$('#raison<?=$i?>').val(),$('#type_pause<?=$i?>').val(),$('#idUser').val())">Modifier
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
                <h4 class="modal-title" id="mySmallModalLabel">Cause de suppresion :</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" id="idPause_del<?=$i?>" value="<?=$value->id?>" hidden>
                <input type="text" id="idclient_del<?=$i?>" value="<?=$value->ID_client?>" hidden>
                <input type="date" id="dateDebut_del<?=$i?>" class="form-control" value="<?=$value->date_debut?>" hidden>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="row">
                            <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="btn">
                                            <input type="checkbox" id="deletePause_parErreur<?=$i?>" checked="" value="<?=$i?>" onclick="getCauseSuppresionPause(this,'<?=$i?>')"> une erreur
                                        </label> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="row">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="btn">
                                                <input type="checkbox" id="pause_terminer<?=$i?>" value="<?=$i?>" onclick="getCauseSuppresionPause(this,'<?=$i?>')"> reouverture
                                            </label> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="deletePause_contener<?=$i?>" style="display: none;">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
                            <div class="form-group col-sm-9">
                                <input type="date" id="dateOuverture<?=$i?>" class="form-control" value="<?=date('Y-m-d')?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletePause($('#idPause_del<?=$i?>').val(),$('#idclient_del<?=$i?>').val(),$('#dateDebut_del<?=$i?>').val(),$('#idUser').val(),'<?=$i?>')" data-dismiss="modal"><i class="ti-trash"></i></button>
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