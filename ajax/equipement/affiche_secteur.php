<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");


<?php
}
/*if ($data = $client->affichrUnClent($_GET['idclient'])->fetch())
{
    echo "Ce secteur existe deja";
}*/


$rs = $equipement->NewSecteur($_GET['Code_secteur'],$_GET['nom_secteur'],$_GET['adrese_secteur']);
if ($rs)
{
?>
    <?php
    $i = 0;
    foreach($equipement->afficheSecteur() as $value) :
        $i++;
    ?>
    <tr>
        <td><?php echo $value->ID_secteur?></td>
        <td><?php echo $value->nom_secteur?></td>
        <td><?php echo $value->adresse_secteur?></td>
        
    </tr>

   <?php endforeach?>
<?php
}

?>        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>ID_secteur</td>
            
            
            <td><?php echo $data['Code_secteur']?></td>
        </tr>
        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>nom</td>               
            
            <td>
               <?php echo $data ['nom_secteur'] ?>
            </td>
        </tr>
        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>adresse</td>               
            
            <td>
            <?php echo $data ['adrese_secteur']?>
            </td>
        </tr>
        
        
        
    <?php
        if($ticket->VerifierTicketfermer($_GET['idticket']))
        {
            ?>
            <div class="card-body">

                <h4 class="card-title">Detail sur l'action apres fermeture</h4>
                <!--<h6 class="card-subtitle">Add class <code>.color-table .success-table</code></h6>-->
                <div class="table-responsive">
                    <table class="table color-table success-table">
                <thead>
                     
                    <?php foreach($ticket->AffichageDetail_fermetureTicket($_GET['idticket']) as $value)
                    {
                       ?>
                 
                    <tr>
                        <th>utilisateur</th>
                        <th>Observation</th>
                        <th>Endroit</th>
                        <th>date fermeture</th>
                        
                    </tr>
                    <?php
                }
                ?>
                </thead>
                <tbody>
                    <tr>

                <td><?php echo $value->technicien?></td>
                <td><?php echo $value->observation?></td>
                <td><?php echo $value->endroit?></td>
                <td><?php echo $value->date_fermeture?></td>
                

                      
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
else
{
    if ($ticket->insertionDescription($_GET['idticket'],$_GET['observation'],$_GET['date_fermeture'])) 
    {
        $data = $ticket->recupereTicket($_GET['idticket'])->fetch();
?>
        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>client</td>
            
            
            <td><?php echo $data['Nom_client']?></td>
        </tr>
        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>problem</td>               
            
            <td>
               <?php echo $data ['corp_ticket'] ?>
            </td>
        </tr>
        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>type ticket</td>               
            
            <td>
            <?php echo $data ['type_ticket']?>
            </td>
        </tr>
        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>Description</td>
            
            
            <td>
            <?php
            foreach ($ticket->recupererLesDescription($_GET['idticket']) as $value) 
            {
                echo $value->date_description.'   '.$value->description.'<br>';
            }
            ?>
            </td>
        </tr>
        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>Status</td>
            
            
            <td>
                <?php 
                if($data ['statut'] == 'ouvert')
                {?>
                    <span class="label label-warning"><?= $data ['statut']?></span>
                <?php
                }
                elseif ($data ['statut'] == 'fermer') 
                {?>
                    <span class="label label-succes"><?= $data ['statut']?></span>
                <?php
                }
                ?>
            </td>
        </tr>
        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>nom utulisateur</td>
            
            
            <td>
                
            </td>
        </tr>
        <tr class="footable-even" style="">
            <td><span class="footable-toggle"></span>date creation</td>
            
            
            <td>
                <?php echo $data ['date_creation']?>
            </td>
        </tr>
<?php
    }
}
?>