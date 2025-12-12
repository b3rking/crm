<?php 
require_once("../../model/connection.php");
require_once("../../model/article.class.php"); 
 
$article = new Article(); 

$i = 0;
foreach($article->get_article_kinepasdans_attribution($_GET['profil'],$_GET['langue']) as $value)
{
    $i++;
?>
<tr>
        <td class=""><?php echo $value->id.'-'.$value->corp;?></td>
        <!--td>
           <input type="checkbox" name="affiche[<?=$i?>]" value="<?=$value->numero_article.'-'.
                                    $value->titre?>">
        </td--> 
<td><input type="checkbox" id="titre<?=$i?>" value="<?=$value->id.'-'.$i?>" name="affiche[<?=$i?>]" onclick="showHideInput_titre(this,'<?=$i?>')"/><br />
</td>

<td>
<div id="contena_titre<?=$i?>" style="display: none;">
    <input type="number" id="ordre<?=$i?>" name="ordre<?=$i?>"> 
</div>
</td>
      
    </tr>
        <?php                                            
                }
                ?>
                   
