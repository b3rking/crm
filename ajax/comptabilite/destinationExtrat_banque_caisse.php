<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");
$comptabilite = new Comptabilite();

	if ($_GET['type'] == 'banque') 
	{
?>
		<div class="col-lg-12 col-md-12">
            <div class="form-group row">
              <label for="exampleInputuname3" class="col-sm-3 control-label">Banque</label>
              <div class="col-sm-9">
                <select class="form-control" id="banque" name="banque">
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
		<div class="col-lg-12 col-md-12">
            <div class="form-group row">
                <label for="exampleInputuname3" class="col-sm-3 control-label">Caisse</label>
	            <div class="col-sm-9">
	                <select class="form-control" id="caisse" name="caisse">
							<?php 
							foreach ($comptabilite->getGrandeCaisses() as $data)
							{?>
								<option value="<?php echo $data->ID_caisse."_".$data->montantCaisse."_".$data->devise.'_'.$data->lignecredit?>"><?php echo $data->nomCaisse . "_" . $data->devise?>
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