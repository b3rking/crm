 <?php
	require_once("../../model/connection.php");
	require_once("../../model/article.class.php");

	$article = new Article();
	$description ="creation du nouveau profil";

	if($article->ajouterProfil($_GET['profil_name'],$description))
	{
		$idprofil = $article->get_max_prol()->fetch()['profil_id'];

				foreach ($article->showArticleByProfil($_GET['profil_id']) as $value) 
				{
					$id = $value->id;
					$titre = $value->titre;
					$corp = $value->corp;
					$profil_id = $value->profil_id;
				
				if($article->attribuer_article($idprofil,$id,$titre))
			       {
			        	//echo "insertion reussie";
			       }
			   }


	}

