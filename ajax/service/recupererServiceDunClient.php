<?php
require_once("../../model/connection.php");
require_once("../../model/service.class.php");

	$service = new Service();
	$idclient = preg_split("#[-]+#", $_GET['idclient']);
	foreach ($service->recupererServiceDunClient($idclient[1]) as $value) 
	{
?>
		<option value="<?=$value->nomService?>"><?=$value->nomService?></option>
<?php
	}
?>