<?php
require_once("../../model/connection.php");
require_once("../../model/service.class.php");

$service = new Service();
$n = $_GET['n'];
$idcontract = $_GET['idcontract'];
$status = ['active' => 0,'annuler' => 1];
?>
<div id="element<?=$idcontract.$n?>">
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">
                Service</label>
                <div class="form-group col-sm-9">
                    <input type="text" id="serviceinclu_id<?=$idcontract.$n?>" value="null" hidden>
                    <select class="form-control form-control-sm" id="service<?=$idcontract.$n?>">
                        <option value=""></option>
                        <?php
                        foreach ($service->recupererServices() as $value) 
                        {
                        ?>
                            <option value="<?=$value->ID_service?>"><?=$value->nomService?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Bande passante</label>
                <div class="form-group col-sm-9 col-lg-8">
                    <input type="text" class="form-control form-control-sm" id="bandepassante<?=$idcontract.$n?>">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Montant</label>
                <div class="form-group col-sm-9 col-lg-8">
                    <div class="form-group">
                        <input type="number" class="form-control form-control-sm" id="montant<?=$idcontract.$n?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Quantite</label><div class="form-group col-sm-9 col-lg-7">
                    <input type="number" class="form-control form-control-sm" id="quantite<?=$idcontract.$n?>" value="1" min="0">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-8">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-1 control-label">Nom</label>
                <div class="form-group col-sm-9 col-lg-11">
                    <input type="text" class="form-control form-control-sm" id="nom<?=$idcontract.$n?>">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-8">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-1 control-label">Adresse</label>
                <div class="form-group col-sm-9 col-lg-11">
                    <input type="text" class="form-control form-control-sm" id="adress<?=$idcontract.$n?>">
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-1 control-label">Status</label>
                <div class="form-group col-sm-9 col-lg-11">
                    <select id="satus_service<?=$idcontract.$n?>" class="form-control form-control-sm">
                        <?php
                        foreach ($status as $key => $data) 
                        {
                        ?>
                            <option value="<?=$data?>"><?=$key?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group">
                <label class="form-control btn">
                    <input type="checkbox" id="show_on_facture<?=$idcontract.$n?>">
                    Afficher sur facture
                </label> 
            </div>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-lg-2">
            <button type="button" style="background-color: #7c4a2f" class="btn text-white" onclick="supServiceToContract()"><i class="ti-minus text"></i></button>
        </div>
    </div>-->
    <hr>
</div>

