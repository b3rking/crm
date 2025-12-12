<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('localisation',$_SESSION['ID_user'])->fetch()) 
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

            <input type="text" id="userName" value="<?=$_SESSION['userName']?>"hidden>
                <div class="row page-titles">
                        <div class="col-md-5 align-self-center" >
                            <h4 class="text-themecolor"></h4>
                        </div>
                        <div class="col-md-7 align-self-center">
                            <div class="d-flex justify-content-end align-items-center">

                               <button type="button" style="background-color: #8b4513"class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>ajouter Localisation
                               </button>
                                <!--<button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Importer companie</button>-->
                                <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Nouvelle localisation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="exampleInputuname3" class="col-sm-3 control-label">Location*</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-map-marker"></i></span></div>
                                                       <input type="text" maxlength="10" class="form-control" id="locationS" placeholder="Province   ou    ville  ">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- END ROW-->
                                    <div class="form-group row m-b-0">
                                        <div class="offset-sm-2 col-sm-6 col-lg-6 col-md-6">
                                        </div>
                                    </div><!-- END ROW-->
                </form>
            </div>
             <div class="modal-footer">
                <button style="background-color: #8b4513" class="btn  waves-effect text-left font-light text-white" onclick="NouvelleLocalisation($('#locationS').val())" data-dismiss="modal"><i class="fa fa-check"></i>Ajouter localisation
                                </button>
                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
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
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Localisation</th>
                                <th>Nombre de client</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Numero</th>
                                <th>Materiel</th> 
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                                $i = 0;
                                   foreach ($localisation->nombreClientParLocalisation() as $value) 
                                           {
                                            $i++;
                                            $Nombreclient[] = $value;
                                            ?>
                                    <td><?php echo $value->nom_localisation?></td>
                                    <td><?php echo $value->nb?></td>

                                <td class="text-nowrap">
                                     <?php
                                if ($m) 
                                        {
                                            ?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                     <?php
                        }
                        ?>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier cette localisation</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                               <form class="form-horizontal p-t-20">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Materiel</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="idlocalisation<?=$i?>" value="<?php echo $value->ID_localisation?>"hidden>
                                                    <input type="text" class="form-control" id="locationS<?=$i?>" value="<?php echo $value->nom_localisation?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div><!-- END ROW-->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #8b4513" class="btn  waves-effect text-left font-light text-white" onclick="Updatelocalisation($('#idlocalisation<?= $i?>').val(),$('#locationS<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>modifier cette localisation
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
             <?php
                        if ($s) 
                        {
                            ?>
            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
             <?php
         }
         ?>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette localisation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="idlocalisation<?= $i?>" value="<?php echo $data->ID_localisation?>" hidden>
                            Voulez-vous supprimer cette localisation?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletelocalisation($('#idlocalisation<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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
/*$home_commercial_content = ob_get_clean();
require_once('vue/admin/home.commercial.php');*/
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>