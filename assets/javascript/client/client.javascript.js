function saveClient(genre,adrs,type,location,langue,nif,note,etat)
{
    var url = $('#url').val();
    var iduser = $('#iduser').val();
    //var userName = $('#userName').val();
    var profil_name = $('#profil_name').val();
    //var tousphone = '';
    //var tousemail = '';
    var pers_cont ;
    var nom;
    var tva = 'non'; 
    var erreur = ''; 
    //alert(nom+'/ '+mail+' /'+adrs+'/ '+phone+'/  '+pers_cont+' /'+note+'/type'+type+' /'+location+'/ '+langue+'/'+nif+nbphone+nbemail);
    if (type == "paying") 
    {
         swal({   
            title: "",   
            text: "ce client doit avoir un contrat pour avoir ce type *",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else if (genre == "" || type == "" || adrs == "")
    {
        swal({   
            title: "",   
            text: "vous devez remplir tous les champs en *",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        var nom = $('#nom').val();
        var pers_cont = $('#pers_cont').val();
        var email = '';
        /*for (var i = 1; i < parseInt(nbphone)+1; i++) 
        {
            if ($('#phone'+i).val() != "") 
            {
                tousphone += $('#phone'+i).val()+'/';
            }
        }*/
        var phone_mobile = $('#phone_mobile').val();
        var phone_fixe = $('#phone_fixe').val();
        /*if (nbphone == 1) 
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
        }*/
        //else tousphone = '+'+phone;
        /*for (var i = 1; i < parseInt(nbemail)+1; i++) 
        {
            if ($('#email'+i).val() != '' && validateEmail($('#email'+i).val())) 
            {
                tousemail += $('#email'+i).val()+',';
            }
            else
            {
                erreur = 'verifier bien le format de l\'adresse mail';
                break;
            } 
        }*/
        if ($('#email').val() != '') 
        {
            if(validateEmail($('#email').val()))
                email = $('#email').val();
            else 
                erreur = 'verifier bien le format de l\'adresse mail';
        }
        /*if (nbemail == 1) 
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
                tousemail += ','+$('#email2').val();
            }
        }
        else if (nbemail == 3) 
        {
            //tousemail = mail;
            if ($('#email1').val() != "") 
            {
                tousemail += ','+$('#email1').val();
            }
            if ($('#email2').val() != "") 
            {
                tousemail += ','+$('#email2').val();
            }
            if ($('#email3').val() != "") 
            {
                tousemail += ','+$('#email3').val();
            }
        }*/
        if (erreur == '') 
        {
            /*if(document.getElementById("tva").checked == true)
            {
                tva = 'oui';
            }*/
            //tousphone = tousphone.slice(0, -1);
            //tousemail = tousemail.slice(0, -1);
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
                        document.location.reload();
                        swal({   
                            text: "",   
                            title: "", 
                            type:"success",  
                            timer: 3000,   
                            showConfirmButton: false
                        });
                    }
                    else
                        swal({   
                            text: "Une erreur s'est produite",   
                            title: "", 
                            type:"error",  
                            timer: 3000,   
                            showConfirmButton: false
                        });
                    document.getElementById("rep").innerHTML = this.responseText;
                }
                /*document.location.reload();
                $('#nom').val('');
                $('#pers_cont').val('');
                $('#adrs').val('');
                $('#nif').val('');
                $('#note').val('');*/
            };               
            xhttp.open("GET","ajax/client/save_client.php?nom="+encodeURIComponent(nom)+"&mail="+email+"&adrs="+encodeURIComponent(adrs)+"&phone_mobile="+phone_mobile+"&phone_fixe="+phone_fixe+"&pers_cont="+encodeURIComponent(pers_cont)+"&note="+encodeURIComponent(note)+"&type="+type+"&location="+location+"&langue="+langue+"&nif="+nif+"&tva="+tva+"&url="+url+"&profil_name="+profil_name+"&iduser="+iduser+"&etat="+etat+"&genre="+genre,true);
            xhttp.send(); 
        }
        else swal({
                title: "",   
                text: erreur,
                type:"error",  
                timer: 3000,   
                showConfirmButton: false 
            });
    }
}
function validateEmail(email) 
{
    var regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    return regex.test(email);
}
function recupererClients()
{
    var url = $('#url').val();
    var session_user = $('#session_user').val();
    var profil_name = $('#profil_name').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            $('#myTable').DataTable().destroy();
            document.getElementById("rep").innerHTML = this.responseText;
            $('#myTable').DataTable();
        }
    };
    xhttp.open("GET","ajax/client/recupererClients.php?url="+url+"&session_user="+session_user+"&profil_name"+profil_name,true);
    xhttp.send();
}
function recupererClientParType(type)
{
    document.getElementById('filtreClient').submit();
    /*$('#cond').val(type);
    var url = $('#url').val();
    var profil_name = $('#profil_name').val();
    var session_user = $('#iduser').val();
    //alert(profil_name);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            $('#myTable').DataTable().destroy();
            document.getElementById("rep").innerHTML = this.responseText;
            $('#myTable').DataTable();
        }
    };
    xhttp.open("GET","ajax/client/recupererClientParType.php?type="+type+"&url="+url+"&profil_name="+profil_name+"&session_user="+session_user,true);
    xhttp.send();*/
}
function updateClient(genre,idclient,nom,pers_cont,fixed_phone,mobile_phone,mail,langue,billing,adrs,type,newtype,location,nif,i,note,profil_name)
{

    //alert('ID :'+idclient+'/billing_number : -'+billing+'-/ nom : '+nom+'-/phone'+phone+'-/ mail /'+mail+'-/@: '+adrs+'-/ perscontact : '+pers_cont+' -/note :'+note+'- /:location '+location+'-/nif /'+nif+'-langue : '+langue+' -/tva: '+tva+' -/type : '+type+'/ -compteur/'+i+'-/new type'+newtype);
   // var tva = $('#tva'+compteur).val();
    var tva = 'non';
   /* if(document.getElementById("tva"+i).checked == true)
    {
        tva = 'oui';
        alert(tva);
    }
    else
    {
        alert(tva);
    }*/
    if (type != 'paying' && newtype == 'paying') 
    { 
      
        swal({   
            text: "ce client doit avoir un contrat pour avoir!",   
            title: "",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
     /* else if(type != 'paying' && billing !='')
      {
        alert('vous ne pouvez pas attribuer le billing');
      }*/
    else
    { 
        /*if(document.getElementById("tva"+i).checked == true)
        {
            tva = 'oui';
            //alert(tva);
        }*/
        //var profil_name = $('#profil_name').val();
        var url = $('#url').val();
        var iduser = $('#iduser').val();

        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                /*$('#myTable').DataTable().destroy();
                document.getElementById("rep").innerHTML = this.responseText;
                $('#myTable').DataTable();*/
                //document.getElementById("rep").innerHTML = this.responseText;
                var rep = String(this.responseText).trim();
                if (rep == '') 
                {
                    document.location.reload();
                    swal({   
                        text: "Modification réussie",   
                        title: "",  
                        type:"success", 
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                swal({   
                    text: "Une erreur s'est produite !",   
                    title: "",  
                    type:"error", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
                //document.getElementById("rep").innerHTML = this.responseText;
            }
        };                                                        
        xhttp.open("GET","ajax/client/updateClient.php?genre="+genre+"&idclient="+idclient+"&nom="+encodeURIComponent(nom)+"&pers_cont="+encodeURIComponent(pers_cont)+"&fixed_phone="+fixed_phone+"&mobile_phone="+mobile_phone+"&mail="+mail+"&langue="+langue+"&billing="+billing+"&adrs="+encodeURIComponent(adrs)+"&type="+newtype+"&location="+location+"&nif="+nif+"&note="+encodeURIComponent(note)+"&tva="+tva+"&url="+url+"&iduser="+iduser+"&profil_name="+profil_name,true);
        xhttp.send();
    }
}
function deleteClient(idclient)
{
    var url = $('#url').val();
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
            //document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/client/deleteClient.php?idclient="+idclient+"&url="+url+"&iduser="+iduser,true);
    xhttp.send();
}
function resetFiltreCustomerUnderContract()
{
    var WEBROOT = $('#webroot').val();
    document.location.href = WEBROOT+"customer_under_contract";
}
function resetFiltreFichierAttacher()
{
    var WEBROOT = $('#webroot').val();
    document.location.href = WEBROOT+"fichier_client";
}
function deleteFichierAttacher(idfichier,fileName)
{
    var root = $('#root').val();
    //alert('idfichier: '+idfichier+' fileName: '+fileName);
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
                    text: "Suppression réussie!",  
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
            //document.getElementById("rep_fichier_attacher").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/client/deleteFichierAttacher.php?idfichier="+idfichier+"&fileName="+fileName+"&root="+root,true);
    xhttp.send();
}
function detailClient(idclient)
{
    //alert(idclient);
    if (idclient != '') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("detailClient-body").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/client/detailClient.php?idclient="+idclient,true);
        xhttp.send();
    }
}
function filtreClient(nom_client,secteur,date1,date2,billing_number,profil_name)
{
   // alert(nom_client+' '+secteur+' '+date1+' '+date2+' '+billing_number+' '+profil_name);
    var url = $('#url').val();
    var session_user = $('#iduser').val();
    //var idclient = client.split(/-/)[1];
    if (typeof idclient == 'undefined') {idclient = '';}

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            $('#myTable').DataTable().destroy();
            document.getElementById("rep").innerHTML = this.responseText;
            $('#myTable').DataTable();
        }
    };
    xhttp.open("GET","ajax/client/filtreClient.php?nom_client="+nom_client+"&secteur="+secteur+"&date1="+date1+"&date2="+date2+"&billing_number="+billing_number+"&url="+url+"&session_user="+session_user+"&profil_name="+profil_name,true);
    xhttp.send();
}
function resetFiltreClient()
{
    //document.location.reload();
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"client";
}
function printFiltreClient()
{
    /*var cond = $('#cond').val();
    //alert(cond);
    if ($('#cond').val() == '') alert('Aucune donneé à imprimer!');
    else document.getElementById("filtreClient").submit();*/
    $('#print').val('1');
    $('#asExcel').val('0');
    document.getElementById("filtreClient").submit();
}
function exportFiltreClientAsExcel()
{
    $('#print').val('0');
    $('#asExcel').val('1');
    document.getElementById("filtreClient").submit();
}
function sendMailToClient(sujet,message,sendmode,sendsecteur)
{
    //alert('sujet: '+sujet+' message : '+message+' mode : '+sendmode+' secteur : '+sendsecteur);
    var sendForAll = 'no';
    if(document.getElementById("sendForAll").checked == true)
    {
        sendForAll = 'yes';
    }
    if (sujet == '' || message == '' || sendmode == '' || sendForAll == 'no') 
    {
        swal({   
            title: "",   
            text: "Veillez renseigner les champs en *",   
            type:"error",
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else if (sendmode == 'mail') 
    {
        document.getElementById('sendMailToClientForm').submit();
        /*var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                var msg = document.getElementById('sendmail-response');
                msg.style.color = 'green';
                msg.innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/client/sendMailToClient.php?sujet="+sujet+"&message="+message+"&sendmode="+sendmode+"&sendsecteur="+sendsecteur+"&sendForAll="+sendForAll,true);
        xhttp.send();*/
    }
}
function clientSoldeNegatif(n,webroot)
{
    if (n == 0) 
    {
        swal({   
            title: "",   
            text: "Aucun client",
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else document.location.href = webroot+'clientSoldeNegatif';
}
function ClientPartiAvecDette(n,webroot)
{
    if (n == 0) 
    {
        swal({   
            title: "",   
            text: "Aucun client",
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else document.location.href = webroot+'cPartiAvecDette';
}
function ClientPartiSansDette(n,webroot)
{
    if (n == 0) 
    {
        swal({   
            title: "",   
            text: "Aucun client",
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else document.location.href = webroot+'cPartiSansDette';
}
function differencier_client(genre)
{
    if (genre != '') 
    {
        if (genre == 'societe') 
        {
            document.getElementById("affiche_genre_client").innerHTML = '<div class="row">'
            +'<div class="col-lg-6 col-md-6">'
            +'<div class="form-group row">'
            +'<label for="exampleInputuname3" class="col-sm-3 control-label">societé*</label>'
            +'<div class="col-sm-9">'
            +'<div class="input-group">'
            +'<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>'
            +'<input type="text" maxlength="100" class="form-control" id="nom" placeholder="Nom complet">'
            +'</div>'
            +'</div>'
            +'</div>'
            +'</div>'
            +'<div class="col-lg-6 col-md-6">'
            +'<div class="form-group row">'
            +'<label for="exampleInputuname3" class="col-sm-3 control-label">Responsable de la societé</label>'
            +'<div class="col-sm-9">'
            +'<div class="input-group">'
            +'<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>'
            +'<input type="text" class="form-control" id="pers_cont">'
            +'</div>'
            +'</div>'
            +'</div>'
            +'</div>'
            +'</div>';
        }
        else
        {
            document.getElementById("affiche_genre_client").innerHTML = '<div class="row">'
            +'<div class="col-lg-6 col-md-6">'
            +'<div class="form-group row">'
            +'<label for="exampleInputuname3" class="col-sm-3 control-label">Nom complet*</label>'
            +'<div class="col-sm-9">'
            +'<div class="input-group">'
            +'<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>'
            +'<input type="text" maxlength="100" class="form-control" id="nom" placeholder="Nom complet">'
            +'</div>'
            +'</div>'
            +'</div>'
            +'</div>'
            +'<div class="col-lg-6 col-md-6">'
            +'<div class="form-group row">'
            +'<label for="exampleInputuname3" class="col-sm-3 control-label">Personne de contact</label>'
            +'<div class="col-sm-9">'
            +'<div class="input-group">'
            +'<div class="input-group-prepend"><span class="input-group-text"><i class="ti-user"></i></span></div>'
            +'<input type="text" class="form-control" id="pers_cont">'
            +'</div>'
            +'</div>'
            +'</div>'
            +'</div>'
            +'</div>';
        }
        /*var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("affiche_genre_client").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/client/distinguer_client.php?genre="+genre,true);
        xhttp.send();*/
    }
}
function nombreClient_gratuit_termineted()
{
    /*$('#cond').val(type);
    var url = $('#url').val();
    var profil_name = $('#profil_name').val();
    var session_user = $('#iduser').val();
    //alert(profil_name);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            $('#myTable').DataTable().destroy();
            document.getElementById("rep").innerHTML = this.responseText;
            $('#myTable').DataTable();
        }
    };
    xhttp.open("GET","ajax/client/recupererClientParType.php?type="+type+"&url="+url+"&profil_name="+profil_name+"&session_user="+session_user,true);
    xhttp.send();*/
    document.getElementById('printCustomer').submit();
}