
<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");

$equipement = new Equipement();
 

if($equipement->attribuer_equipement_client($_GET['idclient'],$_GET['idEquipement'],$_GET['datedistribution'],$_GET['attributeur']))
{
    if ($equipement->updateEquipementUsed($_GET['idEquipement'],'oui') > 0) 
    {
        # code...
    }
	/*if ($equipement->deleteEquipement($_GET['idEquipement'])) 
	{
    	foreach ($equipement->recupereMacAdresses($_GET['idEquipement']) as $value) 
        {
            if ($equipement->deleteMacAdresse($_GET['idEquipement'])) 
            {
            }
            if ($equipement->setHistoriqueMacAdresse($_GET['idEquipement'],$value->mac)) 
        	{
        		# code...
        	}
        }
        echo "Attribution reussie";
	}*/
}
?>
			