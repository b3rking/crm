<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/historique.class.php");

$equipement = new Equipement();
$historique = new Historique();

$mac = strtoupper($_GET['mac']);
$nbport = $_GET['nbport'];

if ($equipement->verifierMacAdresse($mac)->fetch()) 
{
    echo "l'adresse mac existe deja";
} 
else
{
    if ($equipement->ajouterStock($_GET['model'],$_GET['type_equipement'],$mac,$nbport,$_GET['date_ajout'],$_GET['description'],$_GET['iduser'])) 
    {
        if ($_GET['number'] > 0) 
        {
            $equipement->ajouterMacAdresse($mac);
            // MAC Address Increments
            for($i=0;$i < $nbport-1;$i++)
            {
                $dec = hexdec($mac);
                $dec++;
                $mac = dechex($dec);
                $mac = rtrim(strtoupper(chunk_split($mac, 2, ':')),':');
                $equipement->ajouterMacAdresse($mac);
                //echo "{$hexval}<br>";
            }
        }
        else
        {
            $equipement->ajouterMacAdresse($mac);
        }
        $id = $equipement->getMaxIdEquipement()->fetch()['ID_equipement'];
        if ($historique->setHistoriqueAction($id,'equipement',$_GET['iduser'],date('Y-m-d'),'creer')) 
        {}
        /*if ($_GET['type_equipement'] == 'antenne') 
        {
            require_once('repAntenne.php');
        }
        else if ($_GET['type_equipement'] == 'routeur') 
        {
            require_once('repRouteur.php');
        }
        else if ($_GET['type_equipement'] == 'switch') 
        {
            require_once('reponseSwitch.php');
        }
        else if ($_GET['type_equipement'] == 'radio') 
        {
           require_once('repRadio.php');
        }*/ 
    }
}
?>