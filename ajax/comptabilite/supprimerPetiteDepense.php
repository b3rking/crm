<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

$depense = $comptabilite->getPetiteDepense($_GET['id_depense'])->fetch();


//if ($depense['provenance'] == 'caisse') 
//{
	try
	{
	    $con = connection();

	    //on lance la transaction
	    $con->beginTransaction();
	    if ($comptabilite->supprimerPetitedepense($_GET['id_depense']))  
		{
		    if ($comptabilite->augmenterMontantCaisse($depense['ID_caisse'],$depense['montantdepense']) > 0) 
			{
				/*if ($comptabilite->setHistoriqueEntrerCaisse('depense','retour',$montant_total,$monnaie,$idDestination,$dateversement,$iduser_verser)) 
				{
				}*/
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
//}
/*else
//{
	try
	{
	    $con = connection();

	    //on lance la transaction
	    $con->beginTransaction();
	    if ($comptabilite->supprimerdepense($_GET['id_depense']))  
		{
		    if ($comptabilite->augmanterMontantBanque($depense['ID_banque'],$depense['montantdepense']) > 0) 
			{
				/*if ($comptabilite->setHistoriqueEntrerBanque($_GET['idBanque'],$_GET['montant'],'versement',$_GET['dateversement'])) 
				{
				}*
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
//}*/
if ($comptabilite->setHistoriqueAction($_GET['id_depense'],'depense',$_GET['userName'],date('Y-m-d'),'supprimer')) 
{
	//echo "ok";
}
//require_once('reponsedepenseAdmin.php');
