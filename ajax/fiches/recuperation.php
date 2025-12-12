<?php
require_once("../../model/connection.php");
require_once("../../model/ticket.class.php");

$ticket = new ticket();
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <form action="/crm.buja/fiche_de_recuperation" method="post" class="form-horizontal p-t-20">
               <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
                            <div class="form-group col-sm-9">
                                <input type="text" id="idclient" name="idclient" class="form-control" autocomplete="off">
                                    <div id="modal"></div>
                            </div>
                        </div>
                    </div>
                      <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date de recuperation : </label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="dates" id="dates">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5 col-md-3 col-lg-3 col-xlg-3 offset-4">
                        <button  type="submit" class="btn btn-dribbble waves-effect btn-rounded waves-light" >Generer Fiche </button>
                    </div>
               </div>
                </form>
                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Creation</th>
                                <th>Date demenagement</th>
                                <th>Client</th>
                                <th>Statut</th>
                                <th></th>    
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Creation</th>
                                <th>Date recuperation</th>
                                <th>Client</th>
                                <th>Statut</th>
                                <th></th> 
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                                <?php
                                $i =0;
                                foreach ($ticket->recupererFicheRecuperations() as $value) 
                                {
                                    $i++;
                                    ?>
                                    <tr>
                                <td><?php echo $value->date_creation?></td>
                                <td>
                                    <?php echo $value->dateRecuperation;?>
                                </td>
                                <td><?php echo $value->Nom_client;?></td>
                                <td><?php if($value->status=='ouvert')
                                {
                                    ?>
                                    <span class="label label-danger"><?php echo $value->status?></span>
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
                                    <a href="/crm.buja/regenficherecuperation-<?php echo $value->ID_fiches?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>
                                </td>
                            </tr>

                           <?php
                                }
                            ?><!-- END FOREACH-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>