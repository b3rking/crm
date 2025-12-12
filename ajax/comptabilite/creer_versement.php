<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

	if ($_GET['nombredePaiement'] > 1) 
	{
		$i = (int) $_GET['i']; 
		if ($i == 1) 
		{
			if ($comptabilite->versement($_GET['destination'],$_GET['reference'],$_GET['dateversement'],$_GET['iduser'],$etat = 'fermer',$_GET['montant_total'],$_GET['monnaie']))  
			{
				if ($_GET['destination'] == 'banque') 
				{
					if ($comptabilite->updateMontantVerserBanque($_GET['idDestination'],$_GET['montant_total'])) 
					{
						$res = $comptabilite->getMaxIdVersement()->fetch();
						if ($comptabilite->setPaiement_verser($_GET['idpaiement'],$res['ID_versement'])) 
						{
							if ($comptabilite->versement_banque($_GET['idDestination'],$res['ID_versement'])) {}
						}
					}
				}
				else
				{
					if ($comptabilite->augmenterMontantCaisse($_GET['idDestination'],$_GET['montant_total'])) 
					{
						$res = $comptabilite->getMaxIdVersement()->fetch();
						if ($comptabilite->setPaiement_verser($_GET['idpaiement'],$res['ID_versement'])) 
						{
							if ($comptabilite->versement_caisse($_GET['idDestination'],$res['ID_versement'])) {}
						}
					}
				}
				$res = $comptabilite->getMaxIdVersement()->fetch();
				if ($comptabilite->setHistoriqueAction($res['ID_versement'],'versement',$_GET['userName'],date('Y-m-d'),'creer')) 
				{
				}
			}
		}
		else
		{
			$res = $comptabilite->getMaxIdVersement()->fetch();
			if ($comptabilite->setPaiement_verser($_GET['idpaiement'],$res['ID_versement'])) 
			{
				# code....
			}
		}
	}
	else
	{
		if ($comptabilite->versement($_GET['destination'],$_GET['reference'],$_GET['dateversement'],$_GET['iduser'],$etat = 'fermer',$_GET['montant_total'],$_GET['monnaie']))  
		{
			if ($_GET['destination'] == 'banque') 
			{
				if ($comptabilite->updateMontantVerserBanque($_GET['idDestination'],$_GET['montant_total'])) 
				{
					$res = $comptabilite->getMaxIdVersement()->fetch();
					if ($comptabilite->setPaiement_verser($_GET['idpaiement'],$res['ID_versement'])) 
					{
						if ($comptabilite->versement_banque($_GET['idDestination'],$res['ID_versement'])) {}
					}
				}
			}
			else
			{
				if ($comptabilite->augmenterMontantCaisse($_GET['idDestination'],$_GET['montant_total'])) 
				{
					$res = $comptabilite->getMaxIdVersement()->fetch();
					if ($comptabilite->setPaiement_verser($_GET['idpaiement'],$res['ID_versement'])) 
					{
						if ($comptabilite->versement_caisse($_GET['idDestination'],$res['ID_versement'])) {}
					}
				}
			}
			$res = $comptabilite->getMaxIdVersement()->fetch();
			if ($comptabilite->setHistoriqueAction($res['ID_versement'],'versement',$_GET['userName'],date('Y-m-d'),'creer')) 
			{
			}
		}
	}

?>
