<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");

 
	$equipement = new Equipement();

	if ($_GET['type'] == 'antenne') 
	{
?>
		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Antenne</label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"></span>
					</div>
					<select id="antenne" class="form-control">
                        <option></option>
                        <?php
                        foreach ($equipement->recupererAntennes() as $value) 
                        {
                        ?>
                            <option value="<?=$value->ID_equipement?>"><?=$value->model.' / '.$value->first_adress?></option>
                        <?php
                        }
                        ?>
                    </select>
				</div>
			</div>
		</div>
<?php
	}
	elseif ($_GET['type'] == 'routeur') 
	{
?>
		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Routeur</label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"></span>
					</div>
					<select class="form-control" id="routeur">
                        <option value=""></option>
                        <?php
                        foreach ($equipement->recupererRouteur() as $value) 
                        {
                        ?>
                            <option value="<?=$value->ID_equipement?>"><?=$value->model.' / '.$value->first_adress?></option>
                        <?php
                        }
                        ?>
                    </select>
				</div>
			</div>
		</div>
<?php
	}
	elseif ($_GET['type'] == 'switch') 
	{?>

		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Switch</label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"></span>
					</div>
					<select class="form-control" id="switch">
                        <option></option>
                        <?php
                        foreach ($equipement->recupererSwitch() as $value) 
                        {
                        ?>
                            <option value="<?=$value->ID_equipement?>"><?=$value->model.' / '.$value->first_adress?></option>
                        <?php
                        }
                        ?>
                    </select>
				</div>
			</div>
		</div>
<?php
	}
?>