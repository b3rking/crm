<?php
ob_start();

$l = false;
$c = false;
$m = false; 
$s = false;
if ($d = $user->verifierPermissionDunePage('recuperation',$_SESSION['ID_user'])->fetch()) 
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
$status_libelle = [0 => 'EN ATTANTE',1 => 'CONFIRMER'];
$status_colors = [0 => 'badge-danger',1 => 'badge-success'];
$typeEquipementArray = ['antenne','routeur','switch','radio'];
?>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<input type="text" id="l" value="<?=$l?>" hidden>
<input type="text" id="c" value="<?=$c?>" hidden>
<input type="text" id="m" value="<?=$m?>" hidden>
<input type="text" id="s" value="<?=$s?>" hidden>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body" >
                  <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                      <h4 class="text-themecolor"><a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button></h4>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <div class="d-flex justify-content-end align-items-center">
                            <?php
                            if ($c) 
                            {?>
                                <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-md-st"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Recuperer equipement</button>
                            <?php
                            }
                            ?>

<!-- sample modal content -->
<div class="modal fade bs-example-modal-md-st" tabindex="-1" id="create" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog bs-example-modal-md-st">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Sortie d'equipement en stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div> 
            <div class="modal-body">
                <form class="form-horizontal p-t-0"> 
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Client</label>
                                <input id="seachCustomerToCreateFiche" class="form-control form-control-sm input-filter" onkeyup="filter('idclient',this.value)">
                                <select id="idclient" class="form-control input-filter" size="3">
                                    <option value=""></option>
                                    <?php
                                        foreach ($customers as $value) 
                                        {
                                    ?>
                                            <option value="<?=$value->ID_client?>">
                                                <?=$value->Nom_client.' -- code: '.$value->billing_number?>
                                            </option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Type equipement</label>
                                <select class="form-control form-control-sm input-filter" id="type" onchange="showOrHiddeNbPortDiv(this.value,'nbport_div')">
                                    <option value=""></option>
                                    <option value="antenne">ANTENNE</option>
                                    <option value="routeur">ROUTEUR</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Mac adresse </label>
                                <input type="text" class="form-control form-control-sm input-filter" name="routeur" id="mac">
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <!--<div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Fabriquant</label>
                                <select class="form-control form-control-sm input-filter" id="maker">
                                    <option value=""></option>
                                    <php
                                    foreach ($makers as $value) 
                                    {?>
                                        <option value="<=$value->id?>"><=$value->name?></option>
                                    <php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>-->
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Model </label>
                                <select class="form-control form-control-sm input-filter" id="model">
                                    <option value=""></option>
                                    <?php
                                    foreach ($models as $value) 
                                    {?>
                                        <option value="<?=$value->id?>"><?=$value->name?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Date recuperation</label>
                                <input type="date" id="date_recuperation" class="form-control form-control-sm input-filter" value="<?= date('Y-m-d')?>">
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <!--<div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Marque*</label>
                                <select class="form-control form-control-sm input-filter" id="marque">
                                    <option value=""></option>
                                    <option value="NANO STATION M5">NANO STATION M5</option>
                                    <option value="GIGABEAM">GIGABEAM</option>
                                    <option value="DILINK">DILINK</option>
                                    <option value="TPLINK">TPLINK</option>
                                    <option value="MIKROTIK CLIENT">MIKROTIK CLIENT</option>
                                    <option value="MIKROTIK RELAIS">MIKROTIK RELAIS</option>
                                </select>
                            </div>
                        </div>-->
                        
                        <div class="col-lg-6 col-md-6" id="nbport_div" style="display: none;">
                            <div class="form-group">
                                <label for="nbport" class="control-label">Nombre de port</label>
                                <input type="number" id="nbport" class="form-control form-control-sm input-filter" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control form-control-sm input-filter" id="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                </form>
            </div>
            <div class="modal-footer">
                <button  type="button" class="btn btn- text-white btn-chocolate"  onclick="equipement_recovery($('#idclient').val(),$('#type').val(),$('#mac').val(),$('#model').val(),$('#date_recuperation').val(),$('#iduser').val(),$('#description').val())"> <i class="fa fa-check"></i>Valider </button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>
                <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" onclick="submitFormReportSortieEquipement()"><i class="mdi mdi-printer" class="modal fade" tabindex="-1" role="dialog"></i>Generer pdf</button>
        </div>
    </div>
</div>
            <form action="<?=WEBROOT?>filtreRecuperation" method="get" id="filtreRecuperationForm">
                <div class="row">
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <input type="text" name="nom_client" class="form-control form-control-sm input-filter" value="<?=$nom_client?>" placeholder="nom client">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <select name="type_equipement" class="form-control form-control-sm input-filter">
                                <option value="">Type equipement</option>
                                <?php
                                foreach($typeEquipementArray as $type)
                                {
                                    if ($type == $type_equipement) 
                                    {
                                ?>
                                        <option value="<?=$type?>" selected><?=$type?></option>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                        <option value="<?=$type?>"><?=$type?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                        <input type="text" name="mac_address" class="form-control form-control-sm input-filter" value="<?=$mac_address?>" placeholder= "mac adresse">
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
                    <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                            <select id="mois_filter" name="mois" class="form-control form-control-sm input-filter">
                                <option value="">Mois</option>
                            <?php
                            for ($i=1; $i<13  ; $i++) 
                            {
                                if ($i == $mois) 
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
                    <div class="col-lg-1 col-md-2">
                        <div class="form-group">
                            <input type="number" name="annee" id="annee_filter" class="form-control form-control-sm input-filter" value="<?=$annee?>">
                            <input type="text" name="print" id="print" value="0" hidden="">
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <!--<button type="button" class="btn btn-chocolate btn-rounded btn-sm  text-white"onclick="filtreSortie_equipement($('#demander_par_filter').val(),$('#destination_filter').val(),$('#date1').val(),$('#date2').val(),$('#mois_filter').val(),$('#annee_filter').val())"><i class="ti ti-filter"></i> Filtrer</button>-->
                        <button type="submit" class="btn btn-chocolate btn-rounded btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <button type="reset" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltreRecuperation()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                    </div>
                </div>
            </form>
                <form class="form-horizontal p-t-0" action="<?=WEBROOT?>fiche_de_stock_equipement" method="post" id="form-reportSortieEquipement">
                    <input type="text" id="cond" name="cond" hidden="">
                </form>
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>CLIENT</th>
                                <th>TYPE EQUIPEMENT</th>
                                <th>FABRIQUANT</th>
                                <th>MODEL</th>
                                <th>MAC</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>DATE</th>
                                <th>CLIENT</th>
                                <th>TYPE EQUIPEMENT</th>
                                <th>FABRIQUANT</th>
                                <th>MODEL</th>
                                <th>MAC</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php 
                            $i =0;
                            foreach($result as $value)
                            {
                                $i++;
                            ?>
                            <tr>
                                <td><?=$value->recovery_date?></td>
                                <td><?=$value->nom_client?></td>
                                <td><?=$value->type_equipement?></td>
                                <td><?=$value->maker?></td>
                                <td><?=$value->name?></td>
                                <td><?=$value->first_adress?></td>
                                <td class="text-nowrap">

                                <a href="javascript:void(0)" data-toggle="modal" data-target=".modal-md-update-recover-equip<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                <!-- sample modal content -->
                                <div class="modal fade modal-md-update-recover-equip<?=$i?>" id="modalUpdate-<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog bs-example-modal-md-st">
                                        <div class="modal-content">
                                            <div class="modal-header"><!--la couleur dans l'entete du modal style="background-color: #dc7633"-->
                                                <h4 class="modal-title" id="myLargeModalLabel">Sortie d'equipement en stock</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div> 
                                            <div class="modal-body">
                                                <form class="form-horizontal p-t-0"> 
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <label for="exampleInputEmail3" class="control-label">Client</label>
                                                            <div class="form-group">
                                                                <input type="hidden" id="current_customer<?=$i?>" value="<?=$value->customer_id?>">
                                                                <input id="seachCustomerToCreateFiche<?=$i?>" class="form-control form-control-sm input-filter" onkeyup="filter('idclient<?=$i?>',this.value)"><br>
                                                                <select id="idclient<?=$i?>" class="form-control input-filter" size="3">
                                                                     <?php
                                                                        foreach ($customers as $k) 
                                                                        {
                                                                    ?>
                                                                            <option value="<?=$k->ID_client?>">
                                                                                <?=$k->Nom_client.' -- code: '.$k->billing_number?>
                                                                            </option>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <label for="exampleInputEmail3" class="control-label">Type equipement</label>
                                                            <div class="form-group">
                                                                <select class="form-control form-control-sm input-filter" id="type<?=$i?>" onchange="showOrHiddeNbPortDiv(this.value,'nbport_div<?=$i?>')">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    if ($value->type_equipement == 'antenne') 
                                                                    {
                                                                    ?>
                                                                        <option value="antenne" selected="">ANTENNE</option>
                                                                        <option value="routeur">ROUTEUR</option>                                                                    <?php
                                                                    }
                                                                    else
                                                                    {
                                                                    ?>
                                                                        <option value="antenne">ANTENNE</option>
                                                                        <option value="routeur" selected="">ROUTEUR</option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <label for="exampleInputEmail3" class="control-label">Mac adresse </label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm input-filter" name="routeur" id="mac<?=$i?>" value="<?=$value->first_adress?>">
                                                            </div>
                                                        </div>
                                                    </div><!-- END ROW-->
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <label for="exampleInputEmail3" class="control-label">Model </label>
                                                            <div class="form-group">
                                                                <select class="form-control form-control-sm input-filter" id="model<?=$i?>">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    foreach ($models as $model) 
                                                                    {
                                                                        if ($model->id == $value->model_id) 
                                                                        {
                                                                    ?>
                                                                            <option value="<?=$model->id?>" selected><?=$model->name?></option>
                                                                    <?php
                                                                        }
                                                                        else
                                                                        {
                                                                    ?>
                                                                            <option value="<?=$model->id?>"><?=$model->name?></option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <label for="exampleInputEmail3" class="control-label">Date recuperation</label>
                                                            <div class="form-group">
                                                                <input type="date" id="date_recuperation<?=$i?>" class="form-control form-control-sm input-filter" value="<?= $value->recovery_date?>">
                                                            </div>
                                                        </div>
                                                    </div><!-- END ROW-->
                                                    <div class="row">
                                                        <?php
                                                        if ($value->type_equipement == 'routeur') 
                                                        {
                                                        ?>
                                                            <div class="col-lg-6 col-md-6" id="nbport_div<?=$i?>">
                                                                <label for="nbport" class="control-label">Nombre de port</label>
                                                                <div class="form-group">
                                                                    <input type="number" id="nbport<?=$i?>" class="form-control form-control-sm input-filter" value="<?=$value->nb_port?>">
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                            <div class="col-lg-6 col-md-6" id="nbport_div<?=$i?>" style="display: none;">
                                                                <label for="nbport" class="control-label">Nombre de port</label>
                                                                <div class="form-group">
                                                                    <input type="number" id="nbport<?=$i?>" class="form-control form-control-sm input-filter" value="1">
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="form-group row">
                                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
                                                                <div class="col-sm-9">
                                                                    <textarea class="form-control form-control-sm input-filter" id="description<?=$i?>"><?=$value->description?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- END ROW-->
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button  type="button" class="btn btn- text-white btn-chocolate"  onclick="update_equipement_recovery('<?=$value->customer_id?>',$('#idclient<?=$i?>').val(),$('#type<?=$i?>').val(),$('#mac<?=$i?>').val(),$('#model<?=$i?>').val(),$('#date_recuperation<?=$i?>').val(),$('#iduser').val(),$('#description<?=$i?>').val(),'<?=$value->id?>','<?=$value->equipement_id?>')"> <i class="fa fa-check"></i>Valider </button>
                                                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!--/.modal-dialog -->
                                </div>
                            <?php
                            if ($s) 
                            {?>
                               <!--<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>-->
                            <?php
                            }
                            ?>

                            <!-- sample modal content -->
                            <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer antenne</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body"> 
                                        <input type="text" class="form-control" id="idSortie<?=$i?>" value="" hidden>
                                        <input type="text" class="form-control" id="idequipement<?=$i?>" value="" hidden>
                                        Voulez-vous supprimer cette sortie?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="delete_Sortie_equipement($('#idSortie<?=$i?>').val(),$('#idequipement<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </td>
                    </tr>
                <?php
                    }
                    ?></tbody>
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