<?php
require_once("model/User.class.php");
function infoSocieteView()
{
	$user = new User();
	require_once 'vue/admin/societe/info.php';
}