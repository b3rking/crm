<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('radio',$_SESSION['ID_user'])->fetch()) 
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body" >
                <div id="rep"></div> 
                <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Radio</h4>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <?php
            if ($c) 
            {?>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Radio</li>
                </ol>
                <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15 " data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>ajout radio </button>
            <?php
            }
            ?>

<div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lgs">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">ajout radio</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row" hidden>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Type equipement</label>
                                <div class="col-sm-9">
                                    <!--<select id="type_equipement" class="form-control" >
                                        <option value="radio">radio M2</option>
                                        <option value="radio">radio M3</option>
                                        <option value="radio">radio M5</option>
                                    </select>-->
                                    <input class="form-control" id="type_equipement" value="radio" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Model</label>
                                <div class="col-sm-9">
                                    <input type="text" id="model" class="form-control" placeholder="Model">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Mac adresse</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="example : 00:2C:AD:AF:EB:06" id="mac">
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Fabriquant</label>
                                <div class="col-sm-9">
                                    <input type="text" id="fabriquant" class="form-control" placeholder="fabriquant">
                                    <input type="text" id="number" value="0" hidden="hidden">
                                    <input type="text" id="user" value="<?=$_SESSION['ID_user']?>" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date ajout*</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="date_ajout" value="<?=date('Y-d-m')?>">
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Description*</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-chocolate text-white" data-dismiss="modal" onclick="ajouterStock($('#model').val(),$('#model').val(),$('#fabriquant').val(),$('#type_equipement').val(),$('#mac').val(),$('#user').val(),$('#date_ajout').val(),$('#description').val())"> <i class="fa fa-check"></i> Ajouter routeur</button>
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
              
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>DATE AOUT</th>
                                <th>FABRIQUANT</th>
                                <th>MODEL</th>
                                <th>ADRESSE MAC</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>DATE AOUT</th>
                                <th>FABRIQUANT</th>
                                <th>MODEL</th>
                                <th>ADRESSE MAC</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="retourjs">
                              <?php 
                              $i =0;
                              foreach($equipement->recupereRadio() as $value)
                    {
                        $i++;
                    ?>
                        <tr>
                            <td><?=$value->date_stock?></td>
                            <td><?php echo $value->fabriquant?> </td>
                            <td><?php echo $value->model?></td>
                            <td>
                                <?php
                                    foreach ($equipement->recupereMacAdresses($value->ID_equipement) as $mac) 
                                    {
                                        echo "$mac->mac <br>";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($m) 
                                {?>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
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
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Fabriquant </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span>
                                        </div>
                                        <input type="text" id="id<?=$i?>" value="<?php echo $value->ID_equipement?>" class="form-control"hidden >
                                        <input type="text" id="type_equipement<?=$i?>" value="<?php echo $value->type_equipement?>" class="form-control" hidden>
                                        <input type="text" id="fabriquant<?=$i?>" class="form-control" value="<?php echo $value->fabriquant?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Model*</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text" id="model<?=$i?>" value="<?php echo $value->model?>" class="form-control" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW--> 
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Date*</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="date" id="date_stock<?=$i?>" value="<?=$value->date_stock?>" class="form-control" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW--> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" style="background-color: #7c4a2f" class="btn text-white" data-dismiss="modal" onclick="updateRadio($('#id<?=$i?>').val(),$('#type_equipement<?=$i?>').val(),$('#model<?=$i?>').val(),$('#fabriquant<?=$i?>').val(),$('#date_stock<?=$i?>').val())"> <i class="fa fa-check"></i>
                 Modifier radio
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer radio M2</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="idequipement<?=$i?>" value="<?php echo $value->ID_equipement?>" hidden>
                Voulez-vous supprimer cette radio M2?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerRadio($('#idequipement<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i>
                </button>
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