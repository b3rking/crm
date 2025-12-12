<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
//require_once("../../model/service.class.php");
//require_once("../../model/User.class.php");
require_once("../../model/historique.class.php"); 
require_once("../../model/client.class.php");  

$historique = new Historique();
$contract = new Contract();
//$user = new User();
//$service = new Service();
$client = new Client();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
$update_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
/*$tauxData = $user->getTaux()->fetch();
$taux = $tauxData['taux'];
$serviceData = $service->recupererService($_GET['service'])->fetch();
$montant = $serviceData['montant'];
$monnaieService = $serviceData['monnaie'];
if ($monnaieService != $_GET['monnaie']) 
{
	if ($monnaieService == 'usd') 
	{
		$montantConverti = $montant*$taux;
	}
	elseif ($monnaieService == 'bif') 
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
$webroot = $_GET['webroot'];

$contract_services = rtrim($_GET['contract_services'],'}');
$contract_services = preg_split("#[}]+#", trim($contract_services));
//if ($_GET['nombreService'] > 1) 
//{
	//$i =(int) $_GET['i'];
	//if ($i == 0) 
	//{
		if ($contract->updateContract($_GET['num_contract'],$_GET['client_parent'],$_GET['monnaie'],$_GET['monnaie_facture'],$_GET['tva'],$_GET['mode'],$_GET['facturation'],$_GET['startDate'],$_GET['etat'],$_GET['show_rate'],$_GET['enable_discount'],$update_at) > 0) 
		{
			for ($i=0; $i < count(($contract_services)); $i++) 
			{ 
				$contract_service_detail = preg_split("#[_]+#", trim($contract_services[$i]));

				$id = $contract_service_detail[0];
				$service_id = $contract_service_detail[1];
				$bandepassante = ($contract_service_detail[2] == 'null' ? '' : $contract_service_detail[2]);
				$montant = $contract_service_detail[3];
				$quantite = $contract_service_detail[4];
				$nom_client = ($contract_service_detail[5] == 'null' ? '' : $contract_service_detail[5]);
				$adresse = ($contract_service_detail[6] == 'null' ? '' : $contract_service_detail[6]);
				$show_on_invoice = $contract_service_detail[7];
				$service_status = $contract_service_detail[8];

				$prixTva = $montant/100*$_GET['tva'];

				if ($id == 'null') 
				{
					if ($contract->saveServiceInclu($_GET['num_contract'],$service_id,$bandepassante,$montant,$_GET['client_parent'],$prixTva,$quantite,$nom_client,$adresse,$show_on_invoice,$service_status)) 
					{
						
					}
				}
				else
				{
					if ($contract->updateServiceIncluContract($id,$service_id,$_GET['client_parent'],$bandepassante,$montant,$prixTva,$service_status,$quantite,$nom_client,$adresse,$show_on_invoice) > 0) 
					{}
				}
			}
			if ($contract->updateProfilToContrat($_GET['num_contract'],$_GET['profil']) > 0) 
			{
				if ($_GET['etat'] == 'activer') 
				{
					if ($client->updateTypeAndEtat($_GET['client_parent'],$type_client='paying',$etat='actif') > 0) 
					{
						
					}
				}
				elseif ($_GET['etat'] == 'suspension') 
				{
					if ($client->updateTypeAndEtat($_GET['client_parent'],$type_client='paying',$etat='coupure') > 0) 
					{
						
					}
				}
				elseif ($_GET['etat'] == 'pause') 
				{
					if ($client->updateTypeAndEtat($_GET['client_parent'],$type_client='paying',$etat='pause') > 0) 
					{
						
					}
				}
				elseif($_GET['etat'] == 'terminer')
				{
					if ($client->updateTypeAndEtat($_GET['client_parent'],$type_client='gone',$etat='terminer') > 0) 
					{
						
					}
				}
                elseif($_GET['etat'] == 'attente')
                {
                    if ($client->updateTypeAndEtat($_GET['client_parent'],$type_client='unknown',$etat='attente') > 0) 
					{
						
					}
                }
			}
			if ($historique->setHistoriqueAction($_GET['num_contract'],'contrat',$_GET['iduser'],$created_at,'modifier')) 
			{
				//require_once("rep.php");
			}
		}
	/*}
	else
	{
		if ($contract->updateServiceIncluContract($_GET['id'],$_GET['service'],$_GET['sous_client'],$_GET['bandepassante'],$_GET['montant'],$prixTva,$_GET['status_service'],$_GET['quantite']) > 0) 
		{
			//require_once("rep.php");
		}
	}*/
//}
/*else
{
	if ($contract->updateContract($_GET['num_contract'],$_GET['client_parent'],$_GET['monnaie'],$_GET['monnaie_facture'],$_GET['tva'],$_GET['mode'],$_GET['facturation'],$_GET['startDate'],$_GET['etat'],$_GET['show_rate']) > 0) 
	{
		if ($contract->updateServiceIncluContract($_GET['id'],$_GET['service'],$_GET['sous_client'],$_GET['bandepassante'],$_GET['montant'],$prixTva,$_GET['status_service'],$_GET['quantite']) > 0) 
		{
			if ($contract->updateProfilToContrat($_GET['num_contract'],$_GET['profil']) > 0) 
			{
				if ($_GET['etat'] == 'activer') 
				{
					if ($client->updateTypeAndEtat($_GET['client_parent'],$type_client='paying',$etat='actif') > 0) 
					{
						
					}
				}
				elseif ($_GET['etat'] == 'suspension') 
				{
					if ($client->updateTypeAndEtat($_GET['client_parent'],$type_client='paying',$etat='coupure') > 0) 
					{
						
					}
				}
				elseif ($_GET['etat'] == 'pause') 
				{
					if ($client->updateTypeAndEtat($_GET['client_parent'],$type_client='paying',$etat='pause') > 0) 
					{
						
					}
				}
				else
				{
					if ($client->updateTypeAndEtat($_GET['client_parent'],$type_client='gone',$etat='terminer') > 0) 
					{
						
					}
				}
			}
			if ($comptabilite->setHistoriqueAction($_GET['num_contract'],'contrat',$_GET['userName'],date('Y-m-d'),'modifier')) 
			{
				//require_once("rep.php");
			}
		}
	}
}*/

//num_contract="+numero+"&monnaie="+monnaie+"&monnaie_facture="+monnaie_facture+"&mode="+mode+"&etat="+etat+"&tva="+tva+"&client_parent="+client+"&facturation="+facturation+"&startDate="+startDate+"&webroot="+webroot+"&userName="+userName+"&profil="+profil+"&show_rate="+show_rate+"&enable_discount="+enable_discount+"&contract_services="+contract_services