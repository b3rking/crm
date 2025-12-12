 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/User.class.php");
	require_once("../../model/comptabilite.class.php");
    $comptabilite = new Comptabilite();

	$user = new User();

	if($user->deletecet_utilisateur($_GET['iduser_delete']) > 0)
	{
		if ($comptabilite->setHistoriqueAction($_GET['iduser_delete'],'utilisateur',$_GET['effaceur'],date('Y-m-d'),'supprimer user'))
		{
	    require_once('repprofil.php');
	}
	}
