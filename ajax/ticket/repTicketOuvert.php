<?php
$data = $ticket->recupereTicket($_GET['idticket'])->fetch();
?>
<div class="table-responsive">
        <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list footable-loaded footable" data-page-size="10">
            <thead>
                <tr>
                    <th class="footable-sortable">DETAIL<span class="footable-sort-indicator"></span></th>
                    <th class="footable-sortable">CONTENU<span class="footable-sort-indicator"></span></th>
                    
                </tr>
            </thead>

            <tbody>
                 <!-- Example single danger button -->
                 <button type="button" style="background-color: #8b4513" class="btn btn-" onclick="" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-check" ></i>nouvelle action de ticket</button>
                
                 <!--ton type="button" class="btn waves-effect waves-light btn-rounded btn-warning">autre description</button> -->  
                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Nouvelle action</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>

                            <div class="modal-body">
                      <form class="form-horizontal p-t-20">

        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="form-group row" >
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Endroit</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                <select id="endroit" class="form-control"><option value="in door">In door</option>
                                        <option value="Out door">Out door</option>
                                        </select>
                                <input type="text" id="idticket" class="form-control" value="<?php echo $id?>" hidden>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="col-lg-6 ">
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" id="user" value="<?=$_SESSION['ID_user']?>" hidden>
                            <input type="text" value="<?php $d = new DateTime();echo $d->format('Y-m-d H:i:s');?>" class="form-control" id="date_fermeture" hidden>
                            </div>
                        </div>
                    </div>
                </div>
                        
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 form-group">
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                        <textarea rows="5" cols="2" maxlength="180"  class="form-control " id="observation" placeholder="Description           ici..."></textarea>
                        <input type="text" id="type_ticket" value="<?= $data['type_ticket']?>" hidden>
                        <input type="text" id="id_client" value="<?=$data['ID_client']?>" hidden>
                    </div>
                </div>    
            </div>
            <div class="row">
                <label class="btn btn-info active">
                    <input type="checkbox" id="dernierAction"> dernière action
                </label> 
            </div>
                                                          
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-info" onclick="fermerTicket($('#idticket').val(),$('#user').val(),$('#observation').val(),$('#endroit').val(),$('#date_fermeture').val(),$('#type_ticket').val(),$('#id_client').val())" data-dismiss="modal">Enregistrer
                                </button>
                                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>        
                <!--ici on appel la fonction ticket selection du ticket a partir de l'ID_ticket et on fait la jointure pour trouver le nom du client-->
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Client</td>
                    
                    
                    <td><?php echo 'ID-'.$data['ID_client'].'-'.$data['Nom_client']?></td>
                </tr>
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Probleme</td>               
                    
                    <td>
                       <?php echo $data ['corp_ticket'] ?>
                    </td>
                </tr>
                <tr class="footable-even" style="">
                    <td><span class="footable-toggle"></span>Type ticket</td>                               
                    <td>
                    <?php echo $data ['type_ticket']?>
                    </td>
                </tr>       
            </tbody>  
        </table>
    </div>
<div class="card">
    <div class="card-body">
    <div class="card-header bg-danger">
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
                        <td><?php echo $des = nl2br(wordwrap($value->description,50,"\n",true))?></td>
                        <td><?php echo $value->date_description?></td>                      
                    </tr>
                <?php
                }
                ?>                  
            </tbody>
        </table>
        </div>
    </div>
</div>