<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

$comptabilite = new Comptabilite();

$i =0;
foreach ($comptabilite->filtreDepenses($_GET['condition']) as $value) 
{
$i++;?>
<tr>
    <td><?php echo $value->datedepense?></td>
    <td><?php echo number_format($value->montantdepense).' '.$value->monnaie?></td>
    <td><?php echo $value->motifdepense?></td>
    <td><?=$value->description?></td>
    <td><?php
    if ($value->provenance == 'caisse') 
    {
        $caisse = $comptabilite->getCaisse($value->ID_caisse)->fetch();
        echo $caisse['nomCaisse'];
    }
    else
    {
        $banque = $comptabilite->getBanque($value->ID_banque)->fetch();
        echo $banque['nom'];
    }   
    ?></td>
    <td><?php echo $value->reference?></td>
    <td class="text-nowrap">
        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"><i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier cette depense</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal p-t-20">
<!--<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-3 control-label">Montant</label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input type="text" id="montantdep<?=$i?>" class="form-control" value="<php echo $value->montantdepense?>">
                    <div class="input-group-prepend"><span class="input-group-text"><?=$value->monnaie?></span></div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<div class="form-group row">
    <label for="exampleInputuname3" class="col-sm-3 control-label">Banque</label>
    <div class="col-sm-9">
        <input type="text" name="oldBanque<?=$i?>" id="oldBanque<?=$i?>" value="<?=$data->ID_banque?>" hidden>
        <select class="form-control" id="banque<?=$i?>">
            <?php 
            foreach ($comptabilite->getBanqqueActive() as $data)
            {
                if ($value->ID_banque == $data->ID_banque) 
                {
            ?>
                    <option value="<?php echo $data->ID_banque."_".$data->montant."_".$data->monnaie?>" selected><?php echo $data->nom . "_" . $data->monnaie?>
                    </option>
            <?php
                }
                else
                {
            ?>
                    <option value="<?php echo $data->ID_banque."_".$data->montant."_".$data->monnaie?>"><?php echo $data->nom . "_" . $data->monnaie?>
                    </option>
            <?php
                }
            }
            ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-3 control-label">Reference </label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="reference<?=$i?>" value="<?=$value->reference?>" placeholder="numero de cheque">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputuname3" class="col-sm-3 control-label">Montant </label>
            <div class="col-sm-9">
                <input type="number" class="form-control" id="montantDepense<?=$i?>" value="<?=$value->montantdepense?>">
                <input type="number" class="form-control" id="oldMontant<?=$i?>" value="<?=$value->montantdepense?>" hidden>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-3 control-label">Categorie</label>
            <div class="col-sm-9">
                <input type="text" id="iddepense<?=$i?>" class="form-control" value="<?=$value->ID_depense?>"hidden>
                <select class="form-control" id="categorie<?=$i?>">
                    <option value=""></option>
                    <?php
                    foreach ($comptabilite->getCategorieDepenses() as $categorie) 
                    {
                        if ($categorie->ID_categorie_depense == $value->ID_categorie_depense) 
                        {
                    ?>
                            <option value="<?=$categorie->ID_categorie_depense.'_'.$categorie->description?>" selected><?=$categorie->description?></option>
                    <?php
                        }
                        else
                        {
                    ?>
                            <option value="<?=$categorie->ID_categorie_depense?>"><?=$categorie->description?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
           </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-3 control-label">Libelle</label>
            <div class="col-sm-9">
                <textarea class="form-control" id="motif<?=$i?>"> <?php echo $value->motifdepense?></textarea>
           </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
            <div class="col-sm-9">
                <input type="date" id="datedepense<?=$i?>" value="<?php echo $value->datedepense?>" class="form-control">
           </div>
        </div>
    </div>
</div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button style="background-color: #7c4a2f" class="btn text-white" onclick="updatedepense($('#oldBanque<?=$i?>').val(),$('#oldMontant<?=$i?>').val(),$('#iddepense<?=$i?>').val(),$('#datedepense<?=$i?>').val(),$('#motif<?=$i?>').val(),$('#categorie<?=$i?>').val(),$('#banque<?=$i?>').val(),$('#montantDepense<?=$i?>').val(),$('#reference<?=$i?>').val(),$('#etat<?=$i?>').val())" data-dismiss="modal">Modifier
                                </button>
                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm2<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-sm2<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mySmallModalLabel">Supprimer cette depense </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body"> 
                            <input type="text" class="form-control" id="id_depnsedel<?= $i?>" value="<?php echo $value->ID_depense?>" hidden>
                            <input type="text" id="etat<?=$i?>" value="<?=$value->etat?>" hidden>
                            Voulez-vous supprimer cette depense ? 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerdepense($('#id_depnsedel<?=$i?>').val(),$('#etat<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
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