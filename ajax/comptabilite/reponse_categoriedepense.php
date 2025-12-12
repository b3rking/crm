<?php
$i =0;
foreach ($comptabilite->getCategorieDepenses() as $value) 
{$i++;
?>
<tr>
    <td><?=$value->ID_categorie_depense?></td>
    <td><?=$value->description?></td>
    <td><?=$value->type_categorie?></td>
    <td class="text-nowrap">

<a href="javascript:void(0)" data-toggle="modal" data-target="#responsive-modal<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

<!-- sample modal content -->
<div id="responsive-modal<?=$i?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modification de la categorie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                              <label for="exampleInputuname3" class="col-sm-3 control-label">Libelle categorie:</label>
                              <div class="col-sm-9"> 
                                <input type="text" class="form-control" id="description<?=$i?>" value="<?=$value->description?>">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Type categorie:</label>
                                <div class="col-sm-9"> 
                                <select class="form-control" id="type_categorie<?=$i?>">
                                    <?php
                                    if ($value->type_categorie == 'Fonctionnement') 
                                    {
                                    ?>
                                        <option value="Fonctionnement" selected="">Fonctionnement</option>
                                        <option value="Investissement">Investissement</option>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <option value=""></option>
                                        <option value="Fonctionnement">Fonctionnement</option>
                                        <option value="Investissement" selected="">Investissement</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <input type="text" class="form-control" id="idCategorie<?= $i?>" value="<?php echo $value->ID_categorie_depense?>" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect waves-light" onclick="updateCategorieDepense($('#idCategorie<?=$i?>').val(),$('#type_categorie<?=$i?>').val(),$('#description<?=$i?>').val())" data-dismiss="modal">Modifier</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Fermer</button>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer la categorie</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="numcategorie<?= $i?>" value="<?php echo $value->ID_categorie_depense?>"hidden >
                Voulez-vous supprimer cette categorie?<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimeCategorie($('#numcategorie<?= $i?>').val())" data-dismiss="modal">Supprimer</button>
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