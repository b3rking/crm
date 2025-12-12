<?php
require_once("../../model/connection.php");
require_once("../../model/article.class.php"); 

$article = new Article(); 

    if($article->update_article_avec_id_attrib($_GET['id_article'],$_GET['article']))
        {
            echo "ok";
        }
?>