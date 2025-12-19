//
//
//
// START OF THE OBR INTEGRATION JS CODE.
//
//
//

// TEST server credentials

// const BASEURL = "https://ebms.obr.gov.bi:9443/ebms_api/";
// const USERNAME = "ws400000040800377";
// const PASSWORD = "q4[@2bTA";
// const COMPANY_NIF = "4000000408";

// Production Server

// const BASEURL = "https://ebms.obr.gov.bi:8443/ebms_api/ssddee";
const BASEURL = "https://ebms.obr.gov.bi:8443/ebms_api";
const USERNAME = "wsl400000040800000";
const PASSWORD = "oQuze84(";
const COMPANY_NIF = "4000000408";

async function fetch_api(url = "", body) {
    const token = await token_store();

    const res = await fetch(`${BASEURL}/${url}`, {
        method: "POST",
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        },
        body: JSON.stringify(body),
    });

    const data = await res.json();

    return data;
}

// calling the authentication endpoint to get the auth token
async function token_store() {
    async function login() {
        const body = {
            username: USERNAME,
            password: PASSWORD,
        };

        const res = await fetch(`${BASEURL}/login`, {
            method: "POST",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            body: JSON.stringify(body),
        });

        const data = await res.json();
        return data.result.token;
    }

    // check if the token is stored locally
    let token = localStorage.getItem("obr_token");

    // if it's there check if it's still valid
    if (token) {
        const body = { tp_TIN: "4000000408" };
        const res = await fetch(`${BASEURL}/checkTIN`, {
            method: "POST",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify(body),
        });

        if (res.status === 403) {
            token = await login();
            localStorage.setItem("obr_token", token);
        }
    } else {
        token = await login();
        localStorage.setItem("obr_token", token);
    }

    // return the token
    return token;
}

function addInvoice(invoice_body) {
    console.log(invoice_body);

    fetch_api("addInvoice_confirm", invoice_body)
        .then((response) => {
            // all the stuff to do after getting the signature from obr
            if (response.success) {
                // Remove the corresponding invoice from local storage using invoice_number
                const invoices =
                    JSON.parse(localStorage.getItem("invoices")) || [];
                console.log("Invoices before removal:", invoices);
                console.log(
                    "Removing invoice with invoice_number:",
                    invoice_body.invoice_number
                );

                const updatedInvoices = invoices.filter(
                    (invoice) =>
                        invoice.invoice_number !== invoice_body.invoice_number
                ); // Use invoice_number for filtering
                console.log("Invoices after removal:", updatedInvoices);

                localStorage.setItem(
                    "invoices",
                    JSON.stringify(updatedInvoices)
                );

                fetch(
                    `ajax/facture/updateAfterObrSignature.php?facture_id=${response["result"]["invoice_number"]}&invoice_signature=${response["electronic_signature"]}&identifier=${invoice_body["invoice_identifier"]}&date=${response["result"]["invoice_registered_date"]}`,
                    {
                        method: "GET",
                        headers: {
                            Accept: "application/json",
                            "Content-Type": "application/json",
                        },
                    }
                )
                    .then((res) => res.json())
                    .then((res) => console.log(res))
                    .catch((err) => console.log(err));

                alert(`${response.msg}`);
            } else {
                // Check for specific error conditions
                if (
                    response.status === 409 ||
                    response.msg ===
                        "Une facture avec le même numéro existe déjà."
                ) {
                    // Remove the corresponding invoice from local storage using invoice_number
                    const invoices =
                        JSON.parse(localStorage.getItem("invoices")) || [];
                    console.log("Invoices before removal on error:", invoices);
                    console.log(
                        "Removing invoice with invoice_number on error:",
                        invoice_body.invoice_number
                    );

                    const updatedInvoices = invoices.filter(
                        (invoice) =>
                            invoice.invoice_number !==
                            invoice_body.invoice_number
                    ); // Use invoice_number for filtering
                    console.log(
                        "Invoices after removal on error:",
                        updatedInvoices
                    );

                    localStorage.setItem(
                        "invoices",
                        JSON.stringify(updatedInvoices)
                    );
                }
                alert(`${response.msg}`);
            }
        })
        .catch((err) => alert(err));
}

// Function to resend invoices from local storage
function resendInvoices() {
    const invoices = JSON.parse(localStorage.getItem("invoices")) || [];
    if (invoices.length > 0) {
        invoices.forEach((invoice) => {
            addInvoice(invoice); // Resend each invoice
        });
    }
}

// Set an interval to resend invoices every 5 minutes while on the page
setInterval(resendInvoices, 5 * 60 * 1000); // 5 minutes in milliseconds

function getInvoice() {
    const check_invoice = {
        invoice_identifier:
            "4000000408/ws400000040800079/20211206073022/0002/2021",
    };

    fetch_api("getInvoice", check_invoice).then((res) => console.log(res));
}

function checkTin() {
    const nif_body = {
        tp_TIN: "4000000408",
    };
    fetch_api("checkTIN", nif_body).then((res) => console.log(res));
}

function cancelInvoice(facture_id) {
    const annul_facture = {
        invoice_identifier: facture_id,
        cn_motif: "Marchandise non conforme à la commande",
    };

    fetch_api("cancelInvoice", annul_facture).then((res) =>
        // if the response is okay, then save it to the db
        // alert(res.msg)
        console.log(res)
    );
}

//
//
//
// END OF OBR INTEGRATION JS CODE.
//
//
//

/*function showhide_reduction_facture(element)
{
    var val = element.value;
    if (element.checked) 
    {
        $('#divReduction'+val).show();
    }
    else
    {
        $('#divReduction'+val).hide();
    }
}*/
function creefacture(datefacture, monnaie, mois, annee, tva, customer) {
    //alert(datefacture+' '+monnaie+' '+mois+' '+annee+' '+tva+' '+billing_number+' '+client_parent+' '+next_billing_date);
    billing_date =
        mois < 10 ? annee + "-0" + mois + "-01" : annee + "-" + mois + "-01";

    var nombreService = parseInt($("#nbservice").val());
    var show_rate = 0;
    var enable_discount = 0;
    //var reduction = 0;
    var startDate = "null";
    //var endDate = "null";
    var facture_services = "";
    //var client_parent = client_parent.split(/-/)[1];
    if (customer == "" || datefacture == "" || monnaie == "" || annee == "") {
        swal({
            title: "",
            text: "Veuillez renseigner tous les champs en *",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    } else {
        var customer = customer.split(/_/);
        var client_parent = customer[0];
        var idcontract = customer[1];
        var billing_number = customer[2];
        var next_billing_date = customer[3];
        var fixe_rate = 0;
        var taux = 1;
        var exchange_currency = "USD";
        var test_billing_cycle = 0;
        if (document.getElementById("afficheTaux").checked == true)
            show_rate = 1;
        if (document.getElementById("fixe_rate").checked == true) {
            fixe_rate = 1;
            taux = $("#taux").val();
            exchange_currency = $("#exchange_currency").val();
        }
        if (document.getElementById("enable_discount").checked == true)
            enable_discount = 1;
        //if (reduction == '')
        //reduction = 0;
        var y = 0;
        for (var i = 0; i < nombreService; i++) {
            y++;
            var serviceId = $("#service" + i)
                .val()
                .split(/-/)[0];
            var serviceName = $("#service" + i)
                .val()
                .split(/-/)[1];
            var bandeP =
                $("#bandeP" + i).val() == "" ? "null" : $("#bandeP" + i).val();
            var montant = $("#montantt" + i)
                .val()
                .replace(",", ".");
            var quantite = $("#quantite" + i).val();
            var reduction = $("#rediction" + i).val();
            var description =
                $("#description" + i).val() == ""
                    ? "null"
                    : $("#description" + i).val();
            var billing_cycle = $("#billing_cycle" + i).val();
            //condition1 = (condition1 == '' ? '' : 'AND' +condition1);
            if (serviceId == "" || montant == "" || quantite == "") {
                swal({
                    title: "",
                    text: "Veuillez renseigner les champs en *",
                    type: "error",
                    timer: 3000,
                    showConfirmButton: false,
                });
                break;
            }

            //alert('y = '+y+' quantite = '+quantite+' i = '+i+' sous_client : '+sous_client);
            if (billing_cycle == "0") {
                startDate = $("#startDate" + i).val();
                //endDate = $('#endDate'+i).val();
            }
            if (billing_cycle == 1) {
                test_billing_cycle = 1;

                if (enable_discount == 1) {
                    if (reduction == "") {
                        reduction = 0;
                        if (quantite == 3) reduction = 5;
                        else if (quantite == 6) reduction = 10;
                        else if (quantite == 12) reduction = 15;
                    }
                } else reduction = 0;
            }

            facture_services +=
                serviceId +
                "_" +
                serviceName +
                "_" +
                bandeP +
                "_" +
                montant +
                "_" +
                quantite +
                "_" +
                startDate +
                "_" +
                encodeURIComponent(description) +
                "_" +
                billing_cycle +
                "_" +
                reduction +
                "=";
            //alert("datefacture="+datefacture+"&monnaie="+monnaie+"&mois="+mois+"&annee="+annee+
            //"&tva="+tva+"&serviceId="+serviceId+"&serviceName="+serviceName+"&montant="+montant+
            //"&quantite="+quantite+"&reduction="+reduction+"&client_parent="+client_parent+
            //"&description="+description+"&billing_cycle="+billing_cycle+"&billing_number="+billing_number+
            //"&i="+i+"&nombreService="+nombreService+"&taux="+taux+"&show_rate="+show_rate+"&startDate="+startDate+"&endDate="+endDate);
        }
        if (facture_services == "") {
            swal({
                title: "",
                text: "Les informations sont pas correctes",
                type: "error",
                timer: 3000,
                showConfirmButton: false,
            });
        } else {
            /*if (next_billing_date != '' && billing_date < next_billing_date && test_billing_cycle == 1) 
            {
                swal({
                    title :"",
                    text :"le mois choisi ne corespond pas au next_billing_date",
                    type :"error",
                    timer :2000,
                    showConfirmButton:false
                });
            }*/
            //else
            //{
            var WEBROOT = $("#WEBROOT").val();
            var iduser = $("#iduser").val();
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4) {
                    var rep = String(this.responseText).trim();

                    //document.getElementById('rep').innerHTML = this.responseText;
                    //if (y == nombreService)
                    //{
                    if (rep == "") {
                        document.location.reload();
                        swal({
                            title: "",
                            text: "",
                            type: "success",
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    } else {
                        swal({
                            title: "",
                            text: this.responseText,
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    }
                    //}
                } else
                    swal({
                        title: "",
                        text: "traitement en cours",
                        showConfirmButton: false,
                    });
            };
            xhttp.open(
                "GET",
                "ajax/facture/creefacture.php?datefacture=" +
                    datefacture +
                    "&monnaie=" +
                    monnaie +
                    "&exchange_currency=" +
                    exchange_currency +
                    "&mois=" +
                    mois +
                    "&annee=" +
                    annee +
                    "&tva=" +
                    tva +
                    "&client_parent=" +
                    client_parent +
                    "&billing_number=" +
                    billing_number +
                    "&facture_services=" +
                    facture_services +
                    "&i=" +
                    i +
                    "&nombreService=" +
                    nombreService +
                    "&taux=" +
                    taux +
                    "&show_rate=" +
                    show_rate +
                    "&enable_discount=" +
                    enable_discount +
                    "&fixe_rate=" +
                    fixe_rate +
                    "&WEBROOT=" +
                    WEBROOT +
                    "&iduser=" +
                    iduser +
                    "&next_billing_date=" +
                    next_billing_date +
                    "&idcontract=" +
                    idcontract +
                    "&test_billing_cycle=" +
                    test_billing_cycle,
                true
            );
            xhttp.send();
            //}
        }
    }
}
function showHideFixedRateDiv(element) {
    var val = element.value;
    if (element.checked) {
        $("#divTaux" + val).show();
        $("#divMonnaie" + val).show();
    } else {
        $("#divTaux" + val).hide();
        $("#divMonnaie" + val).hide();
    }
}
function creerProformat(datefacture, monnaie, mois, annee, tva) {
    //alert(datefacture+' monnaie: '+monnaie+' mois: '+mois+' annee: '+annee+' tva: '+tva+' reduction: '+reduction);

    var nombreService = parseInt($("#nbservice").val());
    var nomclient = "";
    var phone = "";
    var mailclient = "";
    var adresse = "";
    var localisation = "";
    var old_client = "";
    var show_rate = 0;
    var enable_discount = 0;
    var startDate = "null";
    var endDate = "null";
    var reduction = 0;
    var facture_services = "";
    var erreur = "";
    if (datefacture == "" || monnaie == "" || annee == "") {
        swal({
            title: "",
            text: "Veuillez renseigner tous les champs en *",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    } else {
        var fixe_rate = 0;
        var taux = 1;
        var exchange_currency = "USD";
        if (document.getElementById("afficheTaux").checked == true)
            show_rate = 1;
        if (document.getElementById("fixe_rate").checked == true) {
            fixe_rate = 1;
            taux = $("#taux").val();
            exchange_currency = $("#exchange_currency").val();
        }
        if (document.getElementById("enable_discount").checked == true) {
            enable_discount = 1;
        }

        if (document.getElementById("client_contracte").checked == true) {
            nomclient = $("#newclient").val();
            phone = $("#phone").val();
            mailclient = "";
            adresse = $("#adresse_client").val();
            localisation = $("#localisation").val();
            if ($("#mailclient").val() != "") {
                if (validateEmail($("#mailclient").val()))
                    mailclient = $("#mailclient").val();
                else erreur += "L'adresse email n'est pas valide";
            }
            //if (!validateEmail(mailclient))
            //  erreur += 'L\'adresse email n\'est pas valide';
        } else {
            old_client = $("#idclient_facture_proformat").val().split(/-/)[1];
        }
        var y = 0;
        for (var i = 0; i < nombreService; i++) {
            y++;
            var serviceId = $("#service" + i)
                .val()
                .split(/-/)[0];
            var serviceName = $("#service" + i)
                .val()
                .split(/-/)[1];
            var bandeP =
                $("#bandeP" + i).val() == "" ? "null" : $("#bandeP" + i).val();
            var montant = $("#montant" + i)
                .val()
                .replace(",", ".");
            var quantite = $("#quantite" + i).val();
            var description =
                $("#description" + i).val() == ""
                    ? "null"
                    : $("#description" + i).val();
            var billing_cycle = $("#billing_cycle" + i).val();
            if (enable_discount == 1 && billing_cycle == 1) {
                if (quantite >= 3 && quantite <= 5) reduction = 5;
                else if (quantite >= 6 && quantite <= 11) reduction = 10;
                else if (quantite >= 12) reduction = 15;
            }

            //condition1 = (condition1 == '' ? '' : 'AND' +condition1);

            if (serviceId == "" || montant == "" || quantite == "") {
                erreur += "Veuillez renseigner les champs en *";
                break;
            }
            //alert('y = '+y+' quantite = '+quantite+' i = '+i+' sous_client : '+sous_client);
            if (billing_cycle == "0") {
                startDate = $("#startDate" + i).val();
                //                endDate = $('#endDate'+i).val();
            }
            facture_services +=
                serviceId +
                "_" +
                serviceName +
                "_" +
                bandeP +
                "_" +
                montant +
                "_" +
                quantite +
                "_" +
                startDate +
                "_" +
                endDate +
                "_" +
                encodeURIComponent(description) +
                "_" +
                billing_cycle +
                "_" +
                reduction +
                "=";
            //alert(facture_services);
        }
        if (facture_services == "") {
            erreur += "Les informations sont pas correctes";
        }
        if (erreur != "") {
            swal({
                title: "",
                text: erreur,
                type: "error",
                timer: 3000,
                showConfirmButton: false,
            });
        } else {
            var iduser = $("#iduser").val();
            //alert(facture_services);
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4) {
                    var rep = String(this.responseText).trim();
                    if (rep == "") {
                        document.location.reload();
                        swal({
                            title: "",
                            text: "",
                            type: "success",
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    } else
                        swal({
                            title: "",
                            text: "Une erreur s'est produite!",
                            type: "error",
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    document.getElementById("rep").innerHTML =
                        this.responseText;
                } else
                    swal({
                        title: "",
                        text: "traitement en cours",
                        showConfirmButton: false,
                    });
            };
            xhttp.open(
                "GET",
                "ajax/facture/creerProformat.php?datefacture=" +
                    datefacture +
                    "&facture_services=" +
                    facture_services +
                    "&reduction=" +
                    reduction +
                    "&monnaie=" +
                    monnaie +
                    "&mois=" +
                    mois +
                    "&annee=" +
                    annee +
                    "&tva=" +
                    tva +
                    "&i=" +
                    i +
                    "&nombreService=" +
                    nombreService +
                    "&taux=" +
                    taux +
                    "&exchange_currency=" +
                    exchange_currency +
                    "&fixe_rate=" +
                    fixe_rate +
                    "&show_rate=" +
                    show_rate +
                    "&old_client=" +
                    old_client +
                    "&nomclient=" +
                    encodeURIComponent(nomclient) +
                    "&phone=" +
                    phone +
                    "&mailclient=" +
                    mailclient +
                    "&adresse=" +
                    encodeURIComponent(adresse) +
                    "&localisation=" +
                    localisation +
                    "&enable_discount=" +
                    enable_discount +
                    "&iduser=" +
                    iduser,
                true
            );
            xhttp.send();
        }
    }
}
function updateProformat(
    type_client,
    facture_id,
    datefacture,
    monnaie,
    mois,
    annee,
    tva,
    i,
    id_dernierService
) {
    //alert('type_client: '+type_client+' facture_id: '+facture_id+' datefacture: '+datefacture+' monnaie: '+monnaie+' mois: '+mois+' annee: '+annee+' tva: '+tva+' i: '+i+' id_dernierService: '+id_dernierService);
    //var WEBROOT = $('#WEBROOT').val();
    //var idclient = idclient.split(/-/)[1];
    var startDate = "null";
    var endDate = "null";
    var enable_discount = 0;
    var reduction = 0;
    var facture_services = "";

    var idclient;
    var nomclient = "";
    var adresse = "";
    var telephone = "";
    var mail = "";
    var localisation = "";
    var erreur = "";
    if (datefacture == "" || annee == "") {
        swal({
            title: "",
            text: "Veuillez renseigner tous les champs en *",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    } else {
        var fixe_rate = 0;
        var show_rate = 0;
        var taux = 1;
        var exchange_currency = "USD";
        if (document.getElementById("afficheTaux" + i).checked == true)
            show_rate = 1;
        if (document.getElementById("enable_discount" + i).checked == true)
            enable_discount = 1;
        if (document.getElementById("fixe_rate" + i).checked == true) {
            fixe_rate = 1;
            taux = $("#taux" + i).val();
            exchange_currency = $("#exchange_currency" + i).val();
        }
        var iduser = $("#iduser").val();

        idclient = $("#idclient" + i).val();
        nomclient = $("#nomclient" + i).val();
        adresse = $("#adresse_client" + i).val();
        telephone = $("#phone" + i).val();
        mail = $("#mailclient" + i).val();
        /*if (mail != '') 
        {
            if(!validateEmail(mail))
                erreur = "l'adresse mail n'est pas valide";
        }*/
        //if (mail != "" && !validateEmail(mail))
        //erreur = "l'adresse mail n'est pas valide";
        localisation = $("#localisation" + i).val();

        var nombreService = $("#nombreServiceUpdate" + i).val();
        //var y = id_dernierService - nombreService;
        for (var j = 0; j < nombreService; j++) {
            y = j + 1;
            var service = $("#service" + facture_id + y)
                .val()
                .split(/-/);
            var serviceId = service[0];
            var serviceName = service[1];
            var idFs = $("#idFs" + facture_id + y).val();
            var montant = $("#montant" + facture_id + y)
                .val()
                .replace(",", ".");
            var quantite = parseInt($("#quantite" + facture_id + y).val());
            //var reduction = $('#reduction'+y).val();
            //var sous_client = $('#sous_client'+y).val();
            var bandeP =
                $("#bandeP" + facture_id + y).val() == ""
                    ? "null"
                    : $("#bandeP" + facture_id + y).val();
            var description =
                $("#description" + facture_id + y)
                    .val()
                    .trim() == ""
                    ? "null"
                    : $("#description" + facture_id + y)
                          .val()
                          .trim()
                          .replace("&", "et");
            var billing_cycle = $("#Billing_cycle" + facture_id + y).val();
            if (billing_cycle == 0) {
                startDate = $("#startDate" + facture_id + y).val();
                endDate = $("#endDate" + facture_id + y).val();
            }
            if (enable_discount == 1 && billing_cycle == 1) {
                /*if (quantite == 3)
                    reduction = 5;
                else if (quantite == 6) 
                    reduction = 10;
                else if (quantite == 12) 
                    reduction = 20;*/
                if (quantite >= 3 && quantite <= 5) reduction = 5;
                else if (quantite >= 6 && quantite <= 11) reduction = 10;
                else if (quantite >= 12) reduction = 15;
            }
            facture_services +=
                serviceId +
                "_" +
                idFs +
                "_" +
                montant +
                "_" +
                quantite +
                "_" +
                bandeP +
                "_" +
                encodeURIComponent(description) +
                "_" +
                billing_cycle +
                "_" +
                startDate +
                "_" +
                endDate +
                "_" +
                serviceName +
                "=";
            //alert(facture_services);
            //alert('idclient: '+idclient+' facture_id: '+facture_id+' idFs: '+idFs+' datefacture: '+datefacture+' monnaie: '+monnaie+' mois: '+mois+' annee: '+annee+' tva: '+tva+' service: '+service+' montant: '+montant+' monnaiservice: '+monnaieService+' quantite: '+quantite+' rediction: '+rediction+' bandeP: '+bandeP+' description: '+description+' billing_cycle: '+billing_cycle+' startDate: '+startDate+' endDate: '+endDate);
        }

        if (facture_services == "") {
            erreur = "Veuillez verifier les donnees du service";
        }
        if (erreur != "") {
            swal({
                title: "",
                text: erreur,
                type: "error",
                timer: 3000,
                showConfirmButton: false,
            });
        } else {
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4) {
                    //document.getElementById('rep').innerHTML = this.responseText;
                    var rep = String(this.responseText).trim();
                    //$('#myTable').DataTable().destroy();
                    //document.getElementById('rep').innerHTML = this.responseText;
                    //$('#myTable').DataTable();
                    if (rep == "") {
                        document.location.reload();
                        swal({
                            title: "",
                            text: "Modification reussie!",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    } else
                        swal({
                            title: "",
                            text: "Une erreur s'est produite!",
                            type: "error",
                            timer: 3000,
                            showConfirmButton: false,
                        });
                    document.getElementById("rep").innerHTML =
                        this.responseText;
                } else
                    swal({
                        title: "",
                        text: "traitement en cours",
                        showConfirmButton: false,
                    });
            };
            xhttp.open(
                "GET",
                "ajax/facture/updateProformat.php?facture_id=" +
                    facture_id +
                    "&facture_services=" +
                    facture_services +
                    "&idclient=" +
                    idclient +
                    "&datefacture=" +
                    datefacture +
                    "&monnaie=" +
                    monnaie +
                    "&fixe_rate=" +
                    fixe_rate +
                    "&exchange_currency=" +
                    exchange_currency +
                    "&mois=" +
                    mois +
                    "&annee=" +
                    annee +
                    "&tva=" +
                    tva +
                    "&i=" +
                    j +
                    "&nombreService=" +
                    nombreService +
                    "&afficheTaux=" +
                    show_rate +
                    "&enable_discount=" +
                    enable_discount +
                    "&reduction=" +
                    reduction +
                    "&taux=" +
                    taux +
                    "&iduser=" +
                    iduser +
                    "&nomclient=" +
                    encodeURIComponent(nomclient) +
                    "&telephone=" +
                    telephone +
                    "&mail=" +
                    mail +
                    "&localisation=" +
                    localisation +
                    "&adresse=" +
                    encodeURIComponent(adresse),
                true
            );
            xhttp.send();
        }
    }
}
function deleteProformat(facture_id) {
    var iduser = $("#iduser").val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            if (rep == "") {
                document.location.reload();
                swal({
                    title: "",
                    text: "",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else
                swal({
                    title: "",
                    text: "Une erreur s'est produite!",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            //document.getElementById('rep').innerHTML = this.responseText;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/deleteProformat.php?facture_id=" +
            facture_id +
            "&iduser=" +
            iduser,
        true
    );
    xhttp.send();
}
$("#client_contracte").on("click", function () {
    if (this.checked) {
        $("#conteneur_proformat").show();
        $("#old_customer_contener").hide();
    } else {
        $("#old_customer_contener").show();
        $("#conteneur_proformat").hide();
    }
    /*if(document.getElementById("client_contracte").checked == true)
    {
        var type = 'nouveau_client';
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //var rep = String(this.responseText).trim();
                document.getElementById('conteneur_proformat').innerHTML = this.responseText;
                const myNodee = document.getElementById("service_contener");
                  while (myNodee.firstChild) {
                    myNodee.removeChild(myNodee.lastChild);
                  } 
            }
        };
        xhttp.open("GET","ajax/facture/conteneur_proformat.php?type="+type,true);
        xhttp.send();
    }
    else
    {
        var type = 'client_contracte';
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //var rep = String(this.responseText).trim();
                document.getElementById('conteneur_proformat').innerHTML = this.responseText; 
            }
        };
        xhttp.open("GET","ajax/facture/conteneur_proformat.php?type="+type,true);
        xhttp.send();
    }*/
});
function setBillingCycleContent(billing_cycle, i) {
    if (billing_cycle == "0") {
        document.getElementById("billingCycleContent" + i).innerHTML =
            '<div class="row">' +
            '<div class="col-lg-4 col-md-4">' +
            '<label class="control-label">Date debut</label>' +
            '<div class="form-group col-sm-9">' +
            '<input type="date" class="form-control form-control-sm" name="startDate" id="startDate' +
            i +
            '">' +
            "</div>" +
            "</div>" +
            "</div>";
        /*var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //var rep = String(this.responseText).trim();
                document.getElementById('billingCycleContent'+i).innerHTML = this.responseText; 
            }
        };
        xhttp.open("GET","ajax/facture/setBillingCycleContent.php?i="+i,true);
        xhttp.send();*/
    } else {
        var divbillingCycle = document.getElementById(
            "billingCycleContent" + i
        );
        divbillingCycle.removeChild(divbillingCycle.childNodes[0]);
    }
}
function getFacturePayerDunClient(idclient) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            //var rep = String(this.responseText).trim();
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/getFacturePayerDunClient.php?idclient=" + idclient,
        true
    );
    xhttp.send();
}
function get_facturePayer_dun_mois(mois_debut, annee) {
    //alert('mois_debut: '+mois_debut+' annee: '+annee);
    var webroot = $("#webroot").val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            //var rep = String(this.responseText).trim();
            $("#myTable").DataTable().destroy();
            document.getElementById("rep").innerHTML = this.responseText;
            $("#myTable").DataTable();
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/get_facture_payee.php?mois_debut=" +
            mois_debut +
            "&annee=" +
            annee +
            "&webroot=" +
            webroot,
        true
    );
    xhttp.send();
}
function getFactureImpayerDunClient(idclient) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            //var rep = String(this.responseText).trim();
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/getFactureImpayerDunClient.php?idclient=" + idclient,
        true
    );
    xhttp.send();
}

function getFacture_impayee(mois_debut, annee) {
    //alert('mois_debut: '+mois_debut+' annee: '+annee);
    var webroot = $("#webroot").val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            //var rep = String(this.responseText).trim();
            $("#myTable").DataTable().destroy();
            document.getElementById("rep").innerHTML = this.responseText;
            $("#myTable").DataTable();
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/Facture_impayee.php?mois_debut=" +
            mois_debut +
            "&annee=" +
            annee +
            "&webroot=" +
            webroot,
        true
    );
    xhttp.send();
}
function getFactures_Dun_mois(mois_debut, annee_debut) {
    //alert('mois_debut: '+mois_debut+' annee_debut: '+annee_debut);
    var webroot = $("#webroot").val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            //var rep = String(this.responseText).trim();
            $("#myTable").DataTable().destroy();
            document.getElementById("rep").innerHTML = this.responseText;
            $("#myTable").DataTable();
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/get_factures.php?mois_debut=" +
            mois_debut +
            "&annee_debut=" +
            annee_debut +
            "&webroot=" +
            webroot,
        true
    );
    xhttp.send();
}
function genererListeFactureNoPayer(mois, annee, idUser) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            //var rep = String(this.responseText).trim();
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/genererListeFactureNoPayer.php?mois=" +
            mois +
            "&annee=" +
            annee +
            "&idUser=" +
            idUser,
        true
    );
    xhttp.send();
}
function genererClientAcouper(idUser) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            if (rep == "no") {
                swal({
                    title: "Information!",
                    text: "Aucun client concerné",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/genererClientAcouper.php?idUser=" + idUser,
        true
    );
    xhttp.send();
}
function genererClientAderoguer(url) {
    //alert('url '+url);
    document.location.href = url;
    /*if (mois == '' || annee == '') 
    {

    }
    else
    {
        document.getElementById('form-creerDerogation').submit();
    }*/
    /*var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            var rep = String(this.responseText).trim();
            if (rep == 'no') 
            {
                swal({   
                    title: "Information!",   
                    text: "Aucun client concerné",   
                    timer: 2000,   
                    showConfirmButton: false 
                });
            }
            else
            document.getElementById('rep').innerHTML = this.responseText; 
        }
    };
    xhttp.open("GET","ajax/facture/genererClientAderoguer.php?mois="+mois+"&annee="+annee,true);
    xhttp.send();*/
}
$("#motif").on("change", function () {
    var idclient = $("#idclient").val();
    var type_client = $("#type_client").val();
    if (type_client == "paying") {
        var i = 0;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                //var rep = String(this.responseText).trim();
                document.getElementById("factureContener").innerHTML =
                    this.responseText;
                ///msg.style.color = 'green';
                //msg.innerHTML = this.responseText;
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/getFacturesDunClient.php?idclient=" +
                idclient +
                "&i=" +
                i,
            true
        );
        xhttp.send();
    }
    /*if($('#motif').val())
    {
        var parent = document.getElementById('factureContener');
        parent.removeChild(parent.childNodes[0]);
    }*/
});
function couperUnClient(
    action,
    idclient,
    motif,
    observation,
    idUser,
    type_client,
    date_creation
) {
    //alert('action: '+action+' observation: '+observation+' client: '+client+' motif: '+motif+' idUser: '+idUser+' type_client: '+type_client);

    if (idclient == "" || motif == "") {
        swal({
            title: "",
            text: "Veuillez renseigner les champs en *",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    } else {
        var facture_id = "";
        if (motif == "dette") {
            facture_id = $("#facture_id").val();
        }
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                var rep = String(this.responseText).trim();
                if (rep == "ok") {
                    document.location.reload();
                    swal({
                        title: "",
                        text: "",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } else {
                    document.getElementById("rep").innerHTML =
                        this.responseText;
                    swal({
                        title: "",
                        text: "Une erreur s'est produite",
                        type: "error",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/couperUnClient.php?idclient=" +
                idclient +
                "&observation=" +
                observation +
                "&action=" +
                action +
                "&idUser=" +
                idUser +
                "&motif=" +
                motif +
                "&type_client=" +
                type_client +
                "&date_creation=" +
                date_creation +
                "&facture_id=" +
                facture_id,
            true
        );
        xhttp.send();
    }
}
function activerClient(idclient, idUser) {
    //alert('idclient : '+idclient+' idUser : '+idUser);
    if (idclient == "")
        swal({
            title: "",
            text: "Veuillez choisir un client",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    else {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                var rep = String(this.responseText).trim();
                if (rep == "") {
                    document.location.reload();
                    swal({
                        title: "",
                        text: "",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } else {
                    document.getElementById("rep").innerHTML =
                        this.responseText;
                    swal({
                        title: "",
                        text: "Une erreur s'est produite",
                        type: "error",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/activerClient.php?idclient=" +
                idclient +
                "&idUser=" +
                idUser,
            true
        );
        xhttp.send();
    }
}
function ajouterClientAuListeDeCoupure(idclient, action, observation, idUser) {
    //alert('cutoff_id: '+cutoff_id+' action: '+action+' observation: '+observation+' client: '+idclient+' idUser: '+idUser);

    if (idclient === null || action == "") {
        swal({
            title: "",
            text: "Veuillez renseigner les champs en *",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    } else {
        var cutoff_id = $("#cutoff_id").val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                var rep = String(this.responseText).trim();
                if (rep == "") {
                    document.location.reload();
                    swal({
                        title: "",
                        text: "",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } else {
                    document.getElementById("rep").innerHTML =
                        this.responseText;
                    swal({
                        title: "",
                        text: "Une erreur s'est produite",
                        type: "error",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/couperUnClient.php?idclient=" +
                idclient +
                "&observation=" +
                observation +
                "&action=" +
                action +
                "&cutoff_id=" +
                cutoff_id +
                "&idUser=" +
                idUser,
            true
        );
        xhttp.send();
    }
}
function print_coupure_action() {
    document.getElementById("print_coupure_action").submit();
}
function creerCoupure(date_coupure) {
    //alert(date_coupure);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            //var msg = document.getElementById("msg"+i);
            //msg.style.color = 'green';
            //msg.innerHTML = this.responseText;
            if (rep == "") {
                document.location.reload();
                swal({
                    title: "",
                    text: "",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else
                swal({
                    title: "",
                    text: "Une erreur s'est produite",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            //document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/saveCoupure.php?date_coupure=" + date_coupure,
        true
    );
    xhttp.send();
}
function update_cutoff_list(date_coupure, cutoff_id, i) {
    //alert(date_coupure+' cutoff_id: '+cutoff_id+' i: '+i);
    var confirmed = "non";
    if (document.getElementById("confirmed" + i).checked == true) {
        confirmed = "oui";
    }
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            //var msg = document.getElementById("msg"+i);
            //msg.style.color = 'green';
            //msg.innerHTML = this.responseText;
            if (rep == "") {
                document.location.reload();
                swal({
                    title: "",
                    text: "",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else
                swal({
                    title: "",
                    text: "Une erreur s'est produite",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/update_cutoff_list.php?date_coupure=" +
            date_coupure +
            "&confirmed=" +
            confirmed +
            "&cutoff_id=" +
            cutoff_id,
        true
    );
    xhttp.send();
}
function delete_cutoff_list(cutoff_id) {
    //alert(cutoff_id);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            //var msg = document.getElementById("msg"+i);
            //msg.style.color = 'green';
            //msg.innerHTML = this.responseText;
            if (rep == "") {
                location.reload();
                swal({
                    title: "",
                    text: "",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else
                swal({
                    title: "",
                    text: "Une erreur s'est produite",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/delete_cutoff_list.php?cutoff_id=" + cutoff_id,
        true
    );
    xhttp.send();
}
function saveDerogation() {
    //alert(action+''+observation+''+idclient+''+montant+''+monnaie+''+mois+''+annee+' '+motif);
    var action = "recouvrer";
    var motif = "derogation";
    var totalCocher = $("input:checkbox:checked").length;
    var y = 0;
    if (totalCocher == 0) {
        swal({
            title: "",
            text: "Aucun client selectioné",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    } else {
        $("input:checkbox:checked").each(function () {
            y++;
            var i = this.value;
            //var facture_id = document.getElementById('facture_id'+i).value;
            var idclient = document.getElementById("idclient" + i).value;
            var montant = document.getElementById("montant" + i).value;
            var monnaie = document.getElementById("monnaie" + i).value;
            var mois = document.getElementById("mois" + i).value;
            var annee = document.getElementById("annee" + i).value;
            //alert('idclient: '+idclient+' montant: '+montant+' monnaie: '+monnaie+' mois: '+mois+' annee: '+annee);
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4) {
                    if (y == totalCocher) {
                        var rep = String(this.responseText).trim();
                        if (rep == "ok") {
                            document.location.reload();
                            swal({
                                title: "",
                                text: "",
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }
                    }
                }
            };
            xhttp.open(
                "GET",
                "ajax/facture/saveDerogation.php?mois=" +
                    mois +
                    "&annee=" +
                    annee +
                    "&monnaie=" +
                    monnaie +
                    "&montant=" +
                    montant +
                    "&idclient=" +
                    idclient +
                    "&action=" +
                    action +
                    "&motif=" +
                    motif,
                true
            );
            xhttp.send();
        });
    }
}
function checkActionCoupure(action, idclient, i) {
    if (action != "") {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                //var rep = String(this.responseText).trim();
                document.getElementById("motif_contener" + i).innerHTML =
                    this.responseText;
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/motif_coupure.php?action=" +
                action +
                "&i=" +
                i +
                "&idclient=" +
                idclient,
            true
        );
        xhttp.send();
    }
}
function getFacturesDunClient(motif, idclient, i) {
    if (motif == "dette") {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                //var rep = String(this.responseText).trim();
                document.getElementById("factureContener" + i).innerHTML =
                    this.responseText;
                ///msg.style.color = 'green';
                //msg.innerHTML = this.responseText;
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/getFacturesDunClient.php?idclient=" +
                idclient +
                "&i=" +
                i,
            true
        );
        xhttp.send();
    } else {
        var parent = document.getElementById("factureContener" + i);
        parent.removeChild(parent.childNodes[0]);
    }
}
function updateCoupure(
    action,
    observation,
    idclient,
    i,
    coupure_id,
    montant,
    monnaie
) {
    //alert('action: '+action+' observation: '+observation+' idclient: '+idclient+' i: '+i+' coupure_id: '+coupure_id+' montant: '+montant+' monnaie: '+monnaie);

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            if (rep == "") {
                document.location.reload();
                swal({
                    title: "",
                    text: "",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else {
                /*var msg = document.getElementById("msg"+i);
                msg.style.color = 'green';
                msg.innerHTML = this.responseText;*/
                swal({
                    title: "",
                    text: this.responseText,
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/updateCoupure.php?idclient=" +
            idclient +
            "&observation=" +
            observation +
            "&action=" +
            action +
            "&coupure_id=" +
            coupure_id +
            "&montant=" +
            montant +
            "&monnaie=" +
            monnaie,
        true
    );
    xhttp.send();
}
function deleteCoupureAction(coupure_id, idclient) {
    //alert('coupure_id: '+coupure_id+' idclient: '+idclient);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            if (rep == "") {
                location.reload();
                swal({
                    title: "",
                    text: "Suppression reussie!",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else {
                swal({
                    title: "",
                    text: "Une err s'est produite!",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/deleteCoupureAction.php?coupure_id=" +
            coupure_id +
            "&idclient=" +
            idclient,
        true
    );
    xhttp.send();
}
function updateFacture(
    idclient,
    facture_id,
    datefacture,
    monnaie,
    mois,
    annee,
    tva,
    billing_number,
    i,
    id_dernierService,
    idcontract,
    next_billing_date,
    billing_date
) {
    //alert(datefacture+' '+monnaie+' '+mois+' '+annee+' '+tva+' '+facture_suivante);
    //var WEBROOT = $('#WEBROOT').val();
    //alert('id_dernierService: '+$('#id_dernierService'+i).val());
    //billing_date = (mois < 10 ? annee+'-0'+mois+'-01' : annee+'-'+mois+'-01');
    var idclient = idclient.split(/-/)[1];
    var startDate = "null";
    //var endDate = "null";
    var enable_discount = 0;
    //var reduction = (reduction == "" ? 0 : reduction);
    var facture_services = "";
    if (datefacture == "" || annee == "") {
        var msg = document.getElementById("msg-update");
        msg.style.color = "red";
        msg.innerHTML =
            "Veuillez renseigner tous les champs en etoile et la quantite doit etre > 0";
    } else {
        /*else if (next_billing_date != '' && billing_date < next_billing_date) 
    {
        swal({
            title :"",
            text :"la prochaine facturation n'est pas vraie",
            type :"error",
            timer :2000,
            showConfirmButton:false
        });
    }*/
        var fixe_rate = 0;
        var show_rate = 0;
        var taux = 1;
        var exchange_currency = "USD";
        var test_billing_cycle = 0;
        if (document.getElementById("afficheTaux" + i).checked == true)
            show_rate = 1;
        if (document.getElementById("enable_discount" + i).checked == true)
            enable_discount = 1;
        if (document.getElementById("fixe_rate" + i).checked == true) {
            fixe_rate = 1;
            taux = $("#taux" + i).val();
            exchange_currency = $("#exchange_currency" + i).val();
        }

        var nombreService = $("#nombreServiceUpdate" + i).val();
        //var y = id_dernierService - nombreService;
        for (var j = 0; j < nombreService; j++) {
            y = j + 1;
            var service = $("#service" + facture_id + y)
                .val()
                .split(/-/);
            var serviceId = service[0];
            var serviceName = service[1];
            var idFs = $("#idFs" + facture_id + y).val();
            var montant = $("#montant" + facture_id + y)
                .val()
                .replace(",", ".");
            //var serviceName = $('#serviceName'+facture_id+y).val();
            var quantite = $("#quantite" + facture_id + y).val();
            var reduction = $("#reduction" + facture_id + y).val();
            //var sous_client = $('#sous_client'+y).val();
            var bandeP =
                $("#bandeP" + facture_id + y).val() == ""
                    ? "null"
                    : $("#bandeP" + facture_id + y).val();
            var description =
                $("#description" + facture_id + y)
                    .val()
                    .trim() == ""
                    ? "null"
                    : $("#description" + facture_id + y)
                          .val()
                          .trim();
            var billing_cycle = $("#Billing_cycle" + facture_id + y).val();
            if (montant == "" || quantite == "") {
                swal({
                    title: "",
                    text: "Veuillez renseigner les champs en *",
                    type: "error",
                    timer: 3000,
                    showConfirmButton: false,
                });
                facture_services = "";
                break;
            }
            if (billing_cycle == 0) {
                startDate = $("#startDate" + facture_id + y).val();
                //endDate = $('#endDate'+facture_id+y).val();
            }
            if (billing_cycle == 1) {
                test_billing_cycle = 1;
                if (enable_discount == 1) {
                    if (reduction == "") {
                        if (quantite == 3) reduction = 5;
                        else if (quantite == 6) reduction = 10;
                        else if (quantite == 12) reduction = 20;
                    }
                } else {
                    reduction = 0;
                }
            }
            facture_services +=
                serviceId +
                "_" +
                idFs +
                "_" +
                montant +
                "_" +
                quantite +
                "_" +
                bandeP +
                "_" +
                encodeURIComponent(description) +
                "_" +
                billing_cycle +
                "_" +
                startDate +
                "_" +
                serviceName +
                "_" +
                reduction +
                "=";
            //alert(facture_services);
            //alert('idclient: '+idclient+' facture_id: '+facture_id+' idFs: '+idFs+' datefacture: '+datefacture+' monnaie: '+monnaie+' mois: '+mois+' annee: '+annee+' tva: '+tva+' service: '+service+' montant: '+montant+' monnaiservice: '+monnaieService+' quantite: '+quantite+' rediction: '+rediction+' bandeP: '+bandeP+' description: '+description+' billing_cycle: '+billing_cycle+' startDate: '+startDate+' endDate: '+endDate);
        }
        if (facture_services != "") {
            var iduser = $("#iduser").val();
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4) {
                    var rep = String(this.responseText).trim();
                    //if ($('#page').val() == 'facture')
                    //{
                    //$('#myTable').DataTable().destroy();
                    document.getElementById("rep").innerHTML =
                        this.responseText;
                    //$('#myTable').DataTable();
                    if (rep == "") {
                        document.location.reload();
                        swal({
                            title: "",
                            text: "Modification reussie!",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    } else
                        swal({
                            title: "",
                            text: "Une erreur s'est produite!",
                            type: "error",
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    //}
                    /*else
                    {
                        document.location.reload();
                    }*/
                } else
                    swal({
                        title: "",
                        text: "traitement en cours",
                        showConfirmButton: false,
                    });
            };
            xhttp.open(
                "GET",
                "ajax/facture/updateFacture.php?facture_id=" +
                    facture_id +
                    "&facture_services=" +
                    facture_services +
                    "&idclient=" +
                    idclient +
                    "&datefacture=" +
                    datefacture +
                    "&monnaie=" +
                    monnaie +
                    "&fixe_rate=" +
                    fixe_rate +
                    "&exchange_currency=" +
                    exchange_currency +
                    "&mois=" +
                    mois +
                    "&annee=" +
                    annee +
                    "&tva=" +
                    tva +
                    "&billing_number=" +
                    billing_number +
                    "&i=" +
                    j +
                    "&nombreService=" +
                    nombreService +
                    "&afficheTaux=" +
                    show_rate +
                    "&enable_discount=" +
                    enable_discount +
                    "&taux=" +
                    taux +
                    "&next_billing_date=" +
                    next_billing_date +
                    "&billing_date=" +
                    billing_date +
                    "&idcontract=" +
                    idcontract +
                    "&iduser=" +
                    iduser +
                    "&test_billing_cycle=" +
                    test_billing_cycle,
                true
            );
            xhttp.send();
        }
    }
}
function creerfactureEnMasse(mode, date_creation, mois, annee, taux) {
    //alert('mode: '+mode+' date_creation: '+date_creation+' mois: '+mois+' annee: '+annee+' taux: '+taux);
    if (
        mode == "" ||
        date_creation == "" ||
        mois == "" ||
        annee == "" ||
        taux == ""
    )
        swal({
            title: "",
            text: "Veuillez remplir tous les champs!",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    else document.getElementById("massInvoiceForm").submit();
}
function massInvoiceDelete(month, year, mode) {
    var WEBROOT = $("#WEBROOT").val();
    var iduser = $("#iduser").val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            if (rep == "") {
                //$('#myTable').DataTable().destroy();
                //document.getElementById('rep').innerHTML = this.responseText;
                //$('#myTable').DataTable();
                document.location.reload();
                swal({
                    title: "",
                    text: "Suppression reussie!",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else {
                //document.getElementById('rep').innerHTML = this.responseText;
                swal({
                    title: "",
                    text: "Une erreur s'est produite !",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
        } else
            swal({
                title: "",
                text: "Suppression en cours",
                showConfirmButton: false,
            });
    };
    xhttp.open(
        "GET",
        "ajax/facture/massDeleteInvoice.php?month=" +
            month +
            "&year=" +
            year +
            "&mode=" +
            mode,
        true
    );
    xhttp.send();
}
function deleteFacture(
    id_facture,
    mois_debut,
    annee_debut,
    idclient,
    idcontract,
    billing_date
) {
    //alert("id_facture: "+id_facture+" mois_debut: "+mois_debut+" annee_debut "+annee_debut+" idclient: "+idclient+" idcontract: "+idcontract+" billing_date: "+billing_date);
    var WEBROOT = $("#WEBROOT").val();
    var iduser = $("#iduser").val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            if (rep == "") {
                //$('#myTable').DataTable().destroy();
                //document.getElementById('rep').innerHTML = this.responseText;
                //$('#myTable').DataTable();
                document.location.reload();
                swal({
                    title: "",
                    text: "Suppression reussie!",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else {
                //document.getElementById('rep').innerHTML = this.responseText;
                swal({
                    title: "",
                    text: "Une erreur s'est produite !",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
            }
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/deleteFacture.php?id_facture=" +
            id_facture +
            "&mois_debut=" +
            mois_debut +
            "&annee_debut=" +
            annee_debut +
            "&WEBROOT=" +
            WEBROOT +
            "&iduser=" +
            iduser +
            "&idclient=" +
            idclient +
            "&idcontract=" +
            idcontract +
            "&billing_date=" +
            billing_date,
        true
    );
    xhttp.send();
}
var nbserviceProforma = 0;
function addServiceToProforma() {
    nbserviceProforma++;
    if (nbserviceProforma < 5) {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                //var rep = String(this.responseText).trim();
                document.getElementById("service_contener").innerHTML +=
                    this.responseText;
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/addServiceToProforma.php?nbserviceProforma=" +
                nbserviceProforma,
            true
        );
        xhttp.send();
    }
}
function creerBallanceInitiale(
    idclient,
    date_creation,
    montant,
    monnaie,
    description
) {
    var iduser = $("#iduser").val();
    //var idclient = idclient.split(/-/)[1];
    //alert('idclient: '+idclient+' date_creation: '+date_creation+' montant: '+montant+' monnaie: '+monnaie+' description: '+description);
    if (idclient === null) {
        swal({
            title: "",
            text: "Veuillez choisir un client!",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    } else {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                //document.getElementById('rep').innerHTML = this.responseText;
                var rep = String(this.responseText).trim();
                if (rep == "") {
                    document.location.reload();
                    swal({
                        title: "",
                        text: "Creation réussie!",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                    /*$('#montant').val('');
                     $('#date_creation').val('');
                     $('#description').val('');*/
                } else
                    swal({
                        title: "",
                        text: "Une erreur s'est produite",
                        type: "error",
                        timer: 2000,
                        showConfirmButton: false,
                    });

                //var msg = document.getElementById('msg');
                //msg.style.color = 'green';
                //msg.innerHTML = rep;
                //document.getElementById('rep').innerHTML = this.responseText;
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/creerBallanceInitiale.php?idclient=" +
                idclient +
                "&date_creation=" +
                date_creation +
                "&montant=" +
                montant +
                "&monnaie=" +
                monnaie +
                "&description=" +
                description +
                "&iduser=" +
                iduser,
            true
        );
        xhttp.send();
    }
}
function updateBallanceInitiale(
    idbalance,
    idclient,
    montant,
    monnaie,
    datebalance,
    description
) {
    //alert('idbalance: '+idbalance+' idclient: '+idclient+' montant: '+montant+' monnaie: '+monnaie+' date: '+datebalance+' description: '+description);
    if (montant == "" || monnaie == "" || datebalance == "") {
        swal({
            title: "",
            text: "Veuillez remplir les champs en *",
            type: "error",
            timer: 2000,
            showConfirmButton: false,
        });
    } else {
        var iduser = $("#iduser").val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                //document.getElementById("rep").innerHTML = this.responseText;
                //location.reload();
                var rep = String(this.responseText).trim();
                if (rep == "") {
                    document.location.reload();
                    swal({
                        title: "",
                        text: "",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false,
                    });
                } else
                    swal({
                        title: "",
                        text: "Une erreur est survenue!",
                        type: "error",
                        timer: 2000,
                        showConfirmButton: false,
                    });
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/updateBallanceInitiale.php?id=" +
                idbalance +
                "&idclient=" +
                idclient +
                "&montant=" +
                montant +
                "&monnaie=" +
                monnaie +
                "&datebalance=" +
                datebalance +
                "&description=" +
                description +
                "&iduser=" +
                iduser,
            true
        );
        xhttp.send();
    }
}
function deleteBallance(id, idclient) {
    var iduser = $("#iduser").val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            if (rep == "") {
                document.location.reload();
                swal({
                    title: "",
                    text: "",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false,
                });
            } else
                swal({
                    title: "",
                    text: "Une erreur est survenue!",
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false,
                });
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/deleteBallanceInitiale.php?id=" +
            id +
            "&idclient=" +
            idclient +
            "&iduser=" +
            iduser,
        true
    );
    xhttp.send();
}
function creerPause(
    idclient,
    dateDebut,
    dateFin,
    raison,
    type_suspension,
    date_creation,
    idUser
) {
    //alert(idclient+' '+dateDebut+' '+dateFin+' '+mois+' '+service+' '+raison+' '+type_suspension+' '+date_creation);

    var idclient = idclient.split(/-/);
    if (dateDebut == "") {
        swal({
            title: "",
            text: "Veuillez renseigner les champs en *",
            type: "error",
            timer: 3000,
            showConfirmButton: false,
        });
    } else {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                var rep = String(this.responseText).trim();
                if (rep == "") {
                    location.reload();
                    swal({
                        title: "",
                        text: "",
                        type: "success",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                } else {
                    swal({
                        title: "",
                        text: "Une erreur s'est produite",
                        type: "error",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                }
                //document.getElementById('rep').innerHTML = this.responseText;
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/creerPause.php?idclient=" +
                idclient[1] +
                "&dateDebut=" +
                dateDebut +
                "&dateFin=" +
                dateFin +
                "&raison=" +
                raison +
                "&type_suspension=" +
                type_suspension +
                "&date_creation=" +
                date_creation +
                "&idUser=" +
                idUser,
            true
        );
        xhttp.send();
    }
}
function updatePause(
    idPause,
    idclient,
    dateDebut,
    dateFin,
    raison,
    type_pause,
    idUser
) {
    //alert('idPause: '+idPause+' idclient: '+idclient+' dateDebut: '+dateDebut+' dateFin: '+dateFin+' raison: '+raison+' type_pause: '+type_pause+' idUser: '+idUser);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            var rep = String(this.responseText).trim();
            if (rep == "ok") {
                location.reload();
                swal({
                    title: "",
                    text: "",
                    type: "success",
                    timer: 3000,
                    showConfirmButton: false,
                });
            } else {
                swal({
                    title: "",
                    text: "Une erreur s'est produite",
                    type: "error",
                    timer: 3000,
                    showConfirmButton: false,
                });
            }
            //document.getElementById('rep').innerHTML = this.responseText;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/updatePause.php?idPause=" +
            idPause +
            "&dateDebut=" +
            dateDebut +
            "&dateFin=" +
            dateFin +
            "&raison=" +
            raison +
            "&type_pause=" +
            type_pause +
            "&idUser=" +
            idUser,
        true
    );
    xhttp.send();
}
function getCauseSuppresionPause(element, i) {
    if (element.id == "deletePause_parErreur" + i) {
        if (document.getElementById(element.id).checked == true) {
            document.getElementById("pause_terminer" + i).checked = false;
            $("#deletePause_contener" + i).hide();
        }
    } else if (element.id == "pause_terminer" + i) {
        if (document.getElementById(element.id).checked == true) {
            document.getElementById(
                "deletePause_parErreur" + i
            ).checked = false;
            $("#deletePause_contener" + i).show();
        }
    }
}
function deletePause(idPause, idclient, dateDebut, idUser, i) {
    //alert('idPause: '+idPause+' idclient: '+idclient+' idUser: '+idUser);
    var checkDelete = 0;
    var dateOuverture = "";
    if (document.getElementById("deletePause_parErreur" + i).checked == true) {
        checkDelete = 1;
    } else if (document.getElementById("pause_terminer" + i).checked == true)
        dateOuverture = $("#dateOuverture" + i).val();
    if (dateOuverture == "" && checkDelete == 0) {
        swal({
            title: "",
            text: "Veuillez faire un choix !",
            type: "error",
            timer: 3000,
            showConfirmButton: false,
        });
    } else {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                var rep = String(this.responseText).trim();
                if (rep == "") {
                    document.location.reload();
                    swal({
                        title: "",
                        text: "",
                        type: "success",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                } else {
                    swal({
                        title: "",
                        text: this.responseText,
                        type: "error",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                }
                document.getElementById("rep").innerHTML = this.responseText;
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/deletePause.php?idPause=" +
                idPause +
                "&idclient=" +
                idclient +
                "&idUser=" +
                idUser +
                "&dateOuverture=" +
                dateOuverture +
                "&checkDelete=" +
                checkDelete +
                "&dateDebut=" +
                dateDebut,
            true
        );
        xhttp.send();
    }
}
function sendFacture(mois_fact, annee_fact) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            try {
                var response = JSON.parse(this.responseText);
                var msg = response.message;

                if (
                    response.stats &&
                    response.stats.errors &&
                    response.stats.errors.length > 0
                ) {
                    msg +=
                        "\n\nDétails des erreurs:\n" +
                        response.stats.errors.slice(0, 5).join("\n");
                    if (response.stats.errors.length > 5) {
                        msg +=
                            "\n... et " +
                            (response.stats.errors.length - 5) +
                            " autre(s)";
                    }
                }

                swal(
                    {
                        title: response.success
                            ? "Succès"
                            : "Complété avec erreurs",
                        text: msg,
                        type: response.success ? "success" : "warning",
                        timer: 5000,
                        showConfirmButton: false,
                    },
                    function () {
                        if (response.success) {
                            document.location.reload();
                        }
                    }
                );
            } catch (e) {
                // Fallback for non-JSON responses
                swal({
                    title: "Résultat",
                    text: this.responseText || "Traitement complété",
                    type: "info",
                    timer: 3000,
                    showConfirmButton: false,
                });
            }
        } else
            swal({
                title: "",
                text: "traitement en cours...",
                showConfirmButton: false,
            });
    };
    xhttp.open(
        "GET",
        "ajax/Sender/sendFacture.php?mois_fact=" +
            mois_fact +
            "&annee_fact=" +
            annee_fact,
        true
    );
    xhttp.send();
}
function filtreFacture(
    billing_number,
    nom_client,
    date1,
    date2,
    mode,
    mois,
    annee
) {
    //alert(num_fact+' '+client+' '+date1+' '+date2+' '+mode+' '+mois+' '+annee);
    var WEBROOT = $("#WEBROOT").val();
    //var idclient = client.split(/-/)[1];
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4 = null;
    var condition5 = null;
    var condition6 = null;
    var condition = "";
    //if (typeof idclient == 'undefined') {idclient = '';}
    if (billing_number == "") {
        condition1 = "";
    } else {
        condition1 = " billing_number='" + billing_number + "' ";
    }
    if (nom_client == "") {
        condition2 = "";
    } else {
        //condition2 = " cl.ID_client="+idclient+" ";
        condition2 = " nom_client LIKE '%" + nom_client + "%' ";
    }
    if (mode == "") {
        condition3 = "";
    } else {
        condition3 = " fac.creation_mode='" + mode + "' ";
    }
    if (date1 == "") {
        condition4 = "";
    } else {
        condition4 = " fac.date_creation='" + date1 + "' ";
    }
    if (date2 == "") {
        condition5 = "";
    } else {
        if (date1 !== "") {
            condition5 =
                " fac.date_creation BETWEEN '" +
                date1 +
                "' AND '" +
                date2 +
                "'";
            condition4 = "";
        } else condition5 = " fac.date_creation='" + date2 + "' ";
    }
    if (mois == "") {
        condition6 = "";
    } else {
        if (annee != "") {
            condition6 = " fs.mois_debut='" + mois + "' AND fs.annee=" + annee;
        }
    }

    condition1 = condition1 == "" ? "" : "AND" + condition1;
    condition2 = condition2 == "" ? "" : "AND" + condition2;
    condition3 = condition3 == "" ? "" : "AND" + condition3;
    condition4 = condition4 == "" ? "" : "AND" + condition4;
    condition5 = condition5 == "" ? "" : "AND" + condition5;
    condition6 = condition6 == "" ? "" : "AND" + condition6;

    condition =
        condition1 +
        condition2 +
        condition3 +
        condition4 +
        condition5 +
        condition6;

    if (condition == "") {
    } else {
        $("#cond").val(condition);
        var m = $("#m").val();
        var s = $("#s").val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                $("#myTable").DataTable().destroy();
                var data = (document.getElementById("rep").innerHTML =
                    this.responseText);
                $("#myTable").DataTable();
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/filtreFacture.php?condition=" +
                condition +
                "&WEBROOT=" +
                WEBROOT +
                "&m=" +
                m +
                "&s=" +
                s,
            true
        );
        xhttp.send();
    }
}
function resetFiltreFacture() {
    //location.reload();
    var WEBROOT = $("#WEBROOT").val();
    document.location.href = WEBROOT + "facture_client";
}
function resetFiltreFactureProformat() {
    //location.reload();
    var WEBROOT = $("#WEBROOT").val();
    document.location.href = WEBROOT + "proforma_facture";
}
function filtreProformat(num_fact, nom_client, date1, date2) {
    //alert(num_fact+' '+client+' '+date1+' '+date2+' '+mode+' '+mois+' '+annee);
    var WEBROOT = $("#WEBROOT").val();
    //var idclient = client.split(/-/)[1];
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4 = null;
    var condition5 = null;
    var condition6 = null;
    var condition = "";
    //if (typeof idclient == 'undefined') {idclient = '';}
    if (num_fact == "") {
        condition1 = "";
    } else {
        condition1 = " pro.numero = '" + num_fact + "' ";
    }
    if (nom_client == "") {
        condition2 = "";
    } else {
        condition2 = " nom_client LIKE '%" + nom_client + "%' ";
    }
    if (date1 == "") {
        condition3 = "";
    } else {
        condition3 = " pro.date_creation = '" + date1 + "' ";
    }
    if (date2 == "") {
        condition4 = "";
    } else {
        if (date1 !== "") {
            condition4 =
                " pro.date_creation BETWEEN '" +
                date1 +
                "' AND '" +
                date2 +
                "'";
            condition3 = "";
        } else condition4 = " pro.date_creation='" + date2 + "' ";
    }

    condition1 = condition1 == "" ? "" : "AND" + condition1;
    condition2 = condition2 == "" ? "" : "AND" + condition2;
    condition3 = condition3 == "" ? "" : "AND" + condition3;
    condition4 = condition4 == "" ? "" : "AND" + condition4;

    condition = condition1 + condition2 + condition3 + condition4;

    if (condition == "") {
    } else {
        //var data = document.getElementById('rep').innerHTML = condition;
        $("#cond").val(condition);
        //var m = $('#m').val();
        //var s = $('#s').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                $("#myTable").DataTable().destroy();
                document.getElementById("rep").innerHTML = this.responseText;
                $("#myTable").DataTable();
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/filtreProformat.php?condition=" +
                condition +
                "&WEBROOT=" +
                WEBROOT,
            true
        );
        xhttp.send();
    }
}
function raportFacture() {
    //var cond = $('#cond').val();
    //if ($('#cond').val() == '') alert('Veuillez filtrer d\'abord!');
    //else document.getElementById("forem-reportFact").submit();
    //document.location.href = "/crm.spidernet/report_fact?cond="+cond;
    $("#print").val(1);
    document.getElementById("filtreFacture").submit();
}
function calculerMontantFacture(status, mois, annee) {
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            document.getElementById("repCalcul").innerHTML = this.responseText;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/calculerMontantFacture.php?status=" +
            status +
            "&mois=" +
            mois +
            "&annee=" +
            annee,
        true
    );
    xhttp.send();
}
function filtreRaportFacture(status, mois, annee) {
    //alert(status+' '+mois_creation+' '+annee_fact);
    var webroot = $("#webroot").val();
    if (status == "" || mois == "" || annee == "") {
        alert("Veuillez renseigner tous les champs");
    } else {
        var condition =
            " AND fs.mois_debut='" + mois + "' AND fs.annee=" + annee;
        $("#cond").val(condition);
        $("#type").val(status);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                $("#myTable").DataTable().destroy();
                document.getElementById("rep").innerHTML = this.responseText;
                $("#myTable").DataTable();
                calculerMontantFacture(status, mois, annee);
            }
        };
        xhttp.open(
            "GET",
            "ajax/facture/filtreRaportFacture.php?condition=" +
                condition +
                "&status=" +
                status +
                "&webroot=" +
                webroot,
            true
        );
        xhttp.send();
    }
}
function resetFiltreRaportFacture() {
    var webroot = $("#webroot").val();
    //alert(webroot);
    document.location.href = webroot + "raportFact";
}
function submitRaportFacturePayerIpayer() {
    if ($("#cond").val() == "") alert("Veuillez filtrer d'abord!");
    else document.getElementById("form-raportFact").submit();
}
function form_nouveau_client() {
    document.getElementById("form_nouveau_client").submit();
}
function client_derogation() {
    document.getElementById("form_clientderoguer").submit();
}
var m = 0;
function ajoutServiceToFacture() {
    m++;
    //Conteneur.removeChild(Conteneur.childNodes[i]);
    var action = "create";
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            document.getElementById("service_contener").innerHTML +=
                this.responseText;
            document.getElementById("nbservice").value = m + 1;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/includeServiceOnCreerfacture.php?n=" +
            m +
            "&action=" +
            action,
        true
    );
    xhttp.send();
}
function supServiceToFacture() {
    var nbservice = $("#nbservice").val();
    var service_contener = document.getElementById("service_contener");
    service_contener.removeChild(service_contener.childNodes[nbservice - 2]);
    nbservice--;
    document.getElementById("nbservice").value = nbservice;
    m = nbservice - 1;
}
function ajoutServiceToUpdateFacture(facture_id, i) {
    var nbServiceContract = $("#nombreServiceUpdate" + i).val();
    var j = parseInt(nbServiceContract) + 1;
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            document.getElementById("service_contener" + i).innerHTML +=
                this.responseText;
            //document.getElementById("service_contener").appendChild(this.responseText);
            document.getElementById("nombreServiceUpdate" + i).value = j;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/includeServiceOnUpdatefacture.php?n=" +
            j +
            "&facture_id=" +
            facture_id,
        true
    );
    xhttp.send();
}
var k = 0;
function ajoutServiceToProformat() {
    k++;
    //Conteneur.removeChild(Conteneur.childNodes[i]);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            document.getElementById("service_contener").innerHTML +=
                this.responseText;
            document.getElementById("nbservice").value = k + 1;
        }
    };
    xhttp.open(
        "GET",
        "ajax/autocomplete/includeServiceOnCreerfacture_proformat.php?n=" + k,
        true
    );
    xhttp.send();
}
function supServiceToCeateProformat() {
    var nbservice = $("#nbservice").val();
    var service_contener = document.getElementById("service_contener");
    service_contener.removeChild(service_contener.childNodes[nbservice - 2]);
    nbservice--;
    document.getElementById("nbservice").value = nbservice;
    k = nbservice - 1;
}
function ajoutServiceToUpdateFactureProformat(facture_id, i) {
    var nbServiceContract = $("#nombreServiceUpdate" + i).val();
    var j = parseInt(nbServiceContract) + 1;
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            document.getElementById("service_contener" + i).innerHTML +=
                this.responseText;
            //document.getElementById("service_contener").appendChild(this.responseText);
            document.getElementById("nombreServiceUpdate" + i).value = j;
        }
    };
    xhttp.open(
        "GET",
        "ajax/facture/includeServiceOnUpdateFactureProformat.php?n=" +
            j +
            "&facture_id=" +
            facture_id,
        true
    );
    xhttp.send();
}

const select = document.getElementById("selectCustomerInvoice");
if (select === null) {
} else {
    const options = Array.from(select.options);
    const input = document.getElementById("seachCustomerInvoice");
    function findMatches(search, options) {
        return options.filter((option) => {
            const regex = new RegExp(search, "gi");
            return option.text.match(regex);
        });
    }

    function filterOptions() {
        options.forEach((option) => {
            option.remove();
            option.selected = false;
        });
        const matchArray = findMatches(this.value, options);
        select.append(...matchArray);
    }

    input.addEventListener("keyup", filterOptions);
}

const select2 = document.getElementById("selectCustomerToActivate");
if (select2 === null) {
} else {
    const options = Array.from(select2.options);
    const input = document.getElementById("seachCustomerToActivate");
    function findMatches(search, options) {
        return options.filter((option) => {
            const regex = new RegExp(search, "gi");
            return option.text.match(regex);
        });
    }

    function filterOptions() {
        options.forEach((option) => {
            option.remove();
            option.selected = false;
        });
        const matchArray = findMatches(this.value, options);
        select2.append(...matchArray);
    }

    input.addEventListener("keyup", filterOptions);
}

const select3 = document.getElementById("selectCustomerToAddToList");
if (select3 === null) {
} else {
    const options = Array.from(select3.options);
    const input = document.getElementById("seachCustomerToAddToList");
    function findMatches(search, options) {
        return options.filter((option) => {
            const regex = new RegExp(search, "gi");
            return option.text.match(regex);
        });
    }

    function filterOptions() {
        options.forEach((option) => {
            option.remove();
            option.selected = false;
        });
        const matchArray = findMatches(this.value, options);
        select3.append(...matchArray);
    }

    input.addEventListener("keyup", filterOptions);
}

// for OBR

var invoice_amount_total = 0;
function selectInvoicesToSendToObr(element) {
    if (element.checked) {
        invoice_amount_total += parseFloat(element.value);
    } else {
        invoice_amount_total -= parseFloat(element.value);
    }
    let number_format = invoice_amount_total
        .toString()
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    $("#showTotalAmount").val(number_format);
}
function addInvoicesToObrServer(event) {
    event.preventDefault();

    var invoices = new Array();
    var oTable = $("#myTable").dataTable();
    var rowcollection = oTable.$(".selected_invoice:checked", { page: "all" });
    rowcollection.each(function (index, elem) {
        invoices.push(elem.id);
    });

    // Array to hold invoice data
    var invoiceDataArray = [];

    for (let index = 0; index < invoices.length; index++) {
        const element = invoices[index];
        fetch("ajax/facture/getInvoiceById.php?id=" + element, {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
            },
            method: "POST",
        })
            .then((res) => res.json())
            .then(function (data) {
                if (Object.keys(data).length === 0) {
                    console.log("no data");
                } else {
                    const dateString = data.invoice_date;
                    const formattedDateString =
                        dateString.replace(/[-:\s]/g, "") + "100000";
                    data.invoice_identifier = `${COMPANY_NIF}/wsl${COMPANY_NIF}00000/${formattedDateString}/${data.invoice_number}`;
                    data.customer_TIN = "";
                    data.invoice_date = data.invoice_date + " 10:00:00";
                    data.tp_fiscal_center = "DGC";

                    // Add invoice data to the array
                    invoiceDataArray.push(data);

                    // Store the invoice data in local storage
                    localStorage.setItem(
                        "invoices",
                        JSON.stringify(invoiceDataArray)
                    );

                    // Attempt to send the invoice immediately
                    // console.log(data);
                    addInvoice(data);
                }
            });
    }
}

/**
 * Send a single invoice by email
 * @param {number} facture_id - The ID of the invoice to send
 */
function sendSingleFacture(facture_id) {
    if (!facture_id) {
        swal({
            title: "Erreur",
            text: "ID de facture manquant",
            type: "error",
            timer: 3000,
            showConfirmButton: false,
        });
        return;
    }

    swal(
        {
            title: "Confirmation",
            text: "Êtes-vous sûr de vouloir envoyer cette facture par email?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Oui, envoyer",
            cancelButtonText: "Annuler",
            closeOnConfirm: false,
        },
        function (isConfirm) {
            if (isConfirm) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        try {
                            var response = JSON.parse(this.responseText);

                            if (response.success) {
                                swal(
                                    {
                                        title: "Succès",
                                        text: response.message,
                                        type: "success",
                                        timer: 3000,
                                        showConfirmButton: false,
                                    },
                                    function () {
                                        setTimeout(function () {
                                            document.location.reload();
                                        }, 500);
                                    }
                                );
                            } else {
                                var errorType = response.type || "error";
                                swal({
                                    title:
                                        errorType === "warning"
                                            ? "Attention"
                                            : "Erreur",
                                    text: response.message,
                                    type: errorType,
                                    timer: 4000,
                                    showConfirmButton: false,
                                });
                            }
                        } catch (e) {
                            // Fallback for non-JSON responses
                            swal({
                                title: "Erreur",
                                text:
                                    this.responseText ||
                                    "Erreur lors de l'envoi",
                                type: "error",
                                timer: 3000,
                                showConfirmButton: false,
                            });
                        }
                    }
                };

                xhttp.onerror = function () {
                    swal({
                        title: "Erreur réseau",
                        text: "Une erreur est survenue lors de l'envoi",
                        type: "error",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                };

                xhttp.open(
                    "GET",
                    "ajax/Sender/sendSingleFacture.php?facture_id=" +
                        facture_id,
                    true
                );
                xhttp.send();
            }
        }
    );
}

/**
 * Resend a previously sent invoice by email
 * @param {number} facture_id - The ID of the invoice to resend
 */
function resendSingleFacture(facture_id) {
    if (!facture_id) {
        swal({
            title: "Erreur",
            text: "ID de facture manquant",
            type: "error",
            timer: 3000,
            showConfirmButton: false,
        });
        return;
    }

    swal(
        {
            title: "Confirmation",
            text: "Êtes-vous sûr de vouloir renvoyer cette facture par email?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Oui, renvoyer",
            cancelButtonText: "Annuler",
            closeOnConfirm: false,
        },
        function (isConfirm) {
            if (isConfirm) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        try {
                            var response = JSON.parse(this.responseText);

                            if (response.success) {
                                swal(
                                    {
                                        title: "Succès",
                                        text: response.message,
                                        type: "success",
                                        timer: 3000,
                                        showConfirmButton: false,
                                    },
                                    function () {
                                        setTimeout(function () {
                                            document.location.reload();
                                        }, 500);
                                    }
                                );
                            } else {
                                var errorType = response.type || "error";
                                swal({
                                    title:
                                        errorType === "warning"
                                            ? "Attention"
                                            : "Erreur",
                                    text: response.message,
                                    type: errorType,
                                    timer: 4000,
                                    showConfirmButton: false,
                                });
                            }
                        } catch (e) {
                            // Fallback for non-JSON responses
                            swal({
                                title: "Erreur",
                                text:
                                    this.responseText ||
                                    "Erreur lors de l'envoi",
                                type: "error",
                                timer: 3000,
                                showConfirmButton: false,
                            });
                        }
                    }
                };

                xhttp.onerror = function () {
                    swal({
                        title: "Erreur réseau",
                        text: "Une erreur est survenue lors de l'envoi",
                        type: "error",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                };

                // Use the same sender endpoint; include a query param to indicate this is a resend
                xhttp.open(
                    "GET",
                    "ajax/Sender/sendSingleFacture.php?facture_id=" +
                        facture_id +
                        "&resend=1",
                    true
                );
                xhttp.send();
            }
        }
    );
}
