<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");


$comptabilite = new Comptabilite();
$historique = new Historique();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');
if ($comptabilite->supprimerdepense($_GET['iddepense']))  
{
    //if ($comptabilite->augmanterMontantBanque($_GET['oldBanque'],$_GET['oldMontant']) > 0) 
	//{

		if ($comptabilite->creationDepense($_GET['reference'],$_GET['montant'],$_GET['motif'],$_GET['datedepense'],$_GET['idcategorie'],$_GET['newBanque'],$_GET['iduser']))
		{
			//if ($comptabilite->reduireMontantEnBanque($_GET['newBanque'],$_GET['montant']) > 0) 
			//{
				//if ($comptabilite->setBanqueDepense($_GET['idprovenance']))
				//{
					//if ($comptabilite->sortie_banque ($_GET['newBanque'],$_GET['montant'],$_GET['motif'],$_GET['descriptionCategorie'],$_GET['datedepense'])) 
					//{
						$id = $comptabilite->getMaxIdDepense()->fetch()['ID_depense'];
						if ($historique->setHistoriqueAction($id,'depense',$_GET['iduser'],$created_at,'modifier')) 
						{
							//echo "ok";
						}
					//}
				//}
					//require_once('reponsedepenseAdmin.php');
			//}
		}
	//}
}

/*if ($comptabilite->updatedepense($_GET['iddepense'],$_GET['datedepense'],$_GET['motif'],$_GET['idcategorie'],$_GET['reference']) > 0)  
{
	if ($comptabilite->setHistoriqueAction($_GET['iddepense'],'depense',$_GET['userName'],date('Y-m-d'),'modifier')) 
	{
		//echo "ok";
	}
	//require_once('reponsedepenseAdmin.php');
}*/
//iddepense="+iddepense+"&datedepense="+datedepense+"&motif="+motif+"&idcategorie="+idcategorie+"&reference="+reference+"&oldBanque="+oldBanque+"&oldMontant="+oldMontant+"&newBanque="+idBanque+"&montant="+montant+idcategorie="+idCategorie+"&descriptionCategorie="+descriptionCategorie