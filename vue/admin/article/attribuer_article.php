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
                <a href="<?=WEBROOT?>article" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a>
                <hr>
                <form class="form-horizontal" action="<?= WEBROOT?>octroi_article" method="POST" id="form-profil-article">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Langue</label>
                                <div class="form-group col-sm-9">
                                    <select id="langue" class="form-control">
                                        <option >Trier selon la langue</option>
                                        <option value="francais">francais</option>
                                        <option value="anglais">anglais</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 form-group">
                            <select class="form-control" name="profil_id" id="profil_id" onchange="showArtcle($(this).val(),$('#langue').val())">
                                <option value="">selectionner le profil </option>
                                <?php
                                foreach ($article->getProfils() as $value) 
                                {
                                ?>
                                    <option value="<?=$value->profil_id?>"><?=$value->profil_name?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead style="background-color: #8b4513" class="text-white">
                                    <tr>
                                        <th>CORP ARTICLE</th>
                                        <th>AFFICHE</th>
                                        <th>ordre</th>
                                    </tr>
                                </thead>
                                <tfoot style="background-color: #8b4513" class="text-white">
                                    <tr>
                                        <th>CORP ARTICLE</th>
                                        <th>AFFICHE</th>
                                        <th>ordre</th> 
                                    </tr>
                                </tfoot>
                                <tbody id="reponse"> 
                                <?php
                                    $i =0;
                                    $value =array();
                                foreach ($article->getAll_corpDarticle() AS $value) 
                                {
                                 $i++;
                                   ?>
                                    <tr>
                                    <td class=""><?php echo $value->id.' - '.$value->corp;?></td>
                                    <td>
                                      <input type="checkbox" id="titre<?=$i?>" value="<?=$value->id?>" name="affiche[<?=$i?>]" onclick="showHideInput_titre(this,'<?=$i?>')"/><br />
                                    </td>
                                    <td>
                                        <div id="contena_titre<?=$i?>" style="display: none;">
                                            <input type="number" id="ordre<?=$i?>" name="ordre<?=$i?>"> 
                                        </div>
                                    </td> 
                                </tr>
                                <?php          
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-2 offset-5">
                    <button type="submit" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 text-white"><i class="fa fa-check-circle"></i> Valider</button>
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
