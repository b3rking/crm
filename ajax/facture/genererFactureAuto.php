<?php
require_once("/var/www/crm.uvira/model/connection.php");
require_once("/var/www/crm.uvira/model/contract.class.php");
require_once("/var/www/crm.uvira/model/User.class.php");

$contract = new Contract();
$user = new User();
$comptabilite = new Comptabilite();
//$taux = $user->getTaux()->fetch();
$mois_array = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
$quantite;
$annee_debut;
$annee_fin;
$startDate = null;
$endDate = null;
$date = date_parse(date('Y-m-d'));
$mois_courant = $date['month'];
$annee_debut = $date['year'];
$quantite = 1;
if ($mois_courant == 12) 
{
	$mois_debut  = 1;
	$mois_fin = $mois_debut;
	$annee_debut = $date['year']+1;
	$annee_fin = $annee_debut;
	$description = 'Abonnement mois de '.$mois_array[$mois_debut].'/'.$annee_debut;
}
else
{
	$mois_debut  = $mois_courant+1;
	$mois_fin = $mois_debut;
	$annee_debut = $date['year'];
	$annee_fin = $annee_debut;
	$description = 'Abonnement mois de '.$mois_array[$mois_debut].'/'.$annee_debut;
}
if ($mois_fin == 12) 
{
	$nextMoth = 1;
	$nextYear = $annee_fin + 1;
}
else
{
	$nextMoth = $mois_fin+1;
	$nextYear = $annee_fin;
}
$verifierCreation = false;
//$dateformat = preg_split("#[-]+#", $date_creation);
foreach ($contract->getDataToPrintOnFactureEnMasse() as $value)
{
	//$facture_id = $value->billing_number.'_'.$dateformat[0].$dateformat[1].$dateformat[2];
	if (empty($contract->getMoisFactureDunClient($value->ID_client,$mois_debut,$annee_debut)->fetch()['ID_client'])) 
	{
		$billing_number = $value->billing_number;

		$mois_debut_f = ($mois_debut < 10 ? '0'.$mois_debut : $mois_debut);
		$facture_id = $value->billing_number.'_'.$annee_debut.$mois_debut_f.'01';
		if ($contract->creeFacture($facture_id,$show_rate=0,$value->monnaie_facture,$value->tva,date('Y-m-d'),$taux=1,$nextMoth,$nextYear)) 
		{
			/*$montantConverti = 0;
			if ($value->monnaie_facture != $value->monnaie) 
			{
				if ($value->monnaie == 'USD') 
				{
					$montantConverti = $value->montant*$taux['taux'];
				}
				elseif ($value->monnaie == 'FC') 
				{
					$montantConverti = $value->montant/$taux['taux'];
				}
			}
			else
			{
				$montantConverti = $value->montant;
			}*/
			$montantConverti = $value->montant;
			$montant_total = $montantConverti * $quantite;

			if ($contract->creerFactureService($facture_id,$value->ID_client,$value->ID_service,$value->bandepassante,$montantConverti,$montant_total,$rediction=0,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$startDate,$endDate,1)) 
			{
				$verifierCreation = true;
				$contract->setMoisFactureDunClient($value->ID_client,$mois_debut,$annee_debut,$facture_id);
				if ($contract->setAccountHistory($facture_id,'facture',$taux=1,date("Y-m-d"),$value->ID_client)) 
				{
					//$message = "ok";
				}
				/*if ($contract->augmanterBalanceInitiale($value->ID_client,$montant_total) > 0) 
				{
					$b = $contract->getmontaTotalBalanceInitiale($value->ID_client)->fetch();
					if ($contract->setAccountHistory($facture_id,'facture',$taux=1,$b['solde'],$b['montant_total'],date('Y-m-d'),$value->ID_client)) 
					{
						if ($quantite > 1) 
						{
							$y = 0;
							for ($i=0; $i < $quantite; $i++) 
							{ 
								$mois = $mois_debut+$i;
								if ($mois <= 12) 
								{
									if ($contract->setEcheance($value->ID_client,$mois,$annee_debut,$value->montant,$etat ='non consommer',$facture_id)) 
									{
										$verifierCreation = true;
									}
								}
								else
								{
									$y++;
									$mois = $mois_debut+$y;
									if ($contract->setEcheance($value->ID_client,$mois,$annee_fin,$value->montant,$etat ='non consommer',$facture_id)) 
									{
										$verifierCreation = true;
									}
								}
							}
						}
						else
						{
							if ($contract->setEcheance($value->ID_client,$mois_debut,$annee_debut,$value->montant,$etat ='non consommer',$facture_id)) 
							{
								$verifierCreation = true;
							}
						}
					}
				}*/
			}
			if ($comptabilite->setHistoriqueAction($facture_id,'facture','Automatique',date('Y-m-d'),'creer')) 
			{
			}
		}
		foreach ($contract->getClientEnfantToPrintOnFactureEnMasse($billing_number) as $value2) 
		{
			/*$montantConverti = 0;
			if ($value->monnaie_facture != $value->monnaie) 
			{
				if ($value->monnaie == 'USD') 
				{
					$montantConverti = $value->montant*$taux['taux'];
				}
				elseif ($value->monnaie == 'FC') 
				{
					$montantConverti = $value->montant/$taux['taux'];
				}
			}
			else
			{
				$montantConverti = $value->montant;
			}*/
			$montantConverti = $value->montant;
			$montant_total = $montantConverti * $quantite;
			if ($contract->creerFactureService($facture_id,$value->ID_client,$value2->ID_service,$value->bandepassante,$montantConverti,$montant_total,$rediction=0,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$startDate,$endDate,1)) 
			{
				$verifierCreation = true;
				/*if ($contract->augmanterBalanceInitiale($value->ID_client,$montant_total) > 0) 
				{
					$b = $contract->getmontaTotalBalanceInitiale($value->ID_client)->fetch();
					if ($contract->augmenterBalanceAccountHistory($facture_id,$b['montant_total']) > 0) 
					{
						if ($quantite > 1) 
						{
							$y = 0;
							for ($i=0; $i < $quantite; $i++) 
							{ 
								$mois = $mois_debut+$i;
								if ($mois <= 12) 
								{
									if ($contract->verifierUnMoisExistDansEcheance($value->ID_client,$mois,$annee_debut)) 
									{
										if ($contract->updateMontantEcheance($value->ID_client,$montant,$mois,$annee_debut) > 0) 
										{
											$verifierCreation = true;
										}
									}
									else
									{
										if ($contract->setEcheance($value->ID_client,$mois,$annee_debut,$montant,$etat ='non consommer',$facture_id)) 
										{
											$verifierCreation = true;
										}
									}
								}
								else
								{
									$y++;
									$mois = $mois_debut+$y;
									if ($contract->verifierUnMoisExistDansEcheance($value->ID_client,$mois,$annee_fin)) 
									{
										if ($contract->updateMontantEcheance($value->ID_client,$montant,$mois,$annee_fin) > 0) 
										{
											$verifierCreation = true;
										}
									}
									else
									{
										if ($contract->setEcheance($value->ID_client,$mois,$annee_fin,$montant,$etat ='non consommer',$facture_id)) 
										{
											$verifierCreation = true;
										}
									}
								}
							}
						}
						else
						{
							if ($contract->verifierUnMoisExistDansEcheance($value->ID_client,$mois,$annee_debut)) 
							{
								if ($contract->updateMontantEcheance($value->ID_client,$montant,$mois,$annee_debut) > 0) 
								{
									$verifierCreation = true;
								}
							}
							else
							{
								if ($contract->setEcheance($value->ID_client,$mois_debut,$annee_debut,$montant,$etat ='non consommer',$facture_id)) 
								{
									$verifierCreation = true;
								}
							}
						}
					}
				}*/
			}
		}
	}
}