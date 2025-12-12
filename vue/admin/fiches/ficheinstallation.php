<?php
ob_start();
/*require_once('model/connection.php');
require_once('model/ticket.class.php');
require_once('model/client.class.php');
require_once('model/User.class.php');
$user = new User();
$ticket =new Ticket();
$client =new Client();*/

$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('ficheinstallation',$_SESSION['ID_user'])->fetch()) 
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

<div class="row">
    <input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
    <input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"><a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></h4>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 font-light text-white " data-toggle="modal" data-target=".bs-example-modal-md"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Creer fiche
                           </button>

                           <div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Creer fiche d'installation</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal p-t-20" id="genficheinstallation" action="<?=WEBROOT?>genficheinstallation" method="post">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Client *</label>
                                                            <div class="form-group col-sm-9">
                                                                <!--<input type="text" id="idclient_ficheInstallation" class="form-control" autocomplete="off" name="idclient">
                                                                <div id="modal_fiche_instal"></div>-->
                                                                <input id="seachCustomerToCreateFiche" class="form-control form-control-sm" placeholder="filtrer le client">
                                                                <select id="selectCustomerToCreateFiche" name="idclient" class="form-control" size="3">
                                                                    <?php
                                                                        foreach ($client->getClientToCreateTicket() as $value) 
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
                                                </div><!-- END ROW-->
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <span id="msg"> 
                                                <?php
                                                    if (isset($msg)) 
                                                    {
                                                        echo $msg;
                                                    }
                                                ?>
                                            </span>
                                            <button  type="button" style="background-color: #8b4513" name="post" onclick="genfiche_installation($('#selectCustomerToCreateFiche').val())" class="btn  d-none d-lg-block m-l-15 font-light text-white"> <i class="fa fa-plus-circle"></i> Generer fiche installation</button>

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
                <form action="<?=WEBROOT?>filtreInstallation" method="get" id="filtreInstallation">
                    <div class="row">
                        <div class="col-lg-2 col-md-4">
                            <div class="form-group">
                            <input type="text" name="nom_client" class="form-control form-control-sm input-filter" placeholder="nom client">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <div class="form-group">
                            <input type="date" name="date1" id="date1" class="form-control form-control-sm input-filter">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <div class="form-group">
                            <input type="date" name="date2" id="date2" class="form-control form-control-sm input-filter">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <button type="submit" style="background-color: #7c4a2f" class="btn btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <button type="button" class="btn btn-sm  btn-dark"onclick="resetFiltreFicheInstallation()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Creation</th>
                                <th>Client</th>
                                <th>Statut</th>
                                <th>Action</th>    
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Creation</th> 
                                <th>Client</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                            $i =0;
                            foreach ($result as $value) 
                            {
                                $i++;
                            ?>
                            <tr>
                                <td><?php echo $value->date_creation?></td>
                                <td><?php echo $value->Nom_client;?></td>
                                <td><?php if($value->status=='ouvert')
                                {   $value->status ='en cours'
                                    ?>
                                    <span class="label label-danger"><?php echo $value->status?></span>
                                    <?php
                                }
                                elseif($value->status == 'fermer') 
                                {    $value->status ='fini'
                                    ?>
                                    <span class="label label-success"> <?php echo $value->status?></span>
                                <?php   
                                }
                                ?>
                                </td>
                                <td class="text-nowrap">
                                    <?php
                                    if ($l)  
                                    {?>
                                        <a href="<?=WEBROOT?>regenficheinstallation-<?php echo $value->ID_fiches?>" data-toggle="tooltip" data-original-title="Print"> <i class="icon-printer text-inverse m-r-10"></i> </a>
                                        <?php
                                    }
                                   
                                    if ($s)  
                                    {
                                        ?>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer fiche"> <i class="ti-trash text-inverse m-r-10"></i></a>
                                    <?php
                                    }
                                    ?>
                                    <!-- sample modal content -->
                                    <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette fiche</h4>
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