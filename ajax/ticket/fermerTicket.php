<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");
require_once("../../model/comptabilite.class.php");

$ticket = new ticket();
$comptabilite = new Comptabilite();

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
$started_at = date('H:i:s');
/*if ($data = $ticket->afficheToustickets($_GET['idticket'])->fetch()) 
{
    echo "Ce ticket existe deja";
}
$ticket;
if ($data = $ticket->recupererdernier()->fetch()) 
{
    $recupererdernier = $data['ID_client'] + 1;
}
*/

if ($_GET['dernierAction'] == 'cocher') 
{
    if ($_GET['type_ticket'] == 'pause') 
    {
        if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['endroit'],$_GET['user'],$started_at,$finished_at=$started_at,$created_at,$created_at,$last_action='oui')) 
        {  
            if ($ticket->updateStatus($_GET['idticket'],'fermer')) 
            {
                //require_once('repTicketFermer.php');
                /*if ($ticket->deleteSuspension($_GET['idclient'])) 
                {
                    //require_once('repTicketFermer.php');
                }*/
            }
        }
    }
    else
    {
        if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['endroit'],$_GET['user'],$started_at,$finished_at=$started_at,$created_at,$created_at,$last_action='oui')) 
        {  
            if ($ticket->updateStatus($_GET['idticket'],'fermer')) 
            { 
                //require_once('repTicketFermer.php');
                //require_once('repTicketFermer.php');
            }
        }
    }
}
else
{
    if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['endroit'],$_GET['user'],$started_at,$finished_at=$started_at,$created_at,$created_at,$last_action='non')) 
    {
        //require_once('repTicketOuvert.php');
    }
}
?>