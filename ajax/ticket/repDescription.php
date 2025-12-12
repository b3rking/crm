 <?php
 ob_start();
$donne = $ticket->VerifierTicketfermer($id)->fetch();
$ticketFermer = $donne['status'];
$data = $ticket->recupereTicket($id)->fetch();
 $i=0; foreach($ticket->recupererLesDescription($id) as $value)
                    { $i++;
                    ?>
                       <tr>
                            <td><?=$value->nom_user?></td>
                            <td><?php echo $value->comment//$des = nl2br(wordwrap($value->comment,50,"\n",true))?></td>
                            <td><?php echo $value->created_at?></td>  
                            <td><?php echo $value->means?></td>
                            <td>
                                 <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                                    
                   
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                    <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                       <div class="modal-dialog modal-sm<?=$i?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette description</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body"> 
                                    <input type="text" class="form-control" id="ref<?=$i?>" value="<?php echo $value->id?>" hidden>
                                    Voulez-vous supprimer cette description?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn waves-effect waves-light btn btn-dark" onclick="deleteTicket($('#idticket<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
                                </div>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                    

                                    <!-- sample modal content -->
             <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg<?=$i?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">MODIFIER LA DESCRIPTION </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                           <form class="form-horizontal p-t-20">
                                 <!-- Debut premiere ligne-->
                   <div class="row">
                    
                    <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-6 control-label">Client</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        
                                            <input type="text" class="form-control" value="<?php echo $data['Nom_client']?>" disabled>
                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <input type="text" id="ref<?=$i?>" value="<?php echo $value->id?>"class="form-control" hidden>
                                <label for="exampleInputEmail3" class="col-md-6 control-label">Utilisateur</label>
                                <div class="form-group col-sm-9">
                                   
                                    <select class="form-control" id="informaticien<?=$i?>">
                                          <option value="<?=$value->ID_user?>"><?=$value->nom_user?></option>
                                         <?php
                                            foreach ($user->get_utulisateur() as $value2) 
                                            {
                                            ?>
                                                <option value="<?=$value2->ID_user?>"><?=$value2->nom_user?></option>
                                            <?php
                                            }
                                          ?>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                  <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-6 control-label">Date creation</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        
                                            <input type="text" value="<?php echo $value->created_at?>" class="form-control" id="date_description<?=$i?>" >
                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-md-6 control-label">Endroit</label>
                                <div class="form-group col-sm-9">
                                    <select id="endroit<?=$i?>" class="form-control">
                                            <option value="<?php echo $value->means?>"><?php echo $value->means?></option>
                                            <option value="in_door">In door</option>
                                            <option value="Out_door">Out door</option>
                                        </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 col-md-12 form-group">
                            <div class="form-group row">
                                <div class="col-lg-12 col-md-12 form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                                        
                                        <textarea class="form-control" id="description<?= $i?>"> <?php echo $value->comment?></textarea>
                                </div>
                            </div>
                        </div> 
                    </form>
                        </div>
                        <div class="modal-footer">
                            <span id="msg"></span>
                                      
                                        <button type="button" style="background-color: #8b4513" class="btn text-white waves-effect text-left" onclick="modifier_details_client($('#ref<?=$i?>').val(),$('#informaticien<?=$i?>').val(),$('#date_description<?=$i?>').val(),$('#endroit<?=$i?>').val(),$('#description<?=$i?>').val())">Modifier description
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