<?php
ob_start();
?>

<section id="wrapper">
    <div class="login-register" style="background-image:url(assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body"> 
                <form class="form-horizontal form-material" id="loginform">
                    <h3 class="box-title m-b-20">Nouveau mot de passe</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" name="password" id="password" placeholder="Mot de passe" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" name="repassword" id="repassword" placeholder="Confirmer" value="">
                            <input type="text" name="token" id="token" value="<?=$token?>" hidden="">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12 p-b-20">
                            <button class="btn btn-block btn-lg text-white btn-rounded text-uppercase" style="background-color: #7c4a2f" type="button" onclick="recoverPassword($('#password').val(),$('#repassword').val(),$('#token').val())">valider</button>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal form-material" id="recoverform" action="<?= WEBROOT?>login" method="post">
                    <h3 class="box-title m-b-20">Connexion</h3>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" name="login" placeholder="Login" value="<?php if(isset($_COOKIE['remember_login'])){echo $_COOKIE['remember_login'];}?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" name="password" placeholder="Mot de passe" value="<?php if(isset($_COOKIE['remember_password'])){echo $_COOKIE['remember_password'];}?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <?php if(isset($_COOKIE['remember_login']))
                                {?> <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember_me" checked="" />
                                <?php
                                }
                                else
                                {
                                ?>
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember_me"/>
                                <?php
                                }
                                ?>
                                <label class="custom-control-label" for="customCheck1">Remember me</label>
                                <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right" ><i class="fa fa-lock m-r-5"></i> Mot de passe oublier?</a>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12 p-b-20">
                            <button class="btn btn-block btn-lg text-white btn-rounded" style="background-color: #7c4a2f" type="submit">Se connecter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
    $vue_home_content = ob_get_clean();
    require_once('vue/index.php');
?>

