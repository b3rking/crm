<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");
require_once("../../model/comptabilite.class.php");


$ticket = new ticket();
$comptabilite = new Comptabilite();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
$closed_by = $created_at;
$started_at = date('H:i:s');

//$idclient = preg_split("#[-]+#", $_GET['idclientCreerTicket']);
 
if ($ticket->saveTicket($idfiche=NULL,$_GET['idclient'],strtoupper($_GET['probleme']),$closed_by,$_GET['idUser'],$created_at,$created_at,strtoupper($_GET['description']),$_GET['type_ticket'],$status ="ouvert")) 
{
    $data = $ticket->recuperationIdticket()->fetch();
    $ticket_id = $data['id'];

    if ($ticket->insertionDescription($ticket_id,strtoupper($_GET['description']),$endroit='in_door',$_GET['idUser'],$started_at,$finished_at=$started_at,$created_at,$created_at,$last_action='non')) 
    {
        /*if ($comptabilite->setHistoriqueAction($ticket_id,'ticket',$_GET['userName'],date('Y-m-d'),'creer')) 
		{
			require_once('rep.php');
		}*/
    }
}
?>