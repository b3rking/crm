<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");  

	$comptabilite = new Comptabilite();

	date_default_timezone_set("Africa/Bujumbura");
    $dateversement = date("Y-m-d");

	/*if ($comptabilite->cloturerVersement($dateversement) > 0) 
	{
		foreach ($comptabilite->getVersementDuneDate($dateversement) as $value) 
		{
			if ($comptabilite->augmanterMontantBanque($value->ID_banque,$value->montant)) 
			{
				if ($comptabilite->diminuerMontantGrandeCaisse($value->montant,$value->monnaie_verser) > 0) 
				{
				}
				if ($comptabilite->setHistoriqueEntrerBanque($value->ID_banque,$value->montant,'payement',$dateversement)) 
				{
				}
				/*if ($comptabilite->versement_banque($idDestination,$idversement)) 
				{
					if ($comptabilite->setHistoriqueEntrerBanque($idDestination,$montant_total,'payement',$dateversement)) 
					{
					}
				}*
			}
		}
		//echo "Vous venez de cloturer le versement du ".$_GET['datepaiement'];
	}*/

    try
        {
            $con = connection();

            //on lance la transaction
            $con->beginTransaction();
            $versement = $comptabilite->getVersementNoCloturerByUser($_GET['iduser']);
            if ($comptabilite->cloturerVersement($_GET['iduser']) > 0) 
            {
                foreach ($versement as $value) 
                {
                    if ($comptabilite->augmanterMontantBanque($value->ID_banque,$value->debit) > 0) 
                    {
                        if ($comptabilite->diminuerMontantGrandeCaisse($value->debit,$value->monnaie) > 0) 
                        {
                            foreach ($comptabilite->getPaiements_attacher_a_un_versement($value->ID_versement) as $value2) 
                            {
                                if ($comptabilite->updateDeposedPayment($value2->ID_paiement,1) > 0) 
                                {
                                    
                                }
                            }
                            if ($comptabilite->setHistoriqueEntrerBanque($value->ID_banque,$value->debit,'payement',$dateversement)) 
                            {
                            }
                        }
                        
                        /*if ($comptabilite->versement_banque($idDestination,$idversement)) 
                        {
                            if ($comptabilite->setHistoriqueEntrerBanque($idDestination,$montant_total,'payement',$dateversement)) 
                            {
                            }
                        }*/
                    }
                }
                //echo "Vous venez de cloturer le versement du ".$_GET['datepaiement'];
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