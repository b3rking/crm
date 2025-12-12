<?php
	ob_start();
?>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h6 class="m-b-0">Servise(s) inclus</h6></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Bande passante</th>
                            <th>Montant</th> 
                            <th>Client</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            	foreach ($contract->detailContract($idcontract) as $value) 
                            	{
                    		?>
                				<tr>
                            		<td><?=$value->nomService?></td>
                            		<td><?=$value->bandepassante?></td>
                            		<td><?=$value->montant?></td>
                            		<td><?=$value->nom_client?></td>
                            		<td><?=$value->etat?></td>
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

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>