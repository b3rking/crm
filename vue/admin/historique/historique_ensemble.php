<?php
ob_start(); 
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
			<div class="card-header text-white font-bold" style="background-color: #FF8300;padding: 0.1rem"><h4>HISTORIQUE D'ACTION</h4>
		    </div>
		    <div class="card-body">
		    	<div class="form-group">
                    <label class="col-sm-3 form-control-label" for="example-input-small">Small</label>
                    <div class="col-sm-6">
                        <input type="text" id="example-input-small" name="example-input-small" class="form-control form-control-sm" placeholder="form-control-sm">
                    </div>
                </div>
		        <div class="table-responsive m-t-0">
		            <table id="myTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
		                	foreach ($comptabilite->getHistoriqueActions() as $value) 
		                	{
	                		?>
		                		<tr>
			                        <td><?=$value->type?></td>
			                        <td><?=$value->dateAction?></td>
			                        <td><?=$value->effectuerPar?></td>
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