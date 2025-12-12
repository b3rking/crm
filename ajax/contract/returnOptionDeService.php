<?php
require_once("../../model/connection.php");
require_once("../../model/service.class.php");

$service = new Service();

foreach ($service->recupererServices() as $value) 
{
?>
	<option value="<?=$value->ID_service?>"><?=$value->nomService?></option>
<?php
}
?>