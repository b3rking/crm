<?php
ob_start();
$month_etiquete = [1 => 'Janvier', 2 => 'Fevrier', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Aout', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Decembre'];
$date = date_parse(date('Y-m-d'));
$mois = $date['month'];
$annee = $date['year'];

$next_date = date_parse(date('Y-m-1', strtotime('+1 month')));
$nextMoth = $next_date['month'];
$nextYear = $next_date['year'];
$massInvoiceYear = ($mois == 12 ? $nextYear : $annee);

$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('facture', $_SESSION['ID_user'])->fetch()) {
    if ($d['L'] == 1) {
        $l = true;
    }
    if ($d['C'] == 1) {
        $c = true;
    }
    if ($d['M'] == 1) {
        $m = true;
    }
    if ($d['S'] == 1) {
        $s = true;
    }
}
foreach ($comptabilite->getMonnaies() as $value) {
    $tbMonnaie[] = $value->libelle;
}
?>
<input type="text" id="WEBROOT" value="<?= WEBROOT ?>" hidden>
<input type="text" id="userName" name="userName" value="<?= $_SESSION['userName'] ?>" hidden>
<input type="text" id="iduser" value="<?= $_SESSION['ID_user'] ?>" hidden>
<input type="text" id="m" value="<?= $m ?>" hidden>
<input type="text" id="s" value="<?= $s ?>" hidden>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button"><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <!-- <a href="<?= WEBROOT ?>update_solde" style="background-color: #7c4a2f" class="btn btn- text-white d-none d-sm-block m-l-8">Update solde</a> -->
            <?php
            if ($c) {
            ?>
                <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Creer facture</button>
            <?php
            }
            ?>

            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Creation de la facture</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-0" name="formaddClient">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3">
                                        <div class="row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date*</label>
                                            <div class="form-group col-sm-9"><input type="date" class="form-control form-control-sm" id="datefacture" value="<?= date('Y-m-d') ?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="row"><label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Monnaie*</label>
                                            <div class="form-group col-sm-9 col-lg-7">
                                                <select class="form-control form-control-sm" id="monnaie">
                                                    <?php
                                                    for ($l = 0; $l < count($tbMonnaie); $l++) {
                                                    ?>
                                                        <option value="<?= $tbMonnaie[$l] ?>"><?= $tbMonnaie[$l] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="form-group">
                                            <label class="btn">
                                                <input type="checkbox" id="afficheTaux"> afficher taux
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-2">
                                        <div class="form-group">
                                            <label class="btn">
                                                <input type="checkbox" id="enable_discount" value="0"> activer reduction
                                            </label>
                                        </div>
                                    </div>
                                    <!--<div class="col-lg-2 col-md-2" id="divReduction0">
										<label for="exampleInputuname3" class="col-sm-3 control-label">Reduction(%)</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction" value="" min="0"></div>
									</div>-->
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-xlg-12 col-md-12">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 col-md-1 col-lg-1 col-xlg-1 control-label">Client*</label>
                                            <div class="form-group col-sm-9 col-md-11 col-lg-11 col-xlg-11">
                                                <input type="text" id="seachCustomerInvoice" class="form-control form-control-sm" autocomplete="off">
                                                <select id="selectCustomerInvoice" class="form-control" size="3">
                                                    <?php
                                                    foreach ($client->getClientsToCreateInvoice() as $value) {
                                                    ?>
                                                        <option value="<?= $value->ID_client . '_' . $value->ID_contract . '_' . $value->billing_number . '_' . $value->next_billing_date ?>">
                                                            <?= $value->Nom_client . ' -- code: ' . $value->billing_number ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <!--<input type="text" id="idclient_facture" class="form-control form-control-sm" autocomplete="off">
		                                    	<input type="text" id="idclient" hidden>
		                                            <div id="modal"></div>
		                                            <input type="text" id="next_billing_date" hidden="">
		                                            <input type="text" id="idcontract" hidden="">-->
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                                <hr>
                                <input type="text" id="billing_number" hidden="">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">
                                                Service*</label>
                                            <div class="form-group col-sm-9">
                                                <select class="form-control form-control-sm" id="service0">
                                                    <option></option>
                                                    <?php
                                                    foreach ($service->recupererServices() as $value) {
                                                    ?>
                                                        <option value="<?= $value->ID_service . '-' . $value->nomService ?>"><?= $value->nomService ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group row">
                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Montant</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="number" step="any" class="form-control form-control-sm" id="montantt0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">Quantite*</label>
                                        <div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="quantite0" value="1" min="1"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="row">
                                            <label for="exampleInputuname3" class="col-sm-6 control-label">Bande passante</label>
                                            <div class="form-group col-sm-9">
                                                <input type="text" id="bandeP0" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
                                        <div class="form-group col-sm-9">
                                            <textarea class="form-control form-control-sm" id="description0"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label class="control-label">Cycle facture</label>
                                        <div class="form-group col-sm-9">
                                            <select class="form-control form-control-sm" id="billing_cycle0" onchange="setBillingCycleContent($(this).val(),0)">
                                                <option value="0">jour</option>
                                                <option value="1" selected="">mois</option>
                                                <option value="2">une seule fois</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2" id="divReduction0">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction(%)</label>
                                        <div class="form-group col-sm-9">
                                            <input type="number" class="form-control form-control-sm" id="rediction0" min="0">
                                        </div>
                                    </div>
                                </div>
                                <div id="billingCycleContent0">
                                    <div></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <input type="text" id="nbservice" value="1" hidden="">
                                        <button type="button" style="background-color: #7c4a2f" class="btn text-white " onclick="ajoutServiceToFacture()">
                                            Service
                                            <i class="ti-plus text"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div id="service_contener"></div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-3">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                                            <div class="form-group col-sm-9">
                                                <select id="mois" class="form-control form-control-sm">
                                                    <?php
                                                    for ($i = 1; $i < 13; $i++) {
                                                        if ($i == $mois) {
                                                    ?>
                                                            <option value="<?= $i ?>" selected><?= $month_etiquete[$i] ?></option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="<?= $i ?>"><?= $month_etiquete[$i] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" id="annee" value="<?= $annee ?>" class="form-control form-control-sm" min="<?= $annee - 1 ?>" max="<?= $annee + 1 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">TVA</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" class="form-control form-control-sm" id="tva" value="18">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="form-group">
                                            <label class="btn">
                                                <input type="checkbox" id="fixe_rate" value="0" onclick="showHideFixedRateDiv(this)"> fixe taux
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2" style="display: none;" id="divTaux0">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Taux</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" class="form-control form-control-sm" id="taux">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2" style="display: none;" id="divMonnaie0">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
                                            <div class="form-group col-sm-9">
                                                <select class="form-control form-control-sm" id="exchange_currency">
                                                    <option value="BIF">BIF</option>
                                                    <option value="USD">USD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #7c4a2f" class="btn waves-effect text-left text-white" onclick="creefacture($('#datefacture').val(),$('#monnaie').val(),$('#mois').val(),$('#annee').val(),$('#tva').val(),$('#selectCustomerInvoice').val())"><i class="fa fa-check"></i>Enregistrer
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->



            <!--<button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i>Cloturer un mois</button>-->
            <?php
            if ($c) {
            ?>
                <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> Creer facture en masse</button>
            <?php
            }
            ?>

            <!-- sample modal content -->
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Creation des factures En masse</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-0" id="massInvoiceForm" method="post" action="<?= WEBROOT ?>printMassInvoice">
                                <div class="row">
                                    <div class="col-lg-6 col-md-7">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mode :</label>
                                            <div class="form-group col-sm-9">
                                                <select id="mode_mass_invoice" name="mode_mass_invoice" class="form-control form-control-sm">
                                                    <option value="mail">via mail</option>
                                                    <option value="impression">Imprimer</option>
                                                    <option value="manuel">Manuel</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-7">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date:</label>
                                            <div class="form-group col-sm-9">
                                                <input type="date" class="form-control form-control-sm" id="datefacture_masse" name="datefacture_masse" value="<?= date('Y-m-d') ?>">
                                                <input type="text" name="userName" value="<?= $_SESSION['userName'] ?>" hidden>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                                            <div class="form-group col-sm-9">
                                                <select id="mois_choisi" name="mois_choisi" class="form-control form-control-sm">
                                                    <?php
                                                    for ($i = 1; $i < 13; $i++) {
                                                        if ($i == $nextMoth) {
                                                    ?>
                                                            <option value="<?= $i ?>" selected><?= $month_etiquete[$i] ?></option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="<?= $i ?>"><?= $month_etiquete[$i] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" id="annee_factureEnMass" name="annee_factureEnMass" value="<?= $massInvoiceYear ?>" class="form-control form-control-sm" min="<?= $annee ?>" max="<?= $annee + 1 ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-7">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Taux :</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" class="form-control form-control-sm" id="taux_mass_invoice" name="taux_mass_invoice">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <span id="msg_factureEnMass"></span>
                            <button style="background-color: #7c4a2f" class="btn text-white waves-effect text-left" onclick="creerfactureEnMasse($('#mode_mass_invoice').val(),$('#datefacture_masse').val(),$('#mois_choisi').val(),$('#annee_factureEnMass').val(),$('#taux_mass_invoice').val())"><i class="fa fa-check"></i>Enregistrer
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <?php
            if ($l) {
            ?>
                <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target="#myModalGenPdf"><i class="fa fa-eye"></i> Afficher facture</button>
            <?php
            }
            ?>

            <!-- sample modal content -->
            <div id="myModalGenPdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Generation de facture en pdf</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form class="form-horizontal p-t-0" id="GenPdfInvoiceForm" method="post" action="<?= WEBROOT ?>printInvoiceMonth">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois </label>
                                        <div class="form-group col-sm-9">
                                            <select id="month_report" name="mois_choisi" class="form-control form-control-sm">
                                                <?php
                                                for ($i = 1; $i < 13; $i++) {
                                                    if ($i == $mois) {
                                                ?>
                                                        <option value="<?= $i ?>" selected><?= $month_etiquete[$i] ?></option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <option value="<?= $i ?>"><?= $month_etiquete[$i] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Année</label>
                                        <div class="col-sm-9">
                                            <input type="number" data-mask="9999" class="form-control form-control-sm" name="annee_raport" id="annee_raport" value="<?php echo date('Y') ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <label for="exampleInputEmail3" class="col-sm-3 col-lg-6 control-label">Creation mode</label>
                                        <div class="col-sm-9 col-lg-6 ">
                                            <select id="mode_mass_invoice_print" name="mode_mass_invoice_print" class="form-control form-control-sm">
                                                <option value="impression">Imprimer</option>
                                                <option value="mail">via mail</option>
                                                <option value="manuel">Manuel</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <span id="msg_factureGen"></span>
                                <button style="background-color: #7c4a2f" class="btn text-white waves-effect text-left" type="submit"><i class="fa fa-check"></i>Generer
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

            <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" onclick="raportFacture()"><i class="fa fa-file"></i> Génerer rapport</button>

            <form class="form-horizontal p-t-0" action="<?= WEBROOT ?>report_fact" method="post" id="forem-reportFact">
                <input type="text" id="cond" name="cond" hidden="">
            </form>

            <!-- sample modal content --
            <div id="myModalGenPdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Génerer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                    <form class="form-horizontal p-t-0" id="GenPdfInvoiceForm" method="post" action="<=WEBROOT?>print_rapport_mois">
                        <div class="modal-body">
                            <div class="row">
                            	<div class="col-lg-6 col-md-6">
                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois </label>
                                    <div class="form-group col-sm-9">
                                    	<select id="mois_choisi" name="mois_choisi" class="form-control">
						                	<option value="1">Janvier</option>
						                	<option value="2">Fevrier</option>
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
							   <div class="col-lg-6 col-md-6">
							        	<label for="exampleInputEmail3" class="col-sm-3 control-label">Année</label>
	                                    <div class="col-sm-9">
	                                    	<div class="input-group">
	                                    		<div class="input-group-prepend"></div>
	                                    		<input type="number" data-mask="9999" class="form-control" name="annee_raport" id="annee_raport" value="<php echo date('Y')?>">
	                                    	</div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
                        <div class="modal-footer">
                        	<span id="msg_factureGen"></span>
                            <button type="submit" class="btn btn-success waves-effect text-left"><i class="fa fa-check"></i>Generer
     						</button>
                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                        </form>
                    </div>
                    <!- /.modal-content --
                </div>
                <!- /.modal-dialog --
            </div>
            <!- /.modal -->

            <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target="#myModalSendefacture"><i class="mdi mdi-gmail"></i> Envoyer facture</button>

            <!-- sample modal content -->
            <div id="myModalSendefacture" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Envoie des factures par email</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form class="form-horizontal p-t-0">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-7 col-md-7">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois :</label>
                                            <div class="form-group col-sm-9">
                                                <select id="mois_fact" name="mois_fact" class="form-control">
                                                    <option value="1">Janvier</option>
                                                    <option value="2">Fevrier</option>
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
                                    <div class="col-lg-5 col-md-5">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" class="form-control" name="annee_fact" id="annee_fact" value="<?= date('Y') ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <span id="msg_sendfact"></span>
                                <button style="background-color: #7c4a2f" type="button" class="btn text-white waves-effect text-left" onclick="sendFacture($('#mois_fact').val(),$('#annee_fact').val())"><i class="fa fa-check"></i>Envoyer
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

            <a href="<?= WEBROOT ?>incomeingInvoices" class="btn btn-chocolate text-white d-none d-lg-block m-l-15">Facturation Suivante</a>

            <?php
            if ($s) {
            ?>
                <button type="button" class="btn btn-chocolate text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target="#myModal-mass-delete">Suppression en masse</button>
            <?php
            }
            ?>
            <!-- sample modal content -->
            <div id="myModal-mass-delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Suppression des factures En masse</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-0">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                                            <div class="form-group col-sm-9">
                                                <select id="month-delete" name="mois_choisi" class="form-control form-control-sm">
                                                    <?php
                                                    for ($i = 1; $i < 13; $i++) {
                                                        if ($i == $nextMoth) {
                                                    ?>
                                                            <option value="<?= $i ?>" selected><?= $month_etiquete[$i] ?></option>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <option value="<?= $i ?>"><?= $month_etiquete[$i] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" id="year-delete" name="annee_factureEnMass" value="<?= $massInvoiceYear ?>" class="form-control form-control-sm" min="<?= $annee ?>" max="<?= $annee + 1 ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-7">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mode :</label>
                                            <div class="form-group col-sm-9">
                                                <select id="mode_delete" name="mode_mass_invoice" class="form-control form-control-sm">
                                                    <option value="mail">via mail</option>
                                                    <option value="impression">Imprimer</option>
                                                    <option value="manuel">Manuel</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-chocolate text-white waves-effect text-left" onclick="massInvoiceDelete($('#month-delete').val(),$('#year-delete').val(),$('#mode_delete').val())"><i class="fa fa-check"></i>Supprimer
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <form action="<?= WEBROOT ?>filtreFacture" method="get" id="filtreFacture">
                    <div class="row">
                        <div class="col-lg-1 col-md-1">
                            <div class="form-group">
                                <input type="text" name="billing_number" id="billing_number_filtre" class="form-control form-control-sm input-filter" placeholder="billing number" value="<?= $billing_number ?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <input type="text" name="nom_client" id="nom_client" class="form-control form-control-sm input-filter" placeholder="Nom client" value="<?= $nom_client ?>">
                                <!--<div id="modal_client_filter_fact"></div>-->
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <input type="date" name="date1" id="date1" class="form-control form-control-sm input-filter" value="<?= $date1 ?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2">
                            <div class="form-group">
                                <input type="date" name="date2" id="date2" class="form-control form-control-sm input-filter" value="<?= $date2 ?>">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-2">
                            <div class="form-group">
                                <select class="form-control form-control-sm custom-select input-filter" name="mode_creation" id="mode_creation">
                                    <?php
                                    $creation_mode = ['impression', 'mail', 'manuel'];
                                    if (!empty($mode_creation)) {
                                        for ($i = 0; $i < count($creation_mode); $i++) {
                                            if ($creation_mode[$i] == $mode_creation) {
                                    ?>
                                                <option value="<?= $creation_mode[$i] ?>" selected><?= $creation_mode[$i] ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?= $creation_mode[$i] ?>"><?= $creation_mode[$i] ?></option>
                                        <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <option value="">Mode de creation</option>
                                        <option value="impression">Impression</option>
                                        <option value="mail">Mail</option>
                                        <option value="manuel">Mannuel</option>
                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-2">
                            <div class="form-group">
                                <select id="mois_creation" name="mois_creation" class="form-control form-control-sm input-filter">
                                    <option value="">Mois</option>
                                    <?php
                                    for ($i = 1; $i < 13; $i++) {
                                        if (!empty($mois_creation)) {
                                            if ($mois_creation == $i) {
                                    ?>
                                                <option value="<?= $i ?>" selected><?= $month_etiquete[$i] ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?= $i ?>"><?= $month_etiquete[$i] ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="<?= $i ?>"><?= $month_etiquete[$i] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <div class="form-group">
                                <input type="number" name="annee_creation" id="annee_creation" class="form-control form-control-sm input-filter" value="<?= $annee_creation ?>">
                                <input type="text" name="print" id="print" value="0" hidden="">
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <!--<button type="button" style="background-color: #7c4a2f" class="btn btn-sm  text-white"onclick="filtreFacture($('#billing_number_filtre').val(),$('#nom_client').val(),$('#date1').val(),$('#date2').val(),$('#mode_creation').val(),$('#mois_creation').val(),$('#annee_creation').val())"><i class="ti ti-filter"></i> Filtrer</button>-->
                            <button type="submit" style="background-color: #7c4a2f" class="btn btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
                        </div>
                        <div class="col-lg-1 col-md-1">
                            <button type="button" class="btn btn-sm  btn-dark" onclick="resetFiltreFacture()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Reset</button>
                        </div>
                    </div>
                </form>
                <form>
                    <div class="row">
                        <div class="col-lg-9"></div>
                        <div class="col-lg-1">
                            <div class="form-group">
                                <!-- <input type="text" class="form-control form-control-sm input-filter" id="showTotalAmount"> -->
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" onclick="addInvoicesToObrServer(event)">Envoyer à l'OBR</button>
                            </div>
                        </div>
                    </div>
                </form>
                <input type="text" id="page" value="facture" hidden="">
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Numero</th>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Mois</th>
                                <th>Montant</th>
                                <th>TVA</th>
                                <th>Selectionner</th>
                                <th>Valider</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Numero</th>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Mois</th>
                                <th>Montant</th>
                                <th>TVA</th>
                                <th>Selectionner</th>
                                <th>Valider</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                            <?php
                            $i = 0;
                            $y = 0;
                            $mois = [1 => 'janvier', 2 => 'fevrier', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'aout', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'decembre'];
                            foreach ($result as $value) {
                                $i++;
                            ?>
                                <tr>
                                    <td><?= $value->date_creation ?></td>
                                    <td><?= $value->numero ?></td>
                                    <td><a href="<?= WEBROOT; ?>detailClient-<?= $value->ID_client; ?>"><b><?php echo $value->nom_client; ?></b></a></td>
                                    <td>
                                        <?php
                                        $serviceName = "";
                                        foreach ($contract->recupererServicesDunFacture($value->facture_id) as $val) {
                                            $serviceName .= $val->nomService . ", ";
                                        }
                                        echo rtrim($serviceName, ', ');
                                        ?>
                                    </td>
                                    <td><?php
                                        if (count($contract->getMoisDuneFacture($value->facture_id)) > 1) {
                                            $k = 0;
                                            foreach ($contract->getMoisDuneFacture($value->facture_id) as $val) {
                                                if ($val->billing_cycle == 0) {
                                                    //echo "Du ".$value->startDate." au ".$value->endDate;
                                                } elseif ($val->billing_cycle == 2) {
                                                } else {
                                                    if ($val->quantite > 1) {
                                                        //if ($k==0) 
                                                        //{
                                                        if ($val->annee == $val->annee_fin) {
                                                            echo ucfirst($mois[$val->mois_debut]) . ' au ' . ucfirst($mois[$val->mois_fin]) . ' ' . $val->annee;
                                                        } else {
                                                            echo ucfirst($mois[$val->mois_debut]) . '/' . $val->annee . ' au ' . ucfirst($mois[$val->mois_fin]) . '/' . $val->annee_fin;
                                                        }
                                                        //}
                                                        break;
                                                    } else {
                                                        //if ($k==0) echo ucfirst($mois[$val->mois_debut]).' '.$val->annee;
                                                        echo ucfirst($mois[$val->mois_debut]) . ' ' . $val->annee;
                                                        //$k++;
                                                        break;
                                                    }
                                                }
                                            }
                                        } else {
                                            if ($value->billing_cycle == 0) {
                                                echo "Du " . $value->startDate . " au " . $value->endDate;
                                            } elseif ($value->billing_cycle == 2) {
                                                echo ucfirst($mois[$value->mois_debut]) . ' ' . $value->annee;
                                            } else {
                                                if ($value->quantite > 1) {
                                                    if ($value->annee == $value->annee_fin) {
                                                        echo ucfirst($mois[$value->mois_debut]) . ' au ' . ucfirst($mois[$value->mois_fin]) . ' ' . $value->annee;
                                                    } else {
                                                        echo ucfirst($mois[$value->mois_debut]) . '/' . $value->annee . ' au ' . ucfirst($mois[$value->mois_fin]) . '/' . $value->annee_fin;
                                                    }
                                                } else {
                                                    echo ucfirst($mois[$value->mois_debut]) . ' ' . $value->annee;
                                                }
                                            }
                                        }
                                        $data_contract = $contract->getNext_billing_date_dun_client($value->ID_client)->fetch();
                                        ?>
                                    </td>
                                    <td><?= number_format(round($value->montant_total)) . ' ' . $value->monnaie ?></td>
                                    <td><?= $value->tva + $value->tvci ?></td>


                                    <td>
                                        <input type="checkbox" class="selected_invoice" id="<?= $value->facture_id ?>" value="<?= $value->montant_total ?>" onchange="selectInvoicesToSendToObr(this)">
                                    </td>

                                    <?php
                                    if (!empty($value->invoice_signature)) {
                                    ?>
                                        <td style="background-color:rgba(0, 255, 0, 0.24); color:#004600">facture validée par l'OBR</td>
                                    <?php
                                    } else {
                                    ?>
                                        <td style="background-color:rgba(255, 0, 0, 0.24); color:#290000">Non validée</td>
                                    <?php
                                    }
                                    ?>

                                    <td class="text-nowrap">
                                        <!--<a href="<= WEBROOT;?>detailFacture-<?= $value->facture_id; ?>" data-toggle="tooltip" data-original-title="Voir"> <i class="fa fa-eye text-inverse m-r-10"></i> </a>-->
                                        <a href="<?= WEBROOT; ?>printfact-<?= $value->facture_id; ?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>
                                        <a href="javascript:void(0)" onclick="sendSingleFacture(<?= $value->facture_id ?>)" data-toggle="tooltip" data-original-title="Envoyer par email">
                                            <?php if ($value->sent) { ?>
                                                <i class="mdi mdi-email-check text-success m-r-10" data-toggle="tooltip" data-original-title="Envoyée"></i>
                                                <span class="badge badge-success">Envoyée</span>
                                            <?php } else { ?>
                                                <i class="mdi mdi-email-outline text-muted m-r-10" data-toggle="tooltip" data-original-title="Non envoyée"></i>
                                                <span class="badge badge-secondary">Non envoyée</span>
                                            <?php } ?>
                                        </a>

                                        <!-- Resend button (tries to resend the invoice email) -->
                                        <a href="javascript:void(0)" onclick="resendSingleFacture(<?= $value->facture_id ?>)" data-toggle="tooltip" data-original-title="Renvoyer par email">
                                            <i class="mdi mdi-email-send text-primary m-r-10" data-toggle="tooltip" data-original-title="Renvoyer"></i>
                                        </a>
                                        <?php
                                        if ($m) {
                                        ?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgg<?= $i ?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                        <?php
                                        }
                                        ?>

                                        <!-- sample modal content -->
                                        <?php require 'vue/admin/facture/updateInvoiceForm.php' ?>
                                        <!-- /.modal -->
                                        <?php
                                        if ($s) {
                                        ?>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?= $i ?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                                        <?php
                                        }
                                        ?>

                                        <!-- sample modal content -->
                                        <div class="modal fade bs-example-modal-sm<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="mySmallModalLabel">Suppression de facture</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Voulez-vous vraiment supprimer cette </br> facture ?
                                                        <input type="text" id="id_factureDelete<?= $i ?>" value="<?= $value->facture_id ?>" hidden>
                                                        <input type="text" id="del_moisdebut<?= $i ?>" value="<?= $value->mois_debut ?>" hidden>
                                                        <input type="text" id="del_annedebut<?= $i ?>" value="<?= $value->annee ?>" hidden>
                                                        <input type="text" id="del_idclient<?= $i ?>" class="form-control form-control-sm" value="<?= $value->ID_client ?>" hidden>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-danger waves-effect text-left" onclick="deleteFacture($('#id_factureDelete<?= $i ?>').val(),$('#del_moisdebut<?= $i ?>').val(),$('#del_annedebut<?= $i ?>').val(),$('#del_idclient<?= $i ?>').val(),$('#idcontract<?= $i ?>').val(),$('#billing_date<?= $i ?>').val())" data-dismiss="modal"><i class="ti-trash"></i>Supprimer
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