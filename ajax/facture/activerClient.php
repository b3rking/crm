<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/client.class.php");
//require_once('../../include/routeros_api.class.php');

$contract = new Contract();
$client = new Client();
//$mikrotik = new Mikrotik();

date_default_timezone_set("Africa/Bujumbura");
$updated_at = date("Y-m-d H:i:s");
//$return = 'no';
//$mikrotik->debug = true;
/*if ($mikrotik->connect('192.168.88.1','admin',''))
{
	$mikrotik->write('/ip/firewall/address-list/print',false);
    $mikrotik->write('?address='.$_GET['ip_address'],true);
    $READ = $mikrotik->read(false);
    $ARRAY = $mikrotik->parseResponse($READ);
    if(count($ARRAY) > 0)
    {
        $mikrotik->write('/ip/firewall/address-list/set',false);
        $mikrotik->write("=.id=".$ARRAY[0]['.id'],false);
        $mikrotik->write('=list=PAYING',true);
        $READ = $mikrotik->read(false);
        $ARRAY = $mikrotik->parseResponse($READ);
        if (count($ARRAY) > 0) 
        {
        	echo "NO";
        }
        else
        {*/
        	//if ($contract->activerClient($_GET['idclient'],$updated_at)) 
			//{
				if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='actif') > 0) 
				{
					//$return = 'ok';
					if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
					{
						
					}
				}
				/*if ($_GET['type_client'] == 'free') 
				{
					if ($client->updateTypeAndEtat($_GET['idclient'],$_GET['type_client'],$etat='actif') > 0) 
					{
						$return = 'ok';
					}
				}
				else
				{
					if ($client->updateTypeAndEtat($_GET['idclient'],$type_client='paying',$etat='actif') > 0) 
					{
						$return = 'ok';
						if ($contract->updateEtatContract($_GET['idclient'],'activer') > 0) 
			    		{
			    			if ($contract->setEtatFactureActifAfterDeleteCoupureAction($_GET['idclient'],$_GET['mois'],$_GET['annee']) > 0) 
							{
								$return = 'ok';
							}
			    		}
					}
				}*/
				//echo $return;
			/*}
        }
    }
}
else echo "connexion echoue";*/


