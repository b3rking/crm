<?php
                            $i=0;
                            foreach ($comptabilite->get_type_extrat() as $value) 
                                {$i++;
                                    ?>
                                     <tr>
                                            <td><?=$value->ID_type_extrat?></td>
                                            <td><?=$value->libelle_extrat?></td>
                                            <td class="text-nowrap">
                                    
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm-<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    
<!-- sample modal content -->
<div class="modal fade bs-example-modal-sm-<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Modifier ce type d'extrat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="refextrat<?= $i?>" value="<?php echo $value->ID_type_extrat?>" hidden>

                <input type="text" id="libelle<?= $i?>" class="form-control" value="<?=$value->libelle_extrat?>">           
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-success" onclick="update_type_extrat($('#refextrat<?= $i?>').val(),$('#libelle<?= $i?>').val())" data-dismiss="modal">Modifier</button>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce type d'extrat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="num_extrat<?= $i?>" value="<?php echo $value->ID_type_extrat?>"hidden >
                Voulez-vous supprimer ce type d'extrat?<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprime_tpe_extrat($('#num_extrat<?= $i?>').val())" data-dismiss="modal">Supprimer</button>
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