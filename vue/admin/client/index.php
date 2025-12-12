<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width --> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>CRM ajywa</title>
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <link href="assets/node_modules/morrisjs/morris.css" rel="stylesheet">
    <!--Toaster Popup message CSS -->
    <!--<link href="assets/node_modules/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/node_modules/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="assets/node_modules/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">-->
    <link href="assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="dist/css/pages/dashboard1.css" rel="stylesheet">
    <link href="dist/css/pages/login-register-lock.css" rel="stylesheet">
    <link href="assets/node_modules/calendar/dist/fullcalendar.css" rel="stylesheet"/>
    <!--alerts CSS -->
    <link href="assets/node_modules/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <link rel="stylesheet" href="dist/css/styles.css">
</head>

<body class="horizontal-nav boxed skin-blue fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">crm spidernet</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <input type="text" id="action" value="<?=$_SESSION['action']?>" hidden>
        <input type="text" id="dashboard" value="<?=$_SESSION['dashboardPage']?>" hidden="">
        <input type="text" id="idUser" value="<?=$_SESSION['ID_user']?>" hidden>
    <?php
    if (isset($vue_home_content)) 
    {
        echo  $vue_home_content;
    }
    else
    {

    }
    ?>
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
            &copy; 2020 crm.spidernet
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->

    <script type="text/javascript">
        var p = 0;
        function addPhoneNumber()
        {
            p++;// nombre de champs de telephone
            if (p < 4) 
            {
                document.getElementById("divAddPhone").innerHTML += '<div class="form-group row" id="element'+p+'"><label for="exampleInputuname3" class="col-sm-3 control-label"></label><div class="col-sm-6"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-phone-classic"></i></span></div><input type="text" data-mask="+257 99 99 99 999" class="form-control" id="phone'+p+'"></div></div><div class="col-sm-3"><button type="button"style="background-color: #8b4513" class="btn font-light text-white" onclick="removePhoneNumber()"><i class="mdi mdi-phone-classic"></i><i class="ti-minus text"></i></button></div></div>';
                document.getElementById('nbphone').value = p;
            }
            else p--;
        }
        function removePhoneNumber()
        {
            var number = $('#nbphone').val();
            var divAddPhone = document.getElementById('divAddPhone');
            divAddPhone.removeChild(divAddPhone.childNodes[number-1]);
            number--;
            p--;
            document.getElementById('nbphone').value = number;
        }
        var m = 0;// nombre de champs mail
        function addMailAdress()
        {
            m++;
            if (m < 4) 
            {
                document.getElementById("divAddMail").innerHTML += '<div class="form-group row" id="elementEmail'+m+'"><div class="col-sm-9"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="ti-email"></i></span></div><input type="mail" class="form-control" id="email'+m+'" placeholder="@ email"></div></div><div class="col-sm-3"><button type="button" style="background-color: chocolate" class="btn font-light text-white" onclick="removeEmail()"><i class="ti-email"></i><i class="ti-minus text"></i></button></div></div>';
                document.getElementById('nbemail').value = m;
            }
            else m--;
        }
        function removeEmail()
        {
            var number = $('#nbemail').val();
            var divAddMail = document.getElementById('divAddMail');
            divAddMail.removeChild(divAddMail.childNodes[number-1]);
            number--;
            m--;
            document.getElementById('nbemail').value = number;
        }
        var n = 0;
        function ajoutServiceToProformat()
        {
            n++;
            //Conteneur.removeChild(Conteneur.childNodes[i]);
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    document.getElementById("service_contener").innerHTML += this.responseText;
                    document.getElementById('nbservice').value = n+1;
                }
            };
            xhttp.open("GET","ajax/autocomplete/includeServiceOnCreerfacture_proformat.php?n="+n,true);
            xhttp.send();
        }
        function supService()
        {
            var nbservice = $('#nbservice').val();
            var service_contener = document.getElementById('service_contener');
            service_contener.removeChild(service_contener.childNodes[nbservice-2]);
            n--;
            document.getElementById('nbservice').value = n;
        }


    </script>

    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap popper Core JavaScript -->
    <script src="assets/node_modules/popper/popper.min.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="assets/node_modules/raphael/raphael-min.js"></script>
    <script src="assets/node_modules/morrisjs/morris.js"></script>
    <!--<script src="assets/node_modules/chartist-js/dist/chartist.min.js"></script>
    <script src="assets/node_modules/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="assets/node_modules/chartist-js/dist/chartist-init.js"></script>-->

    <script src="assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>

    <!-- This is data table -->
    <script src="assets/node_modules/datatables/jquery.dataTables.min.js"></script>
    <!-- Popup message jquery -->
    <!--<script src="assets/node_modules/toast-master/js/jquery.toast.js"></script>-->
    <!-- Chart JS -->
    <script src="dist/js/dashboard1.js"></script>
    <script src="dist/js/pages/mask.js"></script>
    <!-- Calendar JavaScript -->
    <script src="assets/node_modules/calendar/jquery-ui.min.js"></script>
    <script src="assets/node_modules/moment/moment.js"></script>
    <script src='assets/node_modules/calendar/dist/fullcalendar.min.js'></script>
    <script src="assets/node_modules/calendar/dist/cal-init.js"></script>
    <!-- Sweet Alert-->
    <script src="assets/node_modules/sweetalert/sweetalert.min.js"></script>
    <!-- Popup message jquery -->
    <script src="assets/node_modules/toast-master/js/jquery.toast.js"></script>

    <!--inclusion des fichier javascript-->
    
    <script src="assets/javascript/client/client.javascript.js"></script>
    <script src="assets/javascript/equipement/equipement.js"></script>
    <script src="assets/javascript/typeclient/typeclient.js"></script>
    <script src="assets/javascript/service/service.js"></script>
    <script src="assets/javascript/contract/contract.javascript.js"></script>
    <script src="assets/javascript/tickets/ticket.javascript.js"></script>
    <script src="assets/javascript/parametre/parametre.js"></script>
    <script src="assets/javascript/vehicule/vehicule.js"></script>
    <script src="assets/javascript/article/article.js"></script>
    <script src="assets/javascript/utilisateur/utilisateur.js"></script>
    <script src="assets/javascript/fiches/fiches.js"></script>
    <script src="assets/javascript/localisation/localisation.js"></script>
    <script src="assets/javascript/autocomplate/autocomplete.js"></script>
    <script src="assets/javascript/facture/facture.js"></script>
    <script src="assets/javascript/marketing/marketing.javascript.js"></script>
    <script src="assets/javascript/comptabilite/comptabilite.javascript.js"></script>
    <script src="assets/javascript/historique/historique.js"></script>
    <script src="assets/javascript/Datatables/dataTable.Inc.js"></script> 
    <!--<script src="javascript/dashboard/adminDashboard.js">
    </script>
    <script src="javascript/dashboard/raportGraph.js">
    </script>-->
    
    <script>
        var cType = <?php echo $data; ?>;
        var cLocal = <?php echo $data_local; ?>;
        var cActif = <?php echo $dataClActif; ?>;
        var montant_recu_graph = [<?=$montant_recu_graph?>];
        var depense_mensuel = [<?=$depense_mensuel_graph?>];
        var situation_mensuel_tresorerie_graph = [<?= $situation_mensuel_tresorerie_graph?>];
        
        var url = document.getElementById('action');
        var action = url.value;
        var dashboard = $('#dashboard').val();

        $(document).ready(function() {
            if (action == 'dashboard') 
            {
                if (dashboard!='') 
                {
                    var scriptElement = document.createElement('script');
                    scriptElement.src = 'assets/javascript/dashboard/'+dashboard+'.js';
                    document.body.appendChild(scriptElement);
                }
            }
        })

    $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

        /***********************
        // Verification Echeance
        ************************/

        $(function(){
           /* var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("save").innerHTML = this.responseText;
                    //$('#eChe').val(1);
                    //document.getElementById("eChe").value = 1;
                    //alert(this.responseText);
                }
            };
            xhttp.open("GET","ajax/facture/verifierEcheance.php?",true);
            xhttp.send();*/
        });

        // GENERATION DES FACTURES AUTOMATIQUE

        /*$(function()
        {
               var j = new Date();
             //var jour = j.getDate();
             //var lejourdumois = j.getDate();
        if (j.getDate() == 15) 
        {
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
                {
                    if (this.readyState == 4) 
                    {
                        //document.getElementById("save").innerHTML = this.responseText;
                        var rep = String(this.responseText).trim();
                        alert(rep);
                    }
                };
            xhttp.open("GET","ajax/facture/genererFactureAuto.php?",true);
            xhttp.send();
        }
    });*/

    /********************* 
    ** COUPURE AUTOMATIQUE
    **********************/
    /*$(function()
    {
        var idUser = document.getElementById('idUser').value;
        //var j = new Date();
         //var jour = j.getDate();
         //var lejourdumois = j.getDate();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4)  
            {
                //document.getElementById("save").innerHTML = this.responseText;
                var rep = String(this.responseText).trim();
                //alert(rep);
            }
        };
        xhttp.open("GET","ajax/facture/saveCoupureAutomatique.php?idUser="+idUser,true);
        xhttp.send();
    });*/
    </script>
</body>

</html>