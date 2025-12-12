<?php
require_once("../../model/connection.php");
require_once("../../model/typeClient.class.php");
require_once("../../model/comptabilite.class.php");

$type = new TypeClient();
$comptabilite = new Comptabilite();

if ($type->updateType($_GET['idtype'],$_GET['type']) > 0) 
{
    $idAction = $type->getMaxIdType()->fetch()['ID_type'];
     if ($comptabilite->setHistoriqueAction($idAction,'type_client',$_GET['userName'],date('Y-m-d'),'modifier')) 
    {
	$i = 0;
	foreach ($type->recupererTypes() as $value)
	{
	 $i++; ?>
    <tr>
        <td><?= $value->libelle?></td>
        <td class="text-nowrap">
        	<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm-<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
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
<button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="updateType($('#idtype<?= $i?>').val(),$('#type<?= $i?>').val())" data-dismiss="modal">Modifier</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

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
<?php
	}
}
}