<?php
$i =0;

foreach ($ticket->filtreTickets($condition) as $value) 
{
    $i++;
    ?>
    <tr>
        <td><a href="<?=$WEBROOT;?>detailTicket-<?= $value->id?>"><?php echo 'Ticket#'.$value->id;?><a/>
        </td>
        <td><a href="<?=$WEBROOT;?>detailClient-<?= $value->ID_client;?>"><?php echo $value->Nom_client;?><a/>
        </td>
        <td><?php echo $value->created_at?></td>
        <td><?php echo $value->ticket_type?></td>
        <td><?php echo $value->problem?></td>
        <td class="text-wrap"><?php echo $value->description?></td>
        <td><?php echo $value->nom_user?></td>
         <td><?php if($value->status == 'ouvert')
                {
                    ?>
                    <span style="background-color: #ef7f22" class="label label-"><?php echo $value->status?></span>
                    <?php
                }
                elseif($value->status == 'fermer') 
                {?>
                    <span class="label label-success"> <?php echo $value->status?></span>
                <?php   
                }
                ?>
                </td>
                <td class="text-nowrap">
                    <?php 
                    if ($m )
                     {
                      ?>
                    
                    <a href="<?=$WEBROOT;?>detailTicket-<?php echo $value->id?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i>
                    </a>
                    <?php
                      }
                    ?>

                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-md<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                     <?php
                    if ($s) 
                    {
                        ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                    <?php
                        }
                    ?> <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                       <div class="modal-dialog modal-sm<?=$i?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer Ticket</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body"> 
                                    <input type="text" class="form-control" id="idticket<?=$i?>" value="<?php echo $value->id?>" hidden>
                                    Voulez-vous supprimer ce ticket?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn waves-effect waves-light btn btn-dark" onclick="deleteTicket($('#idticket<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
                                </div>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                    

                                    <!-- sample modal content -->
             <div class="modal fade bs-example-modal-md<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-md<?=$i?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">MODIFIER TICKET </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                                 <!-- Debut premiere ligne-->
                   <div class="row">
                          <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <input type="text" id="idticket<?=$i?>" value="<?php echo $value->id?>"class="form-control" hidden>
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
                                <div class="form-group col-sm-9">
                                    <!--input type="text" id="idclientCreerTicket<?=$i?>" value="<?php echo $value->Nom_client?>" class="form-control" disabled-->
                                    <select class="form-control" id="idclientupdateTicket<?=$i?>">
                                        <option value="<?php echo $value->ID_client?>"><?php echo $value->Nom_client?></option>
                                         <?php
                                            foreach ($ticket->getTous_client_surTicket() as $value2) 
                                            {
                                            ?>
                                                <option value="<?=$value2->ID_client?>"><?=$value2->Nom_client?></option>
                                            <?php
                                            }
                                          ?>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label"> Ticket</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" id="type_ticket<?=$i?>" value="<?php echo $value->ticket_type?>" class="form-control"disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" value="<?php echo $value->created_at?>" class="form-control" id="date_ticket<?=$i?>" >
                                    <input type="text" id="page" value="ticket" hidden="hidden">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Probleme</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="probleme<?=$i?>" value="<?php echo $value->problem?>" placeholder="probleme">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <div class="row">
                        </div><!-- END premiere ligne description-->

                        <div class="col-lg-12 col-md-12 form-group">
                            <div class="form-group row">
                                <!--<label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>-->
                                <div class="col-lg-12 col-md-12 form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                                        
                                        <textarea class="form-control" id="des_ticket<?= $i?>"> <?php echo $value->description?></textarea>
                                </div>
                            </div>
                        </div> 
                    </form>
                        </div>
                        <div class="modal-footer">
                            <span id="msg"></span>
                            <button type="button" style="background-color: #8b4513" class="btn text-white waves-effect text-left" onclick="updateTickets($('#idticket<?=$i?>').val(),$('#date_ticket<?=$i?>').val(),$('#probleme<?=$i?>').val(),$('#des_ticket<?=$i?>').val(),$('#idclientupdateTicket<?=$i?>').val())">Modifier ticket
                                        </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </td>
    </tr>

<?php
}

?>