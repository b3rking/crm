<?php 
    ob_start();
    require_once('model/User.class.php');
    require_once("model/client.class.php");
    require_once("model/localisation.class.php"); 
    require_once("model/comptabilite.class.php");
    require_once 'vue/reportGraphData.php';
    /*require_once 'vue/dashboard.php';
    require_once 'vue/dashboardComptabilite.php';
    require_once 'vue/adminDashboard.php';*/
     
    $user = new User();
    $client = new Client();
    $localisation = new Localisation();
    $comptabilite = new Comptabilite();
    $data = $client->totalClientParType();
    
    $tbMonnaie = ['USD','BIF'];
    $tbMonnaie = json_encode($tbMonnaie);
    $data_local = array();
    $query_local = $localisation->nombreClientParLocalisation();
    foreach ($query_local as $value) 
    {
        $data_local[] = array('label'  => $value->nom_localisation,'value'  => $value->nb);
    }
   
    $data_local = json_encode($data_local);
?>
<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar" style="height: 40px;background-color: #ef7f22";>
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <!--<a class="navbar-brand" href="#">
                <!- Logo icon -<b>
                    <!-You can put here icon as well // <i class="wi wi-sunset"></i> //-
                    <!- Dark Logo icon- 
                    <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                    <!- Light Logo icon-
                    <img src="assets/images/logo-light-icon.png" alt="homepage" class="light-logo" /> 
                </b>
                <!-End Logo icon -
                <!- Logo text -<span class="hidden-sm-down">
                 <!- dark Logo text -
                 <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                 <!- Light Logo text -    
                 <img src="assets/images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a>-->
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse" style="margin-top: -13px;">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-sm-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item">
                    <h3 class="text-white"><strong style="font-weight: bold;">Gestion de Relation  Client  <?=$_SESSION['nomSociete']?> </strong></h3>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <!--<a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="ti-email"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>-->
                    <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown">
                        <ul>
                            <li>
                                <div class="drop-title">Notifications</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Messages -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <!--<a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="icon-note"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>-->
                    <div class="dropdown-menu mailbox dropdown-menu-right animated bounceInDown" aria-labelledby="2">
                        <ul>
                            <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li>
                            <li>
                                <div class="message-center">
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="assets/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)">
                                        <div class="user-img"> <img src="assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center link" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Messages -->
                <!-- User Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown u-pro">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <?php
                            foreach ($user->image_user($_SESSION['ID_user']) as  $value) 
                            {?>
                                <img src="<?=WEBROOT?>image_profil/<?php echo $value->photo?>" alt="user" class="" heigth="50" width="50" />
                            <?php
                            }
                            ?>
                        <span class="hidden-md-down text-white" style="font-weight: bold;"><?= $_SESSION['userName']?> &nbsp;
                        <i class="fa fa-angle-down"></i></span> </a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <!-- text-->
                        <a href="<?=WEBROOT;?>monprofil-<?=$_SESSION['ID_user'];?>" class="dropdown-item"><i class="ti-user"></i> Mon Profile</a>
                        <!-- text-->
                       <!-- <a href="javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>-->
                        <!-- text--
                        <div class="dropdown-divider"></div>
                        -- text--
                        <a href="javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Parametre compte</a>
                         <div class="dropdown-divider"></div>
                        <!- text-->

                        <!--<a href="<=WEBROOT;?>Changer_motpasse" class="dropdown-item" ><i class="mdi mdi-lock-outline" ></i> Changer mot de passe</a>-->
                        
                    
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a href="<?=WEBROOT;?>deconnexion" class="dropdown-item"><i class="fa fa-power-off"></i> Deconnexion</a>
                        <!-- text-->
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End User Profile -->
                <!-- ============================================================== -->
                <li class="nav-item right-side-toggle"> 
                    <a class="nav-link  waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href=""><i class="ti-settings"></i></a>
                    <!--<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-settings"></i>
                    </button>-->
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <?php
                        foreach ($user->getPermissionDunUser($_SESSION['ID_user']) as $key => $value) 
                        {
                            if ($value->page == 'typeclient') 
                            {?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>typeClient">TYPE CLIENT</a>
                            <?php
                            }
                            elseif ($value->page == 'service') 
                            { ?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>service">SERVICES</a>
                            <?php
                            }
                            elseif ($value->page == 'vehicule') 
                            { ?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>vehicule">VEHICULE</a>
                            <?php
                            }
                            elseif ($value->page == 'localisation')  
                            { ?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>localisation">LOCALISATION</a>
                            <?php
                            }
                            elseif ($value->page == 'article') 
                            { ?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>article">ARTICLE</a>
                                
                               <a class="dropdown-item" href="<?= WEBROOT;?>verso">VERSO ARTICLE DU CONTRAT</a> 
                            <?php
                            }
                            elseif ($value->page == 'tauxdechange')  
                            { ?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>taux">TAUX</a>
                            <?php
                            }
                            elseif ($value->page == 'tva') 
                            {?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>tva"></a>
                            <?php
                            }
                            elseif ($value->page == 'type_extrat') 
                            {?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>type_extrat">TYPE EXTRAT</a>
                            <?php
                            }
                            elseif ($value->page == 'categorieDepense') 
                            {
                            ?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>categorieDepense">CATEGORIE DEPENSE</a> 
                            <?php
                            }
                            else if ($value->page == 'infoSociete') 
                            {
                            ?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>info">INFO D'ENTREPRISE</a>
                            <?php
                            } 
                            elseif ($value->page == 'utilisateur') 
                            {?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>utilisateur">UTILISATEUR</a> 
                            <?php
                            }
                            elseif ($value->page == 'historique') 
                            {?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>historiques">HISTORIQUE</a> 
                            <?php
                            }
                            /*elseif ($value->page == 'fourniseur') 
                            {?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>fourniseur">FOURNISSEUR</a> 
                            <?php
                            }*/
                            elseif ($value->page == 'monnaie') 
                            {?>
                                <a class="dropdown-item" href="<?= WEBROOT;?>monnaie">MONNAIE</a>
                            <?php
                            }
                        }
                            ?>
                </li>
            </ul>
        </div>


    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="user-pro"> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><img src="assets/images/users/1.jpg" alt="user-img" class="img-circle"><span class="hide-menu">Mark Jeckson</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
                        <li><a href="javascript:void(0)"><i class="ti-wallet"></i> My Balance</a></li>
                        <li><a href="javascript:void(0)"><i class="ti-email"></i> Inbox</a></li>
                        <li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-power-off"></i> Logout</a></li>
                    </ul>
                </li>
                <li class="nav-small-cap" >--- PERSONAL</li>

                <li>
                    <?php
                    //print_r($_SESSION['dashboardPage']) ;
                    if ($_SESSION['dashboardPage'] !='adminDashboard')
                    {
                        ?>
                        <a href="<?= WEBROOT.'dashboard-'.$_SESSION['dashboardPage'];?>"><span class="font-medium text-dark">Tableau de bord</span></a>
                        <?php
                    }
                    else
                    {
                    ?>
                        <li><a href="javascript:void(0)"><span class="font-medium text-dark">Tableau de bord</span></a>
                            <ul aria-expanded="false" class="collapse">
                            <?php
                            foreach ($user->getAll_dashoard() as $dash)
                            {
                            ?>
                                    <li><a href="<?= WEBROOT.'dashboard-'.$dash->page;?>"><span class="font-medium text-dark"><?=ucfirst($dash->page)?></span></a></li>
                    <?php
                            }
                    ?>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>

                </li>
                <?php
                if ($user->verifierPermissionDunePage('client',$_SESSION['ID_user'])->fetch()) 
                {?>
                    <li><a href="<?= WEBROOT;?>client"><span class="font-medium text-dark">Client</span></a></li>
                <?php
                }
                if ($user->verifierPermissionDunePage('contrat',$_SESSION['ID_user'])->fetch()) 
                { ?>
                    <li><a href="<?= WEBROOT;?>contract"><span class="font-medium text-dark">Contrat</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?=WEBROOT;?>fichier_client"><span class="font-medium text-dark">Fichier attaché</span></a></li>
                            <li><a href="<?=WEBROOT;?>customer_under_contract"><span class="font-medium text-dark">Client sous contract</span></a></li>
                        </ul>
                    </li>
              
                <?php
                }

                $secteur = $user->verifierPermissionDunePage('secteur',$_SESSION['ID_user'])->fetch();
                $base = $user->verifierPermissionDunePage('base',$_SESSION['ID_user'])->fetch();
                if ($secteur && $base) 
                {?>
                    <li><a href="<?= WEBROOT;?>technique"><span class="font-medium text-dark">Technique</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?=WEBROOT;?>secteur"><span class="font-medium text-dark">Secteur-relais</span></a></li>
                            <li><a href="<?= WEBROOT;?>point_acces"><span class="font-medium text-dark">Base-point d'acces</span></a></li>
                        </ul>
                    </li>
                <?php
                }
                elseif ($secteur && !$base) 
                {?>
                    <li><a href="<?= WEBROOT;?>technique"><span class="font-medium text-dark">Technique</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?=WEBROOT;?>secteur"><span class="font-medium text-dark">Secteur-relais</span></a></li>
                        </ul>
                    </li>
                <?php
                }
                elseif(!$secteur && $base)
                {
                ?>
                    <li><a href="<?= WEBROOT;?>technique"><span class="font-medium text-dark">Technique</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="<?= WEBROOT;?>point_acces"><span class="font-medium text-dark">Base-point d'acces</span></a></li>
                        </ul>
                    </li>
                <?php
                }
                
                $tb_marketing = array();
                if ($d = $user->verifierPermissionDunePage('prospection',$_SESSION['ID_user'])->fetch()) {$tb_marketing[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('sponsor',$_SESSION['ID_user'])->fetch()) {$tb_marketing[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('stockmarketing',$_SESSION['ID_user'])->fetch()) {$tb_marketing[] .= $d['page'];}
                if (!empty($tb_marketing)) 
                {
                ?>
                    <li>
                        <a href="<?= WEBROOT;?>marketing"><span class="font-medium text-dark">Marketing</span></a>
                        <ul aria-expanded="false" class="collapse">
                <?php
                    foreach ($tb_marketing as $value) 
                    {
                        if ($value == 'prospection') 
                        {?>
                            <li><a href="<?= WEBROOT;?>prospection"><span class="font-medium text-dark">Prospection</span></a></li>
                        <?php
                        }
                        elseif ($value == 'sponsor') 
                        {?>
                            <li><a href="<?= WEBROOT;?>sponsor"><span class="font-medium text-dark">Sponsor</span></a></li>
                        <?php
                        }
                        elseif ($value == 'stockmarketing') 
                        {?>
                            <li><a href="<?= WEBROOT;?>ajoutstock"><span class="font-medium text-dark">Stock marketing</span></a></li>
                        <?php
                        }
                    }
                    ?>
                    </ul>
                </li>
                <?php
                }

                $tb_facture = array();
                if ($d = $user->verifierPermissionDunePage('facture',$_SESSION['ID_user'])->fetch()) {$tb_facture[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('raportFacture',$_SESSION['ID_user'])->fetch()) {$tb_facture[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('balanceinitiale',$_SESSION['ID_user'])->fetch()) {$tb_facture[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('suspenssion',$_SESSION['ID_user'])->fetch()) {$tb_facture[] .= $d['page'];}
                if($d = $user->verifierPermissionDunePage('coupure',$_SESSION['ID_user'])->fetch()){$tb_facture[] .= $d['page'];}
                if($d = $user->verifierPermissionDunePage('factureproformat',$_SESSION['ID_user'])->fetch()){$tb_facture[] .= $d['page'];}
                if (!empty($tb_facture)) 
                {?>
                    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="font-medium text-dark">Factures</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <?php
                            foreach ($tb_facture as $value) 
                            {
                                if ($value == 'facture') 
                                {?>
                                    <li><a href="<?= WEBROOT?>facture_client"><span class="font-medium text-dark">Factures clients</span></a></li>
                                <?php
                                }
                                elseif ($value == 'raportFacture') 
                                {?>
                                    <li><a href="<?= WEBROOT?>raportFact"><span class="font-medium text-dark">Rapports</span></a></li>
                                <?php
                                }
                                elseif ($value == 'balanceinitiale') 
                                {?>
                                    <li><a href="<?= WEBROOT?>balance_initiale"><span class="font-medium text-dark">Balance initiale</span></a></li>
                                <?php
                                }
                                 elseif ($value == 'suspenssionA') 
                                {?>
                                    <!--li><a href="<?= WEBROOT?>new_customer"><span class="font-medium text-dark">Nouveau client par mois</span></a></li-->
                                <?php
                                }
                                /*elseif ($value == 'suspenssion') 
                                {?>
                                    <!--<li><a href="<= WEBROOT?>suspension"><span class="font-medium text-dark">Pause</span></a></li>-->
                                <?php
                                }*/
                                elseif ($value == 'coupure') 
                                {?>
                                    <li><a href="<?= WEBROOT?>coupure"><span class="font-medium text-dark">Coupure</span></a></li>
                                <?php
                                }
                                elseif ($value == 'factureproformat') 
                                {?>
                                    <li><a href="<?= WEBROOT?>proforma_facture"><span class="font-medium text-dark">Facture pro forma</span></a></li>
                                <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>
                <?php
                }
                
                $tb_finance = array();
                if ($d = $user->verifierPermissionDunePage('paiement',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('banque',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('versementbanque',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('caisse',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
if ($d = $user->verifierPermissionDunePage('approvisionnement',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
                /*if ($d = $user->verifierPermissionDunePage('compte',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('creance',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}*/
                if ($d = $user->verifierPermissionDunePage('depense',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
if ($d = $user->verifierPermissionDunePage('petitedepense',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('extra',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('prevision',$_SESSION['ID_user'])->fetch()) {$tb_finance[] .= $d['page'];}
                if (!empty($tb_finance)) 
                {
                ?>
                    <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu font-medium text-dark">Finance</span></a>
                        <ul aria-expanded="false" class="collapse">
                    <?php
                    foreach ($tb_finance as $value) 
                    {
                        if ($value == 'paiement') 
                        {?> 
                            <li><a href="<?= WEBROOT;?>paiement"><span class="font-medium text-dark">Paiement</span></a></li>
                        <?php
                        }
                        elseif ($value == 'banque') 
                        {?>
                            <li><a href="<?= WEBROOT;?>banque"><span class="font-medium text-dark">Banque</span></a></li>
                        <?php
                        }
                        elseif ($value == 'versementbanque') 
                        {?>
                            <li><a href="<?= WEBROOT;?>banque_de_versement"><span class="font-medium text-dark">Versement</span></a></li>
                        <?php
                        }
                        elseif ($value == 'caisse') 
                        {?>
                            <li><a href="<?= WEBROOT;?>caisse"><span class="font-medium text-dark">Caisse</span></a></li>
                        <?php
                        }
                        elseif ($value == 'approvisionnement') 
                        {?>
                            <li><a href="<?= WEBROOT;?>approvisionnement" ><span class="font-medium text-dark">Approvisionnement</span></a></li>
                        <?php
                        }
                        elseif ($value == 'compte') 
                        {?>
                             <li><a href="<?= WEBROOT;?>ajoutcompte"><span class="font-medium text-dark">Compte</span></a></li>
                        </li>
                        <?php
                        }
                        elseif ($value == 'creance') 
                        {?>
                            <li><a href="<?= WEBROOT;?>creance"><span class="font-medium text-dark">Creance</span></a></li>
                        <?php
                        }
                        elseif ($value == 'depense') 
                        {?>
                            <li><a href="<?= WEBROOT;?>depense_administrative"><span class="font-medium text-dark">Dépense administrative</span></a></li>
                        <?php
                        }
                        elseif ($value == 'petitedepense') 
                        {?>
                            <li><a href="<?= WEBROOT;?>petitedepense"><span class="font-medium text-dark">Depense</span></a></li>
                        <?php
                        }
                         elseif ($value == 'extra') 
                        {?>
                            <li><a href="<?= WEBROOT;?>extrat"><span class="font-medium text-dark">Extrat</span></a></li>
                        <?php 
                        }
                        elseif ($value == 'prevision') 
                        {?>
                            <li><a href="<?= WEBROOT;?>prevision"><span class="font-medium text-dark">Prevision</span></a></li>
                        <?php 
                        } 
                    }
                    ?>
                    </ul>
                </li>
                <?php
                }
                ?>

                 
                <?php
                if ($user->verifierPermissionDunePage('rapports',$_SESSION['ID_user'])->fetch()) 
                {?>
                    <!--li><a href="<?= WEBROOT;?>rapports">synthese</a></li-->
                <?php
                }
                if ($user->verifierPermissionDunePage('ticket',$_SESSION['ID_user'])->fetch()) 
                {?>
                    <li><a href="<?= WEBROOT;?>tickets"><span class="font-medium text-dark">Tickets</span></a></li>
                <?php
                }
                
                $tb_logistique = array();
                if ($d = $user->verifierPermissionDunePage('accessoire',$_SESSION['ID_user'])->fetch()) {$tb_logistique[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('antenne',$_SESSION['ID_user'])->fetch()) {$tb_logistique[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('routeur',$_SESSION['ID_user'])->fetch()) {$tb_logistique[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('switch',$_SESSION['ID_user'])->fetch()) {$tb_logistique[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('radio',$_SESSION['ID_user'])->fetch()) {$tb_logistique[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('sortieEquipement',$_SESSION['ID_user'])->fetch()) {$tb_logistique[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('carburant',$_SESSION['ID_user'])->fetch()) {$tb_logistique[] .= $d['page'];}
                if ($d = $user->verifierPermissionDunePage('recuperation',$_SESSION['ID_user'])->fetch()) {$tb_logistique[] .= $d['page'];}
                if (!empty($tb_logistique)) 
                {?>
                    <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="font-medium text-dark">Logistique</span></a>
                    <ul aria-expanded="false" class="collapse">
                <?php
                    foreach ($tb_logistique as $value) 
                    {
                        if ($value == 'accessoire') 
                        {?>
                            <li><a href="<?= WEBROOT;?>accessoire"><span class="font-medium text-dark">Accessoire</span></a></li>
                        <?php
                        }
                        elseif ($value == 'antenne') 
                        {?>
                            <li><a href="<?=WEBROOT;?>antenne"><span class="font-medium text-dark">Antenne</span></a></li>
                        <?php
                        }
                        elseif ($value == 'routeur') 
                        {?>
                            <li><a href="<?=WEBROOT;?>routeur"><span class="font-medium text-dark">Routeur</span></a></li>
                        <?php
                        }
                        elseif ($value == 'switch') 
                        {?>
                            <li><a href="<?=WEBROOT;?>switch"><span class="font-medium text-dark">Switch</span></a></li>
                        <?php
                        }
                        elseif ($value == 'radio') 
                        {?>
                            <li><a href="<?= WEBROOT;?>radio"><span class="font-medium text-dark">Radio</span></a></li>
                        <?php
                        }
                        elseif ($value == 'sortieEquipement') 
                        {?>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="font-medium text-dark">Sortie equipement</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= WEBROOT;?>sortie_accessoire"><span class="font-medium text-dark">Accessoires</span></a></li>
                                    <li><a href="<?= WEBROOT;?>sortie_equipement"><span class="font-medium text-dark">Equipement</span></a></li>
                                </ul>
                            </li>
                        <?php
                        }
                        elseif ($value == 'carburant') 
                        {?>
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="font-medium text-dark">Gestion carburant</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="<?= WEBROOT;?>ajout_carburant"><span class="font-medium text-dark">Ajout carburant</span></a></li>
                                    <li><a href="<?= WEBROOT;?>distribution_carburant"><span class="font-medium text-dark">Distribution carburant</span></a></li>
                                </ul>
                            </li>
                        <?php
                        }
                        elseif ($value == 'recuperation') 
                        {?>
                            <li><a href="<?= WEBROOT;?>equipement_recover"><span class="font-medium text-dark">Recuperation</span></a></li>
                        <?php
                        }
                    }
                    ?>
                    </ul>
                </li>
                <?php
                }
                ?>
                <!--<li><a href="<= WEBROOT;?>fiches">Fiches</a></li>-->
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu font-medium text-dark">Fiches</span></a>
                    <ul aria-expanded="false" class="collapse">
                    <?php
                    if ($d = $user->verifierPermissionDunePage('ficheinstallation',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li><a href="<?= WEBROOT;?>inc_ficheinstation"><span class="font-medium text-dark">Installation</span></a></li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('fichededemenagement',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li><a href="<?= WEBROOT;?>inc_fichedemenagement"><span class="font-medium text-dark">Demenagement</span></a></li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('fichederecuperation',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li><a href="<?= WEBROOT;?>inc_ficherecuperation"><span class="font-medium text-dark">Recuperation</span></a></li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('ficheintervention',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li><a href="<?= WEBROOT;?>inc_ficheintervention"><span class="font-medium text-dark">Intervention</span></a></li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('ficheBP',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li><a href="<?= WEBROOT;?>inc_ficheaugmentationbp"><span class="font-medium text-dark">Augmentation BP</span></a></li>
                    <?php
                    }
                     if ($d = $user->verifierPermissionDunePage('ficheDiminutionBP',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li><a href="<?= WEBROOT;?>inc_fichediminutionbp"><span class="font-medium text-dark">Diminution BP</span></a></li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('fichedemission',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li><a href="<?= WEBROOT;?>inc_fichedemission"><span class="font-medium text-dark">Fiche de mission</span></a></li>
                    <?php
                    }

                    if ($d = $user->verifierPermissionDunePage('fichedepanne',$_SESSION['ID_user'])->fetch()) 
                    {?>
                        <li><a href="<?= WEBROOT;?>generefichepanne"><span class="font-medium text-dark">Fiche de panne</span></a></li>
                    <?php
                    }
                    ?>
                    </ul>
                </li>
                <li><a href="<?= WEBROOT;?>agenda"><span class="hide-menu font-medium text-dark">Agenda</span></a></li>
                <!--<li> <li><a href="< WEBROOT>historique">Historique</a></li>
                <!- <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-pie-chart"></i><span class="hide-menu">Historique</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<historique">Voir l'historique</a></li>
                    </ul>--
                </li>-->
               <!-- <li> 
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Gestion Utilisateur</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="< WEBROOT;?>utilisateur">Utilisateur</a></li>
                    </ul>
                </li>-->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        
        <?php
        if (isset($home_admin_content)) 
        {
            echo $home_admin_content;
        }
        else
        {   

        }
        ?>
        <!--le 02/09/2020-->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<?php
 $vue_home_content = ob_get_clean();
 require_once('vue/index.php');
?>