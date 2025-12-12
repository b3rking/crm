<?php
require_once("model/User.class.php");

function inc_utilisateur()
{
	$user = new User();
	require_once('vue/admin/utilisateur/utilisateur.php');
}
function monprofil()
{
	$user = new User();
	require_once('vue/admin/utilisateur/mon_profil.php');
}
function afficherMessage($message,$url)
{
	$user = new User();
	require_once $url;
}
function Changer_motpasse()
{
	$user = new User();
	require_once('vue/admin/utilisateur/update_mot_passe.php');
}
function setProfilUser($profile_name,$page,$l,$c,$m,$s,$i,$page_accept,$nb)
{
	$user = new User();

	$res = $user->setProfil_user($profile_name);
	if ($res[1] == 1062) 
	{
		$profil = $user->getMaxProfilIdUser()->fetch();
		if ($user->setProfil_user_permession($profil['profil_id'],$page,$l,$c,$m,$s,$page_accept))
		{
			if ($i == $nb - 1) 
			{
				$msg = 'Le profil :'.$profile_name.' cree avec succes';
				header('location:utilisateur');
			}
		}
	}
	else
	{
		$profil = $user->getMaxProfilIdUser()->fetch();
		if ($user->setProfil_user_permession($profil['profil_id'],$page,$l,$c,$m,$s,$page_accept))
		{
			if ($i == $nb - 1) 
			{
				$msg = 'Le profil :'.$profile_name.' cree avec succes';
				header('location:utilisateur');
			}
		}
	}
}
function voir_profil()
{
	$user = new User();

	require_once('vue/admin/utilisateur/affiche_profil.php');
}
function modification()
{
	$user = new User();

	require_once('vue/admin/utilisateur/modification_suppression_profil.php');
}
function voir_utilisateur()
{
	$user = new User();

	require_once('vue/admin/utilisateur/affiche_utilisateur.php');
}
function gestion_dashboard()
{
	$user = new User();
	require_once 'vue/admin/utilisateur/gestion_dashboard.php';
}
function societe()
{
	$user = new User();
	require_once 'vue/admin/utilisateur/societe.php';

}
function fourniseur()
{
	$user =new User();
	require_once 'vue/admin/utilisateur/fournisseur.php';
}
function creerphoto_profil($idutilisateur,$fileTmpName,$uploadPath,$fileName)
{
	
	$user = new User();
	//echo "Bonjour".$idutilisateur.$nomphoto.$fileTmpName.$uploadPath.$fileName;
	//$iduser = preg_split("#[-]+#", $idutilisateur);
	 
    //$idutilisateur[0];

	//echo 'fileTmpName: '.$fileTmpName.' uploadPath: '.$uploadPath.' fileName: '.$fileName;
	$didUpload = move_uploaded_file($fileTmpName, $uploadPath);
	if ($didUpload) 
	{
		
		$photo = basename($fileName);
		//echo "idutilisateur : ".$idutilisateur." nom :".$nom." fichier : ".$fichier;
		if ($user->modifierphotoprofil($idutilisateur,$photo))
		{
			//echo 'upload reussie';
			//$user = new User();
			//$msg = "La creation reussie";
			header("location:monprofil-".$_SESSION['ID_user']);
			//require_once('vue/admin/utilisateur/mon_profil.php');
		}
	}
	else
	{	$user = new User();
		$message = "La photo ".basename($fileName)." n'est pas chargé";
		require_once('vue/admin/utilisateur/mon_profil.php');
	}
}