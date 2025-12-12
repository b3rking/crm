
<?php
	require_once("../../model/connection.php");
	require_once("../../model/User.class.php");

	$user = new User();

	if($user->updatePasswordByToken($_GET['password'],$_GET['token']) > 0)
	{
	}
