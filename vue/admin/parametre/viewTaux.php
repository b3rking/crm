<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('tauxdechange',$_SESSION['ID_user'])->fetch()) 
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
}
?>

<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row">
	<div class="col-lg-3"></div>
	<div class="col-lg-6">
		<div class="card">
            <div class="card-header">
                Enregistrement de taux
            </div>
            <div class="card-body">
                <form class="form-horizontal p-t-0">
                    <div class="row">
                    	<div class="col-lg-12 col-md-12">
                    		<div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Entreez le taux :</label>
                                <div class="form-group col-sm-9">
                 					<input type="number" class="form-control" id="taux" name="taux" value="0">
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
                	<span id="rep"></span>
                </form>
            </div>
            <div class="card-footer text-center text-muted">
                <?php
                if ($c) 
                {?>
                    <button style="background-color: #8b4513" class="btn  waves-effect text-left font-light text-white" onclick="creerTaux($('#taux').val(),$('#description').val())"><i class="fa fa-check"></i>Enregistrer
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
	</div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>