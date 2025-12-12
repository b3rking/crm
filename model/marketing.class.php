
<?php
/**
 * 
 */
class Marketing
{

    function visiteProspect($idprospects,$propositionmarketeur,$propositionprospect,$daterdv,$datedujour)
    {
        $con = connection();
        $query = $con->prepare("INSERT INTO visite_prospect(ID_prospect,propositionmarketeur,propositionprospect,rendezvous ,datedujour) VALUES (:idprospects,:propositionmarketeur,:propositionprospect,:daterdv,:datedujour)");

        $rs = $query->execute(array('idprospects'=>$idprospects,'propositionmarketeur' =>$propositionmarketeur,'propositionprospect'=>$propositionprospect,'daterdv'=>$daterdv,'datedujour'=>$datedujour)) or die(print_r($query->errorInfo()));
        return $rs;
    }
    function autocompleteVisiteProspect($nom)
    {
        $con = connection();
        $query = $con->query("SELECT ID_prospect,nom FROM prospect WHERE nom LIKE '%".$nom."%'");
        $tb = array();
        while ($data = $query->fetchObject()) {
            $tb[] = $data;
        }
        return $tb;
    }
    function ajouterprospect($prospect,$adresprospect,$portable,$mailP,$genre,$rdv,$jourEnreg,$prospect_comment,$marketeur_comment,$etat,$iduser)
    {
        $con = connection();
        $query = $con->prepare("INSERT INTO prospect(nom,adresseProspect,telephone,mail,genre,rendezvous ,dateProspection,prospect_comment,marketeur_comment,etatduProspect,ID_user) VALUES (:prospect,:adresprospect,:portable,:mailP,:genre,:rdv,:jourEnreg,:prospect_comment,:marketeur_comment,:etat,:iduser)");

        $rs = $query->execute(array('prospect'=>$prospect,'adresprospect' =>$adresprospect,'portable'=>$portable,'mailP'=>$mailP,'genre'=>$genre,'rdv' =>$rdv,'jourEnreg' => $jourEnreg, 'prospect_comment' => $prospect_comment,'marketeur_comment'=>$marketeur_comment,'etat'=>$etat,'iduser' =>$iduser)) or die(print_r($query->errorInfo()));
        return $rs;
    }
    function getMaxIdProspect()
    {
        $con = connection();
        $query = $con->prepare("SELECT MAX(ID_prospect) as ID_prospect FROM prospect");
        $query->execute();
        return $query->fetchObject()->ID_prospect;
    }
    function afficheProspect ()
	{
		$con = connection ();
		$query = $con->prepare("SELECT ID_prospect,nom,adresseProspect,telephone,mail,entreprise,rendezvous,dateProspection,prospect_comment,marketeur_comment,etatduProspect,genre,u.ID_user,u.nom_user FROM prospect p,user u WHERE u.ID_user = p.ID_user");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function filtreProspect($condition)
    {
        $con = connection();
        $query = "SELECT ID_prospect,nom,entreprise,telephone,adresseProspect,mail,genre,dateProspection,rendezvous,etatduProspect,u.nom_user,u.ID_user FROM prospect p,user u WHERE u.ID_user = p.ID_user $condition ORDER BY dateProspection DESC";
        $statement = $con->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
    function getProspectsByUser($iduser)
    {
        $con = connection ();
        $query = $con->prepare("SELECT * FROM prospect WHERE ID_user = ?");
        $query->execute([$iduser]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function affichetoutSponsor ()
    {
        $con = connection ();
        $query = $con->prepare("SELECT * FROM sponsor");

        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function affichevisiteProspect()
    {
        $con = connection ();
        $query = $con->prepare("SELECT * FROM visite_prospect");

        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function recupereDetail_client_visite($id)
    {
        $con =connection();
        $query =$con->prepare("SELECT ID_prospect,propositionmarketeur,propositionprospect,rendezvous,datedujour FROM visite_prospect WHERE ID_prospect=?");
        $query->execute(array($id)) or die(print_r($query->errorInfo()));
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    /*function recupererTypes()
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
    }*/
    function updateProspect($numprospect,$nomprospect,$adresprospect,$phoneprospect,$mailprospect,$genre,$rdv,$dateprospection)
    {
        $con = connection();
        $query = $con->prepare("UPDATE prospect SET nom =:nomprospect,adresseProspect=:adresprospect,telephone =:phoneprospect,mail =:mailprospect,genre=:genre,rendezvous =:rdv, dateProspection =:dateprospection WHERE ID_prospect =:numprospect"); 
        $rs =$query->execute(array('nomprospect'=>$nomprospect,'adresprospect' =>$adresprospect,'phoneprospect' =>$phoneprospect,'mailprospect' =>$mailprospect,'genre'=>$genre,'rdv'=>$rdv, 'dateprospection' =>$dateprospection,'numprospect'=>$numprospect));
        
        return $rs;
    }
    function supprimerProspect($numprospect)
    {
        $con = connection();
        $query = $con->prepare("DELETE FROM prospect WHERE ID_prospect = ?"); 
        $rs =$query->execute(array($numprospect))or die(print_r($query->errorInfo()));
        return $rs; 	
    }
    function nombreprospect()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb FROM prospect");
        $query->execute(); /*or die(print_r($query->errorInfo()));*/
        return $query;
    }
    function nombreprospectByUser($iduser)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb FROM prospect WHERE ID_user = ?");
		$query->execute([$iduser]);
		return $query;
	}
    function ajouterstockmarketing($materiel,$quantite)
    {
        $con = connection();
        $query = $con->prepare("INSERT INTO stock_marketing(materiels,quantite) VALUES (:materiel,:quantite)");

        $rs = $query->execute(array('materiel'=>$materiel,'quantite' =>$quantite)) or die(print_r($query->errorInfo()));
        return $rs;
    }
    function afficheStockmarketing()
    {
        $con = connection ();
        $query = $con->prepare("SELECT * FROM stock_marketing");

        $query->execute();
        $rs = array();

        while ( $data = $query->fetchObject()) 
        {
        # code...
        $rs[] = $data;
        }
        return $rs;
    }
    function supprimerstock($idstockmarketing)
    {
        $con = connection();
        $query = $con->prepare("DELETE FROM stock_marketing WHERE ID_stock = ?"); 
        $rs =$query->execute(array($idstockmarketing))or die(print_r($query->errorInfo()));
        return $rs; 	
    }
    function updatestock($idstockmarketing,$materiels,$quantite)
    {
        $con = connection();
        $query = $con->prepare("UPDATE stock_marketing SET materiels =:materiels,quantite=:quantite WHERE ID_stock =:idstockmarketing"); 
        $rs =$query->execute(array('materiels'=>$materiels,'quantite' =>$quantite,'idstockmarketing' =>$idstockmarketing));

        $error = $query->errorInfo();
        return $rs;
    }
    function ajoutersponsor($demande,$nature,$adrsponsor,$phonesponsor,$visibilite,$datedebut,$datefin)
    {
        $con = connection();
        $query = $con->prepare("INSERT INTO sponsor(demande,nature,adresse,telephone ,visibilite,duredebut,durefin) VALUES (:demande,:nature,:adrsponsor,:phonesponsor,:visibilite,:datedebut,:datefin)");

        $rs = $query->execute(array('demande' =>$demande,'nature'=>$nature,'adrsponsor'=>$adrsponsor,'phonesponsor'=>$phonesponsor,'visibilite' =>$visibilite,'datedebut' => $datedebut, 'datefin' => $datefin)) or die(print_r($query->errorInfo()));
        return $rs;
    }
    function updateSponsor($idsponsor,$demande,$nature,$adrsponsor,$phonesponsor,$datedebut,$datefin)
    {
        $con = connection();
        $query = $con->prepare("UPDATE sponsor SET demande =:demande,nature=:nature,adresse =:adrsponsor,telephone =:phonesponsor,duredebut=:datedebut,durefin =:datefin WHERE ID_sponsor =:idsponsor"); 
        $rs =$query->execute(array('demande'=>$demande,'nature' =>$nature,'adrsponsor' =>$adrsponsor,'phonesponsor' =>$phonesponsor,'datedebut'=>$datedebut, 'datefin' =>$datefin,'idsponsor' =>$idsponsor));

        $error = $query->errorInfo();
        return $rs;
    }
    function supprimerSponsor($numspons)
    {
        $con = connection();
        $query = $con->prepare("DELETE FROM sponsor WHERE ID_sponsor = ?"); 
        $rs =$query->execute(array($numspons))or die(print_r($query->errorInfo()));
        return $rs; 	
    }
    function recuperermaterielstock()
    {

        $con = connection();
        $query = $con->prepare("SELECT * FROM stock_marketing");
        $query->execute();
        $rs =array();
        while($data =$query->fetchObject())
        {
            $rs [] = $data;
        }
        return $rs;
    }
    function selection1prospect($idprospect)
    {
        $con = connection();
        $query = $con->prepare("SELECT nom,telephone,mail,adresseProspect,entreprise,genre FROM prospect WHERE ID_prospect = ?"); 
        $query->execute(array($idprospect))or die(print_r($query->errorInfo()));
        return $query; 	
    }
    function selectionLocalisationProspect()
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
    function uptadateEtatprospect($idprospect,$Etatprospect)
    {
        $con = connection();
        $query = $con->prepare("UPDATE prospect SET etatduProspect =:Etatprospect WHERE ID_prospect =:idprospect"); 
        $rs =$query->execute(array('Etatprospect'=>$Etatprospect,'idprospect' =>$idprospect))or die(print_r($query->errorInfo()));
        return $rs;
    }
    function getProspect($id)
    {
        $con =connection();
        $query =$con->prepare("SELECT ID_prospect,nom,entreprise,telephone,adresseProspect,mail,dateProspection,rendezvous,prospect_comment,marketeur_comment,etatduProspect FROM prospect WHERE ID_prospect=?");
        $query->execute(array($id)) or die(print_r($query->errorInfo()));
        return $query;
    }
    function recupereDetail_un_prospect($id)
    {
        $con =connection();
        $query =$con->prepare("SELECT ID_prospect,nom,entreprise,telephone,adresseProspect,mail,dateProspection,rendezvous,commentaire,etatduProspect FROM prospect WHERE ID_prospect=?");
        $query->execute(array($id)) or die(print_r($query->errorInfo()));
        $rs = array();
        while ($data = $query->fetchObject()) 
        {
            $rs[] = $data;
        }
        return $rs;
    }
    function VerifierEtatsponsor($idprospect)
    {
        $con = connection();
        $query = $con->prepare("SELECT etatduProspect FROM prospect WHERE ID_prospect= ?");
        $query->execute(array($idprospect)) or die(print_r($query->errorInfo()));
        return $query;
    } 

    function groupementProsect_par_etat()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS nb,etatduProspect FROM prospect GROUP BY etatduProspect");
        $query->execute() or die(print_r($query->errorInfo()));
        
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function groupementProspect_par_etat_by_user($iduser)
	{
		$con = connection();
		$query = $con->prepare("SELECT COUNT(*) AS nb,etatduProspect FROM prospect WHERE ID_user = ? GROUP BY etatduProspect");
		$query->execute([$iduser]) or die(print_r($query->errorInfo()));
		return $query->fetchAll(PDO::FETCH_OBJ);
	}
    function selectionMateriel()
    {
        $con = connection();
        $query = $con->prepare("SELECT * FROM stock_marketing");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    function diminuerQuantitemateriel($idstockmarketing,$quantite)
    {
        $con = connection();
        $query = $con->prepare("UPDATE stock_marketing SET quantite = quantite - :quantite WHERE ID_stock = :idstockmarketing");
        $res = $query->execute(array('idstockmarketing' => $idstockmarketing,'quantite' => $quantite)) or die(print_r($query->errorInfo()));
        return $res;
    }
    function prospectValide()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS prospectvalide FROM prospect WHERE etatduProspect = 'valider'");
        $query ->execute();
        return $query;
    }
    function prospectannuler()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS annuler FROM prospect WHERE etatduProspect = 'annuler'");
        $query ->execute();
        return $query;
    }
    function prospect_attente()
    {
        $con = connection();
        $query = $con->prepare("SELECT COUNT(*) AS stocknombreprospectAttente FROM prospect WHERE etatduProspect = 'attente'");
        $query ->execute();
        return $query;
    }
    function recupereProspectsparEtat($etatduProspect)
    {
        $con = connection();
        $query = $con->prepare("SELECT ID_prospect,nom,adresseProspect,telephone,mail,entreprise,rendezvous,dateProspection,etatduProspect,commentaire FROM prospect WHERE etatduProspect =?  GROUP BY ID_prospect");
        $query->execute(array($etatduProspect));
        $rs = array();
        while ( $data = $query->fetchObject()) 
        {
            $rs[] = $data;
        }
        return $rs;
    }
	function prospect_deja_visiter($idprospect)
	{

	 	$con = connection();
	 	$query = $con->prepare("SELECT prospect.nom,visite_prospect.ID_prospect FROM visite_prospect,prospect WHERE prospect.ID_prospect = visite_prospect.ID_prospect AND visite_prospect.ID_prospect =?");
	 	$query->execute(array($idprospect)) or die(print_r($query->errorInfo()));
	 	return $query;
	}
    function prospect_recupererTypes()
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

}

