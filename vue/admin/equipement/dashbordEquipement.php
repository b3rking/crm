<?php
ob_start();
?>


  <div class="col-lg-12 col-md-12 col-xl-12">
    <div class="card">
        <div class="card-body">
          <a href="javascript:history.back()" class="btn btn-outline-primary waves-effect waves-light" type="button" ><i class="fa fa-fast-backward"></i></a><span class="btn-label"></span>
          <!--small><a href="/system/settings/localization" class="appType--quiet" data-tooltip="Heure système GMT+02:00 Africa/Cairo" data-clock="2020-03-17T12:20:15+02:00"><?php echo date('d-m-Y H:i'); ?></a></small-->
          <div class="row page-titles">
            <div class="col-md-5 align-self-center">
            </div>
            <div class="col-md-7 align-self-center text-right">
                <div class="d-flex justify-content-end align-items-center">
                    
                    <a href="<?= WEBROOT;?>etat_Stock" type="button" class="list-group-item list-group-item-primary" class="btn btn-primry d-none d-lg-block m-l-15"><i class="mdi mdi-printer"></i>Imprimer</a>
                </div>
            </div>
         </div>

              <div class="row">
                <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card">
                            <div style="background-color: #8b4513" class="box  text-center">
                                <h1 class="font-light text-white"><?php $data =$equipement->Total_secteur()->fetch();echo $data['nb'];?></h1>
                                <h6 class="text-white"><a href="<?=WEBROOT;?>secteur">Total Secteur<a/></h6>
                            </div>
                        </div>
                   </div>
                   <div class="col-md-6 col-lg-3 col-xlg-3"> 
                        <div class="card">
                            <div style="background-color: #8b4513" class="box  text-center">
                                <h1 class="font-light text-white"><?php $data =$equipement->Total_Base()->fetch();echo $data['nb'];?></h1>
                                 <h6 class="text-white"><a href="<?=WEBROOT;?>point_acces">Total point d'acces<a/></h6>
                            </div>
                        </div>
                     </div>
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
                        }?>

                        <?php
                        //$dashbordNombreEquipement = array();
                        
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
                        }?>
               </div>
               <!--*******************************************************************************************************************-->

               
            </div>

        </div>
    </div>





 <div class="col-lg-12 col-md-12 col-xl-12">
    <div class="card">
        <div class="card-body">
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
              <div style="background-color: #ef7f22" class="box text-center">
                <h1 class="font-light text-white"><?=$value->quantite?></h1>
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
    </div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>