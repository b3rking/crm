 
<?php
require_once("../../model/connection.php");
require_once("../../model/article.class.php");
//require_once("../../model/comptabilite.class.php");

$article = new Article();

//$comptabilite = new Comptabilite();
//idatre,titre_attrib
if ($article->update_titre_attrib($_GET['idatre'],$_GET['titre_attrib']) > 0) 
{

	//if ($comptabilite->setHistoriqueAction($_GET['numero'],'article',$_GET['userName'],date('Y-m-d'),'modifier'))
   // {
    	require_once('repArticle.php');
   // }
  
	
}
		
