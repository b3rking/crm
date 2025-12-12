<?php
ob_start();
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
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                    if (isset($message)) 
                                    {?>
                                        <div class="alert alert-warning">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Proche" _mstaria-label="75621"> <span aria-hidden="true" _msthash="3927521" _msttexthash="19565">×</span> </button>
                                            <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i><font _mstmutation="1" _msthash="3395496" _msttexthash="237237"> Avertissement</font></h3><font _mstmutation="1" _msthash="3052088" _msttexthash="105342497"><?=$message?></font>
                                         </div>     
                              <?php
                                    }
                                ?>
                                <center class="m-t-30"> 
                                    <?php
                                    foreach ($user->image_user($_SESSION['ID_user']) as  $value) 
                                        {?>
                                        <img src="<?=WEBROOT?>image_profil/<?php echo $value->photo?>" class="img-circle" width="200" />
                                        <?php
                                    }
                                    ?>
                                    
                                    <h4 class="card-title m-t-10">Details</h4>
                                    <!--<h6 class="card-subtitle"><php echo $_SESSION['nom_user']?></h6>-->
                                   
                                    <div class="row text-center justify-content-md-center">
                                        

                                <button type="button" class="btn btn-primary d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="icon-picture"></i>Photo profil</button>
                                    <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lgs">
                                                <div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myLargeModalLabel">modifier photo</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal p-t-20" enctype="multipart/form-data" action="<?=WEBROOT?>photoprofil" method="POST">
                                                      
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="row">
                                                            <input type="text" class="form-control" id="idutilisateur" name="idutilisateur" value="<?php echo $_SESSION['ID_user']?>"hidden>
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Photo </label>
                                                            <div class="form-group col-sm-9">

                                                                <input type="file" class="form-control" id="photo" name="photo">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-success waves-effect text-left" type="submit" name="POST" id="POST"><i class="fa fa-check"></i>Enregistrer</button>
                                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
                <div><hr></div>
                <div class="card-body">
                    <!--<small class="text-muted">Text </small>
                    <h6>je suis </h6> <small class="text-muted p-t-30 db">txxx</small>
                    <h6>xxxx</h6> <small class="text-muted p-t-30 db">xxxxx</small>
                    <small class="text-muted">Email address </small>
                    <h6>hannagover@gmail.com</h6>
                    <small class="text-muted p-t-30 db">Phone</small>
                    <h6>+91 654 784 547</h6>
                    <small class="text-muted p-t-30 db">Address</small>
                    <h6>Slogan</h6>-->
                    <div class="map-box">
                            <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d470029.1604841957!2d72.29955005258641!3d23.019996818380896!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C+Gujarat!5e0!3m2!1sen!2sin!4v1493204785508" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>-->
                                </div> 
                                <small class="text-muted p-t-30 db">Social Profile</small>
                                <br/>
                                <button class="btn btn-circle btn-info"><i class="fa fa-facebook"></i></button>
                                <button class="btn btn-circle btn-info"><i class="fa fa-twitter"></i></button>
                                <button class="btn btn-circle btn-danger"><i class="fa fa-youtube"></i></button>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Profile</a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab">Mot de passe</a> </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                 
                                <div class="tab-pane active" id="profile" role="tabpanel">
                                    <div class="card-body">
                                        <div id="rep"></div>
                                         <form class="form-horizontal form-material">
                               <?php foreach ($user->afficheprofilUser($_SESSION['ID_user']) as $value) 
                                {
                                    ?>


                                    <div class="row">
                                    <div class="col-lg-6 form-group">
                                         Nom </div>
                                        <div class="col-lg-6 form-group">
                                            <input type="text" id ="identifiant" value="<?php echo $_SESSION['ID_user'];?>" hidden>
                                             <input type="text" id="nomuser" value="<?php echo $value->nom_user;?>" class="form-control form-control-line">
                                            
                                        </div>
                                    </div>
                                       <div class="row">
                                    <div class="col-lg-6 form-group">
                                         Prenom </div>
                                        <div class="col-lg-6 form-group">
                                            <input type="text" id="prenomuser" value="<?php echo $value->prenom;?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                       <div class="row">
                                    <div class="col-lg-6 form-group">
                                         Nom du profil </div>
                                        <div class="col-lg-6 form-group">
                                            <input type="text"  value="<?php echo $value->profil_name;?>" class="form-control form-control-line" disabled>
                                        </div>
                                    </div>
                                       <div class="row">
                                    <div class="col-lg-6 form-group">
                                         Mail </div>
                                        <div class="col-lg-6 form-group">
                                            <input type="email" id="adresmail" value="<?php echo $value->email;?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                       <div class="row">
                                    <div class="col-lg-6 form-group">
                                         Login </div>
                                        <div class="col-lg-6 form-group">
                                            <input type="text" id="loginuser" value="<?php echo $value->login;?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success" type="button" onclick="modif_detailprofil($('#identifiant').val(),$('#nomuser').val(),$('#prenomuser').val(),$('#adresmail').val(),$('#loginuser').val())">Modifier Profile</button>
                                                </div>
                                            </div>
                                <?php
                            }?>
                                </form>
                                        
                                    </div>
                                </div>
                                <div class="tab-pane" id="settings" role="tabpanel">
                                    <div class="card-body">
                                        <form class="form-horizontal form-material">
                                            <div class="form-group">
                                                 <input type="text" class="form-control custom-select" id="nomss" value="<?= $_SESSION['userName']?>" hidden>
                                                <label class="col-md-12">NOUVEAU MOT DE PASSE</label>
                                                <div class="col-md-12">
                                                  
                                                    <input type="password" id="nouveaupassword"  class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">CONFIRMER</label>
                                                <div class="col-md-12">
                                                    <input type="password"  class="form-control form-control-line" id="confirmer">
                                                </div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="button" class="btn btn-info" onclick="changempmot_de_passe($('#nomss').val(),$('#nouveaupassword').val(),$('#confirmer').val())">modifier mot de passe
                                                    </button>
                                                   
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>
