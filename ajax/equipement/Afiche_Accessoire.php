 <?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");



$rs = $equipement->afficheAccessoire($_GET['accessoire'],$_GET['quantite'],$_GET['commentaire']);
if ($rs)
{
?>
    <?php
    $i = 0;
    foreach($user->afficheAccessoire() as $value) :
        $i++;
    ?>
   <tr>
       <td><?php echo $value->categorie?></td>
        <td><?php echo $value->quantite?> </td>
        <td><?php echo $value->commentaire?></td>
        
    </tr>

   <?php endforeach?>
<?php
}

?>        
        
        
    
            <div class="card-body">

                    <div class="table-responsive">
                    <table class="table color-table success-table">
                <thead>
                     
                    <?php foreach($equipement->afficheAccessoire() as $value)
                    {
                       ?>
                 
                    <tr>
                                <th>Categorie</th>
                                <th>Quantite</th>
                                <th>Commentaire</th>
                    </tr>
                    <?php
                }
                ?>
                </thead>
                <tbody>
                     <?php foreach($equipement->afficheAccessoire() as $value)
                    {
                       ?>
                 
                    <tr>
       <td><?php echo $value->categorie?></td>
        <td><?php echo $value->quantite?> </td>
        <td><?php echo $value->commentaire?></td>
                       
                    </tr>
                    <?php
                }
                ?>
                           
                     </tbody>
                    </table>
                </div>
            </div>

        <?php 

            }
        }
    }
}




   

   
        
    
         