<?php
ob_start();
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div class="row">
		    		<div class="col-sm-6 col-md-3 col-lg-3"></div>
		    		<div class="col-lg-6 col-md-6 align-self-center">
		    			<h4 class="text-themecolor">Fiche de diminution de bande passante</h4>
		    		</div>
			    </div>

			    <form class="form-horizontal p-t-20" id="fiche_diminuerbp" action="<?=WEBROOT?>genficheDiminutionBP" method="post">
                    <div class="row">
                        <div class="col-lg-12 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-2 control-label">Client</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" id="idclient_diminuBP" class="form-control" autocomplete="off" name="idclient">
                                    <div id="modal_diminuer_bp"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 col-lg-4 col-md-3 col-lg-3 control-label">Bande passante</label>
                                <div class="col-sm-6 col-md-7 col-lg-8">
                                    <div class="input-group">
                                       <input type="number" class=" form-control" id="bandepassante" name="bandepassante" value="1" min="1">
                                       <div class="input-group-prepend"><span class="input-group-text">Mbps</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Diminuer à partir du</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="date" class="bootstrapMaterialDatePicker form-control" id="datedebut" name="datedebut" value="<?=date('Y-m-d')?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Au</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="date" class="bootstrapMaterialDatePicker form-control" id="datefin" name="datefin" value="<?=date('Y-m-d')?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
		    </div>
		</div>
	</div>
</div>
<?php
	
     	$home_admin_content = ob_get_clean();
        require_once('vue/admin/home.admin.php');
?>