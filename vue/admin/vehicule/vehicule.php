<?php
ob_start();

$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('vehicule',$_SESSION['ID_user'])->fetch()) 
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
		    	<div id="rep"></div>
    	<div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">vehicule</h4>
            </div>
            <div class="col-md-7 align-self-center">
                <div class="d-flex justify-content-end align-items-center">
                    <?php
                    if ($c) 
                    {?>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">gestion vehicule</a></li>
                            <li class="breadcrumb-item active">vehicule</li>
                        </ol>
                       
                        <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i>Ajouter vehicule</button>
                    <?php
                    }
                    ?>
                    <!-- sample modal content -->
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">Nouveau vehicule</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal p-t-20">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Plaque</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="icon-feed"></i></span></div><input type="text" class="form-control" id="plaque" >
                                                                       
                                                         </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">modeles</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                            <input type="text" class="form-control" id="modele" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                           <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Marque</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                            <input type="text" class="form-control" id="marque" >
                                                            <input type="text" id="nom_user" value="<?=$_SESSION['userName']?>"hidden>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- END ROW-->
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button style="background-color: #8b4513" class="btn waves-effect text-left font-light text-white" onclick="ajouterVehicule($('#plaque').val(),$('#modele').val(),$('#marque').val(),$('#nom_user').val())" data-dismiss="modal"><i class="fa fa-check"></i>Ajouter vehicule
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
		        <!--<h4 class="card-title">Data Export</h4>
		        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
		        <div class="table-responsive m-t-0">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Plaque d'immatriculation</th>
                                <th>Modele</th>
                                <th>Marque</th>
		                        <th></th>
                                <th></th>
		                    </tr>
		                </thead>
		                <tfoot>
				            <tr>
					            <th>Plaque d'immatriculation</th>
                                <th>Modele</th>
                                <th>Marque</th>
                                <th></th>
                                <th></th>
				            </tr>
				        </tfoot>
	                    <tbody id="reponse">
                            <?php 
                            $i =0;
                            foreach ($vehicule->afficheVehicule() as  $value)
                            {
                               $i++; ?>
                            <tr>
                                <td><?php echo $value->immatriculation?></td>
                                <td><?php echo $value->modele?></td>
                                <td><?php echo $value->marque?></td>
                                <td>
                                    <?php
                                    if ($m) 
                                    {?>
                                        <button type="button" class="btn waves-effect waves-light btn-xs btn-success" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>">Edit
                                    </button>
                                    <?php
                                    }
                                    ?>
          <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">modifier vehicule</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">plaque</label>
                                            <div class="form-group col-sm-9">
                                                <input type="text" class="form-control" id="newplaque<?=$i?>" value="<?php echo $value->immatriculation?>">
                                                <input type="text" class="form-control" id="plaque<?=$i?>" value="<?php echo $value->immatriculation?>"hidden>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Modele</label>
                                            <div class="form-group col-sm-9">
                                                <input type="text" class="form-control" id="modele<?=$i?>" value="<?php echo $value->modele?>">
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Marque</label>
                                            <div class="form-group col-sm-9">
                                                <input type="text" class="form-control" id="marque<?=$i?>" value="<?php echo $value->marque?>">
                                                <input type="text" id="nom_user" value="<?=$_SESSION['userName']?>"hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End row-->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #8b4513" class="btn  waves-effect text-left font-light text-white" onclick="updateVehicule($('#plaque<?=$i?>').val(),$('#newplaque<?=$i?>').val(),$('#modele<?=$i?>').val(),$('#marque<?=$i?>').val(),$('#nom_user').val())" data-dismiss="modal"><i class="fa fa-check"></i>modifier vehicule
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </td>
        <td>
            <?php
            if ($s) 
            {?>
                <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>">Del</button>
            <?php
            }
            ?>
            
                <!-- sample modal content -->
            <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer vehicule</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="idservice<?= $i?>" value="<?php echo $value->ID_service?>" hidden>
                            <input type="text" id="suprimeur" value="<?=$_SESSION['userName']?>"hidden>

                            Voulez-vous supprimer ce vehicule?<br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteVehicule($('#plaque<?=$i?>').val(),$('#suprimeur').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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
