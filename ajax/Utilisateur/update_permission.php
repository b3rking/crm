<?php
require_once("../../model/connection.php");
require_once("../../model/User.class.php");
require_once("../../model/comptabilite.class.php");
    $comptabilite = new Comptabilite();

$user = new User();

//$idUser = preg_split("#[-]+#", $_GET['idUser']);
$userName = $_GET['userName'];
if ($user->update_permission($_GET['idpermission'],$_GET['lire'],$_GET['creer'],$_GET['modifier'],$_GET['supprimer'],$_GET['page_accept'])) 
{
	if ($comptabilite->setHistoriqueAction($_GET['idpermission'],'utilisateur',$_GET['userName'],date('Y-m-d'),'modifier'))
	{
	//require_once('rep.php');
	$i = 0;
  	foreach ($user->affiche_permission_par_profil($_GET['profil_id']) as $value) 
	{ 
	$i++;
	?>
	<tr>
	    <td><?php echo $value->page?></td>
	<?php 
	if ($value->L == 1) 
	{?>
	  <td><label class="text-success"><i class="fa fa-check "></i></label></td>
	    
	<?php
	}
	else
	{?>
	  <td><label class="text-danger"><i class="fa fa-close "></i></label></td>
	<?php 
	} 
	if ($value->C == 1) 
	{?>
	  <td><label class="text-success"><i class="fa fa-check "></i></label> </td>
	    
	<?php
	}
	else
	{?>
	  <td><label class="text-danger"><i class="fa fa-close "></i></label></td>
	<?php 
	}
	if ($value->M == 1) 
	{?>
	  <td><label class="text-success"><i class="fa fa-check "></i></label></td>
	<?php
	}
	else
	{?>
	  <td><label class="text-danger"><i class="fa fa-close "></i></label></td>
	<?php 
	} 
	if ($value->S == 1) 
	{?>
	  <td><label class="text-success"><i class="fa fa-check "></i></label></td>    
	<?php
	}
	else
	{?>
	  <td><label class="text-danger"><i class="fa fa-close "></i></label></td>
	<?php 
	}
	?>
	  <td>
	<?php
	if ($_GET['droit']) 
	{?>
	    <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-lgs<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
	    <!-- sample modal content -->
	<div class="modal fade bs-example-modal-lgs<?= $i?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
	  <div class="modal-dialog modal-lgs">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title" id="myLargeModalLabel">Modification des droits le profil</h4>
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	      </div>
	      <form class="form-horizontal p-t-20">
	      <div class="modal-body">
	          <div class="row">
	            <div class="col-lg-6 col-md-6">
	              <div class="form-group row">
	                <label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Lire</label>
	                <div class="col-sm-9 col-lg-5">
	                    <!--<input type="number" id="lire<?=$i?>" value="<?=$value->L?>" class="form-control">-->
	                    <select class="form-control" id="lire<?=$i?>">
	                      <?php
	                      if ($value->L == 0) 
	                      {
	                      ?>
	                        <option value="<?=$value->L?>" selected>Non</option>
	                        <option value="1">Oui</option>
	                      <?php
	                      }
	                      else
	                      {
	                      ?>
	                        <option selected="" value="<?=$value->L?>">Oui</option>
	                        <option value="0">Non</option>
	                      <?php
	                      }
	                      ?>
	                    </select>
	                </div>
	              </div>
	            </div>
	            <div class="col-md-6 col-lg-6">
	              <div class="form-group row">
	                <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Creer</label>
	                <div class="col-sm-9 col-lg-5">
	                    <!--<input type="number" id="creer<?=$i?>" value="<?=$value->C?>" class="form-control">-->
	                    <select class="form-control" id="creer<?=$i?>">
	                      <?php
	                      if ($value->C == 0) 
	                      {
	                      ?>
	                        <option value="<?=$value->C?>" selected>Non</option>
	                        <option value="1">Oui</option>
	                      <?php
	                      }
	                      else
	                      {
	                      ?>
	                        <option selected="" value="<?=$value->C?>">Oui</option>
	                        <option value="0">Non</option>
	                      <?php
	                      }
	                      ?>
	                    </select>
	                </div>
	              </div>
	            </div>
	          </div>
	          <div class="row">
	            <div class="col-md-6 col-lg-6">
	              <div class="form-group row">
	                <label for="exampleInputuname3" class="col-sm-3 col-lg-4 control-label">Modifier</label>
	                <div class="col-sm-9 col-lg-5">
	                    <!--<input type="number" id="modifier<?=$i?>" value="<?=$value->M?>" class="form-control">-->
	                    <select class="form-control" id="modifier<?=$i?>">
	                      <?php
	                      if ($value->M == 0) 
	                      {
	                      ?>
	                        <option value="<?=$value->M?>" selected>Non</option>
	                        <option value="1">Oui</option>
	                      <?php
	                      }
	                      else
	                      {
	                      ?>
	                        <option selected="" value="<?=$value->M?>">Oui</option>
	                        <option value="0">Non</option>
	                      <?php
	                      }
	                      ?>
	                    </select>
	                </div>
	              </div>
	            </div>
	            <div class="col-md-6 col-lg-6">
	              <div class="form-group row">
	                <label for="exampleInputuname3" class="col-sm-3 col-lg-5 control-label">Supprimer</label>
	                <div class="col-sm-9 col-lg-5">
	                    <!--<input type="number" id="supprimer<?=$i?>" value="<?=$value->S?>" class="form-control">-->
	                    <select class="form-control" id="supprimer<?=$i?>">
	                      <?php
	                      if ($value->S == 0) 
	                      {
	                      ?>
	                        <option value="<?=$value->S?>" selected>Non</option>
	                        <option value="1">Oui</option>
	                      <?php
	                      }
	                      else
	                      {
	                      ?>
	                        <option selected="" value="<?=$value->S?>">Oui</option>
	                        <option value="0">Non</option>
	                      <?php
	                      }
	                      ?>
	                    </select>
	                    <input type="text" id="idpermission<?=$i?>" value="<?=$value->id?>" hidden>
	                    <input type="text" id="i<?=$i?>" value="<?=$i?>" hidden>
	                </div>
	              </div>
	            </div>
	          </div>
	      </div>
	      <div class="modal-footer">
	        <span id="msg<?=$i?>"></span>
	        <button type="button" style="background-color: #7c4a2f" class="btn text-white" onclick="update_permission($('#idpermission<?=$i?>').val(),$('#lire<?=$i?>').val(),$('#creer<?=$i?>').val(),$('#modifier<?=$i?>').val(),$('#supprimer<?=$i?>').val(),$('#i<?=$i?>').val())" data-dismiss="modal">Modifier
	        </button>
	        <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Fermer</button>
	      </div>
	      </form>
	    </div>
	    <!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<?php
	}
	?>
	  </td>
	</tr>
	<?php
	}
}
}
?>
<input type="text" id="userName" value="<?=$userName?>" hidden>
