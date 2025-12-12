<?php
require_once("../../model/connection.php");
require_once("../../model/comptabilite.class.php");

 
	$comptabilite = new Comptabilite();
?>
<div class="row">
	<div class="col-sm-6 col-md-6 col-lg-3 col-xl-3">
		<label for="exampleInputuname3" class="control-label">Banque *</label>
		<div class="form-group">
			<select class="form-control form-control-sm" id="banque<?=$_GET['i']?>">
                <option value=""></option>
				<?php 
				foreach ($comptabilite->getBanqqueActive() as $data)
				{?>
					<option value="<?= $data->ID_banque.'-'.$data->monnaie?>"><?= $data->nom . "_" . $data->monnaie?>
					</option>
				<?php
				}?>
			</select>
		</div>
	</div>
</div>

	