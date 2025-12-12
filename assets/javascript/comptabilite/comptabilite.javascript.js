
function creer_compteBancaire(nombanque,numerocompte,montantinitial,monnaie,statut,affichefacture,datecreation)
{
     var affichefacture = 'NON'; 
    //alert(nombanque+' '+numerocompte+' '+montantinitial+''+monnaie+' '+statut+' '+affichefacture+' '+datecreation);

    if (nombanque === "" || numerocompte === "" || monnaie  === "" || statut === "" )
    {
        //alert('vous devez remplir tous les champs');
        swal({
            title:"",
            text:"vous devez remplir tout les champs",
            type:"error",
            timer:3000, 
            showConfirmButton:false
        });
    }
    else 
    {
        if(document.getElementById("show_on_invoice").checked == true)
        {
            affichefacture = 'OUI';
        }
        var iduser = $('#iduser').val();
        var WEBROOT = $('#WEBROOT').val();
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
                        timer: 1000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    //document.getElementById("rep").innerHTML = this.responseText;
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite",
                        type:"error",   
                        timer: 1000,   
                        showConfirmButton: false 
                    });
                }
                
                /*$('#nombanque').val('');
                $('#numerocompte').val('');
                $('#montantinitial').val(0);
                $('#statut').val('');*/
            }
        };
        xhttp.open("GET","ajax/comptabilite/creer_compteBancaire.php?nombanque="+nombanque+"&numerocompte="+numerocompte+"&montantinitial="+montantinitial+"&monnaie="+monnaie+"&statut="+statut+"&affichefacture="+affichefacture+"&datecreation="+datecreation+"&iduser="+iduser+"&WEBROOT="+WEBROOT,true);
        xhttp.send();
    }
}
function update_compteBancaire(idbank,nombanque,numerocompte,montantinitial,monnaie,oldMontantInitial,statut,i)
{
    //var caseacocherviewinvoice = 'non';
   
    //alert('idbanque: '+idbank+' nombanque: '+nombanque+' numerocompte: '+numerocompte+' montantinitial'+montantinitial+' oldMontantInitial: '+oldMontantInitial+' monnaie: '+monnaie+' statut: '+statut);
    if (nombanque === "" || numerocompte === "" || monnaie === "")
    {
        swal({
            title:"",
            text:"Veillez remplir les champs en *",
            type:"error",
            timer:3000, 
            showConfirmButton:false
        });
    }
    else
    { 
        var show_on_invoice = 'NON';
        if (document.getElementById('show_on_invoice'+i).checked == true) 
            show_on_invoice = 'OUI';
        var iduser = $('#iduser').val();
        var WEBROOT = $('#WEBROOT').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                var res = String(this.responseText).trim();
                if (res == '') 
                {
                    document.location.reload();
                    //document.getElementById("rep").innerHTML = this.responseText;
                    swal({
                        title:"",
                        text:"",
                        type:"success",
                        timer:1000, 
                        showConfirmButton:false
                    });
                }
                else
                    //document.getElementById("rep").innerHTML = this.responseText;
                    swal({
                        title:"",
                        text:"Une erreur s'est produite!",
                        type:"error",
                        timer:1000, 
                        showConfirmButton:false
                    });
            }
        }; 
        xhttp.open("GET","ajax/comptabilite/updatecompteBanque.php?idbank="+idbank+"&nombanque="+nombanque+"&numerocompte="+numerocompte+"&montantinitial="+montantinitial+"&oldMontantInitial="+oldMontantInitial+"&monnaie="+monnaie+"&statut="+statut+"&show_on_invoice="+show_on_invoice+"&iduser="+iduser+"&WEBROOT="+WEBROOT,true);
        xhttp.send();
    }
}
function supprimercompteBanque(clebank)
{
   // alert(clebank);
    var iduser = $('#iduser').val();
    var WEBROOT = $('#WEBROOT').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            var res = String(this.responseText).trim();
            if (res == '') 
            {
                document.location.reload();
                //document.getElementById("rep").innerHTML = this.responseText;
                swal({
                    title:"",
                    text:"",
                    type:"success",
                    timer:1000, 
                    showConfirmButton:false
                });
            }
            else
                //document.getElementById("rep").innerHTML = this.responseText;
                swal({
                    title:"",
                    text:"Une erreur s'est produite!",
                    type:"error",
                    timer:1000, 
                    showConfirmButton:false
                });
        }
    };
    xhttp.open("GET","ajax/comptabilite/suppressioncompteBanque.php?clebank="+clebank+"&iduser="+iduser+"&WEBROOT="+WEBROOT,true);
    xhttp.send();
}

/*function ajout_paiement(idclient,montant,monnaie,methodepaiement,taux_de_change,reference,tva,datepaiement,iduser,facturepaye)
{
    //alert(idclient+' '+montant+'  '+monnaie+' '+methodepaiement+' '+taux_de_change+' '+reference+' '+tva+' '+datepaiement+'  '+iduser+' '+facturepaye);
}*/
function versementArgent(banque,reference,dateversement,iduser)
{
    var divElem = document.getElementById("checkbox-parent");
    //var inputs = divElem.querySelectorAll("input").checked;
    var checked = divElem.querySelectorAll('input[type="checkbox"]:checked');
    var nombredePaiement = checked.length;
    var checkMonnaie = true;
    var montant_total = 0;

    if (banque == "" || reference == "" || dateversement == "") 
    {
        swal({   
            title: "",   
            text: "Veuillez remplir les champs en *!", 
            type:"error",  
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        if (nombredePaiement == 0) 
        {
            swal({   
                title: "",   
                text: "Veuillez choisir le paiement!", 
                type:"error",  
                timer: 2000,   
                showConfirmButton: false 
            });
        }
        else
        {
            var monnaiedestination = banque.split(/-/)[2];
            for (i = 0; i < nombredePaiement; i++) 
            {
                paiement = checked[i].value.split(/_/);
                montant_total += parseFloat(paiement[1]);
                if (paiement[2] != monnaiedestination) 
                {
                    checkMonnaie = false;
                }
            }
            if (checkMonnaie) 
            {
                $('#montant_total').val(montant_total);
                document.getElementById("saveVersementForm").submit();
            }
            else
                swal({   
                title: "",   
                text: "La monnaie de quelque paiement n'est la meme de la banque", 
                type:"error",  
                timer: 2000,   
                showConfirmButton: false 
            });
        }
    }
}
var montant_payement_decocher = 0;
var tb_payement = [''];
function verifierSiPayementDecocher(element)
{
    if (document.getElementById(element).checked == false) 
    {
        var valeur = document.getElementById(element).value.split(/_/);
        montant_payement_decocher+=parseFloat(valeur[1]);
        tb_payement.push(valeur[0]);
    }
    else 
    {
        var valeur = document.getElementById(element).value.split(/_/);
        montant_payement_decocher-=parseFloat(valeur[1]);
        for (var i = 0; i < tb_payement.length; i++) 
        {
            if (valeur[0] == tb_payement[i]) 
            {
                tb_payement.splice(i, 1);
            }
        }
    }
}
function setVerssement(caisse,montant,banque,reference,dateversement)
{
    //alert('caisse: '+caisse+' montant: '+montant+' banque: '+banque+' reference: '+reference+' dateversement: '+dateversement);
    if (caisse == '' || montant == '' || banque == '' || reference == '' || dateversement == '') 
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
        var erreur = '';
        var idcaisse = caisse.split(/-/)[0];
        var montantcaisse = caisse.split(/-/)[1];
        var monnaieCaisse = caisse.split(/-/)[2];

        var idBanque = banque.split(/-/)[0];
        var montantbanque = banque.split(/-/)[1];
        var monnaie_banque = banque.split(/-/)[2];
        var nomBanque = banque.split(/-/)[3];

        if (parseInt(montant) > parseInt(montantcaisse)) 
        {
            erreur += 'montant entré > au montant en caisse';
        }
        if (monnaieCaisse != monnaie_banque) 
        {
            erreur += ' La caisse et la banque doit avoir la meme monnaie';
        }
        if (erreur != '') 
        {
            swal({   
                title: "",   
                text: erreur,  
                type:"error", 
                timer: 3000,   
                showConfirmButton: false 
            });
        }
        else
        {
            var idUser = $('#iduser_verser').val();
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
                    var rep = String(this.responseText).trim();
                    if (rep == '') 
                    {
                        location.reload();
                    }
                    else
                        swal({   
                            title: "",   
                            text: "Une erreur est survenue!",  
                            type:"error", 
                            timer: 3000,   
                            showConfirmButton: false 
                        }); 
                    //document.getElementById("retour").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET","ajax/comptabilite/setVerssement.php?idcaisse="+idcaisse+"&montant="+montant+"&monnaie="+monnaieCaisse+"&idBanque="+idBanque+"&reference="+reference+"&nomBanque="+nomBanque+"&dateversement="+dateversement+"&idUser="+idUser,true);
            xhttp.send();
        }
    }
}
function modifierVersement(idversement,old_monnaie_banque,reference,dateversement,banque,etat,i)
{
    //var idversement = idversement.split(/-/)[0];
    //var nb = document.querySelector("input."+idversement).length;
    //alert(nb);
    //alert(montant_dun_payement_verser);
    //alert('idversement = '+idversement+' reference = '+reference+' dateversement = '+dateversement+' montant_avant_update= '+montant_avant_update+' destination= '+destination+' idDestination= '+iddestination);
    //var nombredePaiement = $('input:checkbox:checked').length;
    //if (etat == 0) 
    //{
        var iduser = $('#iduser').val();
        var paiement;
        var montant_total = 0;
        /*var new_banque = new_banque.split(/-/);
        var new_idbanque = new_banque[0];
        var new_monnaie_banque = new_banque[1];
        var old_banque = old_banque.split(/-/);
        var old_idbanque = old_banque[0];
        var old_monnaiebanque = old_banque[1];*/
        //var monnaie_paiement;
        //var checkMonnaie = true;
        //var i = 0;
        if (reference == "" || dateversement  == "")
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
            paiement = tb_payement.join('_').trim().substr(1);
            //var old_monnaie_banqque = idversement.split(/-/)[1];
            //var idversement = idversement.split(/-/)[0];
            var idbanque = banque.split(/_/)[0];
            var new_monnaie_banque = banque.split(/_/)[2];

            if (old_monnaie_banque == new_monnaie_banque) 
            {
                $('#deletePayement'+i).val(paiement);
                document.getElementById('updateVerssementForm'+i).submit();
                //paiement = $(this).val().split(/_/);
                /*var xhttp;
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function()
                {
                    if (this.readyState == 4) 
                    {
                        /*var msg = document.getElementById('msg');
                        msg.style.color = 'green';
                        msg.innerHTML = this.responseText;
                        location.reload();*
                        var rep = String(this.responseText).trim();
                        if (rep == '') 
                        {
                            document.location.reload();
                        }
                        else document.getElementById("rep").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET","ajax/comptabilite/update_versement.php?idversement="+idversement+"&reference="+reference+"&idbanque="+idbanque+"&dateversement="+dateversement+"&montant_total="+montant_payement_decocher+"&monnaie="+new_monnaie_banque+"&paiement="+paiement+"&iduser="+iduser,true);
                xhttp.send();*/
            }
            else
            {
                swal({   
                    title: "",   
                    text: "Le compte bancaire ne corespond pas aux payement!",  
                    type:"error", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    /*}
    else
    {
        swal({   
            title: "",   
            text: "Vous ne pouvez modifier ce versement, a ete cloturé!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }*/
}
function deleteVerssement(idversement,etat)
{
    if (etat == 0) 
    {
        var iduser = $('#iduser').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                var res = String(this.responseText).trim();
                if (res == '') 
                {
                    document.location.reload();
                    swal({   
                        title: "",   
                        text: "La suppression reussie!",  
                        type:"success", 
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    document.getElementById("rep").innerHTML = this.responseText;
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
        xhttp.open("GET","ajax/comptabilite/delete_versement.php?idversement="+idversement+"&iduser="+iduser,true);
        xhttp.send();
    }
    else
    {
        swal({   
            title: "",   
            text: "Vous ne pouvez supprimer ce versement, a ete cloturé!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
}
function submitRaportPayement()
{
    /*var cond = $('#cond').val();
    if (cond == '' )
    {
        swal({   
            title: "",   
            text: "Aucune filtre!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        document.getElementById('form-reportpayement').submit();
    }*/
    $('#print').val(1);
    document.getElementById('filtrePayement').submit();
}
function ajout_monnaie(monnaie,iduser)
{
    if (monnaie == '')
        swal({   
            title: "",   
            text: "Veillez entrer la monnaie!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    else if (monnaie.length < 2 || monnaie.length >3)
        swal({   
            title: "",   
            text: "Veillez entrer par ex : USD!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    else
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //document.getElementById("rep").innerHTML = this.responseText;
                var rep =String(this.responseText).trim();
                if(rep == "")
                {
                    //document.getElementById("retour").innerHTML = this.responseText;
                    location.reload();
                    swal({
                        title:"",   
                        text:"",  
                        type:"success", 
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    swal({   
                        title: "",   
                        text: "Une erreur est survenue!", 
                        type:"error",  
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/comptabilite/ajout_monnaie.php?monnaie="+monnaie+"&iduser="+iduser,true);
        xhttp.send(); 
    }
}
function updateMonnaie(id,libelle)
{
    if (libelle == '')
        swal({   
            title: "",   
            text: "Veillez entrer la monnaie!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    else if (libelle.length < 2 || libelle.length >3)
        swal({   
            title: "",   
            text: "Veillez entrer par ex : USD!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    else
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //document.getElementById("rep").innerHTML = this.responseText;
                var rep =String(this.responseText).trim();
                if(rep == "")
                {
                    //document.getElementById("retour").innerHTML = this.responseText;
                    location.reload();
                    swal({
                        title:"",   
                        text:"",  
                        type:"success", 
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    swal({   
                        title: "",   
                        text: this.responseText, 
                        type:"error",  
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/comptabilite/update_monnaie.php?monnaie="+libelle+"&id="+id,true);
        xhttp.send();
    }
}
function deleteMonnaie(id)
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            //document.getElementById("rep").innerHTML = this.responseText;
            var rep =String(this.responseText).trim();
            if(rep == "")
            {
                //document.getElementById("retour").innerHTML = this.responseText;
                location.reload();
                swal({
                    title:"",   
                    text:"",  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                swal({   
                    title: "",   
                    text: this.responseText, 
                    type:"error",  
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/comptabilite/delete_monnaie.php?id="+id,true);
    xhttp.send();
}
function showHideInputMontantOnPayement(elemet,i) 
{
    if (elemet.checked) 
    {
        $("#champtext"+i).show();  
        /*var check = document.getElementsByName('choix_dette');
        for(var j = 0; j < check.length; j++)
        {
            if(check[j].checked == false)
            {
                //valeur = boutons[i].value;
                $("#champtext"+check[j].value).hide();
            }
        }*/
    }
    else 
        $("#champtext"+i).hide();
}
function ajout_paiement(idclient,billing_number,montantpaye,devises,methodepaiement,reference,tva,datepaiements,taux_de_change,exchange_currency,iduser)
{
    var idbanque = '';
    var monnaie_banque;
    var factureSeclect = '';
    var facture_id = '';
    var facture_total = 0;
    var monnaieFacture;
    var tauxFacture = 1;
    var montant_converti = 0;
    //var userName = $('#userName').val();
    //var idclient = idclient.split(/-/);
    //var nombreFacture = $('#nombreFacture').val();
    var nombreFacture = $("#facturepaye :selected").length; 
    var montantpaye = montantpaye.replace(",",".");
    var reference = reference.replace("&","et");
    //var reste =0;
    //var montantError = '';
    var erreur = "";   

    if(idclient == "" || methodepaiement == "" || devises == "" || taux_de_change == "" || exchange_currency == "" || datepaiements == "")
    {
        swal({   
            title: "",   
            text: "Veillez renseiger les champs en * !", 
            type:"error",  
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else if(nombreFacture == 0)
    {
        swal({   
            title: "",   
            text: "Veillez choisir au moins une facture !", 
            type:"error",  
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {
        tauxFacture = taux_de_change;
        $("#facturepaye :selected").each(function(){
            factureSeclect += $(this).val()+'/';
        });
        if(methodepaiement !='CASH')
        {
            var banque = $('#banque').val().split(/-/);
            idbanque = banque[0];
            monnaie_banque = banque[1];
            if (idbanque == "") erreur = "Veuillez choisir la banque";
            else if (monnaie_banque != devises) erreur = "La monnaie n'est doit etre differente a celle de la banque";
        }
        /*for (var i = 0; i < nombreFacture; i++) 
        {
            if (document.getElementById('facturepaye'+i).checked == true) 
            {
                factureSeclect += $('#facturepaye'+i).val()+'-'+$('#montant'+i).val()+'/';
                facture_total += parseFloat($('#facturepaye'+i).val().split(/-/)[1]);
                if ($('#montant'+i).val() == '' || $('#montant'+i).val() > parseFloat($('#facturepaye'+i).val().split(/-/)[1])) 
                    montantError = '1';
                else
                montantpaye += parseFloat($('#montant'+i).val());
            }
        }
        if (factureSeclect == '' || montantpaye > facture_total) 
        {
            swal({   
                title: "",   
                text: "vous devez cocher la facture et le montant paye doit etre <= au montant total de la facture!", 
                type:"error",  
                timer: 3000,   
                showConfirmButton: false 
            });
        }
        else if (montantError != '') 
        {
            swal({   
                title: "",   
                text: "le montant payé de chaque facture cocher doit etre <= montant da la facture!", 
                type:"error",  
                timer: 3000,   
                showConfirmButton: false 
            });
        }
        else
        {*/
            if (erreur != "") 
            {
                swal({   
                    title: "",   
                    text: erreur, 
                    type:"error",  
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                if (exchange_currency != devises) 
                {
                    if (devises == 'USD') 
                    {
                        montant_converti = montantpaye * tauxFacture;
                    }
                    else
                    {
                        montant_converti = montantpaye / tauxFacture;
                    }
                }
                else
                {
                    montant_converti = montantpaye;
                    //montant += montantFacture;
                }
                var xhttp;
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function()
                {
                    if (this.readyState == 4) 
                    {
                        //document.getElementById("rep").innerHTML = this.responseText;
                        var rep =String(this.responseText).trim();
                        if(rep == "")
                        {
                            document.location.reload();
                            swal({
                                title:"",   
                                text:"",  
                                type:"success", 
                                timer: 3000,   
                                showConfirmButton: false 
                            });
                        }
                        else
                        {
                            document.getElementById('rep').innerHTML = this.responseText;
                            swal({   
                                title: "",   
                                text: "Une erreur est survenue!", 
                                type:"error",  
                                timer: 3000,   
                                showConfirmButton: false 
                            });
                        }
                    }
                    else
                        swal({   
                            title: "",   
                            text: "traitement en cours",   
                            showConfirmButton: false 
                        });
                };
                xhttp.open("GET","ajax/comptabilite/ajout_paiement.php?idclient="+idclient+"&facture="+factureSeclect+"&montantpaye="+montantpaye+"&devises="+devises+"&methodepaiement="+methodepaiement+"&taux_de_change="+tauxFacture+"&exchange_currency="+exchange_currency+"&montant_converti="+montant_converti+"&reference="+encodeURIComponent(reference)+"&datepaiements="+datepaiements+"&iduser="+iduser+"&nombreFacture="+nombreFacture+"&billing_number="+billing_number+"&idbanque="+idbanque+"&tva="+tva,true);
                xhttp.send();
            }
        //}
    }
}
function update_paiement(idclient,billing_number,idpaiement,montantpayer,old_montant,monnaie,methode,reference,tva,datepaiements,taux_de_change,exchange_currency,i,iduser,status,deposed)
{
    /*if (parseInt(status) == 1) 
    {
        swal({   
            title: "",   
            text: "Ce payement a été deja cloturé, aucune action ne peut etre effectueé!", 
            type:"error",  
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {*/
        //var montantError = '';
        var montantpayer = montantpayer.replace(",",".");
        var factureSeclect = '';
        //var facture_total = 0;
        var montant_converti = 0;
        var idbanque = "";
        var reference = reference.replace("&","et");
        var erreur = "";
        var nombreFacturePayer = $("#facturepayer"+i+" :selected").length; 
        //var y = id_derniereFacture - nombreFacturePayer;
        $("#facturepayer"+i+" :selected").each(function(){
            factureSeclect += $(this).val()+'/';
        });
        /*for (var j = 0; j < nombreFacturePayer; j++) 
        {
            y++;
            factureSeclect += $('#facturepayer'+y).val()+'-'+$('#montant_payer'+y).val()+'/';
            facture_total += parseFloat($('#facturepayer'+y).val().split(/-/)[1]);
            //if ($('#montant_payer'+y).val() == '' || $('#montant_payer'+y).val() > parseFloat($('#facturepayer'+y).val().split(/-/)[1])) 
                //montantError = '1';
            //else
            montantpayer += parseFloat($('#montant_payer'+y).val());
        }
        if (nombreFacturePayer == 0)
        {
            montantpayer = $('#montantpaye'+i).val();
            if (exchange_currency != monnaie) 
            {
                if (monnaie == 'USD') 
                {
                    montant_converti = montantpayer * taux_de_change;
                }
                else
                {
                    montant_converti = montantpayer / taux_de_change;
                }
            }
            else
            {
                montant_converti = montantpayer;
                //montant += montantFacture;
            }
        }  
        else
        {
            if (exchange_currency != monnaie) 
            {
                if (monnaie == 'USD') 
                {
                    montant_converti = montantpayer * taux_de_change;
                }
                else
                {
                    montant_converti = montantpayer / taux_de_change;
                }
            }
            else
            {
                montant_converti = montantpayer;
                //montant += montantFacture;
            }
            //if (montant_converti > facture_total) 
                //montantError = '1';
        //}*/
        if (idclient == "" || methode == "" || monnaie == "" || taux_de_change == "" || exchange_currency == "" || datepaiements =="") 
        {
            swal({   
                title: "",   
                text: "Veillez renseiger les champs en *!", 
                type:"error",  
                timer: 3000,   
                showConfirmButton: false 
            });
        }
        else
        {
            if (methode !='CASH') 
            {
                //if(typeof document.getElementById('banque'+i) !== 'undefined' && document.getElementById('banque'+i) != null ) 
                //{
                    var banque = $('#banque'+i).val().split(/-/);
                    idbanque = banque[0];
                    var monnaie_banque = banque[1];
                    if (idbanque == "") erreur = "Veuillez choisir la banque";
                    else if (monnaie_banque != monnaie) erreur = "La monnaie n'est doit etre differente a celle de la banque";
                //}
            }
            if (erreur != '') 
            {
                swal({   
                    title: "",   
                    text: erreur, 
                    type:"error",  
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                if (exchange_currency != monnaie) 
                {
                    if (monnaie == 'USD') 
                    {
                        montant_converti = montantpayer * taux_de_change;
                    }
                    else
                    {
                        montant_converti = montantpayer / taux_de_change;
                    }
                }
                else
                {
                    montant_converti = montantpayer;
                    //montant += montantFacture;
                }
                
                //var userName = $('#userName').val();
                var xhttp;
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function()
                {
                    if (this.readyState == 4) 
                    {
                        //if ($('#page').val() == 'paiement') 
                        //{
                            var rep =String(this.responseText).trim();
                            if(rep == "")
                            {
                                document.location.reload();
                                swal({
                                    title:"",   
                                    text:"",  
                                    type:"success", 
                                    timer: 3000,   
                                    showConfirmButton: false 
                                });
                            }
                            else
                            {
                                //document.getElementById('rep').innerHTML = this.responseText;
                                swal({   
                                    title: "",   
                                    text: "Une erreur est survenue!", 
                                    type:"error",  
                                    timer: 3000,   
                                    showConfirmButton: false 
                                });
                            }
                        //}
                        /*else
                        {
                            document.location.reload();
                        }*/
                    }
                };
                xhttp.open("GET","ajax/comptabilite/update_paiement.php?idclient="+idclient+"&idpaiement="+idpaiement+"&old_montant="+old_montant+"&montantpaye="+montantpayer+"&monnaie="+monnaie+"&taux_de_change="+taux_de_change+"&exchange_currency="+exchange_currency+"&montant_converti="+montant_converti+"&methode="+methode+"&reference="+encodeURIComponent(reference)+"&datepaiements="+datepaiements+"&facture="+factureSeclect+"&nombreFacturePayer="+nombreFacturePayer+"&iduser="+iduser+"&billing_number="+billing_number+"&idbanque="+idbanque+"&tva="+tva+"&deposed="+deposed,true);
                xhttp.send();
            }
        }
    //}
}
function deletePaiement(idpaiement,idclient,montant,status,deposed)
{
    //alert('idpaiement: '+idpaiement+' idclient: '+idclient+' montant: '+montant+' status: '+status);
    /*if (parseInt(deposed) == 1) 
    {
        swal({   
            title: "",   
            text: "Ce payement a été deja verssé, vous ne pouvez pas le supprimer!", 
            type:"error",  
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else
    {*/
        //alert(idpaiement+" idclient: "+idclient);
        var iduser = $('#iduser').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                //if ($('#page').val() == 'paiement') 
                //{
                    var rep =String(this.responseText).trim();
                    if(rep == "")
                    {
                        document.location.reload();
                        swal({
                            title:"",   
                            text:"",  
                            type:"success", 
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    else
                    {
                        document.getElementById('rep').innerHTML = this.responseText;
                        swal({   
                            title: "",   
                            text: "Une erreur est survenue!", 
                            type:"error",  
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                //}
                /*else
                {
                    document.location.reload();
                }*/
            }
        };
        xhttp.open("GET","ajax/comptabilite/deletePaiement.php?idpaiement="+idpaiement+"&iduser="+iduser+"&idclient="+idclient+"&montant="+montant+"&deposed="+deposed,true);
        xhttp.send();
    //}
}
function close_paiement()
{
    var idUser = $('#iduser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            var rep =String(this.responseText).trim();
            if(rep == "")
            {
                document.location.reload();
                swal({
                    title:"",   
                    text:"",  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                //document.getElementById('rep').innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "Une erreur est survenue!", 
                    type:"error",  
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/comptabilite/closePaiement.php?idUser="+idUser,true);
    xhttp.send();
}
/*var total = 0.00;
$('#facturepaye').change(function() {
    
    $("#facturepaye :selected").each(function(){
        factureSeclect = $(this).val().split(/-/);
        total += parseFloat(factureSeclect[1]); 
    });
    //factureTable = factureSeclect.split(/-/);
    //$('#totalPaier').val(factureSeclect);
    $('#montantpaye').val(total);

});*/

function setMontant()
{
    $("#facturepaye :selected").each(function(){
        factureSeclect = $(this).val().split(/-/); 
    });
    //factureTable = factureSeclect.split(/-/);
    $('#totalPaier').val(factureSeclect);
    $('#montantpaye').val(factureSeclect[1]);
}
function getMontantPaiementVerser(idbank,datepaiement)
{
    //alert(idbank+' '+datepaiement);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                msg = document.getElementById("afficheMontant");
                msg.style.color = 'green';
                msg.innerHTML = this.responseText;
                //document.getElementById("retour").innerHTML = this.responseText;
            }
        };
    xhttp.open("GET","ajax/comptabilite/getMontantPaiementVerser.php?idbank="+idbank+"&datepaiement="+datepaiement,true);
    xhttp.send();
}
var selectedPayementToAddOnVerssementCount = 0;
function getSelectedPayementToAddOnVerssement(elemet)
{
    if (elemet.checked == true) 
    {
        selectedPayementToAddOnVerssementCount ++;
    }
    else selectedPayementToAddOnVerssementCount --;
}
function addPayementToVerssement(verssement_id)
{
    var error = '';
    if (verssement_id === "") error = "Veuillez entrer l'id de versement\n";
    //else if (!Number.isInteger(verssement_id)) error += "Veuillez entrer un nombre\n";
    else if (selectedPayementToAddOnVerssementCount == 0) error += "Veuillez selectionner le payement";
    if (error == '') document.getElementById('addPayementToVerssementForm').submit();
    else
        swal({   
            title: "",   
            text: error, 
            type:"error",  
            timer: 2000,   
            showConfirmButton: false 
        });
}
function cloturerVersement()
{
    var iduser = $('#iduser_verser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            //msg = document.getElementById("afficheMontant");
            //msg.style.color = 'green';
            //msg.innerHTML = this.responseText;
            //document.getElementById("rep").innerHTML = this.responseText;
            var rep =String(this.responseText).trim();
            if(rep == "")
            {
                document.location.reload();
                swal({
                    title:"",   
                    text:"",  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                document.getElementById('rep').innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "Une erreur est survenue!", 
                    type:"error",  
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/comptabilite/cloturerVersement.php?iduser="+iduser,true);
    xhttp.send();
}
function creerCaisse(nomcaisse,monnaie,statut,responsable,datecreation,iduser,type,description)
{
    //alert(nomcaisse+" "+monnaie+" "+lignecredit+" "+statut+" "+responsable+" "+datecreation+" "+idusers+" "+dimmension+" "+description);
    if(nomcaisse == "" || monnaie == "" || statut =="" || responsable =="" || datecreation == "" || type == "")
    {
        // alert('vous devez remplir tous les champs');
        swal({   
            title: "",   
            text: "Veillez remplir tous les champs en *", 
            type:"error",  
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        //var userName = $('#userName').val();
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
                        text: "Creation reussie!", 
                        type:"success",  
                        timer: 2000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    swal({   
                        title: "",   
                        text: rep, 
                        type:"error",  
                        timer: 2000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/comptabilite/creerCaisse.php?nomcaisse="+nomcaisse+"&monnaie="+monnaie+"&statut="+statut+"&responsable="+responsable+"&datecreation="+datecreation+"&iduser="+iduser+"&type="+type+"&description="+description,true);
        xhttp.send();
    }
}
function deleteCaisse(idcaisse)
{
    var iduser = $('#iduser').val();
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
                text: "Une erreur s'est produite", 
                type:"error",  
                timer: 2000,   
                showConfirmButton: false 
            });
        }
    };
    xhttp.open("GET","ajax/comptabilite/deleteCaisse.php?idcaisse="+idcaisse+"&iduser="+iduser,true);
    xhttp.send();
}
function updateCaisse(idcaisse,nomcaisse,monnaie,statut,responsable,datecreation,oldType,type,description,iduser)
{
    //alert('idcaisse : '+idcaisse+' nomcaisse : '+nomcaisse+' monnaie : '+monnaie+' lignecredit :'+lignecredit+' statut :'+statut+' responsable :'+responsable+' oldType: '+oldType+' type: '+type+' datecreation :'+datecreation+' description :'+description+' iduser: '+iduser);
    if (nomcaisse =="" || datecreation =="") 
    {
        //alert('Completez les champs vide');
        swal({   
            title: "",   
            text: "Completez les champs en * !", 
            type:"error",  
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        //var userName = $('#userName').val();
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
                        text: "Modification reussie !", 
                        type:"success",  
                        timer: 2000,   
                        showConfirmButton: false 
                    });
                }
                else
                swal({   
                    title: "",   
                    text: rep, 
                    type:"error",  
                    timer: 2000,   
                    showConfirmButton: false 
                });
            }
        };
        xhttp.open("GET","ajax/comptabilite/updateCaisse.php?idcaisse="+idcaisse+"&nomcaisse="+nomcaisse+"&monnaie="+monnaie+"&statut="+statut+"&responsable="+responsable+"&datecreation="+datecreation+"&iduser="+iduser+"&oldType="+oldType+"&type="+type+"&description="+description,true);
        xhttp.send();
    }
}
function approvisionner(banque,montantApprovisionne,caissedestination,datevirement,reference,iduser)
{
    //alert('montant: '+montantApprovisionne+' caisse: '+caissedestination+' date: '+datevirement+' iduser: '+iduser);
    if(banque === "" || montantApprovisionne === "" || caissedestination === "" || datevirement === "" || reference === "")
    {
        //alert('vous devez remplir tous les champs');
        swal({   
            title: "",   
            text: "Veillez remplir les champs en * !", 
            type:"error",  
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        var erreur = '';
        //var userName = $('#userName').val();
        var monnaieProv = '';
        var montantProv = 0;
        var idProvenence;
        var nomProv;
        var caissedestination = caissedestination.split(/_/);
        var idcaisseDest = caissedestination[0];
        var lignecredit = parseFloat(caissedestination[1]);
        var monnaieCaisseDest = caissedestination[2];
        var nom_caisseDest = caissedestination[3];

        var banque = banque.split(/_/);
        var idProvenence = banque[0];
        var montantProv = banque[1];
        var monnaieProv = parseFloat(banque[2]);
        var nomProv = banque[3];
        var creditLine = parseFloat(banque[4]);
        montantProv += creditLine;
        /*if (provenence == 'banque') 
        {
            var banque = $('#banque').val().split(/_/);
            idProvenence = banque[0];
            montantProv = banque[1];
            monnaieProv = banque[2];
            nomProv = banque[3];
        }
        else if (provenence == 'caisse')
        {
            var caisseProvenence = $('#caisse').val().split(/_/);
            idProvenence = caisseProvenence[0];
            montantProv = caisseProvenence[1];
            monnaieProv = caisseProvenence[2];
            nomProv = caisseProvenence[3];
            //alert('monnaieCaisseProv: '+monnaieCaisseProv+' monnaieCaisseDest: '+monnaieCaisseDest);
            if (idcaisseDest == idProvenence)
                erreur += "La meme caisse ne peut pas s'approvisionner, \n"; 
        }*/
        if (parseFloat(montantApprovisionne) > montantProv) 
        {
            //alert('Le montant entree est superieur au montant existant dans la caisse');
            /*swal({   
                title: "",   
                text: "Le montant entree est superieur au montant de provenance!", 
                type:"error",  
                timer: 2000,   
                showConfirmButton: false 
            });*/
            erreur += "Le montant entree est superieur au montant de provenance, \n";
        }
        if (monnaieProv != monnaieCaisseDest) 
        {
            //alert('la caisse doit etre de meme nature');
            /*swal({   
                title: "",   
                text: "La monnaie de provenance et destination doit etre la meme!", 
                type:"error",  
                timer: 2000,   
                showConfirmButton: false 
            });*/
            erreur += "La monnaie de provenance et destination doit etre la meme, \n";
        }
        /*if (parseFloat(montantApprovisionne) > lignecredit) 
        {
            //alert('vous ne pouvez pas deposer le montant superieur a '+lignecredit);
            /*swal({   
                title: "",   
                text: "vous ne pouvez pas deposer le montant superieur a "+lignecredit, 
                type:"error",  
                timer: 2000,   
                showConfirmButton: false 
            });*
            erreur += "vous ne pouvez pas deposer le montant superieur a "+lignecredit+"\n";
        }*/
        if (erreur != '') 
        {
            swal({   
                title: "",   
                text: erreur, 
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
                    var rep =String(this.responseText).trim();
                    //document.getElementById("rep").innerHTML = this.responseText;
                    if(rep == "")
                    {
                        document.location.reload();
                        swal({
                            title:"",   
                            text:"",  
                            type:"success", 
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                    else
                    {
                        swal({
                            title:"",   
                            text:"Une erreur s'est produite",  
                            type:"error", 
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                        document.getElementById("rep").innerHTML = this.responseText;
                    }
                }
            };
            xhttp.open("GET","ajax/comptabilite/ApprovisionnerCaisse.php?idcaisseDest="+idcaisseDest+"&nom_caisseDest="+nom_caisseDest+"&idProvenence="+idProvenence+"&montantApprovisionne="+montantApprovisionne+"&datevirement="+datevirement+"&iduser="+iduser+"&nomProv="+nomProv+"&monnaieProv="+monnaieProv+"&iduser="+iduser+"&reference="+reference,true);
            xhttp.send();
        }
    }
}
function cloturerApprovisionnement()
{
    var iduser = $('#iduser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            //msg = document.getElementById("afficheMontant");
            //msg.style.color = 'green';
            //msg.innerHTML = this.responseText;
            //document.getElementById("rep").innerHTML = this.responseText;
            var rep =String(this.responseText).trim();
            if(rep == "")
            {
                document.location.reload();
                swal({
                    title:"",   
                    text:"",  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                //document.getElementById('rep').innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "Une erreur est survenue!", 
                    type:"error",  
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/comptabilite/cloturerApprovisionnement.php?iduser="+iduser,true);
    xhttp.send();
}
function deleteAprovisionement(idapro,etat)
{
    //alert('idapro: '+idapro+' etat: '+etat);
    if (etat == 0) 
    {
        var iduser = $('#iduser').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                var res = String(this.responseText).trim();
                if (res == '') 
                {
                    document.location.reload();
                    swal({   
                        title: "",   
                        text: "La suppression reussie!",  
                        type:"success", 
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    document.getElementById("rep").innerHTML = this.responseText;
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
        xhttp.open("GET","ajax/comptabilite/delete_approvisionement.php?idapro="+idapro+"&iduser="+iduser,true);
        xhttp.send();
    }
    else
    {
        swal({   
            title: "",   
            text: "Vous ne pouvez supprimer ce versement, a ete cloturé!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
}
function getProvenceApprovionnement(type)
{
    if (type != '') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    document.getElementById("divInclubanqueCaisse").innerHTML = this.responseText;
                }
            };
        xhttp.open("GET","ajax/comptabilite/inclureBanqueEtCaisseToAproviCaisse.php?type="+type,true);
        xhttp.send();
    }
}
function inclureProvenenceToApprovisioneCompteComptable(type)
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
                    document.getElementById("divInclubanqueCaisse").innerHTML = this.responseText;
                }
            };
        xhttp.open("GET","ajax/comptabilite/inclureProvenenceToApprovisioneCompteComptable.php?type="+type,true);
        xhttp.send();
    }
}

function creationCompteComptable(code,nomcompte,lignecredit,monnaie,datecompte,note,utilisateur)
{
   // alert(code+'/'+nomcompte+'/'+lignecredit+'/'+monnaie+'/'+datecompte+'/'+note+'*'+utilisateur);
    if(code === "" || nomcompte === "" || lignecredit === "" || monnaie === "" || datecompte === "" || note === "" || utilisateur ==="" )
    {
        //alert('vous devez remplir tous les champs');
        swal({
            title :"Information",
            text :"vous devez remplir tout les champs",
            type:"success",
            timer :3000,
            showConfirmButton :false
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
                document.getElementById("rep").innerHTML = this.responseText;
                swal({
                    title :"Information",
                    text :"Creation du nouveau compte reusie",
                    type:"success",
                    timer :3000,
                    showConfirmButton :true
                });
            }
        };
        xhttp.open("GET","ajax/comptabilite/CreerCompteComptable.php?code="+code+"&nomcompte="+nomcompte+"&lignecredit="+lignecredit+"&monnaie="+monnaie+"&datecompte="+datecompte+"&note="+note+"&utilisateur="+utilisateur+"&userName"+userName,true);
        xhttp.send();
    }
}
function approvisionnercomptespi(provenance,montant,destination,dateapprovisionement,iduser)
{
    //alert(montant+'/'+destination+'/'+dateapprovisionement);
    if(montant === "" )
    {
        //alert('vous devez remplir le montant');
        swal({
            title :"Information",
            text :"vous devez remplir le montant",
            type:"success",
            timer :3000,
            showConfirmButton :true
        });
    }
    else 
    {
        var userName = $('#userName').val();
        var destination = $('#destination').val().split(/_/);
        var idcompte = destination [0];
        var lignecredit = destination [1];
        var monnaiedestination = destination[2];
        var nomcompte = destination[3];

        if (provenance == 'caisse') 
        {
            var caisse = $('#caisse').val().split(/_/);
            var idcaisse = caisse[0];
            var montantcaisse = caisse[1];
            var monnaie = caisse[2];
            var nomcais = caisse[3];

            if (parseFloat(montant) > parseFloat(montantcaisse)) 
            {
                //alert('Le montant entree est superieur au montant existant dans la caisse');
                swal({
                    title :"Information",
                    text :"Le montant entree est superieur au montant existant dans la caisse",
                    type:"success",
                    timer :2000,
                    showConfirmButton :true
                });
            }
            else if (parseFloat(montant) > parseFloat(lignecredit)) 
            {
               //alert('Le montant entree est superieur au ligne de credit de ce compte');
                swal({
                    title :"Information",
                    text :"Le montant entree est superieur au ligne de credit",
                    type:"success",
                    timer :3000,
                    showConfirmButton :true
                });
            }
            else if (monnaie != monnaiedestination) 
            {
                //alert('la caisse doit etre de meme nature ');
                swal({
                    title :"Information",
                    text :" la caisse et le compte doivent etre de meme nature",
                    type:"success",
                    timer :3000,
                    showConfirmButton :true
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
                        //document.getElementById("retour").innerHTML = this.responseText;
                        var message = String(this.responseText).trim();
                        if (message = "ok") 
                        {
                            //document.getElementById("rep").innerHTML = this.responseText;
                            location.reload();
                            swal({   
                                title: "Information!",   
                                text: "Approvisionement reussi",
                                type:"success",   
                                timer: 1000,   
                                showConfirmButton: false 
                            });
                        }
                    }
                };
                xhttp.open("GET","ajax/comptabilite/ApprovisionerCompteComptable.php?provenance="+provenance+"&idcaisse="+idcaisse+"&montant="+montant+"&idcompte="+idcompte+"&nomcompte="+nomcompte+"&dateapprovisionement="+dateapprovisionement+"&monnaie="+monnaie+"&iduser="+iduser+"&userName="+userName,true);
                xhttp.send();
            }
            //alert(caisseProv+'-'+devise);
        }
        else if (provenance == 'banque') 
        {
            var banque = $('#banque').val().split(/_/);
            var idBanque = banque [0];
            var montantbanque = banque [1];
            var monaibanque = banque [2];
            if (parseFloat(montant) > parseFloat(montantbanque)) 
            {
                //alert('Le montant entree est superieur au montant existant dans la banque');
                swal({   
                    title: "Attention!",   
                    text: "Le montant entree est superieur au montant existant dans la banque",  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else if (parseFloat(montant) > parseFloat(lignecredit)) 
            {
                //alert('Le montant entree est superieur au ligne de credit de ce compte');
                swal({   
                    title: "Attention!",   
                    text: "Le montant entree est superieur au ligne de credit de ce compte",  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else if (monaibanque != monnaiedestination) 
            {
                //alert('la banque doit etre de meme nature ');
                 swal({   
                    title: "Attention!",   
                    text: "la banque et le compte doivent etre de meme nature",  
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
                        //document.getElementById("retour").innerHTML = this.responseText;
                        location.reload();
                        swal({   
                            title: "Approvisionement reussi!",   
                            text: "vous venez de faire un approvisionement",  
                            type:"success", 
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                    }
                };
                xhttp.open("GET","ajax/comptabilite/ApprovisionerCompteComptable.php?provenance="+provenance+"&idBanque="+idBanque+"&montant="+montant+"&idcompte="+idcompte+"&nomcompte="+nomcompte+"&dateapprovisionement="+dateapprovisionement+"&monnaie="+monaibanque+"&iduser="+iduser+"&userName="+userName,true);
                xhttp.send();
            }
       }
    } 
}
function update_comptespi(code,idcompte,nomcompte,lignecredit,monnaie,datecompte,montantcompte,commentaire)
{
    //alert(code+idcompte+nomcompte+lignecredit+monnaie+datecompte+montantcompte+commentaire);
    if (code === "" || idcompte === "" || nomcompte === "" || lignecredit === "" || monnaie === "" || datecompte === "" || montantcompte === "" || commentaire === "")
    {
        swal({   
            title: "Attention!",   
            text: "vous devez remplir tout les champs",  
            type:"success", 
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
                document.getElementById("rep").innerHTML = this.responseText;
                swal({   
                    title: "Modification réussie!",   
                    text: "vous venez de modifier avec succes",  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }; 
        xhttp.open("GET","ajax/comptabilite/modifier_compte_comptable.php?code="+code+"&idcompte="+idcompte+"&nomcompte="+nomcompte+"&lignecredit="+lignecredit+"&monnaie="+monnaie+"&datecompte="+datecompte+"&montantcompte="+montantcompte+"&commentaire="+commentaire+"&userName="+userName,true);
        xhttp.send();
    }
}
function deleteCompteComptable(idcompte)
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
                title: "suppression reussie",   
                text: "vous venez de supprimer avec success",  
                type:"success", 
                timer: 3000,   
                showConfirmButton: false 
            });
        }
    };
    xhttp.open("GET","ajax/comptabilite/deleteCompteComptable.php?idcompte="+idcompte+"&userName="+userName,true);
    xhttp.send();
} 
function resetFiltrepaiement()
{
    //document.location.reload();
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"paiement";
}
function filtrepaiment(nom_client,date1,date2,mois,annee,billing_number)
{
    var WEBROOT = $('#WEBROOT').val();
    //var varclient = client_filter_fact.split(/-/);
    //var idclient = client_filter_fact.split(/-/)[1];
    //alert(idclient+' '+date1+' '+date2+' '+mois+' '+annee);
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4;
    var condition5;
    var condition6; 
    var condition = '';

    if (nom_client == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " cl.Nom_client LIKE '%"+nom_client+"%' ";
    }
    if (date1 == '') 
    {
        condition2 = '';
    }
    else
    {
        condition2 = " p.datepaiement='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition3 = '';
    }
    else
    {
        if (date1 != '') 
        {
            //condition3 = " p.datepaiement BETWEEN '"+date1+"' AND '"+date2+"'";
            condition3 = " p.datepaiement BETWEEN '"+date1+"' AND '"+date2+"'";
            condition2 = '';
        }
        else condition3 = " p.datepaiement='"+date2+"' ";
    }
    if (mois == '') condition4 = '';
    else condition4 = " MONTH(p.datepaiement)="+mois+" ";
    if (annee == '') condition5 = '';
    else condition5 = " YEAR(p.datepaiement)="+annee+" ";
    if (condition1 != '') condition5 = '';
    if (billing_number == '') condition6 = '';
    else condition6 = " cl.billing_number="+billing_number;

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
            text: "Aucune donneé filtreé",
            type:"error",   
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        var l = $('#l').val();
        var c = $('#c').val();
        var m = $('#m').val();
        var s = $('#s').val();
        $('#cond').val(condition);
        var iduser = $('#iduser').val();
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
        xhttp.open("GET","ajax/comptabilite/filtre_paiement.php?condition="+condition+"&WEBROOT="+WEBROOT+"&l="+l+"&c="+c+"&m="+m+"&s="+s+"&iduser="+iduser,true);
        xhttp.send();
    }
}
function filtreBanque(name,numero,statut) 
{
    //alert('nom: '+name+' numero: '+numero+' statut: '+statut);
    var WEBROOT = $('#WEBROOT').val();
    var condition1;
    var condition2;
    var condition3; 
    var condition = '';

    if (name == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " nom= '"+name+"' ";
    }
    if (numero == '') 
    {
        condition2 = '';
    }
    else
    {
        condition2 = " numero='"+numero+"' ";
    }
    if (statut == '') 
    {
        condition3 = '';
    }
    else
    {
        condition3 = " statut='"+statut+"' ";
    }

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition = condition1+condition2+condition3;
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
        var l = $('#l').val();
        var c = $('#c').val();
        var m = $('#m').val();
        var s = $('#s').val();
        condition = condition.substr(3);
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
        xhttp.open("GET","ajax/comptabilite/filtre_banque.php?condition="+condition+"&WEBROOT="+WEBROOT+"&l="+l+"&c="+c+"&m="+m+"&s="+s,true);
        xhttp.send();
    }
}
function filtreVerssement(idbanque,date1,date2)
{
    //alert('idbanque: '+idbanque+' date1: '+date1+' date2: '+date2);
    var WEBROOT = $('#WEBROOT').val();
    var condition1;
    var condition2;
    var condition3;
    var condition = '';

    if (idbanque == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " b.ID_banque="+idbanque+" ";
    }
    if (date1 == '') 
    {
        condition2 = '';
    }
    else
    {
        condition2 = " bj.date_operation='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition3 = '';
    }
    else
    {
        if (date1 != '') 
        {
            condition3 = " bj.date_operation BETWEEN '"+date1+"' AND '"+date2+"'";
            condition2 = '';
        }
        else condition3 = " bj.date_operation='"+date2+"' ";
    }

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition = condition1+condition2+condition3;
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
                document.getElementById('rep').innerHTML = this.responseText;
                $('#myTable').DataTable(); 
            }
        };
        xhttp.open("GET","ajax/comptabilite/filtre_verssement.php?condition="+condition+"&WEBROOT="+WEBROOT+"&l="+l+"&c="+c+"&m="+m+"&s="+s,true);
        xhttp.send();
    }
}
function resetFiltreVerssement()
{
    //document.location.reload();
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"banque_de_versement";
}
function filtreCaisse(name,etat) 
{
    //alert('name: '+name+' status: '+status);
    var WEBROOT = $('#WEBROOT').val();
    var condition1;
    var condition2;
    var condition = '';

    if (name == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " nomCaisse LIKE '%"+name+"%' ";
    }
    if (etat == '') 
    {
        condition2 = '';
    }
    else
    {
        condition2 = " etat='"+etat+"' ";
    }

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition = condition1+condition2;
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
        var l = $('#l').val();
        var c = $('#c').val();
        var m = $('#m').val();
        var s = $('#s').val();
        //condition = condition.substr(3);
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
        xhttp.open("GET","ajax/comptabilite/filtre_caisse.php?condition="+condition+"&WEBROOT="+WEBROOT+"&l="+l+"&c="+c+"&m="+m+"&s="+s,true);
        xhttp.send();
    }
}
function resetFiltreCaisse()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"caisse";
}
function filtreApprovisionnement(idbanque,date1,date2,idcaisse)
{
    //alert('idbanque: '+idbanque+' date1: '+date1+' date2: '+date2+' idcaisse: '+idcaisse);
    var WEBROOT = $('#WEBROOT').val();
    var condition1 = '';
    var condition2 = '';
    var condition3 = '';
    var condition4 = '';
    var condition = '';

    if(idbanque != '')
    {
        condition1 = " b.ID_banque="+idbanque+" ";
    }
    if(date1 != '')
    {
        condition2 = " date_operation='"+date1+"' ";
    }
    if(date2 != '')
    {
        if (date1 != '') 
        {
            condition3 = " date_operation BETWEEN '"+date1+"' AND '"+date2+"'";
            condition2 = '';
        }
        else condition3 = " date_operation='"+date2+"' ";
    }
    if (idcaisse != '') 
    {
        condition4 = " c.ID_caisse="+idcaisse+" ";
    }

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);
    condition = condition1+condition2+condition3+condition4;
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
                document.getElementById('rep').innerHTML = this.responseText;
                $('#myTable').DataTable(); 
            }
        };
        xhttp.open("GET","ajax/comptabilite/filtre_approvisionnement.php?condition="+condition+"&WEBROOT="+WEBROOT+"&l="+l+"&c="+c+"&m="+m+"&s="+s,true);
        xhttp.send();
    }
}
function resetFiltreApprovisionnement()
{
    //document.location.reload();
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"approvisionnement";
}
function addPetiteDepense(caisse,montant,motif,datedepense,categorie,iduser)
{
    //alert('caisse: '+caisse+' montant: '+montant+' motif: '+motif+' datedepense: '+datedepense+' categorie: '+categorie);
    if(caisse == "" || montant == "" || motif == "" || datedepense == "" || categorie == "")
    {
        //var msg = document.getElementById('msg');
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
        var userName = $('#userName').val();
        var idprovenance;
        var monnaie;
        var montantprovenance;
        var caisse = caisse.split(/_/);
            idprovenance = caisse[0];
            montantprovenance = caisse[1];
            monnaie = caisse[2];
        if (parseFloat(montantprovenance) < parseFloat(montant))
            swal({   
                title: "",   
                text: "le montant entree > au montant en caisse",
                type:"error",   
                timer: 2000,   
                showConfirmButton: false 
            });
        else
        {
            var idcategorie = categorie.split(/-/)[0];
            var description = categorie.split(/-/)[1];
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("retour").innerHTML = this.responseText;
                    var message = String(this.responseText).trim();
                    if (message == '') 
                    {
                        //document.getElementById("rep").innerHTML = this.responseText;
                        location.reload();
                        swal({   
                            title: "",   
                            text: "",
                            type:"success",   
                            timer: 10000,   
                            showConfirmButton: false 
                        });
                    }                
                    else
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite!",
                        type:"error",   
                        timer: 10000,   
                        showConfirmButton: false 
                    });
                    //document.getElementById("rep").innerHTML = this.responseText;
                    /*$('#montantDepense').val('');
                    $('#motifs').val('');
                    $('#datedepense').val('');*/
                }
            };
            xhttp.open("GET","ajax/comptabilite/addPetiteDepense.php?idprovenance="+idprovenance+"&montant="+montant+"&monnaie="+monnaie+"&motif="+motif+"&datedepense="+datedepense+"&iduser="+iduser+"&idcategorie="+idcategorie+"&description="+description+"&userName="+userName,true);
            xhttp.send();
        }
    }
}
function updatePetiteDepense(oldCaisse,oldMontant,iddepense,datedepense,motif,categorie,caisse,montant,etat)
{
    //alert('oldCaisse: '+oldCaisse+' oldMontant: '+oldMontant+' iddepense:'+iddepense+' datedepense: '+datedepense+' motif: '+motif+' categorie: '+categorie+' caisse: '+caisse+' montant: '+montant);

    if (etat == 0) 
    {
        if (datedepense == "" || motif == "" || categorie == "" || montant == "")
        {
            swal({   
                title: "",   
                text: "remplissez tous les champs en *",  
                type:"error", 
                timer: 3000,   
                showConfirmButton: false 
            });
        }
        else  
        {
            var caisse = caisse.split(/_/);
            idCaisse = caisse[0];
            montantCaisse = caisse[1];
            monnaie = caisse[2];
            var categorie = categorie.split(/_/);
            idCategorie = categorie[0];
            descriptionCategorie = categorie[1];
            //reference = $('#reference').val();
            if (parseFloat(montantCaisse) < parseFloat(montant))
                swal({   
                    title: "",   
                    text: "le montant entree > au montant en caisse",
                    type:"error",   
                    timer: 2000,   
                    showConfirmButton: false 
                });
            else
            {
                var iduser = $('#iduser').val();
                var userName = $('#userName').val();
                var xhttp;
                xhttp = new XMLHttpRequest(); 
                xhttp.onreadystatechange = function()
                {
                    if (this.readyState == 4) 
                    {
                        //document.getElementById("rep").innerHTML = this.responseText;
                        var message = String(this.responseText).trim();
                        if (message == "") 
                        {
                            //document.getElementById("rep").innerHTML = this.responseText;
                            location.reload();
                            swal({   
                                title: "",   
                                text: "Modification reussie",
                                type:"success",   
                                timer: 3000,   
                                showConfirmButton: false 
                            });
                        }
                        else
                        {
                            document.getElementById("rep").innerHTML = this.responseText;
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
                xhttp.open("GET","ajax/comptabilite/updatePetiteDepense.php?iddepense="+iddepense+"&datedepense="+datedepense+"&motif="+motif+"&idcategorie="+idCategorie+"&descriptionCategorie="+descriptionCategorie+"&oldCaisse="+oldCaisse+"&oldMontant="+oldMontant+"&newCaisse="+idCaisse+"&montant="+montant+"&monnaie="+monnaie+"&userName="+userName+"&iduser="+iduser,true);
                xhttp.send();
            }
        }
    }
}
function supprimerPetiteDepense(id_depense,etat)
{
    if (etat == 0) 
    {
        // alert(id_depnse);
        var userName = $('#userName').val();
        var iduser = $('#iduser').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                var message = String(this.responseText).trim();
                if (message == "") 
                {
                    location.reload();
                    swal({   
                        title: "",   
                        text: "suppression reussie",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite!",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                //document.getElementById("rep").innerHTML = this.responseText;
                
            }
        };
        xhttp.open("GET","ajax/comptabilite/supprimerPetiteDepense.php?id_depense="+id_depense+"&userName="+userName+"&iduser="+iduser,true);
        xhttp.send();
    }
    else
    {
        swal({   
            title: "",   
            text: "Vous ne pouvez supprimer cette depense, a ete clotureé!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
}
function submitRapportPetiteDepense(rapportDepense)
{
    if ($('#condition').val() == '')
    {
        swal({   
            title: "",   
            text: "Veillez filtrer d'abord!",  
            type:"error", 
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        document.getElementById('rapportDepense').submit();
    }
}
function filtrePetiteDepense(date1,date2,mois,annee,idcategorie)
{
    //alert('date1: '+date1+' date2: '+date2+' mois: '+mois+' categorie: '+categorie+' typecategorie: '+typecategorie);
    
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4 = null;
    var condition5 = null;
    var condition6 = null;
    var condition7 = null;

    var condition = '';

    if (date1 == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " datedepense='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition2 = '';
    }
    else
    {
        if (date1 !== '') 
        {
            condition2 = " datedepense BETWEEN '"+date1+"' AND '"+date2+"' ";
            condition1 = '';
        }
        else condition2 = " datedepense='"+date2+"' ";
    }
    if (mois == '') 
    {
        condition3 = '';
    }
    else
    {
        condition3 = " MONTH(datedepense)="+mois+" ";
    }
    if (annee == '') 
    {
        condition4 = '';
    }
    else
    {
        condition4 = " YEAR(datedepense)="+annee+" ";
    }
    if (idcategorie == '') 
    {
        condition5 = '';
    }
    else condition5 = " pd.ID_categorie_depense="+idcategorie+" ";

    if (condition1 != '' || condition2 != '') condition4 = '';

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
                text: "suppression reussie",
                type:"success",   
                timer: 3000,   
                showConfirmButton: false 
            });
    }
    else
    {
        //var WEBROOT = $('#WEBROOT').val();
        var iduser = $('#iduser').val();
        document.getElementById('condition').value = condition;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                $('#myTable').DataTable().destroy();
                document.getElementById("rep").innerHTML = this.responseText;
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
        xhttp.open("GET","ajax/comptabilite/filtrePetiteDepense.php?condition="+condition+"&iduser="+iduser,true);
        xhttp.send();
    }
}
function creationDepense(banque,reference,montant,motif,datedepense,categorie,iduser)
{
    //alert('provenance: '+provenance+' montant: '+montant+' motif: '+motif+' datedepense : '+datedepense+' idcategorie: '+idcategorie+' iduser: '+iduser);
    
    if(banque == "" || reference == "" || montant == "" || motif == "" || datedepense == "" || categorie == "" || iduser == "")
    {
        //var msg = document.getElementById('msg');
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
        var idprovenance;
        var monnaie;
        var creditLine;
        var montantprovenance;
        /*if (provenance == 'caisse') 
        {
            var caisse = $('#caisse').val().split(/_/);
            idprovenance = caisse[0];
            montantprovenance = caisse[1];
            monnaie = caisse[2];
        }
        else
        {
            var banque = $('#banque').val().split(/_/);
            idprovenance = banque[0];
            montantprovenance = banque[1];
            monnaie = banque[2];
            reference = $('#reference').val();
        }*/
        var banque = banque.split(/_/);
            idprovenance = banque[0];
            montantprovenance = parseFloat(banque[1]);
            monnaie = banque[2];
            creditLine = parseFloat(banque[3]);
            montantprovenance += creditLine;
            //reference = $('#reference').val();
        if (montantprovenance < parseFloat(montant))
            swal({   
                title: "",   
                text: "le montant entree > au montant de provenance",
                type:"error",   
                timer: 2000,   
                showConfirmButton: false 
            });
        else
        {
            var idcategorie = categorie.split(/-/)[0];
            var description = categorie.split(/-/)[1];
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("retour").innerHTML = this.responseText;
                    var message = String(this.responseText).trim();
                    if (message == '') 
                    {
                        //document.getElementById("rep").innerHTML = this.responseText;
                        document.location.reload();
                        swal({   
                            title: "",   
                            text: "",
                            type:"success",   
                            timer: 10000,   
                            showConfirmButton: false 
                        });
                    }            
                    else
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite",
                        type:"error",   
                        timer: 10000,   
                        showConfirmButton: false 
                    });
                    //document.getElementById("rep").innerHTML = this.responseText;
                    /*$('#montantDepense').val('');
                    $('#motifs').val('');
                    $('#datedepense').val('');*/
                }
                else
                swal({   
                    title: "",   
                    text: "traitement en cours",   
                    showConfirmButton: false 
                });
            };
            xhttp.open("GET","ajax/comptabilite/Ajoutdepense.php?idprovenance="+idprovenance+"&reference="+reference+"&montant="+montant+"&monnaie="+monnaie+"&motif="+motif+"&datedepense="+datedepense+"&iduser="+iduser+"&idcategorie="+idcategorie+"&description="+description,true);
            xhttp.send();
        }
    } 
}
function filtreDepense(date1,date2,mois,annee,idBanque)
{
    //alert('date1: '+date1+' date2: '+date2+' mois: '+mois+' categorie: '+categorie+' typecategorie: '+typecategorie);
    var WEBROOT = $('#WEBROOT').val();
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4 = null;
    var condition5 = null;
    var condition6 = null;
    var condition7 = null;

    var condition = '';

    if (date1 == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " datedepense='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition2 = '';
    }
    else
    {
        if (date1 !== '') 
        {
            condition2 = " datedepense BETWEEN '"+date1+"' AND '"+date2+"' ";
            condition1 = '';
        }
        else condition2 = " datedepense='"+date2+"' ";
    }
    if (mois == '') 
    {
        condition3 = '';
    }
    else
    {
        condition3 = " MONTH(datedepense)="+mois+" ";
    }
    if (annee == '') 
    {
        condition4 = '';
    }
    else
    {
        condition4 = " YEAR(datedepense)="+annee+" ";
    }
    /*if (idcategorie == '') 
    {
        condition5 = '';
    }
    else condition5 = " d.ID_categorie_depense="+idcategorie+" ";
    if (type_categorie == '') 
    {
        condition6 = '';
    }
    else condition6 = " type_categorie='"+type_categorie+"' ";*/
    if (idBanque == '') condition7 = '';
    else condition7 = " d.ID_banque="+idBanque+" ";
    if (condition1 != '' || condition2 != '') condition4 = '';

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);
    //condition5 = (condition5 == '' ? '' : 'AND' +condition5);
    //condition6 = (condition6 == '' ? '' : 'AND' +condition6);
    condition7 = (condition7 == '' ? '' : 'AND' +condition7);

    condition = condition1+condition2+condition3+condition4+condition7;
    if (condition == '') 
    {
        swal({   
                title: "",   
                text: "suppression reussie",
                type:"success",   
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
                $('#myTable').DataTable().destroy();
                document.getElementById("rep").innerHTML = this.responseText;
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
        xhttp.open("GET","ajax/comptabilite/filtreDepense.php?condition="+condition+"&WEBROOT="+WEBROOT,true);
        xhttp.send();
    }
}
function resetFiltreDepense()
{
    //document.location.reload();
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"depense_administrative";
}
function filtreSortieCaisse(date1,date2,mois,annee,idcaisse)
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
    if (idcaisse == '') 
    {
        condition5 = '';
    }
    else condition5 = " c.ID_caisse="+idcaisse+" ";

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
        xhttp.open("GET","ajax/comptabilite/filtreSortieCaisse.php?condition="+condition,true);
        xhttp.send();
    }
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
function submitFiltreEntrerBanque()
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
        //alert($('#condition').val());
        document.getElementById('filtreEntrerBanque').submit();
    }
}
function filtreEntrerBanque(date1,date2,mois,provenance,annee,idbanque)
{
    //alert('date1: '+date1+' date2: '+date2+' mois: '+mois+' provenance: '+provenance+' annee: '+annee+' idbanque: '+idbanque);
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
        condition1 = " h.date_creation='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition2 = '';
    }
    else
    {
        if (date1 !== '') 
        {
            condition2 = " h.date_creation BETWEEN '"+date1+"' AND '"+date2+"' ";
            condition1 = '';
        }
        else condition2 = " h.date_creation='"+date2+"' ";
    }
    if (mois == '') 
    {
        condition3 = '';
    }
    else
    {
        condition3 = " MONTH(h.date_creation)="+mois+" ";
    }
    if (annee == '') 
    {
        condition4 = '';
    }
    else
    {
        condition4 = " YEAR(h.date_creation)="+annee+" ";
    }
    if (provenance == '') 
    {
        condition5 = '';
    }
    else
    {
        condition5 = " provenance='"+provenance+"' "
    }
    if (idbanque == '') 
    {
        condition6 = '';
    }
    else condition6 = " b.ID_banque="+idbanque+" ";

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
        //alert(condition);
        document.getElementById('condition').value = condition;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                $('#example23').DataTable().destroy();
                document.getElementById("repEntrer").innerHTML = this.responseText;
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
        xhttp.open("GET","ajax/comptabilite/filtreEntrerBanque.php?condition="+condition+"&idbanque="+idbanque,true);
        xhttp.send();
    }
}
function submitFiltreSortieBanque()
{
    if ($('#conditionSortie').val() == '')
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
        //alert($('#conditionSortie').val());
        document.getElementById('filtreSortieBanque').submit();
    }
}
function filtreSortieBanque(date1,date2,mois,annee,idbanque)
{
    //alert('date1: '+date1+' date2: '+date2+' mois: '+mois+' annee: '+annee);
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
        condition1 = " sb.date_sortie='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition2 = '';
    }
    else
    {
        if (date1 !== '') 
        {
            condition2 = " sb.date_sortie BETWEEN '"+date1+"' AND '"+date2+"' ";
            condition1 = '';
        }
        else condition2 = " sb.date_sortie='"+date2+"' ";
    }
    if (mois == '') 
    {
        condition3 = '';
    }
    else
    {
        condition3 = " MONTH(sb.date_sortie)="+mois+" ";
    }
    if (annee == '') 
    {
        condition4 = '';
    }
    else
    {
        condition4 = " YEAR(sb.date_sortie)="+annee+" ";
    }
    if (idbanque == '') 
    {
        condition5 = '';
    }
    else condition5 = " b.ID_banque="+idbanque+" ";

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
        //alert(condition);
        document.getElementById('conditionSortie').value = condition;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                $('#sotirBanqueTb').DataTable().destroy();
                document.getElementById("repSortie").innerHTML = this.responseText;
                $('#sotirBanqueTb').DataTable();
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
        xhttp.open("GET","ajax/comptabilite/filtreSortieBanque.php?condition="+condition+"&idbanque="+idbanque,true);
        xhttp.send();
    }
}
function updatedepense(oldBanque,oldMontant,iddepense,datedepense,motif,categorie,banque,montant,reference,etat)
{
    //alert('iddepense: '+iddepense+' datedepense: '+datedepense+' motif: '+motif+' idcategorie: '+idcategorie);
    if (etat == 0) 
    {
        if (datedepense == "" || motif == "" || categorie == "" || reference == "" || montant == "")
        {
            swal({   
                title: "",   
                text: "remplissez tous les champs en *",  
                type:"error", 
                timer: 3000,   
                showConfirmButton: false 
            });
        }
        else  
        {
            var banque = banque.split(/_/);
            idBanque = banque[0];
            montantBanque = banque[1];
            monnaie = banque[2];
            var categorie = categorie.split(/_/);
            idCategorie = categorie[0];
            descriptionCategorie = categorie[1];
            //reference = $('#reference').val();
            if (parseFloat(montantBanque) < parseFloat(montant))
                swal({   
                    title: "",   
                    text: "le montant entree > au montant en banque",
                    type:"error",   
                    timer: 2000,   
                    showConfirmButton: false 
                });
            else
            {
                var iduser = $('#iduser').val();
                //var userName = $('#userName').val();
                var xhttp;
                xhttp = new XMLHttpRequest(); 
                xhttp.onreadystatechange = function()
                {
                    if (this.readyState == 4) 
                    {
                        //document.getElementById("rep").innerHTML = this.responseText;
                        var message = String(this.responseText).trim();
                        if (message == "") 
                        {
                            //document.getElementById("rep").innerHTML = this.responseText;
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
                        {
                            //document.getElementById("rep").innerHTML = this.responseText;
                            swal({   
                                title: "",   
                                text: "Une erreur s'est produite!",
                                type:"error",   
                                timer: 3000,   
                                showConfirmButton: false 
                            });
                        }
                    }
                    else
                        swal({   
                            title: "",   
                            text: "traitement en cours",   
                            showConfirmButton: false 
                        });
                };
                xhttp.open("GET","ajax/comptabilite/updatedepenseAdmin.php?iddepense="+iddepense+"&datedepense="+datedepense+"&motif="+motif+"&idcategorie="+idCategorie+"&descriptionCategorie="+descriptionCategorie+"&reference="+reference+"&oldBanque="+oldBanque+"&oldMontant="+oldMontant+"&newBanque="+idBanque+"&montant="+montant+"&monnaie="+monnaie+"&iduser="+iduser,true);
                xhttp.send();
            }
        }
    }
    else
        swal({   
            title: "",   
            text: "Vous ne pouvez pas modifier cette depense, a ete clotureé!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
}
function supprimerdepense(id_depense,etat)
{
    if (etat == 0) 
    {
        // alert(id_depnse);
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
                if (rep == "") 
                {
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
                {
                    swal({   
                        title: "",   
                        text: "Une erreur s'est produite",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                    document.getElementById("rep").innerHTML = this.responseText;
                }
            }
            else
                swal({   
                    title: "",   
                    text: "traitement en cours",   
                    showConfirmButton: false 
                });
        };
        xhttp.open("GET","ajax/comptabilite/supprime_depense.php?id_depense="+id_depense+"&iduser="+iduser,true);
        xhttp.send();
    }
    else
    {
        swal({   
            title: "",   
            text: "Vous ne pouvez supprimer cette depense, a ete clotureé!",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
    }
}
function cloturerDepenses()
{
    var iduser = $('#iduser').val();
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
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
        }
    };
    xhttp.open("GET","ajax/comptabilite/cloturerDepenses.php?iduser="+iduser,true);
    xhttp.send();
}
function cloturerPetiteDepenses()
{
    var iduser = $('#iduser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            var message = String(this.responseText).trim();
            if (message == "") 
            {
                //document.getElementById("rep").innerHTML = this.responseText;
                location.reload();
                swal({   
                    title: "",   
                    text: "Traitement reussi !",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
                swal({   
                    title: "",   
                    text: "Une erreur s'est produite !",
                    type:"error",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
        }
    };
    xhttp.open("GET","ajax/comptabilite/cloturerPetiteDepenses.php?iduser="+iduser,true);
    xhttp.send();
}
function submitRapportDepense()
{
    /*if ($('#condition').val() == '')
    {
        swal({   
            title: "",   
            text: "Veillez filtrer d'abord!",  
            type:"error", 
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else
    {
        document.getElementById('FiltreDepense').submit();
    }*/
    $('#print').val(1);
    document.getElementById('FiltreDepense').submit();
}
function provenanceDepense(type)
{
    if (type != '') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("conteneur_destination").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/comptabilite/provenanceDepense.php?type="+type,true);
        xhttp.send();
    }
}
function recevoir_destination(type) 
{
    if (type != '') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("conteneur_destination").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/comptabilite/destinationExtrat_banque_caisse.php?type="+type,true);
        xhttp.send();
    }
}
function includeClientDonnerCaution(type_extrat)
{
    var libelle = type_extrat.split(/-/)[1];
    if (libelle == 'caution') 
    {
        document.getElementById('contener_client_donner_caution').innerHTML = "<div class='col-lg-12 col-md-12'>"+
            "<div class='form-group row'>"+
              "<label for='exampleInputuname3' class='col-sm-3 control-label'>"+
              "Client*</label>"+
              "<div class='col-sm-9'>"+        
                "<input type='text' id='client_donner_caution' class='form-control' onkeyup='clientDonnerCaution($(this).val())'>"+
                "<div id='modal_client_donner_caution'></div>"+
              "</div>"+
            "</div>"+
          "</div>";
    }
    else
    {
        var contener = document.getElementById('contener_client_donner_caution');
        contener.removeChild(contener.childNodes[0]);
    }
}
function creationExtrat(montant,monnaie_extrat,banque,date_extrat,description,iduser)
{
    //alert(montant+'/'+monnaie_extrat+'/'+banque+'/'+date_extrat+'/'+description+'/'+iduser);
    
    if(banque === "" || montant === "" || date_extrat === "")
    {
        swal({   
            title: "",   
            text: "vous devez remplir les champs en *", 
            type:"error",  
            timer: 2000,   
            showConfirmButton: false 
        });
    }
    else 
    {
        //var userName = $('#userName').val();
        //var idtype = type_extrat.split(/-/)[0];
        //var libelleType = type_extrat.split(/-/)[1];
        //var idDestination;
        var banque = banque.split(/_/);
        var idDestination = banque[0];
        var monnaie_banque = banque[1];
        var error = '';
        /*if (libelleType == 'caution') 
        {
            if (idclient == '') 
            {
                error = "Veillez choisir le client";
            }
        }*/
        //if (error == '') 
        //{
            /*if (destination == 'banque') 
            {
                var banque = $('#banque').val().split(/_/);
                idDestination = banque[0];
                monnaie = banque[2];
            }
            else if (destination == 'caisse')
            {
                var caisse = $('#caisse').val().split(/_/);
                idDestination = caisse[0];
                monnaie = caisse[2];
            }*/
            //alert('libelleType : '+libelleType+' montant: '+montant+' monnaie: '+monnaie+' destination: '+destination+' idDestination: '+idDestination+' date_extrat: '+date_extrat+' description: '+description+' user: '+utilisateur+' idclient: '+idclient);
            
            if (monnaie_banque != monnaie_extrat) 
                swal({   
                    title: "",   
                    text: "La monnaie n'est pas comptabilite de la destination",  
                    type:"error", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
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
                        else swal({   
                            title: "",   
                            text: "Une erreur est survenue !",  
                            type:"error", 
                            timer: 3000,   
                            showConfirmButton: false 
                        });
                        document.getElementById('retour').innerHTML = this.responseText;
                    }                          
                };
                xhttp.open("GET","ajax/comptabilite/creerExtrat.php?montant="+montant+"&monnaie="+monnaie_extrat+"&idDestination="+idDestination+"&date_extrat="+date_extrat+"&iduser="+iduser+"&description="+description,true);
                xhttp.send();
            }
        /*}
        else
        {
            swal({   
                title: "",   
                text: error, 
                type:"error",  
                timer: 2000,   
                showConfirmButton: false 
            });
        }*/
    }
}
function deleteExtrat(id_extrat,montant,idDestination,etat)
{
    //alert('id_extrat: '+id_extrat+' montant : '+montant+' idDestination : '+idDestination);
    if (etat == 0) 
    {
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
        xhttp.open("GET","ajax/comptabilite/deleteExtrat.php?id_extrat="+id_extrat+"&montant="+montant+"&idDestination="+idDestination+"&iduser="+iduser,true);
        xhttp.send();
    }
    else
        swal({   
            title: "",   
            text: "Vous ne pouvez plus supprimer! c'est cloturer deja",  
            type:"error", 
            timer: 3000,   
            showConfirmButton: false 
        });
}
function close_extrat()
{
    var iduser = $('#iduser').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            var rep =String(this.responseText).trim();
            if(rep == "")
            {
                document.location.reload();
                swal({
                    title:"",   
                    text:"",  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
            else
            {
                //document.getElementById('rep').innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "Une erreur est survenue!", 
                    type:"error",  
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        }
    };
    xhttp.open("GET","ajax/comptabilite/closeExtrat.php?iduser="+iduser,true);
    xhttp.send();
}
function updateExtrat(id_extrat,montant,id_type_extrat,idDestination,date_extrat,idUser,description,destination)
{
    //alert('id_extrat: '+id_extrat+' montant : '+montant+' type_extrat : '+type_extrat+' idDestination: '+idDestination+' date_extrat: '+date_extrat+' user: '+user+' description: '+description+' destination: '+destination);
    if (montant == '' || date_extrat == '') 
    {
        swal({   
            title: "",   
            text: "Veillez renseiger les champs en *",  
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
                //document.getElementById('retour').innerHTML = this.responseText;
                rep = String(this.responseText).trim();
                if(rep == '')
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
                {
                    swal({   
                        title: "",   
                        text: 'Une erreur c\'est produite lors de la modification',  
                        type:"error", 
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
            }                          
        };
        xhttp.open("GET","ajax/comptabilite/updateExtrat.php?id_extrat="+id_extrat+"&montant="+montant+"&idDestination="+idDestination+"&id_type_extrat="+id_type_extrat+"&date_extrat="+date_extrat+"&idUser="+idUser+"&description="+description+"&destination="+destination+"&userName="+userName,true);
        xhttp.send();
    }
}
function filtreExtrat(type_extrat,date1,date2,mois,annee)
{
    var WEBROOT = $('#WEBROOT').val();
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4 = null;
    var condition5 = null;
    var condition = '';
    if (type_extrat == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " t.ID_type_extrat="+type_extrat+" ";
    }
    if (date1 == '') 
    {
        condition2 = '';
    }
    else
    {
        condition2 = " date_extrat='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition3 = '';
    }
    else
    {
        if (date1 !== '') 
        {
            condition3 = " date_extrat BETWEEN '"+date1+"' AND '"+date2+"' ";
            condition2 = '';
        }
        else condition3 = " date_extrat='"+date2+"' ";
    }
    if (mois == '') 
    {
        condition4 = '';
    }
    else
    {
        condition4 = " MONTH(date_extrat)="+mois+" ";
    }
    if (annee == '') 
    {
        condition5 = '';
    }
    else
    {
        condition5 = " YEAR(date_extrat)="+annee+" ";
    }

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);
    condition5 = (condition5 == '' ? '' : 'AND' +condition5);

    condition = condition1+condition2+condition3+condition4+condition5;

    if (condition == '') 
    {
    }
    else
    {
        condition = condition.substr(3);
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                $('#myTable').DataTable().destroy();
                document.getElementById('retour').innerHTML = this.responseText;
                $('#myTable').DataTable();
                /*location.reload();
                swal({   
                    title: "Information!",   
                    text: this.responseText,  
                    type:"success", 
                    timer: 3000,   
                    showConfirmButton: false 
                });*/
            }                          
        };
        xhttp.open("GET","ajax/comptabilite/filtreExtrat.php?condition="+condition+"&WEBROOT="+WEBROOT,true);
        xhttp.send();
    }
}
function resetFiltreExtrat()
{
    location.reload();
}
function ajouterTypeExtra(type,user_extrat)
{
    //alert(type);
    if (type == ''|| user_extrat == '') 
    {
        //alert('Veillez entrer le type!');
        swal({   
            title: "Information!",   
            text: "Veillez entrer le type",
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
                    text: "Ajout du nouveau type d'extrat reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                $('#type').val("");
            }
        };
        xhttp.open("GET","ajax/comptabilite/ajouterTypeExtra.php?type="+type+"&user_extrat="+user_extrat,true);
        xhttp.send();
    }
}
function ajoutercategoriedepense(categoriedepense,type_categorie)
{
    //alert(categoriedepense+' type_categorie: '+type_categorie);
    if (categoriedepense == '' || type_categorie == '') 
    {
        //alert('Veillez entrer le type!');
        swal({   
            title: "Information!",   
            text: "Veillez renseiger tous les champs",
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
                document.getElementById("rep").innerHTML = this.responseText;
                $('#myTable').DataTable();
                swal({   
                    title: "",   
                    text: "Ajout reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                $('#categoriedepense').val("");
                $('#type_categorie').val("");
            }
        };
        xhttp.open("GET","ajax/comptabilite/ajoutercategoriedepense.php?categoriedepense="+categoriedepense+"&type_categorie="+type_categorie,true);
        xhttp.send();
    }
}
function updateCategorieDepense(idCategorie,type_categorie,description)
{
    //alert('idCategorie: '+idCategorie+' type_categorie: '+type_categorie+' description: '+description);
    if (type_categorie == "" || description == "" )
    {
        swal({   
            title: "",   
            text: "remplissez tout les champs",  
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
                document.getElementById("rep").innerHTML = this.responseText;
                $('#myTable').DataTable();
                swal({   
                    title: "",   
                    text: "Modification reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
            }
        };
        xhttp.open("GET","ajax/comptabilite/update_categoriedepense.php?idCategorie="+idCategorie+"&type_categorie="+type_categorie+"&description="+description,true);
        xhttp.send();
    }
}
function supprimeCategorie(numcategorie)
{
    // alert(numcategorie);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            $('#myTable').DataTable().destroy();
            document.getElementById("rep").innerHTML = this.responseText;
            $('#myTable').DataTable();
            //location.reload();
            swal({   
                title: "",   
                text: "suppression reussie",
                type:"success",   
                timer: 3000,   
                showConfirmButton: false 
            });
        }
    };
    xhttp.open("GET","ajax/comptabilite/supprime_categorie_depense.php?numcategorie="+numcategorie,true);
    xhttp.send();
}
function update_type_extrat(refextrat,libelle,update_extrat)
{
     //alert(refextrat+' '+libelle);
    if (refextrat == "" || libelle == "" )
    {
        swal({   
            title: "",   
            text: "remplissez tout les champs",  
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
                document.getElementById("rep").innerHTML = this.responseText;
                    //location.reload();
                    swal({   
                        title: "",   
                        text: "Modification reussie",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                
            }
        };
        xhttp.open("GET","ajax/comptabilite/update_type_extrat.php?refextrat="+refextrat+"&libelle="+libelle+"&update_extrat="+update_extrat,true);
        xhttp.send();
    }
}
function supprime_tpe_extrat(num_extrat,del_extrat)
{
     // alert(num_extrat);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rep").innerHTML = this.responseText;
            //location.reload();
            swal({   
                title: "",   
                text: "suppression reussie",
                type:"success",   
                timer: 3000,   
                showConfirmButton: false 
            });
        }
    };
    xhttp.open("GET","ajax/comptabilite/supprime_type_extrat.php?num_extrat="+num_extrat+"&del_extrat="+del_extrat,true);
    xhttp.send();
}
function creer_dette(dette,montant,motif,datecreation,monnaie)
{
    //alert(dette + montant +motif +datecreation)
    /*swal({
            title:"Information",
            text:dette+' '+montant+' '+motif+' '+datecreation,
            type:"success",
            timer:3000, 
            showConfirmButton:false

        });*/
    if (dette === "" || montant === "" || motif === "") 
    {
        swal({
            title:"Information",
            text:"vous devez remplir tout les champs",
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
                document.getElementById("rep").innerHTML = this.responseText;
                swal({
                    title:"Enregistrement avec success",
                    text:"vous venez d'ajouter la dette avec success",
                    type:"success",
                    timer:3000, 
                    showConfirmButton:false
                });
            }
        }; 
        xhttp.open("GET","ajax/comptabilite/creer_dette.php?dette="+dette+"&montant="+montant+"&motif="+motif+"&datecreation="+datecreation+"&userName="+userName+"&monnaie="+monnaie,true);
        xhttp.send();
    }
}
function showHideInputDette(elemet,i) 
{
    if (elemet.checked) 
    {
        $("#champtext"+i).show();  
        var radios = document.getElementsByName('choix_dette');
        for(var j = 0; j < radios.length; j++)
        {
            if(radios[j].checked == false)
            {
                //valeur = boutons[i].value;
                $("#champtext"+radios[j].value).hide();
            }
        }
    }
    else 
        $("#champtext"+i).hide();
}
function showHideInputBanque(choix,i)
{   
    if (choix.checked) 
    {
        $("#banque"+i).show();
    }
    else 
        $("#banque"+i).hide();     
}
function showHideInputCaisse(champs,i)
{
    if (champs.checked) 
    {
        $("#champ_caisse"+i).show();
    }
    else 
        $("#champ_caisse"+i).hide();
}
function payer_dette(i,j)
{ 
    //alert('nomss: '+nomss+' refdette: '+refdette+' refbanque: '+refbanque+' refcaisse'+refcaisse);

    var userName = $('#userName').val();
    var monnaie_dette;
    var detteTotale = 0;
    var sommeTotalebanque = 0;
    var montantTota_caisse =0;
    var tb_refdette = [''];
    var tb_descriptionDette = [''];
    var tb_refbanque = [''];
    var tb_refcaisse = [''];
    var tb_montantDette = [''];
    var tb_montantBanque = [''];
    var tb_montantCaisse = [''];
    var erreurMonnaie = '';
    for (var n =  1; n <= parseInt(i); n++) 
    {
        if (document.getElementById("choix_dette" + n).checked == true) 
        {
            var dette = $("#montant" + n).val();
            var dette_initiale = parseInt($("#dette_initiale" + n).val());
            var refdette = $("#refdette"+ n).val();
            var intitule_dette = $('#intitule_dette'+n).val();
            monnaie_dette = $('#monnaiedette'+n).val();
            tb_refdette.push(refdette+'-'+dette+'-'+intitule_dette);
            tb_descriptionDette.push(intitule_dette);
            tb_montantDette.push(dette);
            if (dette_initiale < parseInt(dette)) 
            {
                swal({
                    title:"",
                    text:"La dette ne doit pas etre superieur au dette initiale",
                    type:"error",
                    timer:3000, 
                    showConfirmButton:false
                });
            }
            else
            {
                detteTotale +=parseInt(dette);
                //alert(detteTotale);
            }
        }
    }
    for (var n =  1; n <= parseInt(j); n++) 
    {
        if (document.getElementById("choix_banque" + n).checked == true) 
        {
            var choix_banque = document.getElementById("choix_banque" + n).value;
            if (choix_banque == 'banque') 
            {
                if ($("#montant_banque" + n).val() != '') 
                {
                    var montant_banque = parseInt($("#montant_banque" + n).val());
                    var initiale_mount_banque = parseInt($("#initiale_mount_banque" + n).val());
                    var refbanque = $("#refbanque" + n).val();
                    var nomBanque = $("#nomBanque" + n).val();
                    tb_refbanque.push(refbanque+'-'+montant_banque+'-'+nomBanque);
                    tb_montantBanque.push(montant_banque);

                    if (initiale_mount_banque < montant_banque) 
                    {
                        var msg = document.getElementById('msgError'+n);
                        msg.style.color = 'red';
                        msg.innerHTML = 'Attention '+montant_banque+' > '+initiale_mount_banque;
                    }
                    else
                    {
                        sommeTotalebanque +=parseInt(montant_banque);
                        //alert(sommeTotalebanque);
                    }
                }
                if (monnaie_dette != $('#monnaie_banque'+n).val()) erreurMonnaie = 1;
            }
            else
            {
                if ($("#montant_caisse" + n).val() != '') 
                {
                    var montant_caisse = parseInt($("#montant_caisse" + n).val());
                    var initiale_montant_caisse = parseInt($("#caisse_initiale" + n).val());
                    var refcaisse = $('#refcaisse'+n).val();
                    var nomCaisse = $('#nomCaisse' + n).val();
                    tb_refcaisse.push(refcaisse+'-'+montant_caisse+'-'+nomCaisse);
                    tb_montantCaisse.push(montant_caisse);
                    //alert(montant_caisse+' =>'+initiale_montant_caisse );
                    if (initiale_montant_caisse < montant_caisse) 
                    {
                        swal({
                            title:"",
                            text:"Le montant ne doit pas etre superieur au montant disponible dans la caisse",
                            type:"error",
                            timer:3000, 
                            showConfirmButton:false
                        });
                    }
                    else
                    {
                        sommeTotalebanque +=parseInt(montant_caisse);
                    }
                }
                if (monnaie_dette != $('#monnaieCaisse'+n).val()) erreurMonnaie = 1;
            }
        }
    }
    if (erreurMonnaie != '') 
    {
        swal({   
            title: "",   
            text: "Incompatibiliter de la monnaie ",
            type:"error",   
            timer: 2000,   
            showConfirmButton: false
        });
    }
    else
    {
        if (detteTotale == sommeTotalebanque && detteTotale > 0 ) 
        {
            tb_refdette = tb_refdette.join('_').trim().substr(1);
            tb_descriptionDette = tb_descriptionDette.join('_').trim().substr(1);
            tb_montantDette = tb_montantDette.join('_').trim().substr(1);
            tb_refcaisse = tb_refcaisse.join('_').trim().substr(1);
            tb_montantCaisse = tb_montantCaisse.join('_').trim().substr(1);
            tb_refbanque = tb_refbanque.join('_').trim().substr(1);
            tb_montantBanque = tb_montantBanque.join('_').trim().substr(1);
            //alert('tb_refdette = '+tb_refdette+' tb_descriptionDette = '+tb_descriptionDette+' tb_refcaisse= '+tb_refcaisse+' tb_refbanque = '+tb_refbanque);
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("rep").innerHTML = this.responseText;
                    var rep = String(this.responseText).trim();
                    if (rep == 'ok') 
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
                            text: this.responseText,
                            type:"error",   
                            timer: 15000,   
                            showConfirmButton: false
                        });
                } 
            };
            xhttp.open("GET","ajax/comptabilite/payer_dette.php?refdette="+tb_refdette+"&tb_descriptionDette="+tb_descriptionDette+"&tb_montantDette="+tb_montantDette+"&monnaie="+monnaie_dette+"&refbanque="+tb_refbanque+"&tb_montantBanque="+tb_montantBanque+"&refcaisse="+tb_refcaisse+"&tb_montantCaisse="+tb_montantCaisse+"&sommeTotalebanque="+sommeTotalebanque+"&detteTotale="+detteTotale+"&userName="+userName,true);
            xhttp.send();
        }
        else
        {
            alert('la dette doit etre = au montant payé, detteTotale = '+detteTotale+' sommeTotalebanque = '+sommeTotalebanque);
        }
    }
}
function filtreHistoriquePayementDette(date1,date2,mois,annee)
{
    //alert('date1: '+date1+' date2: '+date2+' mois: '+mois+' annee: '+annee);
    //var WEBROOT = $('#WEBROOT').val();
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4 = null;
    var condition = '';

    if (date1 == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " date_histo='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition2 = '';
    }
    else
    {
        if (date1 !== '') 
        {
            condition2 = " date_histo BETWEEN '"+date1+"' AND '"+date2+"' ";
            condition1 = '';
        }
        else condition2 = " date_histo='"+date2+"' ";
    }
    if (mois == '') 
    {
        condition3 = '';
    }
    else
    {
        condition3 = " MONTH(date_histo)="+mois+" ";
    }
    if (annee == '') 
    {
        condition4 = '';
    }
    else
    {
        condition4 = " YEAR(date_histo)="+annee+" ";
    }

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);

    condition = condition1+condition2+condition3+condition4;
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
        //alert(condition.substr(3));
        condition = condition.substr(3);
        document.getElementById('condition').value = condition;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                $('#myTable').DataTable().destroy();
                document.getElementById("repHisto").innerHTML = this.responseText;
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
        xhttp.open("GET","ajax/comptabilite/filtreHistoriquePayementDette.php?condition="+condition,true);
        xhttp.send();
    }
}
function resetFiltreHistoriquePayementDette()
{
    document.location.reload();
}
function submitFiltreHistoriquePayementDette()
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
        document.getElementById('filtreHistoriquePayementDette').submit();
    }
}
function update_dette(id_dette,dette,montant,monnaie,motif,datecreation)
{
    //alert(id_dette,dette,montant,motif,datecreation);
    if (id_dette =="" || dette =="" || montant =="" || motif =="") 
    {
        //alert('Completez les champs vide');
        swal({   
            title: "",   
            text: "Completez tout les champs svp!", 
            type:"error",  
            timer: 2000,   
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
                document.getElementById("rep").innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "modification reussie!", 
                    type:"success",  
                    timer: 3000,   
                    showConfirmButton: false 
                });
                location.reload();
            }
        };                                             
        xhttp.open("GET","ajax/comptabilite/modifier_dette.php?id_dette="+id_dette+"&dette="+dette+"&montant="+montant+"&monnaie="+monnaie+"&motif="+motif+"&datecreation="+datecreation+"&userName="+userName,true);
        xhttp.send();
    }
}
function supprimer_dette(id_dette,userName)
{
    //alert(id_dette+' '+userName);

    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            //document.getElementById("rep").innerHTML = this.responseText;
            swal({   
                title: "",   
                text: "",
                type:"success",   
                timer: 1000,   
                showConfirmButton: false 
            });
            document.location.reload();
        }
    };
    xhttp.open("GET","ajax/comptabilite/supprimer_dette.php?id_dette="+id_dette+"&userName="+userName,true);
    xhttp.send(); 
}

const selectCustomerPeyement = document.getElementById('selectCustomerPeyement');
if(selectCustomerPeyement === null){}
else
{
    const options = Array.from(selectCustomerPeyement.options);
    const input = document.getElementById('seachCustomerPayement');
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
        selectCustomerPeyement.append(...matchArray);
    }

    input.addEventListener('keyup', filterOptions);
}

$('#selectCustomerPeyement').change(function(){
    var customer = this.value.split(/-/);
    $('#idclient').val(customer[0]);
    $('#billing_number').val(customer[1]);

    $.post('ajax/facture/getFactureNonPayerDunClient.php',{result:customer[0]},function(data){

            $('#facturepaye').html(data);
        })
});

function getDestinationPaiementOnCreate(mode)
{
    if (mode != 'CASH' && mode != '') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("conteneur_banque").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/comptabilite/getDestinationPaiementOnCreate.php?mode="+mode,true);
        xhttp.send();
    }
    else
    {
        var conteneur_banque = document.getElementById('conteneur_banque');
        conteneur_banque.removeChild(conteneur_banque.childNodes[0]);
    }
}
function getDestinationPaiementOnUpdate(mode,i)
{
    if (mode != 'CASH') 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("conteneur_banque"+i).innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/comptabilite/getDestinationPaiementOnUpdate.php?i="+i,true);
        xhttp.send();
    }
    else
    {
        var conteneur_banque = document.getElementById('conteneur_banque'+i);
        conteneur_banque.removeChild(conteneur_banque.childNodes[0]);
    }
}

function submitPrintPrevisionReportForm()
{
    document.getElementById('print_prevision_report_form').submit();
}
$(document).ready(function(){
    "use strict";
    //Solde annuel d'un client
    /*var line = new Morris.Line({
        element: "graph_prevision_data",
        resize: true,
        //data:solde_annuel,
        data:graph_prevision_data,
        xkey: "y",
        ykeys: "a",
        labels: ["montant"],
        parseTime:false,
        gridLineColor: "#8b4513",
        lineColors: ["#7c4a2f"],
        lineWidth: 5,
        hideHover: "auto"
    });*/
    Morris.Bar({
    element: 'graph_prevision_data',
    data: graph_prevision_data,
    xkey: 'y',
    ykeys: ['a'],
    labels: ["montant"],
    barColors:['#7c4a2f'],
    hideHover: 'auto',
    gridLineColor: '#eef0f2',
    resize: true
    });
})
