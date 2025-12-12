<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");

$contract = new Contract();
$client = new Client();

if ($contract->update_cutoff_list($_GET['date_coupure'],$_GET['confirmed'],$_GET['cutoff_id'])) 
{
	if ($_GET['confirmed'] == 'oui') 
	{
		foreach ($contract->get_Clients_by_cutoff_id($_GET['cutoff_id'],'couper') as $value) 
		{
			if ($client->updateTypeAndEtat($value->customer_id,$type_client='paying',$etat='coupure') > 0) 
	    	{
	    		if ($contract->updateEtatContract($value->customer_id,'suspension') > 0) 
    			{}
	    	}
		}
	}
}
