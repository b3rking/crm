<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

 
	$comptabilite = new Comptabilite();

	if ($_GET['type'] == 'banque') 
	{
?>
		<div class="form-group row" class="col-lg-6 col-md-6" id="divInclubanqueCaisse">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Banque</label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"></span>
					</div>
					<select class="form-control" id="banque">
						<?php 
						foreach ($comptabilite->afficheBanque_montant() as $data)
						{?>
							<option value="<?php echo $data->ID_banque."_".$data->montantversser."_".$data->monnaie?>"><?php echo $data->nom . "_" . $data->monnaie?>
							</option>
						<?php
						}?>
					</select>
				</div>
			</div>
		</div>
<?php
	}
	elseif ($_GET['type'] == 'caisse') 
	{
?>
		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Grande caisse</label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"></span>
					</div>
					<select class="form-control" id="caisse">
						<?php 
						foreach ($comptabilite->grandeCaisseDisponibleNotNull() as $data)
						{?>
							<option value="<?php echo $data->ID_caisse."_".$data->montantCaisse."_".$data->devise?>"><?php echo $data->nomCaisse . "_" . $data->devise?>
							</option>
						<?php
						}?>
					</select>
				</div>
			</div>
		</div>
<?php
	}
?>