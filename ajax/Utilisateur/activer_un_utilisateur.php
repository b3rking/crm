
<?php
	require_once("../../model/connection.php");
	require_once("../../model/User.class.php");
    require_once("../../model/comptabilite.class.php");

    $comptabilite = new Comptabilite();

	$user = new User();

	if($user->update_user_desactiver($_GET['iduser'],$_GET['new_etat']) > 0)
	{
	    if ($comptabilite->setHistoriqueAction($_GET['iduser'],'utilisateur',$_GET['activateur'],date('Y-m-d'),'activer utilisateur')) 
		{
			
		}
	}
