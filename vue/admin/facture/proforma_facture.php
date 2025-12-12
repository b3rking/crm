<?php
ob_start();
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
$month_etiquete = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
$date = date_parse(date('Y-m-d'));
$mois = $date['month'];
$annee = $date['year']; 
?>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<div class="row page-titles"><div class="col-md-5 align-self-center"></div><div class="col-md-7 align-self-center"><div class="d-flex justify-content-end align-items-center"><!--<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Fac</a></li>
                <li class="breadcrumb-item active">pro forma</li>
            </ol>-->
    <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Nouvel proforma</button>

    <!-- sample modal content -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Nouveau proforma</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal p-t-20" name="formaddClient" id="proformat_client">
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <div class="row">
                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Date*</label><div class="form-group col-sm-9"><input type="date" class="form-control form-control-sm" id="datefacture" value="<?=date('Y-m-d')?>"></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-3">
                                <div class="row"><label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Monnaie*</label><div class="form-group col-sm-9 col-lg-7">
                                    <select class="form-control form-control-sm" id="monnaie">
                                         <?php
                                    for ($l=0; $l < count($tbMonnaie); $l++) 
                                    {
                                    ?> 
                                        <option value="<?=$tbMonnaie[$l]?>"><?=$tbMonnaie[$l]?></option>
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
                                        <!--<input type="checkbox" checked="" id="enable_discount" value="0" onclick="showhide_reduction_facture(this)"> activer reduction-->
                                        <input type="checkbox" checked="" id="enable_discount" value="0" > activer reduction
                                    </label> 
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2" id="divReduction0" style="display: none;">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction" value=0 min="0"><span class="font-13 text-muted">e.g "99%"</span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="btn">
                                                <input type="checkbox" id="client_contracte" checked="checked">  Nouveau client
                                            </label> 

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <hr>
                    <div class="row" id="old_customer_contener" style="display: none;">
                        <div class="col-lg-10 col-md-10">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Client*</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" id="idclient_facture_proformat" class="form-control" autocomplete="off" onkeyup="autocomplete_facture_proformat($(this).val())">
                                    <div id="modal"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="conteneur_proformat">
                        <div class="row">
                            <div class="col-lg-3 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">Nom *</label>
                                <div class="form-group">
                                <input type="text" id="newclient" class="form-control form-control-sm"  placeholder="nom complet">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label"> phone</label>
                                <div class="form-group">
                                <input type="text" id="phone" class="form-control form-control-sm"  placeholder="Telephone">     
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">mail</label>
                                <div class="form-group">
                                    <input type="text" id="mailclient" class="form-control form-control-sm"  placeholder="e-mail">        
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">Adresse</label>
                                <div class="form-group">
                                    <input type="text" id="adresse_client" class="form-control form-control-sm"  placeholder="Enter name">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label for="exampleInputuname3" class="control-label">Localisation*</label>
                                <div class="form-group">
                                   <select  class="form-control form-control-sm" id="localisation">
                                    <?php 
                                    foreach ($localisation->selectionLocalisation() as $value)
                                    {?>
                                        <option value="<?php echo $value->ID_localisation?>"><?php echo $value->nom_localisation?></option>
                                    <?php
                                    }
                                    ?>
                                   </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <hr>
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="row">
                                <label for="exampleInputuname3" class="col-sm-5 control-label">
                                Service*</label>
                                <div class="form-group col-sm-9">
                                    <select class="form-control form-control-sm" id="service0">
                                        <option></option>
                                        <?php
                                        foreach ($service->recupererServices() as $value) 
                                        {
                                        ?>
                                            <option value="<?=$value->ID_service.'-'.$value->nomService?>"><?=$value->nomService?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-5 control-label">Montant*</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="number" class="form-control form-control-sm" id="montant0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3">
                            <label for="exampleInputuname3" class="col-sm-5 control-label">Quantite*</label>
                            <div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="quantite0" value="1"></div>
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
                            <label for="exampleInputuname3" class="col-sm-5 control-label">Description</label>
                            <div class="form-group col-sm-9">
                                <textarea class="form-control form-control-sm" id="description0"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <label class="control-label">Billing cycle</label>
                            <div class="form-group col-sm-9">
                                <select class="form-control form-control-sm" id="billing_cycle0" onchange="setBillingCycleContent($(this).val(),0)">
                                    <option value=""></option>
                                    <option value="0">jour</option>
                                    <option value="1">mois</option>
                                    <option value="2">une seule fois</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="billingCycleContent0">
                            <div></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <input type="text" id="nbservice" value="1" hidden="">
                            <!--<button type="button" class="btn btn-info " onclick="addServiceToProforma()">
                                Service
                                <i class="ti-plus text"></i>
                            </button>-->
                            <button type="button" style="background-color: #7c4a2f" class="btn text-white" onclick="ajoutServiceToProformat()">
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
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Tva</label>
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
                                        <option value=""></option>
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
                    <span id="msg"></span>
                    <button style="background-color: #7c4a2f" class="btn  waves-effect text-left text-white" onclick="creerProformat($('#datefacture').val(),$('#monnaie').val(),$('#mois').val(),$('#annee').val(),$('#tva').val())"><i class="fa fa-check"></i>Enregistrer
                    </button>
                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 text-white"><i class="fa fa-file"></i> Rapport récapitilatif</button>

    <!--<button type="button" style="background-color: #8b4513" class="btn text-white d-none d-lg-block m-l-15" onclick="raportFacture()"><i class="fa fa-file"></i> Génerer rapport</button>-->

    <form class="form-horizontal p-t-0" action="<?=WEBROOT?>report_fact" method="post" id="forem-reportFact">
        <input type="text" id="cond" name="cond" hidden="">
    </form>
</div>
</div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <form action="<?=WEBROOT?>filtreFactureProformat" method="get" id="filtreFactureProformat">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <input type="text" name="num_fact" id="num_fact" class="form-control form-control-sm input-filter" placeholder="Numero facture" value="<?=$numero?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <input type="text" name="nom_client" id="non_client_filtre" class="form-control form-control-sm input-filter" placeholder="Nom client" value="<?=$nom_client?>">
                        <!--<div id="modal_client_filter_fact"></div>-->
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-2">
                        <label for="exampleInputEmail3" class="control-label">Date</label>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                        <input type="date" name="date1" id="date1" class="form-control form-control-sm input-filter" value="<?=$date1?>">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                        <input type="date" name="date2" id="date2" class="form-control form-control-sm input-filter" value="<?=$date2?>">
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <!--<button type="button" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"onclick="filtreProformat($('#num_fact').val(),$('#non_client_filtre').val(),$('#date1').val(),$('#date2').val())"><i class="ti ti-filter"></i> Filtrer</button>-->
                        <button type="submit" style="background-color: #7c4a2f" class="btn btn-rounded btn-sm  text-white"><i class="ti ti-filter"></i> Filtrer</button>
                    </div>
                    <div class="col-lg-1 col-md-1">
                        <button type="button" class="btn btn-dark btn-rounded btn-sm"onclick="resetFiltreFactureProformat()"><i class="mdi mdi-refresh" data-dismiss="modal"></i> Anuler</button>
                    </div>
                </div>
            </form>
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
                                <th>Taux</th>
                                <th>Tva</th>
                                <th>Action</th>
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
                                <th>Taux</th>
                                <th>Tva</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                        <?php
                        $i = 0;
                        $y = 0;
                        $mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
                        foreach ($result as $value) 
                        {
                            $i++;
                        ?>
                            <tr>
                                <td><?=$value->date_creation?></td>
                                <td><?=$value->numero?></td>
                                <td><a href="<?= WEBROOT;?>detailClient-<?= $value->ID_client;?>"><b><?php echo $value->nom_client;?></b></a></td>
                                <td>
                                    <?php
                                    $serviceName = ''; 
                                    foreach ($contract->recupererServicesDunProformat($value->facture_id) as $service1)
                                    {
                                        $serviceName .=$service1->nomService.', ';
                                    }
                                    echo rtrim($serviceName,', ');
                                    ?>
                                </td>
                                <td><?=ucfirst($mois[$value->mois_debut])?></td>
                                <td><?=number_format(round($value->montant_total)).' '.$value->monnaie?></td>
                                <td><?=$value->exchange_rate?></td>
                                <td><?=$value->tva + $value->tvci?></td>
                                <td class="text-nowrap">
                                    <a href="<?=WEBROOT;?>historique-proformat-<?=$value->facture_id?>" data-toggle="tooltip"  data-original-title="historique"><i class="mdi mdi-eye m-r-10"></i></a>
                                    <a href="<?= WEBROOT;?>printProforma-<?= $value->facture_id;?>" data-toggle="tooltip" data-original-title="Print"> <i class="mdi mdi-printer text-inverse m-r-10"></i> </a>
                                    
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
                <form class="form-horizontal p-t-0" name="formaddClient">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date*</label><div class="form-group col-sm-9"><input type="date" class="form-control form-control-sm" id="datefacture<?=$i?>" value="<?=$value->date_creation?>"></div>
                                <input type="text" id="facture_id<?=$i?>" value="<?=$value->facture_id?>" hidden>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="row"><label for="exampleInputuname3" class="col-sm-3 col-lg-6 control-label">Monnaie</label><div class="form-group col-sm-9 col-lg-6">
                                <select class="form-control form-control-sm" id="monnaie<?=$i?>">
                                    <?php
                                    for ($v=0; $v < count($tbMonnaie); $v++) 
                                    { 
                                        if ($tbMonnaie[$v] == $value->monnaie)
                                        {
                                    ?>
                                            <option value="<?php echo $tbMonnaie[$v];?>" selected><?php echo $tbMonnaie[$v];?></option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?php echo $tbMonnaie[$v];?>"><?php echo $tbMonnaie[$v];?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            </div>
                        </div>
                        <?php
                        if ($value->show_rate == 1) 
                        {
                        ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" id="afficheTaux<?=$i?>" checked=""> affiche taux
                                    </label> 
                                </div>
                            </div>
                        <?php
                        }
                        else
                        {
                        ?>
                            <div class="col-lg-2 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <input type="checkbox" id="afficheTaux<?=$i?>"> afficher taux
                                    </label> 
                                </div>
                            </div>
                        <?php
                        }
                        if ($value->enable_discounts == 1) 
                        {
                        ?>
                            <div class="col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <!--<input type="checkbox" value="<=$i?>" id="enable_discount<=$i?>" checked onclick="showhide_reduction_facture(this)"> activer reduction-->
                                        <input type="checkbox" value="<?=$i?>" id="enable_discount<?=$i?>" checked> activer reduction
                                    </label> 
                                </div>
                            </div>
                            <!--<div class="col-lg-2 col-md-2" id="divReduction<=$i?>">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction<=$i?>" value="<=$value->reduction?>" min="0"><span class="font-13 text-muted">e.g "99%"</span></div>
                            </div>-->
                        <?php
                        }
                        else
                        {
                        ?>
                            <div class="col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label class="btn">
                                        <!--<input type="checkbox" value="<=$i?>" id="enable_discount<=$i?>" checked onclick="showhide_reduction_facture(this)"> activer reduction-->
                                        <input type="checkbox" value="<?=$i?>" id="enable_discount<?=$i?>"> activer reduction
                                    </label> 
                                </div>
                            </div>
                            <!--<div class="col-lg-2 col-md-2" id="divReduction<=$i?>" style="display: none;">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction</label><div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="reduction<=$i?>" value="<=$value->reduction?>" min="0"><span class="font-13 text-muted">e.g "99%"</span></div>
                            </div>-->
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if ($value->type_client == "potentiel") 
                    {
                    ?>
                        <input type="text" id="idclient<?=$i?>" value="<?=$value->ID_client?>" hidden>
                        <div class="row">
                            <div class="col-lg-3 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">Nom *</label>
                                <div class="form-group">
                                    <input type="text" id="nomclient<?=$i?>" class="form-control form-control-sm" value="<?=$value->nom_client?>">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label"> phone</label>
                                <div class="form-group">
                                    <input type="text" id="phone<?=$i?>" class="form-control form-control-sm" value="<?=$value->telephone?>">     
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">mail</label>
                                <div class="form-group">
                                    <input type="text" id="mailclient<?=$i?>" class="form-control form-control-sm" value="<?=$value->mail?>">        
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">Adresse</label>
                                <div class="form-group">
                                    <input type="text" id="adresse_client<?=$i?>" class="form-control form-control-sm"  value="<?=$value->adresse?>">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label for="exampleInputuname3" class="control-label">Localisation*</label>
                                <div class="form-group">
                                   <select  class="form-control form-control-sm" id="localisation<?=$i?>">
                                    <?php 
                                    foreach ($localisation->selectionLocalisation() as $loc)
                                    {
                                        if ($value->ID_localisation == $loc->ID_localisation)
                                        {
                                    ?>
                                            <option value="<?php echo $loc->ID_localisation?>" selected><?php echo $loc->nom_localisation?></option>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <option value="<?php echo $loc->ID_localisation?>"><?php echo $loc->nom_localisation?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                   </select>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    else
                    {
                    ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="row">
                                    <label for="exampleInputEmail3" class="col-sm-3 col-md-2 col-lg-1 col-xl-1 control-label">Client*</label>
                                    <div class="form-group col-sm-9 col-md-10 col-lg-10 col-xl-10">
                                        <input type="text" id="nomclient<?=$i?>" class="form-control form-control-sm" value="<?=$value->nom_client?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden="">
                            <input type="text" id="idclient<?=$i?>" value="<?=$value->ID_client?>">
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label"> phone</label>
                                <div class="form-group">
                                    <input type="text" id="phone<?=$i?>" class="form-control form-control-sm" value="<?=$value->telephone?>">     
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">mail</label>
                                <div class="form-group">
                                    <input type="text" id="mailclient<?=$i?>" class="form-control form-control-sm" value="<?=$value->mail?>">        
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-10">
                                <label for="exampleInputEmail3" class="control-label">Adresse</label>
                                <div class="form-group">
                                    <input type="text" id="adresse_client<?=$i?>" class="form-control form-control-sm"  value="<?=$value->adresse?>">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <label for="exampleInputuname3" class="control-label">Localisation*</label>
                                <div class="form-group">
                                    <input type="text" id="localisation<?=$i?>" value="<?=$value->ID_localisation?>">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <hr>

<?php 
$j = 0;
foreach ($contract->recupererServicesDunProformat($value->facture_id) as $value2)
{
    $j++;
    $y++;
?>
    <div class="row">
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="control-label">
                Service
            </label>
            <div class="form-group">
                <select class="form-control form-control-sm" id="service<?=$value->facture_id.$j?>">
                    <?php
                    foreach ($service->recupererServices() as $value3) 
                    {
                        if ($value3->ID_service == $value2->ID_service) 
                        {
                    ?>
                            <option value="<?=$value3->ID_service.'-'.$value3->nomService?>" selected><?=$value3->nomService?></option>
                    <?php
                        }
                        else
                        {
                    ?>
                            <option value="<?=$value3->ID_service.'-'.$value3->nomService?>"><?=$value3->nomService?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
                <input type="text" id="monnaiservice<?=$value->facture_id.$j?>" value="<?=$value2->monnaie?>" hidden>
                <input type="text" name="idFs<?=$value->facture_id.$j?>" id="idFs<?=$value->facture_id.$j?>" value="<?=$value2->idFs?>" hidden>
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="control-label">Montant*</label>
            <div class="form-group">
                <input type="text" class="form-control form-control-sm" id="montant<?=$value->facture_id.$j?>" value="<?=$value2->montant?>">
            </div>
        </div>
        <div class="col-lg-1 col-md-3">
            <label for="exampleInputuname3" class="control-label">Quantite*</label>
            <div class="form-group"><input type="number" class="form-control form-control-sm" id="quantite<?=$value->facture_id.$j?>" value="<?=$value2->quantite?>"></div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="control-label">Bande passante</label>
            <div class="form-group">
               <input type="text" id="bandeP<?=$value->facture_id.$j?>" class="form-control form-control-sm" value="<?=$value2->bande_passante?>">
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label class="control-label">Billing cycle</label>
            <div class="form-group">
                <select class="form-control form-control-sm" id="Billing_cycle<?=$value->facture_id.$j?>">
                    <?php
                    if ($value2->billing_cycle == 0) 
                    {
                    ?>
                        <option value="0" selected="">jour</option>
                        <option value="1">mois</option>
                        <option value="2">une seule fois</option>
                    <?php
                    }
                    elseif ($value2->billing_cycle == 1) 
                    {
                    ?>
                        <option value="0">jour</option>
                        <option value="1" selected="">mois</option>
                        <option value="2">une seule fois</option>
                    <?php
                    }
                    else
                    {
                    ?>
                        <option value="0">jour</option>
                        <option value="1">mois</option>
                        <option value="2" selected="">une seule fois</option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <label for="exampleInputuname3" class="control-label">Description</label>
            <div class="form-group">
                <textarea class="form-control form-control-sm" id="description<?=$value->facture_id.$j?>"><?=$value2->description?>
                </textarea>
            </div>
        </div>
    </div>
    <?php
    if ($value2->billing_cycle == 0) 
    {
    ?>
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <label class="control-label">Date debut</label>
                <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="startDate" id="startDate<?=$value->facture_id.$j?>" value="<?=$value2->startDate?>">
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <label class="control-label">Date fin</label>
                <div class="form-group">
                    <input type="date" class="form-control form-control-sm" name="endDate" id="endDate<?=$value->facture_id.$j?>" value="<?=$value2->endDate?>">
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <hr>
<?php
}
?>
<div class="row">
    <div class="col-lg-2">
        <button type="button" style="background-color: #7c4a2f" class="btn text-white" onclick="ajoutServiceToUpdateFactureProformat('<?=$value->facture_id?>','<?=$i?>')">
            Service
            <i class="ti-plus text"></i>
        </button>
    </div>
</div>
<hr>
<div id="service_contener<?=$i?>"></div>
<input type="text" id="nombreServiceUpdate<?=$i?>" value="<?=$j?>" hidden>
<input type="number" id="i<?=$i?>" value="<?=$i?>" hidden>
<input type="number" id="id_dernierService<?=$i?>" value="<?=$y?>" hidden>
                                <div class="row">
                                    <div class="col-lg-2 col-md-3">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                                            <div class="form-group col-sm-9">
                                                <select id="mois<?=$i?>" class="form-control form-control-sm">
                                        <?php
                                        for ($l=1; $l < 13; $l++)
                                        {
                                            if ($l == $value->mois_debut)
                                            {
                                        ?>
                                                <option value="<?=$l?>" selected><?=$mois[$l]?></option>
                                        <?php
                                            } 
                                            else
                                            {
                                        ?>
                                                <option value="<?=$l?>"><?=$mois[$l]?></option>
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
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee*</label>
                                            <div class="form-group col-sm-9">
                                                <input type="number" id="annee<?=$i?>" value="<?=$value->annee?>" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
<div class="col-lg-2 col-md-2">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">TVA</label>
        <div class="form-group col-sm-9">
            <input type="number" class="form-control form-control-sm" id="tva<?=$i?>" value="<?=$value->tva+$value->tvci?>">
        </div>
    </div>
</div>
<?php
if ($value->fixe_rate == 1) 
{
?>
<div class="col-lg-2 col-md-2">
    <div class="form-group">
        <label class="btn">
            <input type="checkbox" value="<?=$i?>" id="fixe_rate<?=$i?>" onclick="showHideFixedRateDiv(this)" checked> fixe taux
        </label> 
    </div>
</div>
<div class="col-lg-2 col-md-2" id="divTaux<?=$i?>">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Taux</label>
        <div class="form-group col-sm-9">
                <input type="number" class="form-control form-control-sm" id="taux<?=$i?>" value="<?=$value->exchange_rate?>">
        </div>
    </div>
</div>
<div class="col-lg-2 col-md-2" id="divMonnaie<?=$i?>">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
        <div class="form-group col-sm-9">
            <select class="form-control form-control-sm" id="exchange_currency<?=$i?>">
            <?php
                for ($v=0; $v < count($tbMonnaie); $v++) 
                { 
                    if ($tbMonnaie[$v] == $value->exchange_currency)
                    {
                ?>
                        <option value="<?php echo $tbMonnaie[$v];?>" selected><?php echo $tbMonnaie[$v];?></option>
                <?php
                    }
                    else
                    {
                ?>
                        <option value="<?php echo $tbMonnaie[$v];?>"><?php echo $tbMonnaie[$v];?></option>
                <?php
                    }
                }
            ?>
            </select>
        </div>
    </div>
</div>
<?php
}
else
{
?>
<div class="col-lg-2 col-md-2">
    <div class="form-group">
        <label class="btn">
            <input type="checkbox" value="<?=$i?>" id="fixe_rate<?=$i?>" onclick="showHideFixedRateDiv(this)"> fixe taux
        </label> 
    </div>
</div>
<div class="col-lg-2 col-md-2" style="display: none;" id="divTaux<?=$i?>">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Taux</label>
        <div class="form-group col-sm-9">
                <input type="number" class="form-control form-control-sm" id="taux<?=$i?>" value="<?=$value->exchange_rate?>">
        </div>
    </div>
</div>
<div class="col-lg-2 col-md-2" style="display: none;" id="divMonnaie<?=$i?>">
    <div class="row">
        <label for="exampleInputEmail3" class="col-sm-3 control-label">Monnaie</label>
        <div class="form-group col-sm-9">
            <select class="form-control form-control-sm" id="exchange_currency<?=$i?>">
            <?php
                for ($v=0; $v < count($tbMonnaie); $v++) 
                { 
                    if ($tbMonnaie[$v] == $value->exchange_currency)
                    {
                ?>
                        <option value="<?php echo $tbMonnaie[$v];?>" selected><?php echo $tbMonnaie[$v];?></option>
                <?php
                    }
                    else
                    {
                ?>
                        <option value="<?php echo $tbMonnaie[$v];?>"><?php echo $tbMonnaie[$v];?></option>
                <?php
                    }
                }
            ?>
            </select>
        </div>
    </div>
</div>
<?php
}
?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span id="msg-update"></span>
                <button style="background-color: #7c4a2f" class="btn waves-effect text-left text-white" onclick="updateProformat('<?=$value->type_client?>',$('#facture_id<?=$i?>').val(),$('#datefacture<?=$i?>').val(),$('#monnaie<?=$i?>').val(),$('#mois<?=$i?>').val(),$('#annee<?=$i?>').val(),$('#tva<?=$i?>').val(),$('#i<?=$i?>').val(),$('#id_dernierService<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-check"></i>Modifier
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
                            <button class="btn btn-danger waves-effect text-left" onclick="deleteProformat($('#id_factureDelete<?=$i?>').val())" data-dismiss="modal"><i class="ti-trash"></i>Supprimer
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