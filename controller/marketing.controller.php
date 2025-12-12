<?php
require_once('model/User.class.php');

require_once('model/marketing.class.php');


function marketing()
{
	$marketing = new Marketing();
	
	require_once('vue/admin/marketing/dashboardMarketing.php');
} 
function prospection()
{   $user = new User();
	$marketing = new Marketing();
    $users = $user->afficheUsers();

    if($_SESSION['profil_id'] == 832 || $_SESSION['profil_id'] == 834)
        $result = $marketing->afficheProspect();
    else
	$result = $marketing->getProspectsByUser($_SESSION['ID_user']);
    $result = $marketing->afficheProspect();
	require_once('vue/admin/marketing/prospection.php');
}
function filtreProspect($nom,$dateprospection,$daterendezvous,$status,$suivi_par)
{
	$marketing = new marketing();
    $user = new User();
    $users = $user->afficheUsers();

	$condition1 = $nom == '' ? '' : "AND nom LIKE '%".$nom."%' ";
	$condition2 = $dateprospection == ''? '' : "AND dateProspection='".$dateprospection."' ";
	$condition3 = $status == '' ? '' : "AND etatduProspect='".$status."' ";
    $condition4 = $suivi_par == '' ? '' : " AND u.ID_user=".$suivi_par." ";
	//$condition4 = $daterendezvous == '' ? '' : " rendezvous='".$daterendezvous."' ";

	$condition = $condition1.$condition2.$condition3.$condition4;
	//$condition = substr($condition,3);
    
    if($_SESSION['profil_id'] == 832 || $_SESSION['profil_id'] == 834){}
    else
       	$condition .= " AND ID_user= ".$_SESSION['ID_user']." ";
	$result = $marketing->filtreProspect($condition);
	require_once('vue/admin/marketing/prospection.php');
}
function agenda()
{
	$marketing = new Marketing();
	require_once('vue/admin/marketing/agenda.php');
}
function ajoutstock()
{
	$marketing = new Marketing();
	require_once('vue/admin/marketing/stock.php');
}

function sponsor()
{
	$marketing = new Marketing();
	require_once('vue/admin/marketing/sponsor.php');
}
function visibilite()
{
	$marketing = new Marketing();
	require_once('vue/admin/marketing/visibilite.php');
}
function affichestock()
{
	$marketing = new Marketing();
	require_once('vue/admin/marketing/stock.php');
}
function visiteclient()
{
	$marketing = new Marketing();
	require_once('vue/admin/marketing/visiteClient.php');
}
function validationProspect()
{
	$marketing = new Marketing();
	require_once('vue/admin/marketing/validationProspect.php');
}
function detailprospect($id)
{
	$marketing = new Marketing();
	require_once('vue/admin/marketing/detailProspect.php');
}
function attribution_materielSponsor()
{
	$marketing = new Marketing();
	
	require_once('vue/admin/marketing/atribution_materielsSponsor.php');

}




















?>