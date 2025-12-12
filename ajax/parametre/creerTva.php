<?php
require_once("../../model/connection.php");
require_once("../../model/User.class.php");
require_once("../../model/comptabilite.class");

$user = new User();
$comptabilite = new Comptabilite();

if ($user->getTva()->fetch()) 
{
	if ($user->updateTva($_GET['tva'],$_GET['description'],date('Y-m-d')))
	{
		if ($comptabilite->setHistoriqueAction($_GET['tva'],'tva',$_GET['nomtva'],date('Y-m-d'),'modifier tva'))
	    
		{
			
			echo " Le tva a été changer avec succes";
		}
	}
}
else
{
	if ($user->cree_tva($_GET['tva'],$_GET['description'],$_GET['datetva']))
	{
		if ($comptabilite->setHistoriqueAction($_GET['tva'],'tva',$_GET['nomtva'],date('Y-m-d'),'creer tva'))
	    
		{
		echo "Le tva a été enregistrer avec succes";
	    }
	}
}
