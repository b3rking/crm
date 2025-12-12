<?php
require_once("../../model/connection.php");
require_once("../../model/service.class.php");

$service = new Service();
$n = $_GET['n'];
$facture_id = $_GET['facture_id'];
?>




<div id="element<?=$facture_id.$n?>">
    <div class="row">
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="control-label">
                Service</label>
            <div class="form-group">
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
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="control-label">Montant*</label>
            <div class="form-group">
                <input type="text" class="form-control form-control-sm" id="montant<?=$facture_id.$n?>">
            </div>
        </div>
        <div class="col-lg-1 col-md-3">
            <label for="exampleInputuname3" class="control-label">Quantite*</label>
            <div class="form-group">
                <input type="number" class="form-control form-control-sm" id="quantite<?=$facture_id.$n?>" value="1">
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="control-label">Bande passante</label>
            <div class="form-group">
                <input type="text" id="bandeP<?=$facture_id.$n?>" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label class="control-label">Billing cycle</label>
            <div class="form-group">
                <select class="form-control form-control-sm" id="Billing_cycle<?=$facture_id.$n?>" onchange="setBillingCycleContent($(this).val(),'<?=$facture_id.$n?>')">
                    <option value="0">jour</option>
                    <option value="1" selected="">mois</option>
                    <option value="2">une seule fois</option>
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <label for="exampleInputuname3" class="control-label">Description</label>
            <div class="form-group">
                <textarea class="form-control form-control-sm" id="description<?=$facture_id.$n?>">
                </textarea>
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