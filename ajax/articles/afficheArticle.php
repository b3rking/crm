<?php
require_once("../../model/connection.php"); 
require_once("../../model/article.class.php");




$rs = $article->afficheArticle($_GET['numero'],$_GET['typecontrat'],$_GET['typearticle'],$_GET['langue'],$_GET['titre'],$_GET['article']);
if ($rs)
{
?>
    <?php
    $i = 0;
    foreach($article->afficheArticle() as $value) :
        $i++;
    ?>
    <tr>
        
        
        <td><?php echo  $value->id.' - '.$value->corp;?></td>
        <td><?php echo $value->langue?></td>
        <td></td>
        
    </tr>

   <?php endforeach?>
<?php
}

?>    
<div class="card-body">

                <h4 class="card-title">e</h4>
                <!--<h6 class="card-subtitle">Add class <code>.color-table .success-table</code></h6>-->
                <div class="table-responsive">
                    <table class="table color-table warning-table">
                <thead>
                     
                    <?php foreach($article->afficheArticle($_GET['numero']) as $value)
                    {
                       ?>
                 
                    <tr>
                        
                        <!--th>type contrat</th-->
                        <th>Corps</th>
                        <th>Langue</th>
                        <th>Action</th>
                        <!--th>type article</th-->
                        
                    </tr>
                    <?php
                }
                ?>
                </thead>
                <tbody>
                    <tr>
                    <td><?php echo  $value->id.'-'.$value->corp?></td>
                    <td><?php echo $value->langue?></td>
                    <td></td>
                </tr>
                           
                     </tbody>
                    </table>
                </div>
            </div>

        <?php 

            }
        }
    }
}
