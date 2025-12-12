 
<?php
/**
 * 
 */
class Localisation
{
 

	function NouvelleLocalisation($locationS)
	{
		$con = connection();					
		$query = $con->prepare("INSERT INTO localisation(nom_localisation) VALUE(:locationS)");
		$rs = $query->execute(array('locationS' => $locationS)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function getLastLocalisation()
	{
		$con = connection();					
		$query = $con->prepare("SELECT MAX(ID_localisation) AS ID_localisation FROM localisation");
		$query->execute();
		return $query;
	}

	function afficheLocalisation()

	{
		$localisation = new Localisation();
	 	$con = connection();
	 	$query = $con->prepare("SELECT nom_localisation FROM localisation");
	 	$query->execute();
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
	function selectionLocalisation()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM localisation");
		$query->execute();
		$rs = array();
		while ($value =$query->fetchObject()) {
			# code..
			$rs[] = $value;
		}
		return $rs;
	}
	function Updatelocalisation($idlocalisation,$location)
	{
		$con = connection();
		$query = $con->prepare("UPDATE localisation SET nom_localisation =:location WHERE ID_localisation = :idlocalisation");
		$rs = $query->execute(array('location' => $location,'idlocalisation' => $idlocalisation)) or die(print_r($query->errorInfo()));
		return $rs;
	}

	function deletelocalisation($idlocalisation)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM localisation WHERE ID_localisation = ?");
		$rs = $query->execute(array($idlocalisation)) or die(print_r($query->errorInfo()));
		return $rs;
	}
    function nombreClientParLocalisation()
    {
    	$con = connection();
    	$query = $con->prepare("SELECT COUNT(*) AS nb,localisation.ID_localisation,nom_localisation FROM localisation,client WHERE client.ID_localisation = localisation.ID_localisation GROUP BY nom_localisation");
    	$query->execute() or die(print_r($query->errorInfo()));
    	$res = array();
    	while ($data = $query->fetchObject()) 
    	{
    		$res[] = $data;
    	}
    	return $res;
    }

}