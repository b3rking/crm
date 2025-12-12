<?php
    if (isset($filtreProspect)) 
    {
        $i =0;
        foreach ($marketing->filtreProspect($condition) as $value)
        {
            $i++;
            ?>
            <tr>
            <td><?php echo $value->ID_prospect?></td>
            <td> <?php echo $value->nom?></td>
            <td><?php echo $value->entreprise?></td>
            <td><?php echo $value->telephone?></td>
            <td><?php echo $value->adresseProspect?></td>
            <td><?php echo $value->mail?></td>
            <td><?php echo $value->dateProspection?></td>
            <td><?php echo $value->rendezvous?></td>
            <td>
            <?php if($value->etatduProspect =='attente')
            {
                ?>
                <span style="background-color:#ef7f22; "class="label text-white"><?php echo $value->etatduProspect?></span>
                <?php
            }
            elseif ($value->etatduProspect =='valider') 
                {
                    ?>
                <span class="label label-success"><?php echo $value->etatduProspect?></span>
                <?php
            }
            elseif ($value->etatduProspect =='annuler') 
                {?>
                <span class="label label-danger"><?php echo $value->etatduProspect?></span>
            <?php        
            }
           ?>
            </td>
         
            <td class="text-nowrap">
    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i>
        
      <?php
        $detail = $marketing->prospect_deja_visiter($value->ID_prospect)->fetch(); 
        if ($detail['ID_prospect'] != "") 
        {
            ?>
            <a href="<?=WEBROOT;?>detailprospect-<?php echo $value->ID_prospect?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i></a>
           <?php
        }
        else
        {
            //echo "pas de visite";
        }
                                    ?>


    </a>
    <!-- sample modal content -->
    <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">Modifier ce prospect</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
    <div class="modal-body">
        <form class="form-horizontal p-t-20">
    <div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom </label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"></span>
                    </div>
                    <input type="text" id="numprospect<?=$i?>" class="form-control" value="<?php echo $value->ID_prospect?>"hidden>
                    <input type="text" id="nomprospect<?=$i?>" class="form-control" value="<?php echo $value->nom?>">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
    <div class="form-group row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Adresse</label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                <input type="text" id="adresprospect<?=$i?>" class="form-control" value="<?php echo $value->adresseProspect?>">
            </div>
       </div>
    </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-3 control-label">Telephone</label>
            <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                <input type="text" id="phoneprospect<?=$i?>" class="form-control" value="<?php echo $value->telephone?>">
             
            </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-3 control-label">mail</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                    <input type="email" id="mailprospect<?=$i?>" class="form-control" value="<?php echo $value->mail?>">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-3 control-label">entreprise</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                    <input type="text" id="entreprise<?=$i?>" class="form-control" value="<?php echo $value->entreprise?>">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-3 control-label">rendez vous</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                    <input type="text"  id="rdv<?=$i?>" class="form-control" value="<?php echo $value->rendezvous?>">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-3 control-label">date</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                    <input type="date" id="dateprospection<?=$i?>" class="form-control" value="<?php echo $value->dateProspection?>">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
    <div class="form-group row">
    <label for="exampleInputuname3" class="col-sm-3 control-label">commentaire</label>
    <div class="col-sm-9">
    <div class="input-group">
    <div class="input-group-prepend"><span class="input-group-text"></span></div>
    <textarea name="comment" id="commentaire<?=$i?>" class="form-control"><?php echo $value->commentaire?></textarea>

    </div>
    </div>
    </div>
    </div>
    </div><!-- END ROW-->
    </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-success" onclick="updateProspect($('#numprospect<?=$i?>').val(),$('#nomprospect<?=$i?>').val(),$('#adresprospect<?=$i?>').val(),$('#phoneprospect<?=$i?>').val(),$('#mailprospect<?=$i?>').val(),$('#entreprise<?=$i?>').val(),$('#rdv<?=$i?>').val(),$('#dateprospection<?=$i?>').val(),$('#commentaire<?=$i?>').val())" data-dismiss="modal">Modifier
        </button>
        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
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
            <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce prospect</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body"> 
        <input type="text" class="form-control" id="numprospect<?= $i?>" value="<?php echo $data->ID_prospect?>" hidden>
        Voulez-vous supprimer ce prospect?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerProspect($('#numprospect<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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
    }
    else
    {
        $i =0;
    foreach ($marketing->afficheProspect () as $value)
    {
        $i++;
        ?>
        <tr>
        <td><?php echo $value->ID_prospect?></td>

        <td> <?php echo $value->nom?></td>
        <td><?php echo $value->entreprise?></td>
        <td><?php echo $value->telephone?></td>
        <td><?php echo $value->adresseProspect?></td>
        <td><?php echo $value->mail?></td>
        <td><?php echo $value->dateProspection?></td>
        <td><?php echo $value->rendezvous?></td>
       

        <td>
            <?php if($value->etatduProspect =='attente')
        {
            ?>
            <span class="label label-warning"><?php echo $value->etatduProspect?></span>
            <?php
        }
        elseif ($value->etatduProspect =='valider') 
            {
                ?>
            <span class="label label-success"><?php echo $value->etatduProspect?></span>
            <?php
        }
        elseif ($value->etatduProspect =='annuler') 
            {?>
            <span class="label label-danger"><?php echo $value->etatduProspect?></span>
        <?php        
        }
       ?>
        </td>
     
        <td class="text-nowrap">
<a href="/crm.spi.uva/detailprospect-<?php echo $value->ID_prospect?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i></a>
<?php
if ($value->etatduProspect != 'valider') 
{
?>
    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
<?php
}
?> 

<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myLargeModalLabel">Modifier ce prospect</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
<div class="modal-body">
    <form class="form-horizontal p-t-20">
<div class="row">
<div class="col-lg-6 col-md-6">
    <div class="form-group row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom </label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"></span>
                </div>
                <input type="text" id="numprospect<?=$i?>" class="form-control" value="<?php echo $value->ID_prospect?>"hidden>
                <input type="text" id="nomprospect<?=$i?>" class="form-control" value="<?php echo $value->nom?>">
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-6">
<div class="form-group row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Adresse</label>
    <div class="col-sm-9">
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"></span></div>
            <input type="text" id="adresprospect<?=$i?>" class="form-control" value="<?php echo $value->adresseProspect?>">
        </div>
   </div>
</div>
</div>
<div class="col-lg-6 col-md-6">
    <div class="form-group row">
        <label for="exampleInputuname3" class="col-sm-3 control-label">Telephone</label>
        <div class="col-sm-9">
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"></span></div>
            <input type="text" id="phoneprospect<?=$i?>" class="form-control" value="<?php echo $value->telephone?>">
        </div>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-6">
    <div class="form-group row">
        <label for="exampleInputuname3" class="col-sm-3 control-label">mail</label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                <input type="email" id="mailprospect<?=$i?>" class="form-control" value="<?php echo $value->mail?>">
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-6">
    <div class="form-group row">
        <label for="exampleInputuname3" class="col-sm-3 control-label">entreprise</label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                <input type="text" id="entreprise<?=$i?>" class="form-control" value="<?php echo $value->entreprise?>">
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-6">
    <div class="form-group row">
        <label for="exampleInputuname3" class="col-sm-3 control-label">rendez vous</label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                <input type="date"  id="rdv<?=$i?>" class="form-control" value="<?php echo $value->rendezvous?>">
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-6">
    <div class="form-group row">
        <label for="exampleInputuname3" class="col-sm-3 control-label">date</label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text"></span></div>
                <input type="date" id="dateprospection<?=$i?>" class="form-control" value="<?php echo $value->dateProspection?>">
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-6">
<div class="form-group row">
<label for="exampleInputuname3" class="col-sm-3 control-label">commentaire</label>
<div class="col-sm-9">
<div class="input-group">
<div class="input-group-prepend"><span class="input-group-text"></span></div>
<textarea name="comment" id="commentaire<?=$i?>" class="form-control"><?php echo $value->commentaire?></textarea>

</div>
</div>
</div>
</div>
</div><!-- END ROW-->
</form>
</div>
<div class="modal-footer">
    <button class="btn btn-success" onclick="updateProspect($('#numprospect<?=$i?>').val(),$('#nomprospect<?=$i?>').val(),$('#adresprospect<?=$i?>').val(),$('#phoneprospect<?=$i?>').val(),$('#mailprospect<?=$i?>').val(),$('#entreprise<?=$i?>').val(),$('#rdv<?=$i?>').val(),$('#dateprospection<?=$i?>').val(),$('#commentaire<?=$i?>').val())" data-dismiss="modal">Modifier
    </button>
    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
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
        <h4 class="modal-title" id="mySmallModalLabel">Supprimer ce prospect</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body"> 
    <input type="text" class="form-control" id="numprospect<?= $i?>" value="<?php echo $data->ID_prospect?>" hidden>
    Voulez-vous supprimer ce prospect?
    </div>
    <div class="modal-footer">
        <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerProspect($('#numprospect<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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
    }

    ?>
                              