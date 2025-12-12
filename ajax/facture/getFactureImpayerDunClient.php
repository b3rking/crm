<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();
$i = 0;
foreach ($contract->recuperFactureImpayerDunClient($_GET['idclient']) as $value) 
{
	$i++;
?>
	<tr>
        <td><?=$value->date_creation?></td>
        <td><?=$value->facture_id?></td>
        <td><?=$value->nom_client?></td>
        <td><?=$value->nomService?></td>
        <td><?php 
        $mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
        if ($value->billing_cycle == 0) 
        {
            echo "Du ".$value->startDate." au ".$value->endDate;
        }
        else
        {
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
            }
        }?>
        	
        </td>
        <td><?=$value->montant_total.'_'.$value->monnaie?></td>
        <td><?=$value->tva?></td>
        <td class="text-nowrap">
        	<a href="/crm.spidernet/printfact-<?= $value->facture_id;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>
        	
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
        	<div class="col-lg-3 col-md-3">
        		<div class="row">
        			<label for="exampleInputuname3" class="col-sm-3 control-label">Date*</label><div class="form-group col-sm-9"><input type="text" class="form-control" id="datefacture<?=$i?>" value="<?=$value->date_creation?>"></div>
        			<input type="text" id="facture_id<?=$i?>" value="<?=$value->facture_id?>" hidden>
        		</div>
        	</div>
			<div class="col-lg-3 col-md-3">
				<div class="row"><label for="exampleInputuname3" class="col-sm-3 control-label">Monnaie</label><div class="form-group col-sm-9">
					<select class="form-control" id="monnaie<?=$i?>">
						<option>USD</option>
						<option>BIF</option>
					</select>
				</div>
        		</div>
        	</div>
        	<div class="col-lg-3 col-md-3">
				<div class="row">
					<div class="form-group row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            	<label class="btn">
				                    <input type="checkbox" id="afficheTaux"> Affiche taux
				                </label> 
                            </div>
                        </div>
                    </div>
                </div>
        		</div>
        	</div>
        	<div class="col-lg-3 col-md-3">
				<div class="row">
					<div class="form-group row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            	<label class="btn">
				                    <input type="checkbox" id="activeRediction"> Rediction
				                </label> 
                            </div>
                        </div>
                    </div>
                </div>
        		</div>
        	</div>
        </div>
    	<div class="row">
    		<div class="col-lg-10 col-md-10">
        		<div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Client*</label>
                    <div class="form-group col-sm-9">
                    	<input type="text" id="idclient_factureUpdate" class="form-control" value="<?=$value->nom_client?>">
                    </div>
                </div>
        	</div>
    	</div><!-- END ROW-->
        <hr>

<?php 
$y = 0;
foreach ($contract->recupererServicesDunFacture($value->facture_id) as $value2) 
{
$y++;
?>
<div class="row">
<div class="col-lg-4 col-md-4">
<div class="row">
<label for="exampleInputuname3" class="col-sm-3 control-label">
Service</label><div class="form-group col-sm-9">
<input type="text" id="service<?=$y?>" value="<?=$value2->ID_service?>" hidden>
<input type="text" class="form-control" value="<?=$value2->nomService?>">
</div></div></div>
<div class="col-lg-4 col-md-4">
<div class="form-group row">
<label for="exampleInputuname3" class="col-sm-3 control-label">Montant*</label>
<div class="col-sm-9">
<div class="input-group">
<input type="text" class="form-control" id="montant<?=$y?>" value="<?=$value2->montant?>" disabled>
<div class="input-group-prepend"><span class="input-group-text"><?=$value2->monnaie?></span></div>
</div>
</div>
</div>
</div>
<div class="col-lg-2 col-md-3">
<label for="exampleInputuname3" class="col-sm-3 control-label">Quantite</label>
<div class="form-group col-sm-9"><input type="number" class="form-control" id="quantite<?=$y?>" value="<?=$value2->quantite?>"></div>
</div>
<div class="col-lg-2 col-md-2">
<label for="exampleInputuname3" class="col-sm-3 control-label">Rediction</label><div class="form-group col-sm-9"><input type="text" class="form-control" id="rediction<?=$y?>" data-mask="99" value="<?=$value2->rediction?>"><span class="font-13 text-muted">e.g "99%"</span></div>
</div>
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
<input type="text" id="nombreServiceUpdate" value="<?=$y?>" hidden>
        <input type="text" id="billing_number<?=$i?>" hidden="">
        <div id="service_contener"></div>
        <div class="row">
        	<div class="col-lg-3 col-md-3">
        		<div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                    <div class="form-group col-sm-9">
                        <select id="mois<?=$i?>" class="form-control">
                        	<option value="<?=$value->mois_debut?>" selected><?=$value->mois_debut?></option>
                        	<option value="janvier">Janvier</option>
                        	<option value="fevrier" >Fevrier</option>
                        	<option value="mars">Mars</option>
                        	<option value="avril">Avril</option>
                        	<option value="mai">Mai</option>
                        	<option value="juin">Juin</option>
                        	<option value="juillet">Juillet</option>
                        	<option value="aout">Aout</option>
                        	<option value="septembre">Septembre</option>
                        	<option value="octobre">Octobre</option>
                        	<option value="novembre">Novembre</option>
                        	<option value="decembre">Decembre</option>
                        </select>
                    </div>
                </div>
        	</div>
        	<div class="col-lg-3 col-md-3">
        		<div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee</label>
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
        		<div class="row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Facture suivante</label>
                    <div class="form-group col-sm-9">
     					<input type="date" class="form-control" id="facture_suivante<?=$i?>">
                    </div>
                </div>
        	</div>
        </div>
    </form>
</div>
<div class="modal-footer">
	<span id="msg"></span>
    <button class="btn btn-success waves-effect text-left" onclick="updateFacture($('#facture_id<?=$i?>').val(),$('#datefacture<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#mois<?=$i?>').val(),$('#annee<?=$i?>').val(),$('#tva<?=$i?>').val(),$('#facture_suivante<?=$i?>').val(),$('#billing_number<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>Enregistrer
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
                    	<button class="btn btn-success waves-effect text-left" onclick="deleteFacture($('#id_factureDelete<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>Enregistrer
 						</button>
                        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
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