<?php
ob_start();
?>

<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">parametre</h4>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ti-settings"></i>
                            </button>
                            <div class="dropdown-menu animated flipInX flipInY">
                                <input type="text" id="idUser" value="<?=$_SESSION['ID_user']?>" hidden>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="includeTypeClient($('#idUser').val())">Type client</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="includeService($('#idUser').val())">Service</a>
                                <!--<a class="dropdown-item" href="javascript:void(0)" onclick="includeContract($('#idUser').val())">Contract</a>-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="includeVehicule()">VEHICULE</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="includeArticle()">ARTICLE</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="includeUtilisateur()">UTILISATEUR</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                        </div>
                    </div>
                </div>
		    </div>
		</div>

        <div id="body-parametre">
            
        </div>
	</div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>