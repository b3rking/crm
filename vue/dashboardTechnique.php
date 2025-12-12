<?php
    ob_start(); 
    $date = date_parse(date('Y-m-d'));  
?> 
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<div class="card">
    <div class="card-body">
        <h3 class="card-title">TICKETS OUVERTS PAR TYPE</h3>
        <div class="row">
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">

                    <div class="box bg-info text-center">
                        <h3 class="font-light text-white">
                            <?php 
                          $recuperation = $ticket->getrecuperation()->nb;
                          ?>
                    <button type="button" class="btn btn-sm btn-rounded box bg-info"><a href="<?=WEBROOT;?>client_recuperer" class="font-light text-white">Total Recuperation <?= $recuperation?></a></button>

                        </h3>
                    </div>
                </div>
            </div>
             <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-success text-center">
                        <h3 class="font-light text-white"><?php
                        $installation = $ticket->getinstallation()->nbreinstallation;
                        ?>
                            
                            <button type="button" class="btn btn-sm btn-rounded btn-success">
                                <a href="<?=WEBROOT;?>installer" class="font-light text-white">Total Installation </a><?= $installation?></button></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-megna text-center">
                        <h3 class="font-light text-white"><?php
                        $demenagement = $ticket->getdemenagement()->demenagt;

                        ?>
                        <button type="button" class="btn btn-sm btn-rounded bg-megna"><a href="<?=WEBROOT;?>printclient_demenager" class="font-light text-white">Total Demenagement <?= $demenagement?></a></button>
                           </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-primary text-center"> 
                        <h3 class="font-light text-white"><?php
                        $panne = $ticket->getdepannage()->nb;
                        ?><button type="button" class="btn btn-sm btn-rounded box bg-primary"><a href="<?=WEBROOT;?>pannes_client" class="font-light text-white">Total Pannes <?= $panne?></a></button>
                             
                       </h3>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>
 


<div class="card">
    <div class="card-body">
        <h3 class="card-title">MATERIELS EN STOCK</h3>
        <div class="row"> 
            <?php
            $dashbordNombreEquipement = array();

            foreach ($equipement->nombreAntenneParModel() as $value) 
            {
              $dashbordNombreEquipement[] = $value;
            ?>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div style="background-color: #6D071A" class="box  text-center">
                      <h1 class="font-light text-white"><?= $value->nb?></h1>
                      <h6><a href="<?=WEBROOT;?><?=$value->type_equipement?>"><?=ucfirst($value->type_equipement).' '.$value->model?> en stock<a/></h6>
                    </div>
                </div>
            </div>
            <?php
            }
        
            $dashbordNombreEquipement = array();

            foreach ($equipement->nombreRouteurParModel() as $value) 
            {
              $dashbordNombreEquipement[] = $value;
            ?>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div style="background-color: #00a29b" class="box   text-center">
                      <h1 class="font-light text-white"><?= $value->nb?></h1>
                      <h6><a class="text-white" href="<?=WEBROOT;?><?=$value->type_equipement?>"><?=ucfirst($value->fabriquant).' '.$value->model?> en stock<a/></h6>
                    </div>
                </div>
            </div>
            <?php
            }
            
            $dashbordNombreEquipement = array();

            foreach ($equipement->nombreRadioParModel() as $value) 
            {
              $dashbordNombreEquipement[] = $value;
            ?>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div style="background-color: #00a30c" class="box   text-center">
                      <h1 class="font-light text-white"><?= $value->nb?></h1>
                      <h6><a class="text-white" href="<?=WEBROOT;?><?=$value->type_equipement?>"><?=ucfirst($value->type_equipement).' '.$value->model?> en stock<a/></h6>
                    </div>
                </div>
            </div>
            <?php
            }
            
            $dashbordNombreEquipement = array();

            foreach ($equipement->nombreSwitchParModel() as $value) 
            {
              $dashbordNombreEquipement[] = $value;
            ?>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div style="background-color: #05a2ac" class="box   text-center">
                      <h1 class="font-light text-white"><?= $value->nb?></h1>
                      <h6><a class="text-white" href="<?=WEBROOT;?><?=$value->type_equipement?>"><?=ucfirst($value->type_equipement).' '.$value->model?> en stock<a/></h6>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">ACCESSOIRES EN STOCK</h3>
        <div class="row"> 
            <?php
            $_SESSION['dashbordNombreEquipement'] = $dashbordNombreEquipement;
            $dashbordNombreAccessoir = array();
            foreach ($equipement->getAccessories() as $value) 
            {
              $dashbordNombreAccessoir[] = $value;
            ?>
                <div class="col-md-6 col-lg-3 col-xlg-3">
                  <div class="card">
                      <div class="box bg-primary text-center">
                        <h3 class="font-light text-white"><?=$value->quantite?></h3>
                        <h6 class="text-white"><?=$value->categorie?> en stock</h6>
                      </div>
                  </div>
                </div>
            <?php
            }
            $_SESSION['dashbordNombreAccessoir'] = $dashbordNombreAccessoir;
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">SECTEURS ET POINT D'ACCES</h3>
                 <div class="row">
            <div class="col-md-6 col-lg-6 col-xlg-6">
                <div class="card">

                    <div class="box bg-info text-center">
                        <h3 class="font-light text-white">
                            <?php 
                          $data =$equipement->Total_secteur()->fetch();
                          ?>
                    <button type="button" class="btn btn-sm btn-rounded box bg-info"><a href="<?=WEBROOT;?>secteur" class="font-light text-white">Total Secteur <?php echo $data['nb'];?></a></button>

                        </h3>
                    </div>
                </div>
            </div>
             <div class="col-md-6 col-lg-6 col-xlg-6">
                <div class="card">
                    <div class="box bg-success text-center">
                        <h3 class="font-light text-white"><?php
                        $data =$equipement->Total_Base()->fetch();
                        ?>
                            
                            <button type="button" class="btn btn-sm btn-rounded btn-success"><a href="<?=WEBROOT;?>point_acces" class="font-light text-white">Total Base </a><?php echo $data['nb'];?></button></h3>
                    </div>
                </div>
            </div>
           
          
        </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                INSTALLATION PAR MOIS ANNEE <?php
                echo date(" Y");?></h4>
                    <div class="table-responsive">
                    <table class="table full-color-table full-info-table hover-table">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Installation</th>
                            </tr>
                        </thead>
                        <tbody>
                                 <?php

                            $resulta = array();

                             $mois = ['1','2','3','4','5','6','7','8','9','10','11','12'];
                             $tb_mois= [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
                            for ($i=1; $i < $date['month'] +1; $i++) 
                            {     
                                ?>
                            <tr for='installation' >
                                <td > 
                                    <?php 
                                    echo ucfirst($tb_mois[$i]);

                                    ?> 

                                    </td>
                                <td >
                                    <?php
                                $rs = 0;
                                $rs = $ticket->installationParmois($i,$date['year'])->fetch();

                                ?>

                               <?= $rs['nb'];?>installation <a href="<?= WEBROOT;?>getinstalationDmois-<?= $i.'-'.$date['year'];?>" id='installation'><i class="mdi mdi-printer"></i></a>
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




<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>
<!--id="mois" onclick="genereInstallation($(this).val())"a href="<WEBROOT;?>clientinstallerdumois"><h4><= $rs['nb'];?> client installer dans ce mois</h4></a-->