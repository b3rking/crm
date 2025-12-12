<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/service.class.php");

$contract = new Contract();
$service = new Service();
$n = $_GET['n'];
?>
<div id="element<?=$n?>">
    <div class="row">
        <div class="col-lg-5 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-5 control-label">
                Service</label>
                <div class="form-group col-sm-9">
                    <select class="form-control form-control-sm" id="service<?=$n?>">
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
        <div class="col-lg-5 col-md-4">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-5 control-label">Montant</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="number" class="form-control form-control-sm" id="montant<?=$n?>">
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <label class="control-label">Quantite</label>
            <div class="form-group col-sm-9">
                <input type="number" class="form-control form-control-sm" id="quantite<?=$n?>" value= "1">
            </div>
        </div>
    </div><!-- End row -->
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-6 control-label">Bande passante</label>
                <div class="form-group col-sm-9">
                   <input type="text" id="bandeP<?=$n?>" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <label for="exampleInputuname3" class="col-sm-5 control-label">Description</label>
            <div class="form-group col-sm-9">
                <textarea class="form-control form-control-sm" id="description<?=$n?>"></textarea>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <label class="control-label">Billing cycle</label>
            <div class="form-group col-sm-9">
                <select class="form-control form-control-sm" id="billing_cycle<?=$n?>" onchange="setBillingCycleContent($(this).val(),n)">
                    <option value=""></option>
                    <option value="0">jour</option>
                    <option value="1">mois</option>
                    <option value="2">une seule fois</option></select>
            </div>
        </div>
    </div><!--End row -->
    <div id="billingCycleContent<?=$n?>">
        <div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <button type="button" class="btn text-white" style="background-color: #7c4a2f" onclick="supServiceToCeateProformat()"><i class="ti-minus text"></i></button>
        </div>
    </div>
    <hr>
</div>