<?php
ob_start();
?>
<input type="text" id="userName" name="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4>Gestion de dashboard</h4>
    </div>
    <div class="col-md-7 align-self-center">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"></a></li>
                <li class="breadcrumb-item active">
                    
                    <!--button type="button" class="btn btn-primary"> <a href="<=WEBROOT?>utilisateur"><i class="fa fa-fast-backward"></a></i></button-->
                    <a href="<?=WEBROOT?>utilisateur" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>
                </li>
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-xl-6">
        <div class="card">
            <div class="card-header font-bold">
                Attribuer dashboard à un profil
            </div>
            <div class="card-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Profil*</label>
                                <div class="col-sm-9">
                                    <select class="form-control custom-select" id="profil_id">
                                        <option value=""></option>
                                        <?php
                                        foreach ($user->getProfilUserNotHaveDashboard() as $value) 
                                        {
                                        ?>
                                            <option value="<?=$value->profil_id?>"><?=$value->profil_name?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Dashboard*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="dashboarduser">
                                        <option value=""></option>
                                        <option value="adminDashboard">Dashboard admin</option>
                                        <option value="dashboardComptabilite">Dashboard comptabilité</option>
                                        <!--<option value="dashboardRecouvrement">Dashboard Recouvrement</option>-->
                                        <option value="dashboardDirectionCommercial">Dashboard Direction Commerciale</option>
                                        <option value="dashboardTechnique">Dashboard technique</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-16 col-lg-6"></div>
                    <div class="col-md-6 col-lg-6">
                        <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white" onclick="setDashboardToProfil($('#profil_id').val(),$('#dashboarduser').val())"><i class="fa fa-check-circle"></i> Valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-xl-6">
        <div class="card">
            <div class="card-header font-bold">
                Changer le dashboard d'un profil
            </div>
            <div class="card-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Profil*</label>
                                <div class="col-sm-9">
                                    <select class="form-control custom-select" id="profil_id_update">
                                        <option value=""></option>
                                        <?php
                                        foreach ($user->getProfilUserWithDashboard() as $value) 
                                        {
                                        ?>
                                            <option value="<?=$value->profil_id?>"><?=$value->profil_name.'/'.$value->page?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Dashboard*</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="dashboardUpdate">
                                        <option value=""></option>
                                        <option value="adminDashboard">Dashboard admin</option>
                                        <option value="dashboardComptabilite">Dashboard comptabilité</option>
                                        <!--<option value="dashboardRecouvrement">Dashboard Recouvrement</option>-->
                                        <option value="dashboardDirectionCommercial">Dashboard Direction Commerciale</option>
                                        <option value="dashboardTechnique">Dashboard technique</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-16 col-lg-6"></div>
                    <div class="col-md-6 col-lg-6">
                        <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white " onclick="updateDashboardToProfil($('#profil_id_update').val(),$('#dashboardUpdate').val())"><i class="fa fa-check-circle"></i> Valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>
