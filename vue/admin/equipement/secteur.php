<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('secteur',$_SESSION['ID_user'])->fetch()) 
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
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body" >
                 <!--a href="<=WEBROOT?>technique" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"> Retour</i></a><span class="btn-label"></span></button-->
                 <a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>
                <div class="row page-titles">
    <div class="col-md-5 align-self-center">
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <?php
            if ($c) 
            {?>
                <!--<ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Equipement</a></li>
                    <li class="breadcrumb-item active">secteur</li>
                </ol>-->
                <button type="button" class="btn d-none d-lg-block m-l-15 font-light text-white btn-chocolate" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Creer secteur</button>
            <?php
            }
            ?>

<div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lgs">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Creation secteur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">CODE</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="Code_secteur">
                                        <option></option>
                                        <?php
                                            for ($i=1; $i < 11; $i++) 
                                            {
                                        ?> 
                                                <option value="<?=$maxCode+$i?>"><?=$maxCode+$i?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text" class="form-control custom-select" id="nom_secteur">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Adresse</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text" class="form-control" id="adrese_secteur" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Switch IP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="switch_ip">
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white btn-chocolate" onclick="NewSecteur($('#Code_secteur').val(),$('#nom_secteur').val(),$('#adrese_secteur').val(),$('#switch_ip').val())">Ajouter
                </button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>
              
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nom </th>
                                <th>adresse</th>
                                <th>Switch IP</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nom </th>
                                <th>adresse</th>
                                <th>Switch IP</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="reponse"> 
                           
                            <?php
                            $i=0;
                            foreach ($equipement->affichageSecteur() as $data) 
                                {
                                    $i++;
                                  ?>
                                <tr>
                                    <td><?=$data->code.'-'.$data->nom_secteur?></td>
                                    <td><?= $data->adresse_secteur?></td>
                                    <td><?= $data->switch_ip?></td>
                                    <td>
                                        <?php
                                        if ($m) 
                                        {?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                        <?php
                                        }
                                        ?>

<!-- sample modal content -->
<div class="modal fade bs-example-modal-lgs<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lgs">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Modification secteur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">CODE</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="code<?=$i?>">
                                        <option value="<?=$data->code?>"><?=$data->code?></option>
                                        <?php
                                            for ($j=0; $j < 11; $j++) 
                                            {
                                        ?> 
                                                <option value="<?=$maxCode+$j?>"><?=$maxCode+$j?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom*</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control custom-select" id="nom_secteur<?=$i?>" value="<?= $data->nom_secteur?>">
                                    <input type="text" class="form-control custom-select" id="id_secteur<?=$i?>" value="<?= $data->ID_secteur?>" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Adresse*</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="adrese_secteur<?=$i?>" value="<?php echo $data->adresse_secteur?>">
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Switch IP*</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="switch_ip<?=$i?>" value="<?= $data->switch_ip?>">
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-white btn-chocolate" onclick="update_Secteur($('#id_secteur<?=$i?>').val(),$('#code<?=$i?>').val(),$('#nom_secteur<?=$i?>').val(),$('#adrese_secteur<?= $i?>').val(),$('#switch_ip<?=$i?>').val())" data-dismiss="modal">modifier
                </button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
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
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer secteur</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                         </div>
                        <div class="modal-body"> 
                        <!--<input type="text" class="form-control" id="id_secteur<?= $i?>" value="< echo $data->ID_secteur?>" hidden>-->
                        Voulez-vous supprimer ce secteur?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="suppressionSecteur($('#id_secteur<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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