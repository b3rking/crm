
<?php
/**
 * 
 */
class TypeClient
{
	
	function ajouterType($type)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO typeclient(libelle) VALUES(?)");
		$rs = $query->execute(array($type)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function affecterTypeClient($idClient,$idType)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO affectertypeclient(ID_client,ID_type) VALUES(:idClient,:idType)");
		$rs = $query->execute(array('idClient' => $idClient,'idType' => $idType)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function recupererTypes()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM typeclient");
		$query->execute() or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function libelletypeClient()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM typeclient");
		$query->execute() or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function nombreClientParType($type)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nbclient FROM client WHERE type_client = ? AND isDelete = 0");
		$query->execute(array($type)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function updateType($idtype,$type)
	{
		$con = connection();
		$query = $con->prepare("UPDATE typeclient SET libelle = :libelle WHERE ID_type = :idtype");
		$rs = $query->execute(array('idtype' => $idtype,'libelle' => $type)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function deleteType($idtype)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM typeclient WHERE ID_type = ?");
		$rs = $query->execute(array($idtype)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function getMaxIdType()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_type) AS ID_type FROM `typeclient`");
		$query->execute();
		return $query;
	}
	function nombreClient_gratuit_termineted()
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nbclient FROM client WHERE type_client = 'free' AND etat = 'terminer'");
		$query->execute(array()) or die(print_r($query->errorInfo()));
		return $query;
	}
	function listeClient_gratuit()
	{
		$con = connection();
		$query = $con->query("SELECT cl.ID_client,Nom_client,billing_number,assujettiTVA,ID_contract,monnaie,next_billing_date FROM client cl,contract co WHERE cl.ID_client = co.ID_client AND cl.isDelete = 0");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
}
