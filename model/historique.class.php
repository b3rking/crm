<?php
/**
 * 
 */
class Historique
{
	
    function setHistoriqueAction($idAction,$type,$effectuerPar,$dateAction,$action)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO historiqueAction(	ID_action,type,effectuerPar,dateAction,action) VALUES
			(:idAction,:type,:effectuerPar,:dateAction,:action)");
		$res = $query->execute(['idAction' => $idAction,'type' => $type,'effectuerPar' => $effectuerPar,'dateAction' => $dateAction,'action' =>$action]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function filtreHistoriqueAction($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_action,type,effectuerPar,dateAction,action,u.nom_user FROM historiqueAction h,user u WHERE h.effectuerPar = u.ID_user $condition");
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
    function getHistoriqueActions()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_action,type,effectuerPar,dateAction,action,u.nom_user FROM historiqueAction h,user u WHERE h.effectuerPar = u.ID_user");
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getHistoriqueAction($type,$idAction)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_action,type,effectuerPar,dateAction,action,u.nom_user FROM historiqueAction h,user u WHERE h.effectuerPar = u.ID_user AND ID_action =:idAction AND type =:type");
		$query->execute(['idAction' => $idAction,'type' => $type]);
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
    
}