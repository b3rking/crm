<?php
require_once("model/vehicule.class.php");
require_once('model/User.class.php');

function inc_vehicule()
{
	$vehicule = new Vehicule();
	$user = new User();
	require_once('vue/admin/vehicule/vehicule.php');
}
?>