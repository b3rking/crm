<?php
ob_start();
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xlg-3"> 
        <div class="card">
            <div class="card-header" style="background-color:#ef7f22;"> 
                <div class="title font-light text-white" style="text-align: center;"><h3 class="font-bold">Differente fiches</h3></div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs customtab2" role="tablist">
                    <?php
                    if ($d = $user->verifierPermissionDunePage('ficheinstallation',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#installation" role="tab" aria-selected="false"> <span class="hidden-xs-down"><h7 class="font-bold"style="color:#ef7f22;">Installation</h7></span></a> </li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('fichededemenagement',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Demenagement" role="tab" aria-selected="true"> <span class="hidden-xs-down"><h7 class="font-bold">Demenagement</h7></span></a> </li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('fichederecuperation',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Recuperation" role="tab" aria-selected="true"> <span class="hidden-xs-down"><h7 class="font-bold">Recuperation</h7></span></a> </li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('ficheintervention',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Intervention" role="tab" aria-selected="false"> <span class="hidden-xs-down"><h7 class="font-bold">Intervention</h7></span></a> </li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('ficheBP',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Bande-passante" role="tab" aria-selected="false"> <span class="hidden-xs-down"><h7 class="font-bold">Augmenter bande passante</h7></span></a></li>
                        <?php
                    }
                     if ($d = $user->verifierPermissionDunePage('ficheDiminutionBP',$_SESSION['ID_user'])->fetch()) 
                    {?>

                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#diminu_BP" role="tab" aria-selected="false"> <span class="hidden-xs-down"><h7 class="font-bold">Diminuer bande passante</h7></span></a></li>
                    <?php
                   }

                    if ($d = $user->verifierPermissionDunePage('fichedemission',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Fiche-de-mission" role="tab" aria-selected="false"><span class="hidden-xs-down"><h7 class="font-bold">Fiche de mission</h7></span></a></li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('fichedepanne',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= WEBROOT;?>generefichepanne"><h7 class="font-bold">Fiche de panne</h7></a>
                        </li>
                    <?php
                    }
                    ?>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show" id="installation" role="tabpanel">
                    <div class="p-20">
                        <?php
                            require_once('vue/admin/fiches/contenuFicheInstallation.php');
                        ?>
                    </div>
                </div>
                <div class="tab-pane p-20" id="Demenagement" role="tabpanel">
                    <?php
                        require_once('vue/admin/fiches/ficheDemenagement.php');
                    ?>
                </div>
                <div class="tab-pane p-20" id="Recuperation" role="tabpanel">
                    <?php
                        require_once('vue/admin/fiches/ficheRecuperation.php');?>
                </div>
                <div class="tab-pane p-20" id="Intervention" role="tabpanel">
                    <?php
                        require_once('vue/admin/fiches/ficheIntervention.php');?>
                </div>
                <div class="tab-pane p-20" id="Bande-passante" role="tabpanel">
                    <?php
                        require_once('vue/admin/fiches/ficheBandepassante.php');?>
                </div>
                    <div class="tab-pane p-20" id="diminu_BP" role="tabpanel">
                    <?php
                        require_once('vue/admin/fiches/fiche_diminuer_bande_passante.php');?>
                </div>
                <div class="tab-pane p-20" id="Fiche-de-mission" role="tabpanel">
                    <?php
                        require_once('vue/admin/fiches/ficheMission.php');?>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php
    $home_admin_content = ob_get_clean();
    require_once('vue/admin/home.admin.php');
    /*if ($_SESSION['role'] == 'commercial') 
    {
        $home_commercial_content = ob_get_clean();
        require_once('vue/admin/home.commercial.php');
    }
    elseif ($_SESSION['role'] == 'admin') 
    {
        $home_admin_content = ob_get_clean();
        require_once('vue/admin/home.admin.php');
    }*/
?>