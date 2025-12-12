<?php 
    $i = 0;
    $y = 0; 
    foreach($contract->afficherContracts() as $value)
    {
        $i++;
    ?>
    <tr>
        <td>
            <a class="dropdown-item" href="<?= $webroot;?>detailContract-<?= $value->ID_contract;?>"> <?php echo $value->ID_contract;?></a>
        </td>
        <td><a href="<?= $webroot;?>detailClient-<?= $value->ID_client;?>"> <?php echo $value->Nom_client;?></a></td>
        <td><?= $value->type?> </td>
        <td><?= $value->montant+$value->prixTva.' '.strtoupper ($value->monnaie)?></td>
        <td><?= $value->monnaie?></td>
        <td><?php echo $value->date_creation?></td>
        <td>
            <?php
            foreach ($contract->getServiceToPrintToContract($value->ID_contract) as $value2) {
                echo $value2->NomService.', ';
             } 
            ?>
        </td>
        <td><?= $value->etat?></td>
        <td class="text-nowrap">
            <a href="<?= $webroot;?>detailContract-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>
            <a href="<?= $webroot;?>printContract-<?= $value->ID_contract;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>
            
           
                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                  
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modification d'un contract</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Contrat</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <input type="text" class="form-control" id="numero<?=$i?>" value="<?php echo $value->ID_contract;?>" hidden>
                                                    <select id="monnaie<?=$i?>" class="form-control">
                                                        <option value="<?php echo $value->monnaie;?>"><?php echo $value->monnaie;?></option>
                                                        <option value="FC">FC</option>
                                                        <option value="USD">USD</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Facture</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <input type="text" class="form-control" id="numero<?=$i?>" value="<?php echo $value->ID_contract;?>" hidden>
                                                    <select id="monnaie_facture<?=$i?>" class="form-control">
                                                        <option value="<?php echo $value->monnaie;?>"><?php echo $value->monnaie_facture;?></option>
                                                        <option value="FC">FC</option>
                                                        <option value="USD">USD</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mode</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <select id="mode<?=$i?>" class="form-control">
                                                        <option value="<?php echo $value->mode;?>"><?php echo $value->mode;?></option>
                                                        <option value="mail">via mail</option>
                                                        <option value="imprimer">Imprimer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End row-->

                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Etat</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <select id="etat<?=$i?>" class="form-control">
                                                        <option value="<?php echo $value->etat;?>"><?php echo $value->etat;?></option>
                                                        <option value="activer">Activer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <input type="text" id="client<?=$i?>" value="<?php echo $value->ID_client;?>" hidden>
                                                    <input type="text" class="form-control" value="<?php echo $value->Nom_client;?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End row-->
                                <hr>

<?php 
$j = 0;
foreach ($contract->getServiceToPrintToContract($value->ID_contract) as $value3) 
{
    $j++;
    $y++;
?>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">
                Service</label><div class="form-group col-sm-9">
                    <select class="form-control" id="service<?=$y?>">
                        <option value="<?=$value3->ID_service.'_'.$value3->montant?>"><?=$value3->nomService?></option>
                        <?php
                        foreach ($service->recupererServices() as $val) 
                        {
                        ?>
                            <option value="<?=$val->ID_service.'_'.$val->montant?>"><?=$val->nomService?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <!--<input type="text" id="service<?=$y?>" value="<?=$value3->ID_service?>" hidden>
                    <input type="text" class="form-control" value="<?=$value3->nomService?>">-->
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-3">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Bande passante</label>
                <div class="form-group col-sm-9 col-lg-8"><input type="text" class="form-control" id="bandepassante<?=$y?>" value="<?=$value3->bandepassante?>"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-2 control-label">Client</label><div class="form-group col-sm-9 col-lg-10">
                    <input type="text" id="sous_client<?=$y?>" value="<?=$value3->ID_client?>" hidden>
                    <input type="text" class="form-control" id="nom_client<?=$y?>" value="<?=$value3->nom_client?>" disabled></div>
            </div>
        </div>
    </div>
    <hr>
<?php
}
?>
<input type="number" id="nombreServiceUpdate<?=$i?>" value="<?=$j?>" hidden>
<input type="number" id="i<?=$i?>" value="<?=$i?>" hidden>
<input type="number" id="id_dernierService<?=$i?>" value="<?=$y?>" hidden>

                                <div class="row">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Periode de facturation</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                   <select id="facturation<?=$i?>" class="form-control">
                                                    <option value="<?php echo $value->facturation;?>"><?php echo $value->facturation;?></option>
                                                   </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Debut consomassion</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                    <input type="date" id="startDate<?=$i?>" class="form-control" value="<?php echo $value->startDate;?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Tva</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="tva<?=$i?>" value="<?php echo $value->tva;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End row -->
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success  waves-effect" onclick="updateContract($('#numero<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#monnaie_facture<?=$i?>').val(),$('#mode<?=$i?>').val(),$('#etat<?=$i?>').val(),$('#client<?=$i?>').val(),$('#facturation<?=$i?>').val(),$('#startDate<?=$i?>').val(),$('#tva<?=$i?>').val(),$('#i<?=$i?>').val(),$('#id_dernierService<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>Enregistrer
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->


        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
  
        <!-- sample modal content -->
        <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">Supprimer Contract</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body"> 
                        <input type="text" class="form-control" id="deleteContractNum<?= $i?>" value="<?=$value->ID_contract?>" hidden>
                        Voulez-vous supprimer ce contract?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteContract($('#deleteContractNum<?= $i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
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