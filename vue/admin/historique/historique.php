<?php
ob_start(); 
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
			<div class="card-header text-white font-bold" style="background-color: #FF8300;padding: 0.1rem"><h4>HISTORIQUE DE <?=strtoupper($type).' # '.$idAction?></h4>
		    </div>
		    <div class="card-body">
		        <div class="table-responsive m-t-0">
		            <table id="example23" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>TYPE</th>
		                        <th>DATE</th>
		                        <th>EFFECTUER PAR</th>
		                        <th>ACTION</th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>TYPE</th>
		                        <th>DATE</th>
		                        <th>EFFECTUER PAR</th>
		                        <th>ACTION</th>
		                    </tr>
		                </tfoot>
		                <tbody>
		                	<?php
		                	foreach ($historique->getHistoriqueAction($type,$idAction) as $value) 
		                	{
	                		?>
		                		<tr>
			                        <td><?=$value->type?></td>
			                        <td><?=$value->dateAction?></td>
			                        <td><?=$value->nom_user?></td>
			                        <td><?=$value->action?></td>
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