
<?php
require_once("../../model/connection.php");
require_once("../../model/article.class.php");
require_once("../../model/comptabilite.class.php");

$article = new Article();

$comptabilite = new Comptabilite();

if ($article->updateArticle($_GET['numero'],$_GET['langue'],$_GET['corp_article']) > 0) 
{
	if ($comptabilite->setHistoriqueAction($_GET['numero'],'article',$_GET['userName'],date('Y-m-d'),'modifier'))
    {
    	require_once('repArticle.php');
    }
  
	
}
		
