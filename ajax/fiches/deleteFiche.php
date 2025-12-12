<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");
require_once("../../model/comptabilite.class.php");

$ticket = new ticket();
$comptabilite = new Comptabilite();
 
if ($ticket->suppression_fiche($_GET['idfiche'])) 
{
    /*if ($comptabilite->setHistoriqueAction($_GET['idfiche'],'fiche',$_GET['userName'],date('Y-m-d'),'supprimer'))
    {
    	//require_once('repfiche.php');
    }*/
}
