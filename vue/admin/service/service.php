<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('service',$_SESSION['ID_user'])->fetch()) 
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
<script type="text/javascript">
    var msg = 'Ici il y a les info concernant les types des clients';
</script>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>"hidden>

<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Service</h4>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <?php
            if ($c) 
            {?>
                <button type="button" class="btn btn-success d-none d-lg-block m-l-15" data-toggle="modal" data-target="#add-contact"><i class="fa fa-plus-circle"></i> Creer service</button>
            <?php
            }
            ?>
<!-- Modal -->
<div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Nouveau Service</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                 <form>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                              <label for="exampleInputuname3" class="col-sm-3 control-label">Nom service</label>
                              <div class="col-sm-9"> 
                                <input type="text" class="form-control" id="nom">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant</label>
                                <div class="col-sm-9"> 
                               
                                <input type="text" class="form-control" id="montant">
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Monnaie</label>
                                <div class="col-sm-9"> 
                                <select id="monnaie" class="form-control">
                                     <option value="FC">FC</option>
                                    <option value="USD" selected="">USD</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="col-md-12 m-b-20">
                    <input type="text" class="form-control" placeholder="Description" id="description">
             <input type="text" id="user_service" value="<?=$_SESSION['userName']?>"hidden> </div>
        
                </form>
   
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" onclick="ajouterService($('#nom').val(),$('#montant').val(),$('#monnaie').val(),$('#description').val(),$('#user_service').val())">Ajouter</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->
        </div>
    </div>
</div>

                <div class="table-responsive m-t-0">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Montant</th>
                                <th>Monnaie</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nom</th>
                                <th>Montant</th>
                                <th>Monnaie</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                            $i = 0;
                            foreach ($service->recupererServices() as $value) : $i++; ?>
                            <tr>
                                <td><?= $value->nomService?></td>
                                <td><?= $value->montant?></td>
                                <td><?= $value->monnaie?></td>
                                <td><?= $value->description?></td>
                                <td class="text-nowrap">
                                    <?php
                                    if ($m) 
                                    {?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#add-contact<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <?php
                                    }
                                    ?>
<!-- sample modal content -->
<div id="add-contact<?=$i?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Modifier Service</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <from class="form-horizontal form-material">
                    <div class="form-group">
                        <div class="col-md-12 m-b-20">
                            <input type="text" id="idservice<?= $i?>" value="<?= $value->ID_service?>" hidden>
                            <input type="text" class="form-control" placeholder="Non de service" id="nom<?= $i?>" value="<?= $value->nomService?>"> </div>
                        <div class="col-md-12 m-b-20">
                            <input type="number" class="form-control" placeholder="Montant par defaut" id="montant<?= $i?>" value="<?= $value->montant?>">
                        </div>
                        <div class="col-md-12 m-b-20">
                            <select id="monnaie<?= $i?>" class="form-control">
                                <?php
                                if ($value->monnaie == 'bif') 
                                {
                                ?>
                                    <option value="BIF">BIF</option>
                                    <option value="USD">USD</option>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <option value="USD">USD</option>
                                    <option value="FC">FC</option>
                                <?php
                                }
                                ?>                              
                            </select>
                        </div>
                        <div class="col-md-12 m-b-20">
                            <input type="text" class="form-control" placeholder="Description" id="description<?= $i?>" value="<?= $value->description?>">
                            <input type="text" id="mod_service" value="<?=$_SESSION['userName']?>"hidden> 
                        </div>
                    </div>
                </from>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" onclick="updateService($('#idservice<?= $i?>').val(),$('#nom<?= $i?>').val(),$('#montant<?= $i?>').val(),$('#monnaie<?= $i?>').val(),$('#description<?= $i?>').val(),$('#mod_service').val())" data-dismiss="modal">Modifier</button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->

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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer Service</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="idservice<?= $i?>" value="<?php echo $value->ID_service?>" hidden>
                <input type="text" id="dropservice" value="<?=$_SESSION['userName']?>"hidden> 
                Voulez-vous supprimer ce service?<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteService($('#idservice<?= $i?>').val(),$('#dropservice').val())" data-dismiss="modal">Supprimer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
                                </td>
                            </tr>
                        <?php endforeach?>
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