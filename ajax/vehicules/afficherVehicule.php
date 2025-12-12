<?php
require_once("../../model/connection.php");
require_once("../../model/vehicule.class.php");



$rs = $vehicule->afficheVehicule($_GET['plaque'],$_GET['modele'],$_GET['marque']);
if ($rs)
{
?>
    <?php
    $i = 0;
    foreach($article->afficheArticle() as $value) :
        $i++;
    ?>
   <tr>
        <td><?php echo $value->immatriculation?></td>
        <td><?php echo $value->modele?> </td>
        <td><?php echo $value->marque?></td>
        
        
    </tr>

   <?php endforeach?>
<?php
}

?>        
        
        
    
            <div class="card-body">

                    <div class="table-responsive">
                    <table class="table color-table success-table">
                <thead>
                     
                    <?php foreach($vehicule->afficheVehicule($_GET['plaque']) as $value)
                    {
                       ?>
                 
                    <tr>
                               <th>Plaque d'immatriculation</th>
                                
                                <th>Modele</th>
                                <th>Marque</th>
                                <th></th>
                                <th></th>
                            </tr>
                    <?php
                }
                ?>
                </thead>
                <tbody>
                     <?php foreach($vehicule->afficheVehicule($_GET['plaque']) as $value)
                    {
                       ?>
                 
                    <tr>
                       <th><?php echo $value->immatriculation?></th>
                        
                        <th><?php echo $value->modele?></th>
                        <th><?php echo $value->marque?></th>
                       
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




   

   
        
    
         