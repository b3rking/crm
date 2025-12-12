<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");
require_once("../../model/comptabilite.class.php");

$ticket = new ticket();
$comptabilite = new Comptabilite();

//$ticket->updateDescriptionTicket($_GET['idticket'],$_GET['dates'],$_GET['description']) > 0) 
if ($ticket->modifierUnticket($_GET['idticket'],$_GET['date_ticket'],$_GET['probleme'],$_GET['des_ticket'],$_GET['idclientupdateTicket']) > 0) 
{
    /*if ($comptabilite->setHistoriqueAction($_GET['idticket'],'ticket',$_GET['userName'],date('Y-m-d'),'modifier'))
    {
    	require_once('rep.php');
    }*/
} 


