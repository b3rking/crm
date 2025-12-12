<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();
$tbMonnaie = ['USD','BIF'];
$montant_facture_USD = 0;
$montant_facture_monnaie_locale = 0;
foreach ($contract->getfacture_total_dun_mois($_GET['mois'],$_GET['annee']) as $value) 
{
    if ($value->monnaie == 'USD') 
    {
        $montant_facture_USD = $value->montant+$value->montant_tva;
        //$monnaie_facture_USD = $value->monnaie;
    }
    else
    {
        $montant_facture_monnaie_locale += $value->montant+$value->montant_tva;
        //$monnaie_facture_locale = $value->monnaie;
    }
}

if ($_GET['status'] == 'paying') 
{
    $montant_facture_payee_USD = 0;
    $montant_facture_payee_monnaie_locale = 0;
    foreach ($contract->getmontant_facture_payee_dun_mois($_GET['mois'],$_GET['annee']) as $value) 
    {
        if ($value->devise == 'USD') 
        {
            $montant_facture_payee_USD += $value->montant;
        }
        else
        {
            $montant_facture_payee_monnaie_locale += $value->montant;
        }
    }
?>
	<div class="row">
	    <div class="col-lg-4 col-md-6">
	        <div class="card">
	            <div class="d-flex flex-row">
	                <div class="align-self-center m-l-20 bg-info text-white">
	                    <h3 class="m-b-0">
	                	<?php
	                	echo 'Total = '.round($montant_facture_USD).'_'.$tbMonnaie[0].' '.round($montant_facture_monnaie_locale).'_'.$tbMonnaie[1];
	                	?>
	                </h3>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="col-lg-6 col-md-6">
	        <div class="card">
	            <div class="d-flex flex-row">
	                <div class="align-self-center m-l-20 bg-success text-white">
	                	<h3 class="m-b-0">
	                	<?php
	                	echo 'Payee = '.round($montant_facture_payee_USD).'_'.$tbMonnaie[0].' '.round($montant_facture_payee_monnaie_locale).'_'.$tbMonnaie[1];
	                	?>
	                </h3>
	                </div>
	            </div>
	        </div>
	    </div>
    </div>
<?php
}
elseif ($_GET['status'] == 'impayer') 
{
	$montant_facture_impayee_USD = 0;
    $montant_facture_impayee_monnaie_locale = 0;
    foreach ($contract->getmontant_facture_impayee_dun_mois($_GET['mois'],$_GET['annee']) as $value) 
    {
        if ($value->monnaie == 'USD') 
        {
            $montant_facture_impayee_USD = $value->montant_total-$value->reste;
        }
        else
        {
            $montant_facture_impayee_monnaie_locale += $value->montant_total-$value->reste;
        }
    }
?>
	<div class="row">
	    <div class="col-lg-4 col-md-6">
	        <div class="card">
	            <div class="d-flex flex-row">
	                <div class="align-self-center m-l-20 bg-info text-white">
	                    <h3 class="m-b-0">
	                	<?php
	                	echo 'Total = '.round($montant_facture_USD).'_'.$tbMonnaie[0].' '.round($montant_facture_monnaie_locale).'_'.$tbMonnaie[1];
	                	?>
	                </h3>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="col-lg-6 col-md-6">
	        <div class="card">
	            <div class="d-flex flex-row">
	                <div class="align-self-center m-l-20 bg-danger text-white">
	                	<h3 class="m-b-0">
	                	<?php
	                	echo 'Impayé = '.round($montant_facture_impayee_USD).'_'.$tbMonnaie[0].' '.round($montant_facture_impayee_monnaie_locale).'_'.$tbMonnaie[1];
	                	?>
	                </h3>
	                </div>
	            </div>
	        </div>
	    </div>
    </div>
<?php
}