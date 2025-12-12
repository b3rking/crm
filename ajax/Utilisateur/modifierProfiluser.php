<?php
require_once("../../model/connection.php");
require_once("../../model/User.class.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();
$user = new User();

if ($user->modifier_profil($_GET['idprof'],$_GET['nomprofil'])) 
{
	if ($comptabilite->setHistoriqueAction($_GET['idprof'],'utilisateur',$_GET['nom_update'],date('Y-m-d'),'modifier profil'))
	{
		require_once('repoMprofil.php');
	}
}
?>
