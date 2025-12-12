<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php");  

$historique = new Historique();
$equipement = new Equipement();

            
$rs = $equipement->NewPoint_acces($_GET['secteurpa'],$_GET['nompa'],$_GET['ipa'],$_GET['macpa'],$_GET['idAntenne'],$_GET['frequence'],$_GET['ssidpa'],$_GET['ant_limite_pa'],$_GET['user']);

if ($rs != "duplicate") 
{
	if ($equipement->deleteEquipement($_GET['idAntenne'])) 
	{
		if ($equipement->deleteMacAdresse($_GET['idAntenne'])) 
		{
			$id = $equipement->getMaxIdPointAccess()->fetch()['ID_point_acces'];
			if ($historique->setHistoriqueAction($id,'pointAcces',$_GET['iduser'],date('Y-m-d'),'creer')) 
			{
				require_once("reponsePointAcces.php");
			}
		}
	}
}
else
{
	echo 'Duplication de l\'IP';
}
?>