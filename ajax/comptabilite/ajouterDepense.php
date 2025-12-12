<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite(); 
 
if ($comptabilite->justifierdepense($_GET['dateDepense'],$_GET['montant'],$_GET['nom'],$_GET['description'],$_GET['nomserveur'])) 
{
	/*if ($comptabilite->updateMontantVerserBanque($_GET['idDestination'],$_GET['montant'])) 
		{
			if ($comptabilite->setHistoriqueAction($res['ID_versement'],'caisse ',$_GET['nomserveur'],$_GET['dateDepense'],'creer depense')) 
			
			
				{
						$res = $comptabilite->getMaxIdVersement()->fetch();
						//if ($comptabilite->setPaiement_verser($_GET['idpaiement'],$res['ID_versement'])) 
						//{
							//if ($comptabilite->versement_banque($_GET['idDestination'],$res['ID_versement'])) 
						//{}
						//}

						
			}
		}*/
	
}



?>
