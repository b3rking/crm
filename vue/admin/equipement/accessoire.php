<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('accessoire',$_SESSION['ID_user'])->fetch()) 
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
$month_etiquete = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
?>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body" >
                <!--<div id="rep"></div>-->
                <span id="msg"></span>
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <!--h4 class="text-themecolor">Accessoire</h4--><a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>
                        </div>
                        <div class="col-md-7 align-self-center">
                            <div class="d-flex justify-content-end align-items-center">

    <!--<a href="<= WEBROOT;?>attribution_materiel_client" style="background-color: #8b4513" class="btn text-white d-none d-lg-block m-l-15"><i class="fa fa-check"></i>Attribuer accessoire client</a>-->
     
    <?php
    if ($c) 
    {
    ?>
        <a href="<?=WEBROOT?>categorieAccessoire" class="btn btn-chocolate text-white d-none d-lg-block m-l-15">Categorie accessoire</a>
        <!--<button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Categorie </button>-->
        <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Ajouter accessoire en stock</button>
    <?php
    }
    ?>

<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><!--la couleur dans l'entete du modal style="background-color: #dc7633"-->
                <h4 class="modal-title" id="myLargeModalLabel">Ajout d'accessoire en stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Categorie </label>
                            <div class="col-sm-9">
                                <select id="categorie_id" class="form-control">
                                    <option value>Faire un choix</option>
                                    <?php
                                    foreach ($equipement->getCategorieAccessoires() as $data)
                                    {?>
                                        <option value="<?= $data->categorie_id?>"><?= $data->categorie?></option>
                                    <?php
                                    }
                                    ?>               
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite</label>
                            <div class="col-sm-9">
                                <input type="number" id="quantite_entree" class="form-control" placeholder="le nombre">
                            </div>
                        </div>
                    </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">description</label>
                            <div class="col-sm-9">
                                <input type="text" id="commentaire" class="form-control" placeholder=" note">
                            </div>
                        </div>
                    </div>
                      <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date entré</label>
                            <div class="col-sm-9">
                                <input type="date" id="date_entre" class="form-control" value="<?=date('Y-m-d')?>" >
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" class="modal-header">
                <button type="button" class="btn btn-chocolate text-white" data-dismiss="modal" onclick="ajouterAccessoire($('#categorie_id').val(),$('#quantite_entree').val(),$('#commentaire').val(),$('#date_entre').val())"> <i class="fa fa-check"></i> Ajouter accessoire</button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div> 
            <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgg" onclick="submitRapportEntreeSortieAccessoir()"><i class="fa fa-file" class="modal fade" tabindex="-1" role="dialog"></i> Generer PDF</button>
        </div>
    </div>
</div>

                <!-- FILTRE -->
                <form action="<?=WEBROOT?>filtreAccessoire" method="get" id="filtreAccessoireForm">
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                                <select id="categorie_id" name="categorie_id" class="form-control form-control-sm input-filter">
                                    <option value="">Categorie</option>
                                    <?php
                                    foreach ($equipement->getCategorieAccessoires() as $data)
                                    {
                                        if ($categorie_id == $data->categorie_id) 
                                        {
                                    ?>
                                            <option value="<?= $data->categorie_id?>" selected><?= $data->categorie?></option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?= $data->categorie_id?>"><?= $data->categorie?></option>
                                    <?php
                                        }
                                    }
                                    ?>                
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                                <input type="date" name="date1" id="date1" class="form-control form-control-sm input-filter" value="<?=$date1?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                                <input type="date" name="date2" id="date2" class="form-control form-control-sm input-filter" value="<?=$date2?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                                <select id="mois_filter" name="mois" class="form-control form-control-sm input-filter">
                                    <option value="">Mois</option>
                                    <?php
                                    for ($i=1; $i<13  ; $i++) 
                                    {
                                        if ($mois == $i) 
                                        {
                                    ?>
                                            <option value="<?=$i?>" selected><?=$month_etiquete[$i]?></option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?=$i?>"><?=$month_etiquete[$i]?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <input type="number" name="annee" id="annee_filter" class="form-control form-control-sm input-filter" value="<?=$annee?>">
                                <input type="text" name="print" id="print" value="0" hidden="">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <button type="submit" class="btn btn-chocolate btn-rounded btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <button type="button" class="btn btn-rounded btn-sm btn-danger" onclick="resetFiltreAccessoire()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead> 
                            <tr>
                                <th>CATEGORIE</th>
                                <th>QUANTITE</th>
                                <th>COMMENTAIRE</th>
                                <th>DATE ENTREE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>CATEGORIE</th>
                                <th>QUANTITE</th>
                                <th>COMMENTAIRE</th>
                                <th>DATE ENTREE</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                            $i=0;
                            foreach ($result as $value)
                            {
                                $i++;
                            ?>
                            <tr>
                                <td><?= $value->categorie?></td>
                                <td><?= $value->in_store?> </td>
                                <td><?= $value->description?></td>
                                <td><?= $value->operation_date?></td>
                                <td class="text-nowrap">
                                    <?php
                                    if ($m) 
                                    {?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                                        </a>
                                    <?php
                                    }
                                    ?>
                <!-- sample modal content -->
                            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header"><!--la couleur dans l'entete du modal style="background-color: #dc7633"-->
                                            <h4 class="modal-title" id="myLargeModalLabel">Modification d'accessoire en stock</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal p-t-20">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                    <div class="form-group row">
                                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Categorie </label>
                                                        <div class="col-sm-9">
                                                            <select id="categorie_id<?=$i?>" class="form-control">
                                                                <option value>Faire un choix</option>
                                                                <?php
                                                                foreach ($equipement->getCategorieAccessoires() as $data)
                                                                {
                                                                    if ($value->categorie_id == $data->categorie_id) 
                                                                    {
                                                                ?>
                                                                        <option value="<?= $data->categorie_id?>" selected><?= $data->categorie?></option>
                                                                <?php
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                        <option value="<?= $data->categorie_id?>"><?= $data->categorie?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>               
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="form-group row">
                                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite</label>
                                                        <div class="col-sm-9">
                                                            <input type="number" id="quantite_entree<?=$i?>" class="form-control" value="<?=$value->in_store?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                </div><!-- END ROW-->
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                    <div class="form-group row">
                                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">description</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" id="commentaire<?=$i?>" class="form-control" value="<?=$value->description?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                  <div class="col-lg-6 col-md-6">
                                                    <div class="form-group row">
                                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Date entré</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" id="date_entre<?=$i?>" class="form-control" value="<?=$value->operation_date?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer" class="modal-header">
                                            <button type="button" class="btn btn-chocolate text-white" data-dismiss="modal" onclick="updateEntrerAccessoire($('#categorie_id<?=$i?>').val(),$('#quantite_entree<?=$i?>').val(),$('#commentaire<?=$i?>').val(),$('#date_entre<?=$i?>').val(),'<?=$value->id?>')"> <i class="fa fa-check"></i> Ajouter accessoire</button>
                                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!--/.modal-dialog -->
                            </div>

                    <?php
                    if ($m) 
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
                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer accessoire</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body"> 
                                Voulez-vous supprimer cet accessoire?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="suppression_accessoire('<?=$value->id?>')" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                                </div>
                            </div>
                            <!--/.modal-content -->
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