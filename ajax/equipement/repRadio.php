<?php 
$i =0;
foreach($equipement->recupereRadio() as $value)
{
    $i++;
?>
    <tr>
       
        <td><?php echo $value->fabriquant?> </td>
        <td><?php echo $value->type_equipement?></td>
        <td><?php echo $value->model?></td>
        <td>
            <?php
                foreach ($equipement->recupereMacAdresses($value->ID_equipement) as $mac) 
                {
                    echo "$mac->mac <br>";
                }
            ?>
        </td>
        <td><?=$value->date_stock?></td> 
        <td>
        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

        <!-- sample modal content -->
        <div class="modal fade bs-example-modal-lgs<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lgs">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myLargeModalLabel">Modification secteur</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal p-t-20">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Fabriquant </label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"></span>
                                                </div>
                                                <input type="text" id="id<?=$i?>" value="<?php echo $value->ID_equipement?>" class="form-control"hidden >
                                                <input type="text" id="type_equipement<?=$i?>" value="<?php echo $value->type_equipement?>" class="form-control" hidden>
                                                <input type="text" id="fabriquant<?=$i?>" class="form-control" value="<?php echo $value->fabriquant?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">adresse mac</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                <input type="text" class="form-control" id="mac<?=$i?>" value="<?php echo "$mac->mac "?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Model</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                                <input type="text" id="model<?=$i?>" value="<?php echo $value->model?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- END ROW--> 
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="updateRadio($('#id<?=$i?>').val(),$('#type_equipement<?=$i?>').val(),$('#model<?=$i?>').val(),$('#fabriquant<?=$i?>').val(),$('#mac<?=$i?>').val())"> <i class="fa fa-check"></i>
                         Modifier radio
                        </button>
                        <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>

        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

        <!-- sample modal content -->
        <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="mySmallModalLabel">Supprimer radio M2</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body"> 
                        <input type="text" class="form-control" id="idequipement<?=$i?>" value="<?php echo $value->ID_equipement?>" hidden>
                        Voulez-vous supprimer cette radio M2?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerRadio($('#idequipement<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i>
                        </button>
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