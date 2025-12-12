<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

  

	$comptabilite = new Comptabilite();
//echo $_GET['montant'].'/'.$_GET['type_extrat']. '/' .$_GET['idbanque'].'/'.$_GET['date_extrat'].'/ '.$_GET['utilisateur'].'/'.$_GET['description'];

	if ($_GET['destination'] == 'banque') 
	{	
		if ($comptabilite->creationExtrat($_GET['montant'],$_GET['type_extrat'],$_GET['idbanque'],$_GET['date_extrat'],$_GET['utilisateur'],$_GET['description'])) 
		{
			if ($comptabilite->AugmenterMontantbanque($_GET['idbanque'],$_GET['type_extrat']) > 0)
			{
				echo "L'approvinnement dans la banque reussi avec succes";
			}
		}
	}
	elseif ($_GET['destination'] == 'caisse') 
	{	
		if ($comptabilite->creationExtrat($_GET['montant'],$_GET['type_extrat'],$_GET['idcaisse'],$_GET['date_extrat'],$_GET['utilisateur'],$_GET['description'])) 
		{
			if ($comptabilite->encaissergrandeCaisse($_GET['idcaisse'],$_GET['type_extrat']) > 0)
			{
				echo "L'approvionnement reussi";
			}
		}	
	}	
?>
