 <?php
                    $i =0;
                    foreach ($ticket->recupererFicheInstallations() as $value) 
                    {
                        $i++;
                        ?>
                <tr>
                    <td><?php echo $value->date_creation?></td>
                    <td>
                        <?php echo $value->dateInstallation;?>
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
                       
                            <a href="<?=WEBROOT?>regenficheinstallation-<?php echo $value->ID_fiches?>" data-toggle="tooltip" data-original-title="Print"> <i class="icon-printer text-inverse m-r-10"></i> </a>
                           
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer fiche"> <i class="ti-trash text-inverse m-r-10"></i></a>
                        <!-- sample modal content -->
             <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                     <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette fiche</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="idfiche<?= $i?>" value="<?php echo $value->ID_fiches?>"hidden >
                Voulez-vous supprimer cette fiche ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-dark" onclick="supprimer_fiche($('#idfiche<?=$i?>').val(),$('#userName').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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