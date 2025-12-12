<?php
require_once("../../model/connection.php");
require_once("../../model/User.class.php");
require_once("../../model/historique.class.php");

$user = new User();
$historique = new Historique();

//$idUser = preg_split("#[-]+#", $_GET['idUser']);

if ($user->ajout_User($_GET['nomuser'],$_GET['mail_user'],$_GET['prenom'],$_GET['password'],$_GET['profil_id'],$_GET['login'],date('Y-m-d'),$_GET['etat'])) 
{
	//require_once('rep.php');
	$idAction = $user->getLastUser()->fetch()['ID_user'];
	if ($historique->setHistoriqueAction($idAction,'utilisateur',$_GET['iduser'],date('Y-m-d'),'creer')) 
	{
		//echo "Creation reussie";
	}
}


