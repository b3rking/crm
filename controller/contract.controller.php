<?php
require_once("model/client.class.php");
require_once("model/contract.class.php");
require_once("model/service.class.php");
require_once("model/typeClient.class.php");
require_once("model/localisation.class.php");
require_once("model/article.class.php");
require_once('model/User.class.php');
require_once('model/comptabilite.class.php');
function contract()
{
	$contract = new Contract();
	$service = new Service();
	$type = new TypeClient();
	$localisation = new Localisation();
	$article = new Article();
	$user = new User();
	$comptabilite = new Comptabilite();
    $client = new Client();
    $customers_tot_create_contract = $client->get_customers_to_create_contrat();
    $result = $contract->afficherContracts();
    
    $numero = "";
	$billing_number = "";
	$nom_client = "";
	$service_filter = "";
	$datecreation = "";
	$status_filter = "";
	require_once('vue/admin/contract/contract.php');
}
function filtre_contract($numero,$billing_number,$nom_client,$service_filter,$datecreation,$status_filter,$print)
{
	$condition1 = "";
    $condition2 = ""; 
    $condition3 = "";
    $condition4 = "";
    $condition5 = "";
    $condition6 = "";
    $condition = "";

    $condition1 = $nom_client == '' ? '' : " cl.nom_client LIKE '%".$nom_client."%' ";

    $condition2 = $service_filter == "" ? "" : " s.ID_service=".$service_filter." ";

    $condition3 = $datecreation == "" ? "" : " co.date_creation='".$datecreation."' ";
    $condition4 = $numero == "" ? "" : " co.numero=".$numero." ";
    $condition5 = $billing_number == "" ? "" : " cl.billing_number=".$billing_number." ";
    $condition6 = $status_filter == "" ? "" : " co.etat='".$status_filter."'";

    $condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
    $condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
    $condition5 = ($condition5 == '' ? '' : 'AND' .$condition5);
    $condition6 = ($condition6 == '' ? '' : 'AND' .$condition6);
    
    $condition = $condition1.$condition2.$condition3.$condition4.$condition5.$condition6;
    //die(print_r($condition));

    $contract = new Contract();
	$service = new Service();
	$type = new TypeClient();
	$localisation = new Localisation();
	$article = new Article();
	$user = new User();
	$comptabilite = new Comptabilite();
    $client = new Client();
    $customers_tot_create_contract = $client->get_customers_to_create_contrat();

    $result = $contract->filtre_contract($condition);
    if ($print == 1) 
    	require_once("printing/fiches/printContractFiltrer.php");
    else
    {
    	require_once('vue/admin/contract/contract.php');
    }
//    require_once('vue/admin/contract/contract.php');
}
function creerfichier_client($idclient,$nom,$fileTmpName,$uploadPath,$fileName)
{
	$contract = new Contract();
	$service = new Service();
	$type = new TypeClient();
	$localisation = new Localisation();
	$article = new Article();
	$user = new User();
    $client = new Client();
	//$idclientOnContract = preg_split("#[-]+#", $idclientOnContract);

	date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");

	if ($contract->creerfichier_attacher($idclient,$nom,$fileName,$_SESSION['ID_user'],$created_at))
	{
		//echo 'upload reussie';
		//$msg = "La creation reussie";
		//header("location:fichier_client");
		//require_once('vue/admin/contract/fichier_client.php');
		$attachId = $contract->get_max_attache_file_id();
		if (mkdir($uploadPath.$attachId, 0755,true)) 
		{
			$didUpload = move_uploaded_file($fileTmpName, $uploadPath.$attachId."/".$fileName);
			if ($didUpload) 
			{
				//$fichier = basename($fileName);
				//echo "idclientOnContract : ".$idclientOnContract." nom :".$nom." fichier : ".$fichier;
				/*if ($contract->creerfichier_attacher($idclientOnContract[1],$nom,$fileName,$_SESSION['ID_user'],date('Y-m-d')))
				{
					//echo 'upload reussie';
					//$msg = "La creation reussie";
					header("location:fichier_client");
					//require_once('vue/admin/contract/fichier_client.php');
				}*/
				//require_once('vue/admin/contract/fichier_client.php');
				header("location:fichier_client");
			}
			else
			{
				if ($client->deleteFichierAttacher($attachId)) 
				{}
				$msg = "Le fichier ".basename($fileName)." n'est pas chargé";
				require_once('vue/admin/contract/fichier_client.php');
			}
		}
		else
		{
			if ($client->deleteFichierAttacher($attachId)) 
			{}
			$msg = "Le fichier ".basename($fileName)." n'est pas chargé";
			require_once('vue/admin/contract/fichier_client.php');
		}
	}
}
function sendMsg($errors,$url)
{
	$contract = new Contract();
	$service = new Service();
	$type = new TypeClient();
	$localisation = new Localisation();
	$article = new Article();
	$user = new User();
	require_once($url);
}

function fichier_client()
{
	$contract = new Contract();
	//$service = new Service();
	//$type = new TypeClient();
	//$localisation = new Localisation();
	//$article = new Article();
	$user = new User();
	$result = $contract->afficherfichier_client_avec_contrat();
	require_once('vue/admin/contract/fichier_client.php');
}
function customer_under_contract()
{
    $user = new User();
	$client = new Client();
	$customer_parents = $client->customers_with_contract();
	$children_to_assign = $client->customers_to_assign_parent();
	$children_customers = $client->children_customers();
	require_once('vue/admin/contract/customer_under_contract.php');
}
function filtreFichierAttacher($billing_number,$nom_client,$date_creation,$file_name)
{
	$contract = new Contract();
	$user = new User();

	$condition1 = "";
    $condition2 = "";
    $condition3 = "";
    $condition4 = "";

    $condition1 = ($billing_number == "" ? "" : " billing_number='".$billing_number."' ");
    $condition2 = ($nom_client == "" ? "" : " nom_client LIKE '%".$nom_client."%' ");
    $condition3 = ($date_creation == "" ? "" : " DATE(date_fichier) = '".$date_creation."' ");
    $condition4 = ($file_name == "" ? "" : " nom LIKE '%".$file_name."%' ");

    $condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
    $condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
    
    $cond = $condition1.$condition2.$condition3.$condition4;

    $result = $contract->filtreFichierAttacher($cond);
	require_once('vue/admin/contract/fichier_client.php');
}
function detailContract($idcontract)
{
	$contract = new Contract();
	require_once('vue/admin/contract/detailContract.php');
}
function detailClient_fichier_contract($idclient)
{
	$client = new Client();
	$ticket = new ticket();
	$contract = new Contract();
	$equipement = new Equipement();
	require_once('vue/admin/contract/detailClient_fichier_contract.php');
}
function printContract($idcontract)
{
	$contract = new Contract();
	$article = new Article();
	$donnee = $contract->getNumeroAndLangueContrat($idcontract)->fetch();
	$numero = $donnee['numero'];
	$langue = $donnee['langue'];
	require_once('printing/fiches/printContract.php');
}
function voirfichier($idfichier)
{
	$contract =new Contract();
	$article = new Article();
	require_once('vue/admin/contract/fichier_client.php');
	//require_once('printing/fiches/printContract.php');
}
function Modifier_fichier_client($idfichier,$nom_fichier,$fileTmpName,$uploadPath,$fileName,$oldFileName,$errors)
{
	$contract = new Contract();
	$service = new Service();
	$type = new TypeClient();
	$localisation = new Localisation();
	$article = new Article();
	$user = new User();

	if (null === $fileName)
	{
		$extension = explode('.', $oldFileName)[1];
		$fileName = $nom_fichier.'.'.$extension;

		if ($contract->updatefichierClient($idfichier,$nom_fichier,$fileName))
		{
			
			if (rename('uploads/customer_file/file/'.$idfichier.'/'.$oldFileName, 'uploads/customer_file/file/'.$idfichier.'/'.$fileName)) 
			{
				$_SESSION['message'] = 'Modification reussie';
				header('location:fichier_client');
			}
		}
	}
	else
	{
		if ($contract->updatefichierClient($idfichier,$nom_fichier,$fileName))
		{
			if (unlink('uploads/customer_file/file/'.$idfichier.'/'.$oldFileName)) 
			{
				$didUpload = move_uploaded_file($fileTmpName, $uploadPath.$idfichier."/".$fileName);
				if ($didUpload) 
				{
					$_SESSION['message'] = 'Modification reussie';
					header('location:fichier_client');
				}
			}
		}
	}
}
function printVeso_contrat($idcontract)
{
	$contract = new Contract();
	$article = new Article();
	$donnee = $contract->getNumeroAndLangueContrat($idcontract)->fetch();
	$numero = $donnee['numero'];
	$langue = $donnee['langue'];
	require_once('printing/fiches/PrintVerso_contrat.php');
}

function updateAmountContract()
{
    $contract = new Contract();
    foreach ($contract->getContractServices() as $value) 
    {
        if($contract->updateContractAmount($value->ID_contract,$value->amount) > 0)
        {}
    }
}

/**
 * Convert amount from one currency to another (for invoicing)
 * Supported: BIF, USD, EUR
 * Rates as of December 2025 – update periodically or make dynamic later
 */
function convertCurrency($amount, $fromCurrency, $toCurrency)
{
    $from = strtolower($fromCurrency);
    $to   = strtolower($toCurrency);

    // No conversion needed
    if ($from === $to) {
        return $amount;
    }

    // Exchange rates (BIF base) – update these regularly!
    $rates = [
        'bif' => 1,
        'usd' => 2947,   // 1 USD ≈ 2947 BIF (Dec 2025 approx)
        'eur' => 3300,   // 1 EUR ≈ 3300 BIF (Dec 2025 approx)
    ];

    // Convert to BIF first
    $inBif = $amount * $rates[$from];

    // Then convert to target currency
    return $inBif / $rates[$to];
}