function ajouterStock(model,type_equipement,mac,user,date_ajout,description) 
{
    var number = $('#number').val();
    var userName = $('#userName').val();
    var usage = '';
    var nbPort = 1;
    var erreur = '';
    var val = type_equipement.split(/-/);
    type_equipement = val[0];
    //alert('model: '+model+' type_equipement: '+type_equipement+' mac: '+mac+' date_ajout: '+date_ajout+' user: '+user+' description: '+description);
    if (model == '' || mac == '' || date_ajout == '') 
    {
        swal({   
            title: "",   
            text: "Veillez remplir les champs en *",
            type:"error",   
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        if (number > 0) 
        {
            nbPort = $('#port').val();
            if (nbPort == '' || nbPort <= 0) 
                erreur = "Veillez entrer le nombre de port";
        }
        if (erreur == '') 
        {
            if (verifierMacAdress(mac))
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
                                text: "Creation reussie",
                                type:"success",   
                                timer: 2000,   
                                showConfirmButton: false 
                            });
                        }
                        else
                        {
                            document.getElementById("retourjs").innerHTML = this.responseText;
                            swal({   
                                title: "",   
                                text: "Une erreur s'est produite, soit l'adresse mas existe deja!",
                                type:"error",   
                                timer: 2000,   
                                showConfirmButton: false 
                            });
                        }
                        /*$('#model').val('');
                        $('#fabriquant').val('');
                        $('#mac').val('');*/
                    }
                };
                xhttp.open("GET","ajax/equipement/ajouterStock.php?model="+model+"&type_equipement="+type_equipement+"&mac="+mac+"&nbport="+nbPort+"&number="+number+"&date_ajout="+date_ajout+"&iduser="+user+"&userName="+userName+"&description="+description,true);
                xhttp.send();
            }
            else
            {
                //msg = document.getElementById("msg");
                //msg.style.color = 'red';
                //msg.innerHTML = 'l\'Adresse mac n\'est pas valide';
                swal({
                    title: "",   
                    text: "l'Adresse mac n'est pas valide",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
        else
        {
            //alert('Veillez entrer le nombre de port');
            swal({
                title: "",   
                text: erreur,
                type:"error",   
                timer: 3000,   
                showConfirmButton: false 
            });

        }
    }
}
function verifierMacAdress(mac)
{
    var regexp = /^(([A-Fa-f0-9]{2}[:]){5}[A-Fa-f0-9]{2}[,]?)+$/i;
    //var mac_address = "fa:09:91:d5:e4:5a";
    if(regexp.test(mac)) {
        return true;
    } else {
        return false;
    }
}
// Ajouter certains champs a l'interface selon le type d'equipement
function getTypeEquipement(type_equipement)
{
    if (type_equipement == 'routeur-mikrotik') 
    {
        document.getElementById("divIncludeRouteur").innerHTML = '<div class="col-md-12" id="element"><div class="form-group"><label class="control-label">Nombre de port</label><input type="text" id="port" class="form-control"></div></div>';
        document.getElementById("number").value = 1;
    }
    else if (type_equipement == 'switch') 
    {
        document.getElementById("divIncludeRouteur").innerHTML = '<div class="col-md-12" id="element"><div class="form-group"><label class="control-label">Nombre de port</label><input type="text" id="port" class="form-control"></div></div> <div class="col-md-12"><div class="form-group"><label class="control-label">Usage</label><select class="form-control custom-select" id="usage"><option value="secteur">Secteur</option><option value="client">Client</option><option value="prive">Privé</option></select></div></div>';
        document.getElementById("number").value = 2;
    }
    else
    {
        if ($('#number').val() == 2) 
        {
            var divIncludeRouteur = document.getElementById('divIncludeRouteur');
            divIncludeRouteur.removeChild(divIncludeRouteur.childNodes[0]);
            divIncludeRouteur.removeChild(divIncludeRouteur.childNodes[1]);
            document.getElementById("number").value = 0;
        }
        else if($('#number').val() == 1)
        {
            var divIncludeRouteur = document.getElementById('divIncludeRouteur');
            divIncludeRouteur.removeChild(divIncludeRouteur.childNodes[0]);
            document.getElementById("number").value = 0;
        }
    }
}

function NewSecteur(Code_secteur,nom_secteur,adrese_secteur,switch_ip)
{
   //alert(Code_secteur+' '+nom_secteur+' '+adrese_secteur);
    if (Code_secteur === "" || nom_secteur === "" || adrese_secteur === "" || switch_ip === "")
    {
        swal({   
            title: "",   
            text: "Veuillez remplir les champs en *",
            type:"warning",   
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        if (verifierIP(switch_ip)) 
        {
            //var userName = $('#userName').val();
            var iduser = $('#iduser').val();
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("reponse").innerHTML = this.responseText;
                    document.location.reload();
                    swal({   
                        title: "",   
                        text: "Creation reussie",
                        type:"success",   
                        timer: 2000,   
                        showConfirmButton: false 
                    });
                    /*$('#Code_secteur').val('');
                    $('#nom_secteur').val('');
                    $('#adrese_secteur').val('');*/
                    //location.reload();
                }
            };
            xhttp.open("GET","ajax/equipement/Save_secteur.php?Code_secteur="+Code_secteur+"&nom_secteur="+nom_secteur+"&adrese_secteur="+adrese_secteur+"&iduser="+iduser+"&switch_ip="+switch_ip,true);
            xhttp.send();
        }
        else
        {
            swal({   
                title: "",   
                text: "L'IP n'est pas correcte",
                type:"error",   
                timer: 2000,   
                showConfirmButton: false 
            });
        }
    }
}

function affiche_ToutSecteur()
{
    
    if (nom_secteur == "" || adrese_secteur == "")
    {
        alert('vous devez remplir le nom et adrese_secteur ');
    }
    else 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("reponse").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/Equipement/fermerTicket.php?idticket="+idticket+"&user="+user+"&observation="+observation+"&endroit="+endroit+"&date_fermeture="+date_fermeture,true);
        xhttp.send();
    }
} 
function supprimer_point_acces(nupa)
{
    var iduser = $('#iduser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("reponse").innerHTML = this.responseText;
            swal({   
                text: "",   
                title: "suppression reussie",
                type:"success",   
                timer: 3000,   
                showConfirmButton: false 
            });
        }
    };
    xhttp.open("GET","ajax/equipement/suppressionPA.php?nupa="+nupa+"&iduser="+iduser,true);
    xhttp.send();
}
function update_Secteur(id_secteur,code,nom_secteur,adrese_secteur,switch_ip)
{
    //alert('id_secteur: '+id_secteur+' code '+code+' nom: '+nom_secteur+'  adresse: '+adrese_secteur+' switch_ip: '+switch_ip);
    if (id_secteur === "" || code === "" || nom_secteur === "" || switch_ip === "")
    {
        swal({   
            text: "",   
            title: "Veillez remplir les champs en *!",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        if (verifierIP(switch_ip)) 
        {
            var userName = $('#userName').val();
            var iduser = $('#iduser').val();
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("reponse").innerHTML = this.responseText;
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
                    {
                        swal({   
                            text: rep,   
                            title: "",
                            type:"error",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    //location.reload();
                }
            };
            xhttp.open("GET","ajax/equipement/updateSecteur.php?id_secteur="+id_secteur+"&code="+code+"&nom_secteur="+nom_secteur+"&adrese_secteur="+adrese_secteur+"&switch_ip="+switch_ip+"&userName="+userName+"&iduser="+iduser,true);
            xhttp.send();
        }
        else
        {
            swal({   
                text: "L'IP n'est pas correcte",   
                title: "",
                type:"error",   
                timer: 3000,   
                showConfirmButton: false 
            });
        }
    }
}
function suppressionSecteur(id_secteur)
{
    var userName = $('#userName').val();
    var iduser = $('#iduser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            //document.getElementById("reponse").innerHTML = this.responseText;
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
            {
                swal({   
                    text: rep,   
                    title: "",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/equipement/deleteSecteur.php?id_secteur="+id_secteur+"&userName="+userName+"&iduser="+iduser,true);
    xhttp.send();
}
function newPoint_acces(secteurpa,nompa,ipa,macpa,antene_type_pa,frequence,ssidpa,ant_limite_pa,iduser)
{
 // alert(secteurpa+'/'+nompa+'/'+ipa+'/'+macpa+'/'+antene_type_pa+'/'+frequence+'/'+ssidpa+'/'+ant_limite_pa);
    if (secteurpa === "" || nompa === "" || ipa === "" /*|| macpa === ""*/ || antene_type_pa === "" || frequence === "" || ssidpa === "" || ant_limite_pa === "")
    {
        swal({   
            title: "",   
            text: "Veillez remplir les champs en *!",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        //var userName = $('#userName').val();
        if (verifierIP(ipa)) 
        {
            var val = antene_type_pa.split(/-/);
            var idAntenne = val[0];
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("save").innerHTML = this.responseText;
                    var rep = String(this.responseText).trim();
                    if (rep == 'Duplication de l\'IP') 
                    {
                        //msgError = document.getElementById("msgError");
                        //msgError.style.color = 'red';
                        //msgError.innerHTML = this.responseText;
                        swal({   
                            title: "",   
                            text: "Duplication de l'IP",
                            type:"error",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    else
                    {
                        msgError = document.getElementById("msgError");
                        //msgError.style.color = 'green';
                        //msgError.innerHTML = "Point d'acces ajouter avec succes. Vous pouvez maintenant fermer";
                        document.getElementById("reponse").innerHTML = this.responseText;
                        swal({   
                            title: "",   
                            text: "",
                            type:"success",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                        $('#nompa').val('');
                        $('#ipa').val('');
                        $('#macpa').val('');
                        $('#antene_type_pa').val('');
                        $('#frequence').val('');
                        $('#ssidpa').val('');
                        $('#ant_limite_pa').val('');
                    }
                }
            };
            xhttp.open("GET","ajax/equipement/Save_point_acces.php?secteurpa="+secteurpa+"&nompa="+nompa+"&ipa="+ipa+"&macpa="+macpa+"&idAntenne="+idAntenne+"&frequence="+frequence+"&ssidpa="+ssidpa+"&ant_limite_pa="+ant_limite_pa+"&iduser="+iduser,true);
            xhttp.send();                                                                                                                                                      
        }
        else
        {
            //span = document.getElementById("msg");
            //span.style.color = 'red';
            //span.innerHTML = 'adresse IP invalide : <strong>'+ipa+'</strong>';
            swal({   
                text: "",   
                title: "adresse IP invalide :",
                type:"error",   
                timer: 3000,   
                showConfirmButton: false 
            });
        }
    }
    
}
// Verifier l'ip le format de l'ip avant insertion de point d'acces
function verifierIP(ip)
{
    var regexp = /^(([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])$/;
    if(regexp.test(ip)) {
        return true;
    } else {
        return false;
    }
}
         
function update_point_acces(idpa,nompa,frequence,ipa,ant_limite_pa,ssidpa,mac_adress)
{ 
  //alert(idpa+nompa+frequence+ipa+ant_limite_pa+ssidpa+'   :>'+mac_adress);
    if (idpa == "" || nompa == "" || frequence == "" || ipa == "" || ant_limite_pa == "" || ssidpa === "" || mac_adress === "")
    {
        alert('vous devez remplir tout le champ');
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
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "suppression reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                document.location.reload();
            }
        };
        xhttp.open("GET","ajax/equipement/modifier_PA.php?idpa="+idpa+"&nompa="+nompa+"&frequence="+frequence+"&ipa="+ipa+"&ant_limite_pa="+ant_limite_pa+"&ssidpa="+ssidpa+"&iduser="+iduser+"&mac_adress="+mac_adress,true);
        xhttp.send();                                                                                                                                                                             

    }
}
/* Recuperer le mac d'une antenne sur la page point d'acces en choisissant l'antenne
*   et le mettre dans le champs mac
*/
function recupererMacAntenne(antene_type_pa)
{
    if (antene_type_pa != '') 
    {
        var val = antene_type_pa.split(/-/);
        document.getElementById("macpa").value = val[1];
    }
    else document.getElementById("macpa").value = "";
}
function ajouterCategorieAccessoire(categorie)
{
    //alert(categorie);
    if (categorie === "" )
    {
        //alert('vous devez definir une categorie');
        swal({   
            title: "",   
            text: "Veuillez entrer la categorie",
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
                var rep = String(this.responseText).trim();
                if (rep == '') 
                {
                    document.location.reload();
                    swal({   
                        title: "",   
                        text: "Creation reussie",  
                        type:"success", 
                        timer: 2000,   
                        showConfirmButton: false 
                    });
                    //$('#categorie').val('');
                }
                else
                {
                    swal({   
                        title: "!",   
                        text: "Une erreur s'est produite",   
                        timer: 3000,  
                        type:"success" ,
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/equipement/NewCategorie.php?categorie="+categorie,true);
        xhttp.send();
    }
}
function update_categorie_accessoire(categorie_id,categorie)
{
    if (categorie === "" )
    {
        //alert('vous devez definir une categorie');
        swal({   
            title: "",   
            text: "Veuillez entrer la categorie",
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
                var rep = String(this.responseText).trim();
                if (rep == '') 
                {
                    document.location.reload();
                    swal({   
                        title: "",   
                        text: "Creation reussie",  
                        type:"success", 
                        timer: 2000,   
                        showConfirmButton: false 
                    });
                    //$('#categorie').val('');
                }
                else
                {
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite",   
                        timer: 3000,  
                        type:"error" ,
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/equipement/updateCategorieAccessoire.php?categorie="+categorie+"&categorie_id="+categorie_id,true);
        xhttp.send();
    }
}
function deleteCategorieAccessoire(categorie_id)
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
                    text: "suppression reussie",  
                    type:"success", 
                    timer: 2000,   
                    showConfirmButton: false 
                });
                //$('#categorie').val('');
            }
            else
            {
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite",   
                    timer: 3000,  
                    type:"error" ,
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/equipement/deleteCategorieAccessoire.php?categorie_id="+categorie_id,true);
    xhttp.send();
}
function ajouterAccessoire(categorie_id,quantite,commentaire,date_entre)
{
    //alert(categorie_id+'   '+quantite+'     '+commentaire+'  '+date_entre);
                
    if (categorie_id === "" || quantite === "" || date_entre === "")
    {
        swal({   
            text: "Veuillez remplir les champs en *",   
            title: "",  
            type:"error", 
            timer: 5000,   
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
                if (rep === '') 
                {
                    //document.getElementById("rep").innerHTML = this.responseText;
                    document.location.reload();
                    swal({   
                        text: "Ajout reussie!",   
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
        };
        xhttp.open("GET","ajax/equipement/ajoutAccessoire.php?categorie_id="+categorie_id+"&quantite="+quantite+"&commentaire="+commentaire+"&iduser="+iduser+"&date_entre="+date_entre,true);
        xhttp.send();
    }
}
function updateEntrerAccessoire(categorie_id,quantite,commentaire,date_entre,id)
{
    //alert(categorie_id+'   '+quantite+'     '+commentaire+'  '+date_entre+' '+id);
                
    if (categorie_id === "" || quantite === "" || date_entre === "")
    {
        swal({   
            text: "Veuillez remplir les champs en *",   
            title: "",  
            type:"error", 
            timer: 5000,   
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
                if (rep === '') 
                {
                    //document.getElementById("rep").innerHTML = this.responseText;
                    document.location.reload();
                    swal({   
                        text: "Modification reussie!",   
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
                //document.getElementById("rep").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/equipement/updateEntrerAccessoire.php?categorie_id="+categorie_id+"&quantite="+quantite+"&commentaire="+commentaire+"&iduser="+iduser+"&date_entre="+date_entre+"&id="+id,true);
        xhttp.send();
    }
}
function submitRapportEntreeSortieAccessoir()
{
    $('#print').val(1);
    document.getElementById('filtreAccessoireForm').submit();
}
function resetFiltreAccessoire()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"accessoire";
}
function attribuer_accessoire(idclient,accessoire,quantite_entree,date_attribution,motif,user)
{
    //alert(idclient+' '+accessoire+' '+quantite);
    if (idclient === "" || accessoire === "" || quantite === "" || date_attribution == "")
    {
        //alert('vous devez remplir tout les champs');
        swal({   
            text: "Erreur!",   
            title: "vous devez remplir tout les champs",  
            type:"success", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        var msg = document.getElementById('msg');
        var accessoire = accessoire.split(/-/);
        var client = idclient.split(/-/);
        var idclient = client[1];
        var idaccessoire = accessoire[0];
        var quantite_stock = accessoire[1];
        if (parseInt(quantite_stock) < parseInt(quantite_entree)) 
        {
            msg.style.color = 'white';
            msg.innerHTML = 'La quantite entree depasse seule du stock';
            swal({   
                                    text: "Erreur!",   
                                    title: "La quantite entree depasse seule du stock",  
                                    type:"success", 
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
                    msg.style.color = 'white';
                    msg.innerHTML = this.responseText;
                                swal({   
                                    title: "Attribution reussie avec succes!",   
                                    text: "Attribution reussie avec succes",
                                    type:"success",   
                                    timer: 2000,   
                                    showConfirmButton: false 
                                });
                            $('#idclient').val('');
                            $('#accessoire').val('');
                            $('#quantite_entree').val('');
                            $('#date_attribution').val('');
                            $('#motif').val('');
                     location.reload();
                    //document.getElementById("rep").innerHTML = this.responseText;
                }
            };
            
            xhttp.open("GET","ajax/equipement/attribuer_accessoire.php?idclient="+idclient+"&accessoire="+idaccessoire+"&quantite="+quantite_entree+"&date_attribution="+date_attribution+"&motif="+motif+"&user="+user,true);
            xhttp.send();
        }
    }
}
function resetFiltreSortieAccessoire()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"sortie_accessoire";
}
function setAccessoire_user(destination,demander_par,accessoire,date_sortie,quantitesortie,motif,sortie_par)
{
    if (destination === "" || demander_par === "" || accessoire === "" || quantitesortie === "")
    {
        //alert('vous devez remplir tout les champs');
        swal({   //
            text: "Veuillez remplir les champs en *",   
            title: "",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var accessoire = accessoire.split(/-/);
        var categorie_id = accessoire[0];
        //var idaccessoire = accessoire[0];
        var quantite_stock = accessoire[1];
        //var categorie_id = accessoire[2];
        var destination_detail = null;
        if (parseInt(quantite_stock) < parseInt(quantitesortie)) 
        {
            swal({   
                text: "",   
                title: "La quantite entrée depasse celle du stock",  
                type:"error", 
                timer: 3000,   
                showConfirmButton: false 
            });
        }
        else
        {
            if (destination === 'client') 
                destination_detail = $('#selectCustomer0').val();
            else if (destination === 'relais') 
                destination_detail = $('#relais0').val();
            else if (destination == 'base')
                destination_detail = $('#point_acces0').val();
            else if (destination == 'vehicule')
                destination_detail = $('#vehicule0').val();
            
            var iduser = $('#iduser').val();
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //msg.style.color = 'white';
                    //msg.innerHTML = this.responseText;
                    var rep = String(this.responseText).trim();
                    if (rep == "") 
                    {
                        document.location.reload();
                        swal({   
                            title: "",   
                            text: "Traitement reussi",
                            type:"success",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    else
                    {
                        swal({   
                            title: "",   
                            text: "Une erreur s'est produite",
                            type:"error",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    document.getElementById("rep").innerHTML = this.responseText;
                }
            };
    
            xhttp.open("GET","ajax/equipement/sortie_Accessoire_stock.php?demander_par="+demander_par+"&quantitesortie="+quantitesortie+"&date_sortie="+date_sortie+"&motif="+motif+"&sortie_par="+sortie_par+"&categorie_id="+categorie_id+"&destination="+destination+"&destination_detail="+destination_detail+"&iduser="+iduser,true);
            xhttp.send();
        }
    }     
}
function filtreSortie_accessoire(demander_par,destination,date1,date2,mois,annee) 
{
    //alert('demander_par: '+demander_par+' destination: '+destination+' date1: '+date1+' date2: '+date2+' mois: '+mois+' annee: '+annee);

    var condition1 = ""; 
    var condition2 = "";
    var condition3 = "";
    var condition4 = "";
    var condition5 = "";
    var condition6 = ""; 
    var condition  = "";

    condition1 = (demander_par == "") ? "" : " AND demander_par ='"+demander_par+"'";
    condition2 = (destination == "") ? "" : " AND destination ='"+destination+"'";
    condition3 = (date1 == "") ? "" : " AND date_sortie='"+date1+"' ";
    
    if (date2 == '') 
    {
        condition4 = '';
    }
    else
    {
        if (date1 != '') 
        {
            condition4 = " AND date_sortie BETWEEN '"+date1+"' AND '"+date2+"'";
            condition3 = '';
        }
        else condition3 = " AND date_sortie='"+date2+"' ";
    }
    condition5 = (mois == "") ? "" : " AND MONTH(date_sortie)="+mois+" ";
    condition6 = (annee == "") ? "" : " AND YEAR(date_sortie)="+annee+" ";

    condition = condition1+condition2+condition3+condition4+condition5+condition6;

    if (condition == '') 
    {
        swal({   
            title: "",   
            text: "Aucune donneé filtreé",
            type:"error",   
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        //var WEBROOT = $('#WEBROOT').val();
        var l = $('#l').val();
        var c = $('#c').val();
        var m = $('#m').val();
        var s = $('#s').val();
        $('#cond').val(condition);

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
        xhttp.open("GET","ajax/equipement/filtre_sortie_accessoire.php?condition="+condition+"&l="+l+"&c="+c+"&m="+m+"&s="+s,true);
        xhttp.send();
    }
}         
function getEquipementByType(type)
{
    //alert(type);
    if (type != '') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    document.getElementById("dive_equipement").innerHTML = this.responseText;
                }
            };
        xhttp.open("GET","ajax/equipement/equipementInStockByType.php?type="+type,true);
        xhttp.send();
    }
}
function sortieEquipementEnStock(destination,demander_par,type,date_sortie,motif,sortie_par)
{
    //alert('destination: '+destination+' demander_par: '+demander_par+' type: '+type+' date_sortie: '+date_sortie+' motif'+motif+' userName: '+sortie_par)

    if (destination === "" || demander_par === "" || type === "" || date_sortie === "")
    {
        swal({ 
            text: "Veuillez remplir les champs en *",   
            title: "",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var idequipement = $('#equipement').val();

        if (destination === 'client') 
            var destination_detail = $('#selectCustomer0').val();
        else if (destination === 'relais') 
            var destination_detail = $('#relais0').val();
        else if (destination == 'base')
            var  destination_detail = $('#point_acces0').val();
        else if (destination == 'vehicule')
            var destination_detail = $('#vehicule0').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //msg.style.color = 'white';
                //msg.innerHTML = this.responseText;
                var rep = String(this.responseText).trim();
                if (rep == "") 
                {
                    document.location.reload();
                    swal({   
                        title: "",   
                        text: "Traitement reussi",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite",
                        type:"error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                document.getElementById("rep").innerHTML = this.responseText;
            }
            else
                swal({   
                    title: "",   
                    text: "traitement en cours",   
                    showConfirmButton: false 
                });
        };

        xhttp.open("GET","ajax/equipement/sortir_equipement_en_stock.php?demander_par="+demander_par+"&idequipement="+idequipement+"&date_sortie="+date_sortie+"&motif="+motif+"&sortie_par="+sortie_par+"&destination="+destination+"&destination_detail="+destination_detail,true);
        xhttp.send();
    } 
}
function equipement_recovery(idclient,type,mac_address,model,date_recuperation,iduser,description)
{
    if (idclient === null || type == '' || mac_address == '' || model == '' || date_recuperation == '') 
    {
        swal({   
            title: "",   
            text: "Veuillez remplir les champs en *",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else if (!verifierMacAdress(mac_address)) 
    {
        swal({   
            title: "",   
            text: "l'adresse mac n'est pas valide",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var nbport = $('#nbport').val() == '' ? 1 :  $('#nbport').val();
        if (type == 'routeur' && (nbport == '' || parseInt(nbport) <= 0)) 
        {
            swal({   
                title: "",   
                text: "Veuillez entrer le nombre de port",
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
                    //msg.style.color = 'white';
                    //msg.innerHTML = this.responseText;
                    var rep = String(this.responseText).trim();
                    if (rep == "") 
                    {
                        document.location.reload();
                        swal({   
                            title: "",   
                            text: "Traitement reussi",
                            type:"success",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    else
                    {
                        swal({   
                            title: "",   
                            text: "Une erreur s'est produite",
                            type:"error",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    //document.getElementById("rep").innerHTML = this.responseText;
                }
                else
                    swal({   
                        title: "",   
                        text: "traitement en cours",   
                        showConfirmButton: false 
                    });
            };

            xhttp.open("GET","ajax/equipement/equipement_recovery.php?idclient="+idclient+"&type="+type+"&mac_address="+mac_address+"&model="+model+"&date_recuperation="+date_recuperation+"&iduser="+iduser+"&nbport="+nbport+"&description="+description,true);
            xhttp.send();
        }
    }
}
function update_equipement_recovery(oldCustomer,idclient,type,mac_address,model,date_recuperation,iduser,description,recovery_id,equipement_id)
{
    //alert('idclient: '+idclient+' type: '+type+' mac_address: '+mac_address+' model: '+model+' date_recuperation: '+date_recuperation+' iduser: '+iduser+' description: '+description+' recovery_id: '+recovery_id);
    if (idclient === null || type == '' || mac_address == '' || model == '' || date_recuperation == '') 
    {
        swal({   
            title: "",   
            text: "Veuillez remplir les champs en *",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else if (!verifierMacAdress(mac_address)) 
    {
        swal({   
            title: "",   
            text: "l'adresse mac n'est pas valide",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var nbport = $('#nbport').val() == ''? 1 : $('#nbport').val();
        if (type == 'routeur' && (nbport == '' || parseInt(nbport) <= 0)) 
        {
            swal({   
                title: "",   
                text: "Veuillez entrer le nombre de port",
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
                    //msg.style.color = 'white';
                    //msg.innerHTML = this.responseText;
                    var rep = String(this.responseText).trim();
                    if (rep == "") 
                    {
                        document.location.reload();
                        swal({   
                            title: "",   
                            text: "Traitement reussi",
                            type:"success",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    else
                    {
                        swal({   
                            title: "",   
                            text: "Une erreur s'est produite",
                            type:"error",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    document.getElementById("rep").innerHTML = this.responseText;
                }
            };

            xhttp.open("GET","ajax/equipement/update_equipement_recovery.php?idclient="+idclient+"&type="+type+"&mac_address="+mac_address+"&model="+model+"&date_recuperation="+date_recuperation+"&iduser="+iduser+"&nbport="+nbport+"&description="+description+"&recovery_id="+recovery_id+"&equipement_id="+equipement_id+"&oldCustomer="+oldCustomer,true);
            xhttp.send();
        }
    }
}
function resetFiltreRecuperation()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"equipement_recover";
}
function showOrHiddeNbPortDiv(value)
{
    if(value == 'routeur')
    {
        $('#nbport_div').show();
    }
    else
    {
        $('#nbport_div').hide();
    }
}
function confirmerSortieEquipement(idsortie,idequipement,destination_detail,destination,date_sortie,sortie_par)
{
    //alert('idsortie: '+idsortie+' idequipement: '+idequipement+' destination_detail: '+destination_detail+' destination: '+destination+' date_sortie: '+date_sortie+' sortie_par: '+sortie_par);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            //msg.style.color = 'white';
            //msg.innerHTML = this.responseText;
            var rep = String(this.responseText).trim();
            if (rep == "") 
            {
                document.location.reload();
                swal({   
                    title: "",   
                    text: "Traitement reussi",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };

    xhttp.open("GET","ajax/equipement/confirmer_sortir_equipement_en_stock.php?idsortie="+idsortie+"&idequipement="+idequipement+"&destination="+destination+"&destination_detail="+destination_detail+"&date_sortie="+date_sortie+"&sortie_par="+sortie_par,true);
    xhttp.send();
}
function filtreSortie_equipement(demander_par,destination,date1,date2,mois,annee) 
{
    //alert('demander_par: '+demander_par+' destination: '+destination+' date1: '+date1+' date2: '+date2+' mois: '+mois+' annee: '+annee);

    var condition1 = ""; 
    var condition2 = "";
    var condition3 = "";
    var condition4 = "";
    var condition5 = "";
    var condition6 = ""; 
    var condition  = "";

    condition1 = (demander_par == "") ? "" : " AND demander_par ='"+demander_par+"'";
    condition2 = (destination == "") ? "" : " AND destination ='"+destination+"'";
    condition3 = (date1 == "") ? "" : " AND date_sortie='"+date1+"' ";
    
    if (date2 == '') 
    {
        condition4 = '';
    }
    else
    {
        if (date1 != '') 
        {
            condition4 = " AND date_sortie BETWEEN '"+date1+"' AND '"+date2+"'";
            condition3 = '';
        }
        else condition3 = " AND date_sortie='"+date2+"' ";
    }
    condition5 = (mois == "") ? "" : " AND MONTH(date_sortie)="+mois+" ";
    condition6 = (annee == "") ? "" : " AND YEAR(date_sortie)="+annee+" ";

    /*condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);
    condition5 = (condition5 == '' ? '' : 'AND' +condition5);
    condition6 = (condition6 == '' ? '' : 'AND' +condition6);*/
    condition = condition1+condition2+condition3+condition4+condition5+condition6;

    if (condition == '') 
    {
        swal({   
            title: "",   
            text: "Aucune donneé filtreé",
            type:"error",   
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var WEBROOT = $('#WEBROOT').val();
        var l = $('#l').val();
        var c = $('#c').val();
        var m = $('#m').val();
        var s = $('#s').val();
        $('#cond').val(condition);
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
        xhttp.open("GET","ajax/equipement/filtre_sortie_equipement.php?condition="+condition+"&WEBROOT="+WEBROOT+"&l="+l+"&c="+c+"&m="+m+"&s="+s,true);
        xhttp.send();
    }
}
function delete_Sortie_equipement(idSortie,idequipement)
{
    //alert('idSortie: '+idSortie+' idaccessoire: '+idaccessoire+' quantite: '+quantite);

    var iduser = $('#iduser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            //msg.style.color = 'white';
            //msg.innerHTML = this.responseText;
            var rep = String(this.responseText).trim();
            if (rep == "") 
            {
                document.location.reload();
                swal({   
                    title: "",   
                    text: "Traitement reussi",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            //document.getElementById("rep").innerHTML = this.responseText;
        }
    };

    xhttp.open("GET","ajax/equipement/delete_Sortie_equipement.php?idSortie="+idSortie+"&idequipement="+idequipement+"&iduser="+iduser,true);
    xhttp.send();
}
function submitFormReportSortieEquipement()
{
    /*var cond = $('#cond').val();
    if(cond == "")
        swal({   
            title: "",   
            text: "Aucun filtre effectué",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    else document.getElementById("form-reportSortieEquipement").submit();*/
    $('#print').val(1);
    document.getElementById("filtreSortie_equipementForm").submit();
}
function submitFiltreSortieAccessoireForm()
{
    /*var cond = $('#cond').val();
    if(cond == "")
        swal({   
            title: "",   
            text: "Aucun filtre effectué",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    else document.getElementById("form-reportSortieAccessoire").submit();*/
    $('#print').val(1);
    document.getElementById("filtreSortieAccessoireForm").submit();
}
/*function submitFormReportSortieAccessoire()
{
    var cond = $('#cond').val();
    if(cond == "")
        swal({   
            title: "",   
            text: "Aucun filtre effectué",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    else document.getElementById("form-reportSortieAccessoire").submit();
}*/
function delete_Sortie_accessoire(idSortie/*,idaccessoire,quantite*/)
{
    //alert('idSortie: '+idSortie+' idaccessoire: '+idaccessoire+' quantite: '+quantite);

    var iduser = $('#iduser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            //msg.style.color = 'white';
            //msg.innerHTML = this.responseText;
            var rep = String(this.responseText).trim();
            if (rep == "") 
            {
                document.location.reload();
                swal({   
                    title: "",   
                    text: "Traitement reussi",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            //document.getElementById("rep").innerHTML = this.responseText;
        }
    };

    xhttp.open("GET","ajax/equipement/delete_Sortie_accessoire.php?idSortie="+idSortie+"&iduser="+iduser,true);
    xhttp.send();
}
function getEquipementByType(type)
{
    //alert(type);
    if (type != '') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    document.getElementById("dive_equipement").innerHTML = this.responseText;
                }
            };
        xhttp.open("GET","ajax/equipement/equipementInStockByType.php?type="+type,true);
        xhttp.send();
    }
}
function attribuer_equipement_client(refclient,typeEquipement,datedistribution,attributeur)
{
    //alert('client: '+refclient+' typeequipement: '+typeEquipement+' date: '+datedistribution+' user: '+attributeur);
    //var nomantenne = $('#antenne').val().split(/_/);
    //var typeequipement = nomantenne[0];
            //alert(typeequipement);
    if (typeEquipement === "") 
    {
        //var msg = document.getElementById('msg');
        //msg.style.color = 'green';
       // msg.innerHTML = 'Veillez choisir le type d\'equipement';
        swal({   
            title: "Attention!",   
            text: "Veillez choisir le type d\'equipement",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var idEquipement = '';
        if (typeEquipement == 'antenne') 
        {
            idEquipement = $('#antenne').val();
        }
        else if (typeEquipement == 'routeur') 
        {
            idEquipement = $('#routeur').val();
        }
        else
        {
            idEquipement = $('#switch').val();
        }
        if (idEquipement == '') 
        {
            //var msg = document.getElementById('msg');
            //msg.style.color = 'green';
            //msg.innerHTML = 'Veillez choisir l\'equipement';
            swal({   
            title: "Attention!",   
            text: "Veillez choisir l\'equipement",
            type:"success",   
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
                    /*var msg = document.getElementById('msg');
                    msg.style.color = 'green';
                    msg.innerHTML = this.responseText;
                     location.reload();*/
                    document.getElementById("retour").innerHTML = this.responseText;
                    swal({   
                        title: "Attribution du materiel réussi!",   
                        text: "vous venez d'attribuer le materiel à ce client avec succees",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                    /*$('#refclient').val('');
                    $('#typeEquipement').val('');
                    $('#datedistribution').val('');*/
                }
            };
            xhttp.open("GET","ajax/equipement/attribution_equipement_client.php?idclient="+refclient+"&idEquipement="+idEquipement+"&typeEquipement="+typeEquipement+"&datedistribution="+datedistribution+"&attributeur="+attributeur,true);
            xhttp.send();
        }
   }
}
function update_accessoire(idaccessoire,quantite,commentaire)
{
  //alert(idaccessoire+' '+accessoire+'   '+quantite+'     '+commentaire);

    if (quantite === "" )
    {
        alert('vous devez donner la quantite');
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
                document.getElementById("rep").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "modification reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                 //location.reload();
            }
        };
        xhttp.open("GET","ajax/equipement/modifier_accessoire.php?idaccessoire="+idaccessoire+"&quantite="+quantite+"&commentaire="+commentaire+"&userName="+userName,true);
        xhttp.send();
    }
}
function suppression_accessoire(idaccessoire)
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
                //document.getElementById("rep").innerHTML = this.responseText;
                document.location.reload();
                swal({   
                    title: "",   
                    text: "suppression reussie",
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
    xhttp.open("GET","ajax/equipement/supprimer_accessoire.php?idaccessoire="+idaccessoire+"&iduser="+iduser,true);
    xhttp.send();
}
function updateAntenne(id,model,mac,user,date_stock,description)
{
    //alert('id: '+id+' model: '+model+' mac: '+mac+' date_stock: '+date_stock+' description: '+description);
    if (model === "" || date_stock === "" || mac === "")
    {
        swal({   
            title: "",   
            text: "Veillez remplir les champs en *",
            type:"error",   
            timer: 1000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        if (verifierMacAdress(mac))
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
                            text: "modification reussie",
                            type:"success",   
                            timer: 1000,   
                            showConfirmButton: false 
                        });
                    }
                    else
                    {
                        document.getElementById("retourjs").innerHTML = this.responseText;
                        swal({   
                            title: "",   
                            text: "Un erreur s'est produite!",
                            type:"error",   
                            timer: 1000,   
                            showConfirmButton: false 
                        });
                    }
                }
            };                                                                   
            xhttp.open("GET","ajax/equipement/modifierAntenne.php?id="+id+"&model="+model+"&mac="+mac+"&date_stock="+date_stock+"&description="+description+"&user="+user,true);
            xhttp.send();
        }
        else
            swal({   
                title: "",   
                text: "L'adresse mac n'est pas valide",
                type:"error",   
                timer: 1000,   
                showConfirmButton: false 
            });
    }
}  
function supprimerAntenne(id)
{
    var iduser = $('#user').val();
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
                    text: "Une erreur s'est produite!",
                    type:"error",   
                    timer: 2000,   
                    showConfirmButton: false 
                });
            //document.getElementById("retourjs").innerHTML = this.responseText;
            
        }
    };
    xhttp.open("GET","ajax/equipement/supprimerAntenne.php?id="+id+"&iduser="+iduser,true);
    xhttp.send();
}
function updateRouteur(id,model,fabriquant,date_stock)
{
    //alert(id+'  '+model+'  '+fabriquant+'  '+date_stock);
    if (model === "" || date_stock == '')
    {
        swal({   
            title: "",   
            text: "Veillez remplir les champs en *",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
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
                if (rep == '') 
                {
                    location.reload();
                    swal({   
                        title: "",   
                        text: "",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    document.getElementById("retourjs").innerHTML = this.responseText;
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite!",
                        type:"error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                //location.reload();
            }
        };
        xhttp.open("GET","ajax/equipement/updateRouteur.php?id="+id+"&model="+model+"&fabriquant="+fabriquant+"&date_stock="+date_stock+"&userName="+userName,true);
        xhttp.send();
    }   
}
function supprimerRouteur(id)
{
    var iduser = $('#user').val();
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
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                document.getElementById("retourjs").innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite!",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/equipement/deleteRouteur.php?id="+id+"&iduser="+user,true);
    xhttp.send();
}
function updateswitch(id,type_equipement,model,fabriquant,date_stock)
{
    //alert(id+'  '+type_equipement+'  '+model+'  '+fabriquant+ ' ' +date_stock );
    if (model === "" || date_stock == "" )
    {
        swal({   
            title: "",   
            text: "Veillez remplir les champs en *!",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
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
                if (rep == '') 
                {
                    location.reload();
                    swal({   
                        title: "",   
                        text: "",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    document.getElementById("retourjs").innerHTML = this.responseText;
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite!",
                        type:"error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/equipement/updateSwitch.php?id="+id+"&type_equipement="+type_equipement+"&model="+model+"&fabriquant="+fabriquant+"&date_stock="+date_stock+"&userName="+userName,true);
        xhttp.send();
    }       
}
function supprimerswitch(id)
{
    var iduser = $('#user').val();
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
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                //document.getElementById("retourjs").innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite!",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/equipement/deleteSwitch.php?id="+id+"&iduser="+iduser,true);
    xhttp.send();
}
function updateRadio(id,type_equipement,model,fabriquant,date_stock)
{
    //alert(id+'  '+type_equipement+'  '+model+'  '+fabriquant+'  '+date_stock );
    if (date_stock == "" || model == "")
    {
        swal({   
            title: "",   
            text: "Veillez remplir les champs en *!",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else  
    {
        var userName = $('userName').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                var rep = String(this.responseText).trim();
                if (rep == '') 
                {
                    location.reload();
                    swal({   
                        title: "",   
                        text: "",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    document.getElementById("retourjs").innerHTML = this.responseText;
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite!",
                        type:"error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/equipement/modifierRadio.php?id="+id+"&type_equipement="+type_equipement+"&model="+model+"&fabriquant="+fabriquant+"&date_stock="+date_stock+"&userName="+userName,true);
        xhttp.send();
    }
}
function supprimerRadio(id)
{
    var iduser = $('#user').val();
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
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                document.getElementById("retourjs").innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite!",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/equipement/deleteRadio.php?id="+id+"&iduser="+iduser,true);
    xhttp.send();
}
function choisirgazoil(choix)
{
    //alert(choix);
    if (choix != '') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("zonede_destination").innerHTML = this.responseText;

            }
        };
        xhttp.open("GET","ajax/equipement/inclusion_choix_carburant.php?choix="+choix,true);
        xhttp.send();
    }
}
function distribuer_carburant(nature,recepteur,nblitres,datedistribution,distributeur)
{
    //alert(nature+'/'+recepteur+'/'+nblitres+'/'+datedistribution'/'+distributeur);
    var idrecepteur = '';
    if (nature == "" || recepteur == "" || nblitres == "" || datedistribution == "" || distributeur == "") 
    {
        //alert("Aucun de ces champs ne doivent pas rester null");
        swal({   
                                            title: "Information!",   
                                            text: "remplissez tout les champs",
                                            type:"success",   
                                            timer: 3000,   
                                            showConfirmButton: false 
                                        });
    }
    else
    {
        if (recepteur == 'vehicule_essence' && nature == 'essence') 
        {
            idrecepteur = $('#vehicule_essence').val();
              //alert(idrecepteur);
        }
        else if (recepteur == 'vehicule_mazout' && nature == 'mazout') 
        {
            idrecepteur = $('#vehicule_mazout').val();
           // alert(idrecepteur);
        }
        else if (recepteur == 'backup') 
        {
            idrecepteur = $('#secteur').val();
           // alert(idrecepteur);
        }
        else if(recepteur == 'autre') 
        {
            idrecepteur = $('#personel').val();
           // alert(idrecepteur);
        }
        if (idrecepteur == '') 
        {
            //alert('Veillez choisir le recepteur svp');
            swal({   
                                            title: "Information!",   
                                            text: "Veillez choisir le recepteur",
                                            type:"success",   
                                            timer: 3000,   
                                            showConfirmButton: false 
                                        });
        }
        else
        {
            //alert(nature+'/'+idrecepteur+' /'+nblitres+' /'+datedistribution+' /'+distributeur);
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4)  
                {
                    document.getElementById("reponse").innerHTML = this.responseText;
                                swal({   
                                    title: "Information!", 
                                    type:"success" , 
                                    text: "Distribution reussie",   
                                    timer: 3000,   
                                    showConfirmButton: false 
                                });
                            $('#nature').val('');
                            $('#recepteur').val('');
                            $('#nblitres').val('');
                            $('#datedistribution').val('');
                    /*document.getElementById("rep").innerHTML = this.responseText;
                     location.reload();*/
                }
            };
            xhttp.open("GET","ajax/equipement/distribuer_carburant.php?nature="+nature+"&idrecepteur="+idrecepteur+"&nblitres="+nblitres+"&datedistribution="+datedistribution+"&distributeur="+distributeur,true);
            xhttp.send();
        }
    }
}
function ajouter_carburant(nature,nblitre,prix_achat,datesachat)
{
    //alert('nature: '+nature+' nblitre: '+nblitre+' prix_achat: '+prix_achat+' datesachat: '+datesachat);
    //var total = prix_achat*nblitre
    if (nature == "" || nblitre == "" || prix_achat == "" || datesachat == "" ) 
    {
        //alert("Ces champs ne doivent pas etre vide mon cher ami (e)");
        swal({   
            title: "",   
            text: "Veillez remplir les champs *",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var WEBROOT = $('#WEBROOT').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "", 
                    type:"success",  
                    timer: 3000,   
                    showConfirmButton: false 
                });
                $('#nature').val('');
                $('#nblitres').val('');
                $('#prix_achat').val('');
                $('#datesachat').val('');
            }
        };
        xhttp.open("GET","ajax/equipement/ajoutercarburant.php?nature="+nature+"&nblitre="+nblitre+"&prix_achat="+prix_achat+"&datesachat="+datesachat+"&WEBROOT="+WEBROOT,true);
        xhttp.send();
    }  
}
function modifier_stock_carburant(refstock,refnature,refnblitre,refprix_achat,refdatesachat)
{
    //alert(refstock+'/'+refnature+'/'+refnblitre+'/'+refprix_achat+'/'+refdatesachat );
    if (refnature=== "" || refnblitre === "" || refprix_achat === "" || refdatesachat == "")
    {
        swal({   
            title: "",   
            text: "Veillez remplir les champs en *!",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else  
    {
        var WEBROOT = $('#WEBROOT').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                // location.reload();
            }
        };
        xhttp.open("GET","ajax/equipement/updatestock_carburant.php?refstock="+refstock+"&refnature="+refnature+"&refnblitre="+refnblitre+"&refprix_achat="+refprix_achat+"&refdatesachat="+refdatesachat+"&WEBROOT="+WEBROOT,true);
        xhttp.send();
    }    
}
function suppressionstockCarburant(num_stock)
{
    //alert(num_stock);
    var WEBROOT = $('#WEBROOT').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("reponse").innerHTML = this.responseText;
            swal({   
                title: "",   
                text: "",
                type:"success",   
                timer: 3000,   
                showConfirmButton: false 
            });
        }
    };
    xhttp.open("GET","ajax/equipement/deletestock_carburant.php?num_stock="+num_stock+"&WEBROOT="+WEBROOT,true);
    xhttp.send();
}
function genererrapport_mensuel_carburant(annee,mois)
{
    if (annee === "" || mois === "" )
    {
        swal({   
            title: "Information!",   
            text: "vous devez remplir tout les champs *",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        document.getElementById('printrapport_carburant').submit();
    }
}
function genereInstallation(mois)
{
    var content = document.getElementById('mois').firstChild.innerHTML;
    alert(content);
   
}

function submitFiltreSortieCaisse()
{
    if ($('#condition').val() == '')
    {
        swal({   
            title: "",   
            text: "Veillez filtrer d'abord!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        document.getElementById('filtreSortieCaisse').submit();
    }
}
function submitFiltreEntrerCaisse()
{
    if ($('#conditionEntrees').val() == '')
    {
        swal({   
            title: "",   
            text: "Veillez filtrer d'abord!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        //alert($('#conditionEntrees').val());
        document.getElementById('filtreEntrerCaisse').submit();
    }
}
function filtreEntrerCaisse(date1,date2,mois,provenance,annee,idcaisse)
{
    //alert('date1: '+date1+' date2: '+date2+' mois: '+mois+' provenance: '+provenance+' anneeEntrer: '+anneeEntrer+' idcaisse: '+idcaisse);
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4 = null;
    var condition5 = null;
    var condition6 = null;
    var condition = '';

    if (date1 == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " dateEntrer='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition2 = '';
    }
    else
    {
        if (date1 !== '') 
        {
            condition2 = " dateEntrer BETWEEN '"+date1+"' AND '"+date2+"' ";
            condition1 = '';
        }
        else condition2 = " dateEntrer='"+date2+"' ";
    }
    if (mois == '') 
    {
        condition3 = '';
    }
    else
    {
        condition3 = " MONTH(dateEntrer)="+mois+" ";
    }
    if (annee == '') 
    {
        condition4 = '';
    }
    else
    {
        condition4 = " YEAR(dateEntrer)="+annee+" ";
    }
    if (provenance == '') 
    {
        condition5 = '';
    }
    else
    {
        condition5 = " provenance='"+provenance+"' "
    }
    if (idcaisse == '') 
    {
        condition6 = '';
    }
    else condition6 = " c.ID_caisse="+idcaisse+" ";

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);
    condition5 = (condition5 == '' ? '' : 'AND' +condition5);
    condition6 = (condition6 == '' ? '' : 'AND' +condition6);

    condition = condition1+condition2+condition3+condition4+condition5+condition6;
    if (condition == '') 
    {
        swal({   
            title: "",   
            text: "Aucune filtre effectué",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        document.getElementById('conditionEntrees').value = condition;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                $('#myTable').DataTable().destroy();
                document.getElementById("repEntree").innerHTML = this.responseText;
                $('#myTable').DataTable();
                //location.reload();
                /*swal({   
                    title: "",   
                    text: "suppression reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });*/
            }
        };
        xhttp.open("GET","ajax/comptabilite/filtreEntrerCaisse.php?condition="+condition,true);
        xhttp.send();
    }
}
function filtreSortie_stock(date1,date2,mois,annee,idaccessoire)
{
      //alert('date1: '+date1+' date2: '+date2+' mois: '+mois+' annee: '+annee);
    //var WEBROOT = $('#WEBROOT').val();
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4 = null;
    var condition5 = null;
    var condition = '';

    if (date1 == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " date_sortie='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition2 = '';
    }
    else
    {
        if (date1 !== '') 
        {
            condition2 = " date_sortie BETWEEN '"+date1+"' AND '"+date2+"' ";
            condition1 = '';
        }
        else condition2 = " date_sortie='"+date2+"' ";
    }
    if (mois == '') 
    {
        condition3 = '';
    }
    else
    {
        condition3 = " MONTH(date_sortie)="+mois+" ";
    }
    if (annee == '') 
    {
        condition4 = '';
    }
    else
    {
        condition4 = " YEAR(date_sortie)="+annee+" ";
    }
    if (idaccessoire == '') 
    {
        condition5 = '';
    }
    else condition5 = " s.ID_accessoire="+idaccessoire+" ";

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);
    condition5 = (condition5 == '' ? '' : 'AND' +condition5);

    condition = condition1+condition2+condition3+condition4+condition5;
    if (condition == '') 
    {
        swal({   
            title: "",   
            text: "Aucune filtre effectué",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        document.getElementById('condition').value = condition;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                $('#example23').DataTable().destroy();
                document.getElementById("rep").innerHTML = this.responseText;
                $('#example23').DataTable();
                //location.reload();
                /*swal({   
                    title: "",   
                    text: "suppression reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });*/
            }
        };
        xhttp.open("GET","ajax/equipement/filtre_sortieStock.php?condition="+condition,true);
        xhttp.send();
    }
}
function resetFiltreDepense()
{
    document.location.reload();
}
function verstock_accessoir(accessoireStock)
{
    //alert(annee+' '+mois);
    if (accessoireStock === ""  )
    {
       // alert('vous devez remplir tous les champs');
        swal({
            title:"Attention",
            text:"vous devez selectionnez l'accessoire",
            type: "error",
            timer:3000,
            showConfirmButton:false
        });
    }
    else 
    {
        document.getElementById('rapportStock').submit();
    }
}
function modifier_sortie(id_sortie,idaccessoire,quantite,date_sortie,motif)
{
    //alert(id_sortie+'/  '+idaccessoire+' /'+quantite+'  '+date_sortie+'  '+motif);
     if (id_sortie=== "" || quantite === "" || date_sortie === "" || motif == "")
    {
        swal({   
            title: "",   
            text: "Veillez remplir tous champs en !",
            type:"error",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else  
    {
        //var WEBROOT = $('#WEBROOT').val();
        var userName =$('#userName').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //document.getElementById("rep").innerHTML = this.responseText;
                swal({   
                    title: "Bravo",   
                    text: "Modification reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                 location.reload();
            }
        };
        xhttp.open("GET","ajax/equipement/updatesortie_stock.php?id_sortie="+id_sortie+"&idaccessoire="+idaccessoire+"&quantite="+quantite+"&date_sortie="+date_sortie+"&motif="+motif+"&userName="+userName,true);
        xhttp.send();
    } 
}
function destination_accessoire(destination,i)
{
    if (destination != '' && destination != 'autre') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("affiche_destination"+i).innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/equipement/destination_accessoire.php?destination="+destination+"&i="+i,true);
        xhttp.send();
    }
}