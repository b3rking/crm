<?php
require_once("../../model/connection.php");
require_once("../../model/service.class.php");

$service = new Service();
$n = $_GET['n'];
$status = ['active' => 0,'annuler' => 1];
?>
<div id="element<?=$n?>">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 col-lg-2 control-label">Service</label><div class="form-group col-sm-9 col-lg-10"><select id="serviceInclu<?=$n?>" class="form-control form-control-sm">
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
        <div class="col-lg-3 col-md-6">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Bande passante</label>
                <div class="form-group col-sm-9">
                   <input type="text" id="bandepassanteInclu<?=$n?>" class="form-control form-control-sm" autocomplete="">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant</label><div class="form-group col-sm-9">
                    <div class="input-group">
                        <input type="number" class="form-control form-control-sm" id="montantInclu<?=$n?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Quantite</label><div class="form-group col-sm-9">
                    <div class="input-group">
                        <input type="number" class="form-control form-control-sm" id="quantite<?=$n?>" value="1" min="1">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="row">
                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom</label>
                <div class="form-group col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="nom_client<?=$n?>">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="row">
                <label for="exampleInputEmail3" class="col-sm-3 control-label">Adresse</label>
                <div class="form-group col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="adresse<?=$n?>">
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2">
            <div class="form-group">
                <label class="form-control btn">
                    <input type="checkbox" id="show_on_invoice<?=$n?>"> sur facture
                </label> 
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="row">
                <label for="exampleInputEmail3" class="col-sm-3 control-label">Etat</label>
                <div class="form-group col-sm-9">
                    <select id="contract_service_status<?=$n?>" class="form-control form-control-sm">
                    <?php
                    foreach ($status as $key => $data) 
                    {
                        if ($value3->status == $data) 
                        {
                        ?>
                            <option value="<?=$data?>" selected><?=$key?></option>
                        <?php
                        }
                        else
                        {
                        ?>
                            <option value="<?=$data?>"><?=$key?></option>
                        <?php
                        }
                    }
                    ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <button type="button" style="background-color: #7c4a2f" class="btn text-white" onclick="supServiceToContract()"><i class="ti-minus text"></i></button>
        </div>
    </div>
    <hr>
</div>