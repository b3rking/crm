<?php
require_once("../../model/connection.php");
require_once("../../model/client.class.php");
require_once("../../model/historique.class.php"); 
require_once("../../model/contract.class.php");

$historique = new Historique();
$contract = new Contract();
$client = new Client(); 
$url = $_GET['url'];

date_default_timezone_set("Africa/Bujumbura");
$created_at = date("Y-m-d H:i:s");
//$started_at = date('H:i:s');

/*print_r($_GET['idclient'].'/'.$_GET['billing'].'/'.$_GET['nom'].'/'.$_GET['phone'].'/'.$_GET['mail'].'/'.$_GET['adrs'].'/'.$_GET['pers_cont'].'/'.$_GET['note'].'/'.$_GET['location'].'/'.$_GET['nif'].'/'.$_GET['langue'].'/'.$_GET['tva'].'/'.$_GET['type']);die();
*/
//$idcontract = $contract->getIdContract_par_numero($_GET['idclient'])->fetch()['ID_contract'];

//if ($idcontract != '') 
//{
	$billing_number = ($_GET['billing'] == 0 || $_GET['billing'] == '' ? null : $_GET['billing']);
	if ($client->updateClient($_GET['genre'],$_GET['idclient'],$billing_number,$_GET['nom'],$_GET['fixed_phone'],$_GET['mobile_phone'],$_GET['mail'],$_GET['adrs'],$_GET['pers_cont'],$_GET['note'],$_GET['location'],$_GET['nif'],$_GET['langue'],$_GET['tva'],$_GET['type']) > 0) 
		{
		    if ($historique->setHistoriqueAction($_GET['idclient'],'client',$_GET['iduser'],$created_at,'modifier')) 
			{
				//require_once("repClient.php");
			}
		}
//}
