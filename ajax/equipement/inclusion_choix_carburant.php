<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once('../../model/User.class.php');
require_once("../../model/vehicule.class.php");
 
	$equipement = new Equipement();
	$vehicule = new Vehicule();
	$user = new User();

	if ($_GET['choix'] == 'vehicule_essence') 
	{
?>
		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Nature Essence</label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"></span>
					</div>
					<select class="form-control" id="vehicule_essence">
						<?php 
						foreach ($vehicule->getVehiculeParCarburant('essence') as $value)
						{?>
							<option value="<?php echo $value->immatriculation?>"><?php echo $value->immatriculation . "/" . $value->modele. "/" . $value->nature?>
							</option>
						<?php
						}?>
					</select>
				</div>
			</div>
		</div>
<?php
	}
	elseif ($_GET['choix'] == 'vehicule_mazout') 
	{
?>
		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Nature Mazout</label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"></span>
					</div>
					<select class="form-control" id="vehicule_mazout">
						<?php 
						foreach ($vehicule->getVehiculeParCarburant('mazout') as $value)
						{?>
							<option value="<?php echo $value->immatriculation?>"><?php echo $value->immatriculation . "/" . $value->modele. "/" . $value->nature?>
							</option>
						<?php
						}?>
					</select>
				</div>
			</div>
		</div>
<?php
	}
	else if ($_GET['choix'] == 'autre') 
		{?>
		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Personel</label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"></span>
					</div>
					<select class="form-control" id="personel">
						<?php 
						foreach ($user->afficheUsers() as $value)
						{?>
							<option value="<?php echo $value->nom_user?>"><?php echo $value->nom_user?>
							</option>
						<?php
						}?>
					</select>
				</div>
			</div>
		</div>
<?php
	}
	elseif ($_GET['choix'] == 'backup') 
	{?>

		<div class="form-group row">
			<label for="exampleInputuname3" class="col-sm-3 control-label">Backup</label>
			<div class="col-sm-9">
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"></span>
					</div>
					<select class="form-control custom-select" id="secteur">
                        <?php
                        foreach ($equipement->selection_Secteur() as $data)
                        {?>
                            <option value="<?php echo $data->nom_secteur?>"><?php echo $data->nom_secteur?></option>
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
