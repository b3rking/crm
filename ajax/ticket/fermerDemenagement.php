<?php
    require_once("../../model/connection.php");
    require_once("../../model/equipement.class.php");
    require_once("../../model/client.class.php");
    require_once("../../model/ticket.class.php");

    date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");
    $started_at = date('H:i:s');

    $client = new Client();
    $ticket = new ticket();
    $equipement = new Equipement();

    if ($equipement->demenagerClientPointAcces($_GET['idclient'],$_GET['point_acces'])) 
    {

        if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['endroit'],$_GET['user'],$started_at,$finished_at=$created_at,$created_at,$created_at,$last_action='oui')) 
            {  
                if ($ticket->updateStatus($_GET['idticket'],'fermer')) 
                {
                    
                    require_once('repTicketFermer.php');
                }
            }
    }
?>