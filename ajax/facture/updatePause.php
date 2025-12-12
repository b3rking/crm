<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/ticket.class.php");
require_once("../../model/client.class.php");

$contract = new Contract();
$client = new Client();

if ($contract->updatePause($_GET['idPause'],$_GET['dateDebut'],$_GET['dateFin'],$_GET['raison'],$_GET['type_pause']) > 0) 
{
	echo "ok";
	/*$ticket = new ticket();
	if ($ticket->saveTicket($_GET['idclient'],'pause','','',"ouvert")) 
	{
	    $data = $ticket->recuperationIdticket()->fetch();
	    $id_ticket = $data['ID_ticket'];
	    if ($ticket->insertionDescription($id_ticket,$_GET['idUser'],$_GET['raison'],$_GET['date_creation'])) 
	    {
	        if ($client->updateEtatClient($_GET['idclient'],'pause') > 0) 
	        {
	        	//echo "ok";
	        }
	        if ($contract->updateEtatContract($_GET['idclient'],'pause') > 0) 
    		{
    			echo "ok";
    		}
	    }
	}*/
}