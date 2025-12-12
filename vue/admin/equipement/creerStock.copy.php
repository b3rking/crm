<?php
ob_start();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h4 class="m-b-0 text-white">Ajouter un equipement dans le stock</h4>
            </div>
            <div class="card-body">
                <div id="rep"></div>
                <form>
                    <div class="form-body">
                        <hr>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Type d'equipement</label>
                                    <select class="form-control custom-select" id="type_equipement" onchange="getTypeEquipement($('#type_equipement').val())">
                                        <option value=""></option>
                                        <option value="antenne">antenne</option>
                                        <option value="routeur mikrotik">routeur mikrotik</option>
                                        <option value="routeur D-link">routeur D-link</option>
                                        <option value="switch">switch </option>
                                    </select>
                                    <input type="text" id="number" value="0" hidden="">
                                </div>
                            </div>
                            <div id="divIncludeRouteur"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">ID Equipement</label>
                                    <input type="text" id="id" class="form-control" placeholder="Entreer l'ID">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Model</label>
                                    <input type="text" id="model" class="form-control" placeholder="Model">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Fabriquant</label>
                                    <input type="text" id="fabriquant" class="form-control" placeholder="fabriquant">
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Premiere Adresse mac</label>
                                    <input type="text" class="form-control" placeholder="example : 00:2C:AD:AF:EB:06" id="mac">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Numero de serie</label>
                                    <input type="text" class="form-control" placeholder="Numero de serie" id="numeroSerie">
                                    <input type="text" id="user" value="<?=$_SESSION['ID_user']?>" hidden="">
                                </div>
                            </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-success" onclick="ajouterStock($('#id').val(),$('#model').val(),$('#fabriquant').val(),$('#type_equipement').val(),$('#mac').val(),$('#number').val(),$('#numeroSerie').val(),$('#user').val())"> <i class="fa fa-check"></i> Save</button>
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