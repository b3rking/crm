<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

if ($comptabilite->supprimerPetitedepense($_GET['iddepense']))  
{
    if ($comptabilite->augmenterMontantCaisse($_GET['oldCaisse'],$_GET['oldMontant']) > 0) 
	{
		if ($comptabilite->addPetiteDepense($_GET['montant'],$_GET['monnaie'],$_GET['motif'],$_GET['datedepense'],$_GET['idcategorie'],$_GET['newCaisse'],$_GET['iduser']))
		{
			if ($comptabilite->reduireMontantCaisse($_GET['newCaisse'],$_GET['montant']) > 0) 
			{
				//if ($comptabilite->setBanqueDepense($_GET['idprovenance']))
				//{
					if ($comptabilite->setHistoriqueSortieCaisse($_GET['newCaisse'],$_GET['montant'],$_GET['motif'],$_GET['descriptionCategorie'],$_GET['datedepense'])) 
					{
						$id = $comptabilite->getMaxIdPetiteDepense()->fetch()['ID_depense'];
						if ($comptabilite->setHistoriqueAction($id,'depense',$_GET['userName'],date('Y-m-d'),'modifier')) 
						{
							//echo "ok";
						}
					}
				//}
					//require_once('reponsedepenseAdmin.php');
			}
		}
	}
}

/*if ($comptabilite->updatedepense($_GET['iddepense'],$_GET['datedepense'],$_GET['motif'],$_GET['idcategorie'],$_GET['reference']) > 0)  
{
	if ($comptabilite->setHistoriqueAction($_GET['iddepense'],'depense',$_GET['userName'],date('Y-m-d'),'modifier')) 
	{
		//echo "ok";
	}
	//require_once('reponsedepenseAdmin.php');
}*/
//iddepense="+iddepense+"&datedepense="+datedepense+"&motif="+motif+"&idcategorie="+idCategorie+"&descriptionCategorie="+descriptionCategorie+"&oldCaisse="+oldCaisse+"&oldMontant="+oldMontant+"&newCaisse="+idCaisse+"&montant="+montant+"&monnaie="+monnaie+"&userName="+userName+"&iduser="+iduser