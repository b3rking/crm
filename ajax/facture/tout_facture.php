<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();
$i = 0;
    $date = date_parse($_GET['periode']);
   // $jour = $date['day'];
    $mois = $date['month'];
    $annee = $date['year'];
 

//echo "Mois : $month; Jour : $day; Année : $year<br />\n";



foreach ($contract->recupererToutfacture($mois,$annee) as $value) 
{
	$i = 0;
    $y = 0;
    $mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
?>
	<tr>
        <td><?=$value->date_creation?></td>
        <td><?=$value->facture_id?></td>
        <td><?=$value->nom_client?></td>
        <td><?=$value->nomService?></td>
        <td><?php
        if ($value->quantite > 1) 
        {
            if ($value->annee == $value->annee_fin) 
            {
                echo ucfirst($mois[$value->mois_debut]).' au '.ucfirst($mois[$value->mois_fin]).' '.$value->annee;
            }
            else
            {
                echo ucfirst($mois[$value->mois_debut]).'/'.$value->annee.' au '.ucfirst($mois[$value->mois_fin]).'/'.$value->annee_fin;
            }
        }
        else
        {
            echo ucfirst($mois[$value->mois_debut]).' '.$value->annee;
        }?>
            
        </td>
        <td><?=$value->montant.' '.$value->monnaie?></td>
        <td><?=$value->tva?></td>
        <td class="text-nowrap">
            <a href="<?= WEBROOT;?>detailFacture-<?= $value->facture_id;?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>
            <a href="<?= WEBROOT;?>printfact-<?= $value->facture_id;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>
            
            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>

            <!-- sample modal content -->
<div class="modal fade bs-example-modal-lgg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
    <h4 class="modal-title" id="myLargeModalLabel">Modification de la facture</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form class="form-horizontal p-t-20" name="formaddClient">
        <div class="row">
            <div class="col-lg-4 col-md-3">
                <div class="row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label">Date*</label><div class="form-group col-sm-9"><input type="date" class="form-control" id="datefacture<?=$i?>" value="<?=$value->date_creation?>"></div>
                    <input type="text" id="facture_id<?=$i?>" value="<?=$value->facture_id?>" hidden>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="row"><label for="exampleInputuname3" class="col-sm-3 col-lg-6 control-label">Monnaie</label><div class="form-group col-sm-9 col-lg-6">
                    <select class="form-control" id="monnaie<?=$i?>">
                        <option value="<?=$value->monnaie?>"><?=$value->monnaie?></option>
                        <option>USD</option>
                        <option>BIF</option>
                    </select>
                </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-3">
                <div class="row">
                    <div class="form-group row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label">Affiche taux</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select id="afficheTaux<?=$i?>" class="form-control">
                                    <option value="<?=$value->show_rate?>">

                                        <?=$value->show_rate?>
                                    </option>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <!--<div class="col-lg-3 col-md-3">
                <div class="row">
                    <div class="form-group row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class="btn">
                                    <input type="checkbox" id="activeRediction<?=$i?>"> Rediction
                                </label> 
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>-->
        </div>
        <div class="row">
            <div class="col-lg-10 col-md-10">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Client*</label>
                    <div class="form-group col-sm-9">
                        <input type="text" id="idclient_factureUpdate<?=$i?>" class="form-control" value="<?=$value->nom_client?>">
                    </div>
                </div>
            </div>
        </div><!-- END ROW-->
        <hr>

<?php 
$j = 0;
foreach ($contract->recupererServicesDunFacture($value->facture_id) as $value2) 
{
$j++;
$y++;
?>
<div class="row">
<div class="col-lg-4 col-md-4">
<div class="row">
<label for="exampleInputuname3" class="col-sm-3 control-label">
Service</label><div class="form-group col-sm-9">
<input type="text" id="service<?=$y?>" value="<?=$value2->ID_service?>" hidden>
<input type="text" class="form-control" value="<?=$value2->nomService?>">
<input type="text" id="monnaiservice<?=$y?>" value="<?=$value2->monnaie?>" hidden>
</div></div></div>
<div class="col-lg-4 col-md-4">
<div class="form-group row">
<label for="exampleInputuname3" class="col-sm-3 control-label">Montant*</label>
<div class="col-sm-9">
<div class="input-group">
<input type="text" class="form-control" id="montant<?=$y?>" value="<?=$value2->montant?>">
<div class="input-group-prepend"><span class="input-group-text"><?=$value2->monnaie?></span></div>
</div>
</div>
</div>
</div>
<div class="col-lg-2 col-md-3">
<label for="exampleInputuname3" class="col-sm-3 control-label">Quantite*</label>
<div class="form-group col-sm-9"><input type="number" class="form-control" id="quantite<?=$y?>" value="<?=$value2->quantite?>"></div>
</div>
<!--<div class="col-lg-2 col-md-2">
<label for="exampleInputuname3" class="col-sm-3 control-label">Rediction</label><div class="form-group col-sm-9"><input type="number" class="form-control" id="rediction<?=$y?>" data-mask="99" value="<?=$value2->rediction?>"><span class="font-13 text-muted">e.g "99%"</span></div>
</div>-->
</div>
<div class="row">
<div class="col-lg-4 col-md-4">
<div class="row">
<label for="exampleInputuname3" class="col-sm-3 control-label">Client</label><div class="form-group col-sm-9">
<input type="text" id="sous_client<?=$y?>" value="<?=$value2->ID_client?>" hidden>
<input type="text" class="form-control" value="<?=$value2->nom_client?>"></div>
</div>
</div>
<div class="col-lg-4 col-md-4">
<label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
<div class="form-group col-sm-9">
<textarea class="form-control" id="description<?=$y?>"></textarea>
</div>
</div>
<div class="col-lg-4 col-md-4">
<label class="control-label">Billing cycle</label>
<div class="form-group col-sm-9">
<select class="form-control" id="Billing_cycle<?=$y?>">
<option>jour</option>
<option>mois</option>
<option>une seule fois</option>
</select>
</div>
</div>
</div>
<hr>
<?php
}
?>
<input type="text" id="nombreServiceUpdate<?=$i?>" value="<?=$j?>" hidden>
<input type="number" id="i<?=$i?>" value="<?=$i?>" hidden>
<input type="number" id="id_dernierService<?=$i?>" value="<?=$y?>" hidden>
        <input type="text" id="billing_number<?=$i?>" hidden="">
        <div id="service_contener"></div>
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                    <div class="form-group col-sm-9">
                        <select id="mois<?=$i?>" class="form-control">
                            <option value="<?=$value->mois_debut?>" selected><?=$mois[$value->mois_debut]?></option>
                            <option value="1">Janvier</option>
                            <option value="2" >Fevrier</option>
                            <option value="3">Mars</option>
                            <option value="4">Avril</option>
                            <option value="5">Mai</option>
                            <option value="6">Juin</option>
                            <option value="7">Juillet</option>
                            <option value="8">Aout</option>
                            <option value="9">Septembre</option>
                            <option value="10">Octobre</option>
                            <option value="11">Novembre</option>
                            <option value="12">Decembre</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee*</label>
                    <div class="form-group col-sm-9">
                        <?php
                        $date = date_parse(date('Y-m-d'));
                        $annee = $date['year'];
                        ?>
                        <input type="text" id="annee<?=$i?>" value="<?=$annee?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2">
                <div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">TVA</label>
                    <div class="form-group col-sm-9">
                        <input type="number" class="form-control" id="tva<?=$i?>" value="18" checked>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="form-group row" >
                    <label for="exampleInputuname3" class="col-sm-3 control-label">Taux</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="taux<?=$i?>" value="<?=$value->exchange_rate?>">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <span id="msg-update"></span>
    <button class="btn btn-success waves-effect text-left" onclick="updateFacture($('#facture_id<?=$i?>').val(),$('#datefacture<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#mois<?=$i?>').val(),$('#annee<?=$i?>').val(),$('#tva<?=$i?>').val(),$('#billing_number<?=$i?>').val(),$('#i<?=$i?>').val(),$('#id_dernierService<?=$i?>').val(),$('#afficheTaux<?=$i?>').val(),$('#taux<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>Enregistrer
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
                        <h4 class="modal-title" id="mySmallModalLabel">Suppression de facture</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer cette </br> facture ?
                        <input type="text" id="id_factureDelete<?=$i?>" value="<?= $value->facture_id?>" hidden>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger waves-effect text-left" onclick="deleteFacture($('#id_factureDelete<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i>Supprimer
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