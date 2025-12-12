
<?php
	require_once("../../model/connection.php");
	require_once("../../model/article.class.php");
	require_once("../../model/comptabilite.class.php");


	$article = new Article();
	$comptabilite = new Comptabilite();

	if ($article->DeleteVerso($_GET['numero'])) 
	{
		if ($comptabilite->setHistoriqueAction($_GET['numero'],'verso_article',$_GET['userName'],date('Y-m-d'),'supprimer'))
    {
    	require_once('repVerso.php');
    }
    } 		
