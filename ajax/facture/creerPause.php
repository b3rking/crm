<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/ticket.class.php");
require_once("../../model/client.class.php");

$contract = new Contract();
$client = new Client();

$date = date_parse($_GET['dateDebut']);
$mois = $date['month'];
$annee = $date['year'];

if ($contract->creerPause($_GET['idclient'],$_GET['dateDebut'],$_GET['dateFin'],$_GET['raison'],$_GET['type_suspension'],$_GET['date_creation'],$_GET['idUser'])) 
{
	$ticket = new ticket();
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
    			$facture = $contract->getMoisFactureDunClient($_GET['idclient'],$mois,$annee)->fetchObject();
    			if (!empty($facture))
    			{
    				if ($contract->updateEtatFacture($facture->facture_id,'pause') > 0) 
					{
						//echo "ok";
					}
    			}
    			/*if (empty($contract->getMoisFactureDunClient($_GET['idclient'],$mois,$annee)->fetch()['ID_client'])) 
				{
					if ($contract->updateEtatFacture($_GET['facture_id'],'coupure') > 0) 
					{
						echo "ok";
					}
				}*/
    		}
	    }
	}
}