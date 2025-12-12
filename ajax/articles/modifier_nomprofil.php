 
<?php
require_once("../../model/connection.php");
require_once("../../model/article.class.php");
require_once("../../model/comptabilite.class.php");

$article = new Article();

//$comptabilite = new Comptabilite();


if ($article->modification_duProfil($_GET['profil_id'],$_GET['profil_name']) > 0) 
{
	require_once('repmodProfile.php');
	/*if ($comptabilite->setHistoriqueAction($_GET['numero'],'article',$_GET['userName'],date('Y-m-d'),'modifier'))
    {
    	require_once('repArticle.php');
    }*/
  
	
}
		
