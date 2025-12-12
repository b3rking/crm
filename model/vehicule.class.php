
<?php
/**
 * 
 */
class Vehicule
{


	function ajouterVehicule($plaque,$modele,$marque)
	{
		$con = connection();					
		$query = $con->prepare("INSERT INTO vehicule(immatriculation,modele,marque) VALUE(:plaque,:modele,:marque)");
		$rs = $query->execute(array('plaque' => $plaque,'modele' => $modele,'marque' => $marque)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function afficheVehicule()
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM vehicule");
	 	$query->execute();
	 	return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getVehiculeById($id)
	{
		$con = connection();
		$query = $con->prepare("SELECT immatriculation,modele,marque FROM vehicule WHERE immatriculation = ?");
		$query->execute([$id]);
		return $query;
	}
	function selection_plaque()
	{
		$con = connection();
		$query = $con->prepare("SELECT marque,immatriculation FROM vehicule");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function UpdateVehicule($newplaque,$plaque,$modele,$marque)
	{
		$con = connection();
		$query = $con->prepare("UPDATE vehicule SET immatriculation =:newplaque, modele = :modele, marque = :marque  WHERE immatriculation = :plaque");
		$rs = $query->execute(array('modele' => $modele,'marque' => $marque,'newplaque'=>$newplaque,'plaque'=>$plaque)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function deleteVehicule($plaque)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM vehicule WHERE immatriculation = ?");
		$rs = $query->execute(array($plaque)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function getVehiculeParCarburant($carburant)
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM `vehicule` WHERE nature = ?");
	 	$query->execute(array($carburant));
	 	$rs = array();
	 	while ( $data = $query->fetchObject()) 
	 	{
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
}