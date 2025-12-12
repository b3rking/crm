<?php
require_once("../../model/connection.php");
require_once("../../model/equipement.class.php");
$equipement = new Equipement();
?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-xl-3"></div>
    <div class="col-lg-6 col-md-6 col-xl-6">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="m-b-0 text-white">Fermeture de Recuperation</h4>
            </div>
            <div class="card-body" id="responsive">
                <form>
                <input type="text" id="idticket" value="<?=$_GET['idticket']?>" hidden>
                <input type="text" id="user" value="<?=$_GET['user']?>" hidden>
                <input type="text" id="observation" value="<?=$_GET['observation']?>" hidden>
                <input type="text" id="endroit" value="<?=$_GET['endroit']?>" hidden>
                <input type="text" id="type_ticket" value="<?=$_GET['type_ticket']?>" hidden>
                <input type="text" id="idclient" value="<?=$_GET['idclient']?>" hidden>

                <div class="table-responsive m-t-0" >
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>    
                                <th>Materiel(s) à recuperer </th>
                            </tr>
                        </thead>
                        <tbody id="reponse">
                        <?php 

                            $i = 0;
                            foreach($equipement->getEquipementAttribuerAunClient($_GET['idclient']) as $data)
                            {
                            $i++;
                        ?>
                            <tr>
                                <td>
                                    <input type="text" id="idequipement<?=$i?>" value="<?=$data->ID_equipement?>" hidden>
                                    <input type="text" id="model<?=$i?>" value="<?=$data->model?>" hidden>
                                    <input type="text" id="fabriquant<?=$i?>" value="<?=$data->fabriquant?>" hidden>
                                    <input type="text" id="type_equipement<?=$i?>" value="<?=$data->type_equipement?>" hidden>
                                    <input type="text" id="dateStock" value="<?=date('Y-m-d')?>" hidden>
                                    <div class="col-sm-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="equipement" class="custom-control-input" id="customCheck<?=$i?>" value="<?=$i?>">
                                            <label class="custom-control-label" for="customCheck<?=$i?>"><?php echo $data->type_equipement."/".$data->model."/".$data->fabriquant."/";$y = 0; foreach($equipement->recupereMacAdressesHisto($data->ID_equipement) as $value)
                                            {
                                                $y++;
                                                if ($y == 1) 
                                                {
                                                    echo $value->mac;
                                                }
                                            }
                                            ?>
                                                
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            }
                        ?>                              
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-md-3 col-lg-3 offset-3">
                        <button type="button" class="btn btn-success" onclick="fermerRecuperation()"> <i class="fa fa-check"></i> Recuperer</button>
                    </div>
                    <span id="msg"></span>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>