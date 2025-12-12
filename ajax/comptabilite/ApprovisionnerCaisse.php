<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

	$comptabilite = new Comptabilite();
    $historique = new Historique();

try
{
    $con = connection();

    //on lance la transaction
    $con->beginTransaction();

    //if ($_GET['provenence'] == 'banque') 
	//{
		/*if ($comptabilite->diminuerMontantEnBanqueVersCaisse($_GET['idProvenence'],$_GET['montantApprovisionne'],$_GET['idcaisseDest']) > 0)
		{
			if ($comptabilite->sortie_banque($_GET['idProvenence'],$_GET['montantApprovisionne'],'approvision',$_GET['nom_caisseDest'],$_GET['datevirement'])) 
			{*/
                if ($comptabilite->setApprovisionnement($_GET['idProvenence'],$_GET['reference'],$_GET['montantApprovisionne'],$_GET['idcaisseDest'],$_GET['datevirement'],$_GET['iduser'])) 
                {
                    if ($comptabilite->setHistoriqueEntrerCaisse('caisse',$_GET['nomProv'],$_GET['montantApprovisionne'],$_GET['monnaieProv'],$_GET['idcaisseDest'],$_GET['datevirement'],$_GET['iduser'])) 
                    {}
                    if ($historique->setHistoriqueAction($_GET['idcaisseDest'],'approvisionnement',$_GET['iduser'],date('Y-m-d'),'creer')) 
                    {
                        //echo "ok";
                    }
                    /*$idAppro = $comptabilite->getLastAprovisionnement()->fetch()['id_appro'];
                    if ($comptabilite->creationDepense($_GET['reference'],$_GET['montantApprovisionne'],$_GET['reference'],$_GET['datevirement'],null,$_GET['idProvenence'],$_GET['iduser'],$idAppro))
                    {
                        if ($comptabilite->setHistoriqueAction($_GET['idcaisseDest'],'caisse',$_GET['userName'],date('Y-m-d'),'approvision')) 
                        {
                            //echo "ok";
                        }
                    }*/
                }
			//} 
		//}
	/*}
	elseif ($_GET['provenence'] == 'caisse') 
	{
		if ($comptabilite->reduireMontantCaisse($_GET['idProvenence'],$_GET['montantApprovisionne']) > 0) 
		{
			if ($comptabilite->encaisser($_GET['idcaisseDest'],$_GET['montantApprovisionne'])) 
			{
				if ($comptabilite->setHistoriqueSortieCaisse($_GET['idProvenence'],$_GET['montantApprovisionne'],'approvision',$_GET['nom_caisseDest'],$_GET['datevirement']))
				{

					if ($comptabilite->setHistoriqueEntrerCaisse('caisse',$_GET['nomProv'],$_GET['montantApprovisionne'],$_GET['monnaieProv'],$_GET['idcaisseDest'],$_GET['datevirement'],$_GET['iduser'])) 
					{
						/*if ($comptabilite->setCaisseAprovCaisse($_GET['idcaisseProv'])) 
						{
							if ($comptabilite->setHistoriqueAction($_GET['idcaisseDest'],'caisse',$_GET['userName'],date('Y-m-d'),'approvision')) 
							{
								echo "ok";
							}
						}*
						if ($comptabilite->setHistoriqueAction($_GET['idcaisseDest'],'caisse',$_GET['userName'],date('Y-m-d'),'approvision')) 
						{
							echo "ok";
						}
					}
				}
			}
		}
	}*/	

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