<?php
require_once("../../model/connection.php");
require_once("../../model/User.class.php");

require_once("../../model/comptabilite.class");

$user = new User();
$comptabilite = new Comptabilite();

if ($user->getTaux()->fetch()) 
{
	//echo "bien on entre";
	if ($user->updateTaux($_GET['taux'],$_GET['description'],date('Y-m-d')))
	{
		
		if ($comptabilite->setHistoriqueAction($_GET['taux'],'taux',$_GET['nomtva'],date('Y-m-d'),'modifier taux'))
	    
		{
			
			echo " Le taux changer avec succes";
		}
	}
}
else
{
	//echo "bien on entre";
	if ($user->creerTaux($_GET['taux'],$_GET['description'],date('Y-m-d')))
	{
		

		if ($comptabilite->setHistoriqueAction($_GET['taux'],'taux',$_GET['nomtva'],date('Y-m-d'),'supprimer taux'))
	    
		{
			echo "Le taux enregistrer avec succes";
		}
	}
}
