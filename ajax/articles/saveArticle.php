<?php
require_once("../../model/connection.php");
require_once("../../model/article.class.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();
$article = new Article(); 
//$idclient = preg_split("#[-]+#", $_GET['client']);

if ($article->ajouterArticle($_GET['langue'],$_GET['corp_article'])) 

{  $id = $article->id_article()->fetch()['numarticle'];
    if ($comptabilite->setHistoriqueAction($id,'article',$_GET['userName'],date('Y-m-d'),'creer'))
    {
    	require_once('repArticle.php');
    }
    
	
}

   