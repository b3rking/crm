<?php
ob_start();

$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('ficheintervention',$_SESSION['ID_user'])->fetch()) 
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
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body" >
                 <!--a href="<=WEBROOT?>technique" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"> Retour</i></a><span class="btn-label"></span></button-->
                 <a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a>
                <div class="row page-titles">
    <div class="col-md-5 align-self-center">
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <?php
            //if ($c) 
           // {?>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Fiche</a></li>
                    <li class="breadcrumb-item active">Intervention</li>
                </ol>
               <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 font-light text-white " data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Creer fiche </button>
            <?php
           //}
            ?>
                            <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Creation de fiche d'intervention</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="<?=WEBROOT?>fichepanne" method="post" class="form-horizontal" id="form-fiche-intervention">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label  col-md-3">Vehicule* </label>
                                <div class="col-md-9">
                                    <select  class="form-control form-control-sm input-filter" id="vehicule" name="plaque">
                                    <option></option>
                                    <?php
                                    foreach ($vehicule->selection_plaque() as $value)
                                    {?>
                                        <option value="<?= $value->immatriculation?>">
                                            <?=$value->marque.' - '.$value->immatriculation?>
                                        </option>
                                            
                                    <?php
                                    }
                                    ?>
                                    </select> 
                                </div> 
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label col-md-4">Technicien* </label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm input-filter" id="technicien" name="technicien">
                                    <option value=""></option>
                                    <?php
                                    foreach ($user->getTechniciens() as $data)
                                    {?>
                                    <option value="<?php echo $data->ID_user?>"><?php echo $data->nom_user?></option>
                                    <?php
                                    }
                                    ?>
                                    </select> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>DATE CREATION</th>
                                <th>CLIENT</th>
                                <!--<th>ADRESSE</th>
                                <th>TELEPHONE</th>-->
                                <th>PROBLEME</th>
                                <th>STATUS</th>
                                <th>CHOIXT*</th>
                            </tr>
                            </thead>
                            <tbody id="rep" >

                             <?php 
                             $i = 0;
                             foreach($ticket->afficheTicket_client() as $value)
                                {
                                    $i++;
                                ?>
                                   <tr>
                                <td><?= $value->created_at?></td>
                                <td><?= $value->Nom_client?> </td>
                                <!--<td><?= $value->adresse?></td>
                                <td><?= $value->telephone?></td>-->
                                <td><?= $value->ticket_type?></td>
                                <td><?php if($value->status == 'ouvert')
                                {
                                    ?>
                                    <span style="background-color: #ef7f22" class="label label-"><?php echo $value->status?></span>
                                    <?php
                                }
                                elseif($value->status == 'fermer') 
                                {?>
                                    <span class="label label-success"> <?php echo $value->status?></span>
                                <?php   
                                }
                                ?>
                                </td>
                                <td>
                                <input type="checkbox" name="ticket[<?=$i?>]" id="observation_ticket" value="<?=$value->id?>" onclick="verifierTicketCocher(this)">
                                </td>
                            </tr>
                                <?php
                                }
                                ?>        
                            </tbody>
                        </table>
                    </div>
                    <input type="text" id="counterTicketSelected" value="0" hidden="">
                    <input type="text" name="createurFiche" value="<?=$_SESSION['ID_user']?>" hidden>
                </div>
                <div class="modal-footer">
                    <?php
                    if ($c) 
                    {?>
                        <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 font-light text-white" onclick="validateFormFicheIntervention()"><i class="fa fa-check"></i> Creer</button>
                    <?php
                    }
                    ?>
                    <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline" ></i>Fermer</button>
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
            <form action="<?=WEBROOT?>filtreFicheIntervention" method="get" id="filtreFacture">
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="form-group">
            <input type="date" name="date_creation" id="date1" class="form-control form-control-sm input-filter">
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="form-group">
                <select class="form-control form-control-sm input-filter" id="technicien" name="technicien">
                    <option value="">Technicien</option>
                    <?php
                    foreach ($user->getTechniciens() as $data)
                    {?>
                    <option value="<?php echo $data->ID_user?>"><?= $data->nom_user?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-1 col-md-1">
            <button type="submit" style="background-color: #7c4a2f" class="btn btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
        </div>
        <div class="col-lg-1 col-md-1">
            <button type="button" class="btn btn-sm  btn-dark"onclick="resetFiltreFicheIntervention()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
        </div>
    </div>
</form> 
                <div class="table-responsive">
                    <table id="listeFichIntervention" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>DATE CREATION</th>
                                <th>TECHNICIEN</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="rep" >
                         <?php 
                            $i = 0;
                            foreach($result as $value)
                            {
                                $i++;
                            ?>
                            <tr>
                                <td><?=$value->date_creation?></td>
                                <td><?=$value->nom_user?> </td>
                                <td class="text-nowrap">
                                    <?php
                                    if ($l) 
                                    {?>
                                        <a href="<?=WEBROOT?>regenficheintervention-<?= $value->ID_fiches?>" data-toggle="tooltip" data-original-title="Print"> <i class="icon-printer text-inverse m-r-10"></i> </a>
                                    <?php
                                    }
                                    if ($s) 
                                    {?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i></a>

                                    <!-- sample modal content -->
                                    <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="mySmallModalLabel">Suppretion de fiche</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="text" class="form-control" id="idfiche<?= $i?>" value="<?php echo $value->ID_fiches?>"hidden >
                                                    Voulez-vous supprimer cette fiche ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn waves-effect waves-light btn-danger" onclick="supprimer_fiche($('#idfiche<?=$i?>').val(),$('#userName').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content --> 
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    <?php
                                    }
                                    ?>
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