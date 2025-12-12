<?php
ob_start();
$date = date_parse(date('Y-m-d'));
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body" id="rep">
                <a href="<?=WEBROOT?>coupure">Retour</a>
                <div class="table-responsive m-t-0">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Montant dù</th>
                                <th>Selectionner</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Client</th>
                                <th>Montant dù</th>
                                <th>Selectionner</th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                        	<?php
                        	$i = 0;
                        	foreach ($contract->liste_Client_A_couper() as $value) 
                        	{
                        		$i++;
                                $solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
                                if ($solde > 0) 
                                {
                    		?>
                        		<tr>
                	                <td><?=$value->nom_client?></td>
                	                <td><?=$solde.'_USD'?></td>
                	                <td>
                	                	<input type="checkbox" id="i<?=$i?>" value="<?=$i?>">
                                        <!--<input type="text" id="facture_id<=$i?>" value="<=$value->facture_id?>" hidden>-->
                                        <input type="text" id="idclient<?=$i?>" value="<?=$value->ID_client?>" hidden>
                                        <input type="text" id="montant<?=$i?>" value="<?=$solde?>" hidden>
                                        <input type="text" id="monnaie<?=$i?>" value="USD" hidden>
                                        <input type="text" id="mois<?=$i?>" value="<?=$date['month']?>" hidden>
                                        <input type="text" id="annee<?=$i?>" value="<?=$date['year']?>" hidden>
                	                </td>
                	            </tr>
                        	<?php
                                }
                        	}
                        	?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="offset-6">
                        <button type="button"  onclick="saveDerogation()"  class="btn btn-success waves-effect text-left text-white" >Valider
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>