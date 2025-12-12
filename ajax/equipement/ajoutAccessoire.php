<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php");  

$historique = new Historique();
$equipement = new Equipement();
//$mouvement = 'entree';
/*$accessoire_exist = false;
foreach ($equipement->recupererAccessoire($_GET['categorie_id']) as $value) 
{
	$accessoire_exist = true;
	if ($equipement->AugmenterQuantiteAccesoir($value->ID_accessoire,$_GET['quantite'])) 
	{
		if($equipement->SetHisto_accessoire($value->ID_accessoire,$_GET['quantite'],$_GET['commentaire'],$_GET['date_entre'],$_GET['iduser'],null,null,'entree'))
		{
			if ($historique->setHistoriqueAction($value->ID_accessoire,'accessoire',$_GET['iduser'],date('Y-m-d'),'creer')) 
			{
				//require_once('reponseAccessoire.php');
			}
		}
	}
}
if (!$accessoire_exist)
{
	if ($equipement->ajouterAccessoire($_GET['categorie_id'],$_GET['quantite'],$_GET['commentaire'],$_GET['date_entre']))
	{
		$id = $equipement->getMaxIdAccessoire()->fetch()['ID_accessoire'];
		if ($equipement->SetHisto_accessoire($id,$_GET['quantite'],$_GET['commentaire'],$_GET['date_entre'],$_GET['iduser'],null,null,'entree')) 
		{
			if ($historique->setHistoriqueAction($id,'accessoire',$_GET['iduser'],date('Y-m-d'),'creer')) 
			{
				//require_once('reponseAccessoire.php');
			}
		}
	}
}*/
if ($equipement->ajouterAccessoire($_GET['categorie_id'],$_GET['quantite'],$_GET['commentaire'],$_GET['date_entre'],$_GET['iduser'],'entree'))
{
	$id = $equipement->getMaxIdAccessoire()->fetch()['accessory_journal_id'];
	if ($historique->setHistoriqueAction($id,'accessoire',$_GET['iduser'],date('Y-m-d'),'creer')) 
	{
		//require_once('reponseAccessoire.php');
	}
}
