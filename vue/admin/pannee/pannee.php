<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('ticket',$_SESSION['ID_user'])->fetch()) 
{
    if ($d['L'] == 1) 
    {
        $l = true;
    }
    if ($d['C'] == 1) 
    {
        $c = true;
    }
    if ($d['M'] == 1) 
    {
        $m = true;
    }
    if ($d['S'] == 1) 
    {
        $s = true;
    }
}
?>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="l" value="<?=$l?>" hidden="">
<input type="text" id="c" value="<?=$c?>" hidden="">
<input type="text" id="m" value="<?=$m?>" hidden="">
<input type="text" id="s" value="<?=$s?>" hidden="">
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body" id="responsive">
            <!-- sample modal content -->
             <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau ticket</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                                 <!-- Debut premiere ligne-->
                   <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-1 col-md-2 control-label">Client*</label>
                                <div class="form-group col-sm-9 col-lg-11 col-md-9">
                                    <!--<input type="text" id="idclientCreerTicket" class="form-control" autocomplete="off">
                                    <div id="modalCreerTicket"></div>-->
                                    <input id="seachCustomerTicket" class="form-control form-control-sm" placeholder="--filtrer par code ou par nom--">
                                    <select id="selectCustomerTicket" class="form-control" size="3">
                                        <?php
                                            foreach ($client->getClientToCreateTicket() as $value) 
                                            {
                                        ?>
                                                <option value="<?=$value->ID_client?>">
                                                    <?=$value->Nom_client.' -- code: '.$value->billing_number?>
                                                </option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!--<div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Connexion</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" id="con" class="form-control" disabled="">
                                    <!-<select class="form-control" id="con" onclick="recupererServiceDunClient($('#idclient').val())">
                                        <option value=""></option>
                                    </select>--
                                    <input type="text" id="page" value="ticket" hidden="hidden">
                                </div>
                            </div>
                        </div>-->
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Probleme*</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="probleme" placeholder="probleme">
                                        <!--<input type="text" value="<php $d = new DateTime();echo $d->format('Y-m-d H:i:s');?>" class="form-control" id="dates" hidden>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label"> Ticket*</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" id="type_ticket" class="form-control" value="depannage" disabled>
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
                                        <textarea rows="5"  class="form-control " id="description"  placeholder="Description           ici..."></textarea>
                                        <input type="text" id="idUser" value="<?= $_SESSION['ID_user']?>" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                        </div>
                      
                        <div class="modal-footer">
                            <span id="msg"></span>
                            <button type="button"  class="btn btn-chocolate text-white waves-effect text-left" onclick="saveTicket($('#selectCustomerTicket').val(),$('#type_ticket').val(),$('#probleme').val(),$('#description').val(),$('#idUser').val())">Creer ticket
                                        </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <div class="row m-t-0">
                    <!-- Column -->
            <div class="col-md-3 col-lg-3 col-xlg-3">
                <div class="card">
                    <div style="background-color: #8b4513" class="box bg- text-center">
                        <h7 class="font-light text-white"><button type="button" style="background-color: #8b4513"class="btn btn-sm btn-rounded btn- text-white" onclick="//afficheToustickets()">TOTAL <?php $data =$ticket->ticketTotal()->fetch();echo $data['nb'];?></button></h7>
                    </div>
                </div>
            </div>

        <div class="col-md-3 col-lg-3 col-xlg-3">
        <div class="card">
            <div style="background-color: #ef7f22" class="box bg- text-center text-white">
                <h7 class="font-light text-white"><button type="button" style="background-color: #ef7f22" class="btn btn-sm btn-rounded btn- text-white" onclick="recupereTousTicketParStatut('ouvert')">OUVERT <?php $data =$ticket->ticketAtendu()->fetch();echo $data['ch'];?></button></h7>
            </div>
        </div>
        </div>
        <!-- Column -->
        <div class="col-md-3 col-lg-3 col-xlg-3">
            <div class="card">
                <div class="box bg-success text-center">
                    <h7 class="font-light text-white"><button type="button" class="btn btn-sm btn-rounded btn-success" onclick="recupereTousTicketParStatut('fermer')">FERMER <?php $data =$ticket->ticketRepondu()->fetch();echo $data['nb'];?></button></h7>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 offset-1">
            <?php
            if ($c) 
            {?>
                <button type="button" style="background-color: #8b4513" class="btn  d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Ajouter ticket</button>
            <?php
            }
            ?>
        </div>
        </div>
        <form action="<?=WEBROOT?>filtreTickets" method="get" id="filtreTickets">
        <div class="row">
            <div class="col-lg-1 col-md-2">
                <div class="form-group">
                    <input type="text" name="idticket" value="<?=$idticket?>" id="idticket" class="form-control input-filter" placeholder="ID TICKET">
                </div>
            </div>
            <div class="col-lg-2 col-md-2">
                <div class="form-group">
                    <input type="text" name="nom_client" value="<?=$nom_client?>" id="idclientFiltreTicket" class="form-control input-filter" placeholder="Nom client">
                    <!--<div id="modalFiltreTicket"></div>-->
                </div>
            </div>
            <div class="col-lg-2 col-md-1">
                <div class="form-group">
                    <select id="type_ticketFiltre" name="type_ticket"  class="form-control input-filter">

                        <option value="">Type ticket</option>
                        <?php
                            foreach ($ticket->recupererTypeTickets() as $value) 
                            {
                                if ($value->ticket_type == $type_ticket ) 
                                    {
                                        ?>

                                <option value="<?=$value->ticket_type?>" selected><?=$value->ticket_type?></option>
                                    <?php
                                }
                                else
                                {
                                     ?>
                                <option value="<?=$value->ticket_type?>"><?=$value->ticket_type?></option>
                        <?php
                                }
                       
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-md-1 col-sm-3">
                <div class="form-group">
                    <input type="date" class="form-control input-filter" value="<?=$date1?>"  id="date1" name="date1">
                </div>
            </div>
            <div class="col-lg-2 col-md-1 col-sm-3">
                <div class="form-group">
                    <input class="form-control input-filter" type="date" id="date2" value="<?=$date2?>" name="date2">
                    <input type="text" name="status" value="<?=$status?>" id="status_filtre" hidden="">
                    <input type="text" name="print" id="print" value="0" hidden="">
                </div>
            </div>
            <div class="col-lg-1 col-md-1">
               <button type="submit" style="background-color: #7c4a2f" class="btn waves-effect waves-light btn- text-white btn-sm " >filtrer<i class="ti ti-filter"></i></button></div>
                <div class="col-lg-1 col-md-1">
                        <button type="submit"style="background-color: #8b4513" class="btn waves-effect waves-light btn- btn-sm text-white"onclick="submitRapportticket()"><i class="mdi mdi-printer"></i> Print</button>
                    </div>

            <div class="col-lg-1 col-md-1">
                <button type="button" class="btn waves-effect waves-light btn- btn-sm btn-dark" onclick="resetFiltreTicket()"><i class="mdi mdi-refresh"></i> Reset</button>
            </div>
        </div>
    </form>
         <div class="table-responsive m-t-0">
              <table id="myTable" class="table table-color-table warning-tabletable-striped" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>TICKET</th> 
                        <th>CLIENT</th>
                        <th>CREATION</th>
                        <th>TYPE</th>
                        <th>PROBLEME</th>
                        <th>DESCRIPTION</th>
                        <th>TECHNICIEN</th>
                        <th>ETAT</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>TICKET</th>
                        <th>CLIENT</th>
                        <th>CREATION</th>
                        <th>TYPE</th>
                        <th>PROBLEME</th>
                        <th>DESCRIPTION</th>
                        <th>TECHNICIEN</th>
                        <th>ETAT</th>
                        <th>ACTION</th>
                    </tr>
                </tfoot>
                <tbody id="rep" class="font-size" style="font-size: 16" style="font-family: Times New Roman">
                <?php
                    $i =0;
                    foreach ($result as $value) 
                        {
                            $i++;
                        ?>
                    <tr>
                        <td><a href="<?=WEBROOT;?>detailTicket-<?= $value->id?>"><?php echo 'Ticket#'.$value->id;?><a/>
                        </td>
                        <td><a href="<?=WEBROOT;?>detailClient-<?= $value->ID_client;?>"><?php echo $value->Nom_client;?><a/>
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
                                    
                                    <a href="<?=WEBROOT;?>detailTicket-<?php echo $value->id?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i>
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
                            <!--button type="button" style="background-color: #8b4513" class="btn text-white waves-effect text-left" onclick="updateTickets($('#idticket<?=$i?>').val(),$('#date_ticket<?=$i?>').val(),$('#probleme<?=$i?>').val(),$('#des_ticket<?=$i?>').val())">Modifier ticket
                                        </button-->
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
                    ?><!-- END FOREACH-->
                </tbody>
        </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
    $home_admin_content = ob_get_clean();
        require_once('vue/admin/home.admin.php');
?>
