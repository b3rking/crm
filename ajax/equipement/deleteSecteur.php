<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php");  

$historique = new Historique();
$equipement = new Equipement();

if($equipement->suppressionSecteur($_GET['id_secteur']) > 0)
{
    if ($historique->setHistoriqueAction($_GET['id_secteur'],'secteur',$_GET['iduser'],date('Y-m-d'),'supprimer')) 
	{
		//require_once('repSecteur.php');
	}
}
//$home_admin_content = ob_get_clean();
//require_once('vue/admin/home.admin.php');
?>