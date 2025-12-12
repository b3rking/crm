<?php
Class Comptabilite
{
	
	function creer_compteBancaire($nombanque,$numerocompte,$montantinitial,$monnaie,$statut,$affichefacture,$datecreation)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO banque(nom,numero,montant,montant_initial,monnaie,statut,affiche_numero,date_creation) VALUES(:nombanque,:numerocompte,:montant,:montantinitial,:monnaie,:statut,:affichefacture,:datecreation)");
		$query->execute(array('nombanque' => $nombanque,'numerocompte' => $numerocompte,'montant'=>$montantinitial,'montantinitial'=>$montantinitial,'monnaie'=>$monnaie,'statut'=>$statut,'affichefacture' => $affichefacture,'datecreation' => $datecreation));
		$error = $query->errorInfo();
		return $error;
	}
	function getMaxIdBanque()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_banque) AS ID_banque FROM banque");
		$query->execute();
		return $query;
	}
	function affichageBanque()
	{
		$con = connection ();
		$query = $con->prepare("SELECT SUM(coalesce(debit,0)) - SUM(coalesce(credit,0)) + coalesce(b.montant_initial,0) AS montant,b.montant_initial,bj.ID_banque,numero,nom,monnaie,creditLine,monnaie,statut,affiche_numero,date_creation FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND b.isDelete = 0 AND date_operation >= '2021-08-01' GROUP BY ID_banque UNION ALL SELECT montant,montant_initial,ID_banque,numero,nom,monnaie,creditLine,monnaie,statut,affiche_numero,date_creation FROM banque WHERE isDelete = 0 AND ID_banque NOT IN (SELECT ID_banque FROM bank_journal WHERE debit IS NOT NULL AND date_operation >= '2021-08-01')");
		//$query = $con->prepare("SELECT * FROM banque WHERE isDelete = 0");

		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreBanque($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM banque WHERE $condition AND isDelete = 0");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getBanque($idBanque)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM banque WHERE ID_banque = ?");
		$query->execute([$idBanque]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getBanqqueActive()
	{
		$con = connection();
		//$query = $con->prepare("SELECT ID_banque,numero,nom,montant,montant_initial,creditLine,monnaie FROM banque WHERE statut = 'active'");
		$query = $con->prepare("SELECT SUM(coalesce(debit,0)) - SUM(coalesce(credit,0)) + coalesce(b.montant_initial,0) AS montant,b.montant_initial,bj.ID_banque,numero,nom,monnaie,creditLine,monnaie,statut,affiche_numero,date_creation FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND b.statut = 'active' AND b.isDelete = 0 AND date_operation >= '2021-08-01' GROUP BY ID_banque UNION ALL SELECT montant,montant_initial,ID_banque,numero,nom,monnaie,creditLine,monnaie,statut,affiche_numero,date_creation FROM banque WHERE statut = 'active' AND isDelete = 0 AND ID_banque NOT IN (SELECT ID_banque FROM bank_journal WHERE debit IS NOT NULL AND date_operation >= '2021-08-01')");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getBanqueActiveAndVisibleOnInvoice()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_banque,numero,nom,montant,montant_initial,creditLine,monnaie FROM banque WHERE statut = 'active' AND affiche_numero = 'oui'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function afficheBanque_montant()
	{
		$con = connection ();
		//SELECT ID_banque,nom,montantversser,monnaie FROM banque WHERE montantversser > 0
		$query = $con->prepare("SELECT ID_banque,nom,montantversser,monnaie FROM banque ");
		$query->execute();
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}*/
	function update_compteBancaire($idbank,$nombanque,$numerocompte,$montantinitial,$monnaie,$statut,$show_on_invoice)
	{
		$con = connection();
	 $query = $con->prepare("UPDATE banque SET nom = :nombanque,numero =:numerocompte,montant = montant+:montant,montant_initial = montant_initial+:montantinitial,monnaie = :monnaie,statut = :statut,affiche_numero = :show_on_invoice WHERE ID_banque = :idbank");
			$rs =$query->execute(array('nombanque'=>$nombanque,'numerocompte' => $numerocompte,'montant'=>$montantinitial,'montantinitial'=>$montantinitial,'monnaie'=>$monnaie,'statut'=>$statut,'show_on_invoice'=>$show_on_invoice,'idbank'=>$idbank)) or die(print_r($query->errorInfo()));
			return $rs;
	}
	function supprimercompteBanque($clebank)
	{
    	$con = connection();
	 	//$query = $con->prepare("DELETE FROM banque WHERE ID_banque = ?");
	 	$query = $con->prepare("UPDATE banque SET isDelete = 1 WHERE ID_banque = ?");
	 	$rs = $query->execute(array($clebank)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	/*function versement($idBanque,$reference,$dateversement,$iduser,$etat = 'ouvert',$montant,$monnaie)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO versement(reference,dateversement,ID_user,etat,montant,monnaie_verser,ID_banque) VALUES(:reference,:dateversement,:iduser,:etat,:montant,:monnaie,:idBanque)");
		$res = $query->execute(array('reference' => $reference,'dateversement' => $dateversement,'iduser' => $iduser,'etat' => $etat,'montant' => $montant,'monnaie' => $monnaie,'idBanque' =>$idBanque)) or die(print_r($query->errorInfo()));
		//$error = $query->errorInfo();
		return $res;
	}*/
    function versement($idBanque,$reference,$date_operation,$iduser,$montant)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO bank_journal(date_operation,libelle,debit,ID_banque,reference,typeOperation,considered,ID_user) VALUES(:date_operation,:libelle,:montant,:idBanque,:reference,'verssement',1,:iduser)");
		$res = $query->execute(array('libelle' => $reference,'date_operation' => $date_operation,'iduser' => $iduser,'montant' => $montant,'idBanque' =>$idBanque,'reference'=>$reference)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function versement_banque($idbanque,$idversement)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO versement_banque(ID_banque,ID_versement) VALUES(:idbanque,:idversement)");
		$res = $query->execute(['idbanque' => $idbanque,'idversement' => $idversement]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getBanqueDunVersement($idversement)
	{
		$con = connection();
		$query = $con->prepare("SELECT b.ID_banque,nom FROM banque b,versement_banque vb,versement v WHERE b.ID_banque = vb.ID_banque AND vb.ID_versement = v.ID_versement AND v.ID_versement = ?");
		$query->execute([$idversement]);
		return $query;
	}
	function versement_caisse($idcaisse,$idversement)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO versement_caisse(ID_caisse,ID_versement) VALUES(:idcaisse,:idversement)");
		$res = $query->execute(['idcaisse' => $idcaisse,'idversement' => $idversement]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getCaisseDunVersement($idversement)
	{
		$con = connection();
		$query = $con->prepare("SELECT c.ID_caisse,nomCaisse FROM caisse c,versement_caisse vc,versement v WHERE c.ID_caisse = vc.ID_caisse AND vc.ID_versement = v.ID_versement AND v.ID_versement = ?");
		$query->execute([$idversement]);
		return $query;
	}
	/*function deleteVersement($idversement)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM versement WHERE ID_versement = ?");
		$res = $query->execute([$idversement]);
		return $res;
	}*/
    function deleteVersement($idversement)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM bank_journal WHERE id = ?");
		//$query = $con->prepare("UPDATE bank_journal SET isDelete =1 WHERE id = ?");
		$res = $query->execute([$idversement]);
		return $res;
	}
	/*function getMaxIdVersement()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_versement) AS ID_versement FROM versement");
		$query->execute();
		return $query;
	}*/
    function getMaxIdVersement()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(id) AS ID_versement FROM bank_journal WHERE debit IS NOT NULL");
		$query->execute();
		return $query;
	}
	/*function getPaiements_attacher_a_un_versement($idversement)
	{
		$con = connection();
		$query = $con->prepare("SELECT p.ID_paiement,datepaiement,p.montant,devise,p.reference,nom_client,billing_number FROM client cl,paiement_verser pv,paiement p,versement v WHERE v.ID_versement = pv.ID_versement AND p.ID_paiement = pv.ID_paiement AND cl.ID_client = p.ID_client AND v.ID_versement = ?");
		$query->execute([$idversement]);
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}*/
    function getPaiements_attacher_a_un_versement($idversement)
	{
		$con = connection();
		$query = $con->prepare("SELECT p.ID_paiement,datepaiement,p.montant,devise,p.reference,nom_client,billing_number FROM client cl,paiement_verser pv,paiement p,bank_journal bj WHERE bj.id = pv.ID_versement AND p.ID_paiement = pv.ID_paiement AND cl.ID_client = p.ID_client AND debit IS NOT NULL AND bj.id = ?");
		$query->execute([$idversement]);
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
    function updateDeposedPayment($idpaiement,$deposed)
	{
		$con = connection();
		$query = $con->prepare("UPDATE paiement SET deposed =:deposed WHERE ID_paiement =:idpaiement");
		$res = $query->execute(['deposed'=>$deposed,'idpaiement'=>$idpaiement]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getPayementTotalDunMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant FROM paiement WHERE MONTH(datepaiement) = :mois AND YEAR(datepaiement) = :annee");
		$query->execute(['mois' => $mois,'annee' => $annee]) or die(print_r($query->errorInfo()));
		return $query;
	}
	function setPaiement_verser($idpaiement,$idversement)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO paiement_verser(ID_paiement,ID_versement) VALUES(:idpaiement,:idversement)");
		$res = $query->execute(['idpaiement' => $idpaiement,'idversement' => $idversement]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function delete_from_paiement_verserByIdPayement($idpaiement)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM paiement_verser WHERE ID_paiement =?");
		$res = $query->execute([$idpaiement]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function setVersementBanque($idbank,$dateversement,$iduser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO versement_banque(ID_paiement,ID_banque,dateversement,ID_user) SELECT MAX(ID_paiement),:idbank,:dateversement,:iduser FROM paiement");
		$res = $query->execute(array('idbank' => $idbank,'dateversement' => $dateversement,'iduser' => $iduser)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getNomBanque($idbanque)
	{
		$con = connection();
		$query = $con->prepare("SELECT nom FROM banque WHERE ID_banque = ?");
		$query->execute([$idbanque]);
		return $query;
	}
	function setHistoriqueEntrerBanque($idbanque,$montant,$provenance,$date_creation)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO historique_entree_banque(ID_banque,montantVersser,provenance,date_creation) VALUES(:idbank,:montant,:provenance,:date_creation)");
		$res = $query->execute(['idbank' =>$idbanque,'montant' => $montant,'provenance'=>$provenance,'date_creation' =>$date_creation]) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function getHistoriqueEntrerBanque($idbanque)
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_historique_entree_banque,b.ID_banque,nom,numero,h.montantVersser,monnaie,provenance,h.date_creation FROM historique_entree_banque h,banque b WHERE b.ID_banque = h.ID_banque AND b.ID_banque =?");
		$query->execute(array($idbanque)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}*/
    function getHistoriqueEntrerBanque($idbanque)
	{
		$con = connection ();
		$query = $con->prepare("SELECT id,date_operation,reference,debit,monnaie,bj.etat,b.ID_banque,b.nom FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND debit IS NOT NULL AND b.ID_banque =? AND bj.isDelete = 0 ORDER BY id DESC");
		$query->execute(array($idbanque)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function getHistoriqueSortieBanque($idbanque)
	{
		$con = connection();
		$query = $con->prepare("SELECT b.ID_banque,nom,numero,montantsorti,monnaie,motif,destination,date_sortie FROM sortie_banque sb,banque b WHERE b.ID_banque = sb.ID_banque AND b.ID_banque = ?");
		$query->execute(array($idbanque)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}*/
    function getHistoriqueSortieBanque($idbanque)
	{
		$con = connection();
		$query = $con->prepare("SELECT id,date_operation,libelle,credit,b.ID_banque,b.nom,b.monnaie,bj.reference,etat FROM bank_journal bj,banque b WHERE b.ID_banque = bj.ID_banque  AND credit IS NOT NULL AND b.ID_banque = ? AND bj.isDelete = 0");
		$query->execute(array($idbanque));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function recuperer_un_versement($idversement)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_versement,dateversement,reference,v.montant,monnaie_verser,v.etat,v.ID_banque,b.nom FROM versement v,banque b WHERE v.ID_banque = b.ID_banque AND ID_versement = ?");
		$query->execute([$idversement]);
		return $query;
	}*/
    function recuperer_un_versement($idversement)
	{
		$con = connection();
		$query = $con->prepare("SELECT id,date_operation,reference,debit,monnaie,bj.etat,b.ID_banque,b.nom FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND id = ?");
		$query->execute([$idversement]);
		return $query;
	}
	function detail_entree_banque($idbanque)
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_historique_entree_banque,ID_banque,nom,numero,montantVersser,monnaie,date_creation FROM historique_entree_banque WHERE ID_banque =?");
		$query->execute(array($idbanque)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function detail_sortie_banque($idbanque)
	{
		$con = connection();
		$query = $con->prepare("SELECT b.ID_banque,nom,numero,montantsorti,monnaie,destination,date_sortie FROM sortie_banque sb,banque b WHERE b.ID_banque = sb.ID_banque AND b.ID_banque = ?");
		$query->execute(array($idbanque)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function diminuerMontantEnBanqueVersCaisse($idbanque,$montant,$idcaisse)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE caisse,banque SET montant = montant - :montant,montantCaisse = montantCaisse + :montantCaisse WHERE ID_caisse = :idcaisse AND ID_banque = :idbanque");
	 	$res = $query->execute(array('idbanque' => $idbanque,'montant' => $montant,'montantCaisse' => $montant,'idcaisse' => $idcaisse)) or die(print_r($query->errorInfo()));
	 	return $res;
	}
	function AugmenterMontantbanque($idbanque,$montant)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE banque SET montantVersser = montantVersser + :montant WHERE  ID_banque = :idbanque");
	 	$res = $query->execute(array('idbanque' => $idbanque,'montant' => $montant)) or die(print_r($query->errorInfo()));
	 	return $res;
	}
	function diminuerMontantEnBanque($idbanque,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE banque SET montant =montant - :montant WHERE ID_banque =:idbanque");
		$res = $query->execute(['idbanque' => $idbanque,'montant' => $montant]) or die(print_r($query->errorInfo()));
		return $res;
		/*$query = $con->prepare("UPDATE banque SET montantVersser =montantVersser - :montant WHERE ID_banque =:idbanque");*/
	}
	/*function diminuerMontant_dans_versement($idversement,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE versement SET montant = montant - :montant WHERE ID_versement =:idversement");
		$res = $query->execute(['idversement' => $idversement,'montant' =>$montant]) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function diminuerMontant_dans_versement($idversement,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE bank_journal SET debit = debit - :montant WHERE id =:idversement");
		$res = $query->execute(['idversement' => $idversement,'montant' =>$montant]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function augmenterMontant_dans_versement($idversement,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE bank_journal SET debit = debit + :montant WHERE id =:idversement");
		$res = $query->execute(['idversement' => $idversement,'montant' =>$montant]) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function update_Versement($idversement,$reference,$dateversement,$idbanque)
	{
		$con = connection();
		$query = $con->prepare("UPDATE versement SET reference =:reference,dateversement =:dateversement,ID_banque=:idbanque WHERE ID_versement =:idversement");
		$res = $query->execute(['reference' => $reference,'dateversement' => $dateversement,'idversement' => $idversement,'idbanque' => $idbanque]) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function update_Versement($idversement,$reference,$dateversement,$idbanque,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE bank_journal SET libelle=:libelle,debit=:debit,reference =:reference,date_operation =:date_operation,ID_banque=:idbanque WHERE id =:idversement");
		$res = $query->execute(['libelle'=>$reference,'debit' => $montant,'reference' => $reference,'date_operation' => $dateversement,'idversement' => $idversement,'idbanque' => $idbanque]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function sortie_banque($idbanque,$montantsorti,$motif,$destination,$date_sortie)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO sortie_banque(ID_banque,montantsorti,motif,destination,date_sortie) VALUES(:idbanque,:montantsorti,:motif,:destination,:date_sortie)");
		$query->execute(array('idbanque' => $idbanque,'montantsorti' => $montantsorti,'motif'=>$motif,'destination' => $destination,'date_sortie' => $date_sortie)) or die(print_r($query->errorInfo()));
		$error = $query->errorInfo();
		return $error;
	}
	/*function creationExtrat($type_extrat,$montant,$monnaie,$destination,$date_extrat,$utilisateur,$description)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO extrat(ID_type_extrat,montant,monnaie,destination,date_extrat,ID_user,description) VALUES(:type_extrat,:montant,:monnaie,:destination,:date_extrat,:utilisateur,:description)");
		 $rs = $query->execute(array('type_extrat' => $type_extrat,'montant' => $montant,'monnaie' =>$monnaie,'destination' => $destination,'date_extrat' => $date_extrat,'utilisateur' =>$utilisateur,'description'=>$description)) or die(print_r($query->errorInfo()));
		return $rs;
	}*/
    function creationExtrat($idBanque,$reference,$date_operation,$iduser,$montant)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO bank_journal(date_operation,libelle,debit,ID_banque,reference,typeOperation,considered,ID_user) VALUES(:date_operation,:libelle,:montant,:idBanque,:reference,'extrat',1,:iduser)");
		$res = $query->execute(array('libelle' => $reference,'date_operation' => $date_operation,'iduser' => $iduser,'montant' => $montant,'idBanque' =>$idBanque,'reference'=>$reference)) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function getMaxIdExtrat()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_extrat) AS ID_extrat FROM extrat");
		$query->execute();
		return $query;
	}*/
    function getMaxIdExtrat()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(id) AS ID_extrat FROM bank_journal WHERE typeOperation = 'extrat'");
		$query->execute();
		return $query;
	}
	/*function deleteExtrat($idextrat)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM extrat WHERE ID_extrat = ?");
		$res = $query->execute([$idextrat]) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function deleteExtrat($idextrat)
	{
		$con = connection();
		//$query = $con->prepare("DELETE FROM bank_journal WHERE id = ?");
		$query = $con->prepare("UPDATE bank_journal SET isDelete =1 WHERE id = ?");
		$res = $query->execute([$idextrat]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateExtrat($idextrat,$montant,/*$id_type_extrat*/$date_extrat,$idUser,$description)
	{
		$con = connection();
		$query = $con->prepare("UPDATE extrat SET /*ID_type_extrat =:id_type_extrat,*/montant=:montant,date_extrat=:date_extrat,ID_user=:idUser,description=:description WHERE ID_extrat = :idextrat");
		$res = $query->execute([/*'id_type_extrat'=>$id_type_extrat,*/'montant'=>$montant,'date_extrat'=>$date_extrat,'idUser'=>$idUser,'description'=>$description,'idextrat'=>$idextrat]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function closeExtrat($iduser)
	{
		$con = connection();
		$query = $con->prepare("UPDATE bank_journal SET etat = 1 WHERE ID_user =:iduser AND etat = 0 AND typeOperation = 'extrat'");
		$res = $query->execute(['iduser'=>$iduser]);
		return $res;
	}
	function setCaisseExtrat($idcaisse)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO caisse_extrat(ID_caisse,ID_extrat) SELECT :idcaisse,MAX(ID_extrat) FROM extrat");
		$res = $query->execute(['idcaisse' => $idcaisse]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function setBanqueExtrat($idbanque)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO banque_extrat(ID_banque,ID_extrat) SELECT :idbanque,MAX(ID_extrat) FROM extrat");
		$res = $query->execute(['idbanque' => $idbanque]) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function getExtrats()
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_extrat,montant,monnaie,destination,date_extrat,description,ID_user,libelle_extrat FROM `extrat`,type_extrat WHERE extrat.ID_type_extrat = type_extrat.ID_type_extrat");
		$query->execute();
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}*/
    function getExtrats()
	{
		$con = connection ();
		$query = $con->prepare("SELECT id,date_operation,reference,debit,monnaie,bj.etat,b.ID_banque,b.nom FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND typeOperation = 'extrat' AND bj.isDelete = 0 ORDER BY id DESC LIMIT 100");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function filtreExtrat($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_extrat,t.ID_type_extrat,libelle_extrat,montant,monnaie,destination,date_extrat,ID_user,description FROM extrat e,type_extrat t WHERE e.ID_type_extrat = t.ID_type_extrat AND $condition");
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getCaisseDestinationExtrat($idextrat)
	{
		$con = connection();
		$query = $con->prepare("SELECT c.ID_caisse,e.ID_extrat,nomCaisse FROM caisse c,extrat e,caisse_extrat ce WHERE ce.ID_caisse = c.ID_caisse AND ce.ID_extrat = e.ID_extrat AND e.ID_extrat = ?");
		$query->execute([$idextrat]);
		return $query;
	}
	function getBanqueDestinationExtrat($idextrat)
	{
		$con = connection();
		$query = $con->prepare("SELECT b.ID_banque,e.ID_extrat,nom FROM banque b,extrat e,banque_extrat be WHERE be.ID_banque = b.ID_banque AND be.ID_extrat = e.ID_extrat AND e.ID_extrat = ?");
		$query->execute([$idextrat]);
		return $query;
	}
    function augmenterMontantDansCaisseRecette($montant,$monnaie)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET montantCaisse = montantCaisse + :montantCaisse WHERE typeCaisse = 'cr' AND devise = :monnaie");
		$res = $query->execute(['montantCaisse'=>$montant,'monnaie'=>$monnaie]);
		return $res;
	}
    function augmenterMontantGrandeCaisse($montant,$monnaie)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET montantCaisse = montantCaisse + :montant WHERE dimension = 'grande' AND devise = :monnaie");
		$res = $query->execute(['montant' => $montant,'monnaie' => $monnaie]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function diminuerMontantGrandeCaisse($montant,$monnaie)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET montantCaisse = montantCaisse - :montant WHERE dimension = 'grande' AND devise = :monnaie");
		$res = $query->execute(['montant' => $montant,'monnaie' => $monnaie]) or die(print_r($query->errorInfo()));
		return $res;
	}
    /*function setApprovisionnement($id_banque,$reference,$montant,$id_caisse,$date_appro,$id_user)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO approvisionnement(ID_banque,reference,montant,ID_caisse,date_appro,id_user) VALUES(:id_banque,:reference,:montant,:id_caisse,:date_appro,:id_user)");
		$res = $query->execute(['id_banque' => $id_banque,'reference' => $reference,'montant' => $montant,'id_caisse' => $id_caisse,'date_appro' => $date_appro,'id_user' => $id_user]) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function setApprovisionnement($idbanque,$reference,$credit,$idcaisse,$date_operation,$iduser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO bank_journal(date_operation,libelle,credit,ID_banque,reference,typeOperation,ID_caisse,ID_user) VALUES(:date_operation,:libelle,:credit,:idbanque,:reference,'approvisionnement',:idcaisse,:iduser)");
		$res = $query->execute(['date_operation'=>$date_operation,'libelle'=>$reference,'credit'=>$credit,'idbanque' => $idbanque,'reference' => $reference,'idcaisse' => $idcaisse,'iduser' => $iduser]) or die(print_r($query->errorInfo()));
		return $res;
	}
    /*function getApprivisionnements()
	{
		$con = connection();
		$query = $con->prepare("SELECT a.id,b.ID_banque,a.reference,b.nom,a.montant,a.etat,b.monnaie,c.ID_caisse,nomCaisse,date_appro,u.id_user,nom_user FROM approvisionnement a,banque b,caisse c,user u WHERE a.ID_banque = b.ID_banque AND u.ID_user = a.ID_user AND c.ID_caisse = a.ID_caisse");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function getApprivisionnements()
	{
		$con = connection();
		$query = $con->prepare("SELECT bj.id,date_operation,bj.libelle,credit,bj.reference,bj.etat,bj.ID_caisse,bj.ID_banque,b.nom,b.monnaie,nomCaisse,u.id_user,nom_user FROM bank_journal bj,banque b,caisse c,user u WHERE bj.ID_banque = b.ID_banque AND u.ID_user = bj.ID_user AND c.ID_caisse = bj.ID_caisse AND bj.isDelete = 0 ORDER BY id DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    /*function filtreApprivisionnements($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT a.id,b.ID_banque,b.nom,a.montant,a.etat,b.monnaie,c.ID_caisse,nomCaisse,date_appro,u.id_user,nom_user FROM approvisionnement a,banque b,caisse c,user u WHERE a.ID_banque = b.ID_banque AND u.ID_user = a.ID_user AND c.ID_caisse = a.ID_caisse $condition");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function filtreApprivisionnements($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT bj.id,date_operation,bj.libelle,credit,bj.reference,bj.etat,bj.ID_caisse,bj.ID_banque,b.nom,b.monnaie,nomCaisse,u.id_user,nom_user FROM bank_journal bj,banque b,caisse c,user u WHERE bj.ID_banque = b.ID_banque AND u.ID_user = bj.ID_user AND c.ID_caisse = bj.ID_caisse $condition");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    /*function getApprivisionnement($idapprov)
	{
		$con = connection();
		$query = $con->prepare("SELECT a.id,b.ID_banque,b.nom,a.montant,a.etat,b.monnaie,c.ID_caisse,nomCaisse,date_appro,u.id_user,nom_user FROM approvisionnement a,banque b,caisse c,user u WHERE a.ID_banque = b.ID_banque AND u.ID_user = a.ID_user AND c.ID_caisse = a.ID_caisse AND a.id = ?");
		$query->execute([$idapprov]);
		return $query;
	}*/
    function getApprivisionnement($idapprov)
	{
		$con = connection();
		$query = $con->prepare("SELECT bj.id,b.ID_banque,b.nom,bj.credit,bj.etat,b.monnaie,c.ID_caisse,nomCaisse,date_operation,u.id_user,nom_user FROM bank_journal bj,banque b,caisse c,user u WHERE b.ID_banque = bj.ID_banque AND u.ID_user = bj.ID_user AND c.ID_caisse = bj.ID_caisse AND bj.id = ?");
		$query->execute([$idapprov]);
		return $query;
	}
    /*function delete_aprovisionement($idapprov)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM approvisionnement WHERE id=?");
		$res = $query->execute([$idapprov]) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function delete_aprovisionement($idapprov)
	{
		$con = connection();
		//$query = $con->prepare("DELETE FROM bank_journal WHERE id=?");
		$query = $con->prepare("UPDATE bank_journal SET isDelete = 1 WHERE id=?");
		$res = $query->execute([$idapprov]) or die(print_r($query->errorInfo()));
		return $res;
	}
    /*function cloturerAprovisionnement($date_appro)
	{
		$con = connection();
		$query = $con->prepare("UPDATE approvisionnement SET etat = 1 WHERE date_appro = ? AND etat = 0");
		$res = $query->execute([$date_appro]) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function cloturerAprovisionnement($iduser)
	{
		$con = connection();
		$query = $con->prepare("UPDATE bank_journal SET etat = 1 WHERE ID_user = ? AND etat = 0");
		$res = $query->execute([$iduser]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function decaiserGrandeCaisse($idcaisse,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET montantCaisse = montantCaisse - :montantCaisse WHERE ID_caisse = :idcaisse");
		$res = $query->execute(array('montantCaisse' => $montant,'idcaisse' => $idcaisse)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function approvisinnerCaisse($provenance,$montantrecu,$monnaie,$idcaisse,$dateappro,$idUser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO approvionner_caisse(provenance,montantrecu,monnaie,ID_caisse,dateapprovisionnement,ID_user) VALUES(:provenance,:montant,:monnaie,:idcaisse,:dateappro,:idUser)");
		$res = $query->execute(['provenance' => $provenance,'montant' => $montantrecu,'monnaie' => $monnaie,'idcaisse' => $idcaisse,'dateappro' => $dateappro,'idUser' => $idUser]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getApprovisionnementDuneCaisse($idcaisse)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_approvisionnement,provenance,montantrecu,monnaie,ID_caisse,dateapprovisionnement FROM approvionner_caisse WHERE ID_caisse = ?");
		$query->execute([$idcaisse]) or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getHistoriqueEntrerDuneCaisse($idcaisse)
	{
		$con = connection();
		$query = $con->prepare("SELECT typeProvenance,provenance,montantEntrer,monnaie,dateEntrer FROM historiqueentrercaisse WHERE ID_caisse = ?");
		$query->execute([$idcaisse]) or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	/*function setCaisseAprovCaisse($idcaisse)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO caisse_approvisionne_caisse(ID_caisse,ID_approvisionnement) SELECT :idcaisse,MAX(ID_approvisionnement) FROM approvionner_caisse");
		$res = $query->execute(['idcaisse' => $idcaisse]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getCaisseApprovisionneCaisse($idapprov)
	{
		$con = connection();
		$query = $con->prepare("SELECT nomCaisse FROM caisse c,approvionner_caisse ap,caisse_approvisionne_caisse cap WHERE c.ID_caisse = cap.ID_caisse AND cap.ID_approvisionnement = ap.ID_approvisionnement AND cap.ID_approvisionnement = ?");
		$query->execute([$idapprov]);
		return $query;
	}
	function setBanqueApprovisionneCaisse($idbanque)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO banque_approvisionne_caisse(ID_banque,ID_approvisionnement) SELECT :idbanque,MAX(ID_approvisionnement) FROM approvionner_caisse");
		$res = $query->execute(['idbanque' => $idbanque]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getBanqueApprovisionneCaisse($idapprov)
	{
		$con = connection();
		$query = $con->prepare("SELECT nom FROM banque b,approvionner_caisse ap,banque_approvisionne_caisse bac WHERE b.ID_banque = bac.ID_banque AND bac.ID_approvisionnement = ap.ID_approvisionnement AND bac.ID_approvisionnement = ?");
		$query->execute([$idapprov]);
		return $query;
	}*/
	function encaisser($idcaisse,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET montantCaisse = montantCaisse + :montant WHERE ID_caisse = :idcaisse");
		$res = $query->execute(array('montant' => $montant,'idcaisse' => $idcaisse)) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function encaisserPetiteCaisseFromGrandeCaisse($idcaisse,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET montantCaisse = montantCaisse + :montantCaisse WHERE ID_caisse = :idcaisse");
		$res = $query->execute(array('montantCaisse' => $montant,'idcaisse' => $idcaisse)) or die(print_r($query->errorInfo()));
		return $res;
	}*/
	function setHistoriqueSortieCaisse($idcaisse,$montant_sortie,$motif,$destination,$date_sortie)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO historiquesortiecaisse(ID_caisse,montant_sortie,motif,destination,date_sortie) VALUES(:idcaisse,:montant,:motif,:destination,:date_sortie)");
		$res = $query->execute(array('idcaisse' => $idcaisse,'montant' => $montant_sortie,'motif'=>$motif,'destination' => $destination,'date_sortie' => $date_sortie)) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function updateMontantVerserBanque($idbank,$montant_total)
	{
		$con = connection();
		$query = $con->prepare("UPDATE banque SET nouveau_montant = montantVersser + :montant_total WHERE ID_banque = :idbank");
		$res = $query->execute(array('montant_total' => $montant_total,'idbank' => $idbank)) or die(print_r($query->errorInfo()));
		return $res;
	}*/
	function updateMontantVerserBanque($idbank,$montant_total)
	{
		$con = connection();
		$query = $con->prepare("UPDATE banque SET nouveau_montant = nouveau_montant + :montant_total WHERE ID_banque = :idbank");
		$res = $query->execute(array('montant_total' => $montant_total,'idbank' => $idbank)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function augmanterMontantBanque($idbank,$montant_total)
	{
		$con = connection();
		$query = $con->prepare("UPDATE banque SET montant = montant + :montant_total WHERE ID_banque = :idbank");
		$res = $query->execute(array('montant_total' => $montant_total,'idbank' => $idbank)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getMontantPaiementVerser($idbank,$datepaiement)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant FROM paiement p,versement_banque v WHERE p.ID_paiement = v.ID_paiement AND v.ID_banque = :idbank AND p.datepaiement = :datepaiement AND etat = 'ouvert'");
		$query->execute(array('idbank' => $idbank,'datepaiement' => $datepaiement)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function getVersementOuvert()
	{
		$con = connection();
		$query = $con->prepare("SELECT nom,b.monnaie,b.numero,dateversement,SUM(v.montant) AS montant FROM versement_banque v,banque b WHERE  v.ID_banque = b.ID_banque AND v.etat = 'ouvert' GROUP BY dateversement,v.ID_banque");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	/*function cloturerVersement($dateversement)
	{
		$con = connection();
		$query = $con->prepare("UPDATE versement SET etat = 1 WHERE dateversement =:dateversement AND etat = 0");
		$res = $query->execute(array('dateversement' => $dateversement)) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function cloturerVersement($iduser)
	{
		$con = connection();
		$query = $con->prepare("UPDATE bank_journal SET etat = 1 WHERE ID_user =:iduser AND etat = 0");
		$res = $query->execute(array('iduser' => $iduser)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function cloturerUnVersement($idversement)
	{
		$con = connection();
		$query = $con->prepare("UPDATE bank_journal SET etat = 1 WHERE id =:idversement");
		$res = $query->execute(array('idversement' => $idversement)) or die(print_r($query->errorInfo()));
		return $res;
	}
    /*function getVersementDuneDate($dateversement)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM versement WHERE dateversement = :dateversement");
		$query->execute(['dateversement' => $dateversement]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function getVersementNoCloturerByUser($iduser)
	{
		$con = connection();
		$query = $con->prepare("SELECT id AS ID_versement,debit,monnaie,bj.ID_banque FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND bj.etat = 0 AND bj.ID_user =:iduser");
		$query->execute(['iduser' => $iduser]) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function affichageversementenbanque()
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM versement_banque");

		$query->execute();
		$rs = array();

		while ( $data = $query->fetchObject()) 
		{
		# code...
		$rs[] = $data;
		}
		return $rs;
	}
	/*function getVersements()
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_versement,dateversement,reference,v.montant,monnaie_verser,v.etat,v.ID_banque,b.nom FROM versement v,banque b WHERE v.ID_banque = b.ID_banque ORDER BY ID_versement DESC LIMIT 100");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function getVersementByIdPayement($idpaiement)
	{
		$con = connection();
		$query = $con->prepare("SELECT id,date_operation,bj.reference,debit,monnaie,bj.etat,b.ID_banque,b.nom FROM bank_journal bj,banque b,paiement p,paiement_verser pv WHERE bj.ID_banque = b.ID_banque AND p.ID_paiement = pv.ID_paiement AND pv.ID_versement = bj.id AND p.ID_paiement = ? AND bj.isDelete = 0");
		$query->execute([$idpaiement]);
		return $query;
	}
    function getVersements()
	{
		$con = connection ();
		$query = $con->prepare("SELECT id,date_operation,reference,debit,monnaie,bj.etat,b.ID_banque,b.nom FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND typeOperation  = 'verssement' AND bj.isDelete = 0 ORDER BY id DESC LIMIT 100");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getMontantVerserAvantUneDate($idbanque,$dateversement)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant FROM versement WHERE ID_banque =:idbanque AND dateversement < :dateversement AND considered = 1");
		$query->execute(['idbanque'=>$idbanque,'dateversement'=>$dateversement]);
		return $query->fetch()['montant'];
	}
    function getDebitDuneBanqueAvantUneDate($idbanque,$date_operation)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(debit) AS debit FROM bank_journal WHERE ID_banque =:idbanque AND date_operation < :date_operation AND considered = 1 AND isDelete = 0");
		$query->execute(['idbanque'=>$idbanque,'date_operation'=>$date_operation]);
		return $query->fetch()['debit'];
	}
    /*function filtreVerssement($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_versement,dateversement,reference,v.montant,monnaie_verser,v.etat,v.ID_banque,b.nom FROM versement v,banque b WHERE v.ID_banque = b.ID_banque $condition ORDER BY ID_versement DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function filtreVerssement($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT id,date_operation,reference,debit,monnaie,bj.etat,b.ID_banque,b.nom FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND bj.isDelete = 0 AND typeOperation = 'verssement' $condition ORDER BY id DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    /*function getVersement($idversement)
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_versement,dateversement,reference,v.montant,monnaie_verser,v.etat,v.ID_banque,b.nom FROM versement v,banque b WHERE v.ID_banque = b.ID_banque AND ID_versement = ?");
		$query->execute([$idversement]);
		return $query;
	}*/
    function getVersement($idversement)
	{
		$con = connection ();
		$query = $con->prepare("SELECT id,date_operation,reference,debit,monnaie,bj.etat,bj.ID_banque,b.nom FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND id = ?");
		$query->execute([$idversement]);
		return $query;
	}
	function getNombre_paiement_par_versement($idversement)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(ID_paiement) AS nbPaiement FROM paiement_verser WHERE ID_versement = ?");
		$query->execute([$idversement]);
		return $query;
	}
	function affichenombrePaiementparJour($datepaiement)
	{
		$con = connection ();
		$query = $con->prepare("SELECT COUNT(*) AS paiement,datepaiement  FROM `paiement` WHERE datepaiement = ?");

		$query->execute(array($datepaiement)) or die(print_r($query->errorInfo()));
		$rs = array();

		while ( $data = $query->fetchObject()) 
		{
		# code... 
		$rs[] = $data;
		}
		return $rs;
	}
    function getFacture_dun_payement($idpaiement)
	{	
		$con = connection(); 
		$query = $con->prepare("SELECT fac.facture_id,fac.numero,SUM(fs.montant_total) AS montant,monnaie,fac.exchange_rate AS taux_change_courant,fp.montant AS montant_payer,fac.reste,SUM(fs.montant_tva) AS montant_tva,mois_debut,annee,billing_date FROM facture fac,facture_service fs,facture_payer fp,paiement p WHERE fac.facture_id = fs.facture_id AND fac.facture_id = fp.facture_id AND fp.ID_paiement = p.ID_paiement AND p.ID_paiement = ? GROUP BY fac.facture_id");
		$query->execute([$idpaiement]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getFactureIdPayer($idpaiement)
	{	
		$con = connection(); 
		$query = $con->prepare("SELECT facture_id FROM facture_payer fp,paiement p WHERE fp.facture_id = p.ID_paiement AND p.ID_paiement = ?");
		$query->execute([$idpaiement]);
		return $query;
	}
	function filtrePayement($condition,$tables)
	{
		$con = connection();
		//$query = $con->prepare("SELECT p.ID_paiement,p.numero,p.datepaiement,p.status,cl.ID_client,cl.Nom_client,cl.billing_number,p.Taux_change_courant,p.exchange_currency,p.montant_converti,p.montant,p.devise,p.methode,p.reference,p.tva,p.ID_banque,deposed FROM $tables WHERE p.ID_client = cl.ID_client AND p.isDelete = 0 $condition ORDER BY p.ID_paiement");
		$query = $con->prepare("SELECT p.ID_paiement,p.numero,p.datepaiement,p.status,cl.ID_client,cl.Nom_client,cl.billing_number,p.Taux_change_courant,p.exchange_currency,p.montant_converti,p.montant,p.devise,p.methode,p.reference,p.tva,p.ID_banque,deposed FROM $tables WHERE p.ID_client = cl.ID_client AND p.isDelete = 0 $condition ORDER BY p.datepaiement");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getPayements()
	{
		$con = connection();
		$query = $con->prepare("SELECT p.ID_paiement,p.numero,p.datepaiement,status,cl.ID_client,cl.Nom_client,cl.billing_number,p.Taux_change_courant,exchange_currency,montant_converti,p.montant,devise,methode,reference,p.tva,ID_banque,deposed FROM paiement p,client cl WHERE p.ID_client = cl.ID_client AND p.isDelete = 0 ORDER BY p.ID_paiement DESC LIMIT 100");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getPayementsDunClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT p.ID_paiement,p.datepaiement,cl.ID_client,cl.Nom_client,cl.billing_number,p.Taux_change_courant,p.montant,devise,methode,reference FROM paiement p,client cl WHERE p.ID_client = cl.ID_client AND cl.ID_client = ? ORDER BY p.ID_paiement ASC");
		$query->execute([$idclient]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function affichage_clientAvec_contratpayant_lafacture()
	{
		$con = connection ();
		$query = $con->prepare("SELECT p.ID_paiement,p.datepaiement,f.facture_id,c.ID_client,c.Nom_client,c.billing_number,p.Taux_change_courant,p.montant,devise,methode,reference FROM paiement p,facture_service fs,client c,facture f,facture_payer pf WHERE f.facture_id = fs.facture_id AND pf.facture_id = f.facture_id AND p.ID_paiement = pf.ID_paiement AND  c.ID_client = f.ID_client GROUP BY f.facture_id ORDER BY p.ID_paiement DESC LIMIT 100");
		$query->execute();
		$rs = array();

		while ( $data = $query->fetchObject()) 
		{
		# code...
		$rs[] = $data;
		}
		return $rs;
	}
	/*function recupere_paiement_filtre($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT p.ID_paiement,p.datepaiement,f.facture_id,c.Nom_client,c.billing_number,p.Taux_change_courant,p.montant,devise,methode,reference FROM paiement p,facture_service fs,client c,facture f,facture_payer pf WHERE f.facture_id = fs.facture_id AND pf.facture_id = f.facture_id AND p.ID_paiement = pf.ID_paiement AND  c.ID_client = fs.ID_client GROUP BY f.facture_id $condition ORDER BY p.ID_paiement DESC LIMIT 100");
		$query->execute();
		$rs = array();

		while ( $data = $query->fetchObject()) 
		{
		# code...
		$rs[] = $data;
		}
		return $rs;
	}*/
	function paiement_jour()
	{
		$con =connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM paiement p,client c WHERE c.ID_client = p.ID_client AND datepaiement =?");
		$query->execute(array(date('Y-m-d')));
		
		return $query;

	}
	function affichage_paiement_Hebdomadaire()
	{
		$con = connection ();
		$query = $con->prepare("SELECT p.datepaiement,p.facture_id,c.Nom_client,c.billing_number,p.Taux_change_courant,p.montant,methode,reference,devise FROM paiement p,facture_service fs,client c,facture f WHERE f.facture_id = fs.facture_id AND p.facture_id = f.facture_id AND  c.ID_client = fs.ID_client AND ");
		$query->execute(array(date('Y-m-d')));
		$rs = array();

		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function affichage_paiement_Mensuel($date_debut,$date_fin)
	{
		$con = connection ();
		$query = $con->prepare("SELECT datepaiement,SUM(montant) AS montant,devise FROM paiement WHERE datepaiement BETWEEN :date_debut AND :date_fin GROUP BY datepaiement,devise");
		$query->execute(array('date_debut'=>$date_debut,'date_fin'=>$date_fin)) or die(print_r($query->errorInfo()));
		$rs = $query->fetchAll(PDO::FETCH_OBJ);
		return $rs;
	}
	function affichage_detail_paiementRecu($idpaiement)
	{
		$con = connection ();
		$query = $con->prepare("SELECT p.datepaiement,cl.Nom_client,cl.billing_number,nif,p.montant,methode,p.reference,p.devise,p.tva,nom_user FROM paiement p,client cl,contract co,user u WHERE p.ID_client = cl.ID_client AND u.ID_user = p.ID_user AND co.ID_client = cl.ID_client AND p.ID_paiement = ? GROUP BY p.ID_paiement");
		$query->execute(array($idpaiement)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function import_payement()
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,cl.nom_client,montant,monnaie,methode,datepaiement FROM import_paiement ip,client cl WHERE ip.nom_client = cl.nom_client");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function ajout_monnaie($monnaie,$iduser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO monnaie(libelle,ID_user) VALUES(:libelle,:iduser)");
		$res = $query->execute(['libelle' => $monnaie,'iduser' => $iduser]);
		return $res;
	}
	function getMonnaies()
	{
		$con = connection();
		$query = $con->prepare("SELECT id,libelle,nom_user FROM monnaie m,user u WHERE m.ID_user = u.ID_user ORDER BY libelle");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function update_monnaie($monnaie,$id)
	{
		$con = connection();
		$query = $con->prepare("UPDATE monnaie SET libelle = ? WHERE id = ?");
		$res = $query->execute([$monnaie,$id]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function delete_monnaie($id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM monnaie WHERE id = ?");
		$res = $query->execute([$id]);
		return $res;
	}
	function ajout_paiement($idclient,$numero,$montantpaye,$devises,$methodepaiement,$taux_de_change,$exchange_currency,$montant_converti,$reference,$tva,$datepaiements,$iduser,$reste,$idbanque)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO paiement(ID_client,numero,montant,devise,reste,methode,taux_change_courant,exchange_currency,montant_converti,reference,tva,datepaiement,ID_banque,ID_user) VALUES(:idclient,:numero,:montantpaye,:devises,:reste,:methodepaiement,:taux_de_change,:exchange_currency,:montant_converti,:reference,:tva,:datepaiements,:idbanque,:iduser)");
		$res = $query->execute(array('idclient' => $idclient,'numero'=>$numero,'montantpaye' => $montantpaye,'devises' => $devises,'reste' => $reste,'methodepaiement' => $methodepaiement,'taux_de_change' => $taux_de_change,'exchange_currency'=>$exchange_currency,'montant_converti'=>$montant_converti,'reference'=>$reference,'tva'=>$tva,'datepaiements'=>$datepaiements,'idbanque'=>$idbanque,'iduser'=>$iduser)) or die(print_r($query->errorInfo()));
		//$error = $query->errorInfo();
		return $res;
	}
    function setMonthlyAmountToBeCollected($id,$invoices_amount,$delinquent,$total_solde,$paid_amount,$remains_to_be_collected,$created_at)
    {
        $con = connection();
		$query = $con->prepare("INSERT INTO monthly_amount_to_be_collected(id,invoices_amount,delinquent,total_solde,paid_amount,remains_to_be_collected,created_at) VALUES(:id,:invoices_amount,:delinquent,:total_solde,:paid_amount,:remains_to_be_collected,:created_at)");
        $res = $query->execute(['id'=>$id,'invoices_amount'=>$invoices_amount,'delinquent'=>$delinquent,'total_solde'=>$total_solde,'paid_amount'=>$paid_amount,'remains_to_be_collected'=>$remains_to_be_collected,'created_at'=>$created_at]) or die(print_r($query->errorInfo()));
        return $res;
    }
	function getMaxIdPayement()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_paiement) AS ID_paiement FROM paiement");
		$query->execute();
		return $query;
	}
	function update_paiement($idpaiement,$numero,$montant,$monnaie,$taux_de_change,$exchange_currency,$montant_converti,$methode,$reference,$tva,$datepaiement,$iduser,$idbanque)
	{
		$con = connection();
		$query = $con->prepare("UPDATE paiement SET numero =:numero,montant =:montant,devise =:monnaie,methode =:methode,taux_change_courant=:taux_change_courant,exchange_currency=:exchange_currency,montant_converti=:montant_converti,reference =:reference,tva=:tva,datepaiement =:datepaiement,ID_banque =:idbanque,ID_user =:iduser WHERE ID_paiement = :idpaiement");
		$res = $query->execute(['numero'=>$numero,'montant' => $montant,'monnaie' => $monnaie,'methode' => $methode,'taux_change_courant'=>$taux_de_change,'exchange_currency'=>$exchange_currency,'montant_converti'=>$montant_converti,'reference' => $reference,'tva'=>$tva,'datepaiement' => $datepaiement,'idbanque'=>$idbanque,'iduser' => $iduser,'idpaiement' => $idpaiement]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function updatePayementDeposed($idpaiement,$idbanque,$deposed)
	{
		$con = connection();
		$query = $con->prepare("UPDATE paiement SET deposed = :deposed,ID_banque = :idbanque WHERE ID_paiement =:idpaiement");
		$res = $query->execute(['idbanque' => $idbanque,'idpaiement' => $idpaiement,'deposed'=>$deposed]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deletePaiement($idpaiement)
	{
		$con = connection();
		//$query = $con->prepare("DELETE FROM paiement WHERE ID_paiement = ?");
		$query = $con->prepare("UPDATE paiement SET isDelete = 1 WHERE ID_paiement = ?");
		$res = $query->execute([$idpaiement]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function getPayementCashJournalier($datepaiement)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant,devise FROM paiement WHERE datepaiement = :datepaiement AND methode = 'CASH' AND status = 0 GROUP BY devise");
		$query->execute(['datepaiement' => $datepaiement]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getPayementCashNotCloseByUser($iduser)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant,devise FROM paiement WHERE ID_user = :iduser AND methode = 'CASH' AND status = 0 AND deposed = 0 AND isDelete = 0 GROUP BY devise");
		$query->execute(['iduser' => $iduser]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getPayementNoCashNotCloseByUser($iduser)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_paiement,montant,devise AS monnaie,ID_banque,reference,datepaiement FROM paiement WHERE ID_user = :iduser AND methode <> 'CASH' AND status = 0 AND deposed = 0 AND isDelete = 0 AND ID_banque IS NOT NULL");
		$query->execute(['iduser' => $iduser]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getPayementCashNotCloseForAllUsers()
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant,devise FROM paiement WHERE methode = 'CASH' AND status = 0 AND deposed = 0 AND isDelete = 0 AND DATEDIFF(now(),datepaiement) >= 3 GROUP BY devise");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getPayementNoCashNotCloseForAllUsers()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_paiement,montant,devise AS monnaie,ID_banque,reference,datepaiement FROM paiement WHERE methode <> 'CASH' AND status = 0 AND deposed = 0 AND isDelete = 0 AND ID_banque IS NOT NULL AND DATEDIFF(now(),datepaiement) >= 3");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}

    function closePayement($closed_by)
	{
		$con = connection();
		$query = $con->prepare("UPDATE paiement SET status = 1,closed_by = :closed_by WHERE ID_user = :iduser");
		$res = $query->execute(['closed_by' => $closed_by,'iduser' => $closed_by]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function closePayementsByCron($closed_by)
	{
		$con = connection();
		$query = $con->prepare("UPDATE paiement SET status = 1,closed_by = :closed_by WHERE status = 0 AND deposed = 0 AND isDelete = 0 AND DATEDIFF(DATE_ADD(now(),INTERVAL 1 DAY),datepaiement) >= 3");
		$res = $query->execute(['closed_by' => $closed_by]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function setHistoriqueAction($idAction,$type,$effectuerPar,$dateAction,$action)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO historiqueAction(	ID_action,type,effectuerPar,dateAction,action) VALUES
			(:idAction,:type,:effectuerPar,:dateAction,:action)");
		$res = $query->execute(['idAction' => $idAction,'type' => $type,'effectuerPar' => $effectuerPar,'dateAction' => $dateAction,'action' =>$action]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getHistoriqueActions()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM historiqueAction");
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function afficheFactureduclienparlocalisation()
	{
		$con = connection ();
		$query = $con->prepare("SELECT p.ID_paiement,p.datepaiement,p.montant, c.Nom_client,l.nom_localisation FROM paiement p,localisation l,client c WHERE c.ID_localisation = l.ID_localisation AND c.ID_client = p.ID_client AND p.ID_paiement NOT IN (SELECT ID_paiement FROM versement_banque)");
		$query->execute();
		$rs = array();

		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function afficherPaiementNonVerser()
	{
		$con = connection ();
		$query = $con->prepare("SELECT p.ID_paiement,p.datepaiement,p.montant,devise, c.Nom_client FROM paiement p,client c WHERE c.ID_client = p.ID_client AND p.deposed = 0 AND methode = 'CASH' AND p.isDelete = 0 AND p.ID_paiement NOT IN (SELECT ID_paiement FROM paiement_verser) ORDER BY p.ID_paiement DESC LIMIT 100");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function setFacturePayer($idpaiement,$facture_id,$montant,$taux,$date_creation)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO facture_payer(ID_paiement,facture_id,montant,exchange_rate,date_creation) VALUES (:idpaiement,:facture_id,:montant,:exchange_rate,:date_creation)");
		$res = $query->execute(array('idpaiement' => $idpaiement,'facture_id' => $facture_id,'montant'=>$montant,'exchange_rate' => $taux,'date_creation' => $date_creation)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function updateFacturePayer($facture_id,$idpaiement,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture_payer SET montant = :montant WHERE facture_id =:facture_id AND ID_paiement = :idpaiement");
		$res = $query->execute(['montant'=>$montant,'facture_id'=>$facture_id,'idpaiement'=>$idpaiement]);
		return $res;
	}
	function deleteFromFacturePayer($idpaiement)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM facture_payer WHERE ID_paiement = ?");
		$res = $query->execute([$idpaiement]);
		return $res;
	}
	function creerCaisse($nomcaisse,$devise,$statut,$responsable,$datecreationcaisse,$idusers,$type,$description)
	{	
		$con = connection();
		$query = $con->prepare("INSERT INTO caisse(nomCaisse,devise,typeCaisse,etat,reponsableCaisse,datecaisse,ID_user,description) VALUES(:nomcaisse,:devise,:type,:statut,:responsable,:datecreationcaisse,:idusers,:description)");
		$res = $query->execute(array('nomcaisse' => $nomcaisse,'devise' => $devise,'type' => $type,'statut' => $statut,'responsable'=>$responsable,'datecreationcaisse' => $datecreationcaisse,'idusers' => $idusers,'description'=>$description)) or die(print_r($query->errorInfo()));
		//$error = $query->errorInfo();
		return $res;
	}
	function getMaxIdCaisse()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_caisse) AS ID_caisse FROM caisse");
		$query->execute();
		return $query;
	}
	function augmenterMontantCaisse($idcaisse,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET montantCaisse = montantCaisse + :montant WHERE ID_caisse = :idcaisse");
		$res = $query->execute(array('montant' => $montant,'idcaisse' => $idcaisse)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function diminuerMontantCaisse($idcaisse,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET montantCaisse = montantCaisse - :montant WHERE ID_caisse = :idcaisse");
		$res = $query->execute(array('montant' => $montant,'idcaisse' => $idcaisse)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deleteCaisse($idcaisse)
	{
		$con = connection();
		//$query = $con->prepare("DELETE FROM caisse WHERE ID_caisse = ?");
		$query = $con->prepare("UPDATE caisse SET isDelete = 1 WHERE ID_caisse = ?");
		$res = $query->execute([$idcaisse]);
		return $res;
	}
	function updateCaisse($idcaisse,$nomCaisse,$monnaie,$statut,$responsable,$datecreation,$type,$description,$iduser)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET nomCaisse=:nomCaisse,devise=:monnaie,etat=:statut,reponsableCaisse=:responsable,datecaisse=:datecreation,typeCaisse=:type,description=:description,ID_user=:iduser WHERE ID_caisse=:idcaisse");
		$res = $query->execute(['nomCaisse' =>$nomCaisse,'monnaie'=>$monnaie,'statut'=>$statut,'responsable'=>$responsable,'datecreation'=>$datecreation,'type'=>$type,'description'=>$description,'iduser'=>$iduser,'idcaisse'=>$idcaisse]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function getCaisses()
	{
		$con = connection ();
		//$query = $con->prepare("SELECT c.ID_caisse,nomCaisse,devise,lignecredit,montantCaisse,dimension,etat,reponsableCaisse,datecaisse,c.ID_user,description,nom_user,typeCaisse FROM caisse c,user u WHERE reponsableCaisse = u.ID_user AND c.isDelete = 0") or die(print_r($query->errorInfo()));
        $query = $con->prepare("SELECT c.ID_caisse,nomCaisse,devise,lignecredit,montantCaisse,dimension,etat,reponsableCaisse,datecaisse,c.ID_user,description,nom_user,typeCaisse FROM caisse c,user u WHERE reponsableCaisse = u.ID_user AND c.isDelete = 0 AND typeCaisse <> 'cr'") or die(print_r($query->errorInfo()));
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function filtreCaisses($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT c.ID_caisse,nomCaisse,devise,lignecredit,montantCaisse,dimension,etat,reponsableCaisse,datecaisse,c.ID_user,description,nom_user FROM caisse c,user u WHERE reponsableCaisse = u.ID_user $condition") or die(print_r($query->errorInfo()));
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getCaisse($idcaisse)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM caisse WHERE ID_caisse = ?");
		$query->execute([$idcaisse]);
		return $query;
	}
	function getPetiteCaisse()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM caisse WHERE dimension = 'petite'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getCaisseDunUserNotNull($iduser)
	{
		$con = connection ();
		//$query = $con->prepare("SELECT * FROM caisse WHERE montantCaisse > 0 AND reponsableCaisse = ?");
		$query = $con->prepare("SELECT * FROM caisse WHERE montantCaisse > 0 ");
		$query->execute(array($iduser));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
    function getCaisseDepenseDunUserNotNull($iduser)
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM caisse WHERE montantCaisse > 0 AND reponsableCaisse = ? AND typeCaisse = 'cd'");
		//$query = $con->prepare("SELECT * FROM caisse WHERE montantCaisse > 0 ");
		$query->execute(array($iduser));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function setHistoriqueEntrerCaisse($typeProvenance,$provenance,$montantEntrer,$monnaie,$idcaisse,$dateEntrer,$idUser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO historiqueentrercaisse(typeProvenance,provenance,montantEntrer,monnaie,ID_caisse,dateEntrer,ID_user) VALUES(:typeProvenance,:provenance,:montant,:monnaie,:idcaisse,:dateEntrer,:idUser)");
		$res = $query->execute(['typeProvenance'=>$typeProvenance,'provenance' => $provenance,'montant' => $montantEntrer,'monnaie' => $monnaie,'idcaisse' => $idcaisse,'dateEntrer' => $dateEntrer,'idUser' => $idUser]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getHistoriqueSortieDuneCaisse($idcaisse)
	{
		$con = connection ();
		$query = $con->prepare("SELECT montant_sortie,motif,destination,date_sortie,devise,dimension FROM caisse c,historiquesortiecaisse h WHERE c.ID_caisse = h.ID_caisse AND c.ID_caisse = ?");
		$query->execute(array($idcaisse)) or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function filtreSortieCaisse($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT montant_sortie,motif,destination,date_sortie,devise,dimension FROM caisse c,historiquesortiecaisse h WHERE c.ID_caisse = h.ID_caisse $condition");
		$query->execute() or die(print_r($query->errorInfo()));
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function filtreEntrerCaisse($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT typeProvenance,provenance,montantEntrer,devise,dimension,dateEntrer,u.nom_user FROM historiqueentrercaisse h,caisse c,user u WHERE c.ID_caisse = h.ID_caisse AND h.ID_user = u.ID_user $condition");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getNomCaisse($idcaisse)
	{
		$con = connection();
		$query = $con->prepare("SELECT nomCaisse FROM caisse WHERE ID_caisse =?");
		$query->execute([$idcaisse]);
		return $query;
	}
	function creationCompteComptable($code,$nomcompte,$lignecredit,$monnaie,$datecompte,$note,$utilisateur)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO compte(code_compte, nomCompte,lignecredit,devise,dateCompte,note,ID_user ) VALUES(:code,:nomcompte,:lignecredit,:monnaie,:datecompte,:note,:utilisateur)");
		$query->execute(array('code' => $code,'nomcompte' => $nomcompte,'lignecredit' => $lignecredit,'monnaie'=>$monnaie,'datecompte' => $datecompte,'note' => $note,'utilisateur' => $utilisateur));
		$error = $query->errorInfo();
		return $error;
	}
	function getCompteComptables()
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM compte");
		$query->execute();
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
    function addPetiteDepense($montant,$monnaie,$motif,$datedepense,$idcategorie,$idcaisse,$iduser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO petitedepense(montantdepense,monnaie,motifdepense,datedepense,ID_categorie_depense,ID_caisse,ID_user) VALUES(:montant,:monnaie,:motif,:datedepense,:idcategorie,:idcaisse,:iduser)");
		$res = $query->execute(['montant'=>$montant,'monnaie'=>$monnaie,'motif'=>$motif,'datedepense'=>$datedepense,'idcategorie'=>$idcategorie,'idcaisse'=>$idcaisse,'iduser'=>$iduser]) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function creationDepense($reference,$montant,$monnaie,$motif,$datedepense,$idcategorie,$provenance,$idAppro,$idcaisse,$idbanque,$iduser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO depense(reference,montantdepense,monnaie,motifdepense,datedepense,ID_categorie_depense,provenance,ID_approvisionnement,ID_banque,ID_caisse,ID_user ) VALUES(:reference,:montant,:monnaie,:motif,:datedepense,:idcategorie,:provenance,:idAppro,:idbanque,:idcaisse,:iduser)");
		$res = $query->execute(array('reference' => $reference,'montant' => $montant,'monnaie' => $monnaie,'motif' => $motif,'datedepense' => $datedepense,'idcategorie' => $idcategorie,'provenance' => $provenance,'idAppro' => $idAppro,'idbanque'=>$idbanque,'idcaisse' => $idcaisse,'iduser' => $iduser)) or die(print_r($query->errorInfo()));
		return $res;
	}*/
    function creationDepense($reference,$credit,$libelle,$date_operation,$idcategorie,$idbanque,$iduser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO bank_journal(date_operation,libelle,credit,ID_banque,ID_categorie_depense,reference,typeOperation,considered,ID_user)  VALUES(:date_operation,:libelle,:credit,:idbanque,:idcategorie,:reference,'depense',1,:iduser)");
		$res = $query->execute(array('reference' => $reference,'credit' => $credit,'libelle' => $libelle,'date_operation' => $date_operation,'idcategorie' => $idcategorie,'idbanque'=>$idbanque,'iduser' => $iduser)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function getMaxIdPetiteDepense()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_depense) AS ID_depense FROM petitedepense");
		$query->execute();
		return $query;
	}
	/*function getMaxIdDepense()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_depense) AS ID_depense FROM depense");
		$query->execute();
		return $query;
	}*/
    function getMaxIdDepense()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(id) AS ID_depense FROM bank_journal WHERE credit IS NOT NULL");
		$query->execute();
		return $query;
	}
	function setCaisseDepense($idcaisse)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO caisse_depense(ID_caisse,ID_depense) SELECT :idcaisse,MAX(ID_depense) FROM depense");
		$res = $query->execute(['idcaisse' => $idcaisse]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function setBanqueDepense($idbanque)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO banque_depense(ID_banque,ID_depense) SELECT :idbanque,MAX(ID_depense) FROM depense");
		$res = $query->execute(['idbanque' => $idbanque]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getCategorieDepenses() 
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM categorie_depense ORDER BY ID_categorie_depense DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function reduireMontantCaisse($idprovenance,$montantDepense)
	{
		$con = connection();
		$query = $con->prepare("UPDATE caisse SET montantCaisse = montantCaisse - :montantDepense WHERE ID_caisse = :idprovenance");
		$res = $query->execute(array('montantDepense' => $montantDepense,'idprovenance' => $idprovenance)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function reduireMontantEnBanque($idprovenance,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE banque SET montant = montant - :montant WHERE ID_banque = :idprovenance");
		$res = $query->execute(array('montant' => $montant,'idprovenance' => $idprovenance)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function getPetiteDepenses($iduser)
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_depense,montantdepense,monnaie,motifdepense,datedepense,cat.ID_categorie_depense,cat.description,c.ID_caisse,nomCaisse,d.etat FROM petitedepense d,categorie_depense cat,caisse c WHERE d.ID_categorie_depense = cat.ID_categorie_depense AND c.ID_caisse = d.ID_caisse AND d.ID_user =? ORDER BY d.ID_depense DESC");
		$query->execute([$iduser]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtrePetiteDepense($condition,$iduser)
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_depense,montantdepense,monnaie,motifdepense,datedepense,cat.ID_categorie_depense,cat.description,c.ID_caisse,nomCaisse,pd.etat FROM petitedepense pd,categorie_depense cat,caisse c WHERE pd.ID_categorie_depense = cat.ID_categorie_depense AND c.ID_caisse = pd.ID_caisse AND pd.ID_user =? $condition ORDER BY pd.ID_depense DESC");
		$query->execute([$iduser]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getDepenses()
	{
		$con = connection ();
		$query = $con->prepare("SELECT d.reference,ID_depense,montantdepense,monnaie,motifdepense,datedepense,cat.ID_categorie_depense,description,provenance,ID_banque,ID_caisse,etat FROM depense d,categorie_depense cat WHERE d.ID_categorie_depense = cat.ID_categorie_depense ORDER BY d.ID_depense DESC LIMIT 100");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getBanqueJournalCredits()
	{
		$con = connection();
		$query = $con->prepare("SELECT id,date_operation,libelle,credit,b.ID_banque,b.nom,b.monnaie,cat.ID_categorie_depense,cat.description,bj.reference,etat FROM bank_journal bj,banque b,categorie_depense cat WHERE b.ID_banque = bj.ID_banque AND cat.ID_categorie_depense = bj.ID_categorie_depense AND typeOperation = 'depense' AND bj.isDelete = 0");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    /*function getDepense($iddepense)
	{
		$con = connection ();
		$query = $con->prepare("SELECT d.reference,ID_depense,montantdepense,monnaie,motifdepense,datedepense,cat.ID_categorie_depense,description,provenance,ID_banque,ID_caisse,etat FROM depense d,categorie_depense cat WHERE d.ID_categorie_depense = cat.ID_categorie_depense AND ID_depense =?");
		$query->execute([$iddepense]);
		return $query;
	}*/
    function getDepense($iddepense)
	{
		$con = connection ();
		$query = $con->prepare("SELECT bj.reference,bj.id,credit,libelle,date_operation,cat.ID_categorie_depense,description,ID_banque,etat FROM bank_journal bj,categorie_depense cat WHERE bj.ID_categorie_depense = cat.ID_categorie_depense AND bj.id =?");
		$query->execute([$iddepense]);
		return $query;
	}
    function getPetiteDepense($iddepense)
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_depense,montantdepense,monnaie,motifdepense,datedepense,cat.ID_categorie_depense,cat.description,ID_caisse,etat FROM petitedepense pd,categorie_depense cat WHERE pd.ID_categorie_depense = cat.ID_categorie_depense AND ID_depense =?");
		$query->execute([$iddepense]);
		return $query;
	}
    function getMontantDepenseAvantUneDate($idbanque,$datedepense)
	{
		$con = connection();
		$query= $con->prepare("SELECT SUM(montantdepense) AS montantdepense FROM depense WHERE ID_banque = :idbanque AND datedepense < :datedepense");
		$query->execute(['idbanque'=>$idbanque,'datedepense'=>$datedepense]);
		return $query->fetch()['montantdepense'];
	}
    function getCreditBuneBanqueAvantUneDate($idbanque,$date_operation)
	{
		$con = connection();
		$query= $con->prepare("SELECT SUM(credit) AS credit FROM bank_journal WHERE ID_banque = :idbanque AND date_operation < :date_operation AND isDelete = 0");
		$query->execute(['idbanque'=>$idbanque,'date_operation'=>$date_operation]);
		return $query->fetch()['credit'];
	}
	/*function filtreDepenses($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT d.reference,ID_depense,montantdepense,monnaie,motifdepense,datedepense,cat.ID_categorie_depense,description,provenance,ID_banque,ID_caisse,etat FROM depense d,categorie_depense cat WHERE d.ID_categorie_depense = cat.ID_categorie_depense $condition ORDER BY d.ID_depense");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function filtreDepenses($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT id,date_operation,libelle,credit,b.ID_banque,b.nom,b.monnaie,cat.ID_categorie_depense,cat.description,bj.reference,etat FROM bank_journal bj,banque b,categorie_depense cat WHERE b.ID_banque = bj.ID_banque AND cat.ID_categorie_depense = bj.ID_categorie_depense AND credit IS NOT NULL AND bj.isDelete = 0 $condition ORDER BY bj.id");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreBankJournal($condition)
	{
		$con = connection ();
		$query = $con->prepare("SELECT id,date_operation,libelle,debit,credit,b.ID_banque,b.nom,b.monnaie,bj.reference,bj.etat FROM bank_journal bj,banque b WHERE b.ID_banque = bj.ID_banque AND bj.isDelete = 0 $condition ORDER BY bj.date_operation");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getCaisseProvenanceDepense($iddepense)
	{
		$con = connection();
		$query = $con->prepare("SELECT c.ID_caisse,nomcaisse FROM caisse c,depense d,caisse_depense cd WHERE c.ID_caisse = cd.ID_caisse AND cd.ID_depense = d.ID_depense AND d.ID_depense = ?");
		$query->execute([$iddepense]); 
		return $query;
	}
	function getBanqueProvenanceDepense($iddepense)
	{
		$con = connection();
		//$query = $con->prepare("SELECT b.ID_banque,nom FROM banque b,depense d,banque_depense bd WHERE b.ID_banque = bd.ID_banque AND bd.ID_depense = d.ID_depense AND d.ID_depense = ?");
        $query = $con->prepare("SELECT b.ID_banque,nom FROM banque b,depense d WHERE b.ID_banque = d.ID_banque AND d.ID_depense = ?");
		$query->execute([$iddepense]);
		return $query;
	}
	/*function totalDepenseDunMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montantdepense) AS montant,monnaie FROM depense WHERE MONTH(datedepense) = :mois AND YEAR(datedepense) =:annee GROUP BY monnaie");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function totalDepenseDunMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(credit) AS montant,monnaie FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND MONTH(date_operation) = :mois AND YEAR(date_operation) =:annee GROUP BY monnaie");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getMontantDepenseGrandeCaisseDunMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montantdepense) AS montant,monnaie FROM depense,caisse WHERE MONTH(datedepense) = :mois AND YEAR(datedepense) = :annee AND depense.provenance = 'caisse' AND depense.ID_caisse = caisse.ID_caisse AND caisse.dimension = 'grande' GROUP BY monnaie");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getMontantDepenseBanqqueDunMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montantdepense) AS montant,monnaie FROM depense WHERE MONTH(datedepense) = :mois AND YEAR(datedepense) = :annee AND depense.provenance = 'banque' GROUP BY monnaie");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getMontantApprovisionnementDunMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(ap.montant) as montant,monnaie FROM approvisionnement ap,banque b WHERE ap.ID_banque = b.ID_banque AND MONTH(date_appro) = :mois AND YEAR(date_appro) = :annee GROUP BY monnaie");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function depenseDunePeriodeDunUser($date_debut,$date_fin,$iduser)
	{
		$con = connection();SELECT depense.ID_depense,datedepense,montantdepense,motifdepense,nomCaisse,devise,categorie_depense.description FROM depense ,caisse ,user ,caisse_depense ,categorie_depense WHERE depense.ID_depense = caisse_depense.ID_depense AND caisse.ID_caisse=caisse_depense.ID_caisse AND categorie_depense.ID_categorie_depense = depense.ID_categorie_depense AND datedepense BETWEEN :date_debut AND :date_fin GROUP BY depense.ID_depense

		$query = $con->prepare("SELECT datedepense,montantdepense,motifdepense,nomCaisse,devise FROM depense d,caisse c,user u WHERE d.ID_user = u.ID_user AND c.ID_caisse = d.ID_caisse AND datedepense BETWEEN :date_debut AND :date_fin AND d.ID_user = :iduser");
		$query->execute(array('date_debut' => $date_debut,'date_fin' => $date_fin,'iduser' => $iduser)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}*/
	function depenseDunePeriodeDunUser($mois,$annee)
	{
		$con = connection();

		$query = $con->prepare("SELECT depense.ID_depense,datedepense,montantdepense,motifdepense,monnaie,categorie_depense.description AS categorie FROM depense ,categorie_depense WHERE  categorie_depense.ID_categorie_depense = depense.ID_categorie_depense AND MONTH(datedepense) = :mois AND YEAR(datedepense) = :annee");
		$query->execute(array('mois' => $mois,'annee' => $annee)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function grandeCaisseDisponibleNotNull()
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM caisse WHERE montantCaisse > 0 AND dimension = 'grande'");
		$query->execute();
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
	}
	function getGrandeCaisseByMonnaie($monnaie)
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM caisse WHERE  dimension = 'grande' AND devise = ?");
		$query->execute([$monnaie]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getGrandeCaisses()
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM caisse WHERE  dimension = 'grande'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getCaisseDepenses()
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM caisse WHERE  typeCaisse = 'cd'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function getCaisseRecetteByMonnaie($monnaie)
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM caisse WHERE  typeCaisse = 'cr' AND devise =:monnaie ");
		$query->execute(['monnaie'=>$monnaie]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getCaisseRecettes()
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM caisse WHERE  typeCaisse = 'cr'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getMontantCaisse($idcaisse)
	{
		$con = connection();
		$query = $con->prepare("SELECT montantCaisse,devise FROM caisse WHERE ID_caisse = ?");
		$query->execute([$idcaisse]);
		return $query;
	}
	function approvisionnerCompte($provenance,$montant,$monnaie,$idcompte,$dateApro,$iduser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO approvisioner_compte(provenance,montant,monnaie,ID_compte,dateApro,ID_user) VALUES(:provenance,:montant,:monnaie,:idcompte,:dateApro,:iduser)");
		$res = $query->execute(['provenance' => $provenance,'montant' => $montant,'monnaie' => $monnaie,'idcompte' => $idcompte,'dateApro' => $dateApro,'iduser' => $iduser]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function setBanqueAprovisionnerCompte($idbanque)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO banque_aprovisionner_compte(ID_banque,ID_approvCompte) SELECT :idbanque,MAX(ID_approvCompte) FROM approvisioner_compte");
		$res = $query->execute(['idbanque' => $idbanque]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function setCaisseAprovisionnerCompte($idcaisse)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO caisse_approvisionne_compte(ID_caisse,ID_approvCompte) SELECT :idcaisse,MAX(ID_approvCompte) FROM approvisioner_compte");
		$res = $query->execute(['idcaisse' => $idcaisse]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function transfertMontantde_banque_vers_compte($idbanque,$montant,$idcompte)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE banque,compte SET montantcompte = montantcompte + :montant,montantVersser = montantVersser - :montantbanque WHERE ID_compte = :idcompte AND ID_banque = :idbanque");
	 	$res = $query->execute(array('idbanque' => $idbanque,'montant' => $montant,'montantbanque' => $montant,'idcompte' => $idcompte)) or die(print_r($query->errorInfo()));
	 	return $res;
	}
	function transfertMontantde_caisse_vers_compte($idcaisse,$montant,$idcompte)
	{
	 	$con = connection();
	 	$query = $con->prepare("UPDATE caisse,compte SET montantcompte = montantcompte + :montant,montantCaisse = montantCaisse  - :montantcaisse WHERE ID_compte = :idcompte AND ID_caisse = :idcaisse");
	 	$res = $query->execute(array('idcaisse' => $idcaisse,'montant' => $montant,'montantcaisse' => $montant,'idcompte' => $idcompte)) or die(print_r($query->errorInfo()));
	 	return $res;
	}
	function update_compteComptable($code,$idcompte,$nomcompte,$lignecredit,$monnaie,$datecompte,$montantcompte,$commentaire)
	{
	    $con = connection();
		$query = $con->prepare("UPDATE compte SET code_compte = :code,nomCompte =:nomcompte,lignecredit = :lignecredit,montantcompte = :montantcompte,devise = :monnaie,dateCompte = :datecompte,note = :commentaire WHERE ID_compte = :idcompte");
		$rs =$query->execute(array('code'=>$code,'nomcompte' => $nomcompte,'lignecredit'=>$lignecredit,'montantcompte'=>$montantcompte,'monnaie'=>$monnaie,'datecompte'=>$datecompte,'commentaire'=>$commentaire,'idcompte'=>$idcompte));

		$error = $query->errorInfo();
		return $rs;
	}
	function deleteCompteComptable($idcompte)
	{
    	$con = connection();
	 	$query = $con->prepare("DELETE FROM compte WHERE ID_compte = ?");
	 	$rs = $query->execute(array($idcompte)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	/*function supprimerdepense($id_depnse)
	{
	 	$con = connection();
	 	$query = $con->prepare("DELETE FROM depense WHERE ID_depense = ?");
	 	$rs = $query->execute(array($id_depnse)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}*/
    function supprimerdepense($id_depnse)
	{
	 	$con = connection();
	 	//$query = $con->prepare("DELETE FROM bank_journal WHERE id = ?");
	 	$query = $con->prepare("UPDATE bank_journal SET isDelete = 1 WHERE id = ?");
	 	$rs = $query->execute(array($id_depnse)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
    function supprimerPetitedepense($id_depnse)
	{
	 	$con = connection();
	 	$query = $con->prepare("DELETE FROM petitedepense WHERE ID_depense = ?");
	 	$rs = $query->execute(array($id_depnse)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
    function updatedepense($iddepense,$datedepense,$motif,$idcategorie,$reference)
    {
  		$con = connection();
	 	$query = $con->prepare("UPDATE depense SET reference=:reference,datedepense =:datedepense, motifdepense =:motif,ID_categorie_depense =:idcategorie WHERE ID_depense= :iddepense ");
	 	$res = $query->execute(array('iddepense' => $iddepense,'datedepense' => $datedepense,'motif'=>$motif,'idcategorie' => $idcategorie,'reference'=>$reference)) or die(print_r($query->errorInfo()));
	 	return $res;
    }
    /*function cloturerDepenses($iduser,$datedepense)
    {
    	$con = connection();
    	$query = $con->prepare("UPDATE depense SET etat = 1 WHERE datedepense = :datedepense AND ID_user = :iduser AND etat = 0");
    	$res = $query->execute(['datedepense' => $datedepense,'iduser' => $iduser]) or die(print_r($query->errorInfo()));
    	return $res;
    }*/
    function cloturerDepenses($iduser)
    {
    	$con = connection();
    	$query = $con->prepare("UPDATE bank_journal SET etat = 1 WHERE credit IS NOT NULL AND ID_user = :iduser AND etat = 0");
    	$res = $query->execute(['iduser' => $iduser]) or die(print_r($query->errorInfo()));
    	return $res;
    }
    function cloturerPetiteDepenses($iduser)
    {
    	$con = connection();
    	$query = $con->prepare("UPDATE petitedepense SET etat = 1 WHERE ID_user = :iduser AND etat = 0");
    	$res = $query->execute(['iduser' => $iduser]) or die(print_r($query->errorInfo()));
    	return $res;
    }
    /*function get_rapport_banque() 
    {
		$con = connection ();
		$query = $con->prepare("SELECT ID_banque,nom,monnaie,montantVersser,nouveau_montant FROM `banque` GROUP BY ID_banque") or die(print_r($query->errorInfo()));
		$query->execute();
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
    }*/
    function depensejournaliere()
	{
		$con = connection ();
		$query = $con->prepare("SELECT datedepense,montantdepense,motifdepense,categorie_depense.description,categorie_depense.type_categorie,provenance,monnaie,reference FROM `categorie_depense`,depense WHERE depense.ID_categorie_depense = categorie_depense.ID_categorie_depense AND depense.datedepense =?");
		$query->execute(array(date('Y-m-d')));
		$rs = array();

		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;

	}
    function getMontantBanque($idbanque)
    {
    	$con = connection();
    	$query = $con->prepare("SELECT montantVersser,monnaie FROM banque WHERE ID_banque = ?");
    	$query->execute([$idbanque]);
    	return $query;
    }
    function get_rapport_caisse()
    {
		$con = connection ();
		$query = $con->prepare("SELECT SUM(montantCaisse),dimension FROM `caisse` GROUP BY dimension") or die(print_r($query->errorInfo()));
		$query->execute();
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
    }
    function get_cliet_avec_service() 
    {
		$con = connection ();
		$query = $con->prepare("SELECT COUNT(*) AS nombre,service.nomService FROM serviceinclucontract,service,client,contract WHERE client.ID_client = contract.ID_client AND serviceinclucontract.ID_service = service.ID_service GROUP BY service.ID_service") or die(print_r($query->errorInfo()));
		$query->execute();
		$rs = array();
		while ( $data = $query->fetchObject()) 
		{
			$rs[] = $data;
		}
		return $rs;
    }
    function getPaiementTotalParMois($annee,$mois)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant)AS montant,devise FROM paiement WHERE MONTH(datepaiement) = :mois AND YEAR(datepaiement) = :annee");
		$query->execute(['mois' => $mois,'annee' => $annee]) or die(print_r($query->errorInfo()));
		return $query;
	}
	function total_extrat($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant FROM extrat WHERE MONTH(date_extrat) = :mois AND YEAR(date_extrat) = :annee");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query;
	}
	/*function total_extrat_dun_mois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant,monnaie FROM extrat WHERE MONTH(date_extrat) = :mois AND YEAR(date_extrat) = :annee GROUP BY monnaie");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function total_extrat_dun_mois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(debit) AS montant,monnaie FROM bank_journal bj,banque b WHERE bj.ID_banque = b.ID_banque AND MONTH(date_operation) = :mois AND YEAR(date_operation) = :annee AND typeOperation = 'extrat' GROUP BY monnaie");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function montant_depense_totale($annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montantdepense) AS montant FROM depense WHERE YEAR(datedepense) = ?");
		$query->execute([$annee]);
		return $query;
	}
	function montant_total_Extrat()
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant FROM extrat");
		$query->execute();
		return $query;
	}
	function total_payment()
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant FROM paiement");
		$query->execute();
		return $query;
	}
	function ajouterTypeExtra($type)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO type_extrat(libelle_extrat) VALUES(?)");
		$rs = $query->execute(array($type)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function get_type_extrat()
	{
		$con = connection ();
		$query = $con->prepare("SELECT * FROM type_extrat");

		$query->execute();
		$rs = array();

		while ( $data = $query->fetchObject()) 
		{
		# code...
		$rs[] = $data;
		}
		return $rs;
	}
	function setCategieDepense($categorie,$type_categorie) 
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO categorie_depense(description,type_categorie) VALUES(:description,:type_categorie)");
		$rs = $query->execute(array('description'=>$categorie,'type_categorie' =>$type_categorie)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function updateCategorieDepense($idcategorie,$type_categorie,$description)
	{
		$con = connection();
		$query = $con->prepare("UPDATE categorie_depense SET description = :description,type_categorie=:type_categorie WHERE ID_categorie_depense = :idcategorie");
		$rs =$query->execute(array('description'=>$description,'idcategorie' => $idcategorie,'type_categorie' => $type_categorie)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function supprimeCategorie($numcategorie)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM categorie_depense WHERE ID_categorie_depense = ?");
		$res = $query->execute([$numcategorie]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function update_type_extrat($refextrat,$libelle)
	{
		$con = connection();
		$query = $con->prepare("UPDATE type_extrat SET libelle_extrat = :libelle WHERE ID_type_extrat = :refextrat");
		$rs =$query->execute(array('libelle' => $libelle,'refextrat' => $refextrat));

		$error = $query->errorInfo();
		return $rs;
	}
	function supprime_tpe_extrat($num_extrat)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM type_extrat WHERE ID_type_extrat = ?");
		$res = $query->execute([$num_extrat]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function montant_total()
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(nouveau_montant) AS montant FROM banque  ");
		
		$query->execute() or die(print_r($query->errorInfo()));
		$montant = 0;
		while ($data = $query->fetchObject()) 
		{
			/*if ($data->monnaie == 'USD') 
			{
				$montant +=$data->montant*$data->exchange_rate;
			}
			else*/
			$montant +=$data->montant;
		}
		return $montant;
	}
	function ajouter_dette($dette,$montant,$monnaie,$motif,$datecreation)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO dette(nom_dette,montant,monnaie,motif,datecreation) VALUES(:dette,:montant,:monnaie,:motif,:datecreation)");
		$res = $query->execute(['dette' => $dette,'montant' => $montant,'monnaie'=>$monnaie,'motif' => $motif,'datecreation' => $datecreation]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getMaxIddette()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_dette) AS ID_dette FROM dette");
		$query->execute();
		return $query;
	}
	function affiche_dette()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM dette WHERE dette.montant > 0");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function diminuer_dette($refdette,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE dette SET montant = montant - :montant WHERE ID_dette = :refdette");
		$res = $query->execute(array('montant' => $montant,'refdette' => $refdette)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function setHistorique_dette_paye($nomss,$detteTotale,$monnaie,$datepaie,$provenance,$userName)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO historique_paie(nom,montant_paie,monnaie,date_histo,provenancePayement,userName) VALUES(:nomss,:detteTotale,:monnaie,:datepaie,:provenance,:userName)");
		$res = $query->execute(['nomss' => $nomss,'detteTotale' => $detteTotale,'monnaie'=>$monnaie,'datepaie' => $datepaie,'provenance'=>$provenance,'userName' => $userName]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getHistoriquepaie()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM historique_paie");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function filtreHistoriquePayementDette($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM historique_paie WHERE $condition");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function changer_dette($id_dette,$dette,$montant,$monnaie,$motif,$datecreation)
	{
		$con = connection();
		$query = $con->prepare("UPDATE dette SET nom_dette =:dette,montant = :montant,monnaie =:monnaie,motif = :motif,datecreation =:datecreation WHERE ID_dette = :id_dette");
		$res = $query->execute(array('dette'=>$dette,'montant' => $montant,'monnaie'=>$monnaie,'motif'=>$motif,'id_dette' => $id_dette,'datecreation'=>$datecreation)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function suppression_dette($id_dette)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM dette WHERE ID_dette= ?");
		$res = $query->execute([$id_dette]) or die(print_r($query->errorInfo()));
		return $res;
	}
}
