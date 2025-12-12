<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");
require_once("../../model/comptabilite.class.php");

$ticket = new ticket();
$comptabilite = new Comptabilite();

if ($ticket->modifierDescription($_GET['ref'],$_GET['informaticien'],$_GET['date_description'],$_GET['endroit'],$_GET['description']) > 0) 
{
    if ($comptabilite->setHistoriqueAction($_GET['ref'],'detail ticket',$_GET['userName'],date('Y-m-d'),'modifier'))
    {
    	//require_once('repDescription.php');
    	//require_once('rep.php');
    }
} 
?>

