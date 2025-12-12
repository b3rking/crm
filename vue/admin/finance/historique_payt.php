<?php
ob_start();

?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <!--h2 class="text-themecolor">Historique paiement</h2-->
    </div>
           </div>
		        <!--h4 class="card-title">Data Export</h4>
		        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6-->

		        <div class="table-responsive m-t-40">
		            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		            	<input type="text" name="" value="">
		                <thead>
		                    <tr>
		                        <th>facture</th>
		                        <th>type</th>
		                        <th>date modif</th>
		                        <th>utilisateur</th>
		                        <th>detail</th>
		                        
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>facture</th>
		                        <th>type</th>
		                        <th>date modif</th>
		                        <th>utilisateur</th>
		                        <th>detail</th>
		                        
		                    </tr>
		                </tfoot>
		                <tbody>
		                	<input type="text" id="session_user" value="<?=$_SESSION['ID_user']?>" hidden>

		                	<?php
		              foreach ($comptabilite->get_historique_Payements($idpayement,$_SESSION['ID_user']) as $data)
					   {
                        $i++;
							?>
					    <tr>
							<td><?php echo $data->facture_id?></td>
	                        <td>paiement</td>
							<td><?php echo $data->datepaiement?></td>
							<td><?php echo $data->nom_user.' '.$value->prenom?></td>
							<td><?php echo $data->reference?></td>
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