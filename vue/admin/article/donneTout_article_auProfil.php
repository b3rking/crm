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
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div id="reponse"></div>
  <a href="<?=WEBROOT?>article" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>

                <hr>
            <form class="form-horizontal" method="POST" >
                    <div class="row">
                         <div class="col-lg-3 col-md-3">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Nouveau profil</label>
                                            <div class="form-group col-sm-9">
                                                <select id="new_profil" class="form-control">
                                                     <option value=""></option>
                                                        <?php
                                                       // getProfilGlobaux
                                                        foreach ($article->getProfilGlobaux() as $value) 
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
                        <div class="col-lg-3 form-group">
                           
                             <select class="form-control" name="profil_id" id="profil_id">
                                    <option value="">selectionner le profil </option>
                                    <?php
                                    foreach ($article->profil_avec_article() as $value) 
                                    {
                                    ?>
                                        <option value="<?=$value->profil_id?>"><?=$value->profil_name?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                        </div>
                        
                        <div class="row">
                             <div class="col-lg-2 offset-5">
                              
                                        <button type="button" onclick="mettre_profil_global($('#new_profil').val(),$('#profil_id').val())" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 text-white"><i class="fa fa-check-circle"></i> Valider</button>
                                  
                            </div>
                            </form>
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
