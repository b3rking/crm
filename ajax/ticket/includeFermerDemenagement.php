<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
$equipement = new Equipement();

?>
<div class="row">
    <div class="col-lg-3 col-xlg-3"></div>
    <div class="col-lg-6 col-md-12 col-xlg-6">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="m-b-0 text-white">Fermeture de demenagement</h4>
            </div>
            <div class="card-body" id="responsive">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="row">
                            <input type="text" id="idticket" value="<?=$_GET['idticket']?>" hidden>
                            <input type="text" id="user" value="<?=$_GET['user']?>" hidden>
                            <input type="text" id="observation" value="<?=$_GET['observation']?>" hidden>
                            <input type="text" id="endroit" value="<?=$_GET['endroit']?>" hidden>
                            <input type="text" id="type_ticket" value="<?=$_GET['type_ticket']?>" hidden>
                            <input type="text" id="idclient" value="<?=$_GET['idclient']?>" hidden>
                            <label for="exampleInputEmail3" class="col-sm-4 col-md-4 col-lg-4 control-label">Nouvelle Station*</label>
                            <div class="col-sm-8 col-md-8 col-lg-8">
                                <div class="form-group">
                                    <select class="form-control" id="point_acces">
                                    <option></option>
                                    <?php
                                    foreach ($equipement->recuperePointAccesNoDepasserClient() as $value) 
                                    {
                                    ?>
                                        <option value="<?=$value->ID_point_acces?>"><?=$value->nom?></option>
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
                    <div class="col-sm-3 col-md-3 col-lg-3 offset-3">
                        <button type="button" class="btn btn-success" onclick="fermerDemenagement($('#point_acces').val())"> <i class="fa fa-check"></i> Fermer</button>
                    </div>
                    <span id="msg"></span>
                </div>
            </div>
        </div>
    </div>
</div>