<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();
if ($_GET['provenance'] == 'banque') 
{
	if ($comptabilite->transfertMontantde_banque_vers_compte($_GET['idBanque'],$_GET['montant'],$_GET['idcompte']) > 0) 
	{
		if ($comptabilite->sortie_banque ($_GET['idBanque'],$_GET['montant'],$_GET['nomcompte'],$_GET['dateapprovisionement'])) 
		{
			if ($comptabilite->approvisionnerCompte($_GET['provenance'],$_GET['montant'],$_GET['monnaie'],$_GET['idcompte'],$_GET['dateapprovisionement'],$_GET['iduser'])) 
			{
				if ($comptabilite->setBanqueAprovisionnerCompte($_GET['idBanque'])) 
				{
					if ($comptabilite->setHistoriqueAction($_GET['idcompte'],'compte',$_GET['userName'],date('Y-m-d'),'approvision')) 
					{
						echo "ok";
					}
				}
			}
		}
	}
}
elseif ($_GET['provenance'] == 'caisse') 
{
	if ($comptabilite->transfertMontantde_caisse_vers_compte($_GET['idcaisse'],$_GET['montant'],$_GET['idcompte']) > 0) 
	{
		if ($comptabilite->sortie_grande_caisse($_GET['idcaisse'],$_GET['montant'],$_GET['nomcompte'],$_GET['dateapprovisionement'])) 
		{
			if ($comptabilite->approvisionnerCompte($_GET['provenance'],$_GET['montant'],$_GET['monnaie'],$_GET['idcompte'],$_GET['dateapprovisionement'],$_GET['iduser'])) 
			{
				if ($comptabilite->setCaisseAprovisionnerCompte($_GET['idcaisse'])) 
				{
					if ($comptabilite->setHistoriqueAction($_GET['idcompte'],'compte',$_GET['userName'],date('Y-m-d'),'approvision')) 
					{
						echo "ok";
					}
				}
			}
		}
	}
}
