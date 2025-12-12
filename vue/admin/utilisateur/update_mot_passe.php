<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('utilisateur',$_SESSION['ID_user'])->fetch()) 
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


<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div id="rep"></div>
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h6>Changer votre mot de passe</h6>
                    </div>
                    
                </div>
                <hr>
                <form class="form-horizontal" >
                    <div class="row">
                        <div class="col-lg-12">


                            <div class="table-responsive">
                                <table class="table">
                                    <tbody id="reponse">
                                          <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Changer le mot de passe</button>
   

                                            <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                             <div class="modal-dialog modal-lgs">
                                              <div class="modal-content">
            <div class="modal-header"><!--
                <h4 class="modal-title" id="myLargeModalLabel">Nouveau secteur</h4>-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                      <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                            <input type="text" class="form-control custom-select" id="nomss" value="<?= $_SESSION['userName']?>" hidden>

                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nouveau mot de passe</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-lock-open-outline"></i></span></div>
                                        <input type="text" class="form-control custom-select" id="nouveaupassword">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Confirmer</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-lock-outline" ></i></span></div>
                                        <input type="text" class="form-control custom-select" id="confirmer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" style="background-color: #8b4513" class="btn font-light text-white" onclick="changemp($('#nomss').val(),$('#nouveaupassword').val(),$('#confirmer').val())">modifier
                            </button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>  
                                    </tbody>
                                </table>
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
