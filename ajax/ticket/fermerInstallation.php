<?php
    require_once("../../model/connection.php");
    require_once("../../model/ticket.class.php"); 
    require_once("../../model/equipement.class.php");
    require_once("../../model/client.class.php");

    //point_acces,antenne,routeur,switche,date_instal,userName,idticket,user,observation,endroit,type_ticket,idclient

    date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");
    $started_at = date('H:i:s');

    $ticket = new ticket();
    $equipement = new Equipement();

    $equipementt = array();
    $client = new Client();

    if ($_GET['switche'] == '') 
    {
        $equipementt = array($_GET['antenne'],$_GET['routeur']);
    }
    else
    {
        $equipementt = array($_GET['antenne'],$_GET['routeur'],$_GET['switche']);
    }
 
    try 
    {
        $con = connection();

        //on lance la transaction
        $con->beginTransaction();
        /*if ($ticket->ajouterInstallation($_GET['idclient'],$_GET['point_acces'],$_GET['user'],$_GET['date_instal'])) 
        {

            if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['endroit'],$_GET['user'],$started_at,$finished_at=$created_at,$created_at,$created_at,$last_action='oui')) 
            {  
                if ($ticket->updateStatus($_GET['idticket'],'fermer')) 
                {
                    *for ($i=0; $i < count($equipementt); $i++) 
                    {
                        if($equipement->attribuer_equipement_client($_GET['idclient'],$equipementt[$i],$_GET['date_instal'],$_GET['user']))
                        {
                            if ($equipement->updateEquipementUsed($equipementt[$i],'oui')) 
                            {
                                /foreach ($equipement->recupereMacAdresses($equipementt[$i]) as $value) 
                                {
                                    if ($equipement->deleteMacAdresse($value->ID_equipement)) 
                                    {
                                    }
                                    if ($equipement->setHistoriqueMacAdresse($value->ID_equipement,$value->mac)) 
                                    {
                                        # code...
                                    }
                                }*
                            }
                        }
                        /if ($equipement->deleteEquipement($equipementt[$i])) 
                        {
                            foreach ($equipement->recupereMacAdresses($equipementt[$i]) as $value) 
                            {
                                $equipement->deleteMacAdresse($value->ID_equipement);
                            }
                            $equipement->attribuer_equipement_client($_GET['idclient'],$equipementt[$i],$_GET['date_instal'],$_GET['user']);
                        }*
                    }*
                    //$res = $ticket->insererUserFermerTicket($_GET['user'],$_GET['idticket']);
                    //require_once('repTicketFermer.php');
                    if ($client->updateIpAdresseClient($_GET['idclient'],$_GET['ip_address']) > 0) 
                    {
                        // code...
                    }
                }
            }
        }*/
        
        if ($ticket->ajouterInstallation($_GET['idclient'],$_GET['point_acces'],$_GET['user'],$_GET['date_instal'])) 
        {
            if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['endroit'],$_GET['user'],$started_at,$finished_at=$started_at,$created_at,$created_at,$last_action='oui')) 
            {  
                if ($ticket->updateStatus($_GET['idticket'],'fermer') > 0) 
                {
                    for ($i=0; $i < count($equipementt); $i++) 
                    {
                        $equipement_array = preg_split("#[_]+#", $equipementt[$i]);
                        $idequipement = $equipement_array[0];
                        $idsortie = $equipement_array[1];
                        if($equipement->attribuer_equipement_client($_GET['idclient'],$idequipement,$_GET['date_instal'],$_GET['user']))
                        {
                            if ($equipement->updateDestinationDetailAndStatusToSortieEquipement($idsortie,$_GET['idclient'],1) > 0) 
                            {
                                # code...
                            }
                        }
                    }
                    if ($client->updateIpAdresseClient($_GET['idclient'],$_GET['ip_address']) > 0) 
                    {
                        // code...
                    }
                }
            }
        }

        //si jusque là tout se passe bien on valide la transaction
        $con->commit();
    } catch (Exception $e) {
        //on annule la transation
        $con->rollback();

        //on affiche un message d'erreur ainsi que les erreurs
        echo 'Erreur : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();

        //on arrête l'exécution s'il y a du code après
        exit();
    }
    
?>