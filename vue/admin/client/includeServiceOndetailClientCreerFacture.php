<?php

$i = 0;
$nbservice = $contract->getNombreServiceDunContrat($value['ID_contract'])->fetch()['nbservice'];
foreach ($contract->getServiceToIncludeOnFacture($value['ID_contract']) as $value) 
{
    $i++;
?>
	<div class="row">
    	<div class="col-lg-4 col-md-4">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 control-label">
                Service</label><div class="form-group col-sm-9">
                    <input type="text" id="service<?=$i?>" value="<?=$value->ID_service?>" hidden>
    				<input type="text" class="form-control" value="<?=$value->nomService?>">
    			</div></div></div>
		<div class="col-lg-4 col-md-4">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Montant</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="number" class="form-control" id="montantt<?=$i?>" value="<?=$value->montant?>" disabled>
                        <input type="text" id="monnaie<?=$i?>" value="<?=$value->monnaie?>" hidden>
                        <div class="input-group-prepend"><span class="input-group-text"><?=$value->monnaie?></span></div>
                    </div>
                </div>
            </div>
    	</div>
    	<div class="col-lg-2 col-md-3">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Quantite*</label>
			<div class="form-group col-sm-9"><input type="number" class="form-control" id="quantite<?=$i?>" value="1"></div>
    	</div>
    	<div class="col-lg-2 col-md-2">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Reduction</label><div class="form-group col-sm-9"><input type="number" class="form-control" id="reduction<?=$i?>" value=0><span class="font-13 text-muted">e.g "99%"</span></div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-lg-4 col-md-4">
    		<div class="row">
    			<label for="exampleInputuname3" class="col-sm-3 control-label">Client</label><div class="form-group col-sm-9">
                    <input type="text" id="sous_client<?=$i?>" value="<?=$value->ID_client?>" hidden>
                    <input type="text" class="form-control" value="<?=$value->nom_client?>"></div>
    		</div>
    	</div>
		<div class="col-lg-4 col-md-4">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
			<div class="form-group col-sm-9">
				<textarea class="form-control" id="description<?=$i?>"></textarea>
			</div>
    	</div>
    	<div class="col-lg-4 col-md-4">
			<label class="control-label">Cycle facture</label>
			<div class="form-group col-sm-9">
				<select class="form-control" id="billing_cycle<?=$i?>" onchange="setBillingCycleContent($(this).val(),'<?=$i?>')">
                    <option value=""></option>
					<option value="0">jour</option>
					<option value="1">mois</option>
					<option>une seule fois</option>
				</select>
			</div>
    	</div>
    </div>
    <div id="billingCycleContent<?=$i?>">
        <div></div>
    </div>
    <?php
    if ($nbservice > 1) 
    {
?>
        <div class="row">
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="btn">
                            <input type="checkbox" id="retire<?=$i?>"> Retirer ce service sur cette facture
                        </label> 
                    </div>
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
<input type="text" id="nombreService" value="<?=$i?>" hidden>