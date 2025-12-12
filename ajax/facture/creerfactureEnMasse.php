<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();

$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
$quantite;
$mois_debut;
$annee;
if ($_GET['type'] == 'un_mois') 
{
	$quantite = 1;
	$mois_debut = $mois[$_GET['mois_debut']];
	$annee = $_GET['annee'];
	while ($mois_val = current($mois)) 
    {
        if ($mois_val == $mois_debut) 
        {
            $cle =  key($mois);
            break;
        }
        next($mois);
    }
}
else
{
	$mois_debut = $mois[$_GET['mois_debut']];
	$quantite = $_GET['mois_fin'] - $_GET['mois_debut'] + 2;
	$annee = $_GET['annee'];
	while ($mois_val = current($mois)) 
    {
        if ($mois_val == $mois_debut) 
        {
            $cle =  key($mois);
            break;
        }
        next($mois);
    }
}
$verifierCreation = false;
foreach ($contract->getDataToPrintOnFactureEnMasse() as $value)
{
	$facture_id = $value->billing_number.'/'.date('Ymd');
	$billing_number = $value->billing_number;
	if ($contract->creeFacture($facture_id,$show_rate=0,$value->monnaie,$tva=0,date('Y-m-d'))) 
	{
		if ($contract->creerFactureService($facture_id,$value->ID_client,$value->ID_service,$value->montant,$rediction=0,$mois_debut,$quantite,$annee,$description='')) 
		{
			$verifierCreation = true;
		}
	}
	foreach ($contract->getClientEnfantToPrintOnFactureEnMasse($billing_number) as $value2) 
	{
		if ($contract->creerFactureService($facture_id,$value2->ID_client,$value2->ID_service,$value2->montant,$rediction=0,$mois_debut,$quantite,$annee,$description='')) 
		{
			$verifierCreation = true;
		}
	}
}
if ($verifierCreation) 
{
	require_once("../../printing/fiches/printMassInvoice.php");
}
