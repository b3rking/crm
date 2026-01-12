
<?php
/**
 * 
 */
class ticket
{	

	/*function saveTicket($idclient,$probleme,$closed_by,$idUser,$created_at,$updated_at,$description,$ticket_type,$status)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO tickets(customer_id,problem,closed_by,admin_user_id,created_at,updated_at,description,ticket_type,status) VALUES (:idclient,:probleme,:closed_by,:idUser,:created_at,:updated_at,:description,:ticket_type,:status)");
		$rs = $query->execute(array('idclient' =>$idclient,'probleme' =>$probleme,'closed_by'=>$created_at,'idUser'=>$idUser,'created_at'=>$created_at,'updated_at'=>$created_at,'description'=>$description,'ticket_type' =>$ticket_type,'status'=>$status)) or die(print_r($query->errorInfo()));
		return $rs;
	}*/
    function saveTicket($idfiche=NULL,$idclient,$probleme,$closed_by,$idUser,$created_at,$updated_at,$description,$ticket_type,$status)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO tickets(customer_id,fiche_id,problem,closed_by,admin_user_id,created_at,updated_at,description,ticket_type,status) VALUES (:idclient,:fiche_id,:probleme,:closed_by,:idUser,:created_at,:updated_at,:description,:ticket_type,:status)");
		$rs = $query->execute(array('idclient' =>$idclient,'fiche_id'=>$idfiche,'probleme' =>$probleme,'closed_by'=>$created_at,'idUser'=>$idUser,'created_at'=>$created_at,'updated_at'=>$created_at,'description'=>$description,'ticket_type' =>$ticket_type,'status'=>$status)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function recupert()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM tickets");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function getTous_client_surTicket()
	{
		$con = connection();
	 	$query = $con->prepare("SELECT client.ID_client,Nom_client FROM client WHERE type_client <> 'gone' ORDER BY Nom_client");
	 	$query->execute();
	 	return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function afficheToustickets()
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT c.ID_client,Nom_client,t.id,ticket_type,problem,closed_by,admin_user_id,created_at,updated_at,description,status,nom_user FROM tickets t,client c,user u WHERE c.ID_client = t.customer_id AND u.ID_user = t.admin_user_id ORDER BY t.id DESC LIMIT 50");
	 	/*$query->execute() or die(print_r($query->errorInfo()));
	 	return $query->fetchAll(PDO::FETCH_OBJ);*/
	 	$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function filtreTickets($condition)
	{
		$con = connection();
		//$query = "SELECT c.ID_client,Nom_client,t.ID_ticket,type_ticket,corp_ticket,type_connection,statut,date_description FROM ticket t,client c,description_ticket d WHERE ,c.ID_client = t.ID_client AND ,d.ID_ticket = t.ID_ticket $condition GROUP BY t.ID_ticket ORDER BY date_description";
	
		$query =("SELECT c.ID_client,c.billing_number,c.adresse,c.mobile_phone,Nom_client,t.id,ticket_type,problem,closed_by,admin_user_id,created_at,updated_at,description,status,nom_user FROM tickets t,client c,user u WHERE c.ID_client = t.customer_id AND u.ID_user = t.admin_user_id $condition ORDER BY t.id DESC LIMIT 100");
		$statement = $con->prepare($query);
        $statement->execute() or die(print_r($statement->errorInfo()));
        return $statement->fetchAll(PDO::FETCH_OBJ);
	}
	function recupererTousTicketDunClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT c.ID_client,Nom_client,t.id,ticket_type,problem,closed_by,admin_user_id,created_at,updated_at,description,status,nom_user FROM tickets t,client c,user u WHERE c.ID_client = t.customer_id AND u.ID_user = t.admin_user_id AND c.ID_client = ? ORDER BY t.id ASC");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ($data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
				/* requete pour la gestion de ticket*/
	function ticketTotal() 
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM tickets ");
		$query ->execute();
		return $query;
	}
	function ticketAtendu()
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS ch FROM tickets WHERE status = 'ouvert'");
		$query ->execute();
		return $query;
	}

	function ticketRepondu()
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM tickets WHERE status = 'fermer'");
		$query ->execute();
		return $query;
	}
	function recupereTicket($idticket)
	{
		$con =connection();
		$query =$con->prepare("SELECT client.ID_client,client.billing_number,client.Nom_client,tickets.ticket_type,tickets.problem,tickets.description,tickets.status FROM client,tickets WHERE tickets.customer_id=client.ID_client AND tickets.id=?");
		$query->execute(array($idticket)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function recupereTousTicketParStatut($statut)
	{
		$con = connection();
		$query = $con->prepare("SELECT c.ID_client,Nom_client,t.id,ticket_type,t.description,problem,status,t.created_at,nom_user FROM tickets t,client c ,ticket_actions,user WHERE c.ID_client = t.customer_id AND ticket_actions.ticket_id = t.id AND t.admin_user_id = user.ID_user AND t.status = ? GROUP BY t.id LIMIT 100");
	 	$query->execute(array($statut));
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
    function updateTicketsCreatedAt($idticket,$date_creation)
	{
		$con = connection();
		$query = $con->prepare("UPDATE tickets SET created_at =:created_at WHERE id = :idticket");
		$res = $query->execute(['created_at' => $date_creation,'idticket'=>$idticket]);
		return $res;
	}
	function modifierUnticket($idticket,$date_ticket,$probleme,$des_ticket,$idclientupdateTicket)
	{
		
		$con = connection();
		$query = $con->prepare("UPDATE tickets SET problem=:probleme,description =:des_ticket,created_at =:date_ticket,customer_id =:idclientupdateTicket WHERE id =:idticket");
		$rs = $query->execute(array('probleme' => $probleme,'idticket' => $idticket,'des_ticket'=>$des_ticket,'date_ticket'=>$date_ticket,'idclientupdateTicket'=>$idclientupdateTicket)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function modifierDescription($ref,$informaticien,$date_description,$endroit,$description)
	{
		$con = connection();
		$query = $con->prepare("UPDATE ticket_actions SET admin_user_id=:informaticien,created_at =:date_description,means =:endroit,comment =:description WHERE id =:ref");
		$rs = $query->execute(array('description' => $description,'informaticien' => $informaticien,'endroit'=>$endroit,'date_description'=>$date_description,'ref'=>$ref)) or die(print_r($query->errorInfo()));
		return $rs;
	}
    function updateTicketActionCreatedAt($idticket,$date_creation)
	{
		$con = connection();
		$query = $con->prepare("UPDATE ticket_actions SET created_at = :created_at WHERE ticket_id = :idticket");
		$res = $query->execute(['created_at' => $date_creation,'idticket' => $idticket]);
		return $res;
	}
	function DeleteDescription($ref)
	{
		$con = connection();
	 	$query = $con->prepare("DELETE FROM ticket_actions WHERE id = ?");
	 	$rs = $query->execute(array($ref)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function updateDescriptionTicket($idticket,$date,$description)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE description_ticket SET description = :description WHERE ID_ticket = :idticket AND date_description = :date_description");
	 	$rs = $query->execute(array('idticket' => $idticket,'date_description' => $date,'description' => $description)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function supprimerticket($idticket)
	{
	 	$con = connection();
	 	$query = $con->prepare("DELETE FROM tickets WHERE id = ?");
	 	$rs = $query->execute(array($idticket)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function affichrUnticket($idticket)
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM tickets WHERE id = ?");
	 	$query->execute(array($idticket)) or die(print_r($query->errorInfo()));
	 	return $query;
	}
	function recupererDernierticket()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM `tickets` ORDER BY id DESC LIMIT 1");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query;
	}
	function fermerTicket($idticket,$user,$observation,$endroit,$date_fermeture)
	{
		$con = connection();
			$query = $con->prepare("INSERT INTO fermer_ticket (ID_ticket,technicien,observation,endroit,date_fermeture) VALUES (:idticket,:technicien,:observation,:endroit,:date_fermeture)");

		$rs = $query->execute(array('idticket' =>$idticket,'technicien' =>$user,'observation'=>$observation,'endroit' =>$endroit,'date_fermeture' =>$date_fermeture)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function updateStatus($idticket,$status)
	{
		$con = connection();
		$query = $con->prepare("UPDATE tickets SET status=:status WHERE id =:idticket");

		$rs = $query->execute(array('idticket' => $idticket,'status' => $status)) or die(print_r($query->errorInfo()));
		return $rs;
	}
    function changeCustomersToTickets($idticket,$customer_id)
	{
		$con = connection();
		$query = $con->prepare("UPDATE tickets SET customer_id=:customer_id WHERE id =:idticket");

		$rs = $query->execute(array('idticket' => $idticket,'customer_id' => $customer_id)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function deleteSuspension($idclient)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM suspension WHERE ID_client = ?");
		$res = $query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function VerifierTicketfermer($idticket)
	{
		$con = connection();
	 	$query = $con->prepare("SELECT status FROM tickets WHERE id= ?");
	 	$query->execute(array($idticket)) or die(print_r($query->errorInfo()));
	 	return $query;
	}
	function AffichageDetail_fermetureTicket($idticket)
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT * FROM fermer_ticket WHERE ID_ticket= ?");
	 	$query->execute(array($idticket));
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
	function recupererLesDescription($idticket)
	{
		$con = connection();
		$query = $con->prepare("SELECT u.ID_user,nom_user,id, ta.means,	comment,means,started_at,finished_at, 	created_at, 	updated_at,last_action FROM ticket_actions ta,user u WHERE ta.admin_user_id = u.ID_user AND ticket_id = ?");
		$query->execute(array($idticket)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function insertionDescription($ticket_id,$description,$endroit,$idUser,$started_at,$finished_at,$created_at,$updated_at,$last_action)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO ticket_actions(ticket_id,comment,means,admin_user_id,started_at,finished_at,created_at,updated_at,last_action) VALUES 
			(:ticket_id,:description,:endroit,:idUser,:started_at,:finished_at,:created_at,:updated_at,:last_action)");

		$rs = $query->execute(array('ticket_id' => $ticket_id,'description'=>$description,'endroit'=>$endroit,'idUser' => $idUser,'started_at'=>$started_at,'finished_at' => $finished_at,'created_at'=>$created_at,'updated_at'=>$updated_at,'last_action'=>$last_action)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function recupererDateFinBandePassante($idticket)
	{
		$con = connection();
		$query = $con->prepare("SELECT dateFin FROM `contenufiches` WHERE ID_ticket = ? AND (SELECT now()) >= dateFin");
		$query->execute(array($idticket)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function ajouterInstallation($ID_client,$ID_point_acces,$ID_user,$date_installation)
	{
		$con = connection();
		//$taille = count($ID_equipement);
		//for ($i=0; $i < $taille ; $i++) 
		{ 
			//$equipement = $ID_equipement[$i]; 
			$query = $con->prepare("INSERT INTO installation(ID_client,ID_point_acces,ID_user,date_installation) VALUES(:idclient,:ID_point_acces,:idUser,:date_installation)");
			$rs = $query->execute(array('idclient' => $ID_client,'ID_point_acces' => $ID_point_acces,'idUser' => $ID_user,'date_installation' => $date_installation)) or die(print_r($query->errorInfo()));
		}
		
		return $rs;
	}
	function insererUserFermerTicket($idUser,$idticket)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO userfermerticket VALUES(:idUser,:idticket)");
		$res = $query->execute(array('idUser' => $idUser,'idticket' => $idticket)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function recuperationIdticket()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(id) AS id FROM tickets");
		$query->execute() or die (print_r($query->errorInfo()));
		return $query;
	}

	/*
	* TRAITEMENT DES FICHES
	*/
    
    function getMaxIdFicheByType($type_fiche)
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_fiches) AS ID_fiches FROM fiches WHERE type_fiche = ?");
		$query->execute([$type_fiche]);
		return $query->fetchObject()->ID_fiches;
	}
	function getTechnicienByFicheIntervention($idfiche)
	{
		$con = connection();
		$query = $con->prepare("SELECT nom_user,DATE_FORMAT(f.date_creation,'%d/%m/%Y') AS date_creation FROM fiches f,user u WHERE u.ID_user = f.technicien AND ID_fiches = ?");
		$query->execute([$idfiche]);
		return $query;
	}
    function getUserCreerFicheByFicheId($idfiche)
	{
		$con = connection();
		$query = $con->prepare("SELECT nom_user,DATE_FORMAT(f.date_creation,'%d/%m/%Y') AS date_creation FROM fiches f,user u WHERE u.ID_user = f.ID_user AND ID_fiches = ?");
		$query->execute([$idfiche]);
		return $query;
	}
	function getVehiculeByFicheIntervention($idfiche)
	{
		$con = connection();
		$query = $con->prepare("SELECT DISTINCT(immatriculation) AS immatriculation,modele,marque,f.date_creation FROM fiches f,contenufiches c,vehicule v WHERE v.immatriculation = c.vehicule AND f.ID_fiches = c.ID_fiches AND f.ID_fiches = ?");
		$query->execute([$idfiche]);
		return $query;
	}
	function creerFiche($idUser,$type_fiche,$date_creation,$technicien=null)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO fiches(ID_user,type_fiche,technicien,date_creation) VALUES(:idUser,:type_fiche,:technicien,:date_creation)");
		$res = $query->execute(array('idUser' => $idUser,'type_fiche' => $type_fiche,'technicien' => $technicien,'date_creation' => $date_creation)) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function contenuFiche($idticket,$bande,$datedebut,$datefin,$vehicule,$date_installation,$dateRecuperation,$dateDemenager,$etat)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO contenufiches(ID_fiches,ID_ticket,bandeP,dateDebut,dateFin,vehicule,dateInstallation,dateRecuperation,dateDemenager,etat)
			SELECT ID_fiches,:idticket,:bande,:datedebut,:datefin,:vehicule,:date_installation,:dateRecuperation,:dateDemenager,:etat FROM fiches ORDER BY ID_fiches DESC LIMIT 1");
		$res = $query->execute(array('idticket' => $idticket,'bande' => $bande,'datedebut' => $datedebut,'datefin' => $datefin,'vehicule' => $vehicule,'date_installation' => $date_installation,'dateRecuperation' => $dateRecuperation,'dateDemenager' => $dateDemenager,'etat'=>$etat)) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function contenuFiche($idfiche,$idticket,$bande,$datedebut,$datefin,$vehicule,$date_installation,$dateRecuperation,$dateDemenager,$etat)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO contenufiches(ID_fiches,ID_ticket,bandeP,dateDebut,dateFin,vehicule,dateInstallation,dateRecuperation,dateDemenager,etat)
			VALUES(:idfiche,:idticket,:bande,:datedebut,:datefin,:vehicule,:date_installation,:dateRecuperation,:dateDemenager,:etat)");
		$res = $query->execute(array('idfiche'=>$idfiche,'idticket' => $idticket,'bande' => $bande,'datedebut' => $datedebut,'datefin' => $datefin,'vehicule' => $vehicule,'date_installation' => $date_installation,'dateRecuperation' => $dateRecuperation,'dateDemenager' => $dateDemenager,'etat'=>$etat)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function updateFiche($idfiche,$date_creation)
	{
		$con = connection();
		$query = $con->prepare("UPDATE fiches SET date_creation =:date_creation WHERE ID_fiches =:idfiche");
		$res = $query->execute(['date_creation' => $date_creation,'idfiche' => $idfiche]);
		return $res;
	}
    function creerFicheDemanagement($idfiche,$dateDemenager,$idticket)
    {
        $con = connection();
        $query = $con->prepare("INSERT INTO contenufiches(ID_fiches,ID_ticket,dateDemenager) VALUES(:idfiche,:idticket,:dateDemenager)");
        $res = $query->execute(['idfiche'=>$idfiche,'dateDemenager'=>$dateDemenager,'idticket'=>$idticket]);
        return $res;
    }
    function updateContenuFicheDemenagement($id,$dateDemenager)
	{
		$con = connection();
		$query = $con->prepare("UPDATE contenufiches SET dateDemenager = :dateDemenager WHERE contenufiche_id = :contenufiche_id");
		$res = $query->execute(['dateDemenager' => $dateDemenager,'contenufiche_id' => $id]);
		return $res;
	}
    function updateContenuFicheRecuperation($id,$dateRecuperation)
	{
		$con = connection();
		$query = $con->prepare("UPDATE contenufiches SET dateRecuperation = :dateRecuperation WHERE contenufiche_id = :contenufiche_id");
		$res = $query->execute(['dateRecuperation' => $dateRecuperation,'contenufiche_id' => $id]);
		return $res;
	}
    function getMaxIdFiche()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_fiches) AS ID_fiches FROM fiches");
		$query->execute();
		return $query;
	}
    function getContenuDuneFiche($idfiche)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM contenufiches c,fiches f WHERE c.ID_fiches = f.ID_fiches AND f.ID_fiches = ? ORDER BY ID_ticket DESC");
		$query->execute([$idfiche]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function updateEtatContenuFiche($idticket)
	{
		$con = connection();
		$query = $con->prepare("UPDATE contenufiches SET etat = 1 WHERE ID_ticket = ?");
		$res = $query->execute(array($idticket)) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function recupererFicheInstallations()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,dateInstallation,cl.ID_client,Nom_client,telephone,mobile_phone,status FROM fiches f,contenufiches c,tickets,client cl WHERE f.ID_fiches = c.ID_fiches AND c.ID_ticket = tickets.id AND tickets.customer_id = cl.ID_client AND tickets.ticket_type = 'installation'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function recupererFicheInstallations()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,dateInstallation,cl.ID_client,Nom_client,telephone,mobile_phone,status,tickets.id FROM fiches f,contenufiches c,tickets,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = tickets.fiche_id AND tickets.customer_id = cl.ID_client AND f.type_fiche = 'installation'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function filtreInstallation($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,dateInstallation,cl.ID_client,Nom_client,telephone,mobile_phone,status,tickets.id FROM fiches f,contenufiches c,tickets,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = tickets.fiche_id AND tickets.customer_id = cl.ID_client AND f.type_fiche = 'installation' $condition ");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function recupererFicheDemenagements()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,dateDemenager,cl.ID_client,Nom_client,adresse,old_adresse,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND type_fiche = 'demenagement'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function recupererFicheDemenagements()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,dateDemenager,contenufiche_id,cl.ID_client,Nom_client,adresse,old_adresse,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND f.type_fiche = 'demenagement' ORDER BY f.date_creation DESC");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreDemenagement($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,dateDemenager,contenufiche_id,cl.ID_client,Nom_client,adresse,old_adresse,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND f.type_fiche = 'demenagement' $condition ORDER BY f.date_creation DESC");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function recupererFicheRecuperations()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,dateRecuperation,cl.ID_client,Nom_client,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND f.type_fiche = 'recuperation'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function recupererFicheRecuperations()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,dateRecuperation,cl.ID_client,Nom_client,status,t.id as idticket,contenufiche_id FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND f.type_fiche = 'recuperation'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreFicheRecuperation($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,dateRecuperation,cl.ID_client,Nom_client,status,t.id as idticket,contenufiche_id FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND f.type_fiche = 'recuperation' $condition");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function recupererFicheBandepanssantes()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,bandeP,dateDebut,dateFin,cl.ID_client,Nom_client,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND t.ticket_type = 'augmentationBP'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function recupererFicheBandepanssantes()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,bandeP,dateDebut,dateFin,cl.ID_client,Nom_client,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND f.type_fiche = 'augmentationBP'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreAugmentationBp($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,bandeP,dateDebut,dateFin,cl.ID_client,Nom_client,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND f.type_fiche = 'augmentationBP' $condition");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getFichesInterventions()
	{
		$con = connection();
		$query = $con->prepare("SELECT nom_user,ID_fiches,f.date_creation FROM fiches f,user u WHERE u.ID_user = f.technicien");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreFicheIntervention($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT nom_user,ID_fiches,f.date_creation FROM fiches f,user u WHERE u.ID_user = f.technicien $condition");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function recupererFicheDemenagement($idfiche)
	{
		$con = connection();
		/*$query = $con->prepare("SELECT cl.ID_client,cl.billing_number,type_client,Nom_client,telephone,mail,adresse,nomService,dateDemenager,nom_user FROM client cl,serviceinclucontract si,service s,contract co,fiches f,contenufiches c,tickets t,user u WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'demenagement' AND f.ID_fiches = ?");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;*
        $query = $con->prepare("SELECT cl.ID_client,cl.billing_number,type_client,Nom_client,telephone,mobile_phone,mail,adresse,old_adresse,dateDemenager,nom_user FROM client cl,fiches f,contenufiches c,tickets t,user u WHERE f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND f.type_fiche = 'demenagement' AND f.ID_fiches = ?");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;
	}*/
	function recupererFicheDemenagement($idfiche)
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,cl.billing_number,type_client,Nom_client,telephone,mobile_phone,mail,adresse,old_adresse,dateDemenager,nom_user FROM client cl,fiches f,contenufiches c,tickets t,user u WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'demenagement' AND f.ID_fiches = ?");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;
	}
	/*function recupererFicheRecuperation($idfiche)
	{//SELECT cl.ID_client,Nom_client,telephone,mail,adresse,nomService,dateRecuperation,nom_user FROM client cl,serviceinclucontract si,service s,contract co,fiches f,contenufiches c,tickets t,user u WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'recuperation' AND f.ID_fiches = ?
		$con = connection();
		$query = $con->prepare("

			SELECT cl.ID_client,billing_number,Nom_client,telephone,mobile_phone,mail,adresse,dateRecuperation,nom_user,type_client FROM client cl,fiches f,contenufiches c,tickets t,user u WHERE f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'recuperation' AND f.ID_fiches =? ");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;
	}*/
    function recupererFicheRecuperation($idfiche)
{
    $con = connection();
    $query = $con->prepare("
        SELECT 
            cl.ID_client,
            cl.billing_number,
            cl.Nom_client,
            cl.telephone,
            cl.mobile_phone,
            cl.mail,
            cl.adresse,
            dateRecuperation,
            nom_user,
            type_client,
            co.monnaie,    -- NEW: added from contract table
            co.amount      -- NEW: added from contract table
        FROM client cl,
             fiches f,
             contenufiches c,
             tickets t,
             user u,
             contract co   -- NEW: added contract table
        WHERE f.ID_fiches = c.ID_fiches 
        AND f.ID_fiches = t.fiche_id 
        AND t.customer_id = cl.ID_client 
        AND u.ID_user = f.ID_user 
        AND co.ID_client = cl.ID_client  -- NEW: join condition
        AND f.type_fiche = 'recuperation' 
        AND f.ID_fiches = ?
    ");
    $query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
    return $query;
}
	/*function recupererFicheInstallation($idfiche)
	{ 
	//SELECT cl.ID_client,Nom_client,telephone,mail,adresse,nomService,dateInstallation,nom_user FROM client cl,serviceinclucontract si,service s,contract co,fiches f,contenufiches c,tickets t,user u WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'installation' AND f.ID_fiches = ?
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,billing_number,type_client,Nom_client,telephone,mobile_phone,mail,adresse,f.date_creation,nom_user,cl.billing_number FROM client cl,fiches f,contenufiches c,tickets t,user u WHERE f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'installation' AND f.ID_fiches =?");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;
	}*/
	function recupererFicheInstallation($idfiche)
	{ 
	//SELECT cl.ID_client,Nom_client,telephone,mail,adresse,nomService,dateInstallation,nom_user FROM client cl,serviceinclucontract si,service s,contract co,fiches f,contenufiches c,tickets t,user u WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'installation' AND f.ID_fiches = ?
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,type_client,Nom_client,telephone,mobile_phone,mail,adresse,f.date_creation,nom_user,cl.billing_number FROM client cl,fiches f,contenufiches c,tickets t,user u WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'installation' AND f.ID_fiches =?");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;
	}
	/*function recupererFicheBandepanssante($idfiche)
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,billing_number,Nom_client,telephone,mobile_phone,mail,adresse,nomService,bandeP,dateDebut,dateFin,nom_user FROM client cl,serviceinclucontract si,service s,contract co,fiches f,contenufiches c,tickets t,user u WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'augmentationBP' AND f.ID_fiches = ?");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;
	}*/
	function recupererFicheBandepanssante($idfiche)
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,bandeP,dateDebut,dateFin,cl.ID_client,billing_number,Nom_client,telephone,mobile_phone,mail,adresse,t.status FROM fiches f,contenufiches c,tickets t,client cl WHERE  f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND f.type_fiche = 'augmentationBP' AND f.ID_fiches = ?");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function afficheTicket_client()		
	{//SELECT client.ID_client,client.Nom_client,client.adresse,client.telephone,tickets.id,tickets.status,tickets.ticket_type,tickets.created_at FROM client,tickets WHERE client.ID_client = tickets.customer_id  AND tickets.status='ouvert' AND ticket_type <> 'augmentationBP' AND ticket_type <> 'diminutionBP' AND tickets.id NOT IN (SELECT ID_ticket FROM contenufiches co,fiches f WHERE co.ID_fiches = f.ID_fiches AND f.type_fiche = 'intervention') ORDER BY tickets.created_at DESC
		//SELECT client.ID_client,client.Nom_client,client.adresse,client.telephone,tickets.id,tickets.status,tickets.ticket_type,tickets.created_at FROM client,tickets WHERE client.ID_client = tickets.customer_id  AND tickets.status='ouvert' AND ticket_type <> 'augmentationBP' AND ticket_type <> 'diminutionBP' ORDER BY tickets.created_at DESC
		$con = connection();
		$query = $con->prepare("SELECT DISTINCT client.ID_client,client.Nom_client,client.adresse,client.telephone,tickets.id,tickets.status,tickets.ticket_type,tickets.created_at FROM client,tickets,contenufiches co,fiches f WHERE client.ID_client = tickets.customer_id  AND tickets.status='ouvert' AND ticket_type <> 'augmentationBP' AND ticket_type <> 'diminutionBP' AND co.ID_fiches = f.ID_fiches AND f.type_fiche = 'intervention' ORDER BY tickets.created_at DESC");
		$query->execute();
	 	return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function selectionTicketFiche($idticket)
	{
		$con = connection();
		$query = $con->prepare("SELECT DISTINCT(client.ID_client),client.Nom_client,client.adresse,client.telephone,client.mobile_phone,tickets.id,tickets.status,tickets.ticket_type FROM client,tickets WHERE client.ID_client = tickets.customer_id AND id = ?");
		$query->execute(array($idticket)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function recupererTypeTickets()
	{
		$con = connection();
		$query = $con->prepare("SELECT DISTINCT(ticket_type) FROM tickets WHERE ticket_type IS NOT NULL");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	
	function getrecuperation()
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM `tickets` WHERE ticket_type='recuperation' AND status='ouvert' ");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchObject();
	}
	function getinstallation()
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nbreinstallation FROM `tickets` WHERE ticket_type='installation' AND status='ouvert'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchObject();
	}
	function getdemenagement()
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS demenagt FROM `tickets` WHERE ticket_type='demenagement' AND status='ouvert'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchObject();
	}
	/*function getdepannage()
	{
		$con =connection();
		$query = $con->prepare("SELECT COUNT(*) AS nombredepannage FROM `tickets` WHERE ticket_type='depannage' AND status='ouvert'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchObject();
	}*/
	function getdepannage()
	{
		$con =connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM `tickets` WHERE tickets.ticket_type='depannage' AND status='ouvert'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchObject();
	}
	
	function classement_technicien($idteck)
	{
		//SELECT COUNT(description_ticket.ID_user) AS nb, nom_user,prenom FROM user ,description_ticket,ticket,contenufiches WHERE user.ID_user = description_ticket.ID_user AND ticket.ID_ticket = description_ticket.ID_ticket AND ticket.ID_ticket = contenufiches.ID_ticket AND user.ID_user =:idteck GROUP BY user.ID_user
		
		$con = connection();
		$query = $con->prepare("SELECT COUNT(description_ticket.ID_user) AS nb, nom_user,prenom FROM user ,description_ticket,tickets,contenufiches WHERE user.ID_user = description_ticket.ID_user AND tickets.id = description_ticket.ID_ticket AND tickets.id = contenufiches.ID_ticket AND user.ID_user =15550 GROUP BY user.ID_user");
		$query->execute(['idteck' => $idteck]) or die(print_r($query->errorInfo()));
		return $query;
	}
	function installationParmois($mois,$annee)
	{
		//SELECT COUNT(*) AS nb FROM contenufiches,tickets WHERE tickets.id = contenufiches.ID_ticket AND MONTH(dateInstallation)= :mois AND YEAR(dateInstallation)= :annee 
		$con = connection();
		$query = $con->prepare(" SELECT COUNT(*) AS nb FROM tickets WHERE tickets.ticket_type ='installation' AND MONTH(tickets.created_at)= :mois AND YEAR(tickets.created_at)= :annee
			");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query;
	
	}
	function installation_parmois($mois,$annee)
	{
		
		$con = connection();
		$query = $con->prepare("SELECT client.ID_client,Nom_client,telephone,mail,adresse,tickets.created_at FROM client ,tickets WHERE client.ID_client =tickets.customer_id AND tickets.ticket_type='installation' AND MONTH(tickets.created_at)= :mois AND year(tickets.created_at) =:annee ");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		//return $query;
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function suppression_fiche($idfiche)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM fiches WHERE ID_fiches = ?");
		$res = $query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getBande($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT bandepassante,nomService FROM client cl,serviceinclucontract si,service s,contract co WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND cl.ID_client =? ");
		$query->execute(array($idclient));
		return $query;
	//	return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function recupererFicheDiminution_Bandepanssantes()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,bandeP,dateDebut,dateFin,cl.ID_client,Nom_client,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND t.ticket_type = 'diminutionBP'");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}*/
    function recupererFicheDiminution_Bandepanssantes()
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,bandeP,dateDebut,dateFin,cl.ID_client,billing_number,Nom_client,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND f.type_fiche = 'diminutionBP'");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreFicheDiminutionBp($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT f.ID_fiches,f.date_creation,bandeP,dateDebut,dateFin,cl.ID_client,Nom_client,status FROM fiches f,contenufiches c,tickets t,client cl WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND f.type_fiche = 'diminutionBP' $condition");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    /*function regenfichediminution_bp($idfiche)
	{
		//SELECT cl.ID_client,Nom_client,telephone,mail,adresse,nomService,bandeP,dateDebut,dateFin,nom_user FROM client cl,serviceinclucontract si,service s,contract co,fiches f,contenufiches c,tickets t,user u WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'augmentationBP' AND f.ID_fiches = ?
		
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,billing_number,Nom_client,telephone,mail,adresse,bandeP,dateDebut,dateFin,nom_user FROM client cl,fiches f,contenufiches c,tickets t,user u WHERE f.ID_fiches = c.ID_fiches AND c.ID_ticket = t.id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND t.ticket_type = 'diminutionBP' AND f.ID_fiches =?");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;
	}*/
    function regenfichediminution_bp($idfiche)
	{
		
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,billing_number,Nom_client,telephone,mail,adresse,bandeP,dateDebut,dateFin,nom_user FROM client cl,fiches f,contenufiches c,tickets t,user u WHERE f.ID_fiches = c.ID_fiches AND f.ID_fiches = t.fiche_id AND t.customer_id = cl.ID_client AND u.ID_user = f.ID_user AND f.type_fiche = 'diminutionBP' AND f.ID_fiches =?");
		$query->execute(array($idfiche)) or die(print_r($query->errorInfo()));
		return $query;
	}
}	