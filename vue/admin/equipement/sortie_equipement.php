<?php
ob_start();
$l = false;
$c = false;
$m = false; 
$s = false;
if ($d = $user->verifierPermissionDunePage('antenne',$_SESSION['ID_user'])->fetch()) 
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
$destinationArray = ['client','relais','base'];
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
                      <h4 class="text-themecolor"><a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></h4>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <div class="d-flex justify-content-end align-items-center">
                            <?php
                            if ($c) 
                            {?>
                                <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-md-st"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Sortir equipement</button>
                            <?php
                            }
                            ?>

<!-- sample modal content -->
<div class="modal fade bs-example-modal-md-st" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
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
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Destination</label>
                                <select id="destination" onchange="destination_accessoire($(this).val(),0)" class="form-control input-filter">
                                    <option value="">Selectionnez la destination</option>
                                    <option value="client">Client</option>
                                    <option value="relais">Relais</option>
                                    <option value="base">Base</option>
                                    <option value="vehicule">Vehicule</option>
                                    <option value="autre">Autre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="affiche_destination0">
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Demander_par </label>
                                <select id="demander_par" class="form-control input-filter">
                                    <option value="">Faire un choix</option>
                                                    
                                    <?php
                                    foreach ($user->get_utulisateur() as $rs)
                                    {?>
                                    <option value="<?= $rs->ID_user?>"><?php echo $rs->nom_user?></option>
                                    <?php
                                    }
                                    ?>               
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Type equipement </label>
                                <select id="type" class="form-control input-filter" onchange="getEquipementByType($(this).val())">
                                    <option></option>
                                    <option value="antenne">Atenne</option>
                                    <option value="routeur">Routeur</option>
                                    <option value="switch">Switch</option>
                                    <option value="radio">Radio</option>
                                </select>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Date sortie</label>
                                <input type="date" id="date_sortie" class="form-control input-filter" value="<?php echo date('Y-m-d')?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6" id="dive_equipement">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 form-group">
                            <textarea class="form-control input-filter" id="motif" placeholder="Motif ....  "></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                 <button  type="button" class="btn btn- text-white btn-chocolate"  onclick="sortieEquipementEnStock($('#destination').val(),$('#demander_par').val(),$('#type').val(),$('#date_sortie').val(),$('#motif').val(),$('#iduser').val())"> <i class="fa fa-check"></i>Attribuer </button>
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
            <form action="<?=WEBROOT?>filtreSortie_equipement" method="get" id="filtreSortie_equipementForm">
                <div class="row">
                    <div class="col-lg-1 col-md-2">
                        <div class="form-group">
                            <select id="demander_par_filter" name="demander_par" class="form-control form-control-sm input-filter">
                                <option value="">Demander par</option>
                                                
                                <?php
                                foreach ($user->get_utulisateur() as $rs)
                                {
                                    if ($demander_par == $rs->ID_user) 
                                    {
                                ?>
                                        <option value="<?= $rs->ID_user?>"><?php echo $rs->nom_user?></option>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                        <option value="<?= $rs->ID_user?>"><?php echo $rs->nom_user?></option>
                                <?php
                                    }
                                }
                                ?>               
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                            <select class="form-control form-control-sm input-filter" id="destination_filter" name="destination">
                                <option value="">Destination</option>
                                <option value="client">Client</option>
                                <option value="relais">Relais</option>
                                <option value="base">Base</option>
                                <?php
                                foreach($destinationArray as $value)
                                {
                                    if ($destination == $value) 
                                    {
                                ?>
                                        <option value="<?=$value?>" selected><?=strtoupper($value)?></option>
                                <?
                                    }
                                    else
                                    {
                                ?>
                                        <option value="<?=$value?>"><?=strtoupper($value)?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
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
                        <button type="reset" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltreSortie_equipement()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
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
                                <th>EQUIPEMENT</th>
                                <th>MAC</th>
                                <th>DESCRIPTION</th>
                                <th>DESTINATION</th>
                                <th>SORTIE PAR</th>
                                <th>DEMANDER PAR</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>DATE</th>
                                <th>EQUIPEMENT</th>
                                <th>MAC</th>
                                <th>DESCRIPTION</th>
                                <th>DESTINATION</th>
                                <th>SORTIE PAR</th>
                                <th>DEMANDER PAR</th>
                                <th>STATUS</th>
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
                            <td><?= $value->date_sortie?></td>
                            <td><?= $value->model?></td>
                            <td><?=$value->first_adress?></td>
                            <td><?= $value->motif?></td>
                            <td>
                                <?php
                                if ($value->destination == 'client') 
                                {
                                    echo $client->afficherUnClentSansContract($value->destination_detail)->fetch()['Nom_client'];
                                    //$destination[$value->destination] = 'selected';
                                }
                                elseif ($value->destination == 'relais') 
                                {
                                    echo $equipement->getSecteurById($value->destination_detail)->fetch()['nom_secteur'];
                                    //$destination[$value->destination] = 'selected';
                                }
                                elseif ($value->destination == 'base') 
                                {
                                    echo $equipement->getAccessPointById($value->destination_detail)->fetch()['nom'];
                                    //$destination[$value->destination] = 'selected';
                                }
                                elseif ($value->destination == 'vehicule') 
                                {
                                    $vehicule_res = $vehicule->getVehiculeById($value->destination_detail)->fetch();
                                    echo $vehicule_res['modele']."-".$vehicule_res['marque'];
                                    //$destination[$value->destination] = 'selected';
                                }
                                elseif($value->destination == 'autre')
                                    echo $value->motif;
                                ?>
                            </td>
                            <td><?php
                                echo $user->getUserById($value->sortie_par)->fetch()['nom_user'];
                                ?></td>
                            <td><?= $value->nom_user?></td>
                            <td>
                                <h4><span class="badge <?=$status_colors[$value->status]?>"><?=$status_libelle[$value->status]?></span></h4>
                            </td>
                            <td class="text-nowrap">
                                <?php
                                if ($value->status == 0) 
                                {
                                ?>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal-close<?=$i?>" data-original-title="Editer"> <i class="fa fa-check text-inverse m-r-10"></i> </a>
                                <?php
                                }
                                ?>
                                <!-- sample modal content -->
                                <div id="myModal-close<?=$i?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Confirmation de sortie</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                Voulez-vous confirmer cette sortie?
                                            </div>
                                            <div class="modal-footer">
                                                <span id="msg_sendfact"></span>
                                                <button type="button" class="btn btn-chocolate text-white waves-effect text-left" onclick="confirmerSortieEquipement('<?=$value->ID_sortie?>','<?=$value->ID_equipement?>','<?=$value->destination_detail?>','<?=$value->destination?>','<?=$value->date_sortie?>','<?=$value->sortie_par?>')"><i class="fa fa-check"></i> Confirmer
                                                    </button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

                                          <?php
                            if ($m) 
                            {?>
                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-md-lg<?=$i?>" data-original-title="Editer">Modifier<i class="fa fa-pencil text-inverse m-r-10"></i></a>
                            <?php
                            }
                            ?>
                            <!-- sample modal content -->
<div class="modal fade bs-example-modal-md-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog bs-example-modal-md-lg<?=$i?>">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Modifier Sortie d'equipement en stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div> 
            <div class="modal-body">
                <form class="form-horizontal p-t-0"> 
                    <div class="row">
                        <div class="col-lg-10 col-md-10">
                            <div class="form-group">
                                <input type="text" id="idSortie<?=$i?>" value="<?=$value->ID_sortie?>"hidden>
                                <label for="exampleInputEmail3" class="control-label">Destination</label>
                                <select id="destination<?=$i?>" onchange="updateSortie_equip($(this).val(),0)" class="form-control input-filter">
                                    <option value="">Selectionnez la destination</option>
                                    <option value="client">Client</option>
                                    <option value="relais">Relais</option>
                                    <option value="base">Base</option>
                                    <option value="vehicule">Vehicule</option>
                                    <option value="autre">Autre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="affiche_destination20"></div>
                    <div class="row">
                        <div class="col-lg-9 col-md-9">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Demander_par </label>
                                <select id="demander_par<?=$i?>" class="form-control input-filter">
                                    <option value="">Faire un choix</option>
                                                    
                                    <?php
                                    foreach ($user->get_utulisateur() as $rs)
                                    {?>
                                    <option value="<?= $rs->ID_user?>"><?php echo $rs->nom_user?></option>
                                    <?php
                                    }
                                    ?>               
                                </select>
                            </div>
                        </div>
                      
                    </div><!-- END ROW-->
                     <div class="row">
                            <div class="col-lg-9 col-md-9">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Type equipement </label>
                                <select id="type<?=$i?>" class="form-control input-filter" onchange="getEquipementByType2($(this).val())">
                                    <option><?=$value->type_equipement?></option>
                                    <option value="antenne">Atenne</option>
                                    <option value="routeur">Routeur</option>
                                    <option value="switch">Switch</option>
                                    <option value="radio">Radio</option>
                                </select>
                            </div>
                        </div>
                       </div>
                    <div class="row">
                        <div class="col-lg-9 col-md-9">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Date sortie</label>
                                <input type="date" id="date_sortie<?=$i?>" class="form-control input-filter" value="<?php echo date('Y-m-d')?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-md-10" id="dive_equipements"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-md-10 form-group">
                            <textarea class="form-control input-filter" id="motif<?=$i?>"><?=$value->motif?></textarea>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-lg-9 col-md-9">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Status </label>
                                <select id="status<?=$i?>" class="form-control input-filter">
                                                    
                                   
                                    <option value="<?=$value->status?>"><?=$status_libelle[$value->status]?></option>
                                    <option value="1">Confirmer</option>
                                    <option value="0">En attente</option>            
                                </select>
                            </div>
                        </div>
                      
                    </div><!-- END ROW-->
                     <div class="row">
                        <div class="col-lg-9 col-md-9">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Utiliser </label>
                                <select id="used<?=$i?>" class="form-control input-filter">
                                                    
                                   
                                    <option value="<?=$value->used?>"><?=$value->used?></option>
                                    <option value="oui">OUI</option>
                                    <option value="pending">NON</option>            
                                </select>
                            </div>
                        </div>
                      
                    </div><!-- END ROW-->
                </form>
            </div>
            <div class="modal-footer">
                 <button  type="button" class="btn btn- text-white btn-chocolate"  onclick="modifiersortieEquipementEnStock($('#idSortie<?=$i?>').val(),$('#destination<?=$i?>').val(),$('#demander_par<?=$i?>').val(),$('#type<?=$i?>').val(),$('#date_sortie<?=$i?>').val(),$('#motif<?=$i?>').val(),$('#iduser').val(),$('#status<?=$i?>').val(),$('#used<?=$i?>').val())"> <i class="fa fa-check"></i>Modifier </button>
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
                               <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
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
                                        <input type="text" class="form-control" id="idSortie<?=$i?>" value="<?=$value->ID_sortie?>" hidden>
                                        <input type="text" class="form-control" id="idequipement<?=$i?>" value="<?=$value->ID_equipement?>" hidden>
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