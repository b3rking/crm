<?php
require_once("../../model/connection.php");
require_once("../../model/User.class.php");
require_once("../../model/comptabilite.class.php");
    $comptabilite = new Comptabilite();

$user = new User();

//$idUser = preg_split("#[-]+#", $_GET['idUser']);

if ($user->supprimeprofil($_GET['numprof'])) 
{
	if ($comptabilite->setHistoriqueAction($_GET['numprof'],'utilisateur',$_GET['user_del'],date('Y-m-d'),'supprimer profil'))
	{
	require_once('repoMprofil.php');
		}
}
?>


