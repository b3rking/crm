<?php
ob_start();
$value = $client->afficherUnClentAvecContract($id)->fetch(); 
$month_etiquete = [1=>'Jan',2=>'Fev',3=>'Mars',4=>'Avr',5=>'Mai',6=>'Juin',7=>'Juil',8=>'Aout',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'];
//$date = date_parse(date('Y-m-d'));
//$mois = $date['month'];
//$annee = $date['year'];
//$balance_initiale = ($contract->getBalanceInitiale($id)->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($id)->fetch()['montant']);
$balance_initiale = ($contract->getBalanceInitiale($id) ? $contract->getBalanceInitiale($id)->fetch() : 0);
        $balance_initiale = ($balance_initiale != 0 ? $balance_initiale['montant'] : 0);
    // GRAPHE DU SOLDE CLIENT

    $balance = '';
    $solde_annuel ='';
    $taux = 1765;
    //$taux = 2000;

    for ($i=6; $i > 0; $i--) 
    {
        $date = date_parse(date("d-m-Y",strtotime(-$i." Months")));
        $mois = $date['month'];
        $annee = $date['year']; 
        //$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
        //$date1 = $annee.'-'.$i.'-1';
        $date2 = $annee.'-'.$mois.'-01';
        $month = ($mois < 10 ? '0'.$mois : $mois);
        $year_month = $annee.$month;
        //$balance = $contract->getMontantFactureDunClientDuDebutAuneDate($date2,$id)->fetch()['montant'] - $contract->getMontantPayementDunClientDuDebutAuneDate($date2,$id)->fetch()['montant']+$balance_initiale;
        $facture_bif = 0;
        $paiement_bif = 0;
        foreach ($contract->getMontantFactureDunClientDuDebutAuneDate($date2,$id) as $value1) 
        {
            $facture_bif += ($value1->monnaie == 'BIF' ? round($value1->montant) : round($value1->montant)*$taux);
        }
        foreach ($contract->getMontantPayementDunClientDuDebutAuneDate($year_month,$id) as $value1) 
        {
            $paiement_bif += ($value1->exchange_currency == 'BIF' ? $value1->montant : $value1->montant*$taux);
        }
        $balance = $facture_bif + $balance_initiale - $paiement_bif;
        //if (empty($balance)) 
            //$balance = 0;
            $solde_annuel .= "{y:'".$month_etiquete[$mois]."',a:".$balance."}, ";
        if ($i == 1) 
        {
            $date = date_parse(date("d-m-Y"));
            $mois = $date['month'];
            $annee = $date['year'];
            //$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

            $date2 = $annee.'-'.$mois.'-01';
            $month = ($mois < 10 ? '0'.$mois : $mois);
            $year_month = $annee.$month;
            $facture_bif = 0;
            $paiement_bif = 0;
            foreach ($contract->getMontantFactureDunClientDuDebutAuneDate($date2,$id) as $value1) 
            {
                $facture_bif += ($value1->monnaie == 'BIF' ? round($value1->montant) : round($value1->montant)*$taux);
            }
            foreach ($contract->getMontantPayementDunClientDuDebutAuneDate($year_month,$id) as $value1) 
            {
                $paiement_bif += ($value1->exchange_currency == 'BIF' ? $value1->montant : $value1->montant*$taux);
            }
            $balance = $facture_bif - $paiement_bif + $balance_initiale;
            $solde_annuel .= "{y:'".$month_etiquete[$mois]."',a:".$balance."}, ";
        }
    }
    $solde_annuel = substr($solde_annuel, 0,-2);

?>
<script type="text/javascript">
    var solde_annuel_dun_client = [<?php echo $solde_annuel;?>];
</script>
<input type="text" id="webroot" value="<?=ROOT?>" hidden>
<input type="text" name="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <span id='rep'></span>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
            </ol>
            <?php
            if (!empty($value))
            {
                $idcontract = $value['ID_contract'];
                $next_billing_date = $value['next_billing_date'];
                if($_SESSION['profil_name'] != 'Technicien')
                {
                    $date = date_parse(date("d-m-Y"));
                    $mois = $date['month'];
                    $annee = $date['year'];
            ?>
                    <a href="<?=WEBROOT;?>resumeclient-<?=$id?>" class="btn d-none d-lg-block m-l-15 text-white" style="background-color: #7c4a2f"><i class="fa fa-file"></i> Imprimer resumé</a>

                    <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Nouvelle facture</button>
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
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date*</label><div class="form-group col-sm-9"><input type="date" class="form-control form-control-sm" id="datefacture" value="<?=date('Y-m-d')?>"></div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="row"><label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Monnaie*</label><div class="form-group col-sm-9 col-lg-7">
                                <select class="form-control form-control-sm" id="monnaie">
                                    <option value="BIF">BIF</option>
                                    <option value="USD">USD</option>
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
                                    <input type="text" id="idclient_facture" class="form-control form-control-sm" autocomplete="off" value="<?=$value['Nom_client']?>">
                                    <input type="text" id="customerInvoice" hidden="" value="<?=$id."_".$value['ID_contract']."_".$value['billing_number']."_".$value['next_billing_date']?>">
                                    <!--<div id="modal"></div>-->

                                    <input type="text" id="next_billing_date" hidden="" value="<?=$value['next_billing_date']?>">
                                    <input type="text" id="idcontract" hidden="" value="<?=$value['ID_contract']?>">
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <hr>
                    <!--<input type="text" id="billing_number" hidden="" value="<=$value['billing_number']?>">-->
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">
                                Service*</label><div class="form-group col-sm-9">
                                    <select class="form-control form-control-sm" id="service0">
                                        <option></option>
                                        <?php
                                        foreach ($service->recupererServices() as $val) 
                                        {
                                        ?>
                                            <option value="<?=$val->ID_service.'-'.$val->nomService?>"><?=$val->nomService?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant*</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control form-control-sm" id="montantt0" value="0">
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
                                <label for="exampleInputuname3" class="col-sm-6 control-label">Bande passante</label><div class="form-group col-sm-9">
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
                                    for ($i=1; $i<13  ; $i++) 
                                    {
                                        if ($i == $mois) 
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
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee</label>
                                <div class="form-group col-sm-9">
                                    <input type="number" id="annee" value="<?=$annee?>" class="form-control form-control-sm" min="<?=$annee-1?>" max="<?=$annee+1?>">
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
                <button style="background-color: #7c4a2f" class="btn waves-effect text-left text-white" onclick="creefacture($('#datefacture').val(),$('#monnaie').val(),$('#mois').val(),$('#annee').val(),$('#tva').val(),$('#customerInvoice').val())"><i class="fa fa-check"></i>Enregistrer
                    </button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

                    <button type="button" style="background-color: #7c4a2f" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg-paiement"><i class="fa fa-plus-circle"></i> Nouveau paiement</button>
                    <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg-paiement" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
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
                                    <input type="text" id="idclient_paiement" class="form-control form-control-sm" value="<?='ID-'.$id.'-'.$value['Nom_client']?>">
                                    <input type="text" id="idclient" value="<?=$id?>" hidden>
                                    <!--<div id="autocomplete_conteneur"></div>-->
                                    <input type="text" id="billing_number" value="<?=$value['billing_number']?>" hidden="">
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                            <div class="form-group">
                                Facture paie
                                <select id="facturepaye" class="form-control" multiple="">
                                <?php
                                foreach ($contract->getFactureNonPayerDunClient($id) as $val) 
                                {
                                    if ($val->reste > 0 ) 
                                        $montant = round($val->reste);
                                    else
                                        $montant = round($val->montant);
                                ?>
                                    <option value="<?=$val->facture_id.'='.$montant.'='.$val->monnaie.'='.$val->exchange_rate.'='.$val->mois_debut.'='.$val->annee.'='.$val->billing_date?>">
                                        <?php echo 'No '.$val->numero.', mois: '.$val->mois_debut.'/'.$val->annee.', montant: '.$montant.' '.$val->monnaie.', taux: '.$val->exchange_rate?>
                                    </option>
                                <?php
                                }
                                ?>
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
                                        <option value="BIF">BIF</option>
                                        <option value="USD">USD</option>
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
                                        <option value="BIF">BIF</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Banque de versement</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select class="form-control" id="banqueV">
                                    <php
                                    foreach ($comptabilite->affichageBanque() as $data)
                                    {?>
                                    <option value="<php echo $data->ID_banque.'_'.$data->monnaie?>"><php echo $data->nom . '-' . $data->monnaie?></option>
                                    <php
                                    }
                                    ?> 
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!--<div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Banque</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <select class="form-control" id="banqueV">
                                    <php
                                    foreach ($comptabilite->affichageBanque() as $data)
                                    {?>
                                    <option value="<php echo $data->ID_banque?>"><php echo $data->nom . '-' . $data->monnaie?></option>
                                    <php
                                    }
                                    ?> 
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Taux de change</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="text"  class="form-control" id="taux_de_change">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Mode* paiement</label>
                                <div class="col-sm-9 col-lg-7">
                                    <select class="form-control form-control-sm" id="methodepaiement">
                                    <option></option>
                                    <option value="CASH">CASH</option>
                                    <option value="CHEQUE">CHEQUE</option>
                                    <option value="TRANSFERT">TRANSFERT</option>
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Reference</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"></div>
                                        <input type="text" class="form-control form-control-sm"  id="reference">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group row" >
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="date" class="form-control form-control-sm" value="<?= date('Y-m-d')?>" id="datepaiements">
                                        <input type="text" id="iduser"  value="<?= $_SESSION['ID_user']?>" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" style="background-color: #7c4a2f" class="btn waves-effect text-left text-white" onclick="ajout_paiement($('#idclient').val(),$('#billing_number').val(),$('#montantpaye').val(),$('#devises').val(),$('#methodepaiement').val(),$('#reference').val(),$('#datepaiements').val(),$('#taux_de_change').val(),$('#exchange_currency').val(),$('#iduser').val())"> <i class="fa fa-check"></i>Ajouter</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
            <div class="card-header" style="background-color: #ef7f22;height: 1.5rem;padding-top: 0.1rem">
                <h6 class="text-white">Detail client</h6>
                <span id="msg"></span>
            </div>
            <div class="card-body">
                <?php
                if (!empty($value)) 
                {
                ?>
                <div class="table-responsive">
                    <table class="table color-table ">
                        <tbody >
                            <tr>
                                <td>BILLING NUMBER</td>
                                <td><?= $value['billing_number']?></td>
                            </tr>
                            <tr>
                                <td>NOM</td>
                                <td><?= $value['Nom_client']?></td>
                            </tr>
                            <tr>
                                <td>TELEPHONE</td>
                                <td><?= $value['telephone'].' /'.$value['mobile_phone']?></td>
                            </tr>
                            <tr>
                                <td>EMAIL</td>
                                <td><?= $value['mail']?></td>
                            </tr>
                            <tr>
                                <td>PERSONNE DE CONTACT</td>
                                <td><?= $value['personneDeContact']?></td>
                            </tr>
                            <tr>
                                <td>ADRESSE</td>
                                <td><?= $value['adresse']?></td>
                            </tr>
                            <tr>
                                <td>TYPE</td>
                                <td><?php
                                $customer_type = ['paying'=>'Payant','free'=>'Gratuit','gone'=>'Partie','staff'=>'Staff','potentiel'=>'Potentiel','unknown'=>'Inconnu'];
                                /*if ($value['type_client'] == 'paying')$type_client = 'payant';
                                if ($value['type_client'] == 'free')$type_client = 'gratuit';
                                if ($value['type_client'] == 'gone')$type_client = 'partie';*/
                                 echo $customer_type[$value['type_client']]?></td>
                            </tr>
                            <tr>
                                <td>NIF</td>
                                <td><?= $value['nif']?></td>
                            </tr>
                            <tr>
                                <td>SERVICE/CONNEXION</td>
                                <td><?php
                                $services = '';
                                foreach ($contract->getServiceToPrintToContract($value['ID_contract']) as $contractService) 
                                {
                                    
                                    if ($contractService->status == 0) 
                                    {
                                        $services .= '  '.$contractService->nomService.' '.$contractService->bandepassante.', ';
                                    }
                                }
                                $services = rtrim($services, ', ');
                                echo $services?></td>
                            </tr>
                            <?php
                            if($_SESSION['profil_name'] != 'Technicien')
                            {
                            ?>
                                <tr>
                                    <td>SOLDE</td>
                                <td>
                                    <?php
                                    //$solde = $contract->getSommeTotaleFactureDunClient($id)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($id)->fetch()['montant'];
                                    if ($value['solde'] > 0) 
                                    {
                                    ?>
                                        <h5><span style="background-color: red"><?=number_format(round($value['solde'])).' BIF'?></span></h5>
                                    <?php
                                    }
                                    else
                                    {
                                        echo number_format(round($value['solde'])).' BIF';
                                    }
                                ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td>STATUT</td>
                                <td><?= $value['etat']?></td>
                            </tr>
                             <tr>
                                <td>MENSUALITE</td>
                                <td>
                                    <?php

                                 //$value['montant'].' '.$value['monnaie_facture'];
                                // $clientPaying = $client->afficherUnClentAvecContract($value->ID_client)->fetch();
                                //if (!empty($clientPaying))
                                //{
                                    $montant_tva = $value['montant']*$value['tva']/100;
                                    $montant_total = $montant_tva+$value['montant'];
                                    echo round($montant_total).' '.$value['monnaieContract'];
                               // } 
                               //else echo "";
                                 ?>
                                     
                                 </td>
                            </tr>
                            <tr>
                                <td>COMMENTAIRE</td>
                                <td><?= $value['commentaire']?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            <?php 
                }
                else
                {
                    if ($value = $client->afficherUnClentSansContract($id)->fetch()) 
                    {
                    ?>
                        <div class="table-responsive">
                            <table class="table color-table warning-table">
                                <tbody>
                                    <tr>
                                        <td>BILLING NUMBER</td>
                                        <td><?= $value['billing_number']?></td>
                                    </tr>
                                    <tr>
                                        <td>NOM</td>
                                        <td><?= $value['Nom_client']?></td>
                                    </tr>
                                    <tr>
                                        <td>TELEPHONE</td>
                                        <td><?= $value['telephone'].' /'.$value['mobile_phone']?></td>
                                    </tr>
                                    <tr>
                                        <td>EMAIL</td>
                                        <td><?= $value['mail']?></td>
                                    </tr>
                                    <tr>
                                        <td>PERSONNE DE CONTACT</td>
                                        <td><?= $value['personneDeContact']?></td>
                                    </tr>
                                    <tr>
                                        <td>ADRESSE</td>
                                        <td><?= $value['adresse']?></td>
                                    </tr>
                                    <tr>
                                        <td>TYPE</td>
                                        <td><?= $value['type_client']?></td>
                                    </tr>
                                    <tr>
                                        <td>NIF</td>
                                        <td><?= $value['nif']?></td>
                                    </tr>
                                    <tr>
                                        <td>COMMENTAIRE</td>
                                        <td><?= $value['commentaire']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    }
                }
            ?>
            </div>
        </div>
    </div>
</div><!--/.row-->

<?php
    if($_SESSION['profil_name'] != 'Technicien') 
        require 'vue/admin/client/account_history.php';
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
            <div class="card-header" style="background-color: #ef7f22;height: 1.5rem;padding-top: 0.1rem">
                <h6 class="text-white">Tickets</h6>
                <span id="msg"></span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ticketDetailClient" class="table table-bordered table-striped">
                        <thead style="background-color: #ef7f22" class="text-white">
                            <tr>
                                <th>CREATION</th>
                                <th>TICKET</th>
                                <th>DESCRIPTION</th>
                                <th>TECHNICIEN EN CHARGE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tfoot style="background-color: #ef7f22" class="text-white">
                            <tr>
                                <th>CREATION</th>
                                <th>TICKET</th>
                                <th>DESCRIPTION</th>
                                <th>TECHNICIEN EN CHARGE</th>
                                <th>STATUS</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            foreach($ticket->recupererTousTicketDunClient($id) as $value)
                            {
                            ?>
                            <tr>
                                <td><?php echo $value->created_at?></td>
                                <td><a href="<?=WEBROOT;?>detailTicket-<?= $value->id?>"><?php echo 'Ticket#'.$value->id;?><a/></td>
                                <td><?php echo $value->description?></td>
                                <td><?php echo $value->nom_user?></td>
                                <td>
                                    <?php if($value->status == 'ouvert')
                                {
                                    ?>
                                    <span class="label label-danger"><?php echo $value->status?></span>
                                    <?php
                                }
                                elseif($value->status == 'fermer') 
                                {?>
                                    <span class="label label-success font-bold"> <?php echo $value->status?></span>
                                <?php   
                                }
                                ?>
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
</div><!-- /.row-->

<?php require_once 'vue/admin/client/customer_notes.php'?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
            <div class="card-header" style="background-color: #ef7f22;height: 1.5rem;padding-top: 0.1rem">
                <h6 class="text-white">Materiels</h6>
                <span id="msg"></span>
            </div>
            <div class="card-body">
                <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i> Attribuer materiel  </button><br>
<!-- Modal -->
<div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lgs">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Attibuer equipement a ce client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                             <input type="text" id="refclient" value="<?=$id?>" class="form-control"hidden>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Equipement</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                         <select class="form-control" id="typeEquipement" onchange="getEquipementByType($(this).val())">
                                          <option value="">faire votre choix</option>
                                          <option value="antenne">Antenne</option>
                                          <option value="routeur">Routeur</option>
                                          <option value="switch">Switch</option>
                                        </select>
                                        <input type="text" id="datedistribution" value="<?=date('Y-m-d')?>" class="form-control" hidden> 
                                        <input type="text" id="user"  value="<?php echo $_SESSION['ID_user']?>" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-lg-12 col-md-12" id="divInclutype_equipement"></div>
                    </div><!-- END ROW-->
                </form>
            </div>
            <div class="modal-footer">
                <span id="msg"></span>
                <button type="button" style="background-color: #8b4513"class="btn text-white" onclick="attribuer_equipement_client($('#refclient').val(),$('#typeEquipement').val(),$('#datedistribution').val(),$('#user').val())"> <i class="fa fa-check"></i> Attribuer</button>
                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!--/.modal-dialog -->
</div>
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID equipement</th>
                                <th>Type</th>
                                <th>Fabriquant</th>
                                <th>model</th>
                                <th>adresse mac</th>
                                <th>date</th>
                                <th>En charge</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID equipement</th>
                                <th>Type</th>
                                <th>Fabriquant </th>
                                <th>Model</th>
                                <th>Adresse mac</th>
                                <th>Date</th>
                                <th>En charge</th>
                            </tr>
                        </tfoot>
                        <tbody id="retour">
                        <?php 
                        $i =0;
                        foreach($equipement->getEquipement_Dun_client($id) as $value)
                        {
                            $i++;
                        ?>
                            <tr>
                                <td><?php echo $value->ID_equipement?></td>
                                <td><?php echo $value->type_equipement?></td>
                                <td><?php echo $value->fabriquant?> </td>
                                <td><?php echo $value->model?></td>
                                <td>
                                    <?php
                                        foreach ($equipement->recupereMacAdresses($value->ID_equipement) as $value2) 
                                        {
                                            echo $value2->mac.'</br>';
                                            
                                        }
                                    ?>
                                </td>
                                <td><?php echo $value->date_attribution_equip?></td>
                                <td><?=$value->nom_user?></td> 
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
</div><!-- /.row-->

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
            <div class="card-header" style="background-color: #ef7f22;height: 1.5rem;padding-top: 0.1rem">
                <h6 class="text-white">Accessoires</h6>
                <span id="msg"></span>
            </div>
            <div class="card-body">
                

                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Accessoire</th>
                                <th>Nombre</th>
                                <th>Motif</th>
                                 <th>Date attribution</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Accessoire</th>
                                <th>Nombre</th>
                                <th>Motif</th>
                                 <th>Date attribution</th>
                                
                            </tr>
                        </tfoot>
                        <tbody id="retourjs">
                        <!--<php 
                        $i =0;
                        
                        foreach($equipement->getAccessoireAunClient($id) as $value)
                        {
                            $i++;
                        ?>
                            <tr class="font-bold">
                                <td><php echo $value->categorie?></td>
                               <td><php echo $value->quantite?> </td>
                               <td><php echo $value->motifs?> </td>
                               <td><php echo $value->dateattribaccessoire?></td>

                            </tr>  
                        <php
                        }
                        ?>-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.row-->

<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header" style="background-color: #ef7f22;height: 1.5rem;padding-top: 0.1rem">
                <h6 class="text-white">Fichier attaché</h6>
            </div>
            <div class="card-body">
                <div id="save"></div>
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Client</th>
                                <th>Nom</th>
                                <th>Fichier</th>
                                <th>Modification</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Numero</th>
                                <th>Client</th>
                                <th>Nom</th>
                                <th>Fichier</th>
                                <th>Modification</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="rep_fichier_attacher">
                            <?php 
                            $i = 0; 
                            $y = 0;
                            foreach($contract->getAttachFileForOneClient($id) as $value)
                            {
                                $i++;
                            ?>
                            <tr class="font-bold">
                                <td> <?php echo $value->ID_fichier_client;?></td>
                                <td><?php echo $value->Nom_client;?></td>
                                <td> <?php echo $value->nom;?></td>
                                <td ><a href="<?=WEBROOT?>uploads/customer_file/file/<?=$value->ID_fichier_client.'/'.$value->fichier?>">Download</a></td>
                                <td><?= $value->date_fichier?></td>
                                <td class="text-nowrap"> 
                                    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
            <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Modification de fichier attaché</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                           <form class="form-horizontal p-t-20">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10">
                                        <div class="row">
                                         <input type="number" id="numerofichier<?=$i?>" value="<?php echo $value->ID_fichier_client;?>"hidden>
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
                                            <div class="form-group col-sm-9">
                                                <input type="text" id="idclientOnContract<?=$i?>" value="<?php echo $value->Nom_client?>" class="form-control" autocomplete="off">
                                                    <div id="modal"></div>
                                            </div>              
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                    <div class="row">
                        <div class="col-lg-10 col-md-10">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="mdi mdi-file"></i></span>
                                        </div>
                                        <input type="text" id="nom_fichier<?=$i?>" class="form-control" value="<?php echo $value->nom?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Attache fichier</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="icon-paper-clip"></i></span></div>
                                        <input type="file" id="fichier_doc<?=$i?>" class="form-control" value="<?php echo $value->fichier?>">
                                    </div>
                               </div>
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
                            <div class="form-group row" >
                                <div class="col-sm-9" hidden="">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span>
                                        </div>
                                        <div> <input type="text" id="userfile"  value="<?php echo $_SESSION['ID_user']?>"></div>
                                        <input type="date" class="form-control" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" id="datecreation">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- END ROW-->
                </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #8b4513" class="btn text-white waves-effect" onclick="updatefichierClient($('#numerofichier<?=$i?>').val(),$('#idclientOnContract<?=$i?>').val(),$('#nom_fichier<?=$i?>').val(),$('#fichier_doc<?=$i?>').val())"><i class="fa fa-check"></i>Modifier 
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
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
                <h4 class="modal-title" id="mySmallModalLabel">Supprimer Client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body"> 
                <input type="text" class="form-control" id="del_idfichier<?=$i?>" value="<?=$value->ID_fichier_client?>" hidden>
                <input type="text" id="del_nomFichier<?=$i?>" value="<?=$value->fichier?>" hidden>
                Voulez-vous supprimer ce client?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteFichierAttacher($('#del_idfichier<?=$i?>').val(),$('#del_nomFichier<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i></button>
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