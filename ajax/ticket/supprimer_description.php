<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");
require_once("../../model/comptabilite.class.php");

$ticket = new ticket();
$comptabilite = new Comptabilite();

if ($ticket->DeleteDescription($_GET['ref']))
{
    /*if ($comptabilite->setHistoriqueAction($_GET['ref'],'detail ticket',$_GET['userName'],date('Y-m-d'),'supprimer'))
    {
    	//require_once('repDescription.php');
    	//require_once('rep.php');
    }*/
} 
?>

