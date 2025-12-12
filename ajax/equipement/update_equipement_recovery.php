<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php");

//echo $_GET['idclient']." ".$_GET['mac_address']." ".$_GET['model']." ".$_GET['maker']." ".$_GET['type']." ".$_GET['date_recuperation']." ".$_GET['iduser']." ".$_GET['nbport'];
//die();
$equipement = new Equipement();
$historique = new Historique();

$mac = strtoupper($_GET['mac_address']);
$nbport = $_GET['nbport'];

//$recovery_old_data = $equipement->getEquipementRecoverie($recovery_id)->fetch();

/*if ($data = $equipement->verifierMacAdresse($mac)->fetch()) 
{
    if ($equipement->setEquipementRecovery($data['ID_equipement'],$_GET['idclient'],$_GET['date_recuperation'],$_GET['iduser'],$_GET['description'])) 
    {
        if ($equipement->updateEquipementUsed($data['ID_equipement'],'non') > 0) 
        {
            # code...
        }
        if ($equipement->update_exist_attribution_equipement_client($_GET['idclient'],$data['ID_equipement'],'non') > 0) 
        {
            # code...
        }
    }
} 
else
{*/
    if ($equipement->deleteMacAddressByIdEquipemen($idequipement)) 
    {
        if ($nbport > 1) 
        {
            $equipement->ajouterMacAdresse($mac,$_GET['equipement_id']);
            // MAC Address Increments
            for($i=0;$i < $nbport-1;$i++)
            {
                $dec = hexdec($mac);
                $dec++;
                $mac = dechex($dec);
                $mac = rtrim(strtoupper(chunk_split($mac, 2, ':')),':');
                $equipement->ajouterMacAdresse($mac,$_GET['equipement_id']);
                //echo "{$hexval}<br>";
            }
        }
        else
        {
            $equipement->ajouterMacAdresse($mac,$_GET['equipement_id']);
        }
    }
    
    $description = $_GET['description'] == '' ? 'recuperation' : $_GET['description'];

    if ($equipement->updateEquipement($_GET['equipement_id'],$_GET['model'],$_GET['type'],$mac,$nbport,$description) > 0) 
    {
        if ($_GET['oldCustomer'] != $_GET['idclient']) 
        {
            $res = $equipement->getEquipementAttribuerByIdClientAndIdEquipement($_GET['oldCustomer'],$_GET['equipement_id'])->fetch();
            if ($res) 
            {
                if ($equipement->updateEquipementRecovery($_GET['recovery_id'],$_GET['oldCustomer'],$_GET['date_recuperation'],$_GET['description']) > 0) 
                {
                    # code...
                }
            }
            else
            {
                if ($equipement->updateEquipementRecovery($_GET['recovery_id'],$_GET['idclient'],$_GET['date_recuperation'],$_GET['description']) > 0) 
                {
                    # code...
                }
            }
        }
        /*if ($historique->setHistoriqueAction($id,'equipement',$_GET['iduser'],date('Y-m-d'),'recuperation')) 
        {}*/
    }
//}
