<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

	$comptabilite = new Comptabilite();
	$provenance = '';
	/*fonction pour reduire la dette*/
	$refdette = preg_split("#[_]+#", $_GET['refdette']);
	for ($i=0; $i < count($refdette); $i++) 
	{
		$idDette = preg_split("#[-]+#", $refdette[$i])[0];
		$montantDette = preg_split("#[-]+#", $refdette[$i])[1];
		//echo "idDette : ".$idDette." montantDette: ".$montantDette;
		if($comptabilite->diminuer_dette($idDette,$montantDette))
		{
			//echo "dette payer\n";
			$msg = "ok";
		}
	}
	
	if (!empty($_GET['refcaisse'])) 
	{
		$refcaisse = preg_split("#[_]+#", $_GET['refcaisse']);
		for ($i=0; $i < count($refcaisse); $i++) 
		{
			$idCaisse = preg_split("#[-]+#", $refcaisse[$i])[0];
			$montantCaisse = preg_split("#[-]+#", $refcaisse[$i])[1];
			$nomCaisse = preg_split("#[-]+#", $refcaisse[$i])[2];
			$provenance .= $nomCaisse.' : '.$montantCaisse.' , ';
			//echo "idDette : ".$idDette." montantDette: ".$montantDette;
			if ($comptabilite->reduireMontantCaisse($idCaisse,$montantCaisse)) 
			{
				if ($comptabilite->setHistoriqueSortieCaisse($idCaisse,$montantCaisse,'dette','dette',date('Y-m-d')))
				{
					$msg = "ok";
					//echo "ok";
				}
				//echo "payement par la caisse";
			}
		}
	}
	if (!empty($_GET['refbanque'])) 
	{
		$refbanque = preg_split("#[_]+#", $_GET['refbanque']);
		for ($i=0; $i < count($refbanque); $i++) 
		{
			$idbanque = preg_split("#[-]+#", $refbanque[$i])[0];
			$montantBanque = preg_split("#[-]+#", $refbanque[$i])[1];
			$nomBanque = preg_split("#[-]+#", $refbanque[$i])[2];
			$provenance .= $nomBanque.' : '.$montantBanque.' , ';
			//echo "idbanque : ".$idbanque.;
			if ($comptabilite->diminuerMontantEnBanque($idbanque,$montantBanque)) 
			{
				if ($comptabilite->sortie_banque($idbanque,$montantBanque,'dette','dette',date('Y-m-d'))) 
				{
					$msg = "ok";
					//echo "ok";
				}
				//echo "payement par la banque";
			}
		}
	}
	if ($comptabilite->setHistorique_dette_paye($_GET['tb_descriptionDette'],$_GET['detteTotale'],$_GET['monnaie'],date('Y-m-d'),$provenance,$_GET['userName'])) 
	{
		//echo "insertion reussie de l'historique";
		if ($comptabilite->setHistoriqueAction($idDette,'dette',$_GET['userName'],date('Y-m-d'),'creer')) 
		{
			$msg = "ok";
		}
	}
	echo $msg;
	/*if($comptabilite->diminuer_dette($_GET['refdette'],$_GET['detteTotale']))
	{
		/*fonction pour diminuer le montant en banque*
		if ($comptabilite->diminuerMontantEnBanque($_GET['refbanque'],$_GET['sommeTotalebanque'])) 
		{
			/*fonction pour reduire le montant en caisse*
			if ($comptabilite->reduireMontantCaisse($_GET['refcaisse'],$_GET['sommeTotalebanque'])) 
			{
				 /*fonction pour reduire la dette*
				if ($comptabilite->historique_dette_paye($_GET['nomss'],$_GET['detteTotale'],date('Y-m-d'))) 
				{
					if ($comptabilite->setHistoriqueAction($_GET['refdette'],'dette',$_GET['userName'],date('Y-m-d'),'creer')) 
						{
							//require_once('repcompteComptable.php');
						}
				}
			}
		}
	}*/

//refdette"+tb_refdette+"&tb_descriptionDette="+tb_descriptionDette+"&tb_montantDette="+tb_montantDette+"&refbanque="+tb_refbanque+"&tb_montantBanque="+tb_montantBanque+"&refcaisse="+tb_refcaisse+"&tb_montantCaisse="+tb_montantCaisse+"&sommeTotalebanque="+sommeTotalebanque+"&detteTotale="+detteTotale+"&userName="+userName
	 
  
