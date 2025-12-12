 
<?php
	require_once("../../model/connection.php");
	require_once("../../model/User.class.php");
	require_once("../../model/comptabilite.class.php");
	
    $comptabilite = new Comptabilite();

	$user = new User();

	if($user->deleteUser($_GET['iduser']) > 0)
	{
		if ($comptabilite->setHistoriqueAction($_GET['iduser'],'utilisateur',$_GET['userName'],date('Y-m-d'),'supprimer')) 
		{
			require_once('rep.php');
		}
	}

     