<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

$comptabilite = new Comptabilite();
$historique = new Historique();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
/*if ($_GET['provenance'] == 'caisse') 
{
	try
	{
	    $con = connection();

	    //on lance la transaction
	    $con->beginTransaction();

	    if ($comptabilite->creationDepense($_GET['reference'],$_GET['montant'],$_GET['monnaie'],$_GET['motif'],$_GET['datedepense'],$_GET['idcategorie'],$_GET['provenance'],$_GET['idprovenance'],null,$_GET['iduser']))
		{
			if ($comptabilite->reduireMontantCaisse($_GET['idprovenance'],$_GET['montant']) > 0) 
			{
				//if ($comptabilite->setCaisseDepense($_GET['idprovenance']))
				//{
					if ($comptabilite->setHistoriqueSortieCaisse($_GET['idprovenance'],$_GET['montant'],$_GET['motif'],$_GET['description'],$_GET['datedepense']))
					{
						$id = $comptabilite->getMaxIdDepense()->fetch()['ID_depense'];
						if ($comptabilite->setHistoriqueAction($id,'depense',$_GET['userName'],date('Y-m-d'),'creer')) 
						{
							echo "ok";
						}
					}
				//}
				//require_once('reponsedepenseAdmin.php');
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
}*/
//else
//{
	try
	{
	    $con = connection();

	    //on lance la transaction
	    $con->beginTransaction();

	    if ($comptabilite->creationDepense($_GET['reference'],$_GET['montant'],$_GET['motif'],$_GET['datedepense'],$_GET['idcategorie'],$_GET['idprovenance'],$_GET['iduser']))
		{
			//if ($comptabilite->reduireMontantEnBanque($_GET['idprovenance'],$_GET['montant']) >0) 
			//{
				//if ($comptabilite->setBanqueDepense($_GET['idprovenance']))
				//{
					if ($comptabilite->sortie_banque ($_GET['idprovenance'],$_GET['montant'],$_GET['motif'],$_GET['description'],$_GET['datedepense'])) 
					{
						$id = $comptabilite->getMaxIdDepense()->fetch()['ID_depense'];
						if ($historique->setHistoriqueAction($id,'depense',$_GET['iduser'],$created_at,'creer')) 
						{
							//echo "ok";
						}
					}
				//}
					//require_once('reponsedepenseAdmin.php');
			//}
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

?>