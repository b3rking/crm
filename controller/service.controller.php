<?php
require_once("model/typeClient.class.php");
require_once("model/service.class.php");
require_once('model/User.class.php');
function service()
{
	$user = new User();
	$type = new TypeClient();
	$service = new Service();
	require_once('vue/admin/service/service.php');
}
?>