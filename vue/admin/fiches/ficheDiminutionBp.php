<?php
ob_start();

$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('ficheDiminutionBP',$_SESSION['ID_user'])->fetch()) 
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
    <input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center" id="rep">
                        <h4 class="text-themecolor"><a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></h4>
                    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <?php
                if ($c) 
                {?>
                    <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i> Creer fiche
                    </button>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Fiche diminution bande passante</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">                                                
                <form class="form-horizontal p-t-20" id="fiche_diminuerbp" action="<?=WEBROOT?>genficheDiminutionBP" method="post">
                    <div class="row">
                        <div class="col-lg-12 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Client*</label>
                                <div class="form-group col-sm-9">
                                    <!--<input type="text" id="idclient_diminuBP" class="form-control" autocomplete="off" name="idclient">
                                    <div id="modal_diminuer_bp"></div>-->
                                    <input id="seachCustomerToCreateFiche" class="form-control form-control-sm">
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
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-4 col-md-3 col-lg-3 control-label">Bande passante*</label>
                                <div class="col-sm-6 col-md-7 col-lg-8">
                                    <input type="text" class=" form-control" id="bandepassante" name="bandepassante" value="1" min="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Diminuer à partir du*</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="date" class="bootstrapMaterialDatePicker form-control" id="datedebut" name="datedebut" value="<?=date('Y-m-d')?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Au*</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="date" class="bootstrapMaterialDatePicker form-control" id="datefin" name="datefin" value="<?=date('Y-m-d')?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button  type="button" style="background-color: #8b4513" name="post" onclick="genfiche_diminution_bp($('#selectCustomerToCreateFiche').val(),$('#bandepassante').val(),$('#datedebut').val(),$('#datefin').val())" class="btn d-none d-lg-block m-l-15 font-light text-white"> Generer fiche diminution bande passante</button>

                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>
                <?php
                }
                ?>
        </div>
    </div>
</div>
                <form action="<?=WEBROOT?>filtreDiminutionBd" method="get">
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
                            <button type="button" class="btn btn-sm  btn-dark"onclick="resetFiltreFicheDiminutionBp()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                           <tr>
                              <th>CREATION</th>
                              <th>BANDE PASSANTE DIMINUER</th>
                                <th>DEBUT</th>
                                <th>DATE FIN</th>
                                <th>CLIENT</th>
                                <th>STATUT</th>
                                <th></th> 
                            </tr>
                        </thead>
                        <tfoot>
                             <tr>
                              <th>CREATION</th>
                              <th>BANDE PASSANTE DIMINUER</th>
                                <th>DEBUT</th>
                                <th>DATE FIN</th>
                                <th>CLIENT</th>
                                <th>STATUT</th>
                                <th></th> 
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
                                <td>
                                    <?php echo $value->bandeP;?>
                                </td>
                                <td>
                                    <?php echo $value->dateDebut;?>
                                </td>
                                <td>
                                    <?php echo $value->dateFin;?>
                                </td>
                                <td><?php echo $value->Nom_client;?></td>
                                <td><?php if($value->status=='ouvert')
                                {
                                     $value->status ='en cours'
                                    ?>
                                    <span class="label label-danger"><?php echo $value->status?></span>
                                    <?php
                                }
                                elseif($value->status == 'fermer') 
                                {
                                     $value->status ='fini'
                                    ?>
                                    <span class="label label-success"> <?php echo $value->status?></span>
                                <?php   
                                }
                                ?>
                                </td>
                                <!--<td><?php  $value->description?></td>-->
                               <!--debut td bouton modification   -->
                                <td class="text-nowrap">
                                    <?php
                                    if ($l) 
                                    {?>
                                        <a href="<?=WEBROOT?>fiche_diminution_bp-<?php echo $value->ID_fiches?>" data-toggle="tooltip" data-original-title="Voir"> <i class="icon-printer text-inverse m-r-10"></i> </a>
                                    <?php
                                    }
                                    ?>
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