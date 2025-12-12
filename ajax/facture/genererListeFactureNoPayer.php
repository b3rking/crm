<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();

//$date = date_parse($_GET['dateGenerer']);
//$jour = $date['day'];
$mois_indice = $_GET['mois'];
$annee = $_GET['annee'];
$mois_tb = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
$mois = $mois_tb[$mois_indice];

?>
<div class="table-responsive m-t-0">
    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Client</th>
                <th>Montant dù</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Client</th>
                <th>Montant dù</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
        	<?php
        	$i = 0;
        	foreach ($contract->genererListeFactureNoPayer($mois,$annee) as $value) 
        	{
        		$i++;
    		?>
        		<tr>
	                <td><?=$value->nom_client?></td>
	                <td><?=$value->montant?></td>
	                <td>
	                	<button type="button" class="btn text-white waves-effect text-left" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" style="background-color: chocolate"><i class="ti-pencil"></i>
                		</button>

<div class="modal fade bs-example-modal-lgs<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lgs">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: chocolate">
                <h4 class="modal-title" id="myLargeModalLabel">Action à faire</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Action </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                    	<select class="form-control" id="action<?=$i?>">
                                    		<option value="couper">
                                    			couper
                                    		</option>
                                    		<option value="recouvrer">
                                    			recouvrer
                                    		</option>
                                    	</select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Observation </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <textarea class="form-control" id="observation<?=$i?>"></textarea>

                                        <input type="text" id="idclient<?=$i?>" value="<?=$value->ID_client?>" hidden>
                                        <input type="text" id="montant<?=$i?>" value="<?=$value->montant?>" hidden>
                                        <input type="text" id="monnaie<?=$i?>" value="<?=$value->monnaie?>" hidden>
                                        <input type="text" id="mois<?=$i?>" value="<?=$mois?>" hidden>
                                        <input type="text" id="annee<?=$i?>" value="<?=$annee?>" hidden>
                                        <input type="text" id="i<?=$i?>" value="<?=$i?>" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="text" id="idUser<?=$i?>" value="<?=$_GET['idUser']?>" hidden>
            	</form>
            </div>
            <div class="modal-footer">
            	<span id="msg<?=$i?>"></span>
                <button type="button"  onclick="saveCoupure($('#action<?=$i?>').val(),$('#observation<?=$i?>').val(),$('#idclient<?=$i?>').val(),$('#montant<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#mois<?=$i?>').val(),$('#annee<?=$i?>').val(),$('#i<?=$i?>').val(),$('#idUser<?=$i?>').val())"  class="btn waves-effect text-left text-white" style="background-color: chocolate">Enregistrer
                </button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

                		<button type="button"  onclick="genererListeFactureNoPayer($('#dateGenerer').val())"  class="btn text-white waves-effect text-left" style="background-color: chocolate"><i class="ti-trash"></i>
                		</button>
	                </td>
	            </tr>
        	<?php
        	}
        	?>
        </tbody>
    </table>
</div>