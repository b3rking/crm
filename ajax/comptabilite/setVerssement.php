<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

if ($comptabilite->versement($_GET['idBanque'],$_GET['reference'],$_GET['dateversement'],$_GET['idUser'],$etat = 0,$_GET['montant'],$_GET['monnaie']))  
{
	if ($comptabilite->reduireMontantCaisse($_GET['idcaisse'],$_GET['montant']) > 0) 
	{
		if ($comptabilite->setHistoriqueSortieCaisse($_GET['idcaisse'],$_GET['montant'],'verssement',$_GET['nomBanque'],$_GET['dateversement']))
		{
			if ($comptabilite->augmanterMontantBanque($_GET['idBanque'],$_GET['montant'])) 
			{
				if ($comptabilite->setHistoriqueEntrerBanque($_GET['idBanque'],$_GET['montant'],'versement',$_GET['dateversement'])) 
				{
				}
			}
		}
	}
}  