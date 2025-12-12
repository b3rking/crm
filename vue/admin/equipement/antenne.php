<?php
ob_start();
$l = false;
$c = false;
$m = false; 
$s = false;
if ($d = $user->verifierPermissionDunePage('antenne',$_SESSION['ID_user'])->fetch()) 
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
$month_etiquete = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
?>
<input type="text" id="userName" value="<?=$_SESSION['userName']?>" hidden>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                  <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                      <h4 class="text-themecolor"><a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button></h4>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <div class="d-flex justify-content-end align-items-center">
                            <?php
                            if ($c) 
                            {?>
                                <!--<ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Technique</a></li>
                                    <li class="breadcrumb-item active">Antenne</li>
                                </ol>-->
                                <button type="button" class="btn text-white btn-chocolate d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>nouvelle antenne</button>
                            <?php
                            }
                            ?>
                            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Nouvelle antenne</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body"> 
                                            <form class="form-horizontal p-t-0">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Model*</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" id="type_equipement" value="antenne" hidden="hidden">
                                                                <select class="form-control" id="model">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    foreach ($models as $value) 
                                                                    {?>
                                                                        <option value="<?=$value->id?>"><?=$value->name?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                           </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group row">
                                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Mac adresse*</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" placeholder="example : 10:2C:AD:AF:EB:06" id="mac">
                                                                <input type="text" id="user" value="<?=$_SESSION['ID_user']?>" hidden>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END ROW-->
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group row">
                                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Date ajout*</label>
                                                            <div class="col-sm-9">
                                                                <input type="date" class="form-control" id="date_ajout" value="<?=date('Y-d-m')?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END ROW-->
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group row">
                                                            <label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
                                                            <div class="col-sm-9">
                                                                <textarea class="form-control" id="description"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END ROW-->
                                            </form>
                                        </div>
                                        <div class="modal-footer"> 
                                            <span id="msg"></span>
                                        	<button type="button" class="btn text-white btn-chocolate" onclick="ajouterStock($('#model').val(),$('#type_equipement').val(),$('#mac').val(),$('#user').val(),$('#date_ajout').val(),$('#description').val())"> <i class="fa fa-check"></i> Ajouter antenne</button>
                                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!--/.modal-dialog -->
                            </div>
                            <!--/. model -->

                            <button type="button" class="btn btn-chocolate d-lg-block m-l-15 font-light text-white" data-toggle="modal" data-target=".bs-example-modal-lgs"><i class="fa fa-file"></i> Générer pdf</button>

                            <div class="modal fade bs-example-modal-lgs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-lgs">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Generer rapport d'antenne</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <form class="form-horizontal p-t-0" method="get" action="<?=WEBROOT?>rapport_antenne">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Marque </label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" id="marque" name="marque">
                                                                    <option value=""></option>
                                                                    <option value="NANO STATION M5">NANO STATION M5</option>
                                                                    <option value="GIGABEAM">GIGABEAM</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date </label>
                                                            <div class="col-sm-9">
                                                                <input type="date" class="form-control" name="date1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Date</label>
                                                            <div class="col-sm-9">
                                                                <input type="date" class="form-control" name="date2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Mois</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" name="mois">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    foreach ($month_etiquete as $key => $value) 
                                                                    {
                                                                    ?>
                                                                        <option value="<?=$key?>"><?= $value?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="form-group row">
                                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Annee </label>
                                                            <div class="col-sm-9">
                                                                <input type="number" class="form-control" name="annee" value="<?=date('Y')?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-chocolate waves-effect text-left font-light text-white">Envoyer
                                                </button>
                                                <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!--./modal-->

                        </div>
                    </div>
                </div>
              
                <div class="table-responsive m-t-0">
                    <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>DATE AJOUT</th>
                                <th>FABRIQUANT</th>
                                <th>MODEL</th>
                                <th>ADRESSE MAC</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>DATE AJOUT</th>
                                <th>FABRIQUANT</th>
                                <th>MODEL</th>
                                <th>ADRESSE MAC</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody id="retourjs">
                        	<?php 
                            $i =0;
                            foreach($equipement->recupererAntennes() as $value)
                            {
                                $i++;
                            ?>
                                <tr>
                                    <td><?=$value->date_stock?></td> 
                                    <td><?php echo $value->fabriquant?> </td>
                                    <td><?php echo $value->model?></td>
                                    <td><?php echo $value->first_adress?></td>
                                    <!--td>
                                    	<php
                                    		foreach ($equipement->recupereMacAdresses($value->ID_equipement) as $mac) 
                                    		{
                                    			echo "$mac->mac <br>";
                                    		}
                                    	?>
                                    </td-->
                                     
                                    <td class="text-nowrap">
                                    <?php
                                    if ($m) 
                                    {?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <?php
                                    }
                                    ?>

                                    <div class="modal fade bs-example-modal-lg<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Nouvelle antenne</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body"> 
                                                    <form class="form-horizontal p-t-0">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Model*</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" id="type_equipement<?=$i?>" value="antenne" hidden="hidden">
                                                                        <select class="form-control" id="model<?=$i?>">
                                                                            <option value=""></option>
                                                                            <?php
                                                                            foreach ($models as $model) 
                                                                            {
                                                                                if ($model->id == $value->model_id) 
                                                                                {
                                                                            ?>
                                                                                    <option value="<?=$model->id?>" selected><?=$model->name?></option>
                                                                            <?php
                                                                                }
                                                                                else
                                                                                {
                                                                            ?>
                                                                                    <option value="<?=$model->id?>"><?=$model->name?></option>
                                                                            <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                   </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Mac adresse*</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" value="<?=$value->first_adress?>" id="mac<?=$i?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- END ROW-->
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Date ajout*</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="date" class="form-control" id="date_ajout<?=$i?>" value="<?=$value->date_stock?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- END ROW-->
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="exampleInputuname3" class="col-sm-3 control-label">Description</label>
                                                                    <div class="col-sm-9">
                                                                        <textarea class="form-control" id="description<?=$i?>"><?=$value->description?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- END ROW-->
                                                    </form>
                                                </div>
                                                <div class="modal-footer"> 
                                                    <span id="msg"></span>
                                                    <button type="button" class="btn text-white btn-chocolate" onclick="updateAntenne('<?=$value->ID_equipement?>',$('#model<?=$i?>').val(),$('#mac<?=$i?>').val(),$('#user').val(),$('#date_ajout<?=$i?>').val(),$('#description<?=$i?>').val())"> <i class="fa fa-check"></i> Modifier</button>
                                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!--/.modal-dialog -->
                                    </div>
                                    <!--/. model -->

                                    <?php
                                    if ($s) 
                                    {?>
                                       <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                                    <?php
                                    }
                                    ?>

                                    <!-- sample modal content -->
                                    <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="mySmallModalLabel">Supprimer antenne</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body"> 
                                                <input type="text" class="form-control" id="id<?=$i?>" value="<?=$value->ID_equipement?>" hidden>
                                                Voulez-vous supprimer cette antenne?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimerAntenne($('#id<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?></tbody>
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