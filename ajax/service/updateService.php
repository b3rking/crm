<?php
require_once("../../model/connection.php");
require_once("../../model/service.class.php");

require_once("../../model/comptabilite.class.php");

$service = new Service();
$comptabilite = new Comptabilite();

if ($service->updateService($_GET['idservice'],$_GET['nom'],$_GET['montant'],$_GET['monnaie'],$_GET['description']) > 0) 
{

     if ($comptabilite->setHistoriqueAction($_GET['idservice'],'service',$_GET['userName'],date('Y-m-d'),'modifier')) 
    {
    
	$i = 0;
	foreach ($service->recupererServices() as $value) 
	{
		$i++; ?>
    <tr>
        <td><?= $value->nomService?></td>
        <td><?= $value->montant?></td>
        <td><?= $value->monnaie?></td>
        <td><?= $value->description?></td>
        <td class="text-nowrap">
        	<a href="javascript:void(0)" data-toggle="modal" data-target="#add-contact<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
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
        if ($value->monnaie == 'FC') 
        {
        ?>
                                <option value="FC">FC</option>
                                <option value="USD">USD</option>
        <?php
        }
        else
        {
        ?>
        <option value="FC">FC</option>
        <option value="USD">USD</option>
        <?php
        }
        ?>                              
    </select>
</div>
<div class="col-md-12 m-b-20">
    <input type="text" class="form-control" placeholder="Description" id="description<?= $i?>" value="<?= $value->description?>">
</div>
</div>
</from>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-info waves-effect" onclick="updateService($('#idservice<?= $i?>').val(),$('#nom<?= $i?>').val(),$('#montant<?= $i?>').val(),$('#monnaie<?= $i?>').val(),$('#description<?= $i?>').val())" data-dismiss="modal">Modifier</button>
<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Fermer</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div><!-- /.modal -->

<a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

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
Voulez-vous supprimer ce service?<br>
</div>
<div class="modal-footer">
<button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteService($('#idservice<?= $i?>').val())" data-dismiss="modal">Supprimer</button>
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
	}// END FOREACH
}
}
else echo "Insertion echoue";
?>