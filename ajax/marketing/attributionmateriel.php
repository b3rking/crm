<?php
require_once("../../model/connection.php");
require_once("../../model/marketing.class.php");

$marketing = new Marketing();
//Attribuer_Materiels
if ($marketing->diminuerQuantitemateriel($value->ID_stock,$_GET['idstockmarketing'],$_GET['quantite']))
	//,$_GET['materiel'],$_GET['quantite'],date('Y-m-d'))) 
	//diminuerQuantitemateriel

{
	require_once('repstockmarketing.php');
?>
<div class="alert alert-success">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span>
</button>
<h3 class="text-success"><i class="fa fa-check-circle"></i>Attribution materiel</h3>vous venez d'attribuer le materiel avec succès
</div> 
<?php
}
else
{
?>
<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span>
		</button>
		<h3 class="text-danger"><i class="fa fa-info"></i> l'attribution du materiel a echoue</h3>
		
		</div>
<?php
	}
?>


	