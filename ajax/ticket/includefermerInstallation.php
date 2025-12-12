<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
$equipement = new Equipement();
//idticket,user,observation,endroit,date_fermeture,type_ticket,idclient
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="m-b-0 text-white">Fermeture d'Installation</h4>
            </div>
            <div class="card-body" id="responsive">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <input type="text" id="idticket" value="<?=$_GET['idticket']?>" hidden>
                            <input type="text" id="user" value="<?=$_GET['user']?>" hidden>
                            <input type="text" id="observation" value="<?=$_GET['observation']?>" hidden>
                            <input type="text" id="endroit" value="<?=$_GET['endroit']?>" hidden>
                            <input type="text" id="type_ticket" value="<?=$_GET['type_ticket']?>" hidden>
                            <input type="text" id="idclient" value="<?=$_GET['idclient']?>" hidden>

                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Station*</label>
                            <div class="form-group col-sm-9">
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
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Antenne*</label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <select id="antenne" class="form-control">
                                        <option></option>
                                        <?php
                                        foreach ($equipement->recupererAntennes() as $value) 
                                        {
                                        ?>
                                            <option value="<?=$value->ID_equipement?>"><?=$value->model.' / '.$value->mac?></option>
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
                    <div class="col-lg-6 col-md-6">
                        <div class="row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Routeur*</label>
                            <div class="form-group col-sm-9">
                                <select class="form-control" id="routeur">
                                    <option value=""></option>
                                    <?php
                                    foreach ($equipement->recupererRouteur() as $value) 
                                    {
                                    ?>
                                        <option value="<?=$value->ID_equipement?>"><?=$value->model.' / '.$value->mac?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Switch</label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <select class="form-control" id="switch">
                                        <option></option>
                                        <?php
                                        foreach ($equipement->recupererSwitch() as $value) 
                                        {
                                        ?>
                                            <option value="<?=$value->ID_equipement?>"><?=$value->model.' / '.$value->mac?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="text" id="date_instal" value="<?= date('Y-m-d')?>" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Switch</label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="date_instal" value="<?= date('Y-m-d')?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-lg-3 offset-3">
                        <button type="button" class="btn btn-success" onclick="fermerInstallation($('#point_acces').val(),$('#antenne').val(),$('#routeur').val(),$('#switch').val(),$('#date_instal').val())"> <i class="fa fa-check"></i> Fermer</button>
                    </div>
                    <span id="msg"></span>
                </div>
            </div>
        </div>
    </div>
</div>