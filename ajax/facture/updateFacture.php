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
/*$facture_services = rtrim($_GET['facture_services'],'/');
$facture_services = preg_split("#[/]+#", trim($facture_services));
$facture_service_detail = preg_split("#[-]+#", trim($facture_services[0]));
die(print_r($facture_service_detail));*/

$endDate = null;
$mois_etiquete = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
$english_months = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];

$mois_debut_f = ($_GET['mois'] < 10 ? '0'.$_GET['mois'] : $_GET['mois']);
$numero = $_GET['billing_number'].'/'.$_GET['annee'].$mois_debut_f.'01';

$billing_date = ($_GET['mois'] < 10 ? $_GET['annee'].'-0'.$_GET['mois'].'-01' : $_GET['annee'].'-'.$_GET['mois'].'-01');
$etat_facture = 'actif';
$tvci = $_GET['tva'];
if ($billing_date > date('Y-m-1')) 
{
	$etat_facture = 'attante';
	//$tvci = 18;
}

$max_billing_date = $contract->get_Max_Billing_date_Dun_client($_GET['idclient']);

$langue = $client->afficherUnClentAvecContract($_GET['idclient'])->fetch()['langue'];
//echo $langue;
//die();

if ($contract->updateFacture($_GET['facture_id'],$numero,$_GET['afficheTaux'],$_GET['enable_discount'],0,$_GET['monnaie'],0,$tvci,$_GET['datefacture'],$_GET['taux'],$_GET['fixe_rate'],$_GET['exchange_currency'],$nextMoth=0,$nextYear=0,$billing_date,$etat_facture) > 0) 
{
	$facture_services = rtrim($_GET['facture_services'],'=');
	$facture_services = preg_split("#[=]+#", trim($facture_services));
	for ($i=0; $i < count(($facture_services)); $i++) 
	{
		$facture_service_detail = preg_split("#[_]+#", trim($facture_services[$i]));

		$service = $facture_service_detail[0];
		$idFs = $facture_service_detail[1];
		$montant = $facture_service_detail[2];
		$quantite = $facture_service_detail[3];
		//$reduction = $facture_service_detail[4];
		$bandeP = ($facture_service_detail[4] == 'null' ? '' : $facture_service_detail[4]);
		$description = htmlspecialchars($facture_service_detail[5]);
		//echo $description;
		//die();
		$billing_cycle = $facture_service_detail[6];
		$startDate = ($facture_service_detail[7] == 'null' ? null : $facture_service_detail[7]);
		//$endDate = ($facture_service_detail[8] == 'null' ? null : $facture_service_detail[8]);
		$serviceName = $facture_service_detail[8];
        $reduction = $facture_service_detail[9];
		//$destroy = $facture_service_detail[10];
		if ($billing_cycle == 1) 
		{
			/*$rep = 12 - $_GET['mois'] + 1;
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
			$next_billing_date = ($nextMoth < 10 ? $nextYear.'-0'.$nextMoth.'-01' : $nextYear.'-'.$nextMoth.'-01');*/
			$mois_debut = $_GET['mois'];
			$annee_debut = $_GET['annee'];
			$interval = $quantite-1;
			$date = new DateTime($annee_debut.'-'.$mois_debut.'-01');
			$date->add(new DateInterval('P'.$interval.'M'));
			$mois_fin = intval($date->format('m'));
			$annee_fin = $date->format('Y');

			$date = new DateTime($annee_fin.'-'.$mois_fin.'-01');
			$date->add(new DateInterval('P1M'));
			$next_billing_date = $date->format('Y-m-d');

			//$prixRediction = $_GET['montant']/100*$_GET['reduction'];
			$totalHTVA = $montant * $quantite;
			$montant_tva = $totalHTVA/100*0;
			$montant_tvci = $totalHTVA/100*$tvci;
			$montant_total_avant_reduction = $totalHTVA + $montant_tva + $montant_tvci;
			$prixRediction = $montant_total_avant_reduction/100*$reduction;
			$montant_total = $montant_total_avant_reduction - $prixRediction;
            $ott = 0;
            if($billing_date >= '2023-09-01')
            {
                if(strtolower($_GET['exchange_currency']) == 'bif')
                    $ott = 100000 * $quantite;
            }
		}
        elseif($billing_cycle == 2)
		{
			$mois_debut = $_GET['mois'];
			$mois_fin = $_GET['mois'];
			$annee_debut = $_GET['annee'];
			$annee_fin = $_GET['annee'];
			if ($description == 'null') 
			{
				$description = $serviceName;
			}

			$totalHTVA = $montant * $quantite;
			$montant_tva = $totalHTVA/100*0;
			$montant_tvci = $totalHTVA/100*$tvci;
			$montant_total_avant_reduction = $totalHTVA + $montant_tva + $montant_tvci;
			$prixRediction = $montant_total_avant_reduction/100*$reduction;
			$montant_total = $montant_total_avant_reduction - $prixRediction;
            $ott = 0;
		}
		else
		{
		 	/*$date = date_parse($endDate);
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
			$next_billing_date = ($nextMoth < 10 ? $nextYear.'-0'.$nextMoth.'-01' : $nextYear.'-'.$nextMoth.'-01');*/
			$interval = $quantite-1;
			$date = new DateTime($startDate);
            $mois_debut = intval($date->format('m'));
			$annee_debut = $date->format('Y');
			$date->add(new DateInterval('P'.$interval.'D'));
			$mois_fin = intval($date->format('m'));
			$annee_fin = $date->format('Y');
			$endDate = $date->format('Y-m-d');

			$date = new DateTime($endDate);
			$date->add(new DateInterval('P1M'));
			$next_billing_date = $date->format('Y-m-d');
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
			$montant_tvci = $montant/100*$tvci;
			$montant_total_avant_reduction = $montant + $montant_tva + $montant_tvci;
			$montant_total = $montant_total_avant_reduction; //* $quantite;
            $ott = 0;

			/*$date = date_parse($startDate);
			$mois_debut = $date['month'];
			$annee_debut = $date['year'];*/
			if ($description == 'null') 
			{
                $description = $langue == 'anglais' ? 'daily subscription;from '.$startDate.' to '.$endDate.';'.$serviceName.';'.$bandeP : 'Abonnement journalier;Du '.$startDate.' au '.$endDate.';'.$serviceName.';'.$bandeP;
			}
		}
		if ($description == 'null') 
		{
            $description= $langue == 'anglais' ? 'monthly subscription;' : 'Abonnement mensuel;';
			if ($quantite > 1) 
			{
				if ($annee_debut == $annee_fin) 
				{
					$description .= $langue == 'anglais' ? iconv('UTF-8', 'windows-1252',ucfirst($english_months[$mois_debut]).' to '.ucfirst($english_months[$mois_fin]).' '.$annee_debut) : iconv('UTF-8', 'windows-1252', 'mois de '.ucfirst($mois_etiquete[$mois_debut]).' a '.ucfirst($mois_etiquete[$mois_fin]).' '.$annee_debut);
				}
				else
				{
					$description .= $langue == 'anglais' ? iconv('UTF-8', 'windows-1252',ucfirst($english_months[$mois_debut]).' '.$annee_debut.' to '.ucfirst($english_months[$mois_fin]).' '.$annee_fin) : iconv('UTF-8', 'windows-1252', 'mois de '.ucfirst($mois_etiquete[$mois_debut]).' '.$annee_debut.' au '.ucfirst($mois_etiquete[$mois_fin]).' '.$annee_fin);
				}
			}
			else
			{
				$description .= $langue == 'anglais' ? ucfirst($english_months[$mois_debut]).' '.$annee_debut : 'mois de '.ucfirst($mois_etiquete[$mois_debut]).' '.$annee_debut;
			}
			$description .= ';'.$serviceName.";".$bandeP;
		}

		if ($idFs == "null") 
		{
			if ($contract->creerFactureService($_GET['facture_id'],$service,$bandeP,$montant,$montant_total_avant_reduction,$montant_total,$montant_tva,$montant_tvci,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$startDate,$endDate,$billing_cycle,$reduction,$ott)) 
			{
				if ($max_billing_date == $_GET['billing_date']) 
				{
					if ($_GET['test_billing_cycle'] == 1) 
					{
						if ($billing_cycle == 1) 
						{
							if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
							{}
							if ($contract->update_Facture_next_billing_date($_GET['facture_id'],$next_billing_date) > 0) 
							{}
						}
					}
					else
					{
						if ($billing_cycle == 0) 
						{
							if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
							{}
							if ($contract->update_Facture_next_billing_date($_GET['facture_id'],$next_billing_date) > 0) 
							{}
						}
					}
				}
			}
		}
		else
		{
			if ($contract->updateFactureService($idFs,$service,$bandeP,$_GET['idclient'],$montant,$montant_total_avant_reduction,$montant_total,$montant_tva,$montant_tvci,$startDate,$endDate,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$billing_cycle,$reduction,$ott) > 0) 
			{
				if ($max_billing_date == $_GET['billing_date']) 
				{
					if ($_GET['test_billing_cycle'] == 1) 
					{
						if ($billing_cycle == 1) 
						{
							if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
							{}
							if ($contract->update_Facture_next_billing_date($_GET['facture_id'],$next_billing_date) > 0) 
							{}
						}
					}
					else
					{
						if ($billing_cycle == 0) 
						{
							if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
							{}
							if ($contract->update_Facture_next_billing_date($_GET['facture_id'],$next_billing_date) > 0) 
							{}
						}
					}
					/*if ($_GET['nombreService'] > 1) 
					{
						if ($billing_cycle == 1) 
						{
							if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
							{
								
							}
						}
					}
					else
					{
						if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
						{
							//echo " next_billing_date : ".$next_billing_date;
						}
					}*/
				}
			}
		}
	}
	$taux = 1765;
    //$taux = 2000;
	$facture_bif = 0;
	$paiement_bif = 0;
    foreach ($contract->getSommeTotaleFactureDunClient($_GET['idclient']) as $value2) 
    {
        $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
        $facture_bif += (strtolower($value2->monnaie) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
        $facture_bif += $value2->ott;
    }
    foreach ($contract->getSommeTotalePayementDunClient($_GET['idclient']) as $value2) 
    {
        $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
        $paiement_bif += (strtolower($value2->exchange_currency) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
    }
//	foreach ($contract->getSommeTotaleFactureDunClient($_GET['idclient']) as $value) 
//	{
//		$facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
//	}
//	foreach ($contract->getSommeTotalePayementDunClient($_GET['idclient']) as $value) 
//	{
//		$paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
//	}
	//$balanceInitiale = ($contract->getBalanceInitiale($_GET['idclient'])->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($_GET['idclient'])->fetch()['montant']);

	$balanceInitiale = ($contract->getBalanceInitiale($_GET['idclient'])->fetch() ? $contract->getBalanceInitiale($_GET['idclient'])->fetch() : 0);
	$balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
	
	$solde = $facture_bif + $balanceInitiale - $paiement_bif;
	$client->updateSoldeClient($_GET['idclient'],$solde);

	if ($historique->setHistoriqueAction($_GET['facture_id'],'facture',$_GET['iduser'],$created_at,'modifier')) 
	{
		//echo "ok";
	}
}