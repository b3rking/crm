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
?>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
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
                                <ol class="breadcrumb">
                                </ol>
                                <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-md-st"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Sortir accessoire</button>
                            <?php
                            }
                            ?>

<!-- sample modal content -->
<div class="modal fade bs-example-modal-md-st" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog bs-example-modal-md-st">
        <div class="modal-content">
            <div class="modal-header"><!--la couleur dans l'entete du modal style="background-color: #dc7633"-->
                <h4 class="modal-title" id="myLargeModalLabel">Sortie d'accessoire en stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div> 
            <div class="modal-body">
                <form class="form-horizontal p-t-0"> 
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Destination</label>
                                <select id="destination" onchange="destination_accessoire($(this).val(),0)" class="form-control input-filter">
                                    <option>Selectionnez la destination</option>
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
                                    <option value="<?= $rs->ID_user?>"><?= $rs->nom_user?></option>
                                    <?php
                                    }
                                    ?>               
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Accessoire </label>
                                <select id="accessoire" class="form-control input-filter">
                                    <option value=""></option>
                                    <?php
                                    foreach ($equipement->getAccessories() as $donne)
                                    {
                                    ?>
                                        <option value="<?= $donne->categorie_id.'-'.$donne->quantite?>"><?= $donne->categorie.'***'.$donne->quantite?></option>
                                    <?php
                                    }
                                    ?>               
                                </select>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Date sortie</label>
                                <input type="date" id="date_sortie" class="form-control input-filter" value="<?= date('Y-m-d')?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail3" class="control-label">Quantite</label>
                                <input type="number" id="quantitesortie" class="form-control input-filter" value="1">
                            </div>
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
                <button  type="button" class="btn btn-chocolate btn- text-white"  onclick="setAccessoire_user($('#destination').val(),$('#demander_par').val(),$('#accessoire').val(),$('#date_sortie').val(),$('#quantitesortie').val(),$('#motif').val(),$('#iduser').val())"> <i class="fa fa-check"></i>Attribuer </button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>
                <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" onclick="submitFiltreSortieAccessoireForm()"><i class="mdi mdi-printer" class="modal fade" tabindex="-1" role="dialog"></i>Generer pdf</button>
                <!--<form class="form-horizontal p-t-0" action="<=WEBROOT?>fiche_de_sortie_accessoire" method="post" id="form-reportSortieAccessoire">
                    <input type="text" id="cond" name="cond" hidden="">
                </form>-->
        </div>
    </div>
</div>
                <!-- FILTRE -->
                <form action="<?=WEBROOT?>filtreSortieAccessoire" method="get" id="filtreSortieAccessoireForm">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <select id="demander_par_filter" name="demander_par" class="form-control form-control-sm input-filter">
                                <option value="">Demander par</option>
                                <?php
                                foreach ($user->get_utulisateur() as $rs)
                                {
                                    if ($demander_par == $rs->ID_user) 
                                    {
                                ?>
                                        <option value="<?= $rs->ID_user?>" selected><?= $rs->nom_user?></option>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                        <option value="<?= $rs->ID_user?>"><?= $rs->nom_user?></option>
                                <?php
                                    }
                                }
                                ?>               
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <select class="form-control form-control-sm input-filter" name="destination" id="destination_filter">
                                <option value="">Destination</option>
                                <?php
                                    $destination_array = ['client','relais','base','vehicule'];
                                    for ($i=0; $i < count($destination_array); $i++) 
                                    { 
                                        if ($destination == $destination_array[$i]) 
                                        {
                                ?>
                                           <option value="<?=$destination_array[$i]?>" selected><?=$destination_array[$i]?></option>
                                <?php
                                        }
                                        else
                                        {
                                ?>
                                            <option value="<?=$destination_array[$i]?>"><?=$destination_array[$i]?></option>
                                <?php
                                        }
                                    }
                                ?>
                                <!--<option value="">Destination</option>
                                <option value="client">Client</option>
                                <option value="relais">Relais</option>
                                <option value="base">Base</option>
                                <option value="vehicule">Vehicule</option>-->
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
                        <!--<button type="button" class="btn btn-chocolate btn-rounded btn-sm  text-white"onclick="filtreSortie_accessoire($('#demander_par_filter').val(),$('#destination_filter').val(),$('#date1').val(),$('#date2').val(),$('#mois_filter').val(),$('#annee_filter').val())"><i class="ti ti-filter"></i> Filtrer</button>-->
                        <button type="submit" class="btn btn-chocolate btn-rounded btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <button type="button" class="btn btn-rounded btn-sm btn-danger" onclick="resetFiltreSortieAccessoire()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                    </div>
                </div>
            </form>
                <!--<form class="form-horizontal p-t-0" action="<=WEBROOT?>fiche_de_stock_equipement" method="post" id="form-reportSortieEquipement">
                    <input type="text" id="cond" name="cond" hidden="">
                </form>-->
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>ACCESSOIR</th>
                                <th>QUANTITE</th>
                                <th>DESCRIPTION</th>
                                <th>DESTINATION</th>
                                <th>SORTIE PAR</th>
                                <th>DEMANDER PAR</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>DATE</th>
                                <th>ACCESSOIR</th>
                                <th>QUANTITE</th>
                                <th>DESCRIPTION</th>
                                <th>DESTINATION</th>
                                <th>SORTIE PAR</th>
                                <th>DEMANDER PAR</th>
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
                                <td><?= $value->operation_date?></td>
                                <td><?= $value->categorie?> </td>
                                <td><?= $value->out_store?></td>
                                <td><?= $value->description?></td>
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
                                    ?>
                                </td>
                                <td><?php
                                echo $nom_user = $user->getUserById($value->sortie_par)->fetch()['nom_user'];
                                ?></td>
                                <td><?php
                                echo $nom_user = $user->getUserById($value->demander_par)->fetch()['nom_user'];?></td>  
                                <td class="text-nowrap">

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
                                            <!--<input type="text" class="form-control" id="idSortie<=$i?>" value="<=$value->ID_sortie_accessoire?>" hidden>
                                            <input type="text" class="form-control" id="idaccessoire<=$i?>" value="<=$value->ID_accessoire?>" hidden>
                                            <input type="text" class="form-control" id="quantite<=$i?>" value="<=$value->quantite?>" hidden>-->
                                            Voulez-vous supprimer cette sortie?
                                        </div>
                                        <div class="modal-footer">
                                            <!--<button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="delete_Sortie_accessoire($('#idSortie<=$i?>').val(),$('#idaccessoire<=$i?>').val(),$('#quantite<=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>-->
                                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="delete_Sortie_accessoire('<?=$value->id?>')" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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