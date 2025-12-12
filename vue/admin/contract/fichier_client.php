<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('contrat',$_SESSION['ID_user'])->fetch()) 
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
?>
<input type="text" id="webroot" value="<?=WEBROOT?>" hidden>
<input type="text" id="root" value="<?=ROOT?>" hidden>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <!--<a href="<=WEBROOT?>printfacture" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> facture de dernier contract</a>-->
            <?php
            if ($c) 
            {?>

            <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Ajouter fichier</button>
            <?php
            } ?>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau Fichier</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form class="form-horizontal p-t-20" enctype="multipart/form-data" action="<?=WEBROOT?>fichierclient" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-10 col-md-10">
                                    <div class="row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Client*</label>
                                        <div class="form-group col-sm-9">
                                            <input type="text" id="idclientOnFichierAtacher" name="idclientOnFichierAtacher" class="form-control" autocomplete="off">
                                            <input type="text" name="idclient" id="idclient" hidden>
                                                <div id="modal"></div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- END ROW-->
                            <div class="row">
                                <div class="col-lg-10 col-md-10">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom*</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="nom" name="nom" class="form-control" placeholder="le nom du fichier">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-10">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Attache fichier*</label>
                                        <div class="col-sm-9">
                                            <input type="file" id="fichier" name="fichier" class="form-control" placeholder="choisir un fichier">
                                       </div>
                                    </div>
                                </div>
                                 <div class="col-lg-6 col-md-6">
                                    <div class="form-group row" >
                                        <!--<label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>-->
                                        <div class="col-sm-9" hidden="">
                                            <div> <input type="text" id="userfile"  value="<?php echo $_SESSION['ID_user']?>"></div>
                                            <input type="date" class="form-control" value="<?=date('Y-m-d')?>" id="datecreation">
                                        </div>
                                    </div>
                                </div>
                            </div><!-- END ROW-->
                        </div>
                        <div class="modal-footer">
                            <span id="msg"></span>
                            <button style="background-color: #7c4a2f" class="btn text-white waves-effect text-left" type="submit" name="POST" id="POST"><i class="fa fa-check"></i>Creer
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
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <form action="<?=WEBROOT?>filtreFichierAttacher" method="get" id="filtreFacture">
    <div class="row">
        <div class="col-lg-2 col-md-2">
            <div class="form-group">
            <input type="text" name="billing_number" id="billing_number_filtre" class="form-control form-control-sm input-filter" placeholder="billing number">
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group">
                <input type="text" name="nom_client" id="nom_client" class="form-control form-control-sm input-filter" placeholder="Nom client">
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group">
            <input type="date" name="date_creation" id="date1" class="form-control form-control-sm input-filter">
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group">
            <input type="text" name="file_name" id="profile_name" class="form-control form-control-sm input-filter" placeholder="Nom du fichier">
            </div>
        </div>
        <div class="col-lg-1 col-md-1">
            <button type="submit" style="background-color: #7c4a2f" class="btn btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
        </div>
        <div class="col-lg-1 col-md-1">
            <button type="button" class="btn btn-sm  btn-dark"onclick="resetFiltreFichierAttacher()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
        </div>
    </div>
</form>
                <div id="save"></div>
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Client</th>
                                <th>Nom</th>
                                <th>Fichier</th>
                                <th>Modification</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Numero</th>
                                <th>Client</th>
                                <th>Nom</th>
                                <th>Fichier</th>
                                <th>Modification</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep_fichier_attacher">
                            <?php 
                            $i = 0; 
                            $y = 0; 
                            foreach($result as $value)
                            {
                                $i++;
                            ?>
                            <tr>
                                <td> <?= $value->ID_fichier_client;?></td>
                                <td><a href="<?= WEBROOT;?>detailClient-<?= $value->ID_client;?>"> <?= $value->Nom_client.'-'.$value->billing_number;?></a></td>
                                <td> <?= $value->nom;?></td>
                                <td ><a href="<?=WEBROOT?>uploads/customer_file/file/<?=$value->ID_fichier_client.'/'.$value->fichier?>">Download</a></td>
                                <td><?= $value->date_fichier?></td>
                                <td class="text-nowrap">
                                    <?php
                                    if ($m) 
                                    {?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <?php
                                    }
                                    ?>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modification du fichier</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form class="form-horizontal p-t-20" enctype="multipart/form-data" action="<?=WEBROOT?>update_file" method="POST">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="mdi mdi-file"></i></span>
                                                    </div>
                                                    <input type="number" name="idfichier" id="idfichier<?=$i?>" value="<?php echo $value->ID_fichier_client;?>"hidden>

                                                    <input type="text" name="nom_fichier" id="nom_fichier<?=$i?>" class="form-control" value="<?php echo $value->nom?>">
                                                    <input type="text" name="oldFileName" class="form-control" value="<?= $value->fichier?>" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Fichier</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="icon-paper-clip"></i></span></div>
                                                    <input type="file" id="fichier<?=$i?>" name="fichier" class="form-control" value="<?php echo $value->fichier?>">
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                            </div>
                            <div class="modal-footer">
                                <!--<button type="button" class="btn btn-success  waves-effect" onclick="updateFichierAttacher($('#idfichier<?=$i?>').val(),$('#nom_fichier<?=$i?>').val(),$('#fichier<?=$i?>').val())"><i class="fa fa-check"></i>Modifier 
                                </button>-->
                                <button type="submit" class="btn btn-chocolate text-white  waves-effect"><i class="fa fa-check"></i>Modifier 
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

            <?php
                if ($s) 
                {?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                <?php
                }
            ?>

            <!-- sample modal content --> 
            <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Suppression du fichier</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="del_idfichier<?= $i?>" value="<?=$value->ID_fichier_client?>" hidden>
                            <input type="text" id="del_nomFichier<?=$i?>" value="<?=$value->fichier?>" hidden>
                            Voulez-vous supprimer ce fichier?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteFichierAttacher($('#del_idfichier<?=$i?>').val(),$('#del_nomFichier<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
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