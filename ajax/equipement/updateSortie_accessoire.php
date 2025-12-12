<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
require_once("../../model/vehicule.class.php");
require_once("../../model/client.class.php");
 
	$equipement = new Equipement(); 
	$vehicule = new Vehicule();
	$client = new Client();
$i = $_GET['i'];
	

	if ($_GET['destination'] == 'client') 
	{
?>
    	<div class="row">
    		<div class="col-lg-12 col-md-12">
    			<label for="exampleInputuname3" class="control-label">Client*</label>
        		<div class="form-group">
                	<!--input type="text" id="idclient_attribu_accessoir<?=$i?>" name="idclient" class="form-control input-filter" autocomplete="off" onkeyup="getClientToAtrib_Accessoir(this.value)">
                    <div id="modalAtribu_accessoire"></div>
                    <input type="text" id="nom_client" hidden=""-->
                    <input id="seachCustomer<?=$i?>" class="form-control form-control-sm input-filter" onkeyup="filter('selectCustomer<?=$i?>',this.value)"><br>
                    <select id="selectCustomer<?=$i?>" name="idclient" class="form-control input-filter" size="3">
                        <?php
                            foreach ($client->getClientToCreateTicket() as $value) 
                            {
                        ?>
                                <option value="<?=$value->ID_client?>">
                                    <?=$value->Nom_client.' -- code: '.$value->billing_number?>
                                </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
        	</div>
    	</div><!-- END ROW-->
<?php
	}
	elseif ($_GET['destination'] == 'relais') 
	{
?>
		<div class="row">
    		<div class="col-lg-12 col-md-12">
    			<label for="exampleInputuname3" class="control-label">Relais*</label>
        		<div class="form-group">
                    <select class="form-control input-filter" id="relais<?=$i?>">
		                <?php
	                    foreach ($equipement->selection_Secteur() as $data)
	                    {?>
	                        <option value="<?=$data->ID_secteur?>"><?= $data->nom_secteur?></option>
	                    <?php
	                    }
	                    ?> 
		            </select>
                </div>
        	</div>
    	</div><!-- END ROW-->

<?php
	}
	elseif ($_GET['destination'] == 'base')
	{
?>
		<div class="row">
    		<div class="col-lg-12 col-md-12">
    			<label for="exampleInputuname3" class="control-label">Point d'acces*</label>
        		<div class="form-group">
                	<select class="form-control input-filter" id="point_acces<?=$i?>">
			            <option></option>
			            <?php
			            foreach ($equipement->recuperePointAccesNoDepasserClient() as $value) 
			            {
			            ?>
			                <option value="<?=$value->ID_point_acces?>"><?=$value->nom?></option>
			            <?php
			            }
			            ?>
			        </select>
                </div>
        	</div>
    	</div>
<?php
	}
	else
	{
?>
		<div class="row">
    		<div class="col-lg-12 col-md-12">
    			<label for="exampleInputuname3" class="control-label">Vehicule*</label>
        		<div class="form-group">
                	<select class="form-control input-filter" id="vehicule<?=$i?>">
			            <option></option>
			            <?php
			            foreach ($vehicule->afficheVehicule() as $value) 
			            {
			            ?>
			                <option value="<?=$value->immatriculation?>"><?=$value->modele."-".$value->marque."- plaque: ".$value->immatriculation?></option>
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