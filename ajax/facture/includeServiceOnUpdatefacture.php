<?php
require_once("../../model/connection.php");
require_once("../../model/service.class.php");

$service = new Service();
$n = $_GET['n'];
$facture_id = $_GET['facture_id'];
?>




<div id="element<?=$facture_id.$n?>">
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">
                Service</label><div class="form-group col-sm-9">
                    <!--<input type="text" id="service<=$facture_id.$n?>" value="<=$value2->ID_service?>" hidden>
                    <input type="text" class="form-control form-control-sm" id="serviceName<=$facture_id.$n?>" value="<=$value2->nomService?>" disabled>
                    <input type="text" id="monnaiservice<=$facture_id.$n?>" value="<=$value2->monnaie?>" hidden>-->
                    <input type="text" name="idFs<?=$facture_id.$n?>" id="idFs<?=$facture_id.$n?>" value="null" hidden>
                    <select class="form-control form-control-sm" id="service<?=$facture_id.$n?>">
                        <option></option>
                        <?php
                        foreach ($service->recupererServices() as $valu) 
                        {
                        ?>
                            <option value="<?=$valu->ID_service.'-'.$valu->nomService?>"><?=$valu->nomService?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div></div></div>
        <div class="col-lg-4 col-md-4">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant*</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="montant<?=$facture_id.$n?>">
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="col-sm-3 control-label">Quantite*</label>
            <div class="form-group col-sm-9"><input type="number" class="form-control form-control-sm" id="quantite<?=$facture_id.$n?>" value="1"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-6 control-label">Bande passante</label><div class="form-group col-sm-9">
                    <input type="text" id="bandeP<?=$facture_id.$n?>" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
            <div class="form-group col-sm-9">
                <textarea class="form-control form-control-sm" id="description<?=$facture_id.$n?>">
                </textarea>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <label class="control-label">Billing cycle</label>
            <div class="form-group col-sm-9">
                <select class="form-control form-control-sm" id="Billing_cycle<?=$facture_id.$n?>" onchange="setBillingCycleContent($(this).val(),'<?=$facture_id.$n?>')">
                    <option value="0">jour</option>
                    <option value="1" selected="">mois</option>
                    <option value="2">une seule fois</option>
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-md-2" id="divReduction0">
            <label for="exampleInputuname3" class="col-sm-3 control-label">Reduction(%)</label>
            <div class="form-group col-sm-9">
                <input type="number" class="form-control form-control-sm" id="reduction<?=$facture_id.$n?>"  min="0">
            </div>
        </div>
    </div>
    <div id="billingCycleContent<?=$facture_id.$n?>">
        <div>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-lg-2">
            <button type="button" class="btn text-white" style="background-color: #7c4a2f" onclick="supServiceToFacture()"><i class="ti-minus text"></i></button>
        </div>
    </div>-->
</div>