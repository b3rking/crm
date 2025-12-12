<div class="table-responsive">
    <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list footable-loaded footable" data-page-size="10">
        <thead>
            <tr>
                <th class="footable-sortable">DETAIL<span class="footable-sort-indicator"></span></th>
                <th class="footable-sortable">CONTENU<span class="footable-sort-indicator"></span></th>
                
            </tr>
        </thead> 0
        

        <tbody>

            <!--ici on appel la fonction ticket selection du ticket a partir de l'ID_ticket et on fait la jointure pour trouver le nom du client-->
            <?php $data = $ticket->recupereTicket($_GET['idticket'])->fetch();?>
              <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Client</td>
                    <td><?php echo 'ID-'.$data['ID_client'].'-'.$data['Nom_client']?></td>
                </tr>
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Probleme</td>
                    <td>
                       <?php echo $data ['problem'] ?>
                    </td>
                </tr>
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Type ticket</td>                               
                    <td>
                    <?php echo $data ['ticket_type']?>
                    </td>
                </tr>    
        </tbody>  
    </table>
</div>
<div class="card">
    <div class="card-body">
        <div class="card-header bg-success">
        <h4 class="m-b-0 text-white">Description</h4>
        </div>
        <!--<h6 class="card-subtitle">Add class <code>.color-table .success-table</code></h6>-->
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Observation</th>
                        <th>Date Creation</th>
                    </tr>
                </thead>
               <tbody>
                    <?php foreach($ticket->recupererLesDescription($_GET['idticket']) as $value)
                    {
                    ?>
                       <tr>
                            <td><?=$value->nom_user?></td>
                            <td><?php echo $value->comment;//$des = nl2br(wordwrap($value->comment,50,"\n",true))?></td>
                            <td><?php echo $value->created_at?></td>                      
                        </tr>
                    <?php
                    }
                    ?>                  
                </tbody>
            </table>
        </div>
    </div>
</div>