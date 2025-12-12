<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

	$comptabilite = new Comptabilite();

	
	if ($comptabilite->suppression_dette($_GET['id_dette']) >0) 
	{
		//echo "modification reussie du dette";
		if ($comptabilite->setHistoriqueAction($_GET['id_dette'],'dette',$_GET['userName'],date('Y-m-d'),'supprimer')) 
		{
			//echo "histo okkk";
		}
	}
	?>
  