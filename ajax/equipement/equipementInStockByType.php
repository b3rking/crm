<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");

 
	$equipement = new Equipement();
?>
	<label for="exampleInputuname3" class="control-label"><?=ucfirst($_GET['type'])?></label>
	<select id="equipement" class="form-control input-filter">
        <option value=""></option>
        <?php
        foreach ($equipement->getEquipementInStockByType($_GET['type']) as $value) 
        {
        ?>
            <option value="<?=$value->ID_equipement?>"><?=$value->model.' / '.$value->first_adress?></option>
        <?php
        }
        ?>
    </select>