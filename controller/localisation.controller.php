
<?php
require_once("model/localisation.class.php");
require_once('model/User.class.php');

function inc_location()
{
	$user = new User();
	$localisation = new Localisation();
	require_once('vue/admin/localisation/localisation.php');
}