
<?php
/**
 * 
 */
class Article
{
	function ajouterArticle($langue,$corp_article)
	{
		$con = connection();					
		$query = $con->prepare("INSERT INTO article(langue,corp) VALUES(:langue,:corp_article)");
		$res = $query->execute(array('langue' => $langue,'corp_article' => $corp_article)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function afficheArticleamodifier()

	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT article.numero_article,titre,corp,profil_article.profil_name FROM article,profil_article,attribution_article WHERE attribution_article.profil_id = profil_article.profil_id AND article.numero_article =attribution_article.numero_article");
	 	$query->execute();
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
	function afficheArticle()

	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT article.id,type_contrat,type_article,langue,article.titre,corp,profil_article.profil_id,profil_article.profil_name,attribution_article.ID_attrib FROM article,profil_article,attribution_article WHERE article.id = attribution_article.id AND profil_article.profil_id = attribution_article.profil_id ");
	 	$query->execute();
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
	function id_article()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(id) AS numarticle FROM article");
		$query->execute();
		return $query;
		
	}
	  function get_max_prol()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(profil_id) AS profil_id FROM profil_article");
		//$query->execute();
		//return $query->fetch()['id'];
			$query->execute();
		return $query;
	}
	function getArticlesDunContract($idcontract)
	{
		
		$con = connection();
		$query = $con->prepare("SELECT a.id,type_contrat,type_article,langue,attrib.titre,corp,p.profil_id,p.profil_name FROM article a,profil_article p,contract co,profil_articletocontract pac,attribution_article attrib WHERE a.id = attrib.id AND attrib.profil_id =p.profil_id AND pac.profil_id = p.profil_id AND pac.ID_contract = co.ID_contract AND co.ID_contract =? ORDER BY attrib.titre ASC");
		$query->execute(array($idcontract)) or die(print_r($query->errorInfo()));
        return $query->fetchAll(PDO::FETCH_OBJ);
	}
		function getProfilGlobaux()
	{

		$con = connection();
		$query = $con->prepare("SELECT profil_article.profil_id,profil_name FROM profil_article,attribution_article WHERE profil_article.profil_id NOT IN (SELECT attribution_article.profil_id FROM attribution_article) GROUP BY profil_article.profil_id");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array(); 
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res; 
	/*$query->execute() or die(print_r($query->errorInfo()));
		$res = $query->fetchAll(PDO::FETCH_OBJ);
		return $res;*/
	}
	function profil_avec_article()
	{
		$con = connection();
		$query = $con->prepare("SELECT profil_article.profil_id,profil_name FROM profil_article,attribution_article WHERE profil_article.profil_id = attribution_article.profil_id GROUP BY profil_article.profil_id");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array(); 
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res; 
	}
	function updateArticle($numero,$langue,$corp_article)
	{
		$con = connection();
		$query = $con->prepare("UPDATE article SET langue = :langue,corp = :corp_article WHERE id = :numero");
		$rs = $query->execute(array('langue' => $langue,'corp_article'=>$corp_article,'numero' => $numero)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function update_titre_attrib($idatre,$titre_attrib)
	{
		$con = connection();
		$query = $con->prepare("UPDATE attribution_article SET titre = :titre_attrib WHERE ID_attrib= :idatre");
		$rs = $query->execute(array('idatre' => $idatre,'titre_attrib'=>$titre_attrib)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function update_titre_article($idatre,$titre_attrib)
	{
		$con = connection();
		$query = $con->prepare("UPDATE article SET titre = :titre_attrib WHERE id= :idatre");
		$rs = $query->execute(array('idatre' => $idatre,'titre_attrib'=>$titre_attrib)) or die(print_r($query->errorInfo()));
		return $rs;
	}

	function deleteArticle($numero)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM article WHERE id = ?");
		$rs = $query->execute(array($numero)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function drop_profile($idprofile)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM profil_article WHERE profil_id = ?");
		$rs = $query->execute(array($idprofile)) or die(print_r($query->errorInfo()));
		return $rs;
	}

	function ajouterProfil($profil_name,$description)
	{
		$con = connection();
		$query = $con->prepare("INSERT INTO profil_article(profil_name,description) VALUES(:profil_name,:description)");
		$res = $query->execute(array('profil_name' => $profil_name,'description' => $description)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function getProfils()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM profil_article");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array(); 
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res; 
	}
	function profil_differende_global()
	{
		$con = connection();
		$query = $con->prepare("SELECT * FROM profil_article WHERE profil_name !='global'");
		$query->execute() or die(print_r($query->errorInfo()));
		$res = array();
		while ($data = $query->fetchObject()) 
		{
			$res[] = $data;
		}
		return $res; 
	}
	function showArticleByProfil($profil)
	{ 
		$con = connection();
	 	$query = $con->prepare("SELECT a.id,type_contrat,type_article,langue,attrib.titre,corp,p.profil_id,p.profil_name,attrib.ID_attrib FROM article a,profil_article p,attribution_article attrib WHERE attrib.id = a.id AND attrib.profil_id =p.profil_id AND p.profil_id =? GROUP BY id");
	 	$query->execute(array($profil)) or die(print_r($query->errorInfo()));
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}

	function getAll_corpDarticle()
	{
		
		$con = connection();
	 	$query = $con->prepare("SELECT id,corp,titre,p.profil_id FROM article,profil_article p GROUP BY id");
	 	$query->execute() or die(print_r($query->errorInfo()));
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
	function get_article_kinepasdans_attribution($profil,$langue)
	{
		
		$con = connection();
	 	$query = $con->prepare("SELECT a.id,type_contrat,type_article,langue,titre,corp FROM article a WHERE a.id NOT IN (SELECT attribution_article.id FROM attribution_article WHERE profil_id =? ) AND langue = ?");
	 
	 	$query->execute(array($profil,$langue)) or die(print_r($query->errorInfo()));
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data; 
	 	}
	 	return $rs;
	}
	function attribuer_article($profil_id,$affiche,$titre)
	{
		
		$con = connection();
		$query = $con->prepare("INSERT INTO attribution_article(profil_id,id,titre) VALUES(:profil_id,:affiche,:titre)");
		$res = $query->execute(array('profil_id' => $profil_id,'affiche' => $affiche,'titre'=>$titre)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function update_article_avec_id_attrib($id_article,$article)
	{
		$con = connection();
		$query = $con->prepare("UPDATE article SET corp = :article WHERE article.id = :id_article");
		$rs = $query->execute(array('id_article' => $id_article,'article' => $article)) or die(print_r($query->errorInfo()));
		return $rs;
	}
	function supprimeprofile($numprof) 
	{
		$con = connection();
	 	$query = $con->prepare("DELETE FROM profil_article WHERE profil_id = ?");
	 	$rs = $query->execute(array($numprof)) or die(print_r($query->errorInfo()));
	 	return $rs;
	}
	function modifier_profile($idprof,$nomprofil)
	{
		$con = connection();
		$query = $con->prepare("UPDATE profil_article SET  profil_name = :nomprofil WHERE profil_id = :idprof");
		$rs = $query->execute(array('nomprofil' => $nomprofil,'idprof' => $idprof)) or die(print_r($query->errorInfo()));
		return $rs; 
	}
	function modification_duProfil($profil_id,$profil_name)
	{
		$con = connection();
		$query = $con->prepare("UPDATE profil_article SET  profil_name = :profil_name WHERE profil_id = :profil_id");
		$rs = $query->execute(array('profil_name' => $profil_name,'profil_id' => $profil_id)) or die(print_r($query->errorInfo()));
		return $rs; 
	}
	function addVerso($titre,$langue,$corp_article,$dateVerso)
	{
		$con = connection();					
		$query = $con->prepare("INSERT INTO verso_article(titre,langue,contenu,created_by) VALUES(:titre,:langue,:corp_article,:dateVerso)");
		$res = $query->execute(array('titre' => $titre,'langue' => $langue,'corp_article' => $corp_article,'dateVerso' => $dateVerso)) or die(print_r($query->errorInfo()));
		return $res;
	}
	function id_VERSO()
	{
		$con = connection();
		$query = $con->prepare("SELECT MAX(id_verso) AS numarticle FROM verso_article");
		$query->execute();
		return $query;
		
	}
	function getVersoArticle()

	{
	 	$con = connection();
	 	$query = $con->prepare("SELECT id_verso,titre,langue,contenu,created_by FROM verso_article ORDER BY titre ASC");
	 	$query->execute();
	 	$rs = array();

	 	while ( $data = $query->fetchObject()) 
	 	{
	 		# code...
	 		$rs[] = $data;
	 	}
	 	return $rs;
	}
	function DeleteVerso($numero)
	{
		$con = connection();
		$query = $con->prepare("DELETE FROM verso_article WHERE id_verso = ?");
		$rs = $query->execute(array($numero)) or die(print_r($query->errorInfo()));
		return $rs;
	}
		function UpdateVeso($numero,$langue,$corp_article)
	{
		$con = connection();
		$query = $con->prepare("UPDATE verso_article SET langue = :langue,contenu = :corp_article WHERE id_verso = :numero");
		$rs = $query->execute(array('langue' => $langue,'corp_article'=>$corp_article,'numero' => $numero)) or die(print_r($query->errorInfo()));
		return $rs;
	}

}