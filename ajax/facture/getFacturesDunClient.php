<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");
require_once("../../model/comptabilite.class.php");  

$comptabilite = new Comptabilite();
$contract = new Contract();
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group row">
            <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Facture concerner* </label>
            <div class="col-sm-9">
                <div class="input-group">
                	<?php
                	if ($_GET['i'] > 0) 
                	{?>
                		<select class="form-control" id="facture_id<?=$_GET['i']?>">
                			<option value=""></option>
						<?php
						foreach ($contract->getFacturesDunClient($_GET['idclient']) as $value) 
						{
						?>
							<option value="<?=$value->facture_id?>"><?=$value->facture_id?></option>
						<?php
						}
						?>
						</select>
            		<?php
                	}
                	else
                	{?>
                		<select class="form-control" id="facture_id">
                			<option value=""></option>
						<?php
						foreach ($contract->getFacturesDunClient($_GET['idclient']) as $value) 
						{
						?>
							<option value="<?=$value->facture_id?>"><?=$value->facture_id?></option>
						<?php
						}
						?>
						</select>
					<?php
                	}
                	?>
                </div>
            </div>
        </div>
    </div>
</div>