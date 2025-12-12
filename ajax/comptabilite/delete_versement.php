<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

$comptabilite = new Comptabilite();
$historique = new Historique();

//$versement = $comptabilite->getVersement($_GET['idversement'])->fetch();
$paiement = $comptabilite->getPaiements_attacher_a_un_versement($_GET['idversement']);

//echo 'ID_banque: '.$versement['ID_banque'].' montant: '.$versement['montant'];
if ($comptabilite->deleteVersement($_GET['idversement']) > 0) 
{
    foreach ($paiement as $value) 
	{
		if ($comptabilite->updatePayementDeposed($value->ID_paiement,NULL,0) > 0) 
		{
	        # code...
	    }
	}

	//if ($historique->setHistoriqueAction($_GET['idversement'],'versement',$_GET['iduser'],date('Y-m-d'),'supprimer')) 
	//{
		//echo "ok";
		/*if ($comptabilite->augmenterMontantGrandeCaisse($versement['montant'],$versement['monnaie_verser']) > 0) 
		{
			if ($comptabilite->reduireMontantEnBanque($versement['ID_banque'],$versement['montant']) >0) 
			{}
		}*/
	//}
}
//else
//echo "no";