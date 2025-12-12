<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false; 
if ($d = $user->verifierPermissionDunePage('utilisateur',$_SESSION['ID_user'])->fetch()) 
{
    if ($d['M'] == 1) 
    {
        $m = true;
    }
}
?>

<div class="row">
    <input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4>Affichage de profil</h4>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)"></a></li>
                                <li class="breadcrumb-item active">
                                    <a href="<?=WEBROOT?>utilisateur">Retour</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <hr> 
                <form class="form-horizontal" action="<?= WEBROOT?>setprofiluser" method="post" id="form-profil-user">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <input type="text" id="droit" value="<?=$m?>" hidden>
                            <select  onchange="getprofilPermission($(this).val())" id="profile_name"  class="form-control">
                                <option value="">-- Choisir un profil --</option>
                                <?php
                                foreach ($user->getAllProfilUser() as  $value)
                                {
                                ?>
                                    <option value="<?php echo $value->profil_id?>"><?php echo $value->profil_name?></option>
                                <?php   
                                } 
                                ?>
                            </select>

                        </div>
                        <div class="col-lg-6 form-group">
                            <a href="<?= WEBROOT;?>modification" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 font-light text-white"><i class="fa fa-eye"></i> Suppression et modification de profil</a>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Pages</th>
                                            <th>Lecture</th>
                                            <th>Creation</th>
                                            <th>Modification</th>
                                            <th>Suppression</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Pages</th>
                                            <th>Lecture</th>
                                            <th>Creation</th>
                                            <th>Modification</th>
                                            <th>Suppression</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="rs">
                                        <td>Aucune donneé</td>
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
