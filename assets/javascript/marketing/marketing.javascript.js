
function visiteClient(prospect,propositionmarketeur,propositionprospect,daterdv,datedujour)
{
    //alert(prospect+' '+propositionmarketeur+' '+propositionprospect+'  '+daterdv+'  '+datedujour);

    if (prospect === "" || propositionmarketeur === "" || propositionprospect  === "" || daterdv === "")
    {
        swal({   
            title: "",   
            text: "vous devez remplir tous les champs en *",
            type:"warning",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        var prospect = prospect.split(/-/);
        var idprospect = prospect[1];
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
                    swal({   
                        title: "",   
                        text: this.responseText,
                        type:"error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
            }
        };
        xhttp.open("GET","ajax/marketing/ajoutVisiteProspect.php?idprospects="+prospect+"&propositionmarketeur="+propositionmarketeur+"&propositionprospect="+propositionprospect+"&daterdv="+daterdv+"&datedujour="+datedujour,true);
        xhttp.send();
    }
}

function ajouterprospect(prospect,adresprospect,portable,mailP,genre,rdv,jourEnreg,marketeur_comment,prospect_comment,iduser)
{
    //alert(prospect+'  '+adresprospect+'  '+portable+'  '+mailP+'  '+genre+'  '+rdv+'  '+jourEnreg+'  '+iduser);

    if (prospect === "" || genre == "" || adresprospect == "")
    {
        swal({   
            title: "",   
            text: "vous devez remplir tous les champs en *",
            type:"warning",   
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
                //document.getElementById("reponse").innerHTML = this.responseText;
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
                    swal({   
                        title: "",   
                        text: "",
                        type:"error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                //document.getElementById("reponse").innerHTML = this.responseText;
                /*$('#prospect').val('');
                $('#adresprospect').val('');
                $('#portable').val('');
                $('#mailP').val('');
                $('#entreprise').val('');
                $('#rdv').val('');
                $('#jourEnreg').val('');
                $('#commentaire').val('');*/
            }
        };
        xhttp.open("GET","ajax/marketing/ajouterprospect.php?prospect="+prospect+"&adresprospect="+adresprospect+"&portable="+portable+"&mailP="+mailP+"&genre="+genre+"&rdv="+rdv+"&jourEnreg="+jourEnreg+"&marketeur_comment="+marketeur_comment+"&prospect_comment="+prospect_comment+"&iduser="+iduser,true);
        xhttp.send();
    }
}
function updateProspect(numprospect,nomprospect,adresprospect,phoneprospect,mailprospect,genre,rdv,dateprospection)
{
    //alert('idprospect: '+numprospect+' nom: '+nomprospect+' adresse: '+adresprospect+' phone: '+phoneprospect+' mail: '+mailprospect+' entreprise: '+entreprise+' rendevous'+rdv+' date: '+dateprospection+' commentaire: '+commentaire);

    if (numprospect === "" || nomprospect === "" || adresprospect === "" || genre == '')
    {
        swal({   
            title: "",   
            text: "vous devez remplir tous les champs en *",
            type:"warning",   
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
                        text: "",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                    swal({   
                        title: "",   
                        text: "",
                        type:"error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                document.getElementById("reponse").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/marketing/updateprospect.php?numprospect="+numprospect+"&nomprospect="+nomprospect+"&adresprospect="+adresprospect+"&phoneprospect="+phoneprospect+"&mailprospect="+mailprospect+"&genre="+genre+"&rdv="+rdv+"&dateprospection="+dateprospection,true);
        xhttp.send();
    }
}
function supprimerProspect(numprospect)
{
    //alert(numprospect);
    if (numprospect === "")
    {
        alert('vous devez avoir au moin l\'identifiant du prospect');
    }
    else 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                document.location.reload();
            }
        };
        xhttp.open("GET","ajax/marketing/supprimerprospect.php?numprospect="+numprospect,true);
        xhttp.send();
    }
}
function nombreprospect()
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
    xhttp.open("GET","ajax/marketing/recuperertoutprospect.php?",true);
    xhttp.send();
}
function ajouterstockmarketing(materiel,quantite)

{
   // alert(materiel+' '+quantite);
    if (materiel === "" || quantite === "" )
    {
        //alert('vous devez remplir tous les champs');
        swal({   
            title: "Information!",   
            text: "Vous devez remplir tous les champs",
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
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Le nouveau materiel a été enregistré avec succès",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                $('#materiel').val('');
                $('#quantite').val('');
            }
        };
        xhttp.open("GET","ajax/marketing/ajouterStockmarketing.php?materiel="+materiel+"&quantite="+quantite,true);
        xhttp.send();
    }
}
function updatestock(idstockmarketing,materiels,quantite)

{
    //alert(idstockmarketing+'  '+materiels+' '+quantite);

  if ( materiels === ""  || quantite === "")
    {
        //alert('vous devez remplir tous les champs');
        swal({   
            title: "Information!",   
            text: "Vous devez remplir tous les champs",
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
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Modification du stock reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        };
        xhttp.open("GET","ajax/marketing/updateStockM.php?idstockmarketing="+idstockmarketing+"&materiels="+materiels+"&quantite="+quantite,true);
        xhttp.send();
    }
}
function supprimerstock(idstockmarketing)
{
    //alert(idstockmarketing);

    if (idstockmarketing === "")
    {
        //alert('vous devez avoir au moin l\'identifiant du prospect');
        swal({   
            title: "Information!",   
            text: "Vous devez remplir tous les champs",
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
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Vous venez de supprimer ce stock",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        };
        xhttp.open("GET","ajax/marketing/suppression_materiel_stock.php?idstockmarketing="+idstockmarketing,true);
        xhttp.send();

    }
    
}
function ajoutersponsor(demande,nature,adrsponsor,phonesponsor,visibilite,datedebut,datefin)
{
    //alert(demande+' '+nature+'  '+adrsponsor+'  '+phonesponsor+'  '+visibilite+'  '+datedebut+' '+datefin);

    if (demande === "" || nature === "" || adrsponsor === "" || phonesponsor === "" || visibilite === "" || datedebut === "" || datefin === "" )
    {
        //alert('vous devez remplir tous les champs');
        swal({   
            title: "Information!",   
            text: "Vous devez remplir tous les champs",
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
                document.getElementById("rep").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Le nouveau sponsor a été enregistré avec succès",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                $('#demande').val('');
                $('#nature').val('');
                $('#adrsponsor').val('');
                $('#phonesponsor').val('');
                $('#visibilite').val('');
                $('#datedebut').val('');
                $('#datefin').val('');
                //document.location.href = "/crm.spidernet/sponsor";
            }
        };
        xhttp.open("GET","ajax/marketing/nouveauSponsor.php?demande="+demande+"&nature="+nature+"&adrsponsor="+adrsponsor+"&phonesponsor="+phonesponsor+"&visibilite="+visibilite+"&datedebut="+datedebut+"&datefin="+datefin,true);
        xhttp.send();
    }
}
function supprimerSponsor(numspons)
{
    //alert(idsponsor);

    if (numspons === "")
    {
        alert('vous devez avoir au moin l\'identifiant du sponsor');
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
                    title: "Information!",   
                    text: "Suppression reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        };
        xhttp.open("GET","ajax/marketing/supprimersponsor.php?numspons="+numspons,true);
        xhttp.send();
    } 
}
function updateSponsor(idsponsor,demande,nature,adrsponsor,phonesponsor,datedebut,datefin)
{
   //alert(idsponsor+'/'+demande+' /'+nature+'/ '+adrsponsor+' / '+phonesponsor+' /'+datedebut+'/ '+datefin);

    if (demande === "" || nature ==="" || adrsponsor === "" || phonesponsor === "" || datedebut === "" || datefin === "")
    {
        //alert('vous devez remplir tous les champs');
        swal({   
            title: "Information!",   
            text: "Vous devez remplir tous les champs",
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
                document.getElementById("rep").innerHTML = this.responseText;
                swal({   
                                    title: "Information!",   
                                    text: "Modification reussie",
                                    type:"success",   
                                    timer: 3000,   
                                    showConfirmButton: false 
                                });
                
                
            }
        };
        xhttp.open("GET","ajax/marketing/updatesponsor.php?idsponsor="+idsponsor+"&demande="+demande+"&nature="+nature+"&adrsponsor="+adrsponsor+"&phonesponsor="+phonesponsor+"&datedebut="+datedebut+"&datefin="+datefin,true);
        xhttp.send();

    }
}
function valideprospect(idprospect,location,nif,langue,type)
{
    //alert('idprospect : '+idprospect+' location : '+location+' nif : '+nif+' langue : '+langue+'  type : '+type);
    var assujettitva = document.getElementById('assujettitva').checked == true ? 'oui' : 'non';

    if (location === "" || langue === "" || type ==="")
    {
        swal({   
            title: "",   
            text: "Vous devez remplir les champs en *",
            type:"warning",   
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
                //document.getElementById("rep").innerHTML = this.responseText;
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
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        };
        xhttp.open("GET","ajax/marketing/valideprospect.php?idprospect="+idprospect+"&location="+location+"&nif="+nif+"&langue="+langue+"&assujettitva="+assujettitva+"&type="+type,true);
        xhttp.send();
    }
}
function desactiveprospect(idprospect)
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
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
                swal({   
                    title: "",   
                    text: "",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
        }
    };
    xhttp.open("GET","ajax/marketing/desactiverProspect.php?idprospect="+idprospect,true);
    xhttp.send();
}
function activerProspect(idprospect)
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
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
                swal({   
                    title: "",   
                    text: "",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
        }
    };
    xhttp.open("GET","ajax/marketing/activerProspection.php?idprospect="+idprospect,true);
    xhttp.send();
} 
/* function Attribuer_Materiels(idclient,materiel,quantite)

{
  alert(idclient+'  '+materiel+'  '+quantite);


  /*if (idprospect === "" || materiel === "" || quantite === "")
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
                document.getElementById("rep").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/marketing/attributionmateriel.php?idprospect="+idprospect+"&materiel="+materiel+"&quantite="+quantite,true);
        xhttp.send();

    }

}*/
function retourTousprospect()
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
    xhttp.open("GET","ajax/marketing/recuperertoutprospect.php?",true);
    xhttp.send();
}
function recupereProspectsparEtat(etatduProspect)
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
    xhttp.open("GET","ajax/marketing/recuperetoutprospectParEtat.php?etatduProspect="+etatduProspect,true);
    xhttp.send();
}
function filtreProspect(idprospect,nomprospect,phoneprospect,mailprospect,dateprospection)
{
    //alert(idprospect+' '+nomprospect+' '+phoneprospect+' '+mailprospect+' '+dateprospection);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("reponse").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/marketing/filtreProspect.php?idprospect="+idprospect+"&nomprospect="+nomprospect+"&phoneprospect="+phoneprospect+"&mailprospect="+mailprospect+"&dateprospection="+dateprospection,true);
    xhttp.send();
}
function resetFiltreProspect()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"prospection";
}
