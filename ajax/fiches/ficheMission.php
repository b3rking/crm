<?php
require_once("../../model/connection.php");
require_once("../../model/User.class.php");
$user = new User();


?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
            <form action="/crm.buja/genereOrdremission" method="post" class="form-horizontal p-t-20">
               <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Date de départ: </label>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <input type="date" class="form-control" name="dateMission" id="dateMission">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label for="exampleInputEmail3" class="col-sm-3 control-label">Date de retour: </label>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <input type="date" class="form-control" name="dateRetour" id="dateMission">
                            </div>
                        </div>
                    </div>
                </div>
               <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>NOM</th>
                                <th>Fonction</th>
                                <th>Intervenant</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Numero</th>
                                 <th>NOM</th>
                                <th>Fonction</th>
                                <th>Intervenant</th>
                            </tr>
                        </tfoot>
                        <tbody id="rep">
                                <?php 
                            $i =0;
                            foreach ($user->afficheUsers() as  $value)
                             {?>
                               <?php
                               $i++; ?>
                               <tr>
             
                            <td><?php echo $value->ID_user?></td>
                            <td><?php echo $value->nom_user?></td>
                            <!--<td><php echo $value->email?></td>-->
                            <td><?php echo $value->role?></td>         
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
                        <button  type="submit" class="btn btn-dribbble waves-effect btn-rounded waves-light" >Generer fiche de mission </button>
                    </div>
                </form>
               </div>
            </div>
        </div>
    </div>
</div>