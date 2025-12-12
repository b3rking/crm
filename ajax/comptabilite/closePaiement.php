<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
//require_once("../../model/contract.class.php");
//require_once("../../model/client.class.php"); 

//$contract = new Contract();
$comptabilite = new Comptabilite();
//$client = new Client();

	/*date_default_timezone_set("Africa/Bujumbura");
    $datepaiement = date("Y-m-d");

    $flag = false;
    foreach ($comptabilite->getPayementCashJournalier($datepaiement) as $value) 
    {
    	if ($comptabilite->augmenterMontantGrandeCaisse($value->montant,$value->devise) > 0) 
		{
			$flag = true;
		}
    }
    if ($flag) 
    {
    	if ($comptabilite->closePayement($_GET['idUser'],$datepaiement) > 0) 
	    {
	    	# code...
	    }
    }*/

try
{
    $con = connection();

    //on lance la transaction
    $con->beginTransaction();

    //date_default_timezone_set("Africa/Bujumbura");
    //$datepaiement = date("Y-m-d");

    //$flag = false;

    foreach ($comptabilite->getPayementCashNotCloseByUser($_GET['idUser']) as $value) 
    {
        if ($comptabilite->augmenterMontantDansCaisseRecette($value->montant,$value->devise) > 0) 
        {
            //$flag = true;
        }
    }
    foreach ($comptabilite->getPayementNoCashNotCloseByUser($_GET['idUser']) as $value2) 
    {
        if ($comptabilite->augmanterMontantBanque($value2->ID_banque,$value2->montant) > 0) 
        {
            if ($comptabilite->versement($value2->ID_banque,$value2->reference,$value2->datepaiement,$_GET['idUser'],$value2->montant))  
            {
                $res = $comptabilite->getMaxIdVersement()->fetch();
                $idversement = $res['ID_versement'];
                if ($comptabilite->setPaiement_verser($value2->ID_paiement,$idversement)) 
                {
                    if ($comptabilite->cloturerUnVersement($idversement) > 0) 
                    {}
                }
            }
        }
    }
    /*foreach ($comptabilite->getPayementCashJournalier($datepaiement) as $value) 
    {
        if ($comptabilite->augmenterMontantGrandeCaisse($value->montant,$value->devise) > 0) 
        {
            $flag = true;
        }*/
        /*if ($comptabilite->augmenterMontantDansCaisseRecette($value->montant) > 0) 
        {
            $flag = true;
        }*/
    //}
    //if ($flag) 
    //{
        if ($comptabilite->closePayement($_GET['idUser']) > 0) 
        {
            # code...
        }
    //}

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