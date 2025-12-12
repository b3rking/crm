<?php
require_once("model/typeClient.class.php");
require_once('model/User.class.php');

function typeClient()
{
	$user = new User();
	$type = new TypeClient();
	require_once('vue/admin/typeClient/typeClient.php');
}