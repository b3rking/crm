<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

 
	$comptabilite = new Comptabilite();

	if ($_GET['type'] == 'banque') 
	{
?>
		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Banque</label>
			<div class="col-sm-9">
				<select class="form-control" id="banque">
					<?php 
					foreach ($comptabilite->getBanqqueActive() as $data)
					{?>
						<option value="<?php echo $data->ID_banque."_".$data->montant."_".$data->monnaie?>"><?php echo $data->nom . "_" . $data->monnaie?>
						</option>
					<?php
					}?>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
	            <div class="form-group row">
	                <label for="exampleInputuname3" class="col-sm-3 control-label">Reference </label>
	                <div class="col-sm-9">
                        <input type="text" class="form-control" id="reference" placeholder="numero de cheque">
	                </div>
	            </div>
			</div>
		</div>
<?php
	}
	elseif ($_GET['type'] == 'caisse') 
	{
?>
		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label"> Caisse</label>
			<div class="col-sm-9">
				<select class="form-control" id="caisse">
					<?php 
					foreach ($comptabilite->getCaisseDunUserNotNull($_GET['iduser']) as $data)
					{?>
						<option value="<?php echo $data->ID_caisse."_".$data->montantCaisse."_".$data->devise.'_'.$data->lignecredit?>"><?php echo $data->nomCaisse . "_" . $data->devise?>
						</option>
					<?php
					}?>
				</select>
			</div>
		</div>
<?php
	}
?>