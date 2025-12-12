<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

	$comptabilite = new Comptabilite();

	if ($comptabilite->updateExtrat($_GET['id_extrat'],$_GET['montant'],/*$_GET['id_type_extrat']*/$_GET['date_extrat'],$_GET['idUser'],$_GET['description']) > 0) 
	{
		if ($comptabilite->setHistoriqueAction($_GET['id_extrat'],'extrat',$_GET['userName'],date('Y-m-d'),'modifier')) 
		{
			echo "ok";
		}
	}
	//id_extrat="+id_extrat+"&montant="+montant+"&idDestination="+idDestination+"&id_type_extrat="+id_type_extrat+"&date_extrat="+date_extrat+"&user="+idUser+"&description="+description+"&destination="+destination