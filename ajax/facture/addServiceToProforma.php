<?php
require_once("../../model/service.class.php");
$service = new Service();
$nb = $_GET['nbserviceProforma'];
?>
<div id="element<?=$nb?>">
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-5 control-label">
                Service</label>
                <div class="form-group col-sm-9">
                    <select class="form-control" id="service<?=$nb?>">
                        <option></option>
                        <?php
                        foreach ($service->recupererServices() as $value) 
                        {
                        ?>
                            <option value="<?=$value->ID_service.'_'.$value->montant.'_'.$value->bande_passante.'_'.$value->monnaie?>"><?=$value->nomService?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-5 control-label">Montant</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="number" class="form-control" id="montant<?=$nb?>">
                        <input type="text" id="monnaie<?=$nb?>" hidden>
                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-3">
            <label for="exampleInputuname3" class="col-sm-5 control-label">Quantite*</label>
            <div class="form-group col-sm-9"><input type="number" class="form-control" id="quantite<?=$nb?>" value="1"></div>
        </div>
        <div class="col-lg-2 col-md-2">
            <label for="exampleInputuname3" class="col-sm-6 control-label">Rediction</label><div class="form-group col-sm-9"><input type="text" class="form-control" id="reduction<?=$nb?>" value=0><span class="font-13 text-muted">e.g "99%"</span></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-6 control-label">Bande passante</label><div class="form-group col-sm-9">
                    <input type="text" id="bandeP<?=$nb?>" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <label for="exampleInputuname3" class="col-sm-5 control-label">Description</label>
            <div class="form-group col-sm-9">
                <textarea class="form-control" id="description<?=$nb?>"></textarea>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <label class="control-label">Billing cycle</label>
            <div class="form-group col-sm-9">
                <select class="form-control" id="billing_cycle<?=$nb?>" onchange="setBillingCycleContent($(this).val())">
                    <option value=""></option>
                    <option value="0">jour</option>
                    <option value="1">mois</option>
                    <option>une seule fois</option>
                </select>
            </div>
        </div>
        <div id="billingCycleContent<?=$nb?>">
            <div></div>
        </div>
    </div>
</div>
