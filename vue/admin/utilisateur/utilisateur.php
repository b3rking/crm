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
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<input type="text" id="iduser" value="<?=$_SESSION['ID_user']?>" hidden>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4>Gestion utilisateur</h4>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)"></a></li>
                            </ol>
                            <?php
                            if (isset($msg)) 
                            {?>
                                <div class="alert alert-success"  style="height: 40px;"> 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span>
                                    </button><?=$msg;?>
                                </div>
                            <?php
                            }
                            if ($c) 
                            {?>
                                <a href="<?= WEBROOT;?>dashboardgest" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white"><i class="fa fa-plus-circle"></i> Dashboard</a>
                                <button type="button" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i>Creer utilisateur</button>
                            <?php
                            }
                            ?>

                            <!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Creer utislisateur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom *</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nomuser" placeholder="nom complet">
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Login *</label>
                                <div class="col-sm-9">   
                                    <div class="form-group">
                                        <input type="text" id="login" class="form-control">   
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div><!-- End row-->
                     <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Prenom *</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="prenom" placeholder="Prenom">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Mot de passe *</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" placeholder="password">
                                </div>
                            </div>
                        </div>
                  
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Profil</label>
                                <div class="col-sm-9">   
                                    <div class="form-group">
                                    <select class="form-control custom-select" id="profil_id">
                                        <option value=""></option>
                                        <?php
                                        foreach ($user->getAllProfilUser() as $value) 
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
                           <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Confirmer *</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="conf_password" placeholder="Confirmer le mot de passe">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Mail *</label>
                                <div class="col-sm-9">
                                    <input type="mail" class="form-control" id="mail_user" placeholder="mail">
                                    <input type="text" class="form-control" id="etat" value="1" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span id="msg-add-user"></span>
                <button type="button" style="background-color: #8b4513" onclick="ajout_User($('#nomuser').val(),$('#login').val(),$('#prenom').val(),$('#password').val(),$('#profil_id').val(),$('#conf_password').val(),$('#mail_user').val(),$('#etat').val())" class="btn waves-effect text-left font-light text-white">Nouveau utilisateur
                            </button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- / .modal-->
<?php
if ($l) 
{?>
    <a href="<?= WEBROOT;?>voir_profil" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white"><i class="fa fa-eye"></i> Voir profil</a>

     <a href="<?= WEBROOT;?>voir_utilisateur" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white"><i class="fa fa-eye"></i> Voir utilisateur</a>
<?php
}
?>                      </div> 
                    </div>
                </div>
                <hr>
                <form class="form-horizontal" action="<?= WEBROOT?>setprofiluser" method="post" id="form-profil-user" onsubmit="setProfilUser()">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <input type="text" class="form-control" name="profile_name" id="profile_name" placeholder="Nom du nouveau profil">
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead style="background-color: #8b4513" class="text-white">
                                        <tr>
                                            <th>Pages</th>
                                            <th>L</th>
                                            <th>C</th>
                                            <th>M</th>
                                            <th>S</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot style="background-color: #8b4513" class="text-white">
                                        <tr>
                                            <th>Pages</th>
                                            <th>L</th>
                                            <th>C</th>
                                            <th>M</th>
                                            <th>S</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="reponse">
                                        <?php
                                        $page = ['client','typeclient','service','article','contrat','localisation','base','secteur','accessoire','antenne','routeur','switch','radio','carburant','ticket','vehicule','fichedepanne','ficheintervention','fichederecuperation','fichedemission','ficheinstallation','ficheBP','fichededemenagement','prospection','sponsor','stockmarketing','facture','raportFacture','balanceinitiale','suspenssion','coupure','factureproformat','paiement','banque','versementbanque','caisse','compte','depense','agenda','tauxdechange','tva','utilisateur','rapports','mon_profil','photos_deprofil','extra','categorieDepense','type_extrat','infoSociete','historique','monnaie','ficheDiminutionBP'];
                                        $_SESSION['page'] = $page;
                                        for ($i=0; $i < count($page); $i++) 
                                        { 
                                        ?>
                                            <tr>
                                                <td class="font-bold"><?= $page[$i]?></td>
                                                <td><input type="checkbox" name="l<?=$i?>" id="l<?=$i?>"></td>
                                                <td><input type="checkbox" name="c<?=$i?>" id="c<?=$i?>"></td>
                                                <td><input type="checkbox" name="m<?=$i?>" id="m<?=$i?>"></td>
                                                <td><input type="checkbox" name="s<?=$i?>" id="s<?=$i?>"></td>
                                                <td><label class="btn">
                                                    <input type="checkbox" id="<?=$i?>" onclick="cocherUneLigneOnCreerProfilUser(this.id)"> Cocher cette ligne
                                                </label></td>
                                            </tr>
                                        <?php
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 offset-5">
                            <?php
                            if ($c) 
                            {?>
                                <button type="submit" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white"><i class="fa fa-check-circle"></i> Valider</button>
                            <?php
                            }
                            ?>
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
