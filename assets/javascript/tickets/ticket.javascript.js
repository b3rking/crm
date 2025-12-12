function saveTicket(idclient,type_ticket,probleme,description,idUser)
{
    var nbCaracteur = removeExtraSpace(description).length;
    if(description == "" || probleme == "" || idclient === null)
    {
        
        swal({
        title:"",
        text:"Veuillez remplir les champs en *",
        type:"error",
        timer:3000,
        showConfirmButton:false
    });
    }
    else if (nbCaracteur < 120) 
    {
        swal({
        text:"La description doit depasser 180 caracteres\n sans compter les espaces doubles",
        title:"",
        type:"success",
        timer:3000,
        showConfirmButton:false
    });
    }
    else 
    {
        var userName = $('#userName').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //msg = document.getElementById("msg");
                //msg.style.color = 'green';
                
               // msg.innerHTML = 'Ticket creer avec succes';
               var rep = String(this.responseText).trim();
                if (rep == "") 
                {
                    //document.getElementById("rep").innerHTML = this.responseText;
                    document.location.reload();
                    swal({   
                        text: "Creation reussie",   
                        title: "",
                        type:"success",   
                        timer: 1000,   
                        showConfirmButton: false 
                    });
                }
                else
                swal({   
                    text: "Une erreur s'est produite!",   
                    title: "",
                    type:"error",   
                    timer: 1000,   
                    showConfirmButton: false 
                });
                document.getElementById("rep").innerHTML = this.responseText;
                 
                /*$('#idclientCreerTicket').val('');
                //$('#dates').val('');
                $('#type_ticket').val('');
                $('#probleme').val('');
                //$('#con').val('');
                $('#description').val('');*/
            }
        };
        xhttp.open("GET","ajax/ticket/save_ticket.php?idclient="+idclient+"&probleme="+encodeURIComponent(probleme)+"&type_ticket="+type_ticket+"&description="+encodeURIComponent(description)+"&idUser="+idUser+"&userName="+userName,true);
        xhttp.send();
    }
}
function afficheToustickets()
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/ticket/afficheToustickets.php?",true);
    xhttp.send();
}
function recupereTousTicketParStatut(statut)
{
    $('#status_filtre').val(statut);
    document.getElementById('filtreTickets').submit();
    //document.getElementById('filtreTickets').innerHTML = this.responseText;
    /*var WEBROOT = $('#WEBROOT').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/ticket/recupereTousTicketParStatut.php?statut="+statut+"&WEBROOT="+WEBROOT,true);
    xhttp.send();*/
}
function removeExtraSpace(str)
{
    str = str.trim();
    str = str.replace(/[\s]{2,}/g," "); // Enlève les espaces doubles, triples, etc.
    //str = str.replace(/^[\s]/, ""); // Enlève les espaces au début
    //str = str.replace(/[\s]$/,""); // Enlève les espaces à la fin
    return str;    
}
function updateTickets(idticket,date_ticket,probleme,des_ticket,idclientupdateTicket)
{
    //alert(idticket+' ticket '+date_ticket+'  '+probleme+'  '+des_ticket+' idclient '+idclientupdateTicket);

    var nbCaracteur = removeExtraSpace(des_ticket).length;
    if(des_ticket === "" || probleme === "")
    {
        swal({
        title:"",
        text:"Veuillez remplir les champs recommander",
        type:"error",
        timer:3000,
        showConfirmButton:true
    });
    }
    /*else if (nbCaracteur < 160) 
    {
        
        swal({
        text:"",
        title:"La description doit depasser 159 caracteres\n sans compter les espaces doubles",
        type:"error",
        timer:3000,
        showConfirmButton:true
    });
    }*/
    else 
    {
       
        var userName = $('#userName').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {

                //document.getElementById("rep").innerHTML = this.responseText;
                var rep = String(this.responseText).trim();
                if (rep == "") 
                {
                    document.location.reload(); 
                    swal({   
                        text: "Modification reussie",   
                        title: "",
                        type:"success",   
                        timer: 1000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    swal({   
                        text: "Une erreur s'est produite",   
                        title: "",
                        type:"error",   
                        timer: 1000,   
                        showConfirmButton: false 
                    });
                } 
            }
        };
        xhttp.open("GET","ajax/ticket/modifier_ticket.php?idticket="+idticket+"&date_ticket="+date_ticket+"&probleme="+probleme+"&des_ticket="+des_ticket+"&userName="+userName+"&idclientupdateTicket="+idclientupdateTicket,true);
        xhttp.send();
    }
}
function deleteTicket(idticket)
{
    
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
                    text: "Suppression reussie",   
                    title: "",
                    type:"success",   
                    timer: 1000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                swal({   
                    text: "Une erreur s'est produite",   
                    title: "",
                    type:"error",   
                    timer: 1000,   
                    showConfirmButton: false 
                });
            }
            document.getElementById('rep').innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/ticket/supprimer_ticket.php?idticket="+idticket+"&userName="+userName,true);
    xhttp.send();
}
function fermerTicket(idticket,user,observation,endroit,type_ticket,idclient)
{
    var userName = $('#userName').val();
    var profil_name = $('#profil_name').val();
    var dernierAction = '';
    var erreur = '';
    if(document.getElementById("dernierAction").checked == true)
    {
        dernierAction = 'cocher';
    }
   /* if (profil_name == 'coordination' && dernierAction == 'cocher') 
    {
        if (endroit == 'Out_door') 
        {
            erreur += 'Vous ne pouvez pas fermer les tickes out door';
        }
    }*/
    if (observation == '') 
    {
        /*swal({
            title:"",
            text:"Veuillez entrer l'observation ! ",
            type:"error",
            timer:2000,
            showConfirmButton:true
        });*/
        erreur += 'Veuillez entrer l\'observation ';
    }
    if (erreur != '') 
    {
        swal({
            title:"",
            text:erreur,
            type:"error",
            timer:3000,
            showConfirmButton:false
        });
    }
    else
    {
        //if(document.getElementById("dernierAction").checked == true)
        //{
        
            if (type_ticket == 'installation') 
            {
                includefermerInstallation(idticket,user,observation,endroit,type_ticket,idclient,userName);
            }
            else if (type_ticket == 'demenagement') 
            {
                includeFermerDemenagement(idticket,user,observation,endroit,type_ticket,idclient,userName);
            }
            else if (type_ticket == 'augmentationBP' || type_ticket == 'diminutionBP') 
            {
                fermerTicketBandePassante(idticket,user,observation,endroit,type_ticket,idclient,userName);
            }
            else if (type_ticket == 'recuperation') 
            {
                includeFermerRecuperation(idticket,user,observation,endroit,type_ticket,idclient,userName);
            }
            else if (type_ticket == 'depannage' || type_ticket == 'pause' || type_ticket == 'coupure') 
            {
                var xhttp;
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function()
                {
                    /*if (this.readyState == 4) 
                    {
                        document.getElementById("rep").innerHTML = this.responseText;
                        swal({   
                            title: "",   
                            text: "",
                            type:"success",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                      location.reload();*/
                    var rep = String(this.responseText).trim();
                    if (rep == '') 
                    {
                        swal({   
                            text: "",   
                            title: "",
                            type:"success",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                        location.reload();
                    }
                    else
                        swal({   
                            text: "",   
                            title: "Une erreur s'est produite",
                            type:"error",   
                            timer: 5000,   
                            showConfirmButton: false 
                        });
                };
                xhttp.open("GET","ajax/ticket/fermerTicket.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&date_fermeture="+date_fermeture+"&dernierAction="+dernierAction+"&type_ticket="+type_ticket+"&idclient="+idclient+"&userName="+userName,true);
                xhttp.send();
            }
        /*}
        else
        {
            //alert('idticket: '+idticket+' user: '+user+' observation: '+observation+' endroit: '+endroit+' idclient: '+idclient);
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
                        swal({   
                            text: "",   
                            title: "",
                            type:"success",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                        location.reload();
                    }
                    else
                        swal({   
                            text: "",   
                            title: "Une erreur s'est produite",
                            type:"error",   
                            timer: 5000,   
                            showConfirmButton: false 
                        });
                }
            };
            xhttp.open("GET","ajax/ticket/fermerTicket.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&dernierAction="+dernierAction+"&userName="+userName,true);
            xhttp.send();
        }*/
    }
}
function fermerTicketBandePassante(idticket,user,observation,endroit,type_ticket,idclient)
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
                //document.getElementById("rep").innerHTML = this.responseText;
                document.location.reload();
                swal({
                    title:"",
                    text:"",
                    type:"success",
                    timer:3000,
                    showConfirmButton:false
                });
            }
            else
            {
                swal({
                    title:"",
                    text:"La date ne pas encore atteinte ",
                    type:"error",
                    timer:3000,
                    showConfirmButton:false
                });
            }
            //document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/ticket/fermerTicketBandePassante.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&dernierAction="+dernierAction+"&type_ticket="+type_ticket,true);
    xhttp.send();
}
function includefermerInstallation(idticket,user,observation,endroit,type_ticket,idclient,userName)
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/ticket/inclure_fermeture_ticket_Installation.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&type_ticket="+type_ticket+"&idclient="+idclient+"&userName="+userName,true);
    xhttp.send();
}
function includeFermerRecuperation(idticket,user,observation,endroit,type_ticket,idclient)
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/ticket/includeFermerRecuperation.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&type_ticket="+type_ticket+"&idclient="+idclient+"&userName="+userName,true);
    xhttp.send();
}
function includeFermerDemenagement(idticket,user,observation,endroit,type_ticket,idclient)
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/ticket/includeFermerDemenagement.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&type_ticket="+type_ticket+"&idclient="+idclient,true);
    xhttp.send();
}
function fermerInstallation(point_acces,antenne,routeur,switche,date_instal,userName,ip_address)
{
    //idticket,user,observation,endroit,date_fermeture,type_ticket,idclient
    var idticket = $('#idticket').val();
    var user = $('#user').val();
    var observation = $('#observation').val();
    var endroit = $('#endroit').val();
    var type_ticket = $('#type_ticket').val();
    var idclient = $('#idclient').val();

    //alert('Point : '+point_acces+' Ant :  '+antenne+' Rout : '+routeur+' switche : '+switche+' date_instal : '+date_instal+userName);
    if (point_acces == '' || ip_address == '' || routeur == '' || antenne == '') 
    {
        
        swal({
            title:"",
            text:"Veuillez remplir les champs en *",
            type:"success",
            timer:3000,
            showConfirmButton:false
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
                var res = String(this.responseText).trim();
                if (res == "") 
                {
                    document.location.reload();
                    swal({
                        title:"",
                        text:"",
                        type:"success",
                        timer:3000,
                        showConfirmButton:false
                    });
                }
                else
                    swal({
                        title:"",
                        text:"Une erreur s'est produite",
                        type:"error",
                        timer:3000,
                        showConfirmButton:false
                    });
                document.getElementById("rep").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/ticket/fermerInstallation.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&type_ticket="+type_ticket+"&idclient="+idclient+"&point_acces="+point_acces+"&antenne="+antenne+"&routeur="+routeur+"&switche="+switche+"&date_instal="+date_instal+"&userName="+userName+"&ip_address="+ip_address,true);
        xhttp.send();
    }
}
function fermerRecuperation()
{
    //idequipement,model,fabriquant,type_equipement,dateStock
    /*var nombreEquipement = $("input:checkbox:checked").length;
    if (nombreEquipement == 0) 
    {
       /* msg = document.getElementById("msg");
        msg.style.color = 'red';
        msg.innerHTML = 'Veuiller choisir l\'equipement à recuperer';*
        swal({
        title:"",
        text:"Veuillez choisir l'equipement à recuperer ",
        type:"error",
        timer:2000,
        showConfirmButton:true
    });
    }
    else
    {
        var idticket = $('#idticket').val();
        var user = $('#user').val();
        var observation = $('#observation').val();
        var endroit = $('#endroit').val();
        var type_ticket = $('#type_ticket').val();
        var idclient = $('#idclient').val();

        $("input:checkbox:checked").each(function()
        {
            nombreEquipement--;
            var i = $(this).val();
            var idequipement = $('#idequipement'+i).val();
            var model = $('#model'+i).val();
            var fabriquant = $('#fabriquant'+i).val();
            var type_equipement = $('#type_equipement'+i).val();
            var dateStock = $('#dateStock').val();
            
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    document.getElementById("rep").innerHTML = this.responseText;
                    swal({
                    title:"Recuperation faite avec success",
                    text:"Recuperation reussie",
                    type:"success",
                    timer:3000,
                    showConfirmButton:true
                    });
                }
            };
            xhttp.open("GET","ajax/ticket/fermerRecuperation.php?idequipement="+idequipement+"&model="+model+"&fabriquant="+fabriquant+"&type_equipement="+type_equipement+"&dateStock="+dateStock+"&user="+user+"&idticket="+idticket+"&observation="+observation+"&endroit="+endroit+"&type_ticket="+type_ticket+"&idclient="+idclient+"&nombreEquipement="+nombreEquipement,true);
            xhttp.send();
        });
        /*
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("rep").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/ticket/fermerRecuperation.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&date_fermeture="+date_fermeture+"&type_ticket="+type_ticket+"&idclient="+idclient,true);
        xhttp.send();*
    }*/
    
    var idticket = $('#idticket').val();
    var user = $('#user').val();
    var observation = $('#observation').val();
    var endroit = $('#endroit').val();
    var type_ticket = $('#type_ticket').val();
    var idclient = $('#idclient').val();

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rep").innerHTML = this.responseText;
            swal({
            title:"Recuperation faite avec success",
            text:"Recuperation reussie",
            type:"success",
            timer:3000,
            showConfirmButton:true
            });
        }
    };
    xhttp.open("GET","ajax/ticket/fermerRecuperation.php?user="+user+"&idticket="+idticket+"&observation="+observation+"&endroit="+endroit+"&type_ticket="+type_ticket+"&idclient="+idclient,true);
    xhttp.send();
}
function fermerDemenagement(point_acces)
{
    var idticket = $('#idticket').val();
    var user = $('#user').val();
    var observation = $('#observation').val();
    var endroit = $('endroit').val();
    var type_ticket = $('#type_ticket').val();
    var idclient = $('#idclient').val();
    //alert('Point : '+point_acces+' Rout : '+routeur+' switche : '+switche+' date_instal : '+date_instal);
    if (point_acces == '') 
    {
        /*msg = document.getElementById("msg");
        msg.style.color = 'red';
        msg.innerHTML = 'Veuiller entrer la station';*/
        swal({
        title:"",
        text:"veillez renseigner la station ",
        type:"error",
        timer:2000,
        showConfirmButton:true
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
                document.getElementById("rep").innerHTML = this.responseText;
                swal({
                    title:"Demenagement réussi",
                    text:"Le demenagement se fait avec success ",
                    type:"success",
                    timer:3000,
                    showConfirmButton:true
                });
            }
        };
        xhttp.open("GET","ajax/ticket/fermerDemenagement.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&type_ticket="+type_ticket+"&idclient="+idclient+"&point_acces="+point_acces,true);
        xhttp.send();
    }
}
function AffichageDetail_fermetureTicket(idticket)
{
    if (observation == "" || user == "")
    {
       // alert('vous devez remplir l\'observation et la date ');
         swal({
        title:"Attention",
        text:"vous devez remplir l'observation et la date ",
        type:"success",
        timer:3000,
        showConfirmButton:true
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
                document.getElementById("rep").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/ticket/fermerTicket.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&date_fermeture="+date_fermeture,true);
        xhttp.send();
    }
}
function filtreTicket(idticket,client,type_ticket,date1,date2)
{
    //alert("idticket "+idticket+" client: "+client+" type_ticket: "+type_ticket+" date1: "+date1+" date2: "+date2);
    var WEBROOT = $('#WEBROOT').val();
    var client = client.split(/-/);
    var idclient = client[1];
    if (typeof idclient == 'undefined') {idclient = '';}

    var condition1 = "";
    var condition2 = "";
    var condition3 = "";
    var condition4 = "";
    var condition5 = "";
    var condition = "";

    condition1 = (idticket == "" ? "" : " AND t.id="+idticket);
    condition2 = (idclient == "" ? "" : " AND t.customer_id="+idclient);
    condition3 = (type_ticket == "" ? "" : " AND t.ticket_type='"+type_ticket+"' ");
    condition4 = (date1 == "" ? date1 : " AND DATE(t.created_at)='"+date1+"' ");

    if (date2 == "") 
    {
        $condition5 = "";
    }
    else
    {
        if (date1 !== "") 
        {
            condition5 = " AND DATE(t.created_at) BETWEEN '"+date1+"' AND '"+date2+"'";
            condition4 = '';
        }
        else condition4 = " AND DATE(t.created_at)='"+date2+"' ";
    }

    /*condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);
    condition5 = (condition5 == '' ? '' : 'AND' +condition5);*/

    condition = condition1+condition2+condition3+condition4+condition5;
    var l = $('#l').val();
    var c = $('#c').val();
    var m = $('#m').val();
    var s = $('#s').val();
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
    xhttp.open("GET","ajax/ticket/filtreTicket.php?condition="+condition+"&WEBROOT="+WEBROOT+"&l="+l+"&c="+c+"&m="+m+"&s="+s,true);
    xhttp.send();
}
function resetFiltreTicket()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"tickets";
}
function recupererTicketDunClient(idclient)
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
        xhttp.open("GET","ajax/ticket/recupererTicketDunClient.php?idclient="+idclient,true);
        xhttp.send();
    }
}
function genfiche_installation(selectCustomerToCreateFiche)
{
    if (selectCustomerToCreateFiche === null) 
    {
        swal({
            title:"",
            text:"Veuillez selectionner un client",
            type:"error",
            timer:3000,
            showConfirmButton:false
        });
    }  
    else document.getElementById("genficheinstallation").submit();
}
function genfiche_demenagement(dateDemenagement,new_adress,oldAdresse,form)
{
    //alert(dateDemenagement+" "+new_adress+" "+oldAdresse+" "+form);
    var selectCustomerToCreateFiche = $('#selectCustomerToCreateFiche').val();
    if (selectCustomerToCreateFiche === null || dateDemenagement === "" || new_adress == "") 
    {
         //alert('Veuillez filtrer d\'abord!');
        swal({
            title:"",
            text:"Veuillez remplir tous les champs",
            type:"error",
            timer:3000,
            showConfirmButton:false
        });
    }  
    else document.getElementById(form).submit();
}
function updateFiche_demenagement(dateDemenagement,new_adress,oldAdresse,form)
{
    //alert(dateDemenagement+" "+new_adress+" "+oldAdresse+" "+form);
    if (dateDemenagement === "" || new_adress == "") 
    {
         //alert('Veuillez filtrer d\'abord!');
        swal({
            title:"",
            text:"Veuillez remplir tous les champs",
            type:"error",
            timer:3000,
            showConfirmButton:false
        });
    }  
    else document.getElementById(form).submit();
}
/*function genfiche_recuperation(selectCustomerToCreateFiche,dateRecuperation)
{
    //alert(idclient_fiche_recup+" "+dateRecuperation+" "+toDay);
    if (selectCustomerToCreateFiche === null || dateRecuperation ==="" ) 
    {
         //alert('Veuillez filtrer d\'abord!');
        swal({
            title:"",
            text:"Veuillez remplir tous les champs",
            type:"error",
            timer:3000,
            showConfirmButton:false
        });
    }  
    else document.getElementById("ficheRecuperation").submit();
}*/
function genfiche_recuperation(idclient,dateRecuperation,form,status)
{
    //alert(idclient+" "+dateRecuperation+" "+form);
    if (idclient === "" || dateRecuperation ==="" || status === "") 
    {
         //alert('Veuillez filtrer d\'abord!');
        swal({
            title:"",
            text:"Veuillez remplir tous les champs en *",
            timer:3000,
            showConfirmButton:false
        });
    }  
    else document.getElementById(form).submit(); 
}
function genfiche_bandepsante(selectCustomerToCreateFiche,bandepassante,datedebut,datefin)
{
    //alert(idclient_bandepassante+" "+bandepassante+" "+datedebut+" "+datefin);
    if (selectCustomerToCreateFiche === null || bandepassante ==="" || datedebut  === "" || datefin ==="") 
    {
        swal({
            title:"",
            text:"Veuillez comletez tout les champs en *",
            type:"error",
            timer:3000,
            showConfirmButton:false
        });
    } 
    else document.getElementById("ficheBD").submit();
}
function submitTicketOuvertEtFermer(etat,webroot)
{
    if (etat == 'ouvert') 
        document.location.href = webroot+'filtreTickets?idticket=&nom_client=&type_ticket=&date1=&date2=&status=ouvert&print=0';
    else document.location.href = webroot+'filtreTickets?idticket=&nom_client=&type_ticket=&date1=&date2=&status=fermer&print=0';
}
function modifier_details_client(ref,informaticien,date_description,endroit,description)
{
    //alert('num ref : '+ref+'/ user :'+informaticien+'/date '+date_description+'/endroit'+endroit+' /description/'+description);
 
    if(ref === "" || informaticien === "" || date_description === "" || endroit ==="" || description ==="")
    {
        swal({
            title:"",
            text:"Veuillez remplir tout les champs ",
            type:"error",
            timer:3000,
            showConfirmButton:true
        });
    }
    else 
    {
       
        var userName = $('#userName').val();
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
                        text: "Modification reussie",   
                        title: "",
                        type:"success",   
                        timer: 1000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    swal({   
                        text: "Une erreur s'est produite",   
                        title: "",
                        type:"error",   
                        timer: 1000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/ticket/description_Ticket.php?ref="+ref+"&informaticien="+informaticien+"&date_description="+date_description+"&endroit="+endroit+"&userName="+userName+"&description="+description,true);
        xhttp.send();
    }

}
function supprimeDescription(ref)
{
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
                    text: "Suppression reussie",   
                    title: "",
                    type:"success",   
                    timer: 1000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                swal({   
                    text: "Une erreur s'est produite",   
                    title: "",
                    type:"error",   
                    timer: 1000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/ticket/supprimer_description.php?ref="+ref+"&userName="+userName,true);
    xhttp.send();
}

function genfiche_diminution_bp(selectCustomerToCreateFiche,bandepassante,datedebut,datefin)
{
    //alert(idclient_bandepassante+" "+bandepassante+" "+datedebut+" "+datefin);
    if (selectCustomerToCreateFiche === null || bandepassante ==="" || datedebut  === "" || datefin ==="") 
    {
        swal({
            title:"",
            text:"Veuillez comletez tout les champs en *",
            type:"error",
            timer:3000,
            showConfirmButton:false
        });
    } 
    else document.getElementById("fiche_diminuerbp").submit();
}

function submitRapportticket()
{
    /*var cond = $('#cond').val();
    if ($('#cond').val() == '') alert('Veuillez filtrer d\'abord!');
    else document.getElementById("filtreTickets").submit();
    //document.location.href = "/crm.spidernet/report_fact?cond="+cond;*/
    $('#print').val(1);
    document.getElementById('filtreTickets').submit();
}

const selectCustomerTicket = document.getElementById('selectCustomerTicket');
if(selectCustomerTicket === null){}
else
{
    const options = Array.from(selectCustomerTicket.options);
    const input = document.getElementById('seachCustomerTicket');
    function findMatches (search, options) 
    {
        return options.filter(option => {
          const regex = new RegExp(search, 'gi');
          return option.text.match(regex);
        });
    }

    function filterOptions () 
    {
        options.forEach(option => { 
          option.remove();
          option.selected = false;
        });
        const matchArray = findMatches(this.value, options);
        selectCustomerTicket.append(...matchArray);
    }

    input.addEventListener('keyup', filterOptions);
}