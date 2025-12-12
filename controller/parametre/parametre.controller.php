<?php
require_once("model/typeClient.class.php");
require_once('model/User.class.php');
function parametre()
{
	$type = new TypeClient();
	require_once('vue/admin/parametre/parametre.php');
}

function viewTaux()
{
	$user = new User();
	require_once('vue/admin/parametre/viewTaux.php');
}

function tva()
{
	$user = new User();
	require_once('vue/admin/parametre/tva.php');
}

?>