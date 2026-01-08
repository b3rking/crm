<?php

/**
 * 
 */
class Client
{
    function saveclient($idclient, $nomclient, $phone_mobile, $phone_fixe, $mail, $adresse, $commentaire, $personneDeContact, $type, $date_creation, $location, $langue, $nif, $tva, $etat, $parent_id = Null, $genre)
    {

        $con = connection();
        $query = $con->prepare("INSERT INTO client (ID_client,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,commentaire,ID_localisation,nif,langue,assujettiTVA,parent_id,type_client,date_creation,etat,genre) VALUES 
			(:idclient,:nomclient,:telephone,:mobile_phone,:mail,:adresse,:personneDeContact,:commentaire,:location,:nif,:langue,:tva,:parent_id,:type,:date_creation,:etat,:genre)");

        $rs = $query->execute(array('idclient' => $idclient, 'nomclient' => $nomclient, 'telephone' => $phone_fixe, 'mobile_phone' => $phone_mobile, 'mail' => $mail, 'adresse' => $adresse, 'commentaire' => $commentaire, 'personneDeContact' => $personneDeContact, 'date_creation' => $date_creation, 'location' => $location, 'nif' => $nif, 'langue' => $langue, 'tva' => $tva, 'parent_id' => $parent_id, 'type' => $type, 'etat' => $etat, 'genre' => $genre)) or die(print_r($query->errorInfo()));
        return $rs;
    }
    function setCustomerParent($parent_id, $child_id)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET parent_id = :parent_id WHERE ID_client = :child_id");
        $res = $query->execute(['parent_id' => $parent_id, 'child_id' => $child_id]);
        return $res;
    }
    function deleteChildCustomerToParent($child_id)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET parent_id = :parent_id WHERE ID_client = :child_id");
        $res = $query->execute(['parent_id' => NULL, 'child_id' => $child_id]);
        return $res;
    }
    function recupererClientActif()
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client FROM client cl,contract co WHERE co.ID_client = cl.ID_client AND co.etat = 'activer' AND cl.etat = 'actif' AND cl.isDelete=0");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    /*function afficheTousClients()
	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT ID_client,Nom_client,telephone,mail,adresse,personneDeContact,commentaire,type_client FROM client");
	 	$query->execute();
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data; 
	 	}
	 	return $rs;



	}*/

    function afficheTousClients()
    { //SELECT client.ID_client,billing_number,solde,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,commentaire,type_client,etat,nif,assujettiTVA,ID_localisation,langue,genre FROM client WHERE isDelete = 0 LIMIT 100
        $con = connection();
        $query = $con->prepare("SELECT cl.solde,cl.telephone,cl.mobile_phone,cl.mail,cl.adresse,cl.personneDeContact,cl.commentaire,cl.type_client,cl.etat,cl.nif,cl.assujettiTVA,cl.ID_localisation,cl.langue,cl.genre,
	co.ID_contract,si.bandepassante,si.montant AS tarif,numero,cl.ID_client,billing_number,Nom_client,type,SUM(si.montant) AS montant,co.monnaie,co.monnaie_facture,co.date_creation,co.etat,mode,facturation,startDate,co.tva,SUM(prixTva) AS prixTva,show_rate,enable_discounts,profil_id FROM client cl,serviceinclucontract si,service s,contract co,profil_articletocontract pa WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND co.ID_contract =pa.ID_contract AND co.isDelete = 0 AND cl.isDelete =0 GROUP BY co.ID_contract ORDER BY co.date_creation DESC LIMIT 400");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getClientPayants()
    {
        $con = connection();
        $query = $con->prepare("SELECT ID_client,Nom_client,telephone,mail,adresse,personneDeContact,commentaire,type_client,etat FROM client WHERE type_client = 'paying' AND isDelete =0");
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
    function recupererClientParType($type)
    {
        $con = connection();
        $query = $con->prepare("SELECT client.ID_client,billing_number,solde,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,commentaire,type_client,etat,nif,assujettiTVA,ID_localisation,langue FROM client WHERE type_client = ? AND isDelete = 0");
        $query->execute(array($type)) or die(print_r($query->errorInfo()));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function filtreClient($requete)
    {
        $con = connection();
        $query = $con->prepare($requete);
        $query->execute() or die(print_r($query->errorInfo()));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function totalClientParType()
    {
        $con = connection();
        $query = $con->prepare("SELECT type_client,COUNT(*) AS nombreclient FROM `client` WHERE isDelete = 0 GROUP BY type_client");
        $query->execute() or die(print_r($query->errorInfo()));
        $data = array();
        $type_client = '';
        while ($row = $query->fetchObject()) {
            if ($row->type_client == 'paying') $type_client = 'payant';
            if ($row->type_client == 'gone') $type_client = 'partie';
            if ($row->type_client == 'free') $type_client = 'gratuit';
            if ($row->type_client == 'potentiel') $type_client = 'potentiel';
            if ($row->type_client == 'staff') $type_client = 'staff';
            if ($row->type_client == 'unknown') $type_client = 'inconnu';
            $data[] = array(
                'label'  => $type_client,
                'value'  => $row->nombreclient
            );
        }
        $data = json_encode($data);
        return $data;
    }
    function totalClientsActif()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE type_client = 'paying' AND etat='actif' AND isDelete = 0");
        $query->execute();
        return $query->fetchObject();
    }
    function totalClientPayants()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE type_client = 'paying' AND isDelete=0");
        $query->execute();
        return $query->fetchObject();
    }
    function updateIpAdresseClient($idclient, $ip_address)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET ip_address =:ip_address WHERE ID_client = :idclient");
        $res = $query->execute(['ip_address' => $ip_address, 'idclient' => $idclient]) or die(print_r($query->errorInfo()));
        return $res;
    }
    function updateClietFromProformat($idclient, $nomclient, $telephone, $mail, $adresse, $localisation)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET Nom_client=:Nom_client,telephone=:telephone,mail=:mail,adresse=:adresse,ID_localisation=:idlocalisation WHERE ID_client=:idclient");
        $res = $query->execute(['Nom_client' => $nomclient, 'telephone' => $telephone, 'mail' => $mail, 'adresse' => $adresse, 'idlocalisation' => $localisation, 'idclient' => $idclient]) or die(print_r($query->errorInfo()));
        return $res;
    }
    /*function totalClientSansDete()
	{
		$con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client cl,balanceinitiale bi WHERE cl.ID_client = bi.ID_client AND solde <= 0 AND type_client = 'paying' AND etat = 'actif'");
        $query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchObject();
	}
	function getClientsEnDette()
	{
		$con = connection();
        $query = $con->prepare("SELECT cl.ID_client,cl.Nom_client,bi.solde,co.monnaie,si.montant FROM client cl,balanceinitiale bi,contract co,serviceinclucontract si WHERE co.ID_contract = si.ID_contract AND cl.ID_client = co.ID_client AND co.ID_client = si.ID_client AND cl.ID_client = bi.ID_client AND solde >0 AND type_client = 'paying' AND cl.etat = 'actif'");
        $query->execute() or die(print_r($query->errorInfo()));
        return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function totalClientEnDette()
	{
		$con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client cl,balanceinitiale bi,contract co,serviceinclucontract si WHERE co.ID_contract = si.ID_contract AND cl.ID_client = co.ID_client AND co.ID_client = si.ID_client AND cl.ID_client = bi.ID_client AND solde > 0 AND type_client = 'paying' AND cl.etat = 'actif'");
        $query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchObject();
	}*/
    function totalClientEnCoupure()
    {
        $con = connection();
        //$query = $con->prepare("SELECT COUNT(*) AS nb FROM client cl,coupure cp WHERE cl.ID_client = cp.ID_client AND type_client = 'paying' AND etat = 'coupure' AND action = 'couper' AND motif = 'dette'");
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE type_client = 'paying' AND etat = 'coupure' AND isDelete = 0");
        $query->execute() or die(print_r($query->errorInfo()));
        return $query->fetchObject();
    }
    function totalClientEnPause()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE type_client = 'paying' AND etat = 'pause' AND isDelete = 0");
        $query->execute();
        return $query->fetchObject();
    }
    /*function getAll_clientEnCoupure()
	{
		$con = connection();
        //$query = $con->prepare("SELECT cl.ID_client,cl.Nom_client FROM client cl,coupure cp WHERE cl.ID_client = cp.ID_client AND type_client = 'paying' AND etat = 'coupure' AND action = 'couper' AND motif = 'dette'");
        $query = $con->prepare("SELECT cl.ID_client,cl.Nom_client FROM client cl,coupure cp WHERE cl.ID_client = cp.ID_client AND type_client = 'paying' AND etat = 'coupure'");
        $query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function totalClientEnDerogation()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client cl WHERE type_client = 'paying' AND etat = 'actif' AND solde > 70000 AND isDelete = 0");
        $query->execute() or die(print_r($query->errorInfo()));
        return $query->fetchObject();
    }
    function listeclientderoguer()
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,cl.Nom_client FROM client cl,coupure cp WHERE cl.ID_client = cp.ID_client AND type_client = 'paying' AND etat = 'actif' AND motif = 'derogation' AND cl.isDelete = 0");
        $query->execute() or die(print_r($query->errorInfo()));

        $rs = array();

        while ($data = $query->fetchObject()) {
            # code...
            $rs[] = $data;
        }
        return $rs;
        //return $query->fetchObject();
    }
    function getClientEnDerogation()
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,Nom_client,telephone,mail,adresse,personneDeContact FROM client cl,coupure cp WHERE cl.ID_client = cp.ID_client AND type_client = 'paying' AND etat = 'actif' AND motif = 'derogation' AND cl.isDelete = 0");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function get_nombre_client_Actif()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE type_client = 'paying' AND etat = 'actif' AND isDelete = 0");
        $query->execute();
        return $query->fetch()['nb'];
    }
    function getClientActifs()
    {
        $con = connection();
        $query = $con->prepare("SELECT ID_client,billing_number,Nom_client,solde,telephone,mail,adresse,personneDeContact FROM client WHERE type_client = 'paying' AND etat = 'actif' AND isDelete = 0 ORDER BY nom_client");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getClientActifs_avec_mensualite()
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,billing_number,nom_client,(SUM(si.montant) * quantite) + ((SUM(si.montant) * quantite) * tva /100) AS montant,co.monnaie,next_billing_date,facturation FROM client cl,serviceinclucontract si,contract co WHERE si.ID_contract = co.ID_contract AND co.ID_client = cl.ID_client AND co.etat = 'activer' AND cl.etat = 'actif' AND si.status = 0 AND cl.isDelete = 0 AND co.isDelete = 0 GROUP BY co.ID_contract ORDER BY cl.Nom_client");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getClientDelinquants()
    {
        $con = connection();
        $query = $con->prepare("SELECT DISTINCT 
                c.ID_client,
                c.billing_number,
                c.Nom_client,
                c.solde,
                c.telephone,
                c.mail,
                c.adresse,
                c.personneDeContact,
                sic.bandepassante
            FROM client c
            LEFT JOIN contract cont ON c.ID_client = cont.ID_client
            LEFT JOIN serviceinclucontract sic ON cont.ID_contract = sic.ID_contract
            WHERE c.type_client = 'paying' 
                AND c.etat = 'actif' 
                AND c.solde >= 70000 
                AND c.isDelete = 0 
            ORDER BY c.billing_number ASC"
        );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function get_nombre_ClientActif_avec_Dette()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE solde >= 70000 AND type_client = 'paying' AND etat = 'actif' AND isDelete = 0");
        $query->execute();
        return $query->fetch()['nb'];
    }
    function get_nombre_clientActif_sans_Dette()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE solde <= 0 AND type_client = 'paying' AND etat = 'actif' AND isDelete = 0");
        $query->execute();
        return $query->fetch()['nb'];
    }
    function getClientActifSansDette()
    {
        $con = connection();
        $query = $con->prepare("SELECT ID_client,billing_number,Nom_client,solde,telephone,mail,adresse,personneDeContact FROM client WHERE type_client = 'paying' AND etat = 'actif' AND solde <= 0 AND isDelete = 0 ORDER BY billing_number DESC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function get_nombre_client_avec_solde_negatif()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE solde < 0 AND isDelete = 0");
        $query->execute();
        return $query->fetch()['nb'];
    }
    function getClient_avec_solde_negatif()
    {
        $con = connection();
        $query = $con->prepare("SELECT client.ID_client,billing_number,solde,Nom_client,telephone,mail,adresse,personneDeContact,commentaire,type_client,etat FROM client WHERE solde < 0 AND isDelete = 0 ORDER BY client.ID_client ASC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function get_nombre_client_parti_avec_dette()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE solde >= 50000 AND  type_client = 'gone' AND isDelete = 0");
        $query->execute();
        return $query->fetch()['nb'];
    }
    function getClientPartiAvecDette()
    {
        $con = connection();
        $query = $con->prepare("SELECT client.ID_client,billing_number,solde,Nom_client,telephone,mail,adresse,personneDeContact,commentaire,type_client,etat FROM client WHERE type_client = 'gone' AND solde >= 50000 AND isDelete = 0 ORDER BY billing_number DESC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function get_nombre_client_parti_sans_dette()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE solde = 0 AND  type_client = 'gone' AND isDelete = 0");
        $query->execute();
        return $query->fetch()['nb'];
    }
    function getClientPartiSansDette()
    {
        $con = connection();
        $query = $con->prepare("SELECT client.ID_client,billing_number,solde,Nom_client,telephone,mail,adresse,personneDeContact,commentaire,type_client,etat FROM client WHERE type_client = 'gone' AND solde = 0 AND isDelete = 0 ORDER BY billing_number DESC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getClientEnCoupure()
    {
        $con = connection();
        $query = $con->prepare("SELECT ID_client,billing_number,Nom_client,telephone,mail,adresse,personneDeContact,solde FROM client WHERE type_client = 'paying' AND etat = 'coupure' AND isDelete = 0 ORDER BY billing_number DESC");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function recupererMailDeClientParSecteur($idsecteur)
    {
        $con = connection();
        $query = $con->prepare("SELECT c.ID_client,Nom_client,telephone,mail,adresse,commentaire,type_client FROM client c,point_acces p,secteur s,installation ins WHERE c.ID_client = ins.ID_client AND p.ID_point_acces = ins.ID_point_acces AND p.secteur = s.ID_secteur AND s.ID_secteur = ? AND mail <> '' AND type_client = 'paying' AND etat = 'actif' AND c.isDelete = 0");
        $query->execute(array($idsecteur)) or die(print_r($query->errorInfo()));

        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function recupererMailDeClientActif()
    {
        $con = connection();
        $query = $con->prepare("SELECT mail FROM client WHERE mail <> '' AND type_client = 'paying' AND etat = 'actif' AND isDelete = 0");
        $query->execute();
        $res = $query->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
    function afficherUnClentAvecContract($idclient)
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,billing_number,solde,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,nif,cl.langue,type_client,cl.commentaire,cl.etat,SUM(si.montant * si.quantite) AS montant,tva,co.monnaie AS monnaieService,si.bandepassante,co.ID_contract,co.monnaie AS monnaieContract,monnaie_facture,co.date_creation,nomService,co.next_billing_date FROM client cl,serviceinclucontract si,service s,contract co WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND cl.ID_client=? AND si.status = 0 AND co.isDelete = 0 GROUP BY co.ID_contract");
        $query->execute(array($idclient)) or die(print_r($query->errorInfo()));
        return $query;
    }
    function afficherUnClientAvecfichier_contrat($idclient)
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,billing_number,Nom_client,telephone,mail,adresse,personneDeContact,nif,assujettiTVA,commentaire,type_client,s.montant,s.monnaie AS monnaieService,co.monnaie AS monnaieContract,co.date_creation,nomService,etat FROM client cl,serviceinclucontract si,service s,contract co WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND  cl.ID_client= ?");
        $query->execute(array($idclient)) or die(print_r($query->errorInfo()));
        return $query;
    }
    function afficherUnClentSansContract($idclient)
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,billing_number,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,commentaire,type_client,nif FROM client cl WHERE cl.ID_client = ?");
        $query->execute(array($idclient)) or die(print_r($query->errorInfo()));
        return $query;
    }
    function recupereDernierBillingNumber()
    {
        $con = connection();
        $query = $con->prepare("SELECT MAX(billing_number) AS billing_number FROM client");
        $query->execute();
        return $query;
    }
    function getNewClients($mois, $annee)
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nbclient FROM client,contract WHERE client.ID_client =contract.ID_client AND MONTH(contract.date_creation) = :mois AND YEAR(contract.date_creation) = :annee AND client.etat ='actif' AND client.isDelete = 0");
        $query->execute(['mois' => $mois, 'annee' => $annee]);
        return $query;
    }
    function getallClient($mois, $annee)
    {
        $con = connection();
        $query = $con->prepare("SELECT contract.date_creation,client.Nom_client,client.adresse,client.etat,client.billing_number FROM client,contract WHERE client.ID_client =contract.ID_client AND MONTH(contract.date_creation) = :mois AND YEAR(contract.date_creation) = :annee AND client.etat ='actif' AND client.isDelete = 0");
        $query->execute(['mois' => $mois, 'annee' => $annee]);

        return $query->fetchAll(PDO::FETCH_OBJ);
        //return $query;
    }

    function nombre_total_Client()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) as nbclient FROM client WHERE isDelete = 0");
        $query->execute() or die(print_r($query->errorInfo()));
        return $query;
    }
    function recupererDernierClient()
    {
        $con = connection();
        $query = $con->prepare("SELECT * FROM `client` ORDER BY ID_client DESC LIMIT 1");
        $query->execute() or die(print_r($query->errorInfo()));
        return $query;
    }
    function autocomplete($nom)
    {
        $con = connection();
        $query = $con->query("SELECT ID_client,billing_number,adresse,Nom_client FROM client WHERE Nom_client LIKE '%" . $nom . "%' AND isDelete = 0");
        $tb = array();
        while ($data = $query->fetchObject()) {
            $tb[] = $data;
        }
        return $tb;
    }
    function autocomplete_client_on_creer_contrat($nom)
    {
        $con = connection();
        $query = $con->query("SELECT ID_client,Nom_client,assujettiTVA FROM client WHERE type_client <> 'free' AND type_client <> 'staff' AND ID_client NOT IN(SELECT ID_client FROM contract) AND Nom_client LIKE '%" . $nom . "%' AND isDelete = 0");
        $tb = array();
        while ($data = $query->fetchObject()) {
            $tb[] = $data;
        }
        return $tb;
    }
    function get_customers_to_create_contrat()
    {
        $con = connection();
        $query = $con->query("SELECT ID_client,Nom_client FROM client WHERE type_client <> 'free' AND type_client <> 'staff' AND isDelete = 0 AND ID_client NOT IN(SELECT ID_client FROM contract)");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function autocompleteClientTicket($nom)
    {
        $con = connection();

        $stern = "'%" . $nom . "%'";
        //$query = $con->query("SELECT ID_client,Nom_client FROM client WHERE Nom_client LIKE '%".$nom."%'");
        //$query = $con->query("SELECT cl.ID_client,Nom_client,s.ID_service,nomService FROM service s,client cl,contract co,serviceinclucontract si WHERE si.ID_service = s.ID_service AND si.ID_contract = co.ID_contract AND cl.ID_client = si.ID_client AND cl.Nom_client LIKE $stern");

        $query = $con->query("SELECT DISTINCT cl.ID_client,Nom_client,s.ID_service,nomService FROM service s,client cl,contract co,serviceinclucontract si WHERE si.ID_service = s.ID_service AND si.ID_contract = co.ID_contract AND cl.ID_client = si.ID_client AND type_client <> 'gone' AND cl.Nom_client LIKE $stern AND cl.isDelete = 0 UNION ALL 
			SELECT ID_client,Nom_client,ID_service,nomService FROM service,client WHERE ID_service = 2 AND Nom_client LIKE $stern AND cl.isDelete = 0 GROUP BY client.ID_client");

        if (!$query) {
            die("Query failed: " . print_r($con->errorInfo(), true)); // Handle the error
        }

        $tb = array();
        while ($data = $query->fetchObject()) {
            $tb[] = $data;
        }
        return $tb;
    }
    function getClientToCreateTicket()
    {
        $con = connection();
        $query = $con->query("SELECT ID_client,billing_number,Nom_client,adresse FROM client WHERE type_client <> 'gone' AND type_client <> 'potentiel' AND isDelete = 0");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /*function getClient_a_recuperer_Equipement()
	{
		$con = connection();
		$query = $con->query("SELECT ID_client,billing_number,Nom_client,adresse FROM client WHERE type_client <> 'staff' AND isDelete = 0");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function autocompleteClientParentContract($nomclient)
    {
        $con = connection();
        $query = $con->query("SELECT cl.ID_client,Nom_client,billing_number,ID_contract,monnaie,next_billing_date FROM client cl,contract co WHERE cl.ID_client = co.ID_client AND co.etat = 'activer' AND type_client = 'paying' AND cl.etat = 'actif' AND Nom_client LIKE '%" . $nomclient . "%' AND isDelete = 0");
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getClientsToCreateInvoice()
    {
        $con = connection();
        $query = $con->query("SELECT cl.ID_client,Nom_client,billing_number,ID_contract,monnaie,next_billing_date FROM client cl,contract co WHERE cl.ID_client = co.ID_client AND co.etat = 'activer' AND type_client = 'paying' AND cl.etat = 'actif' AND cl.isDelete = 0 AND co.isDelete =0");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getClientsToCreateBalanceInitiale()
    {
        $con = connection();
        $query = $con->query("SELECT cl.ID_client,Nom_client,billing_number FROM client cl WHERE type_client = 'paying' OR type_client='gone' AND cl.isDelete = 0 AND ID_client NOT IN (SELECT ID_client FROM balanceinitiale)");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    /*function autocompleteClientOnCreerPayement($nomclient)
	{
		$con = connection();
		$query = $con->query("SELECT cl.ID_client,Nom_client,billing_number,assujettiTVA,ID_contract,monnaie,next_billing_date FROM client cl,contract co WHERE cl.ID_client = co.ID_client AND Nom_client LIKE '%".$nomclient."%'");
		$tb = array();
		while ($data = $query->fetchObject()) 
		{
			$tb[] = $data;
		}
		return $tb;
	}*/
    function getClientToCreatePayements()
    {
        $con = connection();
        $query = $con->query("SELECT cl.ID_client,Nom_client,billing_number,assujettiTVA,ID_contract,monnaie,next_billing_date FROM client cl,contract co WHERE cl.ID_client = co.ID_client AND cl.isDelete = 0");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function autocompleteClientFiltreFacture($nomclient)
    {
        $con = connection();
        $query = $con->query("SELECT cl.ID_client,Nom_client,billing_number,ID_contract,monnaie FROM client cl,contract co WHERE cl.ID_client = co.ID_client AND Nom_client LIKE '%" . $nomclient . "%' AND cl.isDelete = 0");
        $tb = array();
        while ($data = $query->fetchObject()) {
            $tb[] = $data;
        }
        return $tb;
    }
    function autocompleteClientDonnerCaution($nomclient)
    {
        $con = connection();
        $query = $con->query("SELECT cl.ID_client,Nom_client,billing_number,ID_contract,monnaie FROM client cl,contract co WHERE cl.ID_client = co.ID_client AND co.etat = 'activer' AND type_client = 'paying' AND cl.etat = 'actif' AND Nom_client LIKE '%" . $nomclient . "%' AND isDelete = 0");
        $tb = array();
        while ($data = $query->fetchObject()) {
            $tb[] = $data;
        }
        return $tb;
    }
    function getUnClientAcouper($nomclient)
    {
        $con = connection();
        $query = $con->query("SELECT ID_client,Nom_client,type_client FROM client WHERE etat = 'actif' AND Nom_client LIKE '%" . $nomclient . "%' AND isDelete = 0");
        $tb = array();
        while ($data = $query->fetchObject()) {
            $tb[] = $data;
        }
        return $tb;
    }
    function getClient_a_activer()
    {
        $con = connection();
        $query = $con->prepare("SELECT ID_client,Nom_client,billing_number,type_client FROM client WHERE etat='coupure' AND isDelete = 0");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function nbClientEnPause()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE etat = 'pause' AND type_client = 'paying' AND isDelete = 0");
        $query->execute();
        return $query->fetchObject()->nb;
    }

    function updateClient($genre, $idclient, $billing, $nom, $fixed_phone, $mobile_phone, $mail, $adresse, $pers_cont, $note, $location, $nif, $langue, $tva, $type)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET Nom_client =:nom,telephone =:telephone,mobile_phone=:mobile_phone,mail =:mail,adresse =:adresse,personneDeContact=:pers_cont,type_client =:type,langue = :langue,billing_number =:billing,ID_localisation =:location,nif =:nif,commentaire =:note,assujettiTVA =:tva,genre =:genre WHERE ID_client =:idclient");
        $rs = $query->execute(array('nom' => $nom, 'telephone' => $fixed_phone, 'mobile_phone' => $mobile_phone, 'mail' => $mail, 'adresse' => $adresse, 'pers_cont' => $pers_cont, 'idclient' => $idclient, 'type' => $type, 'langue' => $langue, 'billing' => $billing, 'location' => $location, 'nif' => $nif, 'note' => $note, 'tva' => $tva, 'genre' => $genre)) or die(print_r($query->errorInfo()));
        return $rs;
    }
    function getSoldeClient($idclient)
    {
        $con = connection();
        $query = $con->prepare("SELECT solde FROM client WHERE ID_client = ?");
        $query->execute([$idclient]);
        return $query->fetch()['solde'];
    }
    function updateSoldeClient($idclient, $solde)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET solde = :solde WHERE ID_client = :idclient");
        $res = $query->execute(['solde' => $solde, 'idclient' => $idclient]) or die(print_r($query->errorInfo()));
        return $res;
    }
    function resetSoldeToZero()
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET solde = 0 WHERE solde > -10000 AND solde <0");
        $res = $query->execute() or die(print_r($query->errorInfo()));
        return $res;
    }
    function updateEtatClient($idclient, $etat)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET etat =:etat WHERE ID_client =:idclient");
        $res = $query->execute(['etat' => $etat, 'idclient' => $idclient]) or die(print_r($query->errorInfo()));
        return $res;
    }
    function updateTypeAndEtat($idclient, $type_client, $etat)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET type_client =:type_client,etat =:etat WHERE ID_client =:idclient");
        $res = $query->execute(['type_client' => $type_client, 'etat' => $etat, 'idclient' => $idclient]) or die(print_r($query->errorInfo()));
        return $res;
    }
    function updateBillingNumberAndTypeClientAndEtat($idclient, $billing_number, $type_client, $etat = 'actif')
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET billing_number = :billing_number,type_client = :type_client,etat =:etat WHERE ID_client = :idclient");
        $res = $query->execute(array('billing_number' => $billing_number, 'idclient' => $idclient, 'type_client' => $type_client, 'etat' => $etat)) or die(print_r($query->errorInfo()));
        return $res;
    }
    function updateAdresseClient($idclient, $adresse, $oldAdresse)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET adresse = :adresse,old_adresse =:oldAdresse WHERE ID_client = :idclient");
        $res = $query->execute(array('idclient' => $idclient, 'adresse' => $adresse, 'oldAdresse' => $oldAdresse)) or die(print_r($query->errorInfo()));
        return $res;
    }
    function updateBillingNumberDunClient($idclient)
    {
        $con = connection();
        $query = $con->prepare("UPDATE client SET billing_number = NULL WHERE ID_client = ?");
        $res = $query->execute([$idclient]);
        return $res;
    }
    function deleteClient($idclient)
    {
        $con = connection();
        //$query = $con->prepare("DELETE FROM client WHERE ID_client = ?");
        $query = $con->prepare("UPDATE client SET isDelete = 1 WHERE ID_client = ?");
        $rs = $query->execute(array($idclient)) or die(print_r($query->errorInfo()));
        return $rs;
    }
    function deleteFichierAttacher($idfichier)
    {
        $con = connection();
        $query = $con->prepare("DELETE FROM fichier_client WHERE ID_fichier_client =?");
        $res = $query->execute([$idfichier]) or die(print_r($query->errorInfo()));
        return $res;
    }
    function getClientA_recuperer()
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,Nom_client,telephone,mail,adresse,personneDeContact FROM client cl,tickets WHERE cl.ID_client = tickets.customer_id AND ticket_type='recuperation' AND status='ouvert' AND cl.isDelete = 0");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function client_installer()
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,Nom_client,telephone,mail,adresse,personneDeContact,tickets.created_at FROM client cl,tickets WHERE cl.ID_client = tickets.customer_id AND ticket_type ='installation' AND tickets.status ='ouvert' AND cl.isDelete = 0");


        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function installationParmois($mois, $annee)
    {
        //SELECT COUNT(*) AS nb FROM contenufiches,tickets WHERE tickets.id = contenufiches.ID_ticket AND MONTH(dateInstallation)= :mois AND YEAR(dateInstallation)= :annee 
        $con = connection();
        $query = $con->prepare(" SELECT COUNT(*) AS nb FROM tickets WHERE tickets.ticket_type ='installation' AND MONTH(tickets.created_at)= :mois AND YEAR(tickets.created_at)= :annee");
        $query->execute(['mois' => $mois, 'annee' => $annee]);
        return $query;
    }

    function client_demenager()
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,Nom_client,telephone,mail,adresse,personneDeContact FROM client cl,tickets WHERE cl.ID_client = tickets.customer_id AND ticket_type ='demenagement' AND status='ouvert' AND cl.isDelete = 0");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function detail_panne_client()
    {
        $con = connection();
        $query = $con->prepare("SELECT tickets.problem,tickets.ticket_type,tickets.description,tickets.created_at,cl.ID_client,Nom_client,telephone,mail,adresse,personneDeContact FROM client cl,tickets WHERE cl.ID_client = tickets.customer_id AND tickets.ticket_type ='depannage' AND status ='ouvert' AND cl.isDelete = 0 ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function installation_du_mois($mois, $annee)
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,Nom_client,telephone,mail,adresse,dateInstallation FROM client cl,tickets,contenufiches WHERE cl.ID_client = tickets.customer_id AND contenufiches.ID_ticket = tickets.id AND MONTH(dateInstallation)=:mois AND YEAR(dateInstallation) =:annee AND ticket_type ='installation' AND cl.isDelete = 0");
        $query->execute(array($mois, $annee));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function client_sans_contrat()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client WHERE client.isDelete = 0 AND client.ID_client NOT IN (SELECT ID_client FROM contract) AND client.isDelete = 0");
        $query->execute();
        return $query;
    }
    function customers_with_contract()
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,billing_number,Nom_client FROM client cl,contract co WHERE cl.ID_client = co.ID_client AND cl.type_client = 'paying' AND cl.isDelete = 0 AND co.etat <> 'terminer' AND co.isDelete = 0");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function customers_to_assign_parent()
    {
        $con = connection();
        $query = $con->prepare("SELECT ID_client,billing_number,Nom_client  FROM client WHERE parent_id IS NULL AND client.isDelete = 0 AND client.type_client <> 'gone' AND client.type_client <> 'potentiel' AND client.ID_client NOT IN (SELECT ID_client FROM contract)");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function children_customers()
    {
        $con = connection();
        $query = $con->prepare("SELECT 
			    ch.ID_client AS child_id,ch.nom_client AS child_name,
			  	par.ID_client AS parent_id,par.nom_client AS parent_name
			FROM
			    client par
			INNER JOIN client ch ON 
			    par.ID_client = ch.parent_id
			ORDER BY 
			    parent_name");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function filtreCustomerChild($condition)
    {
        $con = connection();
        $query = $con->prepare("SELECT 
			    ch.ID_client AS child_id,ch.nom_client AS child_name,
			  	par.ID_client AS parent_id,par.nom_client AS parent_name
			FROM
			    client par
			INNER JOIN client ch ON 
			    par.ID_client = ch.parent_id
			    $condition
			ORDER BY 
			    parent_name");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function liste_de_client_sans_contrat()
    {
        $con = connection();
        $query = $con->prepare("SELECT *  FROM client WHERE client.isDelete = 0 AND client.ID_client NOT IN (SELECT ID_client FROM contract) GROUP BY client.ID_client");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function client_sans_facture()
    {
        $con = connection();
        $query = $con->prepare("SELECT * FROM client ,contract ,facture WHERE contract.ID_client = client.ID_client AND client.isDelete = 0 AND client.etat ='actif' AND client.ID_client  NOT IN (SELECT ID_client FROM facture) GROUP BY client.ID_client");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function totalclientsans_facture()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM client ,contract ,facture WHERE contract.ID_client = client.ID_client AND client.isDelete = 0 AND client.etat ='actif' AND client.ID_client  NOT IN (SELECT ID_client FROM facture) GROUP BY client.ID_client");
        $query->execute();
        return $query;
    }
    function afficherUnClientPourCree_fiche($idclient)
    {
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,billing_number,solde,Nom_client,telephone,mobile_phone,mail,adresse,personneDeContact,nif,type_client,cl.etat FROM client cl WHERE cl.ID_client=? AND isDelete = 0 GROUP BY cl.ID_client");
        $query->execute(array($idclient)) or die(print_r($query->errorInfo()));
        return $query;
    }
    function listeClient_gratuit()
    {
        $con = connection();
        $query = $con->query("SELECT client.ID_client,client.billing_number,client.Nom_client,client.telephone,client.type_client,client.etat FROM client WHERE type_client = 'free' AND etat = 'terminer' AND isDelete =0 ");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function getClient_a_recuperer_Equipement()
    {
        $con = connection();
        // $query = $con->query("SELECT ID_client,billing_number,Nom_client,adresse FROM client WHERE isDelete = 0 AND type_client = 'paying' AND etat ='actif'");

        $query = $con->query("SELECT ID_client,billing_number,Nom_client,adresse FROM client");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
