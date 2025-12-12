
<?php
	require_once("../../model/connection.php");
	require_once("../../model/User.class.php");
	require_once("../../model/comptabilite.class.php");
    $comptabilite = new Comptabilite();

	$user = new User();

	if($user->update_etat($_GET['iduser'],$_GET['etat']) > 0)
	{
	    //require_once('rep.php');
	    if ($comptabilite->setHistoriqueAction($_GET['iduser'],'utilisateur',$_GET['desactivateur'],date('Y-m-d'),'desactiver utilisateur'))
	    {
	    	
	    }
	}
