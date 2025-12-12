
<?php

/**
 * 
 */
class Equipement
{

	function ajouterStock($model,$type_equipement,$first_adress,$nb_port,$date_stock,$description,$user)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO equipement(model_id,type_equipement,first_adress,nb_port,date_stock,description,ID_user) VALUE(:model,:type_equipement,:first_adress,:nb_port,:date_stock,:description,:user)");
		$rs= $query->execute(array('model' => $model,'type_equipement' => $type_equipement,'first_adress'=>$first_adress,'nb_port' => $nb_port,'date_stock' => $date_stock,'description' => $description,'user' => $user)) or die(print_r($query->errorInfo()));
		/*$error = $query->errorInfo();
		if ($error[1] == 1062) 
		{
			$rs = 'pas ok';
		}
		else $rs = 'ok';*/
		return $rs;
	}
	function getMaxIdEquipement()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_equipement) AS ID_equipement FROM equipement");
		$query->execute();
		return $query;
	}
	function deleteEquipement($id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM equipement WHERE ID_equipement = ?");
		$res = $query->execute(array($id)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateEquipementUsed($idequipement,$used)
	{
		$con = connection();
		$query = $con->prepare("UPDATE equipement SET used = :used WHERE ID_equipement = :idequipement");
		$res = $query->execute(['used' => $used,'idequipement' => $idequipement]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function setEquipementRecovery($idequipement,$idclient,$recovery_date,$user_id,$description)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO equipement_recovery(equipement_id,customer_id,recovery_date,description,user_id) VALUE(:equipement_id,:customer_id,:recovery_date,:description,:user_id)");
		$res = $query->execute(['equipement_id' => $idequipement,'customer_id' => $idclient,'recovery_date' => $recovery_date,'description' => $description,'user_id' => $user_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function updateEquipementRecovery($id,$customer_id,$recovery_date,$description)
	{
		$con = connection();
		$query = $con->prepare("UPDATE equipement_recovery SET customer_id =:customer_id,recovery_date =:recovery_date,description =:description WHERE id =:id");
		$res = $query->execute(['customer_id' => $customer_id,'recovery_date' => $recovery_date,'description' => $description,'id' => $id]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function getEquipementRecoveries()
	{
		$con = connection();
		//$query = $con->prepare(" SELECT equipement_id,customer_id,nom_client,recovery_date,model,fabriquant,type_equipement,first_adress FROM equipement_recovery r,equipement e,client cl WHERE r.equipement_id = e.ID_equipement AND r.customer_id = cl.ID_client");
        
        // $query = $con->prepare(" SELECT r.id,equipement_id,customer_id,nom_client,recovery_date,model_id,mk.name AS maker,type_equipement,first_adress,nb_port,r.description,m.name FROM equipement_recovery r,equipement e,client cl,models m,makers mk WHERE r.equipement_id = e.ID_equipement AND e.model_id = m.id AND m.maker_id = mk.id AND r.customer_id = cl.ID_client");
        
        $query = $con->prepare(" SELECT r.id,equipement_id,customer_id,nom_client,recovery_date,model_id,mk.name AS maker,type_equipement,first_adress,nb_port,r.description,m.name FROM equipement_recovery r,equipement e,client cl,models m,makers mk WHERE r.equipement_id = e.ID_equipement AND e.model_id = m.id AND m.maker_id = mk.id AND r.customer_id = cl.ID_client ORDER BY recovery_date DESC LIMIT 30");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreRecuperation($condition)
	{
		$con = connection();
		$query = $con->prepare(" SELECT r.id,equipement_id,customer_id,nom_client,recovery_date,model_id,mk.name AS maker,type_equipement,first_adress,nb_port,r.description,m.name FROM equipement_recovery r,equipement e,client cl,models m,makers mk WHERE r.equipement_id = e.ID_equipement AND e.model_id = m.id AND m.maker_id = mk.id AND r.customer_id = cl.ID_client $condition ORDER BY recovery_date DESC LIMIT 100");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getEquipementRecoverie($recovery_id)
	{
		$con = connection();
		$query = $con->prepare(" SELECT equipement_id,customer_id,nom_client,recovery_date,model_id,mk.name AS maker,type_equipement,first_adress,nb_port,r.description,m.name FROM equipement_recovery r,equipement e,client cl,models m,makers mk WHERE r.equipement_id = e.ID_equipement AND e.model_id = m.id AND m.maker_id = mk.id AND r.customer_id = cl.ID_client AND r.id =?");
		$query->execute([$recovery_id]);
		return $query;
	}
    function getModels()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM models");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getMakers()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM makers");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function deleteEquipementInstaller($id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM installation WHERE ID_equipement = ?");
		$res = $query->execute(array($id)) or die(print_r($query->errorInfo()));
		return $res;
	}*/
	function deleteEquipementAttribuer($id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM attribution_equipement_client WHERE ID_equipement = ?");
		$res = $query->execute(array($id)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deleteEquipementHisto($id_equipement)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM historique_stock WHERE ID_equipement = ?");
		$res = $query->execute(array($id_equipement)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deleteMacAdresse($id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM macadresse WHERE ID_equipement = ?");
		$res = $query->execute(array($id)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function recupererRouteur()
	{
		$con = connection();
		$query = $con->prepare("SELECT e.ID_equipement,model,fabriquant,first_adress,used FROM equipement e WHERE type_equipement = 'routeur' AND used = 'non'");
		$query->execute()or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function rapport_routeur($condition_entree,$condition_sortie)
	{
		$con = connection();
		$query = $con->prepare("SELECT CONCAT(date_stock,'/entree/',description) AS equipements FROM equipement WHERE type_equipement = 'routeur' $condition_entree UNION ALL SELECT CONCAT(date_sortie,'/sortie/',destination,'/',destination_detail) AS equipements FROM sortie_equipement,equipement WHERE sortie_equipement.ID_equipement = equipement.ID_equipement AND equipement.type_equipement = 'routeur' $condition_sortie ORDER BY equipements");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getNbRouteurByMarqueBeforeAdate($marque,$date_in)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM equipement WHERE type_equipement = 'routeur' AND marque =:marque AND date_stock <:date_in");
		$query->execute(['marque' => $marque,'date_in' => $date_in]);
		return $query->fetch()['nb'];
	}
	function getNbOutRouteurByMarqueBeforeAdate($marque,$date_out)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM equipement e,sortie_equipement s WHERE type_equipement = 'routeur' AND marque =:marque AND date_sortie < :date_out AND e.ID_equipement = s.ID_equipement");
		$query->execute(['marque' => $marque,'date_out' => $date_out]);
		return $query->fetch()['nb'];
	}
    function getSortieRouteurDestinationClient()
	{
		$con = connection();
		//$query = $con->prepare("SELECT ID_sortie,e.ID_equipement,model,e.first_adress,motif,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_sortie,sortie_par,demander_par,destination,destination_detail,s.status,cl.ID_client FROM sortie_equipement s,equipement e,client cl WHERE s.ID_equipement = e.ID_equipement AND e.type_equipement = 'routeur' AND s.destination = 'client' AND cl.ID_client = s.destination_detail AND s.status = 0");
        $query = $con->prepare("SELECT ID_sortie,e.ID_equipement,mo.name AS model,e.first_adress,motif,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_sortie,sortie_par,demander_par,destination,destination_detail,s.status,cl.ID_client FROM sortie_equipement s,equipement e,client cl,models mo WHERE s.ID_equipement = e.ID_equipement AND e.type_equipement = 'routeur' AND e.model_id = mo.id AND s.destination = 'client' AND cl.ID_client = s.destination_detail AND s.status = 0");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function recupererSwitch()
	{
		$con = connection();
		//$query = $con->prepare("SELECT e.ID_equipement,model,fabriquant,type_equipement,date_stock,first_adress FROM equipement e WHERE  type_equipement = 'switch' AND used = 'non'");
        $query = $con->prepare("SELECT ID_equipement,model_id,mo.name AS model,mk.name AS fabriquant,type_equipement,date_stock,first_adress,e.description FROM equipement e,models mo,makers mk WHERE e.model_id = mo.id AND mo.maker_id = mk.id AND type_equipement = 'switch' AND used = 'non'  ORDER BY ID_equipement");
		$query->execute()or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getSortieSwitchDestinationClient()
	{
		$con = connection();
		//$query = $con->prepare("SELECT ID_sortie,e.ID_equipement,model,e.first_adress,motif,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_sortie,sortie_par,demander_par,destination,destination_detail,s.status,cl.ID_client FROM sortie_equipement s,equipement e,client cl WHERE s.ID_equipement = e.ID_equipement AND e.type_equipement = 'switch' AND s.destination = 'client' AND cl.ID_client = s.destination_detail AND s.status = 0");
        $query = $con->prepare("SELECT ID_sortie,e.ID_equipement,mo.name AS model,e.first_adress,motif,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_sortie,sortie_par,demander_par,destination,destination_detail,s.status,cl.ID_client FROM sortie_equipement s,equipement e,client cl,models mo WHERE s.ID_equipement = e.ID_equipement AND e.type_equipement = 'switch' AND e.model_id = mo.id AND s.destination = 'client' AND cl.ID_client = s.destination_detail s.status = 0");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getEquipementInStockByType($type_equipement)
	{
		$con = connection();
		//$query = $con->prepare("SELECT ID_equipement,model,fabriquant,type_equipement,date_stock,first_adress FROM equipement WHERE  type_equipement = :type_equipement AND used = 'non'");
        $query = $con->prepare("SELECT ID_equipement,e.model_id,mo.name AS model,fabriquant,type_equipement,date_stock,first_adress FROM equipement e,models mo WHERE  type_equipement = :type_equipement AND used = 'non' AND e.model_id = mo.id;");
		$query->execute(['type_equipement' => $type_equipement])or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function updateswitch($id,$model,$fabriquant,$date_stock)
	{
		$con = connection();
		$query = $con->prepare("UPDATE equipement SET model=:model,fabriquant =:fabriquant,date_stock =:date_stock WHERE ID_equipement =:id"); 
		$rs =$query->execute(array('date_stock' => $date_stock,'model' => $model,'fabriquant' => $fabriquant,'id'=>$id));
		$error = $query->errorInfo();
		return $rs;
	}
	function updateMAC_Switch($id,$mac)
	{
		$con = connection();
		$query = $con->prepare("UPDATE macadresse SET mac =:mac WHERE ID_equipement =:id"); 
		$query->execute(array('mac' => $mac,'id'=>$id));
		$error = $query->errorInfo();
		return $query;
	}
	function recupereRadio()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM equipement WHERE type_equipement = 'radio' AND used = 'non' ");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function updateRadio($id,$date_stock,$model,$fabriquant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE equipement SET model=:model,fabriquant =:fabriquant,date_stock =:date_stock WHERE ID_equipement =:id"); 
		$rs =$query->execute(array('date_stock' => $date_stock,'model' => $model,'fabriquant' => $fabriquant,'id'=>$id)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function updateMAC_Radio($id,$mac)
	{
		$con = connection();
		$query = $con->prepare("UPDATE macadresse SET mac =:mac WHERE ID_equipement =:id"); 
		$query->execute(array('mac' => $mac,'id'=>$id));
		$error = $query->errorInfo();
		return $query;
	}
	function recupererAntennes()
	{
		$con = connection();
		//$query = $con->prepare("SELECT ID_equipement,model,fabriquant,type_equipement,date_stock,first_adress FROM equipement WHERE type_equipement = 'antenne' AND used = 'non'  ORDER BY ID_equipement");
        $query = $con->prepare("SELECT ID_equipement,model_id,mo.name AS model,mk.name AS fabriquant,type_equipement,date_stock,first_adress,e.description FROM equipement e,models mo,makers mk WHERE e.model_id = mo.id AND mo.maker_id = mk.id AND type_equipement = 'antenne' AND used = 'non'  ORDER BY ID_equipement");
		$query->execute()or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function rapport_antenne($condition_entree,$condition_sortie)
	{
		$con = connection();
		$query = $con->prepare("SELECT CONCAT(date_stock,'/entree/','entree') AS equipements FROM equipement WHERE type_equipement = 'antenne' $condition_entree UNION ALL SELECT CONCAT(date_sortie,'/sortie/',destination,'/',destination_detail) AS equipements FROM sortie_equipement,equipement WHERE sortie_equipement.ID_equipement = equipement.ID_equipement AND equipement.type_equipement = 'antenne' $condition_sortie ORDER BY equipements");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getNbAntenneByMarqueBeforeAdate($marque,$date_in)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM equipement WHERE type_equipement = 'antenne' AND marque =:marque AND date_stock <:date_in");
		$query->execute(['marque' => $marque,'date_in' => $date_in]);
		return $query->fetch()['nb'];
	}
	function getNbOutAntenneByMarqueBeforeAdate($marque,$date_out)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM equipement e,sortie_equipement s WHERE type_equipement = 'antenne' AND marque =:marque AND date_sortie < :date_out AND e.ID_equipement = s.ID_equipement");
		$query->execute(['marque' => $marque,'date_out' => $date_out]);
		return $query->fetch()['nb'];
	}
    function getSortieAntenneDestinationClient()
	{
		$con = connection();
		//$query = $con->prepare("SELECT ID_sortie,e.ID_equipement,model,e.first_adress,motif,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_sortie,sortie_par,demander_par,destination,destination_detail,s.status,cl.ID_client FROM sortie_equipement s,equipement e,client cl WHERE s.ID_equipement = e.ID_equipement AND e.type_equipement = 'antenne' AND s.destination = 'client' AND cl.ID_client = s.destination_detail AND s.status = 0");
        $query = $con->prepare("SELECT ID_sortie,e.ID_equipement,mo.name AS model,e.first_adress,motif,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_sortie,sortie_par,demander_par,destination,destination_detail,s.status,cl.ID_client FROM sortie_equipement s,equipement e,client cl,models mo WHERE s.ID_equipement = e.ID_equipement AND e.type_equipement = 'antenne' AND e.model_id = mo.id AND s.destination = 'client' AND cl.ID_client = s.destination_detail AND s.status = 0");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function verifierMacAdresse($mac)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM macadresse WHERE mac = ?");
		$query->execute(array($mac)) or die(print_r($query->errorInfo()));
		return $query;
	}
	/*function ajouterMacAdresse($mac)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO macadresse(ID_equipement,mac) SELECT max(ID_equipement),:mac FROM equipement");
		$rs = $query->execute(array('mac' => $mac)) or die(print_r($query->errorInfo()));
		return $rs;
	}*/
    function ajouterMacAdresse($mac,$idequipement)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO macadresse(ID_equipement,mac) VALUES(:idequipement,:mac)");
		$rs = $query->execute(['mac' => $mac,'idequipement' => $idequipement]) or die(print_r($query->errorInfo()));
		return $rs;
	}
     function deleteMacAddressByIdEquipemen($idequipement)
	{
		/*$con = connection();
		$query = $con->prepare("DELETE FROM macadresse WHERE ID_equipement =?");
		$res = $query->execute($idequipement);
		return $res;*/

		$con = connection();
		$query = $con->prepare("DELETE FROM macadresse WHERE ID_equipement = ?");
		$res = $query->execute([$idequipement]);
		return $res;
	}
	function recupereMacAdresses($id_equipement)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_equipement,mac FROM macadresse WHERE ID_equipement = ?");
		$query->execute(array($id_equipement)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function setHistoriqueMacAdresse($idequipement,$mac)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO historiquemacadresse(ID_equipement,mac) VALUES(:idequipement,:mac)");
		$res = $query->execute(['idequipement' => $idequipement,'mac' => $mac]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function recupereMacAdressesHisto($id_equipement)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_equipement,mac FROM historiquemacadresse WHERE ID_equipement = ?");
		$query->execute(array($id_equipement)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}

	
	function NewPoint_acces($secteurpa,$nompa,$ipa,$macpa,$idAntenne,$frequence,$ssidpa,$ant_limite_pa,$user)
	{ 				 	 	 	 
		$con = connection();
		$query = $con->prepare("INSERT INTO point_acces(secteur,nom ,ip,mac,antenne,frequence,SSID,antenne_limite,ID_user) VALUE(:secteurpa,:nompa,:ipa,:macpa,:idAntenne,:frequence,:ssidpa,:ant_limite_pa,:user)");
		$rs =$query->execute(array('secteurpa'=>$secteurpa,'nompa'=>$nompa,'ipa'=>$ipa,'macpa'=>$macpa,'idAntenne'=>$idAntenne,'frequence'=>$frequence,'ssidpa'=>$ssidpa,'ant_limite_pa'=>$ant_limite_pa,'user' => $user)) or die(print_r($query->errorInfo()));
		$error = $query->errorInfo();
		$rs = "";
		if ($error[1] == 1062) 
		{
			$rs = 'duplicate';
		}
		else 
		{
			$rs = 'ok';
		}
		return $rs;
	}
	function getMaxIdPointAccess()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_point_acces) AS ID_point_acces FROM point_acces");
		$query->execute();
		return $query;
	}
	function NewSecteur($code,$nom_secteur,$adrese_secteur,$switch_ip)
	{			 	 	 	 	 
		$con = connection();
		$query = $con->prepare("INSERT INTO secteur(code,nom_secteur,adresse_secteur,switch_ip) VALUE(:code,:nom_secteur,:adrese_secteur,:switch_ip)");
		$rs= $query->execute(array('code'=>$code,'nom_secteur'=>$nom_secteur,'adrese_secteur'=>$adrese_secteur,'switch_ip' => $switch_ip)) or die(print_r($query->errorInfo()));
		return $rs;
	}
    function getMaxIdSecteur()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_secteur) AS ID_secteur FROM secteur");
		$query->execute();
		return $query;
	}
	function getMaxCodeSecteur()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(code) AS code FROM secteur");
		$query->execute();
		return $query;
	}
    function getSecteurById($id)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_secteur,code,nom_secteur,adresse_secteur,switch_ip FROM secteur WHERE ID_secteur = ?");
		$query->execute([$id]);
		return $query;
	}
	function affichagePoint_acces()
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM point_acces WHERE isDelete = 0");
	 	$query->execute();
	 	return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getEquipementAttribuerAunClient($idclient)
    {
    	//SELECT  c.Nom_client,e.ID_equipement,model,fabriquant,type_equipement,date_attribution_equip FROM attribution_equipement_client att,equipement e,client c WHERE c.ID_client = att.ID_client AND e.ID_equipement = att.ID_equipement AND c.ID_client = ? 
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,e.ID_equipement,type_equipement,mo.name AS model,mk.name AS fabriquant,first_adress,date_attribution_equip,nom_user FROM client cl ,attribution_equipement_client att,equipement e,models as mo,makers as mk,user u WHERE e.ID_equipement = att.ID_equipement AND cl.ID_client =att.ID_client AND u.ID_user = att.ID_user AND e.model_id = mo.id AND mo.maker_id = mk.id AND cl.ID_client =? AND exist = 'oui'");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getEquipementAttribuerByIdClientAndIdEquipement($idclient,$idequipement)
    {
    	$con = connection();
    	$query = $con->prepare("SELECT * FROM `attribution_equipement_client` WHERE ID_client =:idclient AND ID_equipement =:idequipement");
    	$query->execute(['idclient' => $idclient,'idequipement' => $idequipement]);
    	return $query;
    }
    function attribuer_equipement_client($idclient,$idequipement,$datedistribution,$user)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO attribution_equipement_client(ID_client,ID_equipement,date_attribution_equip,ID_user) VALUE(:idclient,:idequipement,:datedistribution,:user)");

		$rs= $query->execute(array('idclient'=>$idclient,'idequipement'=>$idequipement,'datedistribution'=>$datedistribution,'user'=>$user)) or die(print_r($query->errorInfo()));
				return $rs;
	}
	function update_exist_attribution_equipement_client($idclient,$idequipement,$exist)
	{
		$con = connection();
		$query = $con->prepare("UPDATE attribution_equipement_client SET exist =:exist WHERE ID_client =:idclient AND ID_equipement =:idequipement");
		$res = $query->execute(['exist'=>$exist,'idclient'=>$idclient,'idequipement'=>$idequipement]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function recuperePointAccesNoDepasserClient()
	{
		//("SELECT ID_point_acces,nom FROM point_acces WHERE antenne_limite > anntena_count AND nom IS NOT NULL");
		$con = connection();
		$query = $con->prepare("SELECT ID_point_acces,nom FROM point_acces WHERE  nom IS NOT NULL");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getAccessPointById($id)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_point_acces,nom FROM point_acces WHERE ID_point_acces = ?");
		$query->execute([$id]);
		return $query;
	}
	function affichageSecteur()
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM secteur");
	 	$query->execute();
	 	return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function selection_Secteur()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_secteur,nom_secteur FROM secteur");
		$query->execute();
		$rs = array();
		while ($data =$query->fetchObject()) {
			# code...
			$rs[] = $data;
		}
		return $rs;
	}
	 function supprimer_point_acces($nupa)
	 {
	 	$con = connection();
	 	//$query = $con->prepare("DELETE FROM point_acces WHERE ID_point_acces = ?");
         $query = $con->prepare("UPDATE point_acces SET isDelete = 1 WHERE ID_point_acces = ?");
	 	$rs = $query->execute(array($nupa)) or die(print_r($query->errorInfo()));
	 	return $rs;
	 }
	function suppressionSecteur($Code_secteur)
	{
	 	$con = connection();
	 	//$query = $con->prepare("DELETE FROM secteur WHERE ID_secteur = ?");
        $query = $con->prepare("UPDATE secteur SET isDelete = 1 WHERE ID_secteur = ?");
	 	$rs = $query->execute(array($Code_secteur)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function update_point_acces($idpa,$nompa,$frequence,$ipa,$ant_limite_pa,$ssidpa,$mac_adress)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE point_acces SET nom =:nompa,frequence =:frequence,ip =:ipa,antenne_limite =:ant_limite_pa,SSID =:ssidpa,mac =:mac_adress WHERE ID_point_acces =:idpa");
		$rs = $query->execute(array('nompa' => $nompa,'frequence'=> $frequence,'ipa' => $ipa,'ant_limite_pa' => $ant_limite_pa,'ssidpa'=>$ssidpa,'idpa'=>$idpa,'mac_adress' =>$mac_adress)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function update_Secteur($id_secteur,$code,$nom_secteur,$adrese_secteur,$switch_ip)
	{
		$con = connection();
		$query = $con->prepare("UPDATE secteur SET code=:code,nom_secteur =:nom_secteur,adresse_secteur =:adrese_secteur,switch_ip=:switch_ip WHERE ID_secteur =:id_secteur");
		$rs = $query->execute(array('code'=>$code,'nom_secteur' => $nom_secteur,'adrese_secteur' => $adrese_secteur,'id_secteur'=>$id_secteur,'switch_ip'=>$switch_ip)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function deleteSecteur($Code_secteur)
	{
	 	$con = connection();
	 	$query = $con->prepare("DELETE FROM secteur WHERE ID_secteur = ?");
	 	$rs = $query->execute(array($Code_secteur)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function Total_secteur()
    {
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM secteur ");
		$query ->execute();
		return $query;

    }
    function Total_Base()
    {
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM point_acces ");
		$query ->execute();
		return $query;
    }
    function nombreEquipementParType()
    {
    	$con = connection();
    	$query = $con->prepare("SELECT COUNT(*) AS nb,type_equipement FROM equipement WHERE equipement.used ='non' GROUP BY type_equipement");
    	$query->execute() or die(print_r($query->errorInfo()));
    	return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function nombreAntenneParModel()
    {//SELECT COUNT(*) AS nb,type_equipement,model_id,mo.name AS model,mk.name AS fabriquant FROM equipement e,models mo,makers mk WHERE e.model_id = mo.id AND mo.maker_id = mk.id AND used = 'non' AND type_equipement = 'antenne' GROUP BY mo.id
    	$con = connection();
    	$query = $con->prepare("SELECT COUNT(*) AS nb,type_equipement,model_id,mo.name AS model,mk.name AS fabriquant FROM equipement e,models mo,makers mk WHERE e.model_id = mo.id AND mo.maker_id = mk.id AND used = 'non' AND type_equipement = 'antenne' GROUP BY mo.id");
    	$query->execute() or die(print_r($query->errorInfo()));
    	return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function nombreRouteurParModel()
    {
    	$con = connection();
    	$query = $con->prepare("SELECT COUNT(*) AS nb,type_equipement,model_id,mo.name AS model,mk.name AS fabriquant FROM equipement e,models mo,makers mk WHERE e.model_id = mo.id AND mo.maker_id = mk.id AND used = 'non' AND type_equipement = 'routeur' GROUP BY mo.id");
    	$query->execute() or die(print_r($query->errorInfo()));
    	return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function nombreRadioParModel()
    {
    	$con = connection();
    	$query = $con->prepare("SELECT COUNT(*) AS nb,type_equipement,model_id,mo.name AS model,mk.name AS fabriquant FROM equipement e,models mo,makers mk WHERE e.model_id = mo.id AND mo.maker_id = mk.id AND used = 'non' AND type_equipement = 'radio' GROUP BY mo.id");
    	$query->execute() or die(print_r($query->errorInfo()));
    	return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function nombreSwitchParModel()
    {
    	$con = connection();
    	$query = $con->prepare("SELECT COUNT(*) AS nb,type_equipement,model_id,mo.name,mk.name AS fabriquant FROM equipement e,models mo,makers mk WHERE e.model_id = mo.id AND mo.maker_id = mk.id AND used = 'non' AND type_equipement = 'switch' GROUP BY mo.id");
    	$query->execute() or die(print_r($query->errorInfo()));
    	return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function afficheAccessoire()
    {
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM accessoire a,categorieaccessoire c WHERE a.categorie_id = c.categorie_id");
	 	$query->execute();
	 	return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function afficheAccessoires()
    {
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM accessory_journal a,categorieaccessoire c WHERE a.categorie_id = c.categorie_id AND mouvement = 'entree'");
	 	$query->execute();
	 	return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getAccessories()
    {
	 	$con = connection();
	 	$query = $con->prepare("SELECT c.categorie_id,categorie,SUM(in_store - out_store) AS quantite  FROM accessory_journal a,categorieaccessoire c WHERE a.categorie_id = c.categorie_id GROUP BY c.categorie_id HAVING quantite");
	 	$query->execute();
	 	return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getEntranceAccessoryBeforeAdate($categorie_id,$operation_date)
    {
	 	$con = connection();
	 	$query = $con->prepare("SELECT SUM(in_store) AS in_store FROM accessory_journal a,categorieaccessoire c WHERE a.categorie_id = c.categorie_id AND operation_date < :operation_date AND c.categorie_id = :categorie_id AND mouvement = 'entree'");
	 	$query->execute(['operation_date'=>$operation_date,'categorie_id'=>$categorie_id]);
		return $query->fetch()['in_store'];
	}
	function getOutAccessoryBeforeAdate($categorie_id,$operation_date)
    {
	 	$con = connection();
	 	$query = $con->prepare("SELECT SUM(out_store) AS out_store FROM accessory_journal a,categorieaccessoire c WHERE a.categorie_id = c.categorie_id AND operation_date < :operation_date AND c.categorie_id = :categorie_id AND mouvement = 'sortie'");
	 	$query->execute(['operation_date'=>$operation_date,'categorie_id'=>$categorie_id]);
		return $query->fetch()['out_store'];
	}
    function filteEntreeAccessoires($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT a.id,categorie,in_store,description,DATE_FORMAT(operation_date,'%d/%m/%Y') AS operation_date FROM accessory_journal a,categorieaccessoire c WHERE a.categorie_id = c.categorie_id AND mouvement='entree' $condition");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function raportAccessoires($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT a.id,categorie,in_store,out_store,description,DATE_FORMAT(operation_date,'%d/%m/%Y') AS operation_date,sortie_par,demander_par,destination,destination_detail,mouvement FROM accessory_journal a,categorieaccessoire c WHERE a.categorie_id = c.categorie_id $condition ORDER BY a.operation_date ASC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function detail_accessoire($idaccessoire)
	{

	 	$con = connection();
	 	$query = $con->prepare("SELECT accessoire.ID_accessoire FROM sotie_stock,accessoire WHERE accessoire.ID_accessoire = sotie_stock.ID_accessoire AND sotie_stock.ID_accessoire =? GROUP BY sotie_stock.ID_accessoire");
	 	$query->execute(array($idaccessoire)) or die(print_r($query->errorInfo()));
	 	return $query;
	}
	function getAccessoireAunClient($idclient)
    {
		$con = connection();
		$query = $con->prepare("SELECT c.Nom_client,at_ac.quantite,at_ac.motifs,at_ac.dateattribaccessoire,ac.categorie FROM attribution_accessoire_client at_ac,client c,user us,accessoire ac WHERE c.ID_client =at_ac.ID_client AND ac.ID_accessoire =at_ac.ID_accessoire AND c.ID_client =? GROUP BY c.Nom_client ");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
    }
	function demenagerClientPointAcces($idclient,$idpointacces)
	{
		$con = connection();
		$query = $con->prepare("UPDATE installation SET ID_point_acces = :idpointacces WHERE ID_client = :idclient");
		$rs = $query->execute(array('idclient' => $idclient,'idpointacces' => $idpointacces)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function selection_Categorie()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM categorie");
		$query->execute();
		$rs = array();
		while ($data =$query->fetchObject()) {
			# code...
			$rs[] = $data;
		}
		return $rs;
	}
	/*function categorie_contenant1accessoire()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_accessoire,cat.categorie,quantite,commentaire,date_entre FROM categorie cat,accessoire acc WHERE acc.categorie = cat.categorie");
		$query->execute();
		$rs = array();
		while ($data =$query->fetchObject()) {
			# code...
			$rs[] = $data;
		}
		return $rs;
	}*/
	
	function getEquipement_avantsupression($idequipement)
    {
		$con = connection();
		$query = $con->prepare("SELECT ID_equipement,type_equipement,model,fabriquant,date_stock,ID_user FROM equipement WHERE ID_equipement =? ");
		$query->execute(array($idequipement)) or die(print_r($query->errorInfo()));
		return $query;
    }
    function insererHistoriqueStock($id,$model,$fabriquant,$type_equipement,$date_stock,$user)
    {
    	$con = connection();
		$query = $con->prepare("INSERT INTO historique_stock(ID_equipement,model,fabriquant,type_equipement,date_stock,ID_user) VALUES(:id,:model,:fabriquant,:type_equipement,:date_stock,:user)");
		$res= $query->execute(array('id'=>$id,'model' => $model,'fabriquant' => $fabriquant,'type_equipement' => $type_equipement,'date_stock' => $date_stock,'user' => $user)) or die(print_r($query->errorInfo()));
		
		return $res;
    }
   
    function getEquipement_Dun_client($idclient)
    {
		$con = connection();
		//$query = $con->prepare("SELECT cl.ID_client,e.ID_equipement,type_equipement,model,fabriquant,first_adress,date_attribution_equip,nom_user FROM client cl ,attribution_equipement_client att,equipement e,user u WHERE e.ID_equipement = att.ID_equipement AND cl.ID_client =att.ID_client AND u.ID_user = att.ID_user AND cl.ID_client =? AND exist = 'oui'");
        $query = $con->prepare("SELECT cl.ID_client,e.ID_equipement,type_equipement,mo.name AS model,mk.name AS fabriquant,first_adress,date_attribution_equip,nom_user FROM client cl ,attribution_equipement_client att,equipement e,models mo,makers mk,user u WHERE e.ID_equipement = att.ID_equipement AND cl.ID_client =att.ID_client AND mo.id = e.model_id AND mo.maker_id = mk.id AND u.ID_user = att.ID_user AND cl.ID_client =? AND exist = 'oui'");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
    }
    /* function getEquipementUn_client($idclient)
    {
		$con = connection();
		$query = $con->prepare("SELECT e.ID_equipement,type_equipement,model,fabriquant,mac,date_attribution_equip,c.Nom_client FROM equipement e,macadresse mac,attribution_equipement_client at_equip,client c WHERE e.ID_equipement = mac.ID_equipement AND e.ID_equipement = at_equip.ID_equipement AND c.ID_client =at_equip.ID_client AND c.ID_client =? GROUP BY e.type_equipement");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
    }*/
	function recupereRouteur()
	{
		$con = connection();
		//$query = $con->prepare("SELECT * FROM equipement WHERE type_equipement = 'routeur' AND used = 'non'");
        $query = $con->prepare("SELECT ID_equipement,model_id,mo.name AS model,mk.name AS fabriquant,type_equipement,date_stock,first_adress,e.description FROM equipement e,models mo,makers mk WHERE e.model_id = mo.id AND mo.maker_id = mk.id AND type_equipement = 'routeur' AND used = 'non'  ORDER BY ID_equipement");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function ajouterCategorieAccessoire($categorie)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO categorieaccessoire(categorie) VALUE(:categorie)");

		$rs= $query->execute(array('categorie'=>$categorie)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function getCategorieAccessoires()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM categorieaccessoire");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getCategorieAccessoireIsInJournal()
	{
		$con = connection();
		$query = $con->prepare("SELECT DISTINCT(c.categorie_id),categorie FROM categorieaccessoire c,accessory_journal a WHERE c.categorie_id = a.categorie_id");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getCategorieAccessoire($categorie_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM categorieaccessoire WHERE categorie_id = :categorie_id");
		$query->execute(['categorie_id' => $categorie_id]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function updateCategorieAccessoire($categorie_id,$categorie)
	{
		$con = connection();
		$query = $con->prepare("UPDATE categorieaccessoire SET categorie=:categorie WHERE categorie_id =:categorie_id");
		$res = $query->execute(['categorie' => $categorie,'categorie_id' => $categorie_id]);
		return $res;
	}
	function deleteCategorieAccessoire($categorie_id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM categorieaccessoire WHERE categorie_id = ?");
		$res = $query->execute([$categorie_id]);
		return $res;
	}
	/*function ajouterAccessoire($categorie_id,$quantite,$commentaire,$date_entre)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO accessoire(categorie_id,quantite,commentaire,date_entre) VALUE(:categorie_id,:quantite,:commentaire,:date_entre)");

		$rs= $query->execute(array('categorie_id'=>$categorie_id,'quantite'=>$quantite,'commentaire'=>$commentaire,'date_entre'=>$date_entre)) or die(print_r($query->errorInfo()));
			return $rs;
	}*/
    function ajouterAccessoire($categorie_id,$quantite,$commentaire,$date_entre,$created_by,$mouvement)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO accessory_journal(categorie_id,in_store,description,operation_date,mouvement,created_by) VALUE(:categorie_id,:quantite,:commentaire,:date_entre,:mouvement,:created_by)");

		$rs= $query->execute(array('categorie_id'=>$categorie_id,'quantite'=>$quantite,'commentaire'=>$commentaire,'date_entre'=>$date_entre,'mouvement' => $mouvement,'created_by'=>$created_by)) or die(print_r($query->errorInfo()));
			return $rs;
	}
    function updateEntrerAccessoire($categorie_id,$quantite,$commentaire,$date_entre,$mouvement,$id)
	{
		$con = connection();
		$query = $con->prepare("UPDATE accessory_journal SET categorie_id=:categorie_id,in_store=:in_store,description=:description,operation_date=:operation_date,mouvement=:mouvement WHERE id=:id");

		$rs = $query->execute(array('categorie_id'=>$categorie_id,'in_store'=>$quantite,'description'=>$commentaire,'operation_date'=>$date_entre,'mouvement' => $mouvement,'id'=>$id)) or die(print_r($query->errorInfo()));
			return $rs;
	}
	function SetHisto_accessoire($accessoire_id,$quantite,$commentaire,$date_entre,$entree_par,$sortie_par,$sortie_accessoire_id,$mouvement)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO  historique_accessoire(accessoire_id,quantite,commentaire,date_entre,entree_par,sortie_par,sortie_accessoire_id,mouvement) VALUE(:accessoire_id,:quantite,:commentaire,:date_entre,:entree_par,:sortie_par,:sortie_accessoire_id,:mouvement)");

		$rs = $query->execute(array('accessoire_id'=>$accessoire_id,'quantite'=>$quantite,'commentaire'=>$commentaire,'date_entre'=>$date_entre,'entree_par'=>$entree_par,'sortie_par'=>$sortie_par,'sortie_accessoire_id'=>$sortie_accessoire_id,'mouvement'=>$mouvement)) or die(print_r($query->errorInfo()));
			return $rs;
	}
	/*function getMaxIdAccessoire()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_accessoire) AS ID_accessoire FROM accessoire");
		$query->execute();
		return $query;
	}*/
    function getMaxIdAccessoire()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(id) AS accessory_journal_id FROM accessory_journal");
		$query->execute();
		return $query;
	}
	function recupererAccessoire($categorie_id)
    {
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM accessoire WHERE categorie_id = ?");
	 	$query->execute(array($categorie_id));
	 	return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function selectionaccessoire()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_accessoire,categorie,quantite,commentaire,date_entre FROM accessoire");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function diminuer_QteAccessoire_stock($accessoire,$quantite)
	{
		$con = connection();
		$query = $con->prepare("UPDATE accessoire SET quantite = quantite - :quantite WHERE ID_accessoire = :accessoire");
		$res = $query->execute(array('quantite' => $quantite,'accessoire' => $accessoire)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function attribuer_accessoire($idclient,$idaccessoire,$date_attribution,$idUser,$quantite,$motifs)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO attribution_accessoire_client(ID_client,ID_accessoire,dateattribaccessoire,ID_user,quantite,motifs) VALUES(:idclient,:idaccessoire,:date_attribution,:idUser,:quantite,:motifs)");
		$res = $query->execute(array('idclient' => $idclient,'idaccessoire' => $idaccessoire,'date_attribution' => $date_attribution,'idUser' => $idUser,'quantite' => $quantite,'motifs' => $motifs)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function AugmenterQuantiteAccesoir($idaccessoire,$quantite)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE accessoire SET quantite = quantite + :quantite WHERE ID_accessoire = :idaccessoire");
	 	$res = $query->execute(array('idaccessoire' => $idaccessoire,'quantite' => $quantite)) or die(print_r($query->errorInfo()));
	 	return $res;
	}
    function DiminuerQte_sotie($idsortie,$quantite)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE sotie_stock SET quantite = quantite - :quantite WHERE ID_sortie_stock= :idsortie");
	 	$res = $query->execute(array('idsortie' => $idsortie,'quantite' => $quantite)) or die(print_r($query->errorInfo()));
	 	return $res;
	}
	function update_accessoire($idaccessoire,$quantite,$commentaire)
	{
		$con = connection();		
		$query = $con->prepare("UPDATE accessoire SET quantite =:quantite,commentaire =:commentaire WHERE ID_accessoire =:idaccessoire");
			$rs = $query->execute(array( 'quantite' =>$quantite,'commentaire' => $commentaire, 'idaccessoire'=>$idaccessoire)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function modifier_sortie_stock($id_sortie/*,$quantite*/,$date_sortie,$motif)
	{
		$con = connection();		
		$query = $con->prepare("UPDATE sotie_stock SET /*quantite =:quantite,*/motif =:motif,date_sortie =:date_sortie WHERE ID_sortie_stock =:id_sortie");
			$rs = $query->execute(array( /*'quantite' =>$quantite,*/'motif' => $motif,'date_sortie'=>$date_sortie, 'id_sortie'=>$id_sortie)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	/*function suppression_accessoire($idaccessoire)
	{
	 	$con = connection();
	 	$query = $con->prepare("DELETE FROM accessoire WHERE ID_accessoire = ?");
	 	$rs = $query->execute(array($idaccessoire)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}*/
    function suppression_accessoire($idaccessoire)
	{
	 	$con = connection();
	 	$query = $con->prepare("DELETE FROM accessory_journal WHERE id = ?");
	 	$rs = $query->execute(array($idaccessoire)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function updateAntenne($numequipement,$model,$first_adress,$date_stock,$description)
	{
		$con = connection();
		$query = $con->prepare("UPDATE equipement SET model_id=:model,first_adress =:first_adress,date_stock =:date_stock,description =:description WHERE ID_equipement =:numequipement"); 
		$rs =$query->execute(array('model' => $model,'first_adress' => $first_adress,'date_stock'=>$date_stock,'description' => $description,'numequipement'=>$numequipement));
		$error = $query->errorInfo();
	
		return $rs;
	}
	function updateRouteur($id,$model,$fabriquant,$date_stock)
	{
		$con = connection();
		$query = $con->prepare("UPDATE equipement SET model=:model,fabriquant =:fabriquant,date_stock =:date_stock WHERE ID_equipement =:id"); 
		$rs =$query->execute(array('model' => $model,'fabriquant' => $fabriquant,'date_stock' => $date_stock,'id'=>$id));
		$error = $query->errorInfo();
		return $rs;//retour de la rquete stock dans rs
	}
    function updateEquipement($id,$model,$type_equipement,$first_adress,$nb_port,$description)
	{
		$con = connection();
		$query = $con->prepare("UPDATE equipement SET model_id=:model,type_equipement =:type_equipement,first_adress =:first_adress,nb_port=:nb_port,description=:description WHERE ID_equipement =:id"); 
		$rs =$query->execute(array('model' => $model,'type_equipement' => $type_equipement,'first_adress' => $first_adress,'nb_port' => $nb_port,'description'=>$description,'id'=>$id)) or die(print_r($query->errorInfo()));
		
		return $rs;
	}
	function updateMAC($numequipement,$mac)
	{
		$con = connection();
		$query = $con->prepare("UPDATE macadresse SET mac =:mac WHERE ID_equipement =:numequipement"); 
		$query->execute(array('mac' => $mac,'numequipement'=>$numequipement));
		$error = $query->errorInfo();

		return $query;
	}
	function afficheEtat_distribution()
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM distribution_carburant");
		$query->execute();
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function affiche_distribution_par_carburant($carburant)
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM distribution_carburant WHERE carburant = ?");
		$query->execute(array($carburant));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function distribuer_carburant($nature,$recepteur,$nblitres,$datedistribution,$distributeur)
	{	
		$con = connection();
		$query = $con->prepare("INSERT INTO distribution_carburant (carburant,consommateur,quantite,datedistribution,ID_user) VALUE(:nature,:recepteur,:nblitres,:datedistribution,:distributeur)");

		$rs= $query->execute(array('nature'=>$nature,'recepteur'=>$recepteur,'nblitres'=>$nblitres,'datedistribution'=>$datedistribution,'distributeur'=>$distributeur)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function DiminuerQuantiteCarburant($nature,$nombrelitre)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE stock_carburant SET quantite = quantite - :nombrelitre WHERE nature = :nature");
	 	$res = $query->execute(array('nature' => $nature,'nombrelitre' => $nombrelitre)) or die(print_r($query->errorInfo()));
	 	return $res;
	}
	function afficheEtat_stock_carbrant()
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM stock_carburant");
		$query->execute();
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function ajouter_carburant($nature,$nblitre,$prix_achat,$datesachat)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO stock_carburant(nature,quantite,prix_par_litre,datestock) VALUE(:nature,:nblitre,:prix_achat,:datesachat)");
		$query->execute(array('nature'=>$nature,'nblitre'=>$nblitre,'prix_achat'=>$prix_achat,'datesachat'=>$datesachat)); //or die(print_r($query->errorInfo()));
		return $query->errorInfo();
	}
	function AugmenterQuantiteCarburant($nature,$nombrelitre)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE stock_carburant SET quantite = quantite + :nombrelitre WHERE nature = :nature");
	 	$res = $query->execute(array('nature' => $nature,'nombrelitre' => $nombrelitre)) or die(print_r($query->errorInfo()));
	 	return $res;
	}
	function historique_ajouter_carburant($nature,$nblitre,$prix_achat,$datesachat)
	{

		$con = connection();
		$query = $con->prepare("INSERT INTO historique_stock_carburant(carburant,quantite,prix_par_litre,datestock) VALUE(:nature,:nblitre,:prix_achat,:datesachat)");

		$query->execute(array('nature'=>$nature,'nblitre'=>$nblitre,'prix_achat'=>$prix_achat,'datesachat'=>$datesachat)); //or die(print_r($query->errorInfo()));
			return $query->errorInfo();
	}
	function getHistoStockCarburant($carburant)
	{
		$con = connection();
		$query = $con->prepare("SELECT carburant,quantite,prix_par_litre,datestock FROM historique_stock_carburant WHERE carburant = ?");
		$query->execute(array($carburant)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function modifier_stock_carburant($refstock,$refnature,$refnblitre,$refprix_achat,$refdatesachat)
	{
		$con = connection();
		$query = $con->prepare("UPDATE stock_carburant SET nature=:refnature,quantite =:refnblitre, prix_par_litre =:refprix_achat,datestock =:refdatesachat WHERE ID_stock_carburant =:refstock"); 
		$rs =$query->execute(array('refnature' => $refnature,'refnblitre' => $refnblitre,'refprix_achat' => $refprix_achat,'refdatesachat'=>$refdatesachat,'refstock'=>$refstock));
		$error = $query->errorInfo();
	
		return $rs;
	}
	function deleteStockCarburant($num_stock)
	{
	    $con = connection();
	 	$query = $con->prepare("DELETE FROM stock_carburant WHERE ID_stock_carburant = ?");
	 	$rs = $query->execute(array($num_stock)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function affichage_stock_mensuel($date_debut,$date_fin)
	{
		$con = connection ();
		$query = $con->prepare("SELECT datestock,nature,quantite,prix_par_litre FROM stock_carburant WHERE datestock BETWEEN :date_debut AND :date_fin ORDER BY nature");
		$query->execute(array('date_debut'=>$date_debut,'date_fin'=>$date_fin)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function affichage_consommation_mensuel($date_debut,$date_fin)
	{
		$con = connection ();
		$query = $con->prepare("SELECT datedistribution,carburant,quantite,consommateur,ID_distribution FROM distribution_carburant WHERE datedistribution BETWEEN :date_debut AND :date_fin ORDER BY carburant");
		$query->execute(array('date_debut'=>$date_debut,'date_fin'=>$date_fin)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
    /*function getSortieAccessoires()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_sortie_accessoire,a.ID_accessoire,categorie,s.quantite,motif,date_sortie,sortie_par,demander_par,destination,destination_detail FROM sortie_accessoire s,accessoire a,categorieaccessoire c WHERE s.ID_accessoire = a.ID_accessoire AND a.categorie_id = c.categorie_id");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function getSortieAccessoires()
	{
		$con = connection();
		$query = $con->prepare("SELECT a.id,categorie,out_store,description,operation_date,sortie_par,demander_par,destination,destination_detail,mouvement FROM accessory_journal a,categorieaccessoire c WHERE a.categorie_id = c.categorie_id AND mouvement = 'sortie'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getSortieEquipements()
	{
		$con = connection();
		//$query = $con->prepare("SELECT ID_sortie,e.ID_equipement,first_adress,model,e.type_equipement,motif, date_sortie,sortie_par,demander_par,nom_user,destination,destination_detail,s.status FROM sortie_equipement s,equipement e,user u WHERE s.ID_equipement = e.ID_equipement AND u.ID_user = s.demander_par");
        $query = $con->prepare("SELECT ID_sortie,e.ID_equipement,first_adress,model_id,mo.name AS model,e.type_equipement,motif,date_sortie,sortie_par,demander_par,nom_user,destination,destination_detail,s.status,used FROM sortie_equipement s,equipement e,models mo,user u WHERE s.ID_equipement = e.ID_equipement AND u.ID_user = s.demander_par AND e.model_id = mo.id");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filterSortieEquipements($condition)
	{
		$con = connection();
		//$query = $con->prepare("SELECT ID_sortie,e.ID_equipement,model,e.type_equipement,motif,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_sortie,sortie_par,demander_par,nom_user,destination,destination_detail,s.status FROM sortie_equipement s,equipement e,user u WHERE s.ID_equipement = e.ID_equipement AND s.demander_par = u.ID_user $condition");
        $query = $con->prepare("SELECT ID_sortie,e.ID_equipement,first_adress,model_id,mo.name AS model,e.type_equipement,motif,date_sortie,sortie_par,demander_par,nom_user,destination,destination_detail,s.status FROM sortie_equipement s,equipement e,models mo,user u WHERE s.ID_equipement = e.ID_equipement AND u.ID_user = s.demander_par AND e.model_id = mo.id $condition");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    /*function filterSortieAccessoires($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT a.ID_accessoire,s.ID_sortie_accessoire,categorie,s.quantite,motif,DATE_FORMAT(date_sortie,'%d/%m/%Y') AS date_sortie,sortie_par,demander_par,destination,destination_detail FROM sortie_accessoire s,accessoire a,categorieaccessoire c WHERE s.ID_accessoire = a.ID_accessoire AND a.categorie_id = c.categorie_id $condition");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function filterSortieAccessoires($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT a.id,categorie,out_store,description,DATE_FORMAT(operation_date,'%d/%m/%Y') AS operation_date,sortie_par,demander_par,destination,destination_detail FROM accessory_journal a,categorieaccessoire c WHERE a.categorie_id = c.categorie_id AND mouvement='sortie' $condition");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function sortie_des_accessoire_en_stock($idaccessoire,$quantitesortie,$motif,$date_sortie,$sortie_par,$demander_par,$destination,$destination_detail)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO sortie_accessoire(ID_accessoire,quantite,motif,date_sortie,sortie_par,demander_par,destination,destination_detail) VALUES(:idaccessoire,:quantitesortie,:motif,:date_sortie,:sortie_par,:demander_par,:destination,:destination_detail)");
		$res = $query->execute(array('idaccessoire' => $idaccessoire,'quantitesortie' => $quantitesortie,'motif' => $motif,'date_sortie' => $date_sortie,'demander_par' => $demander_par,'sortie_par'=>$sortie_par,'destination'=>$destination,'destination_detail' => $destination_detail)) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function sortie_des_accessoire_en_stock($categorie_id,$description,$out_store,$operation_date,$sortie_par,$demander_par,$destination,$destination_detail,$mouvement,$created_by)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO accessory_journal(categorie_id,description,out_store,operation_date,sortie_par,demander_par,destination,destination_detail,mouvement,created_by) VALUES(:categorie_id,:description,:out_store,:operation_date,:sortie_par,:demander_par,:destination,:destination_detail,:mouvement,:created_by)");
		$res = $query->execute(array('categorie_id' => $categorie_id,'description' => $description,'out_store' => $out_store,'operation_date' => $operation_date,'demander_par' => $demander_par,'sortie_par'=>$sortie_par,'destination'=>$destination,'destination_detail' => $destination_detail,'mouvement'=>$mouvement,'created_by'=>$created_by)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function getMaxIdSortieAccessoireEnStock()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_sortie_accessoire) AS ID_sortie_accessoire FROM sortie_accessoire");
		$query->execute();
		return $query;
	}
    function sortier_equipement_en_stock($idequipement,$motif,$date_sortie,$sortie_par,$demander_par,$destination,$destination_detail)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO sortie_equipement(ID_equipement,motif,date_sortie,sortie_par,demander_par,destination,destination_detail) VALUES(:idequipement,:motif,:date_sortie,:sortie_par,:demander_par,:destination,:destination_detail)");
		$res = $query->execute(array('idequipement' => $idequipement,'motif' => $motif,'date_sortie' => $date_sortie,'demander_par' => $demander_par,'sortie_par'=>$sortie_par,'destination'=>$destination,'destination_detail' => $destination_detail)) or die(print_r($query->errorInfo()));
		return $res;
	}
   function updateDestinationDetailAndStatusToSortieEquipement($idsortie,$idequipement,$motif,$date_sortie,$sortie_par,$demander_par,$destination,$destination_detail,$status)
	{
		$con = connection();
		$query = $con->prepare("UPDATE sortie_equipement SET ID_equipement= :idequipement,motif= :motif,date_sortie= :date_sortie,sortie_par= :sortie_par,demander_par= :demander_par,destination= :destination,destination_detail= :destination_detail,status= :status  WHERE ID_sortie = :idsortie");
		$res = $query->execute(['idsortie' => $idsortie,'idequipement' =>$idequipement,'motif' =>$motif,'date_sortie' =>$date_sortie,'sortie_par' =>$sortie_par,'demander_par' =>$demander_par,'destination' => $destination,'destination_detail' =>$destination_detail,'status' => $status]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function updateStatusToSortieEquipement($idsortie,$status)
	{
		$con = connection();
		$query = $con->prepare("UPDATE sortie_equipement SET status = :status WHERE ID_sortie = :idsortie");
		$res = $query->execute(['status' => $status,'idsortie' => $idsortie]) or die(print_r($query->errorInfo()));
		return $res;
	}
    /*function deleteSortie_accessoire($idsortie)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM sortie_accessoire WHERE ID_sortie_accessoire = ?");
		$res = $query->execute([$idsortie]) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function deleteSortie_accessoire($idsortie)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM accessory_journal WHERE id = ?");
		$res = $query->execute([$idsortie]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function deleteSortie_equipement($idsortie)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM sortie_equipement WHERE ID_sortie = ?");
		$res = $query->execute([$idsortie]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function getsortie_stock($idaccessoire)
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_sortie_stock,ID_accessoire,s.categorie,s.quantite,s.motif,s.date_sortie,serviteur,nom_user,destination FROM sotie_stock s,user u WHERE s.ID_user = u.ID_user AND s.ID_accessoire =?");
		$query->execute(array($idaccessoire)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function getHistoriqueEntre_stock(/*$idaccessoire*/)
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM historique_accessoire ");
		$query->execute(/*array($idaccessoire)*/) or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
		function detailFiche_stockparCategorie($categorie)
	{
		$con = connection ();
		$query = $con->prepare("SELECT accessoire.quantite AS qte_stock,historique_accessoire.categorie,historique_accessoire.quantite,historique_accessoire.commentaire,historique_accessoire.date_entre,responsable,mouvement,nom_user FROM historique_accessoire,accessoire,user,sotie_stock WHERE historique_accessoire.categorie = accessoire.categorie AND user.ID_user = sotie_stock.ID_user AND historique_accessoire.categorie =? GROUP BY historique_accessoire.ID_historique_accessoire");
		$query->execute(array($categorie)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function filtreSortie_stock($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_accessoire,s.categorie,s.quantite,s.motif,s.date_sortie,serviteur,nom_user FROM sotie_stock s,user u WHERE s.ID_user = u.ID_user $condition");
		$query->execute() or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function totalqte_stock($categorie_accessoire)
	{
		//SELECT ID_accessoire,s.categorie,s.quantite,s.motif,s.date_sortie,serviteur,nom_user FROM sotie_stock s,user u WHERE s.ID_user = u.ID_user AND s.ID_accessoire =?
		$con = connection ();
		$query = $con->prepare("SELECT sum(quantite) as quantite_enstock FROM accessoire WHERE accessoire.categorie=?");
		$query->execute(array($categorie_accessoire)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
} 