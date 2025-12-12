 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/User.class.php");
	require_once("../../model/comptabilite.class.php");
    $comptabilite = new Comptabilite();

	$user = new User();

	if($user->UpdateUser($_GET['iduser'],$_GET['nomuser'],$_GET['mail_user'],$_GET['role']) > 0)
	{
	    if ($comptabilite->setHistoriqueAction($_GET['iduser'],'utilisateur',$_GET['userName'],date('Y-m-d'),'modifier')) 
		{
			require_once('rep.php');
		}
	}
