<?php
ob_start();
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3">
        <div class="card">
           
            <div style="background-color: #ef7f22" class="card-header text-white box bg text-center">
           
                Attribution d'accessoires a un client
        </div>
            <div class="card-body">
                 <a href="<?=WEBROOT?>accessoire" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span></button>
                <form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Client*</label>
                                <div class="form-group col-sm-9">
                                    <input type="text" id="idclient_attribu_accessoir" name="idclient" class="form-control  input-filter" autocomplete="off">
                                        <div id="modalAtribu_accessoire"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label ">accessoire* </label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select class="form-control  input-filter"  id="accessoire">
                                            <option></option>
                                             <?php 
                                            foreach ($equipement->selectionaccessoire() as $value)
                                            {
                                            ?>
                                                <option value="<?php echo $value->ID_accessoire.'-'.$value->quantite?>">
                                                    <?php echo $value->categorie;?>
                                                    </option>                  
                                         <?php
                                            }
                                            ?>
                                        </select>
                                    </div>                  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                       <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Quantite*</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="number" class="form-control  input-filter" id="quantite">
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                       <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Date*</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="date" class="form-control  input-filter" id="date_attribution" value="<?=date('Y-m-d')?>">
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
               
                        <div class="row">
                        <div class="col-3"></div>
                       <div class="col-lg-6 col-md-6">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-3 control-label">Motif</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea class="form-control  input-filter" id="motif"></textarea>
                                        <input type="text" id="user" value="<?=$_SESSION['ID_user']?>" hidden="">
                                        <span id="msg"></span>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-2">
                           
                            <button  type="button" style="background-color: #7c4a2f" class="btn btn- text-white"  onclick="attribuer_accessoire($('#idclient_attribu_accessoir').val(),$('#accessoire').val(),$('#quantite').val(),$('#date_attribution').val(),$('#motif').val(),$('#user').val())"> <i class="fa fa-check"></i>Attribuer </button>
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