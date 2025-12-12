<?php
require_once("../../model/connection.php");
require_once("../../model/client.class.php");
require_once("../../model/typeClient.class.php");
require_once("../../model/contract.class.php");
require_once("../../model/service.class.php");
require_once("../../model/User.class.php");

$client = new Client();
$type = new TypeClient();
$contract = new Contract();

/*$service = new Service();
$user = new User();
$tauxData = $user->getTaux()->fetch();
$taux = $tauxData['taux'];
$serviceData = $service->recupererService($_GET['service'])->fetch();
$montant = $serviceData['montant'];
$monnaieService = $serviceData['monnaie'];
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
$prixTva = $_GET['montant']/100*$_GET['tva'];
//$montantConverti += $prixTva;

$dernierIdClient;
if ($data = $client->recupererDernierClient()->fetch()) 
{
    $dernierIdClient = $data['ID_client'] + 1;
}
$etat = ($_GET['type'] == 'paying' ? 'actif' : 'N/A');
if ($client->saveclient($dernierIdClient,$_GET['nom'],$_GET['phone'],$_GET['mail'],$_GET['adrs'],$_GET['note'],$_GET['pers_cont'],$_GET['type'],date('Y-m-d'),$_GET['location'],$_GET['langue'],$_GET['nif'],$_GET['assujettitva'],$etat,$_GET['billing_number_parent'])) 
{
	if ($contract->saveServiceInclu($_GET['num_contract'],$_GET['service'],$_GET['bandepassante'],$_GET['montant'],$dernierIdClient,$prixTva,$_GET['show_on_fact'])) 
	{
		require_once("../contract/rep.php");
		/*if ($val = $contract->getFactureIdForOneClient($_GET['id_parent'])->fetch()) 
		{
			$date = date_parse($_GET['startDate']);
			$mois_debut = $date['month'];
			$annee = $date['year'];
			if ($contract->creerFactureService($val['facture_id'],$dernierIdClient,$_GET['service'],$_GET['montant'],$_GET['rediction'],$mois_debut,$_GET['quantite'],$annee)) 
			{
				require_once("../contract/rep.php");
			}
		}*/
	}
    /*if ($type->affecterTypeClient($dernierIdClient,$_GET['type'])) 
    {
    	if ($contract->saveServiceInclu($_GET['num_contract'],$_GET['service'],$_GET['bandepassante'],$_GET['montant'],$dernierIdClient,$prixTva)) 
		{
			require_once("../contract/rep.php");
			/*if ($val = $contract->getFactureIdForOneClient($_GET['id_parent'])->fetch()) 
			{
				$date = date_parse($_GET['startDate']);
				$mois_debut = $date['month'];
				$annee = $date['year'];
				if ($contract->creerFactureService($val['facture_id'],$dernierIdClient,$_GET['service'],$_GET['montant'],$_GET['rediction'],$mois_debut,$_GET['quantite'],$annee)) 
				{
					require_once("../contract/rep.php");
				}
			}*
		}
    }*///END IF AFFECTERTYPECLIENT
}//END IF SAVE CLIENT REUSSI 

?>
