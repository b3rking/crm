<?php
require_once("../../model/connection.php");
require_once("../../model/article.class.php");

$article = new Article();

if ($article->ajouterProfil($_GET['profil_name'],$_GET['description'])) 

{
?>
	<option value=""></option>
    <?php
    foreach ($article->getProfils() as $value)
    {
    ?>
        <option value="<?=$value->profil_id?>"><?=$value->profil_name?></option>
    <?php
    }
}
else echo "non";
?>
