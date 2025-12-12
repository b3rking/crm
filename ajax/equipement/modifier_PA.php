<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php");   

$historique = new Historique();
$equipement = new Equipement();

if($equipement->update_point_acces($_GET['idpa'],$_GET['nompa'],$_GET['frequence'],$_GET['ipa'],$_GET['ant_limite_pa'],$_GET['ssidpa'],$_GET['mac_adress']) > 0) 
{
	if ($historique->setHistoriqueAction($_GET['idpa'],'pointAcces',$_GET['iduser'],date('Y-m-d'),'modifier')) 
	{
		//require_once("reponsePointAcces.php");
	}
}

?>