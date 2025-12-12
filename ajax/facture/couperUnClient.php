<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/ticket.class.php");
require_once("../../model/client.class.php");

$contract = new Contract();
$client = new Client();

//$date = date_parse($_GET['date_creation']);
$solde = $client->getSoldeClient($_GET['idclient']);

if ($contract->setCutoff_detail($_GET['cutoff_id'],$_GET['idclient'],$solde,$_GET['action'],'BIF',$_GET['observation'])) 
{
	if ($_GET['action'] == 'couper') 
	{
		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='coupure') > 0) 
		{
			
		}
	}
	else
	{
		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='actif') > 0) 
		{
			if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
			{
				
			}
		}
	}
	
	/*$ticket = new ticket();
	if ($ticket->saveTicket($_GET['idclient'],'coupure',$_GET['observation'],$typecon = '',"ouvert")) 
	{
	    $data = $ticket->recuperationIdticket()->fetch();
	    $id_ticket = $data['ID_ticket'];
	    if ($ticket->insertionDescription($id_ticket,$_GET['idUser'],$_GET['observation'],date('Y-m-d'))) 
	    {}
	}*/
}
/*if ($_GET['type_client'] == 'paying') 
{
	$solde = $contract->getSommeTotaleFactureDunClient($_GET['idclient'])->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($_GET['idclient'])->fetch()['montant'];
}
if ($contract->saveCoupure($_GET['action'],$_GET['observation'],$_GET['idclient'],$solde,'USD',$date['month'],$date['year'],$_GET['date_creation'],$_GET['motif'],$_GET['type_client'])) 
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
		    		if ($_GET['facture_id'] != '') 
		    		{
		    			if ($contract->updateEtatFacture($_GET['facture_id'],'coupure') > 0) 
						{
							echo "ok";
						}
		    		}
		    	}
	    	}
	    	elseif ($_GET['motif'] == 'partie') 
	    	{
	    		if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='gone',$etat='coupure') > 0) 
		    	{
		    		if ($_GET['type_client'] == 'paying') 
					{
						if ($contract->updateEtatContract($_GET['idclient'],'terminer') > 0) 
			    		{
			    			echo "ok";
			    		}
					}
		    	}
	    	}
	    }
	} 
}*/