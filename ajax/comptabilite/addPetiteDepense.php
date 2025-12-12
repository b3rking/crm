<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

try
{
    $con = connection();

    //on lance la transaction
    $con->beginTransaction();

    if ($comptabilite->addPetiteDepense($_GET['montant'],$_GET['monnaie'],$_GET['motif'],$_GET['datedepense'],$_GET['idcategorie'],$_GET['idprovenance'],$_GET['iduser']))
	{
		if ($comptabilite->reduireMontantCaisse($_GET['idprovenance'],$_GET['montant']) > 0) 
		{
			//if ($comptabilite->setCaisseDepense($_GET['idprovenance']))
			//{
				if ($comptabilite->setHistoriqueSortieCaisse($_GET['idprovenance'],$_GET['montant'],$_GET['motif'],$_GET['description'],$_GET['datedepense']))
				{
					$id = $comptabilite->getMaxIdPetiteDepense()->fetch()['ID_depense'];
					if ($comptabilite->setHistoriqueAction($id,'depense',$_GET['userName'],date('Y-m-d'),'creer')) 
					{
						//echo "ok";
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

//idprovenance="+idprovenance+"&montant="+montant+"&monnaie="+monnaie+"&motif="+motif+"&datedepense="+datedepense+"&iduser="+iduser+"&idcategorie="+idcategorie+"&description="+description+"&userName="+userName