<?php
require_once('model/connection.php');
require_once('model/ticket.class.php');
require_once('model/client.class.php');
require_once('model/User.class.php');
$user = new User();
$ticket =new Ticket();
$client =new Client();

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
<div class="col-lg-12 col-md-12 col-xl-12">
<div class="card">
<div class="card-body">
    <div class="row page-titles">
            <div class="col-md-5 align-self-center" id="rep">
                <h4 class="text-themecolor"><a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button></h4>
            </div>
            <div class="col-md-7 align-self-center">
                <div class="d-flex justify-content-end align-items-center">
                   <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white " data-toggle="modal" data-target=".bs-example-modal-md"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Creer fiche
                   </button>
                  
<div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-md">
<div class="modal-content">
<div class="modal-header">
    <h4 class="modal-title" id="myLargeModalLabel">Client a installer</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form class="form-horizontal p-t-20" id="genficheinstallation" action="<?=WEBROOT?>genficheinstallation" method="post">
        <div class="row">
            <div class="col-lg-9 col-md-6">
                <div class="form-group row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Client *</label>
                    <div class="form-group col-sm-9">
                        <input type="text" id="idclient_ficheInstallation" class="form-control" autocomplete="off" name="idclient">
                            <div id="modal_fiche_instal"></div>
                    </div>
                 
                </div>
            </div>
            <div class="col-lg-6 col-md-6"hidden>
                <div class="form-group row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                             <input type="date" class="form-control" id="dateInstallation" name="dateInstallation" value="<?php echo date('Y-m-d')?>">
                             
                        </div>
                   </div>
                </div>
            </div>
        </div><!-- END ROW-->
    
</div>
<div class="modal-footer">
    <span id="msg"> <?php
                    if (isset($msg)) 
                    {
                        echo $msg;
                    }
                ?></span>
   <!--<button type="submit" name="POST"  class="btn btn-success d-none d-lg-block m-l-15"> <i class="fa fa-plus-circle"></i> Generer fiche</button>-->
     <button  type="button" style="background-color: #8b4513" name="post" onclick="genfiche_installation($('#idclient_ficheInstallation').val(),$('#dateInstallation').val())" class="btn  d-none d-lg-block m-l-15 font-light text-white"> <i class="fa fa-plus-circle"></i> Generer fiche installation</button>

    <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!--/.modal-dialog --> <input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
</div></form>
                </div>
            </div>
        </div>
    <div class="table-responsive m-t-0">
        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
           <thead>
                <tr>
                    <th>Creation</th>
                    <th>Date installation</th>
                    <th>Client</th>
                    <th>Statut</th>
                    <th>Action</th>    
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Creation</th>
                    <th>Date installation</th> 
                    <th>Client</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody id="rep">
                    <?php
                    $i =0;
                    foreach ($ticket->recupererFicheInstallations() as $value) 
                    {
                        $i++;
                        ?>
                        <tr>
                    <td><?php echo $value->date_creation?></td>
                    <td>
                        <?php echo $value->dateInstallation;?>
                    </td>
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
                <button type="button" class="btn waves-effect waves-light btn-dark" onclick="supprimer_fiche($('#idfiche<?=$i?>').val(),$('#userName').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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

