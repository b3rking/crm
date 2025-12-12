<?php
ob_start();
$month_etiquete = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('paiement',$_SESSION['ID_user'])->fetch()) 
{
    if ($d['L'] == 1) 
    {
        $l = true;
    }
    if ($d['C'] == 1) 
    {
        $c = true;
    }
    if ($d['M'] == 1) 
    {
        $m = true;
    }
    if ($d['S'] == 1) 
    {
        $s = true;
    }
}
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
?>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser"  value="<?=$_SESSION['ID_user']?>" hidden>
<input type="text" id="l" value="<?=$l?>" hidden>
<input type="text" id="c" value="<?=$c?>" hidden>
<input type="text" id="m" value="<?=$m?>" hidden>
<input type="text" id="s" value="<?=$s?>" hidden>
<div class="row">
<div class="col-lg-12 col-md-12 col-xl-12">
   <div class="card">
     <div class="card-body">
        <div id="retour"></div>
       <div class="row page-titles">
            <div class="col-md-5 align-self-center">
            </div>
            <div class="col-md-7 align-self-center"> 
            <div class="d-flex justify-content-end align-items-center">
                <?php
                if ($c) 
                {
                ?>
                    <button type="button" style="background-color: #7c4a2f" class="btn  d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Nouveau paiement</button>
                <?php
                }
                ?>

        <!-- sample modal content -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                         <h4 class="modal-title" id="myLargeModalLabel">Nouveau paiement</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                <div class="modal-body">
                    <form class="form-horizontal p-t-0" >
                        <div class="row">
                            <div class="col-lg-12 col-md-8">
                                <div class="form-group row">
                                    <label for="exampleInputEmail3" class="col-sm-3 col-lg-1 control-label">Client*</label>
                                    <div class="col-sm-9 col-lg-10">
                                        <!--<input type="text" id="idclient_paiement" class="form-control form-control-sm">-->
                                        <input id="seachCustomerPayement" class="form-control form-control-sm">
                            <select id="selectCustomerPeyement" class="form-control" size="3">
                                <?php
                                    foreach ($client->getClientToCreatePayements() as $value) 
                                    {
                                ?>
                                        <option value="<?=$value->ID_client.'-'.$value->billing_number?>">
                                            <?=$value->Nom_client.' -- code: '.$value->billing_number?>
                                        </option>
                                <?php
                                    }
                                ?>
                            </select>
                                        <input type="text" id="idclient" hidden="">
                                        <!--<div id="autocomplete_conteneur"></div>-->
                                        <input type="text" id="billing_number" hidden="">
                                   </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                                <div class="form-group">
                                    Facture paie
                                    <select id="facturepaye" class="form-control" multiple="">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group row">
                                    <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Montant payé*</label>
                                    <div class="col-sm-9 col-lg-7">
                                        <input type="number" class="form-control form-control-sm" id="montantpaye">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group row">
                                    <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Monnaie*</label>
                                    <div class="col-sm-9 col-lg-7">
                                        <select class="form-control form-control-sm" id="devises">
                                            <option value=""></option>
                                            <?php
                                            for ($i=0; $i < count($tbMonnaie); $i++) 
                                            {
                                            ?> 
                                                <option value="<?=$tbMonnaie[$i]?>"><?=$tbMonnaie[$i]?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group row">
                                    <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Taux*</label>
                                    <div class="col-sm-9 col-lg-7">
                                        <input type="number"  class="form-control form-control-sm" id="taux_de_change" value="1" min="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group row">
                                    <label for="exampleInputuname3" class="col-sm-3 col-lg-6 control-label">Monnaie converti*</label>
                                    <div class="col-sm-9 col-lg-6">
                                        <select class="form-control form-control-sm" id="exchange_currency">
                                            <option value=""></option>
                                            <?php
                                            for ($i=0; $i < count($tbMonnaie); $i++) 
                                            {
                                            ?> 
                                                <option value="<?=$tbMonnaie[$i]?>"><?=$tbMonnaie[$i]?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputuname3" class="control-label">Mode paiement*</label>
                                    <select class="form-control form-control-sm" id="methodepaiement" onchange="getDestinationPaiementOnCreate($(this).val())">
                                        <option></option>
                                        <option value="CASH">CASH</option>
                                        <option value="CHEQUE">CHEQUE</option>
                                        <option value="TRANSFERT">TRANSFERT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputuname3" class="control-label">Reference</label>
                                    <input type="text" class="form-control form-control-sm"  id="reference">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputuname3" class="control-label">Date*</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control form-control-sm" value="<?php echo date('Y-m-d')?>" id="datepaiements">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputuname3" class="control-label">Tci_(%)</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" value="0" id="tva">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="conteneur_banque">
                            <div></div>
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <span id="chargement" style="display:none;">Traitement en cours</span>
                    <button type="button" style="background-color: #7c4a2f" class="btn waves-effect text-left text-white" onclick="ajout_paiement($('#idclient').val(),$('#billing_number').val(),$('#montantpaye').val(),$('#devises').val(),$('#methodepaiement').val(),$('#reference').val(),$('#tva').val(),$('#datepaiements').val(),$('#taux_de_change').val(),$('#exchange_currency').val(),$('#iduser').val())"> <i class="fa fa-check"></i>Ajouter</button>
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.modal -->
        <!--<a href="<= WEBROOT;?>paiement_journalier" class="btn btn-success d-none d-lg-block m-l-15"><i class="fa fa-file"></i> Raport journalier</a>-->
        <?php
        if ($l) 
        {
        ?>
        <button type="button" style="background-color: #7c4a2f" class="btn btn-chocolated-none d-lg-block m-l-15 text-white" onclick="submitRaportPayement()"><i class="fa fa-file"></i> Génerer rapport</button>
        <!-- Add this button in the appropriate place in your HTML -->
        <a href="<?= WEBROOT ?>index.php?p=exportToCSV&billing_number=<?= $billing_number ?>&nom_client=<?= $nom_client ?>&date1=<?= $date1 ?>&date2=<?= $date2 ?>&mois_payement=<?= $mois_payement ?>&mois_facture=<?= $mois_facture ?>&annee=<?= $annee ?>&mode_payement=<?= $mode_payement ?>" class="btn btn-chocolate text-white">
    Export to CSV
</a>
<!--        <button type="button" class="btn btn-chocolate d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target="#myModal-summary">Summary Rapport</button>-->
        <!-- sample modal content -->
        <div id="myModal-summary" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Cloture des paiements du jour</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form class="form-horizontal p-t-0" action="<?=WEBROOT?>payment_summary_report" method="get">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="row">
                                        <label for="exampleInputuname3" class="col-lg-2 col-md-4 control-label">Annee*</label>
                                        <div class="form-group col-lg-10 col-md-8">
                                            <input type="number" class="form-control form-control-sm" value="<?= date('Y')?>" name="year" id="year">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-chocolate text-white waves-effect text-left"><i class="fa fa-lock"></i> Cloturer
                            </button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <?php
        }
        ?>
</div>
</div>
        </div>
        <div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- FILTRE -->
                
                <form action="<?=WEBROOT?>filtrePayement" method="get" id="filtrePayement">
                <div class="row">
                    <div class="col-lg-1 col-md-2">
                        <div class="form-group">
                        <input type="text" name="billing_number" id="billing_number_filtre" class="form-control form-control-sm input-filter" placeholder="billing number" value="<?=$billing_number?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                        <input type="text" name="nom_client" id="nom_client_filtre" class="form-control form-control-sm input-filter" placeholder="Nom client" value="<?=$nom_client?>">
                        <!--<div id="modal_client_filter_fact"></div>-->
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                        <input type="date" name="date1" id="date1" class="form-control form-control-sm input-filter" value="<?=$date1?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                        <input type="date" name="date2" id="date2" class="form-control form-control-sm input-filter" value="<?=$date2?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group">
                            <select name="mois_payement" id="mois_payement" class="form-control form-control-sm input-filter">
                                <option value="">Mois</option>
                            <?php
                            for ($i=1; $i<13  ; $i++) 
                            { 
                                if (!empty($mois_payement)) 
                                {
                                    if ($mois_payement == $i) 
                                    {
                            ?>
                                        <option value="<?=$i?>" selected><?=$month_etiquete[$i]?></option>
                            <?php
                                    }
                                    else
                                    {
                            ?>
                                        <option value="<?=$i?>"><?=$month_etiquete[$i]?></option>
                            <?php
                                    }
                                }
                                else
                                {
                            ?>
                                    <option value="<?=$i?>"><?=$month_etiquete[$i]?></option>
                            <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-2">
                        <div class="form-group">
                            <select name="mode_payement" id="mode_payement_filtre" class="form-control form-control-sm input-filter">
                                <option value="">Mode payement</option>
                                <?php
                                if (empty($mode_payement)) 
                                {
                                ?>
                                    <option value="CASH">CASH</option>
                                    <option value="CHEQUE">CHEQUE</option>
                                    <option value="TRANSFERT">TRANSFERT</option>
                                <?php
                                }
                                else
                                {
                                    if ($mode_payement == 'CASH') 
                                    {
                                ?>
                                        <option value="CASH" selected="">CASH</option>
                                        <option value="CHEQUE">CHEQUE</option>
                                        <option value="TRANSFERT">TRANSFERT</option>
                                <?php
                                    }
                                    elseif ($mode_payement == 'CHEQUE') 
                                    {
                                ?>
                                        <option value="CASH">CASH</option>
                                        <option value="CHEQUE" selected="">CHEQUE</option>
                                        <option value="TRANSFERT">TRANSFERT</option>
                                <?php
                                    }
                                    else 
                                    {
                                ?>
                                        <option value="CASH">CASH</option>
                                        <option value="CHEQUE">CHEQUE</option>
                                        <option value="TRANSFERT" selected="">TRANSFERT</option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-2">
                        <div class="form-group">
                            <input type="text" name="annee" id="annee_filter" class="form-control form-control-sm input-filter" value="<?=date('Y')?>">
                            <input type="text" name="print" id="print" value="0" hidden="">
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-3">
                        <div class="form-group">
                            <select name="mois_facture" id="mois_facture" class="form-control form-control-sm input-filter">
                                <option value="">Facture mois de</option>
                            <?php
                            for ($i=1; $i<13  ; $i++) 
                            { 
                                if (!empty($mois_facture)) 
                                {
                                    if ($mois_facture == $i) 
                                    {
                            ?>
                                        <option value="<?=$i?>" selected><?=$month_etiquete[$i]?></option>
                            <?php
                                    }
                                    else
                                    {
                            ?>
                                        <option value="<?=$i?>"><?=$month_etiquete[$i]?></option>
                            <?php
                                    }
                                }
                                else
                                {
                            ?>
                                    <option value="<?=$i?>"><?=$month_etiquete[$i]?></option>
                            <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <!--<button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtrepaiment($('#nom_client_filtre').val(),$('#date1').val(),$('#date2').val(),$('#mois_filter').val(),$('#annee_filter').val(),$('#billing_number_filtre').val())"><i class="ti ti-filter"></i> Filtrer</button>-->
                        <button type="submit" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <button type="button" class="btn btn-rounded btn-sm btn-danger"onclick="resetFiltrepaiement()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                    </div>
                </div>
            </form>
                <form class="form-horizontal p-t-0" action="<?=WEBROOT?>print_filter_payement" method="post" id="form-reportpayement">
                    <input type="text" id="cond" name="cond" hidden="">
                </form>
                <input type="text" id="page" value="paiement" hidden="">
		<div class="table-responsive m-t-0">
			<table id="myTable" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
				<thead class="font-bold">
					<tr>
						<th>Date paiement</th>
						<th>Numero</th>
						<th>Client</th>
						<th>Montant</th>
						<th>Taux</th>
						<th>Montant converti</th>
						<th>Description</th>
						<th>Facture paye</th>
                        <!--<th>Status</th>-->
						<th>Action</th>
					</tr>
				</thead>
				<tfoot class="font-bold">
					<tr>
						<th>Date paiement</th>
						<th>Numero</th>
						<th>Client</th>
						<th>Montant</th>
						<th>Taux</th>
                        <th>Montant converti</th>
						<th>Description</th>
						<th>Facture paye</th>
                        <!--<th>Status</th>--> 
						<th>Action</th>
					</tr>
				</tfoot>
				<tbody id="rep">              
					<?php 
                    $i = 0;
                    $y = 0;
                    $p = 0;
					foreach ($result as $data)
					{
                        $i++;
                        $p++;
                        $disabled = ($data->status == 0 ? "" : "disabled");
					?>
					   <tr>
						<td><?php echo $data->datepaiement?></td>
						<td><?php echo $data->numero?></td>
                        <td><a href="<?= WEBROOT;?>detailClient-<?= $data->ID_client;?>"><b><?php echo $data->Nom_client.'-'.$data->billing_number;?></b></a></td>
						<td><?php echo number_format($data->montant).' '.$data->devise?></td>
						<td><?php echo $data->Taux_change_courant?></td>
						<td><?php echo number_format($data->montant_converti).' '.$data->exchange_currency?></td>
						<td><?php echo $data->methode .'-'.$data->reference?></td>
						<td><?php
                        $nb_facture_payer = 0;
                        foreach ($comptabilite->getFacture_dun_payement($data->ID_paiement) as $val) 
                        {
                            $nb_facture_payer ++;
                            echo $val->numero."\n";
                        }
                        ?></td>
						
						<td class="text-nowrap">
                    <a href="<?=WEBROOT;?>historique-payement-<?=$data->ID_paiement?>" data-toggle="tooltip"  data-original-title="historique"><i class="mdi mdi-eye m-r-10"></i>
                    </a>
                    <a href="<?=WEBROOT;?>recu_paiement_facture-<?=$data->ID_paiement?>" data-toggle="tooltip"  data-original-title="Print"><i class="mdi mdi-printer m-r-10"></i>
                    </a>
                    <?php
                    if ($m) 
                    {
                    ?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg-paiement<?=$p?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i></a>
                    <?php
                    }
                    ?>
                    <!-- sample modal content -->
                    <?php require 'vue/admin/finance/updatePaymentForm.php';?>
                    <?php
                    if ($s) 
                    {
                    ?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                    <?php
                    }
                    ?>

                    <!-- sample modal content -->
<div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer paiement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="idpaiement_del-<?= $i?>" value="<?php echo $data->ID_paiement?>" hidden>
                <input type="text" id="del_idclient<?=$i?>" value="<?=$data->ID_client?>" hidden>
                Voulez-vous supprimer ce paiement?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deletePaiement($('#idpaiement_del-<?= $i?>').val(),$('#del_idclient<?=$i?>').val(),$('#old_montant<?=$i?>').val(),$('#status<?=$i?>').val(),'<?=$data->deposed?>')" data-dismiss="modal"><i class="ti-trash"></i></button>
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
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>