<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");

//date_creation="+date_creation+"&monnaie="+monnaie+"&mois="+mois+"&annee="+annee+"&tva="+tva+"&service="+service+"&montant="+montantConverti+"&quantite="+quantite+"&description="+description+"&billing_cycle="+billing_cycle+"&i="+i+"&nombreService="+nombreService+"&taux="+taux+"&show_rate="+show_rate+"&startDate="+startDate+"&endDate="+endDate+"&old_client="+old_client+"&nomclient="+nomclient+"&phone="+phone+"&mailclient="+mailclient+"&adresse="+adresse

$contract = new Contract();
$client = new Client();
$IdClient;
if(!empty($_GET['old_client']))
{
	$IdClient = $_GET['old_client'];
	$dateformat = preg_split("#[-]+#", $_GET['date_creation']);
	$facture_id = $_GET['old_client'].'_'.$_GET['annee'].$_GET['mois'].'1';
}
else
{
	if ($data = $client->recupererDernierClient()->fetch()) 
	{
	    $IdClient = $data['ID_client'] + 1;
	}
	if ($client->saveclient($IdClient,strtoupper($_GET['nomclient']),$_GET['phone'],$_GET['mailclient'],$_GET['adresse'],$description='',$pers_cont='',$type='potentiel',$_GET['date_creation'],$_GET['localisation'],$langue='',$nif='',$_GET['tva'])) 
	{
	   $dateformat = preg_split("#[-]+#", $_GET['date_creation']);
		$facture_id = $IdClient.'_'.$_GET['annee'].$_GET['mois'].'1';
	}//END IF SAVE CLIENT REUSSI 
}

$startDate = null;
$endDate = null;
$quantite;
$montant;
$prixRediction;
$montant_total;
$mois_debut = '';
$mois_fin = '';
$annee_debut = 0;
$annee_fin = 0;
$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
if ($_GET['billing_cycle'] == 0) 
{
 	$startDate = $_GET['startDate'];
 	$endDate = $_GET['endDate'];
 	$date1 = strtotime($startDate);
	$date2 = strtotime($endDate);
	$quantite = ceil(abs($date2 - $date1) / 86400)+1;
	//$prixRediction = $_GET['montant']/100*$_GET['reduction'];
	$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $_GET['mois'], $_GET['annee']);
	//$montant = $_GET['montant'] - $prixRediction;
	$montant = $_GET['montant']/$nombre_jour;
	$montant_total = $montant * $quantite;
	$dateformat = preg_split("#[-]+#", $startDate);
	//$facture_id = $_GET['old_client'].'_'.$dateformat[0].$dateformat[1].$dateformat[2];
	$mois_debut = $_GET['mois'];
	$annee_debut = $_GET['annee'];
	$description = $_GET['description'];
	if (empty($description)) 
	{
		$description = 'Abonnement journalier Du '.$startDate.' au '.$endDate;
	}

	if ($contract->creerProformat($facture_id,$_GET['monnaie'],$_GET['tva'],$_GET['taux'],$_GET['date_creation'])) 
	{
		if ($contract->creerProformatService($facture_id,$IdClient,$_GET['service'],$_GET['bandeP'],$montant,$montant_total,$startDate,$endDate,$mois_debut,$mois_fin='',$quantite,$annee_debut,$annee_fin=$annee_debut,$description,$_GET['billing_cycle'])) 
		{
			echo "ok";
		}
	}
}
else
{
	$rep = 12 - $_GET['mois'] + 1;
	$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
	$res = $_GET['quantite'] - $rep;
	if ($res < 0 ) 
	{
		$mois_debut = $_GET['mois'];
		//$mois_fin = $res + 12;
		$mois_fin = $res + 12;
		$annee_debut = $_GET['annee'];
		$annee_fin = $_GET['annee'];
	}
	elseif ($res == 0) 
	{
		$mois_debut = $_GET['mois'];
		$mois_fin = 12;
		$annee_debut = $_GET['annee'];
		$annee_fin = $_GET['annee'];
	}
	else
	{
		$mois_debut = $_GET['mois'];
		$mois_fin = $res;
		$annee_debut = $_GET['annee'];
		$annee_fin = $_GET['annee'] +1;
	}
	$quantite = $_GET['quantite'];
	//$prixRediction = $_GET['montant']/100*$_GET['reduction'];
	$montant = $_GET['montant'];
	$montant_total = $montant * $_GET['quantite'];

	$description = $_GET['description'];
	if (empty($description)) 
	{
		$description='Abonnement mensuel ';
		if ($quantite > 1) 
		{
			if ($annee_debut == $annee_fin) 
			{
				$description .=iconv('UTF-8', 'windows-1252', 'mois de '.ucfirst($mois[$mois_debut]).' à '.ucfirst($mois[$mois_fin]).' '.$annee_debut);
			}
			else
			{
				$description .=iconv('UTF-8', 'windows-1252', 'mois de '.ucfirst($mois[$mois_debut]).' '.$annee_debut.' au '.ucfirst($mois[$mois_fin]).' '.$annee_fin);
			}
		}
		else
		{
			$description .='mois de '.ucfirst($mois[$mois_debut]).' '.$annee_debut;
		}
	}
	if ($_GET['nombreService'] > 1) 
	{
		$i =(int) $_GET['i'];
		if ($i == 0) 
		{
			if ($contract->creerProformat($facture_id,$_GET['monnaie'],$_GET['tva'],$_GET['taux'],$_GET['date_creation'])) 
			{
				if ($contract->creerProformatService($facture_id,$IdClient,$_GET['service'],$_GET['bandeP'],$montant,$montant_total,$startDate,$endDate,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin=$annee_debut,$description,$_GET['billing_cycle'])) 
				{
				}
			}
		}
		else
		{
			if ($contract->creerProformatService($facture_id,$IdClient,$_GET['service'],$_GET['bandeP'],$montant,$montant_total,$startDate,$endDate,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin=$annee_debut,$description,$_GET['billing_cycle'])) 
			{
				//require_once("rep.php");
			}
		}
	}
	else
	{
		if ($contract->creerProformat($facture_id,$_GET['monnaie'],$_GET['tva'],$_GET['taux'],$_GET['date_creation'])) 
		{
			if ($contract->creerProformatService($facture_id,$IdClient,$_GET['service'],$_GET['bandeP'],$montant,$montant_total,$startDate,$endDate,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin=$annee_debut,$description,$_GET['billing_cycle'])) 
			{
				//require_once("rep.php");
			}
		}
	}
}
