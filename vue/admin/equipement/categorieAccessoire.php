<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('accessoire',$_SESSION['ID_user'])->fetch()) 
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
                <!--<div id="rep"></div>-->
                <span id="msg"></span>
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <!--h4 class="text-themecolor">Accessoire</h4--><a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>
                        </div>
                        <div class="col-md-7 align-self-center">
                            <div class="d-flex justify-content-end align-items-center">

    <!--<a href="<= WEBROOT;?>attribution_materiel_client" style="background-color: #8b4513" class="btn text-white d-none d-lg-block m-l-15"><i class="fa fa-check"></i>Attribuer accessoire client</a>-->
     
    <?php
    if ($c) 
    {
    ?>
        <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Categorie </button>
    <?php
    }
    ?>
    
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header"><!--la couleur dans l'entete du modal style="background-color: #dc7633"-->
                            <h4 class="modal-title" id="myLargeModalLabel">Creation de la categie d'accessoire</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-0">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 col-md-2 col-lg-2 control-label">Categorie*</label>
                                            <div class="form-group col-sm-9 col-md-10 col-lg-10">
                                                <input type="text" class="form-control  input-filter" id="categorie" placeholder="Nouvelle Categorie">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer" class="modal-header">
                            <button type="button"  class="btn text-white btn-chocolate"   onclick="ajouterCategorieAccessoire($('#categorie').val())"> <i class="fa fa-check"></i> Ajouter</button>
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
                                <th>CATEGORIE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>CATEGORIE</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                            $i=0;
                            foreach ($equipement->getCategorieAccessoires() as $value)
                            {
                                $i++;
                            ?>
                            <tr>
                                <td><?= $value->categorie?></td>
                                <td class="text-nowrap">
                                    <?php
                                    if ($m) 
                                    {?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                    <!-- sample modal content -->
                                    <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Modifier categorie</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal p-t-20">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                    <div class="form-group row">
                                                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Categorie </label>
                                                                    <div class="col-sm-9">
                                                                        <div class="form-group">
                                                                            <input type="text" class="form-control" name="categorie" id="categorie<?=$i?>" value="<?=$value->categorie?>">
                                                                            <input type="text" name="categorie" id="categorie_id<?=$i?>" value="<?=$value->categorie_id?>" hidden>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- END ROW-->
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" data-dismiss="modal" class="btn btn-chocolate text-white" onclick="update_categorie_accessoire($('#categorie_id<?=$i?>').val(),$('#categorie<?=$i?>').val())"> <i class="fa fa-check"></i> Modifier accessoire</button>
                                                    <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->

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
                                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer accessoire</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body"> 
                                                    <input type="text" class="form-control" id="idaccessoire<?= $i?>" value="<?php echo $value->ID_accessoire?>"hidden >
                                                    Voulez-vous supprimer cet accessoire?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteCategorieAccessoire($('#categorie_id<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                                                </div>
                                            </div>
                                            <!--/.modal-content -->
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