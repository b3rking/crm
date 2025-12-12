<?php

/**
 * 
 */
class Service
{
	
	function ajouterService($nom,$montant,$monnaie,$description)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO service(nomService,montant,monnaie,description) VALUES(:nom,:montant,:monnaie,:description)");
		$rs = $query->execute(array('nom' => $nom,'montant' => $montant,'monnaie' => $monnaie,'description' => $description)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function recupererServices()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM service");
		$query->execute() or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function recupererService($idservice)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM service WHERE ID_service = ?");
		$query->execute(array($idservice)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function recupererServiceDunClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT s.ID_service,nomService FROM service s,client cl,contract co,serviceinclucontract si WHERE si.ID_service = s.ID_service AND si.ID_contract = co.ID_contract AND cl.ID_client = co.ID_client AND cl.ID_client = ?");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function updateService($idservice,$nom,$montant,$monnaie,$description)
	{
		$con = connection();
		$query = $con->prepare("UPDATE service SET nomService = :nom,montant =:montant,monnaie = :monnaie,description = :description WHERE ID_service = :idservice");
		$rs = $query->execute(array('nom' => $nom,'montant' => $montant,'monnaie' => $monnaie,'description' => $description,'idservice' => $idservice)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function deleteService($idservice)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM service WHERE ID_service = ?");
		$rs = $query->execute(array($idservice)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function getMaxIdservice()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_service) AS ID_service FROM `service`");
		$query->execute();
		return $query;
	}

}