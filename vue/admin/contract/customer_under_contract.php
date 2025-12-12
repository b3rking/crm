<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('client_sous_contrat',$_SESSION['ID_user'])->fetch()) 
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
<input type="text" id="webroot" value="<?=WEBROOT?>" hidden>
<input type="text" id="root" value="<?=ROOT?>" hidden>
<input type="text" id="idUser"  value="<?= $_SESSION['ID_user']?>" hidden>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <?php
        if (isset($_SESSION['message']) && !empty($_SESSION['message'])) 
        {
        ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> <?=$_SESSION['message']?></h3>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <?php
            if ($c) 
            {
            ?>
                <button type="button" class="btn btn-chocolate d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-activeclient-modal-lgs"><i class="fa fa-check-circle"></i> Ajouter client au contrat</button>
            <?php
            }
            ?>

            <div class="modal fade bs-activeclient-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lgs">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Ajout de client à un contract</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-0">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <label for="exampleInputEmail3" class="control-label">Client Parent* </label>
                                        <div class="form-group">
                                            <input type="text" id="seachCustomerToActivate" class="form-control form-control-sm input-filter" onkeyup="filter('parent_customer',this.value)" autocomplete="off" placeholder=" -- filtrer ici--">
                                            <select id="parent_customer" class="form-control input-filter" size="3">
                                                <?php
                                                    foreach ($customer_parents as $value) 
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
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <label for="exampleInputEmail3" class="control-label">Client Enfant* </label>
                                        <div class="form-group">
                                            <input type="text" id="seachCustomerToActivate" class="form-control form-control-sm input-filter" onkeyup="filter('children_customers',this.value)" autocomplete="off" placeholder=" -- filtrer ici--">
                                            <select id="children_customers" class="form-control input-filter" size="3">
                                                <?php
                                                    foreach ($children_to_assign as $value) 
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
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button"  onclick="addChildCustomerToParent($('#parent_customer').val(),$('#children_customers').val())"  class="btn btn-chocolate waves-effect text-left text-white" >Ajouter
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./modal -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <form action="<?=WEBROOT?>filtreCustomerChild" method="get" id="filtreCustomerChild">
                    <div class="row">
                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                            <input type="text" name="billing_number" id="billing_number_filtre" class="form-control form-control-sm input-filter" placeholder="billing number">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <input type="text" name="name" id="nom_client" class="form-control form-control-sm input-filter" placeholder="Nom client">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <button type="submit" class="btn btn-chocolate btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <button type="button" class="btn btn-sm  btn-dark"onclick="resetFiltreCustomerUnderContract()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Client Enfant</th>
                                <th>Client Parent</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Client Enfant</th>
                                <th>Client Parent</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <tr>
                                <?php
                                foreach ($children_customers as $value) 
                                {
                                ?>
                                    <tr>
                                        <td><?=$value->child_name?></td>
                                        <td><?=$value->parent_name?></td>
                                        <td class="text-nowrap">
                                            <!--<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>-->

                                            <?php
                                            if ($s) 
                                            {
                                            ?>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-activeclient-modal-lgs<?=$value->child_id?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                                            <?php
                                            }
                                            ?>
                                            <div class="modal fade bs-activeclient-modal-lgs<?=$value->child_id?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-lgs">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myLargeModalLabel">Suppression de client à un contract</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Voulez-vous effectuer cette operation
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"  onclick="deleteChildCustomerToParent('<?=$value->child_id?>')"  class="btn btn-chocolate waves-effect text-left text-white" >Valider
                                                            </button>
                                                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ./modal -->
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$_SESSION['message'] = "";
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>