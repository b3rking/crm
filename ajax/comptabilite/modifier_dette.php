<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

	$comptabilite = new Comptabilite();
	
	
	if ($comptabilite->changer_dette($_GET['id_dette'],$_GET['dette'],$_GET['montant'],$_GET['monnaie'],$_GET['motif'],$_GET['datecreation']) >0) 
	{
		//echo "modification reussie du dette";
		if ($comptabilite->setHistoriqueAction($_GET['id_dette'],'dette',$_GET['userName'],date('Y-m-d'),'modifier')) 
		{
			//echo "histo okkk";
		}
	}
	?>
  
