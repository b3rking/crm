
function saveContract()
{
    var typecontract = 'service';
    var monnaie_contract = $('#monnaie_contract').val();
    var monnaie_facture = $('#monnaie_facture').val();
    var mode = $('#mode').val();
    var etat = $('#etat').val();
    var idclient = $('#idclient').val();
    var facturation = $('#facturation').val();
    var startDate = $('#startDateInclu').val();
    var tva = $('#tvaInclu').val();
    var profil = $('#profil').val();
    var nbServiceContract = parseInt($('#nbServiceContract').val());
    //alert(typecontract+' '+monnaie_contract+' '+monnaie_facture+' '+mode+' '+etat+' '+idclient+' '+facturation+' '+startDate+' '+tva);
    var show_rate = 'non';
    var enable_discount = 0;
    var show_on_invoice = 0;
    var contract_services = '';
    if (idclient == '' || tva == '' || profil == '') 
    {
        //alert('Les champs en * doivent etre remplis');
        swal({   
            title: "",   
            text: "vous devez remplir tous les champs en *", 
            type:"error",  
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        if (document.getElementById('show_rate').checked == true) 
            show_rate = 'oui';
        if (document.getElementById('enable_discount').checked == true) 
            enable_discount = 1;

        for (var i = 1; i < nbServiceContract+1; i++) 
        {
            var service = $('#serviceInclu'+i).val();
            var bandepassante = ($('#bandepassanteInclu'+i).val() == '' ? 'null' : $('#bandepassanteInclu'+i).val());
            var montant = $('#montantInclu'+i).val();
            var quantite = $('#quantite'+i).val();
            var nom_client = ($('#nom_client'+i).val() == '' ? 'null' : $('#nom_client'+i).val());
            var adresse = ($('#adresse'+i).val() == '' ? 'null' : $('#adresse'+i).val());

            if (document.getElementById('show_on_invoice'+i).checked == true)
                show_on_invoice = 1;
            var service_status = $('#contract_service_status'+i).val();
            
            if (service == '' || montant == '' || quantite == '') 
            {
                swal({   
                    title: "",   
                    text: "vous devez remplir tous les champs en *", 
                    type:"error",  
                    timer: 2000,   
                    showConfirmButton: false 
                });
                contract_services = '';
                break;
            }
            contract_services += service+'_'+bandepassante+'_'+montant+'_'+quantite+'_'+encodeURIComponent(nom_client)+'_'+encodeURIComponent(adresse)+'_'+show_on_invoice+'_'+service_status+'}';
            //alert('contract_services: '+contract_services);
            enable_discount = 0;
        }
        
        if (contract_services == '') 
        {
            swal({   
                title: "",   
                text: 'Veuillez verifier les champs en *',
                type:"error",   
                timer: 3000,   
                showConfirmButton: false 
            });
        }
        else
        {
            //var userName = $('#userName').val();
            var iduser = $('#iduser').val();
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("rep").innerHTML = this.responseText;
                    var rep = String(this.responseText).trim();
                    if (rep == '') 
                    {
                        /*msgError = document.getElementById("msg");
                        msgError.style.color = 'red';
                        msgError.innerHTML = 'Duplication de numero de contract';*/
                        document.location.reload();
                        swal({   
                            title: "",   
                            text: "Creation reussie",  
                            type: "success",
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    else
                    {
                        /*msgError = document.getElementById("msg");
                        msgError.style.color = 'green';
                        msgError.innerHTML = 'Le contract cree avec succes';*/
                        swal({   
                            title: "",   
                            text: "Une erreur s'est produite",
                            type:"error",   
                            timer: 2000,   
                            showConfirmButton: false 
                        });
                            
                        //document.getElementById("rep").innerHTML = this.responseText;
                    }
                }
            };
            xhttp.open("GET","ajax/contract/saveContract.php?typecontract="+typecontract+"&monnaie_contract="+monnaie_contract+"&monnaie_facture="+monnaie_facture+"&mode="+mode+"&etat="+etat+"&idclient="+idclient+"&facturation="+facturation+"&contract_services="+contract_services+"&startDate="+startDate+"&tva="+tva+"&profil="+profil+"&iduser="+iduser+"&show_rate="+show_rate+"&enable_discount="+enable_discount,true);
            xhttp.send();
        }
    }
}
function raportContract()
{
    //var cond = $('#cond').val();
    //if ($('#cond').val() == '') alert('Veuillez filtrer d\'abord!');
    //else document.getElementById("forem-reportFact").submit();
    //document.location.href = "/crm.spidernet/report_fact?cond="+cond;
    $('#print').val(1);
    document.getElementById('filtreContract').submit();
}

n = 1;
function ajoutServiceToContract()
{
    n++;
    //Conteneur.removeChild(Conteneur.childNodes[i]);
    var action = 'create';
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("service_contener").innerHTML += this.responseText;
            document.getElementById('nbServiceContract').value = n;
        }
    };
    xhttp.open("GET","ajax/contract/includeServiceOnCreerContract.php?n="+n+"&action="+action,true);
    xhttp.send();
}
function supServiceToContract()
{
    var nbservice = $('#nbServiceContract').val();
    if (nbservice > 1) 
    {
        var service_contener = document.getElementById('service_contener');
        service_contener.removeChild(service_contener.childNodes[nbservice-2]);
        n--;
        document.getElementById('nbServiceContract').value = n;
    }
}
function ajoutServiceToUpdateContract(idcontract,i)
{
    //Conteneur.removeChild(Conteneur.childNodes[i]);
    var nbServiceContract = $('#nombreServiceUpdate'+i).val();
    var j = parseInt(nbServiceContract)+1;
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("service_contener"+i).innerHTML += this.responseText;
            document.getElementById('nombreServiceUpdate'+i).value = j;
        }
    };
    xhttp.open("GET","ajax/contract/includeServiceOnUpdateContract.php?n="+j+"&idcontract="+idcontract,true);
    xhttp.send();
}
function addChildCustomerToParent(parent_customer,children_customers)
{
    if (parent_customer === null || children_customers === null) 
    {
        swal({   
            title: "",   
            text: "Veuillez remplir les champs en *",
            type:"error",   
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                var rep = String(this.responseText).trim();
                if (rep == '') 
                {
                    document.location.reload();
                    swal({   
                        title: "",   
                        text: "",
                        type:"success",   
                        timer: 2000,   
                        showConfirmButton: false 
                    });
                }
                else
                    swal({   
                        title: "",   
                        text: "Une erreur est survenue",
                        type:"error",   
                        timer: 2000,   
                        showConfirmButton: false 
                    });
            }
        };
        xhttp.open("GET","ajax/contract/addChildCustomerToParent.php?parent_customer="+parent_customer+"&children_customers="+children_customers,true);
        xhttp.send();
    }
}
function deleteChildCustomerToParent(child_id)
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            var rep = String(this.responseText).trim();
            if (rep == '') 
            {
                document.location.reload();
                swal({   
                    title: "",   
                    text: "",
                    type:"success",   
                    timer: 2000,   
                    showConfirmButton: false 
                });
            }
            else
                swal({   
                    title: "",   
                    text: "Une erreur est survenue",
                    type:"error",   
                    timer: 2000,   
                    showConfirmButton: false 
                });
        }
    };
    xhttp.open("GET","ajax/contract/deleteChildCustomerToParent.php?child_id="+child_id,true);
    xhttp.send();
}
/*function creerfichier_client(idclientOnContract,nom,fichier,userfile,datecreation)
{
   
    var idclientOnContract = idclientOnContract.split(/-/);
    var idclientOnContract =idclientOnContract[1];
    //alert(idclientOnContract+' '+nom+' '+fichier+' '+userfile+' '+datecreation);

    if(idclientOnContract === "" || nom === "" || fichier === "" || userfile === "" || datecreation === "" )
    {
        alert('vous devez remplir tous les champs');
    }
    else 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("save").innerHTML = this.responseText;
                     document.getElementById("rep").innerHTML = this.responseText;
                                swal({   
                                    title: "Information!", 
                                    type:"success" , 
                                    text: "Fichier cree avec reussie",   
                                    timer: 3000,   
                                    showConfirmButton: false 
                                });
                            $('#idclientOnContract').val('');
                            $('#nom').val('');
            };
        xhttp.open("GET","ajax/contract/fichier_client_contract.php?idclientOnContract="+idclientOnContract+"&nom="+nom+"&fichier="+fichier+"&userfile="+userfile+"&datecreation="+datecreation,true);
        xhttp.send();
    }
}*/
function updateFichierAttacher(idfichier,nom_fichier,fichier)
{
    //alert('idfichier: '+idfichier+' nom_fichier: '+nom_fichier+' fichier: '+fichier);
    /*var root = $('#webroot').val();
    if(nom_fichier === "" )
    {
        alert('Veuillez donner le nom du fichier');   
    }
    else 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    document.getElementById("rep_fichier_attacher").innerHTML = this.responseText;   
                }
            };
        xhttp.open("POST","ajax/contract/updateFichierAttacher.php?",true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send("idfichier="+idfichier+"&nom_fichier="+nom_fichier+"&fichier="+fichier+"&root="+root);
    }*/
}
function saveClientEnfant(nom,adrs,pers_cont,note,type_client,nbphone,nbemail,location,langue,nif,billing_number_parent,num_contract,service,bandepassante,id_parent,tva,monnaie,montant)
{
    /*var webroot = $('#WEBROOT').val();
    var tb = billing_number_parent.split(/-/);
    var billing_number_parent = tb[1];
    var tousphone = '';
    var tousemail = '';
    var assujettitva = 'non';
    var show_on_fact = 0;
    //alert(nom+' '+mail+' '+adrs+' '+phone+' '+pers_cont+' '+note+' '+type_client+' '+nbphone+' '+nbemail+' '+location+' '+langue+' '+nif+' '+billing_number_parent+' '+num_contract+' '+service+' '+bandepassante+' '+id_parent+' '+tva+' '+monnaie+' '+montant);
    if (nom == "" || montant == '' || bandepassante == '' || type_client == "" || adrs == "" || location == "" || billing_number_parent == "")
    {
        msg = document.getElementById("msg");
        msg.style.color = 'red';
        msg.innerHTML = 'vous devez remplir le nom, type, l\'adresse et localisation';
    }
    else 
    {
        service = service.split(/_/)[0];
        if (nbphone == 1) 
        {
            //tousphone = '+'+phone;
            if ($('#phone1').val() != "") 
            {
                tousphone += '+'+$('#phone1').val();
            }
        }
        else if(nbphone == 2)
        {
            //tousphone = '+'+phone;
            if ($('#phone1').val() != "") 
            {
                tousphone += '+'+$('#phone1').val();
            }
            if ($('#phone2').val() != "") 
            {
                tousphone += '/+'+$('#phone2').val();
            }
        }
        else if (nbphone == 3) 
        {
            //tousphone = '+'+phone;
            if ($('#phone1').val() != "") 
            {
                tousphone += '+'+$('#phone1').val();
            }
            if ($('#phone2').val() != "") 
            {
                tousphone += '/+'+$('#phone2').val();
            }
            if ($('#phone3').val() != "") 
            {
                tousphone += '/+'+$('#phone3').val();
            }
        }
        //else tousphone = '+'+phone;
        if (nbemail == 1) 
        {
            //tousemail = mail;
            if ($('#email1').val() != "") 
            {
                tousemail += $('#email1').val();
            }
        }
        else if(nbemail == 2)
        {
            //tousemail = mail;
            if ($('#email1').val() != "") 
            {
                tousemail += $('#email1').val();
            }
            if ($('#email2').val() != "") 
            {
                tousemail += '/'+$('#email2').val();
            }
        }
        else if (nbemail == 3) 
        {
            //tousemail = mail;
            if ($('#email1').val() != "") 
            {
                tousemail += '/'+$('#email1').val();
            }
            if ($('#email2').val() != "") 
            {
                tousemail += '/'+$('#email2').val();
            }
            if ($('#email3').val() != "") 
            {
                tousemail += '/'+$('#email3').val();
            }
        }
        //else tousemail = mail;
        if (tousphone == '') 
        {
            msg = document.getElementById("msg");
            msg.style.color = 'red';
            msg.innerHTML = 'vous devez donneer au-moins un numero de telephone';
        }
        else
        {
            if(document.getElementById("assujettitva").checked == true)
            {
                assujettitva = 'oui';
            }
            if(document.getElementById("show_on_fact").checked == true)
            {
                show_on_fact = 1;
            } 
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    document.getElementById("nom").value = '';
                    //document.getElementById("email").value = '';
                    document.getElementById("adrs").value = '';
                    //document.getElementById("phone").value = '';
                    document.getElementById("pers_cont").value = '';
                    document.getElementById("note").value = '';
                    document.getElementById("type_client").value = '';
                    msg = document.getElementById("msg");
                    msg.style.color = 'green';
                    msg.innerHTML = 'Le client a été ajouter avec succes';
                    document.getElementById("rep").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET","ajax/client/save_clientEnfant.php?nom="+nom+"&mail="+tousemail+"&adrs="+adrs+"&phone="+tousphone+"&pers_cont="+pers_cont+"&note="+note+"&type="+type_client+"&location="+location+"&langue="+langue+"&nif="+nif+"&assujettitva="+assujettitva+"&billing_number_parent="+billing_number_parent+"&num_contract="+num_contract+"&service="+service+"&bandepassante="+bandepassante+"&montant="+montant+"&id_parent="+id_parent+"&tva="+tva+"&monnaie="+monnaie+"&show_on_fact="+show_on_fact,true);
            xhttp.send();
        }
    }*/
}
function updateContract(numero,monnaie,monnaie_facture,mode,etat,client,facturation,startDate,tva,i,id_dernierService,profil)
{
    var webroot = $('#WEBROOT').val();
    var nombreService = $('#nombreServiceUpdate'+i).val();
    var y = id_dernierService - nombreService;
    var show_rate = 'non';
    var enable_discount = 0;
    var show_on_invoice = 0;
    var contract_services = '';

    if (document.getElementById('show_rate'+i).checked == true) 
        show_rate = 'oui';
    if (document.getElementById('enable_discount'+i).checked == true) 
        enable_discount = 1;
    
    //alert('nombreService = '+nombreService+' id_dernierService = '+y);
    //alert(numero+' '+typecontract+' '+monnaie+' '+mode+' '+etat+' '+client+' '+facturation+' '+startDate+' '+tva);
    for (var j = 0; j < nombreService; j++) 
    {
        y=j+1;
        var id = $('#serviceinclu_id'+numero+y).val();
        var service_id = $('#service'+numero+y).val();
        var bandepassante = ($('#bandepassante'+numero+y).val() == '' ? 'null' : $('#bandepassante'+numero+y).val());
        var montant = $('#montant'+numero+y).val();
        var quantite = $('#quantite'+numero+y).val();
        //var sous_client = $('#sous_client'+numero).val();
        var nom_client = ($('#nom'+numero+y).val() == '' ? 'null' : $('#nom'+numero+y).val());
        var adresse = ($('#adress'+numero+y).val() == '' ? 'null' : $('#adress'+numero+y).val());
        var status_service = $('#satus_service'+numero+y).val();
        if (document.getElementById('show_on_facture'+numero+y).checked == true) 
        show_on_invoice = 1;

        if (montant == '' || quantite == '') 
        {
            swal({   
                title: "",   
                text: "vous devez remplir tous les champs en *", 
                type:"error",  
                timer: 2000,   
                showConfirmButton: false 
            });
            contract_services = '';
            break;
        }
        contract_services += id+'_'+service_id+'_'+bandepassante+'_'+montant+'_'+quantite+'_'+encodeURIComponent(nom_client)+'_'+encodeURIComponent(adresse)+'_'+show_on_invoice+'_'+status_service+'}';
        //alert('id: '+id+' nom_client: '+nom_client+' adresse: '+adresse+' bandepassante: '+bandepassante+' montant: '+montant+' service_status: '+status_service+' quantite: '+quantite);
        //alert(contract_services);
        //enable_discount = 0;
    }
    if (contract_services == '') 
    {
        swal({   
            title: "",   
            text: 'Veuillez verifier les champs en *',
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var iduser = $('#iduser').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                var rep = String(this.responseText).trim();
                if (rep == '') 
                {
                    document.location.reload();
                    swal({   
                        title: "",   
                        text: "Modification reussie",  
                        type:"success", 
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite",  
                        type:"error", 
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                //document.getElementById('rep').innerHTML = this.responseText; 
            }
        };
        xhttp.open("GET","ajax/contract/updateContract.php?num_contract="+numero+"&monnaie="+monnaie+"&monnaie_facture="+monnaie_facture+"&mode="+mode+"&etat="+etat+"&tva="+tva+"&client_parent="+client+"&facturation="+facturation+"&startDate="+startDate+"&webroot="+webroot+"&iduser="+iduser+"&profil="+profil+"&show_rate="+show_rate+"&enable_discount="+enable_discount+"&contract_services="+contract_services,true);
        xhttp.send();
    }
}
function deleteContract(num_contract)
{
    var webroot = $('#WEBROOT').val();
    var iduser = $('#iduser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            var rep = String(this.responseText).trim();
            if (rep == "") 
            {
                document.location.reload();
                swal({   
                    title: "",   
                    text: "Suppression reussie",  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite",  
                    type:"error", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            //document.getElementById('rep').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/contract/deleteContract.php?num_contract="+num_contract+"&webroot="+webroot+"&iduser="+iduser,true);
    xhttp.send();
}
function recupererServices(service) 
{
    //alert(service.id);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById(service.id).innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/contract/returnOptionDeService.php?",true);
    xhttp.send();
}
function genererFicheInstallation()
{
    alert('ok');
}
function supprimer_file(del_file)
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById('rep').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/contract/supprimer_file_client.php?del_file="+del_file,true);
    xhttp.send();
}

function saveCautionClient(idclientCaution,montant_caution,monnaie_caution,date_caution,user_creer_caution,note)
{
        var idclientCaution = idclientCaution.split(/-/);
        var idclientCaution = idclientCaution[1];
    //alert(idclientCaution+'/'+montant_caution+'/'+monnaie_caution+'/'+date_caution+'/'+user_creer_caution+''+note);


    if (idclientCaution == "" || montant_caution == '' || monnaie_caution == "" || date_caution == "" || user_creer_caution == "" || note == "" )
    {
        //alert('vous devez remplir tous les champs');
        swal({
            title : "Attention",
            text: "vous devez remplir tous les champs",
            type:"error",
            timer:3000,
            showConfirmButton:false

        });
    }
    else 
    {
       // var prospect = prospect.split(/-/);
        //var idprospect = prospect[1];
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("rep").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Vous venez de creer une caution",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                $('#montant_caution').val('');
                $('#date_caution').val('');
            }
        };
        xhttp.open("GET","ajax/contract/creation_caution_client.php?idclientCaution="+idclientCaution+"&montant_caution="+montant_caution+"&monnaie_caution="+monnaie_caution+"&date_caution="+date_caution+"&user_creer_caution="+user_creer_caution+"&note="+note,true);
        xhttp.send();
    }
}
function filtre_contract(nom_client,service,datecreation,numero,billing_number)
{
    var webroot = $('#WEBROOT').val();
    var iduser = $('#iduser').val();
    //var idclientFiltre = idclientFiltre.split(/-/)[1];
    //alert(idclientFiltre+' service: '+service+' datecreation: '+datecreation);
 
    /*if (typeof idclientFiltre == 'undefined') 
    {
        idclientFiltre = '';
    }*/
    var condition1;
    var condition2; 
    var condition3;
    var condition4;
    var condition5;
    var condition;

    /*if (nom_client == '') 
    {
        condition1 = ''; 
    }
    else
    {
        condition1 = " cl.ID_client="+idclientFiltre+" ";
    }*/
    condition1 = nom_client == '' ? '' : " cl.nom_client LIKE '%"+nom_client+"%' ";
    /*if (service == '') 
    {
        condition2 = '';
    }
    else
    {
        condition2 = " s.ID_service="+service+" ";
    }*/
    condition2 = service == "" ? "" : " s.ID_service="+service+" ";
    /*if (datecreation == '') 
    {
        condition3 = '';
    }
    else
    {
        condition3 = " co.date_creation='"+datecreation+"' ";
    }*/
    condition3 = datecreation == "" ? "" : " co.date_creation='"+datecreation+"' ";
    condition4 = numero == "" ? "" : " co.numero="+numero+" ";
    condition5 = billing_number == "" ? "" : " cl.billing_number="+billing_number+" ";

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);
    condition5 = (condition5 == '' ? '' : 'AND' +condition5);
    
    condition = condition1+condition2+condition3+condition4+condition5;
    if (condition == '') 
    {
        swal({
            title:"",   
            text: "Aucune donneé filtreé",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                $('#myTable').DataTable().destroy(); 
                document.getElementById('rep').innerHTML = this.responseText;
                $('#myTable').DataTable();
            }
        };
        xhttp.open("GET","ajax/contract/filtre_contrat.php?condition="+condition+"&webroot="+webroot+"&iduser="+iduser,true);
        xhttp.send();
    }
}

function resetFiltreContract()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"contract";
}

