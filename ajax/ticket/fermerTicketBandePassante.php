<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
$started_at = date('H:i:s');
    
$ticket = new ticket();

//if ($data = $ticket->recupererDateFinBandePassante($_GET['idticket'])->fetch())
//{
    if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['endroit'],$_GET['user'],$started_at,$finished_at=$created_at,$created_at,$created_at,$last_action='oui')) 
    {  
        if ($ticket->updateStatus($_GET['idticket'],'fermer')) 
        {
            //$res = $ticket->insererUserFermerTicket($_GET['user'],$_GET['idticket']);
            //require_once('repTicketFermer.php');
        }
    }
/*}
else
{
    echo 'La date n\'a pas encore atteinte';
    //require_once('repTicketOuvert.php');
}*/
/*
if ($_GET['dernierAction'] == 'cocher') 
{
    if ($_GET['type_ticket'] == 'bandepassante') 
    {
        if ($data = $ticket->recupererDateFinBandePassante($idticket)->fetch())
        {
            if (date('Y-m-d') < $data['dateFin']) 
            {
                echo 'La date n\'a pas encore atteinte';
            }
            else
            {
                if ($ticket->insertionDescription($_GET['idticket'],$_GET['user'],$_GET['observation'],$_GET['date_fermeture'])) 
                {  
                    if ($ticket->updateStatus($_GET['idticket'],'fermer')) 
                    {
                        $res = $ticket->insererUserFermerTicket($_GET['user'],$_GET['idticket']);
                        require_once('repTicketFermer.php');
                    }
                }
            }
        }
        else
        {
            if ($ticket->insertionDescription($_GET['idticket'],$_GET['user'],$_GET['observation'],$_GET['date_fermeture'])) 
            {  
                if ($ticket->updateStatus($_GET['idticket'],'fermer')) 
                {
                    $res = $ticket->insererUserFermerTicket($_GET['user'],$_GET['idticket']);
                    require_once('repTicketFermer.php');
                }
            }
        }
    }
    else
    {
        if ($ticket->insertionDescription($_GET['idticket'],$_GET['user'],$_GET['observation'],$_GET['date_fermeture'])) 
        {  
            if ($ticket->updateStatus($_GET['idticket'],'fermer')) 
            {
                $res = $ticket->insererUserFermerTicket($_GET['user'],$_GET['idticket']);
                require_once('repTicketFermer.php');
            }
        }
    }
}
else
{
    if ($ticket->insertionDescription($_GET['idticket'],$_GET['user'],$_GET['observation'],$_GET['date_fermeture'])) 
    {
        require_once('repTicketOuvert.php');
    }
}*/
