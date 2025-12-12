<?php
ob_start();
if($_SESSION['profil_id'] == 832 || $_SESSION['profil_id'] == 833)
{
    $data =$marketing->nombreprospect()->fetch();
    $prospect_by_status = $marketing->groupementProsect_par_etat();
}
else
{
    $data = $marketing->nombreprospectByUser($_SESSION['ID_user'])->fetch();
    $prospect_by_status = $marketing->groupementProspect_par_etat_by_user($_SESSION['ID_user']);
}
?>
<div class="card">
    <div class="card-header text-white bg-primary" >&nbsp;&nbsp;&nbsp;
         Tableau de bord de marketing
    </div>
    <div class="card-body">
        
        <div class="row">
            <?php
            $nbprospect = 0;
            if ($data = $marketing->nombreprospect()->fetch()) 
            {
                $nbprospect = $data['nb'];
            ?>
            <?php
            }
           ?>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><?= $data['nb'];?></h1>
                        <h6 class="text-white">Total prospect</h6>
                    </div>
                </div>
            </div>
            <?php
            $dashbordNombreprospect = array();
            $couleurDashboard = ['bg-primary','bg-info','bg-warning'];
            $i =0;
            foreach ($prospect_by_status as $value) 
            {
              $dashbordNombreprospect[] = $value;
            ?>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box <?= $couleurDashboard[$i] ?> text-center">
                      <h1 class="font-light text-white"><?= $value->nb?></h1>
                      <h6 class="text-white">Prospect   <?=$value->etatduProspect?></h6>
                    </div>
                </div>
            </div>
            <?php
            $i++;
            }
            $_SESSION['dashbordNombreprospect'] = $dashbordNombreprospect;
           ?>          
        </div>
    </div>
</div>

<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>