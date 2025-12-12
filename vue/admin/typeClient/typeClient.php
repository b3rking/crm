<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('typeclient',$_SESSION['ID_user'])->fetch()) 
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
<input type="text" id="userName" value="<?=$_SESSION['userName']?>"hidden>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
                <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor"></h4>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <?php
            if ($c) 
            {?>
                <button type="button" style="background-color: #8b4513" class="btn  d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target="#responsive-modal"><i class="fa fa-plus-circle"></i> Ajouter type</button>
            <?php
            }
            ?>

            <!-- sample modal content -->
            <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Nouveau type</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-xlg-3">
                                            <label for="recipient-name" class="control-label">Entreer type:</label>
                                        </div>
                                        <div class="col-md-6 col-xlg-6 col-lg-6">
                                            <input type="text" class="form-control" id="type">
                                        </div>
                                    </div>                                   
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            
                            <button style="background-color: #8b4513" type="button" class="btn waves-effect waves-light font-light text-white" onclick="ajouterTypeClient($('#type').val())">Ajouter</button>
                            <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal -->
        </div>
    </div>
</div>
		        <div class="table-responsive m-t-0">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>Type</th>
		                        <th>Action</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>Type</th>
		                        <th>Action</th>
		                    </tr>
		                </tfoot>
		                <tbody id="rep">
		                	<?php
		                	$i = 0;
		                	foreach ($type->recupererTypes() as $value) : $i++; ?>
		                    <tr>
		                        <td><?= $value->libelle?></td>
		                        <td class="text-nowrap">
		                        	<?php
                                    if ($m) 
                                    {?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm-<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <?php
                                    }
                                    ?>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-sm-<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Modifier Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
            	<input type="text" class="form-control" id="idtype<?= $i?>" value="<?php echo $value->ID_type?>" hidden>

            	<input type="text" id="type<?= $i?>" class="form-control" value="<?=$value->libelle?>">          	
            </div>
            <div class="modal-footer">
                <button type="button" style="background-color: #8b4513" class="btn waves-effect waves-light font-light text-white" onclick="updateType($('#idtype<?= $i?>').val(),$('#type<?= $i?>').val())" data-dismiss="modal">Modifier</button>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
            	<input type="text" class="form-control" id="idtype<?= $i?>" value="<?php echo $value->ID_type?>" hidden>
            	Voulez-vous supprimer ce type?<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteType($('#idtype<?= $i?>').val())" data-dismiss="modal">Supprimer</button>
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