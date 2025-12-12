<?php
ob_start();
$date = date_parse(date('Y-m-d'));
$mois = $date['month'];
$annee = $date['year'];
$mois_etiquete = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
$tbMonnaie = ['USD','BIF'];
?>

<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		        <div class="table-responsive m-t-0">
		            <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
		                <thead>
		                    <tr>
		                        <th>DATE</th>
		                        <th>FACTURATION</th>
		                        <th>DELINQUENT</th>
		                        <th>FACTURE PAYEE</th>
		                        <th>MONTANT A COLLECTER</th>
		                        <th></th>
		                    </tr>
		                </thead>
		                <tfoot>
		                    <tr>
		                        <th>DATE</th>
		                        <th>FACTURATION</th>
		                        <th>DELINQUENT</th>
		                        <th>FACTURE PAYEE</th>
		                        <th>MONTANT A COLLECTER</th>
		                        <th></th>
		                    </tr>
		                </tfoot>
		                <tbody>
		                	<?php
		                	foreach ($result as $value) 
		                	{
		                	?>
			                	<tr>
			                        <td><?=$value->created_at?></td>
			                        <td><?=$value->invoices_amount?></td>
			                        <td><?=$value->delinquent?></td>
			                        <td><?=$value->paid_amount?></td>
			                        <td><?=$value->remains_to_be_collected?></td>
			                        <td><a href="<?=WEBROOT;?>printInvoiceMonthlyCollected-<?= $value->id;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a></td>
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