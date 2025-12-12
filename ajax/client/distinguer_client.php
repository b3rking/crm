<?php
require_once("../../model/connection.php");
require_once("../../model/client.class.php");

 
	$client = new Client();

	if ($_GET['genre'] == 'personnel') 
	{
?>
		
								<div class="row">
                            		<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Nom complet*</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" maxlength="100" class="form-control" id="nom" placeholder="Nom complet">
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                                <div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Personne de contact</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" class="form-control" id="pers_cont" placeholder="Personne de contact">
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
                            	</div><!-- END ROW-->
<?php
	}
	elseif ($_GET['genre'] == 'societe') 
	{
?>
							<div class="row">
                            		<div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Societé*</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" maxlength="100" class="form-control" id="societe" placeholder="Nom complet">
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
	                                <div class="col-lg-6 col-md-6">
	                            		<div class="form-group row">
		                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Responsable de la societé</label>
		                                    <div class="col-sm-9">
		                                        <div class="input-group">
		                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
		                                            <input type="text" class="form-control" id="responsable" placeholder="Personne de contact">
		                                        </div>
		                                    </div>
		                                </div>
	                            	</div>
                            	</div><!-- END ROW-->
<?php
	}
?>