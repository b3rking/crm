<?php
ob_start();
?>
<div class="row"> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
            <div class="card-header" style="background-color: #00A86B">
                <span id="msg"></span>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs customtab2" role="tablist">
                <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#detailClient" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Detail Client</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#ticket" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Ticket</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#factures" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Factures</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#stockclient" role="tab" aria-selected="false">
                    <span class="hidden-sm-up"><i class="ti-email"></i></span>
                    <span class="hidden-xs-down">Materiels client</span></a> 
                </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages7" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Messages</span></a> </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="detailClient" role="tabpanel">
                    <div class="p-20">
<?php
    if ($value = $client->afficherUnClentAvecContract($id)->fetch()) 
    {
?>
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            BILLING NUMBER
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
        <?= $value['billing_number']?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            NOM
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            <?= $value['Nom_client']?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            TELEPHONE
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            <?= $value['telephone']?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            EMAIL
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            <?= $value['mail']?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            PERSONNE DE CONTACT
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            <?= $value['personneDeContact']?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            ADRESSE
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            <?= $value['adresse']?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            TYPE
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            <?= $value['type_client']?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            SERVICE/CONNEXION
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            <?= $value['nomService']?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            STATUT
        </div>
        <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            <?= $value['etat']?>
        </div>
    </div>
    <hr>
<?php 
    }
    else
    {
        if ($value = $client->afficherUnClentSansContract($id)->fetch()) 
        {
        ?>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
                    BILLING NUMBER
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
                    <?= $value['billing_number']?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
                    NOM
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
                    <?= $value['Nom_client']?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
                    TELEPHONE
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
                    <?= $value['telephone']?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
                    EMAIL
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
                    <?= $value['mail']?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
                    PERSONNE DE CONTACT
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
                    <?= $value['personneDeContact']?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
                    ADRESSE
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
                    <?= $value['adresse']?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
                    TYPE
                </div>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
                    <?= $value['libelle']?>
                </div>
            </div>
            <hr>
        <?php
        }
    }
?>
                    </div>
                </div>
                <div class="tab-pane p-20" id="ticket" role="tabpanel">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>TICKET</th>
                                    <th>CREATION</th>
                                    <th>DESCRIPTION</th>
                                    <th>TECHNICIEN EN CHARGE</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>TICKET</th>
                                    <th>CREATION</th>
                                    <th>DESCRIPTION</th>
                                    <th>TECHNICIEN EN CHARGE</th>
                                    <th>STATUS</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php 
                                foreach($ticket->recupererTousTicketDunClient($id) as $value)
                                {
                                ?>
                                <tr>
                                    <td><?php echo $value->ID_ticket?></td>
                                    <td><?php echo $value->date_description?></td>
                                    <td><?php echo $value->corp_ticket?></td>
                                    <td><?php echo $value->nom_user?></td>
                                    <td>
                                        <?php if($value->statut=='ouvert')
                                    {
                                        ?>
                                        <span class="label label-danger"><?php echo $value->statut?></span>
                                        <?php
                                    }
                                    elseif($value->statut == 'fermer') 
                                    {?>
                                        <span class="label label-success"> <?php echo $value->statut?></span>
                                    <?php   
                                    }
                                    ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> 
                <div class="tab-pane p-20" id="factures" role="tabpanel">  
                        <?php require_once'vue/admin/facture/contenuFactureOnDetailClient.php';?>
                </div>
                <div class="tab-pane p-20" id="stockclient" role="tabpanel">

    <div class="table-responsive">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    <button type="button" class="btn btn-success d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>attribuer materiel  </button>
                    <!-- Modal -->
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">attibuer equipement</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal p-t-20">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                 <input type="text" id="refclient" value="<?=$id?>" class="form-control"hidden>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group row">
                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Equipement</label>
                                                    <div class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                             <select class="form-control" id="typeEquipement" onchange="getEquipementByType($(this).val())">
                                                              <option value="">faire votre choix</option>
                                                              <option value="antenne">Antenne</option>
                                                              <option value="routeur">Routeur</option>
                                                              <option value="switch">Switch</option>
                                                              
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><div class="col-lg-6" id="divInclutype_equipement"></div>
                                        </div><!-- END ROW-->
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6"hidden>
                                                <div class="form-group row">
                                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label><div class="col-sm-9">
                                                        <div class="input-group">

                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"></span>
                                                            </div>
                                                            <input type="text" id="datedistribution" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" class="form-control"> 
                                                            <input type="text" id="attributeur"  value="<?php echo $_SESSION['ID_user']?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- END ROW-->
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <span id="msg"></span>
                                    <button type="button" class="btn btn-success" onclick="attribuer_equipement_client($('#refclient').val(),$('#typeEquipement').val(),$('#datedistribution').val(),$('#attributeur').val())"> <i class="fa fa-check"></i> Attribuer</button>
                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!--/.modal-dialog -->
                    </div>
                </div>
            </div>
        </div>
        <table id="myTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                 <th>Client</th>
                   <th>Equipement</th>
                   <th>Date</th>
               </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Client</th>
                   <th>Equipement</th>
                   <th>Date</th>
               </tr>
            </tfoot>
            <tbody>
                <?php 
                foreach($equipement->getEquipementAttribuerAunClient($id) as $value)
                {
                ?>
                <tr>
                    <td><?php echo $value->Nom_client?></td>
                    <td><?php echo $value->type_equipement?></td>
                    <td><?php echo $value->date_attribution_equip?></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
                </div>
                <div class="tab-pane p-20" id="messages7" role="tabpanel">3</div>
            </div>
            </div>
        </div>

        <!--<div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <input type="text" id="idClient" value="<?=$id?>" hidden="hidden">
                        <a class="nav-link" href="javascript:void(0)" onclick="detailClient($('#idClient').val())">Detail Client</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="recupererTicketDunClient($('#idClient').val())">Ticket</a>
                    </li>
                </ul>
            </div>
            <div class="card-body" id="detailClient-body">

            </div>
        </div>-->
    </div>
</div>
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>