<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('article',$_SESSION['ID_user'])->fetch()) 
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
                <div id="profil"></div>
                <a href="<?=WEBROOT?>article" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>

                <hr>
                <div class="row page-titles">
                    <div class="col-md-3 align-self-center">
                        <div class="row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Liste des pofils</label>
                            <div class="form-group col-sm-9">
                                <select class="form-control" id="profil_list" onchange="showArtcleByProfil($(this).val())">
                                    <option value=""></option>
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
                    </div>
                    <div class="col-md-8 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <?php
                            if ($c) 
                            {?>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)"></a></li>
                                <!--li class="breadcrumb-item active">Article</li-->
                            </ol>
                           <button type="button" style="background-color: #8b4513" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> Nouveau Article</button>
           <!-- sample modal content -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau article</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                                <div class="row">
                                    <div class="col-lg-8 col-md-6">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Langue</label>
                                            <div class="form-group col-sm-9">
                                                <select id="langue" class="form-control">
                                                   
                                                    <option value="francais">francais</option>
                                                    <option value="anglais">anglais</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- END ROW-->
                             
                                <div class="row">
                                   <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                                            <textarea class="form-control" placeholder="le corp de l'article" id="corp_article"></textarea>
                                    <input type="text" value="<?php echo date('Y-m-d H:i:s');?>"hidden>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #8b4513" class="btn text-white waves-effect text-left" onclick="ajouterArticle($('#langue').val(),$('#corp_article').val())" data-dismiss="modal"><i class="fa fa-check"></i>Creer article
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            

            <button type="button"style="background-color: #8b4513" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-md"><i class="fa fa-plus-circle"></i> Nouveau profil</button>
            <?php
            }
            ?>

            <div class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nauveau profil</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                <div class="modal-body">
                    <form class="form-horizontal p-t-20">
                        <div class="row">
                           
                            <div class="col-lg-12 col-md-12"> 
                                <div class="form-group row">
                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom profil* </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                            <input type="text" class="form-control" id="profil_name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                                   <div class="col-lg-12 col-md-12"> 
                                <div class="form-group row">
                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Nom profil* </label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </form>
                </div>
                <div class="modal-footer">
                    <span id="rep"></span>
                    <button type="button" onclick="mettre_profil_global($('#profil_name').val(),$('#profil_id').val())" style="background-color: #8b4513" class="btn d-none d-lg-block m-l-15 text-white"><i class="fa fa-check-circle"></i> Valider</button>
                    <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
            <!-- End modal-->
             <?php
                            if ($c) 
                            {?>
             <a href="<?= WEBROOT;?>attibuer_article" style="background-color: #8b4513" class="btn text-white d-none d-lg-block m-l-15"><i class="fa fa-check"></i>Attribuer article</a>
             <?php
          }
          
                            if ($c) 
                            {?>
            
              <a href="<?= WEBROOT;?>modifierSuprime_profil" style="background-color: #8b4513" class="btn text-white d-none d-lg-block m-l-15"><i class="fa fa-check"></i>modifier / supprimer profil</a>
              <?php
          }
          ?>

            
             
            </div>
        </div>
      </div>

                <!--<h4 class="card-title">Data Export</h4>
                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>-->
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <!--th>Type article</th-->
                                <th>Corps</th>
                                <th>Langue</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                          <tfoot>
                                <tr>
                                    <!--th>Type article</th-->
                                    <th>Corps</th>
                                    <th>Langue</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody id="reponse" class="font-bold">
                        <?php 
            $i = 0;
            foreach($article->afficheArticle() as $value)
            {
                 $i++;
            ?>
            <tr>
                    
                   
                    <!--td><php echo $value->type_article?></td-->
                    <td><?php echo iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value->corp);?></td>
                    <td><?php echo $value->langue?></td>
                    <td>
                        <?php 
                        

                       if ($m) 
                                    {?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm-<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <?php
                                    }
                                    ?>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-sm-<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">modifier article</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                                
                                <div class="row">
                                       <input type="text" id="numero<?=$i?>" value="<?php echo $value->id?>"hidden>
                                      <div class="col-lg-7 col-md-5">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Langue</label>
                                            <div class="form-group col-sm-9">

                                                <select id="langue<?=$i?>" value="<?php echo $value->langue?>" class="form-control">
                                                    <option value="francais">francais</option>
                                                    <option value="anglais">anglais</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div></div>
                          
                                <div class="row">
                                   <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                                                <textarea type="text" rows="5" cols="2" class="form-control" id="corp_article<?=$i?>">
                                                    <?php echo iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value->corp)?> 
                                                </textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #8b4513"class="btn text-white waves-effect text-left" onclick="updateArticle($('#numero<?=$i?>').val(),$('#langue<?=$i?>').val(),$('#corp_article<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-pencil"></i>modifier article
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
            <!-- /.modal -->

            <?php
            if ($s) 
            {?>
                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="supprimer"> <i class="fa fa-trash text-inverse m-r-10"></i></a>
            <?php
            }
            ?>
            
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer cet article</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="numero<?=$i?>" value="<?php echo $value->corp?>" hidden>
                            Voulez-vous supprimer cet article?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteArticle($('#numero<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
        </td>
                </tr>
            <?php } ?>
         
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>
