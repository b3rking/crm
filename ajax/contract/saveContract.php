<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");
require_once("../../model/service.class.php");
require_once("../../model/User.class.php");
require_once("../../model/historique.class.php"); 

$historique = new Historique();
$contract = new Contract();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
//$idclient = preg_split("#[-]+#", $_GET['client']);

//$service = new Service();
//$user = new User();
//$tauxData = $user->getTaux()->fetch();
//$taux = $tauxData['taux'];
/*$serviceData = $service->recupererService($_GET['service'])->fetch();
$montant = $serviceData['montant'];
$monnaieService = $serviceData['monnaie'];
$montantConverti = 0;
if ($monnaieService != $_GET['monnaie']) 
{
	if ($monnaieService == 'USD') 
	{
		$montantConverti = $montant*$taux;
	}
	elseif ($monnaieService == 'BIF') 
	{
		$montantConverti = $montant/$taux;
	}
}
else
{
	$montantConverti = $montant;
}
$prixrediction = $montantConverti/100*$_GET['rediction'];
$montantConverti -= $prixrediction;*/

//$montantConverti += $prixTva;

$numero = ($contract->recupererMaxNumeroContract()->fetch()['numero'] == '' ? 1 : $contract->recupererMaxNumeroContract()->fetch()['numero'] +1);
$contract_services = rtrim($_GET['contract_services'],'}');
$contract_services = preg_split("#[}]+#", trim($contract_services));

//if ($data = $contract->recupererMaxNumeroContract()->fetch()) 
//{
	if ($contract->saveContract($numero,$_GET['idclient'],$_GET['typecontract'],$_GET['monnaie_facture'],$_GET['monnaie_contract'],$_GET['tva'],$_GET['mode'],date('Y-m-d'),$_GET['etat'],$_GET['startDate'],$_GET['facturation'],$_GET['show_rate'],$_GET['enable_discount'])) 
	{
		$idcontract = $contract->getIdContract_par_numero($numero)->fetch()['ID_contract'];
		for ($i=0; $i < count(($contract_services)); $i++) 
		{ 
			$contract_service_detail = preg_split("#[_]+#", trim($contract_services[$i]));

			$service_id = $contract_service_detail[0];
			$bandepassante = ($contract_service_detail[1] == 'null' ? '' : $contract_service_detail[1]);
			$montant = $contract_service_detail[2];
			$quantite = $contract_service_detail[3];
			$nom_client = ($contract_service_detail[4] == 'null' ? '' : $contract_service_detail[4]);
			$adresse = ($contract_service_detail[5] == 'null' ? '' : $contract_service_detail[5]);
			$show_on_invoice = $contract_service_detail[6];
			$service_status = $contract_service_detail[7];

			$prixTva = $montant/100*$_GET['tva'];

			if ($contract->saveServiceInclu($idcontract,$service_id,$bandepassante,$montant,$_GET['idclient'],$prixTva,$quantite,$nom_client,$adresse,$show_on_invoice,$service_status)) 
			{
				
			}
		}
		
		$client = new Client();
        $old_billing_number = $client->afficherUnClentSansContract($_GET['idclient'])->fetch()['billing_number'];
        
		$current_billing_number = $client->recupereDernierBillingNumber()->fetch()['billing_number'];
		$billing_number = $old_billing_number == '' ? $current_billing_number + 1: $old_billing_number;
		//if ($result = $client->recupereDernierBillingNumber()->fetch()) 
		//{
			if ($client->updateBillingNumberAndTypeClientAndEtat($_GET['idclient'],$billing_number,'paying') > 0) 
			{
				if ($contract->setProfiArticleToContract($idcontract,$_GET['profil'])) 
				{
					/*$r = $contract->creerBallanceInitiale($idclient[1],date('Y-m-d'),$montant=0,$monnaie='',$description='');
					if ($r[1] == 1062) 
					{
					}*/
					if ($historique->setHistoriqueAction($idcontract,'contrat',$_GET['iduser'],$created_at,'creer')) 
					{
					}
					//require_once("rep.php");
				}
				/*$facture_id = $result['billing_number'] + 1;
				$facture_id .='/'.date('Ymd');
				if ($contract->creeFacture($facture_id,$show_rate=0,$_GET['monnaiefacture'],$_GET['tva'],date('Y-m-d'))) 
				{
					$date = date_parse($_GET['startDate']);
					$mois_debut = $data['month'];
					$annee = $data['year'];
					if ($contract->creerFactureService($facture_id,$idclient[1],$_GET['service'],$_GET['montant'],$_GET['rediction'],$mois_debut,$_GET['quantite'],$annee)) 
					{
						require_once("rep.php");
					}
				}*/
			}
		//}
	}
//}
/*else
{
	if ($contract->saveContract(1,$_GET['idclient'],$_GET['typecontract'],$_GET['monnaie_facture'],$_GET['monnaie_contract'],$_GET['tva'],$_GET['mode'],date('Y-m-d'),$_GET['etat'],$_GET['startDate'],$_GET['facturation'],$_GET['show_rate'])) 
	{
		$idcontract = $contract->getIdContract_par_numero(1)->fetch()['ID_contract'];
		if ($contract->saveServiceInclu($idcontract,$_GET['service'],$_GET['bandepassante'],$_GET['montant'],$_GET['idclient'],$prixTva,$_GET['quantite'])) 
		{
			if ($result = $client->recupereDernierBillingNumber()->fetch()) 
			{
				if ($client->updateBillingNumberAndTypeClientAndEtat($_GET['idclient'],$result['billing_number'] + 1,'paying') > 0) 
				{
					if ($contract->setProfiArticleToContract($idcontract,$_GET['profil'])) 
					{
						/*$r=$contract->creerBallanceInitiale($idclient[1],date('Y-m-d'),$montant=0,$monnaie='',$description='');
						if ($r[1] == 1062) 
						{
						}*
						if ($comptabilite->setHistoriqueAction($idcontract,'contrat',$_GET['userName'],date('Y-m-d'),'creer')) 
						{
						}
						//require_once("rep.php");
					}
					/*$facture_id = $result['billing_number'] + 1;
					$facture_id .='/'.date('Ymd');
					if ($contract->creeFacture($facture_id,$show_rate=0,$_GET['monnaiefacture'],$_GET['tva'],date('Y-m-d'))) 
					{
						$date = date_parse($_GET['startDate']);
						$mois_debut = $data['month'];
						$annee = $data['year'];
						if ($contract->creerFactureService($facture_id,$idclient[1],$_GET['service'],$_GET['montant'],$_GET['rediction'],$mois_debut,$_GET['quantite'],$annee)) 
						{
							require_once("rep.php");
						}
					}*
				}
			}
		}
	}
}*/

//typecontract="+typecontract+"&monnaie_contract="+monnaie_contract+"&monnaie_facture="+monnaie_facture+"&mode="+mode+"&etat="+etat+"&idclient="+idclient+"&facturation="+facturation+"&contract_services="+contract_services+"&startDate="+startDate+"&tva="+tva+"&profil="+profil+"&userName="+userName+"&show_rate="+show_rate+"&enable_discount="+enable_discount