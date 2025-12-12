 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/User.class.php");
	require_once("../../model/historique.class.php");

    $historique = new Historique();
	$user = new User();

	date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");
    //$started_at = date('H:i:s');

	if($user->update_profil($_GET['iduser'],$_GET['profil_id']) > 0)
	{
		if ($historique->setHistoriqueAction($_GET['profil_id'],'utilisateur',$_GET['iduser'],$created_at,'modifier profil'))
		{}
	    //require_once('repprofil.php');
	}
