<?php
require_once("model/client.class.php");
require_once("model/localisation.class.php"); 
require_once 'model/contract.class.php';
require_once("model/comptabilite.class.php");
require_once("model/User.class.php");
require_once('model/ticket.class.php');
require_once('model/equipement.class.php');

function inc_dashboard()
{
	$contract = new Contract();
	$equipement = new Equipement();
	$client = new Client();
	$localisation = new Localisation();
	$data = $client->totalClientParType();
	$comptabilite = new Comptabilite();
	$user = new User();
	$ticket = new Ticket();

	$data_local = array();
	$query_local = $localisation->nombreClientParLocalisation();
	foreach ($query_local as $value) 
	{
		$data_local[] = array(
		'label'  => $value->nom_localisation,
		'value'  => $value->nb
		);
	}
	$data_local = json_encode($data_local);
	$profil_name = '';
	$profil_id; 
	foreach ($user->afficheprofilUser($_SESSION['ID_user']) as $value) 
	{
		$profil_id = $value->profil_id;
		$profil_name = $value->profil_name;
		$_SESSION['profil_name'] = $value->profil_name;
	}
	$profil = $user->getDashboardPage($profil_id)->fetch();
	if (!empty($profil['page'])) 
	{
		$_SESSION['dashboardPage'] = $profil['page'];
		$page = 'vue/'.$profil['page'].'.php';
		require_once $page;
	}
	else require_once 'vue/admin/home.admin.php';
	/*if ($profil_name == 'DirectionCommercial')
		require_once'vue/dashboardComptabilite.php';
	else
	require_once 'vue/dashboard.php';*/
}
function inc_dashboardByPage($page)
{
	$contract = new Contract();
	$equipement = new Equipement();
	$client = new Client();
	$localisation = new Localisation();
	$data = $client->totalClientParType();
	$comptabilite = new Comptabilite();
	$user = new User();
	$ticket = new Ticket();

	$data_local = array();
	$query_local = $localisation->nombreClientParLocalisation();
	foreach ($query_local as $value) 
	{
		$data_local[] = array(
		'label'  => $value->nom_localisation,
		'value'  => $value->nb
		);
	}
	$data_local = json_encode($data_local);
    require_once'vue/'.$page.'.php';
}
function printClientActif()
{
	$contract = new Contract();
	$equipement = new Equipement();
	$client = new Client();
	$localisation = new Localisation();
	$data = $client->totalClientParType();
	$comptabilite = new Comptabilite();
	$user = new User();
	$ticket = new Ticket();
	require_once('printing/fiches/printClientActif.php');
}