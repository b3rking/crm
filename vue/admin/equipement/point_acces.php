<?php
ob_start();
$l = false;
$c = false;
$m = false;
$s = false;
if ($d = $user->verifierPermissionDunePage('base',$_SESSION['ID_user'])->fetch()) 
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
	<div class="card" >
        <div class="card-body" id="save" >
            <a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>
             <!--a href="<?=WEBROOT?>technique" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"> Retour</i></a><span class="btn-label"></span></button-->
		    <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                </div>
                <div class="col-md-7 align-self-center">
                <div class="d-flex justify-content-end align-items-center">
                <?php
                if ($c) 
                {?>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Equipement</a></li>
                        <li class="breadcrumb-item active">point d'acces</li>
                    </ol>
                    <button type="button" style="background-color: #8b4513" class="btn text-white d-none d-lg-block m-l-15" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle" class="modal fade" tabindex="-1" role="dialog"></i>Ajouter point d'acces</button>
                <?php
                }
                ?>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Nouveau point acces</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                    <div class="modal-body">
                        <form class="form-horizontal p-t-20">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                <div class="form-group row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Secteur*</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="icon-feed"></i></span></div>
                                        <select class="form-control custom-select" id="secteurpa">
                                            <?php
                                            foreach ($equipement->selection_Secteur() as $data)
                                            {?>
                                                <option value="<?php echo $data->ID_secteur?>"><?php echo $data->ID_secteur.'-'.$data->nom_secteur?></option>
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
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">SSID*</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                                <input type="text" class="form-control" id="ssidpa" placeholder="ssid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- END ROW-->
                            
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">Nom*</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                <input type="text" class="form-control" id="nompa" placeholder="nom">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Frequence*</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="frequence" placeholder="frequence">
                                                <div class="input-group-prepend"><span class="input-group-text">Mhz</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End row-->
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group row">
                                        <label for="exampleInputuname3" class="col-sm-3 control-label">Antenne*</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                                <select class="form-control" id="antene_type_pa" onchange="recupererMacAntenne($('#antene_type_pa').val())">
                                                    <option value=""></option>
                                                    <?php
                                                    foreach ($equipement->recupererAntennes() as $value) 
                                                    {
                                                    ?>
                                                    <option value="<?=$value->ID_equipement."-".$value->first_adress?>"><?=$value->model?></option>
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
                                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Limite antenne*</label>
                                             <div class="col-sm-9">
                                               <div class="input-group">
                                              <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span>           
                                              </div>
                                        <input type="number" class="form-control" id="ant_limite_pa" placeholder="Limite antenne">
                                    </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">MAC*</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>
                                   <input type="text" class="form-control" id="macpa" placeholder="mac" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">IP*</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                    <input type="text" class="form-control" id="ipa" placeholder="ip">
                                </div>
                                <span id="msg"></span>
                            </div>
                        </div>
                    </div>                           
                </div><!-- End row -->
                        </form>
                    </div>
                        <div class="modal-footer">
                            <span id="msgError"></span>
                            <button type="button" style="background-color: #8b4513" class="btn text-white" onclick="newPoint_acces($('#secteurpa').val(),$('#nompa').val(),$('#ipa').val(),$('#macpa').val(),$('#antene_type_pa').val(),$('#frequence').val(),$('#ssidpa').val(),$('#ant_limite_pa').val(),$('#iduser').val())">Ajouter point d'acces
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!--/.modal-dialog -->
                </div>
            </div>
        </div>
    </div>
	      
	        <div class="table-responsive m-t-0" >
	            <table id="myTable" class="table table-bordered table-striped" cellspacing="0" width="100%">
	                <thead>
	                    <tr>    
	                        <th>Secteur</th>
	                        <th>Nom</th>
	                        <th>IP</th>
	                        <th>MAC</th>
                            <th>Equipement</th>
                            <th>FREQUENCE</th>
                            <th>SSID</th>
	                        <th>Limite</th>
                            <th></th>	                        
	                    </tr>
	                </thead>
	                <tfoot>
	                    <tr>                           
                            <th>Secteur</th>
                            <th>Nom</th>
                            <th>IP</th>
                            <th>MAC</th>
                            <th>Equipement</th>
                            <th>FREQUENCE</th>
                            <th>SSID</th>
                            <th>Limite</th>
                            <th></th>	                        
	                    </tr>
	                </tfoot>
	                <tbody id="reponse">
                    <?php 
            $i = 0;
            foreach($equipement->affichagePoint_acces() as $data)
            {
            $i++;
            ?>
            <tr>
                <!--<td><hp echo $data->ID_point_acces?></td>-->
                <td><?php echo $data->secteur?></td> 
                <td><?php echo $data->nom?></td>
                <td><?php echo $data->ip?></td>
                <td><?php echo $data->mac?></td>
                <td><?php echo $data->antenne?></td>
                <td><?php echo $data->frequence?></td>
                <td><?php echo $data->SSID?></td>
                <td><?php echo $data->antenne_limite?></td>
                <td class="text-nowrap">
                    <?php
                    if ($m) 
                    {?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lg<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                    <?php
                    }
                    ?>
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-lg<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Modifier le point d'acces</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20">
                <div class="row">
                    <label for="exampleInputuname3" class="col-sm-3 control-label"></label>
                <div class="col-sm-9" >
                    <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"hidden><i class="ti-user"></i></span>
                </div>
                <input type="text" class="form-control" id="idpa<?= $i?>" value="<?php echo $data->ID_point_acces?>" hidden>
            </div>
        </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Nom</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ti-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="nompa<?= $i?>" value="<?php echo $data->nom?>">
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">Frequence</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                            <input type="text" class="form-control" id="frequence<?= $i?>" value="<?php echo $data->frequence?>">
                        </div>
                    </div>
                </div>
                </div>
                 <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">IP</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                <input type="text" class="form-control" id="ipa<?= $i?>" value="<?php echo $data->ip?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group row">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">limite antenne</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                                <input type="text" class="form-control" id="ant_limite_pa<?= $i?>" value="<?php echo $data->antenne_limite?>">
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                </div><!-- END ROW-->
                <div class="row">
                <div class="col-lg-6 col-md-6">
                <div class="form-group row">
                    <label for="exampleInputEmail3" class="col-sm-3 control-label">SSID</label>
                    <div class="col-sm-9">

                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div>
                    <input type="text" class="form-control" id="ssidpa<?=$i?>" value="<?php echo $data->SSID?>">
                </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-6 col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">MAC</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"></span></div>
                                     <input type="text" class="form-control" id="mac_adress<?=$i?>" value="<?php echo $data->mac?>">
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div><!-- End row-->
              
                </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #8b4513" class="btn text-white" onclick="update_point_acces($('#idpa<?=$i?>').val(),$('#nompa<?=$i?>').val(),$('#frequence<?=$i?>').val(),$('#ipa<?=$i?>').val(),$('#ant_limite_pa<?=$i?>').val(),$('#ssidpa<?=$i?>').val(),$('#mac_adress<?=$i?>').val())" data-dismiss="modal">changer
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal">Fermer</button>
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
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="Supprimer"> <i class="ti-trash text-inverse m-r-10"></i> </a>
                    <?php
                    }
                ?>

                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer point d'acces</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="nupa<?= $i?>" value="<?php echo $data->ID_point_acces?>" hidden>
                            Voulez-vous supprimer ce point d'acces?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="supprimer_point_acces($('#nupa<?= $i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
        </td>
    </tr>
            <?php
        }?>    		                    
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