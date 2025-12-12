<?php
ob_start();

require_once('model/User.class.php');
require_once("model/client.class.php");
require_once("model/localisation.class.php"); 
require_once("model/comptabilite.class.php");
require_once 'vue/reportGraphData.php';

$user = new User();
$client = new Client();
$localisation = new Localisation();
$comptabilite = new Comptabilite();
$data = $client->totalClientParType();

$tbMonnaie = ['USD','BIF'];
$tbMonnaie = json_encode($tbMonnaie);
$data_local = array();
$query_local = $localisation->nombreClientParLocalisation();
foreach ($query_local as $value) 
{
    $data_local[] = array('label'  => $value->nom_localisation,'value'  => $value->nb);
}
$data_local = json_encode($data_local);
?>

<section id="wrapper">
    <div class="login-register" style="background: linear-gradient(135deg, #7c4a2f 0%, #4a2c1d 100%);">
        <div class="login-box card shadow-lg">
            <div class="card-body">
                <!-- Logo et en-tête -->
                <div class="text-center mb-4">
                    <img src="printing/fiches/logoSpdernet.png" alt="Spdernet Logo" class="logo mb-3" style="max-height: 80px;">
                    <h3 class="box-title m-b-20 text-primary">Connexion à votre compte</h3>
                </div>
                
                <!-- Formulaire de connexion -->
                <form class="form-horizontal form-material" id="loginform" action="<?= WEBROOT?>login" method="post">
                    <div class="form-group mb-4">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                </div>
                                <input class="form-control border-start-0 ps-2" type="text" required="" name="login" placeholder="Nom d'utilisateur" value="<?php if(isset($_COOKIE['remember_login'])){echo $_COOKIE['remember_login'];}?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                </div>
                                <input class="form-control border-start-0 ps-2" type="password" required="" name="password" placeholder="Mot de passe" value="<?php if(isset($_COOKIE['remember_password'])){echo $_COOKIE['remember_password'];}?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <?php if(isset($_COOKIE['remember_login']))
                                {?> <input type="checkbox" class="form-check-input" id="customCheck1" name="remember_me" checked="" />
                                <?php
                                }
                                else
                                {
                                ?>
                                    <input type="checkbox" class="form-check-input" id="customCheck1" name="remember_me"/>
                                <?php
                                }
                                ?>
                                <label class="form-check-label" for="customCheck1">Se souvenir de moi</label>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-primary" style="font-size: 0.9rem;">
                                <i class="fas fa-key m-r-5"></i> Mot de passe oublié?
                            </a>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-xs-12 p-b-20">
                            <button class="btn btn-block btn-lg text-white btn-rounded shadow-sm" style="background: linear-gradient(to right, #7c4a2f, #a56a46); border: none;" type="submit">
                                <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Formulaire de récupération de mot de passe -->
                <form class="form-horizontal" id="recoverform" action="<?=WEBROOT?>resetpwd" method="post" style="display: none;">
                    <div class="text-center mb-4">
                        <img src="logoSpdernet.png" alt="Spdernet Logo" class="logo mb-3" style="max-height: 60px;">
                    </div>
                    <div class="form-group mb-3">
                        <div class="col-xs-12">
                            <h4 class="text-center text-primary">Récupération du mot de passe</h4>
                            <p class="text-muted text-center">Entrez votre email et les instructions vous seront envoyées!</p>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                </div>
                                <input class="form-control border-start-0 ps-2" type="email" required="" placeholder="Adresse email" id="emailrecover" name="emailrecover">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20 mb-3">
                        <div class="col-xs-12">
                            <button style="background: linear-gradient(to right, #7c4a2f, #a56a46); border: none;" class="btn text-white btn-lg btn-block text-uppercase waves-effect waves-light shadow-sm" type="button" id="validateRecoverForm">
                                <i class="fas fa-paper-plane me-2"></i>Réinitialiser
                            </button>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <a href="javascript:void(0)" id="to-login" class="text-primary">
                            <i class="fas fa-arrow-left me-1"></i>Retour à la connexion
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    .login-register {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .login-box {
        border-radius: 15px;
        border: none;
        overflow: hidden;
        max-width: 400px;
        width: 100%;
    }
    
    .logo {
        transition: transform 0.3s ease;
    }
    
    .logo:hover {
        transform: scale(1.05);
    }
    
    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(124, 74, 47, 0.25);
        border-color: #7c4a2f;
    }
    
    .btn {
        border-radius: 8px;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .input-group-text {
        border-radius: 8px 0 0 8px;
    }
    
    .card {
        border-radius: 15px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation pour basculer entre les formulaires
        document.getElementById('to-recover').addEventListener('click', function() {
            document.getElementById('loginform').style.display = 'none';
            document.getElementById('recoverform').style.display = 'block';
        });
        
        document.getElementById('to-login').addEventListener('click', function() {
            document.getElementById('recoverform').style.display = 'none';
            document.getElementById('loginform').style.display = 'block';
        });
        
        // Validation du formulaire de récupération
        document.getElementById('validateRecoverForm').addEventListener('click', function() {
            const email = document.getElementById('emailrecover').value;
            if(email && email.includes('@')) {
                document.getElementById('recoverform').submit();
            } else {
                alert('Veuillez entrer une adresse email valide');
            }
        });
    });
</script>

<?php
    $vue_home_content = ob_get_clean();
    require_once('vue/index.php');
?>