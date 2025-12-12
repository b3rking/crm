<?php
ob_start();

$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('ficheintervention',$_SESSION['ID_user'])->fetch()) 
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
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"><a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></h4>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" style="background-color: #7c4a2f" class="btn d-none d-lg-block m-l-15 font-light text-white " data-toggle="modal" data-target=".bs-example-modal-md"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Creer fiche
                            </button>

                        </div>
                    </div>
                </div>
            <form action="<?=WEBROOT?>genereOrdremission" method="post" class="form-horizontal p-t-20">
               <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <label for="exampleInputEmail3" class="col-sm-3 col-lg-6 control-label">Date de départ: </label>
                        <div class="col-sm-9 col-lg-6">
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="dateMission" id="dateMission" value="<?=date('Y-m-d')?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label for="exampleInputEmail3" class="col-sm-3 col-lg-6 control-label">Date de retour: </label>
                        <div class="col-sm-9 col-lg-6">
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="dateRetour" id="dateMission" value="<?=date('Y-m-d')?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>NOM</th>
                                <th>FONCTION</th>
                                <th>CHOIX</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>NOM</th>
                                <th>FONCTION</th>
                                <th>CHOIX</th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                                <?php 
                            $i =0;
                            foreach ($user->afficheUsers() as  $value)
                            {
                                $i++; 
                            ?>
                            <tr>
                                <td><?= $value->nom_user?></td>
                                <!--<td><php echo $value->email?></td>-->
                                <td><?= $value->profil_name?></td>         
                                <td>
                                    <input type="checkbox" name="technicien[<?=$i?>]" value="<?=$value->ID_user?>" id="technicienMission">
                                </td>
                            <?php 
                            }
                            ?>
                          <!-- END FOREACH-->
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-5 col-md-3 col-lg-3 col-xlg-3 offset-4">
                        <button  type="submit" style="background-color: #7c4a2f" class="btn  waves-effect waves-light font-light text-white" >Generer fiche de mission </button>
                    </div>
                </form>
               </div>
            </div>
        </div>
    </div>
</div>

<?php
    $home_admin_content = ob_get_clean();
    require_once('vue/admin/home.admin.php');
?>