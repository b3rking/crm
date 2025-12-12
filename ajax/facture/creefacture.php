<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/historique.class.php");  
require_once("../../model/client.class.php");  


$historique = new Historique();
$contract = new Contract();
$client = new Client();
/*$startDate = null;
$endDate = null;
$quantite;
$montant;
$prixRediction;
$montant_total;
$mois_debut = '';
$mois_fin = '';
$annee_debut = 0;
$annee_fin = 0;
$nextMoth = '';
$nextYear = '';*/

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
$mois_etiquete = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
$english_months = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];

//if (empty($contract->getMoisFactureDunClient($_GET['client_parent'],$mois_debut,$_GET['annee'])->fetch()['ID_client'])) 
//{
$mois_debut_f = ($_GET['mois'] < 10 ? '0'.$_GET['mois'] : $_GET['mois']);
$billing_date = ($_GET['mois'] < 10 ? $_GET['annee'].'-0'.$_GET['mois'].'-01' : $_GET['annee'].'-'.$_GET['mois'].'-01');
$etat_facture = 'actif';
$tvci = $_GET['tva'];
$endDate = null;

//$periode = [1 => 'mensuel',3 => 'trimestriel',6 => 'semestriel',12 => 'annuel'];
//$english_period = [1 => 'monthly',3 => 'quarterly',6 => 'half-yearly',12 => 'annualy'];

if ($billing_date > date('Y-m-1')) 
{
	$etat_facture = 'attante';
	//$tvci = 18;
}

if ($_GET['test_billing_cycle'] == 1) 
	$numero = $_GET['billing_number'].'/'.$_GET['annee'].$mois_debut_f.'01';
else
{
	$numero = $_GET['billing_number'].'/'.$_GET['annee'].$mois_debut_f.'02';
	$etat_facture = 'actif';
}

$langue = $client->afficherUnClentAvecContract($_GET['client_parent'])->fetch()['langue'];

if ($contract->creeFacture($numero,$_GET['client_parent'],$_GET['show_rate'],$_GET['enable_discount'],0,$_GET['monnaie'],0,$tvci,$_GET['datefacture'],$_GET['taux'],$_GET['exchange_currency'],$_GET['fixe_rate'],$nextMoth=0,$nextYear=0,$billing_date,$etat_facture,$creation_mode="manuel")) 
{
	$facture_services = rtrim($_GET['facture_services'],'=');
	$facture_services = preg_split("#[=]+#", trim($facture_services));
	for ($i=0; $i < count(($facture_services)); $i++) 
	{ 
		$facture_service_detail = preg_split("#[_]+#", trim($facture_services[$i]));

		$serviceId = $facture_service_detail[0];
		$serviceName = $facture_service_detail[1];
		$bandeP = ($facture_service_detail[2] == 'null' ? '' : $facture_service_detail[2]);
		$montant = $facture_service_detail[3];
		$quantite = $facture_service_detail[4];
		//$reduction = $facture_service_detail[5];
		$startDate = ($facture_service_detail[5] == 'null' ? null : $facture_service_detail[5]);
		//$endDate = ($facture_service_detail[6] == 'null' ? null : $facture_service_detail[6]);
		$description = $facture_service_detail[6];
		$billing_cycle = $facture_service_detail[7];
        $reduction = $facture_service_detail[8] == '' ? 0 : $facture_service_detail[8];
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
			}*/
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
			//$next_billing_date = ($nextMoth < 10 ? $nextYear.'-0'.$nextMoth.'-01' : $nextYear.'-'.$nextMoth.'-01');
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
		elseif($billing_cycle == 0)
		{
		 	/*$date = date_parse($endDate);
		    $mois_fin = $date['month'];
		    $annee_fin = $date['year'];*/

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
		 	/*if ($mois_fin == 12) 
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
		else
		{
			$totalHTVA = $montant * $quantite;
			$montant_tva = $totalHTVA/100*0;
			$montant_tvci = $totalHTVA/100*$tvci;
			$montant_total_avant_reduction = $totalHTVA + $montant_tva + $montant_tvci;
			$prixRediction = $montant_total_avant_reduction/100*$reduction;
			$montant_total = $montant_total_avant_reduction - $prixRediction;
            $ott = 0;
			if ($description == 'null') 
			{
				$description = $serviceName;
			}
			$mois_debut = $_GET['mois'];
			$annee_debut = $_GET['annee'];
			$mois_fin = $_GET['mois'];
		    $annee_fin = $_GET['annee'];
		}
		if ($description == 'null') 
		{
			$description= $langue == 'anglais' ? 'subscription;' : 'Abonnement;';
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

		$facture_id = $contract->getFactureId_par_IdClient($_GET['client_parent'])->fetch()['facture_id'];

		if ($contract->creerFactureService($facture_id,$serviceId,$bandeP,$montant,$montant_total_avant_reduction,$montant_total,$montant_tva,$montant_tvci,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$startDate,$endDate,$billing_cycle,$reduction,$ott)) 
		{
			if ($billing_date >= $_GET['next_billing_date'])
			{
				if ($_GET['test_billing_cycle'] == 1) 
				{
					if ($billing_cycle == 1) 
					{
						if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
						{}
						if ($contract->update_Facture_next_billing_date($facture_id,$next_billing_date) > 0) 
						{}
					}
				}
				else
				{
					if ($billing_cycle == 0) 
					{
						if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
						{}
						if ($contract->update_Facture_next_billing_date($facture_id,$next_billing_date) > 0) 
						{}
					}
				}
			}
			
			/*if ($_GET['nombreService'] > 1) 
			{
				if ($billing_cycle == 1) 
				{
					if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
					{
						/*$y = 0;
						for ($i=0; $i < $quantite; $i++) 
						{ 
							$mois = $mois_debut+$i;
							if ($mois <= 12) 
							{
								if (empty($contract->getMoisFactureDunClient($_GET['client_parent'],$mois,$annee_debut)->fetch()['ID_client'])) 
								{
									$contract->setMoisFactureDunClient($_GET['client_parent'],$mois,$annee_debut,$facture_id);
								}
							}
							else
							{
								$y++;
								$mois = $y;
								if (empty($contract->getMoisFactureDunClient($_GET['client_parent'],$mois,$annee_fin)->fetch()['ID_client'])) 
								{
									$contract->setMoisFactureDunClient($_GET['client_parent'],$mois,$annee_fin,$facture_id);
								}
							}
						}*
					}
				}
			}
			else
			{
				if ($contract->updateNext_billing_date($_GET['idcontract'],$next_billing_date) > 0) 
				{
					/if (empty($contract->getMoisFactureDunClient($_GET['client_parent'],$mois_debut,$annee_debut)->fetch()['ID_client'])) 
					{
						$contract->setMoisFactureDunClient($_GET['client_parent'],$mois_debut,$annee_debut,$facture_id);
					}*
				}
			}*/
		}
	}
	if ($etat_facture == 'actif') 
	{
		$taux = 1765;
        //$taux = 2000;
		$facture_bif = 0;
		$paiement_bif = 0;
        foreach ($contract->getSommeTotaleFactureDunClient($_GET['client_parent']) as $value2) 
        {
            $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
            $facture_bif += (strtolower($value2->monnaie) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
            $facture_bif += $value2->ott;
        }
        foreach ($contract->getSommeTotalePayementDunClient($_GET['client_parent']) as $value2) 
        {
            $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
            $paiement_bif += (strtolower($value2->exchange_currency) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
        }
//		foreach ($contract->getSommeTotaleFactureDunClient($_GET['client_parent']) as $value) 
//		{
//			$facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
//		}
//		foreach ($contract->getSommeTotalePayementDunClient($_GET['client_parent']) as $value) 
//		{
//			$paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
//		}
		//$balanceInitiale = ($contract->getBalanceInitiale($_GET['client_parent'])->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($_GET['client_parent'])->fetch()['montant']);
		$balanceInitiale = ($contract->getBalanceInitiale($_GET['client_parent'])->fetch() ? $contract->getBalanceInitiale($_GET['client_parent'])->fetch() : 0);
		$balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
		$solde = $facture_bif + $balanceInitiale - $paiement_bif;
		$client->updateSoldeClient($_GET['client_parent'],$solde);
	}

	if ($historique->setHistoriqueAction($facture_id,'facture',$_GET['iduser'],$created_at,'creer')) 
	{
		//echo "ok";
	}
}


