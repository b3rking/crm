<?php
ob_start();
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-xl-12">
        <div class="card">
              <div class="card-body">
                    <form action="/crm.buja/fichepanne" method="post" class="form-horizontal">
                        <div class="form-body">
                            <h1 >Fiche dintervention    
                            </h1>
                            <?php
                            if (isset($message)) 
                            {
                                echo $message;
                            }
                            ?>
                            <hr class="m-t-0 m-b-40">
                            
                            <!--/row-->
                                <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Vehicule</label>
                                        <div class="col-md-9">                                           
                                    <select class="form-control custom-select" id="plaque" name="plaque">
                                        <option></option>
                                        <?php
                                        foreach ($vehicule->selection_plaque() as $value)
                                        {?>
                                            <option value="<?php echo $value->immatriculation.'   '.$value->marque?>"><?php echo $value->marque.' - '.$value->immatriculation?></option>
                                                
                                        <?php
                                       }
                                        ?>
                                     </select> 
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4">Technicien </label>
                                        <div class="col-md-8">
                                            <select class="form-control custom-select" onchange="SignatureTechnicien($('#idUser').val())" id="idUser" name="Nomtechnicien">
                                            <option value=""></option>
                                            <?php
                                            foreach ($user->selectionUser() as $data)
                                            {?>
                                            <option value="<?php echo $data->ID_user.'-'.$data->nom_user?>"><?php echo $data->nom_user?></option>
                                            <?php
                                            }
                                            ?>
                                            </select> 
                                        </div>
                                    </div>
                            </div>
                        </div>
                              
                            <!--/row-->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xl-12">
                              <div class="card">
                                <div class="card-header btn-dribbble">
                                    <h4 class="m-b-0 text-dribbble">Liste des tickets à inclure sur la fiche</h4>
                                </div>
                                <div class="card-body">
                               
                                <div class="table-responsive m-t-40">

                                    <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>NUMERO</th>
                                    <th>CLIENT</th>
                                    <th>ADRESSE</th>
                                    <th>TELEPHONE</th>
                                    <th>Choisir Client</th>
                                </tr>
                                </thead>
                                <tbody id="rep" >

                                 <?php 
                                 $i = 0;
                                 foreach($ticket->afficheTicket_client() as $value)
                                    {
                                        $i++;
                                    ?>
                                       <tr>
                                    <td><?php echo $value->ID_client?></td>
                                    <td><?php echo $value->Nom_client?> </td>
                                    <td><?php echo $value->adresse?></td>
                                    <td><?php echo $value->telephone?></td>
                                    <td><input type="checkbox" name="ticket[<?=$i?>]" id="observation_ticket" value="<?=$value->id?>"><?php ?>
                                    <input type="text" name="createurFiche" value="<?php echo $_SESSION['ID_user']?>" hidden>
                                    
                                </td>
                                    
                                </tr>
                                    <?php
                                    }
                                    ?>        

                                </tbody>

                                </table>
                                </div>
                            </div>
                        </div>
                                </div>
                            </div>
                            <hr class="m-t-0 m-b-40">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-xlg-6"></div>
                                <div class="col-md-6 col-lg-6 col-xlg-6">
                                    <button type="submit" class="btn btn-warning d-none d-lg-block m-l-15"><i class="icon-printer" ></i> Imprimer</button>
                                </div>
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