<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/ticket.class.php");
require_once("../../model/client.class.php");

$contract = new Contract();
$client = new Client();

if ($contract->setCutoff($_GET['date_coupure'],'non')) 
{
	$cutoff_id = $contract->get_max_cutoff_id();
	foreach ($client->getClientDelinquants() as $value) 
	{
		if ($contract->setCutoff_detail($cutoff_id,$value->ID_client,$value->solde,'couper','BIF','')) 
		{
			# code...
		}
	}
}
/*if ($contract->saveCoupure($_GET['action'],$_GET['observation'],$_GET['idclient'],$_GET['montant'],$_GET['monnaie'],$_GET['mois'],$_GET['annee'],date('Y-m-d'),$_GET['motif'])) 
{
	if ($_GET['action'] == 'couper') 
	{
		$ticket = new ticket();
		if ($ticket->saveTicket($_GET['idclient'],'coupure',$_GET['observation'],$typecon = '',"ouvert")) 
		{
		    $data = $ticket->recuperationIdticket()->fetch();
		    $id_ticket = $data['ID_ticket'];
		    if ($ticket->insertionDescription($id_ticket,$_GET['idUser'],$_GET['observation'],date('Y-m-d'))) 
		    {
		    	if ($_GET['motif'] == 'dette') 
		    	{
		    		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='coupure') > 0) 
			    	{
			    		echo "L'action effectue bien";
			    	}
		    	}
		    	elseif ($_GET['motif'] == 'partie') 
		    	{
		    		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='gone',$etat='coupure') > 0) 
			    	{
			    		echo "L'action effectue bien";
			    	}
		    	}
		    }
		}
	}
	else
	{
		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='actif') > 0) 
    	{
    		echo "L'action effectue bien";
    	}
	} 
}*/
