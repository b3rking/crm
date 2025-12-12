<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();

if ($contract->delete_cutoff_list($_GET['cutoff_id'])) 
{
	
}

