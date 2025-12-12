<?php
    require_once("../../model/connection.php");
    require_once("../../model/ticket.class.php");
    //require_once("../../model/equipement.class.php");
    
    date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");
    $started_at = date('H:i:s');

    $ticket = new ticket();
    //$equipement = new Equipement();

    /*if ($equipement->updateEquipementUsed($_GET['idequipement'],'non'))
    {
        //foreach($equipement->recupereMacAdressesHisto($_GET['idequipement']) as $value)
        //{
            //if ($equipement->ajouterMacAdresse($value->mac)) 
            //{
                if ($equipement->update_exist_attribution_equipement_client($_GET['idclient'],$_GET['idequipement'],$exist= 'non') > 0) 
                {
                    # code...
                }
                //if ($equipement->deleteEquipementAttribuer($_GET['idequipement'])) 
                //{
                    //if ($equipement->deleteEquipementHisto($_GET['idequipement'])) 
                    //{
                        //if ($_GET['nombreEquipement'] == 0) 
                        //{
                

                            if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['endroit'],$_GET['user'],$started_at,$finished_at=$created_at,$created_at,$created_at,$last_action='oui')) 
                            {
                                if ($ticket->updateStatus($_GET['idticket'],'fermer'))
                                {
                                    //if ($ticket->insererUserFermerTicket($_GET['user'],$_GET['idticket'])) 
                                    //{
                                        require_once('repTicketFermer.php');
                                    //}
                                }
                            }
                        //}
                    //}
                //}
            //}
        //}
    }

    /*else
    {
        if ($ticket->insertionDescription($_GET['idticket'],$_GET['user'],$_GET['observation'],$_GET['date_fermeture'],$_GET['endroit'])) 
        {
            if ($ticket->updateStatus($_GET['idticket'],'fermer'))
            {
                if ($ticket->insererUserFermerTicket($_GET['user'],$_GET['idticket'])) 
                {
                    require_once('repTicketFermer.php');
                }
            }
        }
    }*/

    if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['endroit'],$_GET['user'],$started_at,$finished_at=$created_at,$created_at,$created_at,$last_action='oui')) 
    {
        if ($ticket->updateStatus($_GET['idticket'],'fermer'))
        {
            //if ($ticket->insererUserFermerTicket($_GET['user'],$_GET['idticket'])) 
            //{
                require_once('repTicketFermer.php');
            //}
        }
    }
?>