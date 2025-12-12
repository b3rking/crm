<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/contract.class.php");
require_once("../../model/historique.class.php");
  

	$comptabilite = new Comptabilite();
	$contract = new Contract();
    $historique = new Historique();

    date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");
    //$started_at = date('H:i:s');
	/*if ($_GET['destination'] == 'banque') 
	{
		if ($comptabilite->creationExtrat($_GET['idtype'],$_GET['montant'],$_GET['monnaie'],$_GET['destination'],$_GET['date_extrat'],$_GET['utilisateur'],$_GET['description'])) 
		{
			if ($comptabilite->AugmenterMontantbanque($_GET['idDestination'],$_GET['montant']) > 0)
			{
				if ($comptabilite->setBanqueExtrat($_GET['idDestination'])) 
				{
					if ($comptabilite->setHistoriqueEntrerBanque($_GET['idDestination'],$_GET['montant'],$_GET['libelleType'],$_GET['date_extrat'])) 
					{
						$id = $comptabilite->getMaxIdExtrat()->fetch()['ID_extrat'];
						if ($comptabilite->setHistoriqueAction($id,'extrat',$_GET['userName'],date('Y-m-d'),'creer')) 
						{
							if ($contract->saveCautionClient($_GET['idclient'],$_GET['montant'],$_GET['monnaie'],$_GET['date_extrat'],$_GET['userName'],$_GET['description'])) 
							{
								echo "ok";
							}
						}
					}
				}
			}
		}
	}
	elseif ($_GET['destination'] == 'caisse') 
	{	
		if ($comptabilite->creationExtrat($_GET['idtype'],$_GET['montant'],$_GET['monnaie'],$_GET['destination'],$_GET['date_extrat'],$_GET['utilisateur'],$_GET['description'])) 
		{
			if ($comptabilite->encaisser($_GET['idDestination'],$_GET['montant']) > 0)
			{
				if ($comptabilite->setCaisseExtrat($_GET['idDestination'])) 
				{
					if ($comptabilite->setHistoriqueEntrerCaisse('extrat',$_GET['libelleType'],$_GET['montant'],$_GET['monnaie'],$_GET['idDestination'],date('Y-m-d'),$_GET['utilisateur'])) 
					{
						$id = $comptabilite->getMaxIdExtrat()->fetch()['ID_extrat'];
						if ($comptabilite->setHistoriqueAction($id,'extrat',$_GET['userName'],date('Y-m-d'),'creer')) 
						{
							if ($contract->saveCautionClient($_GET['idclient'],$_GET['montant'],$_GET['monnaie'],$_GET['date_extrat'],$_GET['userName'],$_GET['description'])) 
							{
								echo "ok";
							}
						}
					}
				}
			}
		}	
	}*/

	if ($comptabilite->creationExtrat($_GET['idDestination'],$_GET['description'],$_GET['date_extrat'],$_GET['iduser'],$_GET['montant']))  
	{
		//if ($comptabilite->augmanterMontantBanque($_GET['idDestination'],$_GET['montant']) > 0)
		//{
			$id = $comptabilite->getMaxIdExtrat()->fetch()['ID_extrat'];
			if ($historique->setHistoriqueAction($id,'extrat',$_GET['iduser'],$created_at,'creer')) 
			{}
		//}
	}

//montant="+montant+"&monnaie="+monnaie_extrat+"&idDestination="+idDestination+"&date_extrat="+date_extrat+"&utilisateur="+iduser+"&description="+description+"&userName="+userName
