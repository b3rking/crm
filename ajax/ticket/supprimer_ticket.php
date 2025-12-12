<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");
require_once("../../model/comptabilite.class.php");

$ticket = new ticket();
$comptabilite = new Comptabilite();
 
if ($ticket->supprimerticket($_GET['idticket'])) 
{
     /*if ($comptabilite->setHistoriqueAction($_GET['idticket'],'ticket',$_GET['userName'],date('Y-m-d'),'supprimer'))
    {
    	require_once('rep.php');
    }*/
}

