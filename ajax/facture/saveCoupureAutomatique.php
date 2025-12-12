<?php
require_once("/var/www/crm.uvira/model/connection.php");
require_once("/var/www/crm.uvira/model/contract.class.php");
require_once("/var/www/crm.uvira/model/ticket.class.php");
require_once("/var/www/crm.uvira/model/client.class.php");

$contract = new Contract();
$client = new Client();

$date = date_parse(date('Y-m-d'));
foreach ($contract->liste_Client_A_couper() as $value) 
{
	$solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
    if ($solde > 0) 
    {
    	//echo "Client: ".$value->nom_client." solde: ".$solde."\n";
    	if ($contract->saveCoupure('couper','Dette',$value->ID_client,$solde,'USD',$date['month'],$date['year'],date('Y-m-d'),'dette')) 
		{
			$ticket = new ticket();
			if ($ticket->saveTicket($value->ID_client,'coupure','Dette',$typecon = '',"ouvert")) 
			{
			    $data = $ticket->recuperationIdticket()->fetch();
			    $id_ticket = $data['ID_ticket'];
			    if ($ticket->insertionDescription($id_ticket,'','Dette',date('Y-m-d'))) 
			    {
			    	if ($client->updateTypeAndEtat($value->ID_client,$type_client='paying',$etat='coupure') > 0) 
			    	{
			    		if ($contract->updateEtatFacture($value->billing_number.'_'.date('Y').date('m').'01','coupure') > 0) 
						{
							//echo "ok";
						}
			    	}
			    }
			} 
		}
    }
}
/*if (date('d') == 5) 
{
	if (empty($contract->getCoupureDetteCreerAuneDate(date('Y-m-d')))) 
	{*
		$mois = $date['month']+1;
		foreach ($contract->genererClientAderoguer($mois,$date['year']) as $value) 
		{
			if ($contract->saveCoupure('couper','Dette du mois de '.$mois.'/'.$date['year'],$value->ID_client,$value->montant,$value->monnaie,$mois,$date['year'],date('Y-m-d'),'dette')) 
			{
				$ticket = new ticket();
				if ($ticket->saveTicket($value->ID_client,'coupure','Dette du mois de '.$mois.'/'.$date['year'],$typecon = '',"ouvert")) 
				{
				    $data = $ticket->recuperationIdticket()->fetch();
				    $id_ticket = $data['ID_ticket'];
				    if ($ticket->insertionDescription($id_ticket,$_GET['idUser'],'Dette du mois de '.$mois.'/'.$date['year'],date('Y-m-d'))) 
				    {
				    	if ($client->updateTypeAndEtat($value->ID_client,$type_client='paying',$etat='coupure') > 0) 
				    	{
				    		if ($contract->updateEtatFacture($value->facture_id,'coupure') > 0) 
							{
								//echo "ok";
							}
				    	}
				    }
				} 
			}
		}
	//}
//}*/

