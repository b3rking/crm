<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

$comptabilite = new Comptabilite();
$historique = new Historique();

$appro = $comptabilite->getApprivisionnement($_GET['idapro'])->fetch();

//echo 'ID_banque: '.$versement['ID_banque'].' montant: '.$versement['montant'];
/*if ($comptabilite->delete_aprovisionement($_GET['idapro'])) 
{
	if ($comptabilite->setHistoriqueAction($_GET['idapro'],'approvisionnement',$_GET['userName'],date('Y-m-d'),'supprimer')) 
	{
		//echo "ok";
		if ($comptabilite->augmanterMontantBanque($appro['ID_banque'],$appro['montant']) > 0) 
		{
			if ($comptabilite->reduireMontantCaisse($appro['ID_caisse'],$appro['montant']) > 0) 
			{}
		}
	}
}*/

    try
	{
	    $con = connection();

	    //on lance la transaction
	    $con->beginTransaction();

	    if ($comptabilite->delete_aprovisionement($_GET['idapro'])) 
		{
            //echo "ok";
            if ($comptabilite->augmanterMontantBanque($appro['ID_banque'],$appro['credit']) > 0) 
            {
                if ($comptabilite->reduireMontantCaisse($appro['ID_caisse'],$appro['credit']) > 0) 
                {
                    if ($historique->setHistoriqueAction($_GET['idapro'],'approvisionnement',$_GET['iduser'],date('Y-m-d'),'supprimer')) 
					{}
                }
            }
		}
	    //si jusque là tout se passe bien on valide la transaction
	    $con->commit();
	   
	    //on affiche un petit message de confirmation
	    //echo 'Tout s\'est bien passé.';
	}
	catch(Exception $e) //en cas d'erreur
	{
	    //on annule la transation
	    $con->rollback();

	    //on affiche un message d'erreur ainsi que les erreurs
	    echo 'Erreur : '.$e->getMessage().'<br />';
	    echo 'N° : '.$e->getCode();

	    //on arrête l'exécution s'il y a du code après
	    exit();
	}