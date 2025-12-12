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

$nb_facture = $contract->get_nombre_proformat_dans_une_annee($_GET['annee']) + 2;
$numero = 'SC-'.$nb_facture.$_GET['mois'].'-'.$_GET['annee'];
$billing_date = $_GET['annee'].'-'.$_GET['mois'].'-01';

//$IdClient;
if(!empty($_GET['old_client']))
{
	$IdClient = $_GET['old_client'];
}
else
{
	if ($data = $client->recupererDernierClient()->fetch()) 
	{
	    $IdClient = $data['ID_client'] + 1;
	}

	if ($client->saveclient($IdClient,strtoupper($_GET['nomclient']),$_GET['phone'],"",$_GET['mailclient'],strtoupper($_GET['adresse']),$description='',$pers_cont='',$type='potentiel',$_GET['datefacture'],$_GET['localisation'],$langue='francais',$nif='','non',$etat='N/A',null,$genre='personnel')) 
	{
	}//END IF SAVE CLIENT REUSSI 
}

$tvci = $_GET['tva'];

if ($contract->creerProformat($numero,$IdClient,$_GET['show_rate'],$_GET['enable_discount'],$_GET['reduction'],$_GET['monnaie'],0,$tvci,$_GET['datefacture'],$_GET['taux'],$_GET['exchange_currency'],$_GET['fixe_rate'],$nextMoth=0,$nextYear=0,$billing_date)) 
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
		$endDate = ($facture_service_detail[6] == 'null' ? null : $facture_service_detail[6]);
		$description = $facture_service_detail[7];
		$billing_cycle = $facture_service_detail[8];
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
			$next_billing_date = ($nextMoth < 10 ? $nextYear.'-0'.$nextMoth.'-01' : $nextYear.'-'.$nextMoth.'-01');
			$totalHTVA = $montant * $quantite;
			$montant_tva = $totalHTVA/100*0;
            $montant_tvci = $totalHTVA/100*$tvci;
			$montant_total_avant_reduction = $totalHTVA + $montant_tva + $montant_tvci;
			$prixRediction = $montant_total_avant_reduction/100*$_GET['reduction'];
			$montant_total = $montant_total_avant_reduction - $prixRediction;
			if ($description == 'null') 
			{
				//$description = 'Abonnement journalier Du '.$startDate.' au '.$endDate;
				$description='Abonnement mensuel '.$serviceName.' '.$bandeP;
				//$description .= ' '.$serviceName.' '.$bandeP;
			}

		}
		elseif($billing_cycle == 0)
		{
//		 	$date = date_parse($endDate);
//		    $mois_fin = $date['month'];
//		    $annee_fin = $date['year'];
            
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
            
			/*$date = date_parse($startDate);
			$mois_debut = $date['month'];
			$annee_debut = $date['year'];*/
			if ($description == 'null') 
			{
				//$description = 'Abonnement journalier Du '.$startDate.' au '.$endDate;
				$description = 'Abonnement journalier;'.$serviceName.''.$bandeP;
				//$description .= ' '.$serviceName.' '.$bandeP;
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
				//$description = 'Abonnement journalier Du '.$startDate.' au '.$endDate;
				$description = 'Abonnement '.$serviceName.' '.$bandeP;
				//$description .= ' '.$serviceName.' '.$bandeP;
			}
		}
		/*if ($description == 'null') 
		{
			$description='Abonnement mensuel '.$serviceName.' '.$bandeP;
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
			}*
			//$description .= ' '.$serviceName.' '.$bandeP;
		}*/

		$facture_id = $contract->getProformatId_par_numero($numero)->fetch()['facture_id'];
		if ($contract->creerProformatService($facture_id,$serviceId,$bandeP,$montant,$montant_total,$montant_tva,$montant_tvci,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$startDate,$endDate,$billing_cycle)) 
		{
		}
	}
    if ($historique->setHistoriqueAction($facture_id,'proformat',$_GET['iduser'],$created_at,'creer')) 
	{
		//echo "ok";
	}
}


