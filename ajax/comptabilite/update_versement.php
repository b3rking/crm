<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
require_once("../../model/historique.class.php");

$comptabilite = new Comptabilite();
$historique = new Historique();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');

//if ($_GET['montant_total'] > 0) 
//{
	$tb_paiement = preg_split("#[_]+#", $_GET['paiement']);
	//if ($_GET['destination'] == 'banque') 
	//{
		//if ($comptabilite->diminuerMontantEnBanque($_GET['iddestination'],$_GET['montant_total']) > 0) 
		//{
			if ($comptabilite->diminuerMontant_dans_versement($_GET['idversement'],$_GET['montant_total']) > 0) 
			{
				if ($comptabilite->update_Versement($_GET['idversement'],$_GET['reference'],$_GET['dateversement'],$_GET['idbanque']) > 0) 
				{
					for ($i=0; $i < count($tb_paiement); $i++) 
					{ 
						if ($comptabilite->delete_from_paiement_verser($tb_paiement[$i])) 
						{
							if ($comptabilite->updatePayementDeposed($tb_paiement[$i],NULL,0) > 0) 
							{
						        # code...
						    }
						}
					}
					if ($historique->setHistoriqueAction($_GET['idversement'],'versement',$_GET['iduser'],$created_at,'modifier')) 
					{
						//$return = "ok";
					}
				}
			}
		//}
	//}
	/*else
	{
		if ($comptabilite->diminuerMontantCaisse($_GET['iddestination'],$_GET['montant_total']) > 0) 
		{
			if ($comptabilite->diminuerMontant_dans_versement($_GET['idversement'],$_GET['montant_total']) > 0) 
			{
				if ($comptabilite->update_Versement($_GET['idversement'],$_GET['reference'],$_GET['dateversement']) > 0) 
				{
					for ($i=0; $i < count($tb_paiement); $i++) 
					{ 
						if ($comptabilite->delete_from_paiement_verser($tb_paiement[$i])) 
						{
							$return = "ok";
						}
					}
					if ($comptabilite->setHistoriqueAction($_GET['idversement'],'versement',$_GET['userName'],date('Y-m-d'),'modifier')) 
					{
						$return = "ok";
					}
				}
			}
		}
	}*/
/*}
else
{
	if ($comptabilite->update_Versement($_GET['idversement'],$_GET['reference'],$_GET['dateversement']) > 0) 
	{
		if ($comptabilite->setHistoriqueAction($_GET['idversement'],'versement',$_GET['userName'],date('Y-m-d'),'modifier')) 
		{
			$return = "ok";
		}
	}
}
echo $return;*/

//idversement="+idversement+"&reference="+reference+"&idbanque="+idbanque+"&dateversement="+dateversement+"&montant_total="+montant_payement_decocher+"&monnaie="+new_monnaie_banque+"&paiement="+paiement+"&userName="+userName