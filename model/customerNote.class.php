<?php

/**
 * 
 */
class CustomerNote
{
	
	function addNote($idclient,$description,$created_at,$created_by)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO customer_notes(ID_client,description,created_at,created_by) VALUES(:idclient,:description,:created_at,:created_by)");
		$res = $query->execute(['idclient'=>$idclient,'description'=>$description,'created_at'=>$created_at,'created_by'=>$created_by]);
		return $res;
	}
	function getCustomerNoteByClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT nom_client,n.description,n.created_at,n.created_by,nom_user FROM client cl,customer_notes n,user u WHERE cl.ID_client = n.ID_client AND u.ID_user = n.created_by AND cl.ID_client = ?");
		$query->execute([$idclient]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
}