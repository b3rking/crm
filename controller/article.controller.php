<?php
require_once("model/article.class.php");
require_once('model/User.class.php');
//require_once('model/ticket.class.php'); 

function article()
{
	$article = new Article();
	$user = new User();
	require_once('vue/admin/article/article.php');
}
function article_global()
{
	$article = new Article();
	$user = new User(); 
	require_once('vue/admin/article/attribuer_article.php');
}
function article_selectionne($profil_id,$numarticle,$ordre)
// article_selectionne($_POST['profil_id'],$numarticle,$ordre);
{
	$article = new Article();
	$user = new User();
	// ICI LA VARIABLE QUI CONTIENT LE CONTENU DU TABLEAU C AFFICHE
	
	//foreach ($affiche as $value) 
  // {
   	// AVEC CE BOUCLE ON PARCOURS LE TABLEAU ET ON PUIS EXPLODE DECOMPOSE LA VALEUR STRING EN VARIABLE TABLEAU
	  // 	$affiche_tab = explode("-", $value);
	  //  $idarticle = $affiche_tab[0];
	  //  $titre = $affiche_tab[1];
	    // echo "string  : ".$profil_id.'/' .$idarticle.'/' .$titre.'</br>';
     if($article->attribuer_article($profil_id,$numarticle,$ordre))
        {
        	//echo "insertion reussie";
        }
   // }
     require_once('vue/admin/article/attribuer_article.php');
	
}
function inclure_pagemodif()
{
	$article = new Article();
	$user = new User();
	require_once('vue/admin/article/modifi_all_article.php');
}
function inclure_pageAllartic()
{
	$article = new Article();
	$user = new User();
	//require_once('vue/admin/article/modifi_all_article.php');
}
function set_profil()
{
	$article = new Article();
	$user = new User();
	require_once('vue/admin/article/donneTout_article_auProfil.php');
}
function verso_articleContrat()
{
	
	$article = new Article();
	require_once('vue/admin/article/verso_articleContrat.php');
}

?>  