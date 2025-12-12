<?php
require_once("../../model/connection.php");
require_once("../../model/client.class.php");
require_once("../../model/typeClient.class.php");
require_once("../../model/historique.class.php");  

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');

$historique = new Historique();
$client = new Client();
$type = new TypeClient();
$url = $_GET['url'];
$profil_name = $_GET['profil_name'];
$dernierIdClient;

//print_r('genre'.$_GET['genre'].'nom :'.$_GET['nom'].'Tel :'.$_GET['phone'].'Mail :'.$_GET['mail'].'adss :'.$_GET['adrs'].'note :'.$_GET['note'].'personne cont'.$_GET['pers_cont'].' type'.$_GET['type'].date('Y-m-d').$_GET['location'].$_GET['langue'].$_GET['nif'].$_GET['tva'].$_GET['etat']);die();
if ($data = $client->recupererDernierClient()->fetch()) 
{
    $dernierIdClient = $data['ID_client'] + 1;
}
//saveclient($idclient,$nomclient,$telephone,$mail,$adresse,$commentaire,$personneDeContact,$type,$date_creation,$location,$langue,$nif,$tva,$etat='N/A',$billing_number_parent=Null)

if ($client->saveclient($dernierIdClient,strtoupper($_GET['nom']),$_GET['phone_mobile'],$_GET['phone_fixe'],$_GET['mail'],$_GET['adrs'],$_GET['note'],strtoupper($_GET['pers_cont']),$_GET['type'],date('Y-m-d'),$_GET['location'],$_GET['langue'],$_GET['nif'],$_GET['tva'],$_GET['etat'],$billing_number_parent=Null,$_GET['genre'])) 
{
	if ($historique->setHistoriqueAction($dernierIdClient,'client',$_GET['iduser'],$created_at,'creer')) 
	{
		//require_once("repClient.php");
	}
   
}