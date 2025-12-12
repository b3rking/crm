<?php
ob_start();
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div class="row">
		    		<div class="col-sm-6 col-md-6 col-lg-6"></div>
		    		<div class="col-lg-6 col-md-6 align-self-center">
		    			<h4 class="text-themecolor">Fiche d'installation</h4>
		    		</div> 
			    </div>

			    <form class="form-horizontal p-t-20" action="<?=WEBROOT?>genficheinstallation" method="POST">
			                                 <!-- Debut premiere ligne-->
			   <div class="row">
			   		<div class="col-sm-3 col-md-3 col-lg-3"></div>
			        <div class="col-lg-6 col-md-6">
			            <div class="row">
			                <label for="exampleInputEmail3" class="col-sm-3 control-label">Client</label>
			                <div class="form-group col-sm-9">
			                    <input type="text" id="idclient" class="form-control" autocomplete="off" name="idclient">
			                        <div id="modal"></div>
			                </div>
			            </div>
			        	<div class="row">
			                <label for="exampleInputEmail3" class="col-sm-3 control-label">Date d'installation</label>
			                <div class="col-sm-9">
			                    <div class="form-group">
			                        <input type="date" class="form-control" id="dateInstallation" name="dateInstallation">
			                    </div>
			                </div>
			            </div>
		            </div>
			    </div>
			    <hr>
			    <div class="row">
			    	<div class="col-sm-6 col-md-6 col-lg-6">
			    		<?php
			    			if (isset($msg)) 
			    			{
			    				echo $msg;
			    			}
			    		?>
			    	</div>
			    	<div class="col-sm-3 col-md-3 col-lg-3">
			    		
			    		<button class="btn btn-success waves-effect text-left" type="submit" name="POST" id="POST"><i class="fa fa-check"></i>Fiche D'installation
                            </button>

			    	</div>
			    </div>
			    </form>
		    </div>
		</div>
	</div>
</div>
<?php
	/*if ($_SESSION['role'] == 'commercial') 
    {
        $home_commercial_content = ob_get_clean();
        require_once('vue/admin/home.commercial.php');
    }
    elseif ($_SESSION['role'] == 'admin') 
    {
        $home_admin_content = ob_get_clean();
        require_once('vue/admin/home.admin.php');
    }*/
    $home_admin_content = ob_get_clean();
        require_once('vue/admin/home.admin.php');
?>