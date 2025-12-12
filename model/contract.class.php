<?php

/**
 * 
 */
class Contract
{
	function saveContract($numero,$ID_client,$type,$monnaie_facture,$monnaie_contrat,$tva,$mode,$date_contract,$etat,$startDate,$facturation,$show_rate,$enable_discounts)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO contract(numero,ID_client,type,monnaie,monnaie_facture,tva,mode,facturation,startDate,date_creation,show_rate,enable_discounts,etat) VALUES(:numero,:ID_client,:type,:monnaie,:monnaie_facture,:tva,:mode,:facturation,:startDate,:date_contract,:show_rate,:enable_discounts,:etat)");
		$res = $query->execute(array('numero' => $numero,'ID_client' => $ID_client,'type' => $type,'monnaie' => $monnaie_contrat,'monnaie_facture' =>$monnaie_facture,'tva' => $tva,'mode' => $mode,'date_contract' => $date_contract,'etat' => $etat,'startDate' => $startDate,'facturation' => $facturation,'show_rate' => $show_rate,'enable_discounts' => $enable_discounts));
		//$error = $query->errorInfo();
		return $res;
	}
	function getIdContract_par_numero($numero)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_contract FROM contract WHERE numero = ?");
		$query->execute([$numero]);
		return $query;
	}
	function saveServiceInclu($ID_contract,$ID_service,$bande_passante,$montant,$idclient,$tva,$quantite,$nom_client,$adresse,$show_on_facture=1,$status)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO serviceinclucontract(ID_contract,ID_service,ID_client,montant,quantite,prixTva,bandepassante,nom,adress,show_on_facture,status) VALUES(:ID_contract,:ID_service,:idclient,:montant,:quantite,:tva,:bande_passante,:nom_client,:adresse,:show_on_facture,:status)");
		$rs = $query->execute(array('ID_contract' => $ID_contract,'ID_service' => $ID_service,'tva' => $tva,'bande_passante' => $bande_passante,'nom_client' => $nom_client,'adresse' => $adresse,'show_on_facture' =>$show_on_facture,'status' => $status,'montant' => $montant,'quantite' => $quantite,'idclient' => $idclient)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function setProfiArticleToContract($idcontract,$profil_id)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO profil_articletocontract(ID_contract,profil_id) VALUES(:idcontract,:profil_id)");
		$res = $query->execute(array('idcontract' => $idcontract,'profil_id' => $profil_id)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getNext_billing_date_dun_client($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_contract,next_billing_date,DATE_FORMAT(next_billing_date,'%d/%m/%Y') AS next_billing_date_format FROM contract WHERE ID_client = :idclient");
		$query->execute(['idclient' => $idclient]);
		return $query;
	}
	function updateNext_billing_date($idcontract,$next_billing_date)
	{
		$con = connection();
		$query = $con->prepare("UPDATE contract SET next_billing_date =:next_billing_date WHERE ID_contract =:idcontract");
		$res = $query->execute(['next_billing_date'=>$next_billing_date,'idcontract'=>$idcontract]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function update_Facture_next_billing_date($facture_id,$next_billing_date)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture SET next_billing_date =:next_billing_date WHERE facture_id =:facture_id");
		$res = $query->execute(['next_billing_date'=>$next_billing_date,'facture_id'=>$facture_id]) or die(print_r($query->errorInfo()));
		return $res;
	}

	function updateContract($idcontract,$idclient,$monnaie,$monnaie_facture,$tva,$mode,$facturation,$startDate,$etat,$show_rate,$enable_discounts,$date_update_contrat)
	{
		$con = connection();
		$query = $con->prepare("UPDATE contract SET ID_client =:idclient,monnaie =:monnaie,monnaie_facture =:monnaie_facture,tva =:tva,mode =:mode,facturation =:facturation,startDate =:startDate,show_rate=:show_rate,enable_discounts =:enable_discounts,etat =:etat,date_update_contrat =:date_update_contrat WHERE ID_contract = :idcontract");
		$res = $query->execute(array('idclient' => $idclient,'monnaie' => $monnaie,'monnaie_facture' => $monnaie_facture,'tva' => $tva,'mode' => $mode,'facturation' => $facturation,'startDate' => $startDate,'show_rate'=>$show_rate,'enable_discounts' => $enable_discounts,'etat' => $etat,'idcontract' => $idcontract,'date_update_contrat'=>$date_update_contrat)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateProfilToContrat($idcontract,$profil_id)
	{
		$con = connection();
		$query = $con->prepare("UPDATE profil_articletocontract SET profil_id =:profil_id WHERE ID_contract =:idcontract");
		$res = $query->execute(['profil_id' => $profil_id,'idcontract' => $idcontract]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateEtatContract($idclient,$etat)
	{
		$con = connection();
		$query = $con->prepare("UPDATE contract SET etat =:etat WHERE ID_client=:idclient");
		$res = $query->execute(['etat'=>$etat,'idclient'=>$idclient]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deleteContract($num_contract)
	{
		$con = connection();
		//$query = $con->prepare("DELETE FROM contract WHERE ID_contract = ?");
		$query = $con->prepare("UPDATE contract SET isDelete = 1 WHERE ID_contract = ?");
		$res = $query->execute(array($num_contract)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function recupererContractLierAunService($idservice)
	{
		$con = connection();
		$query = $con->prepare("SELECT co.ID_contract FROM contract co,serviceinclucontract si,service se WHERE co.ID_contract = si.ID_contract AND si.ID_service = se.ID_service AND se.ID_service = ? GROUP BY co.ID_contract");
		$query->execute(array($idservice)) or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function updateServiceIncluContract($id,$idservice,$idclient,$bande_passante,$montant,$prixtva,$status,$quantite,$nom,$adress,$show_on_facture)
	{
		$con = connection();
		$query = $con->prepare("UPDATE serviceinclucontract SET ID_service =:idservice,montant =:montant,quantite=:quantite,prixTva =:prixtva,bandepassante =:bandepassante,nom =:nom,adress =:adress,show_on_facture =:show_on_facture,status =:status WHERE id =:id");
		$res = $query->execute(array('idservice' => $idservice,'montant' => $montant,'quantite'=>$quantite,'prixtva' => $prixtva,'bandepassante' => $bande_passante,'nom' => $nom,'adress' =>$adress,'show_on_facture' =>$show_on_facture,'id' => $id,'status' => $status)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function detailContract($idcontract)
	{
		$con = connection();
		$query = $con->prepare("SELECT nomService,bandepassante,si.montant,nom_client,co.etat FROM contract co,client cl,serviceinclucontract si,service se WHERE co.ID_contract = si.ID_contract AND se.ID_service = si.ID_service AND cl.ID_client = si.ID_client AND co.ID_contract = ?");
		$query->execute(array($idcontract)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
    function getNumeroAndLangueContrat($idcontract)
	{
		$con = connection();
		$query = $con->prepare("SELECT numero,langue FROM contract co,client cl WHERE co.ID_client = cl.ID_client AND ID_contract = ?");
		$query->execute([$idcontract]);
		return $query;
	}
	function getClientToPrintToContract($idcontract)
	{
		$con = connection();
		$query = $con->prepare("SELECT DISTINCT(nom_client),personneDeContact,adresse,telephone,mobile_phone,mail,assujettiTVA,langue,genre FROM client cl,service se,serviceinclucontract si,contract co WHERE co.ID_client = cl.ID_client AND co.ID_contract = si.ID_contract AND se.ID_service = si.ID_service AND co.ID_contract = ?");
		$query->execute(array($idcontract)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function getServiceToPrintToContract($idcontract)
	{
		$con = connection();
		$query = $con->prepare("SELECT si.id,cl.ID_client,si.nom,adress,nomService,s.ID_service,bandepassante,si.montant,rediction,prixTva,co.monnaie,tva,quantite,si.show_on_facture,si.status FROM serviceinclucontract si,service s,contract co,client cl WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND si.status = 0 AND si.ID_contract = ?");
		$query->execute(array($idcontract)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function afficherContracts()
	{
		$con = connection();
		$query = $con->prepare("SELECT co.ID_contract,numero,cl.ID_client,billing_number,Nom_client,type,SUM(si.montant) AS montant,co.monnaie,co.monnaie_facture,co.date_creation,co.etat,mode,facturation,startDate,co.tva,SUM(prixTva) AS prixTva,show_rate,enable_discounts,profil_id FROM client cl,serviceinclucontract si,service s,contract co,profil_articletocontract pa WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND co.ID_contract =pa.ID_contract AND co.isDelete = 0 GROUP BY co.ID_contract ORDER BY co.date_creation DESC LIMIT 100");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function filtre_contract($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT co.ID_contract,numero,cl.ID_client,billing_number,Nom_client,type,SUM(si.montant) AS montant,co.monnaie,co.monnaie_facture,co.date_creation,co.etat,mode,facturation,startDate,co.tva,SUM(prixTva) AS prixTva,show_rate,enable_discounts,profil_id FROM client cl,serviceinclucontract si,service s,contract co,profil_articletocontract pa WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND co.ID_contract = pa.ID_contract AND co.isDelete = 0 $condition GROUP BY co.ID_contract");
		$query->execute() or die(print_r($query->errorInfo()));
		
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function afficherfichier_client_avec_contrat()
	{
		$con = connection();
		$query = $con->prepare("SELECT nom,fichier,date_fichier,ID_fichier_client, cl.ID_client,Nom_client,billing_number FROM client cl,fichier_client fcl WHERE  fcl.ID_client = cl.ID_client GROUP BY ID_fichier_client DESC LIMIT 100");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
    function filtreFichierAttacher($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT nom,fichier,date_fichier,ID_fichier_client, cl.ID_client,Nom_client,billing_number FROM client cl,fichier_client fcl WHERE fcl.ID_client = cl.ID_client $condition GROUP BY ID_fichier_client DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function  creerfichier_attacher($idclient,$nom,$fichier,$userfile,$datecreation)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO fichier_client(ID_client,nom,fichier,ID_user,date_fichier) VALUES(:idclient,:nom,:fichier,:userfile,:datecreation)");
		$res = $query->execute(array('idclient' => $idclient,'nom' => $nom,'fichier' => $fichier,'userfile' => $userfile,'datecreation' => $datecreation)) or die(print_r($query->errorInfo()));
		//$error = $query->errorInfo();
		return $res;
	}
    function get_max_attache_file_id()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(ID_fichier_client) AS id FROM fichier_client");
		$query->execute();
		return $query->fetch()['id'];
	}
	function getAttachFileForOneClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT nom,fichier,date_fichier,ID_fichier_client, cl.ID_client,Nom_client FROM client cl,fichier_client fcl WHERE  fcl.ID_client = cl.ID_client AND cl.ID_client= ?");
		$query->execute([$idclient]) or die(print_r($query->errorInfo()));
		$rs = $query->fetchAll(PDO::FETCH_OBJ);
		return $rs;
	}
	function recupererMaxNumeroContract()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(numero) AS numero FROM contract");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query;
	}

	/*
	*  GESTION FACTURE
	*
	*/
	 //FONCTION D'IMPORTATION DES FACTURES DE AJYWA DE JANVIER A AOUT 2020
	function importDataFacture()
	{
		$con = connection();
		//$query = $con->prepare("SELECT * FROM invoices LIMIT 2800,400");
        $query = $con->prepare("SELECT ID_client FROM client WHERE type_client <> 'potentiel' AND type_client <> 'inconnu' AND type_client <> 'free' AND type_client <> 'staff' LIMIT 2000,500"); 
		//$query = $con->prepare("SELECT billing_number,contract.ID_contract,serviceinclucontract.ID_service,client.ID_client,import_facture.montant,import_facture.monnaie,mois,quantite,reduction,import_facture.date_creation FROM import_facture,client,contract,serviceinclucontract WHERE client.ID_client = contract.ID_client AND contract.ID_contract = serviceinclucontract.ID_contract AND client.ID_client = import_facture.ID_client AND mois=1");
		//$query = $con->prepare("SELECT billing_number,contract.ID_contract,service.ID_service,client.ID_client,client.Nom_client,import_facture.montant,import_facture.monnaie,mois,quantite,reduction,import_facture.date_creation FROM import_facture,client,contract,service,serviceinclucontract WHERE client.ID_client = contract.ID_client AND contract.ID_contract = serviceinclucontract.ID_contract AND serviceinclucontract.ID_service = service.ID_service AND client.Nom_client = import_facture.nom_client AND import_facture.nom_client = 'SPARTACUS'");
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getInvoiceServices()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM `facture_service` WHERE billing_cycle = 1 LIMIT 0,1000");
		//$query = $con->prepare("SELECT id,fac.facture_id,montant,montant_total,mois_debut,annee,quantite,tva,fac.reduction,billing_cycle,startDate,endDate FROM facture_service fs,facture fac WHERE fac.facture_id = fs.facture_id LIMIT 19000,1000");
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function setImportFactureService($id,$facture_id,$ID_client,$ID_service,$bande_passante,$montant,$montant_total,$montant_tva,$startDate,$endDate,$mois_debut,$mois_fin,$quantite,$annee,$annee_fin,$description,$billing_cycle)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO facture_service(id,facture_id,ID_client,ID_service,bande_passante,montant,montant_total,montant_tva,startDate,endDate,mois_debut,mois_fin,quantite,annee,annee_fin,description,billing_cycle) VALUES(:id,:facture_id,:ID_client,:ID_service,:bande_passante,:montant,:montant_total,:montant_tva,:startDate,:endDate,:mois_debut,:mois_fin,:quantite,:annee,:annee_fin,:description,:billing_cycle)");

		$res = $query->execute(['id'=>$id,'facture_id'=>$facture_id,'ID_client'=>$ID_client,'ID_service'=>$ID_service,'bande_passante'=>$bande_passante,'montant'=>$montant,'montant_total'=>$montant_total,'montant_tva'=>$montant_tva,'startDate'=>$startDate,'endDate'=>$endDate,'mois_debut'=>$mois_debut,'mois_fin'=>$mois_fin,'quantite'=>$quantite,'annee'=>$annee,'annee_fin'=>$annee_fin,'description'=>$description,'billing_cycle'=>$billing_cycle]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateFactureServiceImport($id,$montant_total,$montant_tva,$mois_fin,$annee_fin)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture_service SET montant_total=:montant_total,montant_tva=:montant_tva,mois_fin =:mois_fin,annee_fin =:annee_fin WHERE id = :id");
		$res = $query->execute(['montant_total'=>$montant_total,'montant_tva'=>$montant_tva,'mois_fin'=>$mois_fin,'annee_fin'=>$annee_fin,'id'=>$id]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function getFactureServiceViaMmail()
	{
		$con = connection();
		$query = $con->prepare("SELECT fs.id,fc.facture_id,ID_service,quantite,montant,montant_total_avant_reduction,montant_total,montant_tva FROM `facture_service` fs,facture fc WHERE fc.facture_id = fs.facture_id AND creation_mode = 'mail' AND billing_date = '2021-11-01'");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function updateMontantService($id,$montant_total,$montant_tva)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture_service SET montant_total = :montant_total,montant_tva=:montant_tva WHERE id =:id");
		$query->execute(['montant_total'=>$montant_total,'montant_tva'=>$montant_tva,'id'=>$id]);
	}
	function updateBiling_date_facture($facture_id,$billing_date)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture SET billing_date = :billing_date WHERE facture_id =:facture_id");
		$res = $query->execute(['billing_date'=>$billing_date,'facture_id'=>$facture_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getFactureJanvier()
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.date_creation,cl.ID_client,fs.rediction,startDate,endDate,mois_debut,mois_fin,annee,annee_fin,fs.quantite,fs.billing_cycle FROM client cl,facture fac,facture_service fs WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND mois_debut ='1' AND annee =2021");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function creeFacture($numero,$idclient,$show_rate,$enable_discount,$reduction,$monnaie,$tva,$tvci,$date_creation,$taux,$exchange_currency,$fixe_rate,$next_billing_month,$next_billing_year,$billing_date,$etat_facture,$creation_mode)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO facture(numero,ID_client,show_rate,monnaie,tva,tvci,exchange_rate,exchange_currency,creation_mode,fixe_rate,date_creation,next_billing_month,next_billing_year,billing_date,enable_discounts,reduction,etat_facture) VALUES(:numero,:idclient,:show_rate,:monnaie,:tva,:tvci,:taux,:exchange_currency,:creation_mode,:fixe_rate,:date_creation,:next_billing_month,:next_billing_year,:billing_date,:enable_discount,:reduction,:etat_facture)");
		$res = $query->execute(array('numero' => $numero,'idclient'=>$idclient,'show_rate' => $show_rate,'monnaie' => $monnaie,'tva' => $tva,'tvci'=>$tvci,'taux'=>$taux,'exchange_currency'=>$exchange_currency,'creation_mode'=>$creation_mode,'fixe_rate'=>$fixe_rate,'date_creation' => $date_creation,'next_billing_month' =>$next_billing_month,'next_billing_year' =>$next_billing_year,'billing_date'=>$billing_date,'enable_discount'=>$enable_discount,'reduction'=>$reduction,'etat_facture'=>$etat_facture)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function creerFactureService($facture_id,$idservice,$bandeP,$montant,$montant_total_avant_reduction,$montant_total,$montant_tva,$montant_tvci,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$startDate=null,$endDate=null,$billing_cycle =1,$rediction,$ott)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO facture_service(facture_id,ID_service,bande_passante,montant,montant_total_avant_reduction,montant_total,montant_tva,montant_tvci,rediction,ott,startDate,endDate,mois_debut,mois_fin,quantite,annee,annee_fin,description,billing_cycle) VALUES(:facture_id,:idservice,:bandeP,:montant,:montant_total_avant_reduction,:montant_total,:montant_tva,:montant_tvci,:rediction,:ott,:startDate,:endDate,:mois_debut,:mois_fin,:quantite,:annee,:annee_fin,:description,:billing_cycle)");
		$res = $query->execute(array('facture_id' => $facture_id,'idservice' => $idservice,'bandeP'=>$bandeP,'montant' => $montant,'montant_total_avant_reduction'=>$montant_total_avant_reduction,'montant_total' => $montant_total,'montant_tva'=>$montant_tva,'montant_tvci'=>$montant_tvci,'rediction'=>$rediction,'startDate' => $startDate,'endDate' => $endDate,'mois_debut' => $mois_debut,'mois_fin' => $mois_fin,'quantite' => $quantite,'annee' => $annee_debut,'annee_fin' => $annee_fin,'description' => $description,'billing_cycle' => $billing_cycle,'ott'=>$ott)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function creerProformat($numero,$idclient,$show_rate,$enable_discount,$reduction,$monnaie,$tva,$tvci,$date_creation,$taux,$exchange_currency,$fixe_rate,$next_billing_month,$next_billing_year,$billing_date)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO proformat(numero,ID_client,show_rate,monnaie,tva,tvci,exchange_rate,exchange_currency,fixe_rate,date_creation,next_billing_month,next_billing_year,billing_date,enable_discounts,reduction) VALUES(:numero,:idclient,:show_rate,:monnaie,:tva,:tvci,:taux,:exchange_currency,:fixe_rate,:date_creation,:next_billing_month,:next_billing_year,:billing_date,:enable_discount,:reduction)");
		$res = $query->execute(array('numero' => $numero,'idclient'=>$idclient,'show_rate' => $show_rate,'monnaie' => $monnaie,'tva' => $tva,'tvci' => $tvci,'taux'=>$taux,'exchange_currency'=>$exchange_currency,'fixe_rate'=>$fixe_rate,'date_creation' => $date_creation,'next_billing_month' =>$next_billing_month,'next_billing_year' =>$next_billing_year,'billing_date'=>$billing_date,'billing_date'=>$billing_date,'enable_discount'=>$enable_discount,'reduction'=>$reduction)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function creerProformatService($facture_id,$idservice,$bandeP,$montant,$montant_total,$montant_tva,$montant_tvci,$mois_debut,$mois_fin,$quantite,$annee_debut,$annee_fin,$description,$startDate=null,$endDate=null,$billing_cycle)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO proformat_service(facture_id,ID_service,bande_passante,montant,montant_total,montant_tva,montant_tvci,startDate,endDate,mois_debut,mois_fin,quantite,annee,annee_fin,description,billing_cycle) VALUES(:facture_id,:idservice,:bandeP,:montant,:montant_total,:montant_tva,:montant_tvci,:startDate,:endDate,:mois_debut,:mois_fin,:quantite,:annee,:annee_fin,:description,:billing_cycle)");
		$res = $query->execute(array('facture_id' => $facture_id,'idservice' => $idservice,'bandeP'=>$bandeP,'montant' => $montant,'montant_total' => $montant_total,'montant_tva'=>$montant_tva,'montant_tvci'=>$montant_tvci,'startDate' => $startDate,'endDate' => $endDate,'mois_debut' => $mois_debut,'mois_fin' => $mois_fin,'quantite' => $quantite,'annee' => $annee_debut,'annee_fin' => $annee_fin,'description' => $description,'billing_cycle' => $billing_cycle)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateFacture($facture_id,$numero,$show_rate,$enable_discount,$reduction,$monnaie,$tva,$tvci,$date_creation,$taux,$fixe_rate,$exchange_currency,$next_billing_month,$next_billing_year,$billing_date,$etat_facture)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture SET numero=:numero,show_rate = :show_rate,monnaie = :monnaie,tva = :tva,tvci=:tvci,exchange_rate =:taux,exchange_currency=:exchange_currency,fixe_rate=:fixe_rate,date_creation = :date_creation,next_billing_month =:next_billing_month,next_billing_year =:next_billing_year,billing_date =:billing_date,enable_discounts=:enable_discount,reduction=:reduction,etat_facture =:etat_facture WHERE facture_id = :facture_id");
		$res = $query->execute(array('show_rate' => $show_rate,'monnaie' => $monnaie,'tva' => $tva,'tvci'=>$tvci,'taux' => $taux,'exchange_currency'=>$exchange_currency,'fixe_rate'=>$fixe_rate,'date_creation' => $date_creation,'numero' => $numero,'facture_id'=>$facture_id,'next_billing_month' => $next_billing_month,'next_billing_year' => $next_billing_year,'billing_date'=>$billing_date,'enable_discount'=>$enable_discount,'reduction'=>$reduction,'etat_facture'=>$etat_facture)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function update_Sent_Facture($facture_id,$sent)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture SET sent =:sent WHERE facture_id =:facture_id");
		$res = $query->execute(['sent' => $sent,'facture_id' => $facture_id]);
		return $res;
	}
	function updateResteFacture($facture_id,$reste)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture SET reste =:reste WHERE facture_id =:facture_id");
		$res = $query->execute(['reste' => $reste,'facture_id' => $facture_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function updateResteFacture_apres_modification_payement($facture_id,$reste)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture SET reste =reste + :reste WHERE facture_id =:facture_id");
		$res = $query->execute(['reste' => $reste,'facture_id' => $facture_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateEtatFacture($facture_id,$etat_facture)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture SET etat_facture = :etat_facture WHERE facture_id = :facture_id");
		$res = $query->execute(array('etat_facture' => $etat_facture,'facture_id' => $facture_id)) or die(print_r($query->errorInfo()));
		return $res;
	}
    function updateEtatFactureDeMoisCourant($billing_date)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture SET etat_facture = 'actif' WHERE billing_date = :billing_date");
		$res = $query->execute(array('billing_date' => $billing_date));
		return $res;
	}
	function setEtatFactureActifAfterDeleteCoupureAction($idclient,$mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture,facture_service SET etat_facture = 'actif' WHERE facture.facture_id = facture_service.facture_id AND mois_debut =:mois_debut AND annee =:annee AND facture_service.ID_client = :idclient");
		$res = $query->execute(array('mois_debut' => $mois,'annee' => $annee,'idclient' => $idclient)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateFactureService($id,$serviceId,$bandeP,$idclient,$montant,$montant_total_avant_reduction,$montant_total,$montant_tva,$montant_tvci,$startDate,$endDate,$mois_debut,$mois_fin,$quantite,$annee,$annee_fin,$description,$billing_cycle,$rediction,$ott)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture_service SET ID_service=:serviceId,bande_passante=:bandeP,montant =:montant,montant_total_avant_reduction=:montant_total_avant_reduction,montant_total =:montant_total,montant_tva=:montant_tva,montant_tvci =:montant_tvci,rediction=:rediction,ott=:ott,startDate=:startDate,endDate=:endDate,mois_debut =:mois_debut,mois_fin=:mois_fin,quantite =:quantite,annee =:annee,annee_fin=:annee_fin,description =:description,billing_cycle=:billing_cycle WHERE id = :id");
		$res = $query->execute(array('serviceId'=>$serviceId,'bandeP'=> $bandeP,'montant' => $montant,'montant_total_avant_reduction'=>$montant_total_avant_reduction,'montant_total' => $montant_total,'montant_tva'=>$montant_tva,'montant_tvci' => $montant_tvci,'rediction'=>$rediction,'startDate' => $startDate,'endDate' => $endDate,'mois_debut' => $mois_debut,'mois_fin'=>$mois_fin,'quantite' => $quantite,'annee' => $annee,'annee_fin' => $annee_fin,'description' => $description,'billing_cycle'=>$billing_cycle,'id' => $id,'ott'=>$ott)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateProformatService($id,$serviceId,$bandeP,$montant,$montant_total,$montant_tva,$montant_tvci,$startDate,$endDate,$mois_debut,$mois_fin,$quantite,$annee,$annee_fin,$description,$billing_cycle)
	{
		$con = connection();
		$query = $con->prepare("UPDATE proformat_service SET ID_service=:serviceId,bande_passante=:bandeP,montant =:montant,montant_total =:montant_total,montant_tva=:montant_tva,montant_tvci=:montant_tvci,startDate=:startDate,endDate=:endDate,mois_debut =:mois_debut,mois_fin=:mois_fin,quantite =:quantite,annee =:annee,annee_fin=:annee_fin,description =:description,billing_cycle=:billing_cycle WHERE id = :id");
		$res = $query->execute(array('serviceId'=>$serviceId,'bandeP'=> $bandeP,'montant' => $montant,'montant_total' => $montant_total,'montant_tva'=>$montant_tva,'montant_tvci' => $montant_tvci,'startDate' => $startDate,'endDate' => $endDate,'mois_debut' => $mois_debut,'mois_fin'=>$mois_fin,'quantite' => $quantite,'annee' => $annee,'annee_fin' => $annee_fin,'description' => $description,'billing_cycle'=>$billing_cycle,'id' => $id)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function verifierNextBilling($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(fs.facture_id) AS facture_id,next_billing_month,next_billing_year FROM facture fac,facture_service fs WHERE fac.facture_id=fs.facture_id AND fs.ID_client = ?");
		$query->execute([$idclient]) or die(print_r($query->errorInfo()));
		
		/*$query = $con->prepare("SELECT fc.facture_id,ID_client,mois_debut,mois_fin,annee,annee_fin FROM facture_service fs,facture fc WHERE fc.facture_id = fs.facture_id AND ID_client = :idclient AND mois_fin >= :mois_fin AND annee_fin >= :annee_fin AND type_facture = 0");
		$query->execute(['idclient'=>$idclient,'mois_fin'=>$mois_debut,'annee_fin'=>$annee_debut]);*/
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		//$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getFactureEnCoupureDunClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,mois_debut,mois_fin,annee,annee_fin,montant,montant_total FROM facture fac,facture_service fs WHERE fac.facture_id = fs.facture_id AND fs.ID_client = ? AND etat_facture = 'coupure'");
		$query->execute([$idclient]);
		return $query;
	}
    function get_Clients_Par_Mois_De_Facturation($billing_date)
	{
		$con = connection();
		$query = $con->prepare("SELECT client.ID_client FROM facture,client WHERE client.ID_client = facture.ID_client AND billing_date = :billing_date");
		$query->execute(['billing_date'=>$billing_date]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function updateMontantTotalDuneFacture($facture_id,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture_service SET montant_total = montant_total - :montant WHERE facture_id = :facture_id");
		$res = $query->execute(['montant'=> $montant,'facture_id'=>$facture_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getFacturesDunClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.date_creation,SUM(fs.montant_total) AS montant,mois_debut,mois_fin,annee,annee_fin,fs.quantite FROM client cl,facture fac,facture_service fs WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND fs.ID_client =? GROUP BY fs.facture_id ORDER BY fac.date_creation DESC");
		$query->execute([$idclient]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getFactureIdForOneClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT facture_id FROM facture_service WHERE ID_client = ?");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		return $query;
	}
	function recupererFactureIdMaxToPrint()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(fac.facture_id) AS facture_id,fac.monnaie,fac.tva,fac.date_creation,nom_client,adresse,nif,assujettiTVA,fs.montant,fs.rediction,mois_debut,fs.quantite,annee,nomService,si.bandepassante,show_rate,exchange_rate FROM client cl,facture fac,facture_service fs,service se,serviceinclucontract si WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND se.ID_service = fs.ID_service AND se.ID_service = si.ID_service");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
    function get_client_by_facture_id($facture_id)
    {
        
        $con = connection();
        $query = $con->prepare("SELECT cl.ID_client,cl.Nom_client,cl.adresse,cl.nif,cl.billing_number,cl.assujettiTVA,cl.telephone,fac.facture_id,fac.numero,
        DATE_FORMAT(fac.date_creation,'%d/%m/%Y') AS date_creation,fac.billing_date,fac.show_rate,fac.exchange_rate,fac.exchange_currency,fac.monnaie,fac.tvci,fac.tva,fac.enable_discounts,fac.reduction,fs.quantite,fs.rediction,fs.ott,fs.montant,fs.montant_total,fs.montant_tva,fs.startDate,fs.endDate,
        fs.mois_debut,fs.mois_fin,fs.annee,fs.annee_fin,si.bandepassante,fs.billing_cycle,se.ID_service,se.nomService,co.ID_contract,co.type AS contract_type,
        co.monnaie AS contract_monnaie,co.monnaie_facture,co.etat AS contract_etat,co.mode AS contract_mode,co.facturation AS contract_facturation,co.startDate AS contract_startDate,si.montant AS service_montant,si.prixTva AS service_prixTva,pa.profil_id,GROUP_CONCAT(DISTINCT CONCAT(se.nomService, ' (', si.montant, ' ', co.monnaie, ')') SEPARATOR ', ') AS services_inclus_contrat,SUM(si.montant) AS total_montant_contrat,SUM(si.prixTva) AS total_prixTva_contrat FROM facture fac INNER JOIN client cl ON fac.ID_client = cl.ID_client INNER JOIN facture_service fs ON fac.facture_id = fs.facture_id INNER JOIN service se ON fs.ID_service = se.ID_service LEFT JOIN contract co ON cl.ID_client = co.ID_client AND co.isDelete = 0 LEFT JOIN serviceinclucontract si ON co.ID_contract = si.ID_contract LEFT JOIN profil_articletocontract pa ON co.ID_contract = pa.ID_contract WHERE fac.facture_id = ? GROUP BY fac.facture_id, cl.ID_client, co.ID_contract ORDER BY co.date_creation DESC"); $query->execute([$facture_id]);
        return $query;
    }
	function recupererFactureToPrint($facture_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.numero,fac.monnaie,exchange_currency,fixe_rate,fac.tva,fac.tvci, montant_tva,fac.date_creation,fac.enable_discounts,fac.reduction,next_billing_month,next_billing_year, nom_client,adresse,nif,assujettiTVA,cl.billing_number,telephone,fs.montant,montant_tvci,fs.montant_total_avant_reduction,fs.montant_total,fs.bande_passante,startDate,endDate,billing_cycle,fs.description,mois_debut,mois_fin,fs.quantite,fs.rediction,ott, annee,annee_fin,nomService,show_rate,exchange_rate,fac.creation_mode FROM client cl,facture fac,facture_service fs,service se WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fac.ID_client AND fs.ID_service = se.ID_service AND fac.facture_id = ?");
		//$query = $con->prepare("SELECT fac.facture_id,fac.monnaie,exchange_currency,fixe_rate,fac.tva,montant_tva,fac.date_creation,next_billing_month,next_billing_year,nom_client,adresse,nif,assujettiTVA,fs.montant,fs.montant_total,fs.rediction,startDate,endDate,billing_cycle,fs.description,cl.billing_number,telephone,mois_debut,mois_fin,fs.quantite,annee,annee_fin,nomService,si.bandepassante,show_on_facture,show_rate,exchange_rate FROM client cl,facture fac,facture_service fs,service se,serviceinclucontract si WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND si.ID_client = fs.ID_client AND se.ID_service = si.ID_service AND fac.facture_id = ? ORDER BY cl.ID_client");
		$query->execute(array($facture_id)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}







	function validateInvoice($facture_id)
	{
		$con = connection();
		$query = $con->prepare("UPDATE facture SET validate = 0 WHERE facture_id = :facture_id");
		$res = $query->execute(['facture_id' => $facture_id]);
		return $res;
	}


	function getInvoiceToSendToObr($facture_id)
	{
		// old code to get the data to send to obr

		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.numero,fs.montant_tvci, fac.monnaie,exchange_currency,fixe_rate,fac.tva,fac.tvci, montant_tva,fac.date_creation,fac.enable_discounts,fac.reduction,next_billing_month,next_billing_year, nom_client,adresse,nif,assujettiTVA,cl.billing_number,telephone,fs.montant,fs.montant_htva,montant_tvci, fs.montant_total_avant_reduction,fs.montant_total,fs.montant_ttc,fs.bande_passante,startDate,endDate,billing_cycle,fs.description,mois_debut,mois_fin,fs.quantite,fs.rediction,ott, annee,annee_fin,nomService,show_rate,exchange_rate,fac.creation_mode FROM client cl,facture fac,facture_service fs,service se WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fac.ID_client AND fs.ID_service = se.ID_service AND fac.facture_id = ?");
		$query->execute(array($facture_id));
		return $query;


		// $con = connection();
		// $query = $con->prepare("SELECT fac.facture_id,fac.numero,fac.monnaie,exchange_currency,fixe_rate,fac.tva,fac.tvci, montant_tva,fac.date_creation,fac.enable_discounts,fac.reduction,next_billing_month,next_billing_year, nom_client,adresse,nif,assujettiTVA,cl.billing_number,telephone,fs.montant,fs.montant_htva,montant_tvci,fs.montant_total_avant_reduction,fs.montant_total,fs.montant_ttc,fs.bande_passante,startDate,endDate,billing_cycle,fs.description,mois_debut,mois_fin,fs.quantite,fs.rediction,ott, annee,annee_fin,nomService,show_rate,exchange_rate,fac.creation_mode FROM client cl,facture fac,facture_service fs,service se WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fac.ID_client AND fs.ID_service = se.ID_service AND fac.facture_id = ?");

		// $query->execute(array($facture_id)) or die(print_r($query->errorInfo()));
		// return $query->fetchAll(PDO::FETCH_OBJ);

	}


	
	function getInvoiceItems($facture_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT se.ID_service,nomService,fs.id AS idFs,fs.bande_passante,fs.montant,fs.montant_htva,fs.montant_tva,fs.montant_tvci ,fs.montant_total,fs.montant_ttc,startDate,endDate,quantite,fs.rediction,fs.description,fs.billing_cycle, fs.montant_total_avant_reduction, fs.ott, fac.exchange_rate, fac.monnaie, fac.exchange_currency FROM facture fac,service se,facture_service fs WHERE se.ID_service = fs.ID_service AND fac.facture_id = fs.facture_id AND fac.facture_id = ?");
		$query->execute(array($facture_id)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}





	    function updateFactureSignature($facture_id, $invoice_signature, $identifier, $date)
    {
        $pdo = connection();

        // Prepare the SQL statement
        $stmt = $pdo->prepare("UPDATE facture SET invoice_signature = :signature, invoice_identifier = :identifier, invoice_registered_date = :date WHERE numero = :facture_id");

        // Create an associative array with the parameters
        $params = [
            'signature' => $invoice_signature,
            'identifier' => $identifier, // New parameter for invoice_identifier
            'date' => $date, // New parameter for invoice_registered_date
            'facture_id' => $facture_id // Ensure this variable is defined
        ];

        // Execute the statement with the parameters array
        if ($stmt->execute($params)) {
            if ($stmt->rowCount() > 0) {
                return [
                    'result' => 'ok',
                    'msg' => 'Successfully updated the invoice'
                ];
            } else {
                return [
                    'result' => 'error',
                    'msg' => 'No invoice found with the given ID or no changes made.',
                    'signature' => $_GET['invoice_signature'],
                    'facture_id' => $_GET['facture_id']
                ];
            }
        } else {
            // Log the error for debugging
            $errorInfo = $stmt->errorInfo();
            return [
                'result' => 'error',
                'msg' => 'Failed to update the invoice: ' . $errorInfo[2],
                'signature' => $_GET['invoice_signature'],
                'facture_id' => $_GET['facture_id']
            ];
        }
    }
    
    function validFacture($facture_id)
    {
    	$con = connection();
		$query = $con->prepare("UPDATE facture SET validate = 1 WHERE facture_id = :facture_id");
		$res = $query->execute(['facture_id'=>$facture_id]) or die(print_r($query->errorInfo()));
		return $res;
    }


    function getFactureId($client_parent) {
        $contract = new Contract();
        $facture_id = 2;
        // $facture_id = $contract->getFactureId_par_IdClient($client_parent)->fetch()['facture_id'];
        return [
            'result' => 'ok',
            'facture_id' => $facture_id 
        ];
    }
    function get_Max_factureId($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(facture_id) AS facture_id FROM facture WHERE ID_client = ?");
		$query->execute([$idclient]);
		return $query->fetch()['facture_id'];
	}







	function recupererAcountHistoryFacture($facture_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.numero,exchange_rate,exchange_currency,fixe_rate,show_rate,fac.monnaie,fac.tva,fac.tvci,fac.date_creation,fac.enable_discounts,fac.reduction,billing_date,cl.ID_client,nom_client,adresse,nif,billing_number,fs.montant,round(SUM(fs.montant_total)) AS montant_total,montant_tva,fs.rediction,startDate,endDate,mois_debut,mois_fin,annee,annee_fin,fs.quantite,nomService,fs.bande_passante,fs.billing_cycle FROM client cl,facture fac,facture_service fs,service se WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fac.ID_client AND se.ID_service = fs.ID_service AND fac.facture_id = ? GROUP BY fs.facture_id");
		$query->execute(array($facture_id)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	} 
	function getMontantFactureDunClientDuDebutAuneDate($billing_date,$idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant_total) AS montant,monnaie FROM facture fc,facture_service fs WHERE fc.facture_id = fs.facture_id AND billing_date <= :billing_date AND ID_client = :idclient AND fc.isDelete = 0 GROUP BY monnaie");
		$query->execute(['billing_date' => $billing_date,'idclient' => $idclient]); 
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getetatDunClientAuneDate($mois,$annee,$idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT historiquecoupure.action FROM historiquecoupure WHERE historiquecoupure.mois = :mois AND historiquecoupure.annee =:annee  AND historiquecoupure.ID_client = :idclient ");
		$query->execute(['mois' => $mois,'annee'=>$annee,'idclient' => $idclient]);
		return $query;
	}
	function getMontantFactureAnnuel($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant_total) AS montant FROM facture fc,facture_service fs WHERE fc.facture_id = fs.facture_id AND MONTH(date_creation) = :mois AND YEAR(date_creation) = :annee");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query;
	}
	function factureTotales($idclient) 
	{
		$con =connection();
		$query =$con->prepare("SELECT SUM(montant_total) AS montant,fc.monnaie FROM facture fc,facture_service fs,client WHERE fc.facture_id = fs.facture_id AND client.ID_client =fs.ID_client AND client.ID_client =:idclient");
		$query->execute(['idclient'=>$idclient]);
		return $query;
	}
	function payementtotal($idclient)
	{
		$con =connection();
		$query =$con->prepare("SELECT SUM(montant) AS montant,p.devise FROM paiement p,client c WHERE c.ID_client = p.ID_client AND p.ID_client =:idclient");
		$query->execute(['idclient'=>$idclient]);
		return $query;

	}
	function getPaiementAnnuel($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant FROM paiement WHERE  MONTH(datepaiement) = :mois AND YEAR(datepaiement) = :annee");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query;
	}
	function getMontantPayementDunClientDuDebutAuneDate($year_month,$idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant_converti) AS montant,exchange_currency FROM paiement WHERE EXTRACT(YEAR_MONTH FROM datepaiement) <= :year_month AND ID_client = :idclient AND isDelete = 0 GROUP BY exchange_currency");
		$query->execute(['year_month' => $year_month,'idclient' => $idclient]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getSommeTotaleFactureDunClient($idclient)
	{
		$con = connection();
//		$query = $con->prepare("SELECT SUM(montant_total) AS montant,monnaie FROM facture fc,facture_service fs WHERE fc.facture_id= fs.facture_id AND fc.ID_client = ? AND fc.type_facture = 0 AND fc.etat_facture = 'actif' AND fc.isDelete = 0 GROUP BY monnaie");
        
        $query = $con->prepare("SELECT fc.facture_id,exchange_rate,exchange_currency,round(SUM(montant_total)) AS montant,SUM(ott) AS ott,monnaie FROM facture fc,facture_service fs WHERE fc.facture_id= fs.facture_id AND fc.ID_client = ? AND fc.type_facture = 0 AND fc.etat_facture = 'actif' AND fc.isDelete = 0 GROUP BY fc.facture_id");
		$query->execute([$idclient]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getSommeTotalePayementDunClient($idclient)
	{
		$con = connection();
//		$query = $con->prepare("SELECT SUM(montant_converti) AS montant,exchange_currency FROM paiement WHERE ID_client = ? AND isDelete = 0 GROUP BY exchange_currency");
        
        $query = $con->prepare("SELECT montant_converti AS montant,exchange_currency,taux_change_courant AS exchange_rate FROM paiement WHERE ID_client = ? AND isDelete = 0");
		$query->execute([$idclient]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function recupererUnProformat($facture_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT pro.facture_id,pro.numero,pro.monnaie,exchange_currency,fixe_rate,pro.tva,pro.tvci,DATE_FORMAT(pro.date_creation,'%d/%m/%Y') AS date_creation,pro.enable_discounts,pro.reduction,next_billing_month,next_billing_year, nom_client,adresse,nif,assujettiTVA, cl.billing_number,telephone,show_rate,exchange_rate,billing_date FROM client cl,proformat pro WHERE cl.ID_client = pro.ID_client AND pro.facture_id = ?");
		$query->execute([$facture_id]) or die(print_r($query->errorInfo()));
		return $query;
	}
	function recupererFactures()
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.numero,exchange_rate,exchange_currency,fixe_rate,show_rate,fac.monnaie,fac.tva,fac.tvci,fac.date_creation,fac.enable_discounts,fac.reduction,billing_date,fac.sent,cl.ID_client,nom_client,adresse,nif,billing_number,fs.montant,SUM(fs.montant_total) AS montant_total,montant_tva,fs.rediction,startDate,endDate,mois_debut,mois_fin,annee,annee_fin,fs.quantite,nomService,fs.bande_passante,fs.billing_cycle FROM client cl,facture fac,facture_service fs,service se WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fac.ID_client AND se.ID_service = fs.ID_service AND fac.type_facture = 0 AND fac.isDelete = 0 GROUP BY fs.facture_id ORDER BY fac.date_creation DESC LIMIT 50");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function monthly_amount_to_be_collected()
	{
		$con = connection();
		$query = $con->prepare("SELECT id, invoices_amount, delinquent, total_solde, paid_amount, remains_to_be_collected,DATE_FORMAT(created_at,'%d-%m-%Y') AS created_at FROM monthly_amount_to_be_collected");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function monthly_amount_to_be_collected_by_id($repport_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT id,invoices_amount,delinquent,total_solde,paid_amount,remains_to_be_collected,DATE_FORMAT(created_at,'%d-%m-%Y') AS created_at FROM monthly_amount_to_be_collected WHERE id = ?");
		$query->execute([$repport_id]);
		return $query;
	}
    function get_Max_Billing_date_Dun_client($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(billing_date) AS billing_date FROM `facture` WHERE ID_client = ?");
		$query->execute([$idclient]);
		return $query->fetch()['billing_date'];
	}
    function get_Max_Next_Billing_date_Dun_client_From_Facture($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(next_billing_date) AS next_billing_date FROM `facture` WHERE ID_client = ?");
		$query->execute([$idclient]);
		return $query->fetch()['next_billing_date'];
	}
	function getMoisDuneFacture($facture_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT startDate,endDate,mois_debut,mois_fin,annee,annee_fin,quantite,billing_cycle FROM `facture_service` WHERE facture_id = ?");
		$query->execute([$facture_id]);
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function recupererProformats()
	{
		$con = connection();
		$query = $con->prepare("SELECT pro.facture_id,pro.numero,ps.ott,exchange_rate,exchange_currency,fixe_rate,show_rate,pro.monnaie,pro.tva,pro.tvci,pro.date_creation,pro.enable_discounts,pro.reduction,cl.ID_client,nom_client,adresse,nif,billing_number,type_client,cl.ID_localisation,telephone,mail,ps.montant,SUM(ps.montant_total) AS montant_total,montant_tva,startDate,endDate,mois_debut,mois_fin,annee,annee_fin,ps.quantite,nomService,ps.bande_passante,ps.billing_cycle FROM client cl,proformat pro,proformat_service ps,service se WHERE pro.facture_id = ps.facture_id AND cl.ID_client = pro.ID_client AND se.ID_service = ps.ID_service AND pro.isDelete = 0 GROUP BY ps.facture_id ORDER BY pro.date_creation DESC LIMIT 100");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function recupererServicesDunProformat($facture_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT se.ID_service,ott,nomService,ps.id AS idFs,ps.bande_passante,ps.montant,montant_total,montant_tva,montant_tvci,startDate,endDate,mois_debut,mois_fin, 	annee,annee_fin,pro.monnaie,quantite,ps.description,ps.billing_cycle FROM service se,proformat pro,proformat_service ps WHERE se.ID_service = ps.ID_service AND pro.facture_id = ps.facture_id AND pro.facture_id = ?");
		$query->execute(array($facture_id)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreProformats($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT pro.facture_id,pro.numero,exchange_rate,exchange_currency,fixe_rate,show_rate,pro.monnaie,pro.tva,pro.tvci,pro.date_creation,pro.enable_discounts,pro.reduction,cl.ID_client,nom_client,adresse,nif,billing_number,ID_localisation,ps.montant,SUM(ps.montant_total) AS montant_total,montant_tva,startDate,endDate,mois_debut,mois_fin,annee,annee_fin,ps.quantite,nomService,ps.bande_passante,ps.billing_cycle FROM client cl,proformat pro,proformat_service ps,service se WHERE pro.facture_id = ps.facture_id AND cl.ID_client = pro.ID_client AND se.ID_service = ps.ID_service AND pro.isDelete = 0 $condition GROUP BY ps.facture_id ORDER BY pro.date_creation DESC");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function get_nombre_proformat_dans_une_annee($annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb_facture FROM proformat WHERE YEAR(date_creation) = ?");
		$query->execute([$annee]);
		return $query->fetch()['nb_facture'];
	}
	function filtreFactures($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.numero,exchange_rate,exchange_currency,fixe_rate,show_rate,fac.monnaie,fac.tva,fac.tvci,fac.date_creation,fac.enable_discounts,fac.reduction,billing_date,fac.sent,cl.ID_client,nom_client,adresse,nif,billing_number,fs.montant,SUM(fs.montant_total) AS montant_total,montant_tva,fs.rediction,SUM(ott) AS ott,startDate,endDate,mois_debut,mois_fin,annee,annee_fin,fs.quantite,nomService,fs.bande_passante,fs.billing_cycle FROM client cl,facture fac,facture_service fs,service se WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fac.ID_client AND cl.etat != 'terminer' AND se.ID_service = fs.ID_service AND fac.type_facture = 0 AND fac.isDelete = 0 AND cl.isDelete = 0 $condition GROUP BY fs.facture_id ORDER BY billing_number");
        //$query = $con->prepare("SELECT billing_number,Nom_client,next_billing_date,l.nom_localisation,cl.etat,solde FROM client cl,contract co,localisation l WHERE cl.ID_client = co.ID_client AND cl.ID_localisation = l.ID_localisation AND cl.type_client = 'paying' AND cl.isDelete = 0 AND co.isDelete = 0 ");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getFacturesDunMois($mois_debut,$annee_debut)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,exchange_rate,show_rate,fac.monnaie,fac.tva,fac.date_creation,cl.ID_client,nom_client,adresse,nif,SUM(fs.montant_total) AS montant,fs.rediction,startDate,endDate,mois_debut,mois_fin,annee,annee_fin,fs.quantite,nomService,si.bandepassante,fs.billing_cycle FROM client cl,facture fac,facture_service fs,service se,serviceinclucontract si WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND se.ID_service = fs.ID_service AND si.ID_client = cl.ID_client AND mois_debut =:mois AND annee =:annee GROUP BY fs.facture_id");
		$query->execute(array('mois' => $mois_debut,'annee' => $annee_debut)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function raportFacturePayer($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,taux_change_courant AS exchange_rate,fac.show_rate,devise AS monnaie,fac.tva,fac.date_creation,cl.ID_client,nom_client,adresse,nif,p.montant ,fs.rediction,fs.startDate,fs.endDate,mois_debut,mois_fin,annee,annee_fin,fs.quantite,billing_cycle,fs.description,nomService,si.bandepassante FROM client cl,facture fac,facture_service fs,facture_payer fp,paiement p,service se,serviceinclucontract si,contract co WHERE fac.facture_id = fs.facture_id AND fac.facture_id = fp.facture_id AND fp.ID_paiement = p.ID_paiement AND cl.ID_client = fs.ID_client AND se.ID_service = fs.ID_service AND si.ID_client = cl.ID_client $condition GROUP BY fs.facture_id");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function raportFactureImpayer($condition)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,exchange_rate,fac.show_rate,fac.monnaie,fac.tva,fac.date_creation,cl.ID_client,nom_client,adresse,nif,montant_total AS montant,montant_tva,fs.rediction,mois_debut,mois_fin,annee,annee_fin,fs.quantite,fs.description,nomService,si.bandepassante FROM client cl,facture fac,facture_service fs,service se,serviceinclucontract si,contract co WHERE fac.facture_id = fs.facture_id /*AND cl.ID_client = fs.ID_client*/ AND se.ID_service = fs.ID_service AND si.ID_client = cl.ID_client $condition AND fs.facture_id NOT IN (SELECT facture_id FROM facture_payer) GROUP BY fs.facture_id");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function genererListeFactureNoPayer($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.monnaie,fac.tva,fac.date_creation,cl.ID_client,nom_client,adresse,nif,SUM(fs.montant) AS montant,fs.rediction,mois_debut,fs.quantite,nomService,si.bandepassante FROM client cl,facture fac,facture_service fs,service se,serviceinclucontract si WHERE fac.facture_id = fs.facture_id AND /*cl.ID_client = fs.ID_client AND*/ se.ID_service = fs.ID_service AND se.ID_service = si.ID_service AND si.ID_client = cl.ID_client AND fac.facture_id NOT IN (SELECT facture_id FROM facture_payer) AND mois_debut = :mois AND annee = :annee GROUP BY si.ID_contract");
		$query->execute(array('mois' => $mois,'annee' => $annee)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function liste_Client_A_couper()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_client,nom_client 
		FROM client 
		WHERE type_client = 'paying' AND etat = 'actif' AND ID_client NOT IN (SELECT ID_client FROM coupure)");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	/*function genererClientAderoguer($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,nom_client,fac.facture_id,SUM(fs.montant) AS montant,fac.monnaie FROM client cl,facture fac,facture_service fs WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND  fs.mois_debut = ? AND fs.annee = ? AND fac.facture_id NOT IN (SELECT facture_id FROM facture_payer) AND etat_facture = 'actif' GROUP BY fac.facture_id");
		$query->execute(array($mois,$annee)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}*/
	function saveCoupure($action,$observation,$idclient,$montant,$monnaie,$mois,$annee,$date_creation,$motif,$type_client)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO coupure(ID_client,montant_du,monnaie,mois,annee,action,observation,motif,date_creation,typeclient) VALUES(:idclient,:montant,:monnaie,:mois,:annee,:action,:observation,:motif,:date_creation,:typeclient)");
		$res = $query->execute(array('idclient' =>$idclient,'montant' =>$montant,'monnaie' =>$monnaie,'mois' =>$mois,'annee' =>$annee,'action' =>$action,'observation' =>$observation,'motif'=>$motif,'date_creation' => $date_creation,'typeclient' => $type_client)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getCoupureDetteCreerAuneDate($date_creation)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM coupure WHERE date_creation =:date_creation AND motif = 'dette'");
		$query->execute(['date_creation' => $date_creation]) or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function updateCoupure($action,$observation,$id)
	{
		$con = connection();
		$query = $con->prepare("UPDATE cutoff_details SET action = :action,comment =:observation WHERE id =:id");
		$res = $query->execute(array('action' => $action,'observation' => $observation,'id' => $id)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deleteCoupureAction($coupure_id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM cutoff_details WHERE id =?");
		$res = $query->execute([$coupure_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function activerClient($customer_id,$updated_at)
	{
		$con = connection();
		$query = $con->prepare("UPDATE cutoff_details SET action = 'activer',updated_at = :updated_at WHERE customer_id =:customer_id AND action = 'couper'");
		$res = $query->execute(['updated_at'=>$updated_at,'customer_id'=>$customer_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function setHistoriqueCoupure($coupure_id,$action,$observation,$idclient,$montant,$monnaie,$mois,$annee,$date_creation,$motif)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO historiquecoupure(coupure_id,ID_client,montant_du,monnaie,mois,annee,action,observation,motif,date_creation) VALUES(:coupure_id,:idclient,:montant,:monnaie,:mois,:annee,:action,:observation,:motif,:date_creation)");
		$res = $query->execute(array('coupure_id'=>$coupure_id,'idclient' =>$idclient,'montant' =>$montant,'monnaie' =>$monnaie,'mois' =>$mois,'annee' =>$annee,'action' =>$action,'observation' =>$observation,'motif'=>$motif,'date_creation' => $date_creation)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getNbClientFromCoupure()
	{
		$con = connection();
		$query = $con->prepare("SELECT cutoffs.id,COUNT(cutoff_details.cutoff_id) AS nb_client,cutoffs.date,cutoffs.confirmed FROM cutoffs,cutoff_details WHERE cutoffs.id = cutoff_details.cutoff_id GROUP BY cutoff_details.cutoff_id ORDER BY cutoffs.id DESC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function get_max_cutoff_id()
	{
		$con = connection();
		$query = $con->prepare("SELECT max(id) AS id FROM cutoffs");
		$query->execute();
		return $query->fetch()['id'];
	}
	function setCutoff($date,$confirmed)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO cutoffs(date,created_at,updated_at,confirmed) VALUES(:date_coupure,:created_at,:updated_at,:confirmed)");
		$res = $query->execute(['date_coupure'=>$date,'created_at'=>$date,'updated_at'=>$date,'confirmed'=>$confirmed]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function setCutoff_detail($cutoff_id,$customer_id,$owed_amount,$action,$currency,$comment)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO cutoff_details(cutoff_id,customer_id,owed_amount,action,currency,comment) VALUES(:cutoff_id,:customer_id,:owed_amount,:action,:currency,:comment)");
		$res = $query->execute(['cutoff_id' => $cutoff_id,'customer_id' => $customer_id,'owed_amount' => $owed_amount,'action' => $action,'currency' => $currency,'comment' => $comment]) or die(print_r($query->errorInfo()));
		return $res;
	}
    function update_cutoff_list($date_coupure,$confirmed,$cutoff_id)
	{
		$con = connection();
		$query = $con->prepare("UPDATE cutoffs SET date=:date_coupure,created_at=:created_at,updated_at=:updated_at,confirmed=:confirmed WHERE id=:cutoff_id");
		$res = $query->execute(['date_coupure'=>$date_coupure,'created_at'=>$date_coupure,'updated_at'=>$date_coupure,'confirmed'=>$confirmed,'cutoff_id'=>$cutoff_id]);
		return $res;
	}
    function delete_cutoff_list($cutoff_id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM cutoffs WHERE id =?");
		$res = $query->execute([$cutoff_id]);
		return $res;
	}

//***************************************************************************** ***
	function getmontant_facture_impayee_dun_mois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant_total) AS montant_total,SUM(montant_tva) AS montant_tva,SUM(reste) AS reste,monnaie FROM facture_service fs,facture fc WHERE fs.facture_id = fc.facture_id AND mois_debut = ? AND annee = ? AND fc.facture_id NOT IN (SELECT facture_id FROM facture_payer) GROUP BY fc.monnaie");
		
		$query->execute(array($mois,$annee)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getmontant_payer_dans_un_mois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant) AS montant,devise FROM paiement WHERE MONTH(datepaiement) = :mois AND YEAR(datepaiement) = :annee AND isDelete = 0 GROUP BY devise");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		/*$montant = 0;
		while ($data = $query->fetchObject()) 
		{
			$montant = $data->montant;
		}*/
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getmontant_facture_payee_dun_mois($billing_date)
	{
		$con = connection();
		$query = $con->prepare("SELECT p.montant,p.taux_change_courant,devise,p.montant_converti,p.exchange_currency FROM facture_payer fp,facture fc,paiement p WHERE fc.facture_id = fp.facture_id AND p.ID_paiement = fp.ID_paiement AND fc.billing_date = ?");
		$query->execute(array($billing_date)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function getmontant_facture_payee($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT p.montant,p.taux_change_courant,devise FROM facture_service fs,facture_payer fp,facture fc,paiement p WHERE fc.facture_id = fs.facture_id AND fc.facture_id = fp.facture_id AND p.ID_paiement = fp.ID_paiement AND mois_debut = ? AND annee = ?");
		$query->execute(array($mois,$annee)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
	function getfacture_total($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant_total) AS montant FROM facture_service fs,facture fc WHERE fs.facture_id = fc.facture_id AND mois_debut = ? AND annee = ? GROUP BY fc.facture_id");
		
		$query->execute(array($mois,$annee)) or die(print_r($query->errorInfo()));
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
	function getfacture_total_dun_mois($billing_date/*$mois,$annee*/)
	{
		$con = connection();
//		$query = $con->prepare("SELECT SUM(montant_total) AS montant,monnaie FROM facture_service fs,facture fc WHERE fs.facture_id = fc.facture_id AND mois_debut = ? AND annee = ? AND isDelete = 0 GROUP BY fc.monnaie");
        $query = $con->prepare("SELECT fc.facture_id,exchange_rate,exchange_currency,SUM(montant_total) AS montant,SUM(ott) AS ott,monnaie FROM facture fc,facture_service fs WHERE fc.facture_id= fs.facture_id AND fc.billing_date = ? AND fc.type_facture = 0 AND fc.etat_facture = 'actif' AND fc.isDelete = 0 GROUP BY fc.facture_id");
		
		$query->execute(array($billing_date)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function getMontantFactureEnDerogation()
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(bi.montant_total) AS montant,bi.monnaie FROM balanceinitiale bi,coupure cp WHERE bi.ID_client = cp.ID_client AND cp.motif = 'derogation' GROUP BY cp.ID_client");
		$query->execute() or die(print_r($query->errorInfo()));
		/*$montant = 0;
		while ($data = $query->fetchObject()) 
		{
			if ($data->monnaie == 'USD') 
			{
				$montant +=$data->montant*$data->exchange_rate;
			}
			else
			$montant +=$data->montant;
		}*
		return $query;
	}*/
	function getMontantFactureEnDerogationDunMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant_du) AS montant,monnaie FROM coupure WHERE motif = 'derogation' AND mois = :mois AND annee = :annee");
		$query->execute(['mois' => $mois,'annee' => $annee]) or die(print_r($query->errorInfo()));
		/*$montant = 0;
		while ($data = $query->fetchObject()) 
		{
			if ($data->monnaie == 'USD') 
			{
				$montant +=$data->montant*$data->exchange_rate;
			}
			else
			$montant +=$data->montant;
		}*/
		return $query;
	}
	function getClientEnDerrogationCreerAunMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client FROM client cl,coupure cp WHERE cl.ID_client = cp.ID_client AND mois =:mois AND annee =:annee AND action = 'recouvrer'");
		$query->execute(['mois'=>$mois,'annee'=>$annee]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getClientEnCoupureCreerAunMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client FROM client cl,coupure cp WHERE cl.ID_client = cp.ID_client AND mois =:mois AND annee =:annee AND action = 'couper'");
		$query->execute(['mois'=>$mois,'annee'=>$annee]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	// Montant manque a gagner(montant mensuel de clients en coupure)
	function getMontantCoupureEncours()
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(si.montant) AS montant,co.monnaie FROM client cl,contract co,serviceinclucontract si WHERE co.ID_contract = si.ID_contract AND cl.ID_client = co.ID_client AND cl.etat = 'coupure' GROUP BY co.monnaie");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	// Le montant de tous les coupure d'un mois
	function   getMontantCoupureDuMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT montant_du,monnaie FROM client cl,coupure cp WHERE cl.ID_client = cp.ID_client AND type_client = 'paying' AND cl.etat = 'coupure' AND cp.mois=:mois AND cp.annee =:annee");
		$query->execute(['mois' => $mois,'annee' =>$annee]) or die(print_r($query->errorInfo()));
		$montant = 0;
		while ($data = $query->fetchObject()) 
		{
			/*if ($data->monnaie == 'USD') 
			{
				$montant +=$data->montant*$data->exchange_rate;
			}
			else*/
			$montant +=$data->montant_du;
		}
		return $montant;
	}
	/*function getMontantDetteClientEncoupure()
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(bi.montant_total) AS montant,bi.monnaie FROM balanceinitiale bi,coupure cp WHERE bi.ID_client = cp.ID_client AND action = 'couper'");
		$query->execute() or die(print_r($query->errorInfo()));
		/*$montant = 0;
		while ($data = $query->fetchObject()) 
		{
			if ($data->monnaie == 'USD') 
			{
				$montant +=$data->montant*$data->exchange_rate;
			}
			else
			$montant +=$data->montant;
		}*
		return $query;
	}*/
	function getSoldeactuel($annee,$mois)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(cp.montant_du) AS montant,cp.monnaie FROM coupure cp WHERE cp.annee=? AND cp.mois=?");
		$query->execute(array($annee,$mois)) or die(print_r($query->errorInfo()));
		return $query;
	}
	/*function getDetteTotal()
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(solde) AS montant,monnaie FROM balanceinitiale WHERE solde > 0");
		$query->execute() or die(print_r($query->errorInfo()));
		return $query;
	}*/
	function verifierUnMoisDebutExiste($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id FROM facture fac,facture_service fs WHERE fac.facture_id = fs.facture_id AND mois_debut =:mois_debut AND annee =:annee_debut AND type_facture = 0");
		$query->execute(['mois_debut' =>$mois,'annee_debut' => $annee]) or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		if (!empty($res)) return true;
		else return false;
	}
/*******************************************************************************************************/


	function getTotalClientParAction($action,$id)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(cutoff_id) nb_client FROM cutoff_details WHERE action = :action AND cutoff_id =:cutoff_id");
		$query->execute(array('action' => $action,'cutoff_id' =>$id)) or die(print_r($query->errorInfo()));
		return $query;
	}
    function get_Clients_by_cutoff_id($cutoff_id,$action)
	{
		$con = connection();
		$query = $con->prepare("SELECT customer_id FROM cutoff_details WHERE action = :action AND cutoff_id =:cutoff_id");
		$query->execute(array('action'=>$action,'cutoff_id' =>$cutoff_id)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function detailCoupure($action,$cutoff_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT id,cl.ID_client,billing_number,nom_client,owed_amount,currency,action,comment FROM cutoff_details cd,client cl WHERE cd.customer_id = cl.ID_client AND action = :action AND cutoff_id =:cutoff_id");
		$query->execute(array('action' => $action,'cutoff_id' => $cutoff_id)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function recupererFacturesDunClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.numero,exchange_rate,exchange_currency,fixe_rate,show_rate,fac.monnaie,fac.tva,fac.date_creation,fac.enable_discounts,fac.reduction,billing_date,cl.ID_client,nom_client,adresse,nif,billing_number,fs.montant,SUM(fs.montant_total) AS montant_total,montant_tva,fs.rediction,startDate,endDate,mois_debut,mois_fin,annee,annee_fin,fs.quantite,nomService,fs.bande_passante,fs.billing_cycle FROM client cl,facture fac,facture_service fs,service se WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fac.ID_client AND se.ID_service = fs.ID_service AND cl.ID_client =? GROUP BY fs.facture_id ORDER BY fac.numero ASC");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function recuperFacturePayerDunClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id ,fac.monnaie,fac.tva,fac.date_creation,nom_client,adresse,nif,fs.montant,fs.rediction,fs.startDate,fs.endDate,annee,annee_fin,billing_cycle,mois_debut,fs.quantite,nomService,si.bandepassante FROM client cl,facture fac,facture_service fs,facture_payer fp,service se,serviceinclucontract si WHERE fac.facture_id = fs.facture_id AND fac.facture_id = fp.facture_id AND cl.ID_client = fs.ID_client AND se.ID_service = fs.ID_service AND se.ID_service = si.ID_service AND si.ID_client = cl.ID_client AND si.ID_client = ?");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function recupererToutfacture_paye_dun_mois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.monnaie,fac.tva,fac.date_creation,cl.ID_client,nom_client,adresse,nif,SUM(fs.montant_total) AS montant_total,fs.rediction,mois_debut,mois_fin,annee,annee_fin,fs.quantite,nomService,si.bandepassante,billing_cycle FROM client cl,facture fac,facture_service fs,facture_payer fp,service se,serviceinclucontract si WHERE fac.facture_id = fs.facture_id AND fac.facture_id = fp.facture_id AND cl.ID_client = fs.ID_client AND se.ID_service = fs.ID_service AND si.ID_client = cl.ID_client AND fs.mois_debut = ? AND fs.annee = ? GROUP BY fac.facture_id");
		$query->execute(array($mois,$annee)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function recuperFactureImpayerDunClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id ,fac.monnaie,fac.tva,fac.date_creation,nom_client,adresse,nif,fs.montant,fs.montant_total,fs.rediction,fs.startDate,fs.endDate,billing_cycle,mois_debut,mois_fin,annee,annee_fin,fs.quantite,nomService,si.bandepassante FROM client cl,facture fac,facture_service fs,service se,serviceinclucontract si WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND se.ID_service = fs.ID_service AND se.ID_service = si.ID_service AND si.ID_client = cl.ID_client AND si.ID_client = ? AND fac.facture_id NOT IN (SELECT facture_id FROM facture_payer)");
		$query->execute(array($idclient)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function FactureImpayers($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id ,fac.monnaie,fac.tva,fac.date_creation,cl.ID_client,nom_client,adresse,nif,SUM(fs.montant_total) AS montant_total,fs.rediction,mois_debut,annee,mois_fin,annee_fin,fs.quantite,nomService,si.bandepassante,billing_cycle FROM client cl,facture fac,facture_service fs,service se,serviceinclucontract si WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND se.ID_service = fs.ID_service AND si.ID_client = cl.ID_client AND  fs.mois_debut = ? AND fs.annee = ? AND fac.facture_id NOT IN (SELECT facture_id FROM facture_payer) GROUP BY fac.facture_id");
		$query->execute(array($mois,$annee)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function getNombreServiceDunContrat($idcontract)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nbservice FROM serviceinclucontract WHERE ID_contract = ?");
		$query->execute([$idcontract]);
		return $query;
	}
	function getServiceToIncludeOnFacture($idcontract)
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,nom_client,se.ID_service,nomService,si.montant,co.monnaie,prixTva FROM client cl,service se,contract co,serviceinclucontract si WHERE cl.ID_client = si.ID_client AND co.ID_contract = si.ID_contract AND se.ID_service = si.ID_service  AND type_client = 'paying' AND co.ID_contract = ?");
		$query->execute(array($idcontract)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function getDataToPrintOnFactureEnMasse($mode,$next_billing_date)
	{
		$con = connection();
		/*$query = $con->prepare("SELECT DISTINCT(cl.ID_client),billing_number,si.montant,si.bandepassante,co.monnaie,co.monnaie_facture,co.taux,co.facturation,co.tva,s.ID_service FROM client cl,serviceinclucontract si,service s,contract co,facture fac,facture_service fs WHERE si.ID_contract = co.ID_contract AND si.ID_service = s.ID_service AND co.ID_client = cl.ID_client AND co.etat = 'activer' AND cl.etat = 'actif' AND fac.facture_id = fs.facture_id AND fs.ID_client = cl.ID_client AND next_billing_month = :mois AND next_billing_year = :annee  GROUP BY cl.ID_client");*/
		$query = $con->prepare("SELECT DISTINCT(cl.ID_client),billing_number,assujettiTVA,langue,ID_contract,co.monnaie,co.monnaie_facture,co.taux,co.facturation,co.tva,co.enable_discounts FROM client cl,contract co WHERE co.ID_client = cl.ID_client AND co.etat = 'activer' AND cl.etat = 'actif' AND mode = ? AND (next_billing_date <=? OR next_billing_date IS NULL) AND cl.isDelete = 0 AND co.isDelete = 0");
		$query->execute([$mode,$next_billing_date]);
        return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function incomeingInvoices($next_billing_date)
	{
		$con = connection();
		$query = $con->prepare("SELECT DISTINCT(cl.ID_client),billing_number,nom_client,assujettiTVA,co.ID_contract,co.monnaie,co.monnaie_facture,co.taux,co.facturation,co.tva,co.enable_discounts,(SUM(si.montant) * quantite) + ((SUM(si.montant) * quantite) * tva /100) as montant,monnaie FROM client cl,contract co ,serviceinclucontract si WHERE co.ID_client = cl.ID_client AND co.etat = 'activer' AND cl.etat = 'actif' AND (next_billing_date <= ? OR next_billing_date IS NULL) AND si.ID_contract = co.ID_contract AND si.status = 0 AND cl.isDelete = 0 AND co.isDelete = 0 GROUP BY si.ID_contract");
		$query->execute([$next_billing_date]) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	/*function getFactureId_par_numero($numero)
	{
		$con = connection();
		$query = $con->prepare("SELECT facture_id FROM facture WHERE numero = ?");
		$query->execute([$numero]);
		return $query;
	}*/
    function getFactureId_par_IdClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(facture_id) AS facture_id FROM facture WHERE ID_client = ? AND isDelete = 0");
		$query->execute([$idclient]);
		return $query;
	}
    function getProformatId_par_numero($numero)
	{
		$con = connection();
		$query = $con->prepare("SELECT facture_id FROM proformat WHERE numero = ?");
		$query->execute([$numero]);
		return $query;
	}
	function getClientEnfantToPrintOnFactureEnMasse($idcontract)
	{
		$con = connection();
		$query = $con->prepare("SELECT se.ID_service,se.nomService,si.montant*quantite AS montant,bandepassante,nom,adress,show_on_facture FROM service se,serviceinclucontract si,contract co WHERE si.ID_service = se.ID_service AND co.ID_contract = si.ID_contract AND si.status = 0 AND si.montant > 0 AND si.ID_contract = ?");
		$query->execute(array($idcontract));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getMontantTotalDuneFacture($facture_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant_total) AS montant,cl.ID_client FROM facture fc,facture_service fs,client cl WHERE fc.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND fc.facture_id = ? GROUP BY fs.facture_id");
		$query->execute([$facture_id]);
		return $query;
	}
    function getInvoicesToDelete($billing_date,$creation_mode)
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,co.ID_contract,fc.facture_id FROM facture fc,client cl,contract co WHERE cl.ID_client = fc.ID_client AND cl.ID_client = co.ID_client AND fc.billing_date = :billing_date AND fc.creation_mode = :creation_mode");
		$query->execute(['billing_date' => $billing_date,'creation_mode' => $creation_mode]);
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function deleteFacutre($facture_id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM facture WHERE facture_id = ?");
		//$query = $con->prepare("UPDATE facture SET isDelete = 1 WHERE facture_id = ?");
		$res = $query->execute(array($facture_id)) or die(print_r($query->errorInfo()));
		return $res;;
	}
	function updateProformat($facture_id,$show_rate,$enable_discount,$reduction,$monnaie,$tva,$tvci,$date_creation,$taux,$fixe_rate,$exchange_currency,$next_billing_month,$next_billing_year,$billing_date)
	{
		$con = connection();
		$query = $con->prepare("UPDATE proformat SET show_rate = :show_rate,monnaie = :monnaie,tva = :tva,tvci=:tvci,exchange_rate =:taux,exchange_currency=:exchange_currency,fixe_rate=:fixe_rate,date_creation = :date_creation,next_billing_month =:next_billing_month,next_billing_year =:next_billing_year,billing_date =:billing_date,enable_discounts=:enable_discount,reduction=:reduction WHERE facture_id = :facture_id");
		$res = $query->execute(array('show_rate' => $show_rate,'monnaie' => $monnaie,'tva' => $tva,'tvci' => $tvci,'taux' => $taux,'exchange_currency'=>$exchange_currency,'fixe_rate'=>$fixe_rate,'date_creation' => $date_creation,'facture_id'=>$facture_id,'next_billing_month' => $next_billing_month,'next_billing_year' => $next_billing_year,'billing_date'=>$billing_date,'enable_discount'=>$enable_discount,'reduction'=>$reduction)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deleteProformat($facture_id)
	{
		$con = connection();
		//$query = $con->prepare("DELETE FROM proformat WHERE facture_id = ?");
		$query = $con->prepare("UPDATE proformat SET isDelete = 1 WHERE facture_id = ?");
		$res = $query->execute(array($facture_id)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function recupereFactureCreerAuneDate($date_creation)
	{
		$con = connection();
		$query = $con->prepare("SELECT fac.facture_id,fac.monnaie,fac.tva,fac.date_creation,nom_client,adresse,nif,assujettiTVA,fs.montant,fs.rediction,mois_debut,fs.quantite,annee,nomService,si.bandepassante FROM client cl,facture fac,facture_service fs,service se,serviceinclucontract si WHERE fac.facture_id = fs.facture_id AND cl.ID_client = fs.ID_client AND si.ID_client = fs.ID_client AND se.ID_service = si.ID_service AND fac.date_creation = ? ORDER BY fac.facture_id");
		$query->execute(array($date_creation)) or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}

	function recupereIdfactureCreerAuneDate($mois_debut,$annee_debut,$mode='impression')
	{
		$con = connection();
		$query = $con->prepare("SELECT 
    cl.ID_client,
    billing_number,
    si.bandepassante,
    s.nomService,
    nom_client,
    adresse,
    nif,
    assujettiTVA,
    telephone,
    fac.facture_id,
    fac.numero,
    fac.date_creation,
    fac.show_rate,
    exchange_rate,
    exchange_currency,
    co.monnaie,
    tvci
FROM 
    facture fac
    INNER JOIN facture_service fs ON fac.facture_id = fs.facture_id
    INNER JOIN client cl ON fac.ID_client = cl.ID_client
    INNER JOIN contract co ON cl.ID_client = co.ID_client
    INNER JOIN serviceinclucontract si ON co.ID_contract = si.ID_contract
    INNER JOIN service s ON si.ID_service = s.ID_service
    INNER JOIN profil_articletocontract pa ON co.ID_contract = pa.ID_contract
WHERE 
    creation_mode = :mode 
    AND type_facture = 0 
    AND fs.mois_debut = :mois_debut 
    AND annee = :annee_debut
    AND co.isDelete = 0
GROUP BY 
    fac.facture_id 
ORDER BY 
    billing_number
");
		$query->execute(array('mode'=>$mode,'mois_debut'=>$mois_debut,'annee_debut'=>$annee_debut)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function recupereIdfactureToSendOnMail($billing_date)
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,billing_number,nom_client,adresse,nif,assujettiTVA,telephone,fac.facture_id,fac.numero,DATE_FORMAT(fac.date_creation,'%d/%m/%Y') AS date_creation,show_rate,exchange_rate,tvci,mail FROM client cl,facture fac WHERE cl.ID_client = fac.ID_client AND fac.creation_mode = 'mail' AND cl.mail<> '' AND fac.billing_date = :billing_date");
		$query->execute(array('billing_date' => $billing_date)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function recupererServicesDunFacture($facture_id)
	{
		$con = connection();
		$query = $con->prepare("SELECT cl.ID_client,nom_client,se.ID_service,nomService,fs.id AS idFs,fs.bande_passante,fs.montant,startDate,endDate,fac.monnaie,quantite,fs.rediction,fs.description,fs.billing_cycle FROM client cl,service se,facture fac,facture_service fs WHERE cl.ID_client = fac.ID_client AND se.ID_service = fs.ID_service AND fac.facture_id = fs.facture_id AND fac.facture_id = ?");
		$query->execute(array($facture_id)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
	function getFactureNonPayerDunClient($idclient)
	{
		$con = connection();
		//$query = $con->prepare("SELECT fac.facture_id,fac.numero,SUM(fs.montant_total) AS montant,monnaie,exchange_rate,reste,SUM(fs.montant_tva) AS montant_tva,mois_debut,annee FROM facture fac,facture_service fs,client cl WHERE cl.ID_client = fac.ID_client AND fac.facture_id = fs.facture_id AND cl.ID_client = ? AND fac.facture_id NOT IN (SELECT facture_id FROM facture_payer) GROUP BY fac.facture_id ORDER BY billing_date DESC");
		$query = $con->prepare("SELECT fac.facture_id,fac.numero,SUM(fs.montant_total) AS montant,monnaie,fac.exchange_rate,fac.reste,SUM(fs.montant_tva) AS montant_tva,mois_debut,annee,billing_date FROM facture fac,facture_service fs,client cl WHERE cl.ID_client = fac.ID_client AND fac.facture_id = fs.facture_id AND cl.ID_client = ? AND fac.facture_id NOT IN (SELECT facture_id FROM facture_payer) GROUP BY fac.facture_id 
			UNION ALL SELECT fac.facture_id,fac.numero,SUM(fs.montant_total) AS montant,monnaie,fac.exchange_rate,fac.reste,SUM(fs.montant_tva) AS montant_tva,mois_debut,annee,billing_date FROM facture fac,facture_service fs,client cl,paiement p,facture_payer fp WHERE cl.ID_client = fac.ID_client AND fac.facture_id = fs.facture_id AND fac.facture_id = fp.facture_id AND fp.ID_paiement = p.ID_paiement AND fac.reste > 0 AND cl.ID_client = ? GROUP BY fac.facture_id");
		$query->execute(array($idclient,$idclient)) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}


	/*********************************
	* BALACE INITIALE 
	*
	**********************************/


	function creerBallanceInitiale($idclient,$date_creation,$montant,$monnaie,$description)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO balanceinitiale(ID_client,montant,monnaie,description,date_creer) VALUES(:idclient,:montant,:monnaie,:description,:date_creer)");
		$query->execute(array('idclient' => $idclient,'montant' => $montant,'monnaie' => $monnaie,'description' => $description,'date_creer' => $date_creation));
		$error = $query->errorInfo();
		return $error;
	}
	function getMaxIdBalanceInitiale()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(id) AS id FROM balanceinitiale");
		$query->execute();
		return $query;
	}
	function getBalanceInitiales()
	{
		$con = connection();
		$query = $con->prepare("SELECT id,cl.ID_client,billing_number,nom_client,montant,monnaie,description,date_creer FROM client cl,balanceinitiale b WHERE cl.ID_client = b.ID_client AND b.isDelete = 0");
		$query->execute();
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getBalanceInitiale($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT id,cl.ID_client,nom_client,montant,monnaie,description,date_creer FROM client cl,balanceinitiale b WHERE cl.ID_client = b.ID_client AND b.ID_client = ? AND b.isDelete = 0");
		$query->execute([$idclient]);
		return $query;
	}
	function getmontaTotalBalanceInitiale($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT solde FROM balanceinitiale WHERE ID_client =?");
		$query->execute([$idclient]) or die(print_r($errorInfo()));
		return $query;
	}
	function augmanterBalanceInitiale($idclient,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE balanceinitiale SET solde = solde + :solde WHERE ID_client = :idclient");
		$res = $query->execute(['idclient' => $idclient,'solde' => $montant]) or die(print_r($query->errorInfo()));
		return $res;
	}
	/*function augmenterSolde($idclient,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE balanceinitiale SET solde = solde + :solde WHERE ID_client = :idclient");
		$res = $query->execute(['solde' => $montant,'idclient' => $idclient]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function diminuerSolde($idclient,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE balanceinitiale SET solde = solde - :solde WHERE ID_client = :idclient");
		$res = $query->execute(['solde' => $montant,'idclient' => $idclient]) or die(print_r($query->errorInfo()));
		return $res;
	}*/
	function diminuerBalanceInitiale($idclient,$montant)
	{
		$con = connection();
		$query = $con->prepare("UPDATE balanceinitiale SET montant_total = montant_total - :montant_total WHERE ID_client = :idclient");
		$res = $query->execute(['idclient' => $idclient,'montant_total' => $montant]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function augmenterBalanceAccountHistory($Idfrom,$balance)
	{
		$con = connection();
		$query = $con->prepare("UPDATE account_history SET balance = balance+:balance WHERE Idfrom = :Idfrom");
		$res = $query->execute(['balance' => $balance,'Idfrom' => $Idfrom]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function augmenterSoldeFactureAccountHistory($idfrom,$solde)
	{
		$con = connection();
		$query = $con->prepare("UPDATE account_history SET solde = solde + :solde WHERE Idfrom = :idfrom");
		$res = $query->execute(['solde' => $solde,'idfrom' => $idfrom]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function diminuerBalanceAccountHistory($Idfrom,$balance)
	{
		$con = connection();
		$query = $con->prepare("UPDATE account_history SET balance = balance-:balance WHERE Idfrom = :Idfrom");
		$res = $query->execute(['balance' => $balance,'Idfrom' => $Idfrom]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateBallanceInitiale($id,$montant,$monnaie,$datebalance,$description)
	{
		$con = connection();
		$query = $con->prepare("UPDATE balanceinitiale SET montant = :montant,monnaie =:monnaie,description =:description,date_creer =:datebalance WHERE id =:id");
		$res = $query->execute(array('montant' => $montant,'monnaie' => $monnaie,'description' => $description,'datebalance'=>$datebalance,'id' => $id)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deleteBallanceInitiale($id)
	{
		$con = connection();
		//$query = $con->prepare("DELETE FROM balanceinitiale WHERE id =?");
		$query = $con->prepare("UPDATE balanceinitiale SET isDelete = 1 WHERE id =?");
		$res = $query->execute([$id])or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateMontantEcheance($idclient,$montant,$mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("UPDATE echeance SET montant = montant+:montant WHERE ID_client = :idclient AND mois = :mois AND annee = :annee");
		$res = $query->execute(['idclient' => $idclient,'montant' => $montant,'mois' => $mois,'annee' => $annee]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deleteEcheance($facture_id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM echeance WHERE facture_id = ?");
		$res = $query->execute([$facture_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function setEcheance($idclient,$mois,$annee,$montant,$etat,$facture_id)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO echeance(ID_client,mois,annee,montant,etat,facture_id) VALUES(:idclient,:mois,:annee,:montant,:etat,:facture_id)");
		$res = $query->execute(['idclient' => $idclient,'mois' => $mois,'annee' => $annee,'montant' => $montant,'etat' => $etat,'facture_id' => $facture_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function verifierUnMoisExistDansEcheance($idclient,$mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM echeance WHERE ID_client =:idclient AND mois =:mois AND annee =:annee");
		$query->execute(['idclient' => $idclient,'mois' => $mois,'annee' => $annee])or die(print_r($query->errorInfo()));
		$res = false;
		while ($data = $query->fetchObject()) 
		{
			$res = true;
		}
		return $res;
	}
	function recupereEcheance_dun_mois_dun_client($idclient,$mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM echeance WHERE ID_client =:idclient AND mois =:mois AND annee =:annee AND etat ='non consommer'");
		$query->execute(['idclient' => $idclient,'mois' => $mois,'annee' => $annee])or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function changerEtatEcheance($idclient,$mois,$annee,$etat)
	{
		$con = connection();
		$query = $con->prepare("UPDATE echeance SET etat = :etat WHERE ID_client =:idclient AND mois =:mois AND annee =:annee");
		$res = $query->execute(['idclient' => $idclient,'mois' => $mois,'annee' => $annee,'etat' => $etat]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getMoisFactureDunClient($idclient,$mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM mois_facture WHERE ID_client = :idclient AND mois = :mois AND annee = :annee ");
		$query->execute(['idclient'=>$idclient,'mois' => $mois,'annee' => $annee]);
		return $query;
	}
	function setMoisFactureDunClient($idclient,$mois,$annee,$facture_id)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO mois_facture(ID_client,mois,annee,facture_id) VALUES(:idclient,:mois,:annee,:facture_id)");
		$res = $query->execute(['idclient'=>$idclient,'mois'=>$mois,'annee'=>$annee,'facture_id'=>$facture_id]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function deleteMoisFactureDunClient($facture_id)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM mois_facture WHERE facture_id = ?");
		$res = $query->execute([$facture_id]);
		return $res;
	}
	function setAccountHistory($Idfrom,$from_type,$taux,$date_history,$ID_client)
	{
		$con = connection(); 
		$query = $con->prepare("INSERT INTO account_history(Idfrom,from_type,taux,date_history,ID_client) VALUES(:idfrom,:from_type,:taux,:date_history,:idclient)");
		$res = $query->execute(['idfrom' => $Idfrom,'from_type' => $from_type,'taux' => $taux,'date_history' => $date_history,'idclient' => $ID_client]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getAccountHistory($idclient)
	{
		$con = connection();
		//$query = $con->prepare('SELECT * FROM account_history WHERE ID_client = ?');
		$query = $con->prepare("SELECT CONCAT(datepaiement,'/payement/',ID_paiement) AS date_creation FROM paiement WHERE paiement.ID_client = ? AND paiement.isDelete = 0 UNION ALL SELECT CONCAT(billing_date,'/facture/',facture_id) AS date_creation FROM facture WHERE facture.ID_client = ? AND facture.type_facture = 0 AND facture.etat_facture = 'actif' AND facture.isDelete = 0 ORDER BY date_creation");
		$query->execute([$idclient,$idclient]) or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function getAccountHistoryPayement($idpaiement)
	{
		$con = connection();
		$query = $con->prepare("SELECT p.ID_paiement,p.numero,p.datepaiement,status,c.ID_client,c.Nom_client,c.billing_number,p.Taux_change_courant,exchange_currency,montant_converti,p.montant,devise,methode,reference,p.tva,ID_banque,deposed FROM paiement p,client c WHERE c.ID_client = p.ID_client AND p.ID_paiement = ?");
		$query->execute([$idpaiement]) or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function toutpayement_d1client($idpaiement)
	{
		$con = connection();
		$query = $con->prepare("SELECT p.ID_paiement,p.datepaiement,c.ID_client,c.Nom_client,c.billing_number,p.montant,methode,reference,devise,taux_change_courant,from_type FROM account_history,paiement p,client c WHERE c.ID_client = p.ID_client AND p.ID_paiement = 100 AND account_history.ID_client = c.ID_client and account_history.from_type ='paiement'");
		$query->execute([$idpaiement]) or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function toutfacture_d1client($idfacture)
	{
		$con = connection();
		$query = $con->prepare("SELECT p.ID_paiement,p.datepaiement,c.ID_client,c.Nom_client,c.billing_number,p.montant,methode,reference,devise,taux_change_courant,from_type FROM account_history,paiement p,client c WHERE c.ID_client = p.ID_client AND p.ID_paiement = 100 AND account_history.ID_client = c.ID_client and account_history.from_type ='facture'");
		$query->execute([$idfacture]) or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;
	}
	function deleteAccountHistory($Idfrom)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM account_history WHERE Idfrom = ?");
		$res = $query->execute([$Idfrom]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function creerPause($idclient,$dateDebut,$dateFin,$raison,$type_pause,$date_creation,$idUser)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO pause_client(ID_client,date_debut,date_fin,raison,type_pause,date_creer,ID_user) VALUES(:idclient,:dateDebut,:dateFin,:raison,:type_pause,:date_creer,:idUser)");
		$res = $query->execute(array('idclient' => $idclient,'dateDebut' => $dateDebut,'dateFin' => $dateFin,'raison' => $raison,'type_pause' => $type_pause,'date_creer' => $date_creation,'idUser'=>$idUser)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updatePause($idPause,$dateDebut,$dateFin,$raison,$type_pause)
	{
		$con = connection();
		$query = $con->prepare("UPDATE pause_client SET date_debut=:dateDebut,date_fin=:dateFin,raison=:raison,type_pause=:type_pause WHERE id =:idPause");
		$res = $query->execute(['dateDebut'=>$dateDebut,'dateFin'=>$dateFin,'raison'=>$raison,'type_pause'=>$type_pause,'idPause'=>$idPause]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function updateStatusPause($idPause)
	{
		$con = connection();
		$query = $con->prepare("UPDATE pause_client SET status = 0 WHERE id =?");
		$res = $query->execute([$idPause]);
		return $res;
	}
	function updateDateOuverturePause($idPause,$dateOuverture)
	{
		$con = connection();
		$query = $con->prepare("UPDATE pause_client SET date_fin =:dateOuverture WHERE id=:idPause");
		$res = $query->execute(['dateOuverture'=>$dateOuverture,'idPause'=>$idPause]);
		return $res;
	}
	function deletePauseClient($idPause)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM pause_client WHERE id=?");
		$res = $query->execute([$idPause]) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getClientEnPauses()
	{
		$con = connection();
		$query = $con->prepare("SELECT id,cl.ID_client,nom_client,date_debut,date_fin,raison,type_pause,date_creer FROM client cl,pause_client pcl WHERE cl.ID_client = pcl.ID_client AND status = 1");
		$query->execute() or die(print_r($query->errorInfo));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
    function getClientEnPauses2()
	{
		$con = connection();
		$query = $con->prepare("SELECT ID_client,billing_number,nom_client FROM client  WHERE etat = 'pause' ORDER BY billing_number DESC");
		$query->execute() or die(print_r($query->errorInfo));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res;
	}
	function updatefichierClient($numerofichier,$nom_fichier,$fichier_doc)
	{
		$con = connection();
		$query = $con->prepare("UPDATE fichier_client SET nom = :nom_fichier,fichier = :fichier_doc WHERE ID_fichier_client = :numerofichier");
		$res = $query->execute(array('numerofichier' => $numerofichier,'nom_fichier' => $nom_fichier,'fichier_doc' => $fichier_doc)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function supprimer_file($del_file)
	 {
	 	$con = connection();
	 	$query = $con->prepare("DELETE FROM fichier_client WHERE ID_fichier_client = ?");
	 	$rs = $query->execute(array($del_file)) or die(print_r($query->errorInfo()));
	 	return $rs;
	 }
	function saveCautionClient($idclientCaution,$montant_caution,$monnaie_caution,$date_caution,$user_creer_caution,$note)
	{
	 	$con = connection();
		$query = $con->prepare("INSERT INTO caution_client(ID_client,montant_caution,monnaie_caution,date_caution,user,commentaire) VALUES(:idclientCaution,:montant_caution,:monnaie_caution,:date_caution,:user_creer_caution,:note)");
		$res = $query->execute(['idclientCaution' => $idclientCaution,'montant_caution' => $montant_caution,'monnaie_caution' => $monnaie_caution,'date_caution' => $date_caution,'user_creer_caution' => $user_creer_caution,'note'=>$note]) or die(print_r($query->errorInfo()));
		return $res;
	} 
 	function cautionTotaleDansUnMois($mois,$annee)
	{
		$con = connection();
		$query = $con->prepare("SELECT SUM(montant_caution) AS montant FROM caution_client WHERE MONTH(date_caution) = :mois AND YEAR(date_caution) = :annee");
		$query->execute(['mois' => $mois,'annee' => $annee]);
		return $query;
	}
	function getCautionDunClient($idclient)
	{
		$con = connection();
		$query = $con->prepare("SELECT montant_caution AS montant,monnaie_caution as monnaie FROM caution_client cau,client cl WHERE cau.ID_client = cl.ID_client AND cl.ID_client = ?");
		$query->execute([$idclient]);
		return $query;
	}	
	function fichier_scanne_Total() 
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM fichier_client");
		$query ->execute();
		return $query;
	}
		function getClient_speciaux()
	{
		$con = connection();
		$query = $con->prepare("SELECT client.ID_client,client.billing_number,client.Nom_client,serviceinclucontract.montant AS montant_total,serviceinclucontract.quantite,serviceinclucontract.prixTva,contract.etat FROM client ,serviceinclucontract,contract WHERE client.ID_client = contract.ID_client AND contract.ID_contract =serviceinclucontract.ID_contract AND contract.etat = 'activer' AND serviceinclucontract.montant BETWEEN '1000000' AND '3000000' GROUP BY client.ID_client ORDER BY client.Nom_client ASC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
		/*function getDetteclient()
	{
		$con = connection();
		$query = $con->prepare("

			/*SELECT client.ID_client,billing_number,Nom_client,mois_debut,annee,SUM(facture_service.montant) AS montant FROM client,facture,facture_service WHERE client.ID_client = facture.ID_client AND facture.facture_id = facture_service.facture_id AND  facture_service.annee BETWEEN 2022 AND 2023 AND facture_service.facture_id >44730 AND facture.facture_id NOT IN(SELECT facture_id FROM facture_payer) GROUP BY facture.facture_id");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}*/
    function getContractServices()
    {
        $con = connection();
        $query = $con->prepare("SELECT co.ID_contract,ROUND(SUM((si.montant * si.quantite) + ((si.montant * si.quantite)*co.tva/100))) AS amount,co.monnaie FROM serviceinclucontract si,contract co WHERE si.ID_contract = co.ID_contract AND si.status = 0 AND co.isDelete = 0 GROUP BY co.ID_contract");
		$query ->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function updateContractAmount($contractId,$amount)
    {
        $con = connection();
        $query = $con->prepare("UPDATE contract SET amount=:amount WHERE ID_contract=:contractId");
		$res = $query ->execute(['amount' => $amount,'contractId'=>$contractId]);
        return $res;
    }

}