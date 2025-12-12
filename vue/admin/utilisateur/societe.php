<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
/*if ($d = $user->verifierPermissionDunePage('tauxdechange',$_SESSION['ID_user'])->fetch()) 
{
    if ($d['L'] == 1) 
    {
        $l = true;
    }
    if ($d['C'] == 1) 
    {
        $c = true;
    }
    if ($d['M'] == 1) 
    {
        $m = true;
    }
    if ($d['S'] == 1) 
    {
        $s = true;
    }
}*/
?>

<div class="row">
	<div class="col-lg-3"></div>
	<div class="col-lg-6">
		<div class="card">
            <div class="card-header">
                Information de l'entreprise
            </div>
            <div class="card-body">
                <form class="form-horizontal p-t-0">
                    <div class="row">
                    	<div class="col-lg-12 col-md-12">
                    		<div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Entreez le nom :</label>
                                <div class="form-group col-sm-9">
                 					<input type="text" class="form-control" id="nom" name="nom" >
                                </div>
                            </div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-lg-12 col-md-12"> 
                    		<div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Localisation :</label>
                                <div class="form-group col-sm-9">
                 					<input type="text" class="form-control" id="localisation" name="localisation">
                                </div>
                            </div>
                    	</div>
                    </div>
                	<span id="rep"></span>
                </form>
            </div>
            <div class="card-footer text-center text-muted">
               
                    <button style="background-color: #8b4513" class="btn waves-effect text-left font-light text-white" onclick="changernom($('#nom').val(),$('#localisation').val())"><i class="fa fa-check"></i>Enregistrer
                    </button>
                
            </div>
        </div>
	</div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>