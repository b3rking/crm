<?php
require_once("/var/www/crm.uvira/model/connection.php");
require_once("/var/www/crm.uvira/model/client.class.php");
require_once("/var/www/crm.uvira/model/contract.class.php");

$date = date_parse(date('Y-m-d'));
$jour = $date['day'];
$mois = $date['month'];
$annee = $date['year'];

$client = new Client();
$contract = new Contract();
foreach ($client->recupererClientActif() as $value) 
{
	foreach ($contract->recupereEcheance_dun_mois_dun_client($value->ID_client,$mois,$annee) as $value2) 
	{
		if ($contract->augmenterSolde($value->ID_client,$value2->montant)>0) 
		{
			if ($contract->changerEtatEcheance($value->ID_client,$mois,$annee,'en cours')>0) 
			{
				// Changer l'etat du mois passer
				if ($mois == 1) 
				{
					if ($contract->changerEtatEcheance($value->ID_client,$mois=12,$annee-1,'consommer')>0) 
					{
						# code...
					}
				}
				else
				{
					if ($contract->changerEtatEcheance($value->ID_client,$mois-1,$annee,'consommer')>0) 
					{
						# code...
					}
				}
				if ($contract->augmenterSoldeFactureAccountHistory($value2->facture_id,$value2->montant) > 0) {
				}
			}
		}
	}
}
