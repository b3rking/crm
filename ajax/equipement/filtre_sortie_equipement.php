 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/equipement.class.php");
	//require_once("../../model/comptabilite.class.php");  

	$equipement = new Equipement();

	$l = $_GET['l'];
	$c = $_GET['c'];
	$m = $_GET['m'];
	$s = $_GET['s'];
	
	$i =0;
    foreach($equipement->filterSortieEquipements($_GET['condition']) as $value)
    {
        $i++;
    ?>
	    <tr>
		    <td><?= $value->date_sortie?></td>
		    <td><?= $value->model?></td>
		    <td><?= $value->motif?></td>
		    <td><?= $value->destination_detail?>
		    </td>
		    <td><?=$value->sortie_par?></td>
		    <td><?= $value->demander_par?></td>  
		    <td class="text-nowrap">
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
			                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer antenne</h4>
			                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			                </div>
			                <div class="modal-body"> 
			                <input type="text" class="form-control" id="idSortie<?=$i?>" value="<?=$value->ID_sortie?>" hidden>
			                <input type="text" class="form-control" id="idequipement<?=$i?>" value="<?=$value->ID_equipement?>" hidden>
			                Voulez-vous supprimer cette sortie?
			                </div>
			                <div class="modal-footer">
			                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="delete_Sortie_equipement($('#idSortie<?=$i?>').val(),$('#idequipement<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
			                </div>
			            </div>
			            <!-- /.modal-content -->
			        </div>
			        <!-- /.modal-dialog -->
			    </div>
			</td>
		</tr>
<?php
    }
?>
