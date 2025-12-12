<?php
	require_once("../../model/connection.php");
	require_once("../../model/client.class.php");

$client = new Client();

    if ($value = $client->afficherUnClentAvecContract($_GET['idclient'])->fetch()) 
    {
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h6 class="m-b-0 text-white">Detail client</h6>
            </div>
            <div class="card-body">
            	<div class="row">
            		<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            			<h5 class="card-title ">BILLING NUMBER</h5>
            		</div>
            		<div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            			<h5 class="card-title"><?= $value['billing_number']?></h5>
            		</div>
            	</div>
            	<hr>
            	<div class="row">
            		<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            			<h5 class="card-title ">NOM</h5>
            		</div>
            		<div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            			<h5 class="card-title"><?= $value['Nom_client']?></h5>
            		</div>
            	</div>
            	<hr>
            	<div class="row">
            		<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            			<h5 class="card-title ">TELEPHONE</h5>
            		</div>
            		<div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            			<h5 class="card-title"><?= $value['telephone']?></h5>
            		</div>
            	</div>
            	<hr>
            	<div class="row">
            		<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            			<h5 class="card-title ">EMAIL</h5>
            		</div>
            		<div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            			<h5 class="card-title"><?= $value['mail']?></h5>
            		</div>
            	</div>
                <hr>
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
                        <h5 class="card-title ">PERSONNE DE CONTACT</h5>
                    </div>
                    <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
                        <h5 class="card-title"><?= $value['personneDeContact']?></h5>
                    </div>
                </div>
            	<hr>
            	<div class="row">
            		<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            			<h5 class="card-title ">ADRESSE</h5>
            		</div>
            		<div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            			<h5 class="card-title"><?= $value['adresse']?></h5>
            		</div>
            	</div>
            	<hr>
            	<div class="row">
            		<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            			<h5 class="card-title ">TYPE</h5>
            		</div>
            		<div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            			<h5 class="card-title"><?= $value['type_client']?></h5>
            		</div>
            	</div>
            	<hr>
            	<div class="row">
            		<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            			<h5 class="card-title ">SERVICE/CONNEXION</h5>
            		</div>
            		<div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            			<h5 class="card-title"><?= $value['nomService']?></h5>
            		</div>
            	</div>
            	<hr>
            	<div class="row">
            		<div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
            			<h5 class="card-title ">STATUT</h5>
            		</div>
            		<div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
            			<h5 class="card-title"><?= $value['etat']?></h5>
            		</div>
            	</div>
            	<hr>
            </div>
        </div>
    </div>
</div>
<?php 
	}
	else
	{
	    if ($value = $client->afficherUnClentSansContract($_GET['idclient'])->fetch()) 
	    {
	    ?>
	        <div class="row">
	            <div class="col-lg-12">
	                <div class="card">
	                    <div class="card-header bg-warning">
	                        <h6 class="m-b-0 text-white">Detail client</h6>
	                    </div>
	                    <div class="card-body">
	                        <div class="row">
	                            <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
	                                <h5 class="card-title ">BILLING NUMBER</h5>
	                            </div>
	                            <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
	                                <h5 class="card-title"><?= $value['billing_number']?></h5>
	                            </div>
	                        </div>
	                        <hr>
	                        <div class="row">
	                            <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
	                                <h5 class="card-title ">NOM</h5>
	                            </div>
	                            <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
	                                <h5 class="card-title"><?= $value['Nom_client']?></h5>
	                            </div>
	                        </div>
	                        <hr>
	                        <div class="row">
	                            <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
	                                <h5 class="card-title ">TELEPHONE</h5>
	                            </div>
	                            <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
	                                <h5 class="card-title"><?= $value['telephone']?></h5>
	                            </div>
	                        </div>
	                        <hr>
	                        <div class="row">
	                            <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
	                                <h5 class="card-title ">EMAIL</h5>
	                            </div>
	                            <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
	                                <h5 class="card-title"><?= $value['mail']?></h5>
	                            </div>
	                        </div>
	                        <hr>
	                        <div class="row">
	                            <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
	                                <h5 class="card-title ">PERSONNE DE CONTACT</h5>
	                            </div>
	                            <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
	                                <h5 class="card-title"><?= $value['personneDeContact']?></h5>
	                            </div>
	                        </div>
	                        <hr>
	                        <div class="row">
	                            <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
	                                <h5 class="card-title ">ADRESSE</h5>
	                            </div>
	                            <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
	                                <h5 class="card-title"><?= $value['adresse']?></h5>
	                            </div>
	                        </div>
	                        <hr>
	                        <div class="row">
	                            <div class="col-sm-3 col-md-3 col-lg-3 col-xlg-3">
	                                <h5 class="card-title ">TYPE</h5>
	                            </div>
	                            <div class="col-sm-9 col-md-9 col-lg-9 col-xlg-9">
	                                <h5 class="card-title"><?= $value['type_client']?></h5>
	                            </div>
	                        </div>
	                        <hr>
	                    </div>
	                </div>
	            </div>
	        </div>
	    <?php
	    }
	}
?>