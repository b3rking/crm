<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/historique.class.php");
require_once("../../model/client.class.php");  

$historique = new Historique();
$contract = new Contract();
$client = new Client();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
/*$facture_services = rtrim($_GET['facture_services'],'_');
$facture_services = preg_split("#[_]+#", trim($facture_services));
$facture_service_detail = preg_split("#[-]+#", trim($facture_services[0]));
die(print_r($facture_service_detail));*/

$mois_debut;
$mois_fin;
$annee_debut;
$annee_fin;
//$nb_facture = $contract->get_nombre_proformat_dans_une_anne($annee);
$mois_etiquete = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
//$mois_debut_f = ($_GET['mois'] < 10 ? '0'.$_GET['mois'] : $_GET['mois']);
//$numero = $_GET['billing_number'].'_'.$_GET['annee'].$mois_debut_f.'01';

$billing_date = ($_GET['mois'] < 10 ? $_GET['annee'].'-0'.$_GET['mois'].'-01' : $_GET['annee'].'-'.$_GET['mois'].'-01');

$tvci = 18;

if ($contract->updateProformat($_GET['facture_id'],$_GET['afficheTaux'],$_GET['enable_discount'],$_GET['reduction'],$_GET['monnaie'],0,$tvci,$_GET['datefacture'],$_GET['taux'],$_GET['fixe_rate'],$_GET['exchange_currency'],$nextMoth=0,$nextYear=0,$billing_date) > 0) 
{
	$facture_services = rtrim($_GET['facture_services'],'=');
	$facture_services = preg_split("#[=]+#", trim($facture_services));
	for ($i=0; $i < count(($facture_services)); $i++) 
	{
		$facture_service_detail = preg_split("#[_]+#", trim($facture_services[$i]));

		$serviceId = $facture_service_detail[0];
		$idFs = $facture_service_detail[1];
		$montant = $facture_service_detail[2];
		$quantite = $facture_service_detail[3];
		//$reduction = $facture_service_detail[4];
		$bandeP = ($facture_service_detail[4] == 'null' ? '' : $facture_service_detail[4]);
		$description = $facture_service_detail[5];
		$billing_cycle = $facture_service_detail[6];
		$startDate = ($facture_service_detail[7] == 'null' ? null : $facture_service_detail[7]);
		$endDate = ($facture_service_detail[8] == 'null' ? null : $facture_service_detail[8]);
		$serviceName = $facture_service_detail[9];
		if ($billing_cycle == 1) 
		{
			$rep = 12 - $_GET['mois'] + 1;
			$res = $quantite - $rep;
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
			if ($mois_fin == 12) 
			{
				$nextMoth = 1;
				$nextYear = $annee_fin+1;
			}
			else
			{
				$nextMoth = $mois_fin+1;
				$nextYear = $annee_fin;
			}
			//$next_billing_date = ($nextMoth < 10 ? $nextYear.'-0'.$nextMoth.'-01' : $nextYear.'-'.$nextMoth.'-01');
			//$prixRediction = $_GET['montant']/100*$_GET['reduction'];
			$totalHTVA = $montant * $quantite;
			$montant_tva = $totalHTVA/100*0;
            $montant_tvci = $totalHTVA/100*$tvci;
			$montant_total_avant_reduction = $totalHTVA + $montant_tva + $montant_tvci;
			$prixRediction = $montant_total_avant_reduction/100*$_GET['reduction'];
			$montant_total = $montant_total_avant_reduction - $prixRediction;
		}
		elseif($billing_cycle == 0)
		{
		 	$date = date_parse($endDate);
		    $mois_fin = $date['month'];
		    $annee_fin = $date['year'];
		 	if ($mois_fin == 12) 
			{
				$nextMoth = 1;
				$nextYear = $annee_fin+1;
			}
			else
			{
				$nextMoth = $mois_fin+1;
				$nextYear = $annee_fin;
			}
			//$next_billing_date = ($nextMoth < 10 ? $nextYear.'-0'.$nextMoth.'-01' : $nextYear.'-'.$nextMoth.'-01');
		 	/*if ($quantite == '') 
		 	{
		 		$date1 = strtotime($startDate);
				$date2 = strtotime($endDate);
				$quantite = ceil(abs($date2 - $date1) / 86400)+1;
		 	}
		 	else $quantite = $_GET['quantite'];*/
			//$prixRediction = $montant/100*$reduction;
			//$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $_GET['mois'], $_GET['annee']);
			$montant = $montant; //- $prixRediction;
			//$montant = $montant/$nombre_jour;
			$montant_tva = $montant/100*0;
            $montant_tvci = $totalHTVA/100*$tvci;
			$montant_total_avant_reduction = $montant + $montant_tva + $montant_tvci;
			$montant_total = $montant_total_avant_reduction; //* $quantite;

			$date = date_parse($startDate);
			$mois_debut = $date['month'];
			$annee_debut = $date['year'];
			if ($description == 'null') 
			{
				$description = 'Abonnement journalier Du '.$startDate.' au '.$endDate;
				$description .= ' '.$serviceName;
			}
		}
		else
		{
			$montant = $montant; //- $prixRediction;
			//$montant = $montant/$nombre_jour;
			$totalHTVA = $montant * $quantite;
			$montant_tva = $totalHTVA/100*0;
            $montant_tvci = $totalHTVA/100*$tvci;
			$montant_total_avant_reduction = $totalHTVA + $montant_tva + $montant_tvci;
			$montant_total = $montant_total_avant_reduction; //* $quantite;
			
			$mois_debut = $_GET['mois'];
			$mois_fin = $mois_debut;
			$annee_debut = $_GET['annee'];
			$annee_fin = $_GET['annee'];
			if ($description == 'null') 
			{
				$description = $serviceName;
			}
		}
		if ($description == 'null') 
		{
			$description='Abonnement mensuel ';
			if ($quantite > 1) 
			{
				if ($annee_debut == $annee_fin) 
				{
					$description .=iconv('UTF-8', 'windows-1252', 'mois de '.ucfirst($mois_etiquete[$mois_debut]).' a '.ucfirst($mois_etiquete[$mois_fin]).' '.$annee_debut);
				}
				else
				{
					$description .=iconv('UTF-8', 'windows-1252', 'mois de '.ucfirst($mois_etiquete[$mois_debut]).'/'.$annee_debut.' au '.ucfirst($mois_etiquete[$mois_fin]).'/'.$annee_fin);
				}
			}
			else
			{
				$description .='mois de '.ucfirst($mois_etiquete[$mois_debut]).'/'.$annee_debut;
			}
			$description .= ' '.$serviceName;
		}
		//echo 'idFs: '.$idFs.' bandeP: '.$bandeP.' montant: '.$montant.'montant_total: '.$montant_total.' montant_tva: '.$montant_tva.' startDate: '.$startDate.' endDate: '.$endDate.' mois_debut: '.$mois_debut.' mois_fin: '.$mois_fin.' quantite: '.$quantite.' annee_debut: '.$annee_debut.' annee_fin: '.$annee_fin.' description: '.$description.' billing_cycle: '.$billing_cycle;
		if ($idFs == "null") 
		{
			if ($contract->creerProformatService($_GET['facture_id'],$serviceId,$bandeP,$montant,$montant_total,$montant_tva,$montant_tvci,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$startDate,$endDate,$billing_cycle)) 
			{
			}
		}
		else
		{
			if ($contract->updateProformatService($idFs,$serviceId,$bandeP,$montant,$montant_total,$montant_tva,$montant_tvci,$startDate,$endDate,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$billing_cycle) > 0) 
			{
				if ($client->updateClietFromProformat($_GET['idclient'],strtoupper($_GET['nomclient']),$_GET['telephone'],$_GET['mail'],$_GET['adresse'],$_GET['localisation']) > 0) 
				{
					// code...
				}
			}
		}
	}
	if ($historique->setHistoriqueAction($_GET['facture_id'],'proformat',$_GET['iduser'],$created_at,'modifier')) 
	{
		//echo "ok";
	}
}