<?php
require_once("../../model/connection.php");
require_once("../../model/article.class.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();
$article = new Article();   

if ($article->addVerso($_GET['titre'],$_GET['langue'],$_GET['corp_article'],$_GET['dateVerso'])) 

{  $id = $article->id_VERSO()->fetch()['numarticle'];
    if ($comptabilite->setHistoriqueAction($id,'verso_article',$_GET['userName'],date('Y-m-d'),'creer'))
    {
    	require_once('repVerso.php');
    }
    
	
}

   