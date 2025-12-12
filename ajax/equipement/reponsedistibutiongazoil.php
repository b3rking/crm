<?php $i =0; 
                            foreach ($equipement->afficheEtat_distribution() as$value) 
                            { $i++; 
                                ?>
                                <tr>
                                    <td><?php echo $value->carburant?></td>
                                    <td><?php echo $value->consommateur?></td>
                                    <td><?php echo $value->quantite?></td>
                                    <td><?php echo $value->datedistribution?></td>    
                                </tr>
                            <?php
                            }
                            ?>