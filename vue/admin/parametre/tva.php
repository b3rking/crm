<?php
ob_start();
?>

<div class="row">
	<div class="col-lg-3"></div>
	<div class="col-lg-6">
		<div class="card">
            <div class="card-header">
                Enregistrement du TVA
            </div>
            <div class="card-body">
                <form class="form-horizontal p-t-0">
                    <div class="row">
                    	<div class="col-lg-12 col-md-12">
                    		<div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Entreez le tva :</label>
                                <div class="form-group col-sm-9">
                 					<input type="number" class="form-control" id="tva" name="tva" value="18">
                                </div>
                            </div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-lg-12 col-md-12">
                    		<div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Description :</label>
                                <div class="form-group col-sm-9">
                 					<input type="text" class="form-control" id="description" name="description">
                                </div>
                            </div>
                    	</div>
                    </div>
                       <div class="col-lg-6 col-md-6">
                            <div class="form-group row" hidden="">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Date creation</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                        <input type="date" class="form-control" value="<?php $d = new DateTime();echo $d->format('Y-m-d');?>" id="datetva">

                                <input type="text" id="nomtva" value="<?=$_SESSION['userName']?>" hidden>
                                    </div>
                                </div>
                            </div>
                        </div>
                	<span id="rep"></span>
                </form>
            </div>
            <div class="card-footer text-center text-muted">
                <button class="btn  waves-effect text-left text-white"style="background-color: #8b4513" onclick="cree_tva($('#tva').val(),$('#description').val(),$('#datetva').val(),$('#nomtva').val())"><i class="fa fa-check"></i>Enregistrer
				</button>
            </div>
        </div>
	</div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>