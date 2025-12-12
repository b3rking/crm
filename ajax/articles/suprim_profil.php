<?php
    require_once("../../model/connection.php");
	require_once("../../model/article.class.php");
	//require_once("../../model/comptabilite.class.php");


	$article = new Article();
	//$comptabilite = new Comptabilite();
	
	if ($article->supprimeprofile($_GET['numprof'])) 
	{
		//if ($comptabilite->setHistoriqueAction($_GET['numprof'],'article',$_GET['user_del'],date('Y-m-d'),'supprimer'))
    
    	require_once('repmodProfile.php');
    
    } 		
?>