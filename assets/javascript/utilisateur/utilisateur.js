function ajout_User(nomuser,login,prenom,password,profil_id,conf_password,mail_user,etat)
{
    //alert(nomuser+'  '+login+'  '+prenom+'  '+password+'  '+profil_id+'  '+conf_password+'  '+mail_user+etat);
    //nbCaracteur = removeExtraSpace(description).length;
    var iduser = $('#iduser').val();
    if (nomuser == "" || mail_user == "" || prenom == "" || password == "" || profil_id == "" || login == "")
    {
       // alert('Les champs nom utilisateur, email ,mot de passe et le role\n ne doivent pas etre vide');
        swal({   
                title: "Erreur!",   
                text: "Remplissez tout les champs avec etoile *", 
                //type:"success",  
                timer: 3000,   
                showConfirmButton: false 
            });
            
    }
    else if (password != conf_password) 
    {
        //alert('Veillez confirmer le mot de passe celui que vous mettez ne pas le meme');
        swal({   
                title: "Erreur!",   
                text: "Veillez confirmer le mot de passe celui que vous mettez ne pas le meme", 
               // type:"success",  
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
                if (rep == "") 
                {
                    swal({   
                        title: "",   
                        text: "Ajout reussi!", 
                        type:"success",  
                        timer: 3000,   
                        showConfirmButton: false 
                   });
                    $('#nomuser').val('');
                    $('#login').val('');
                    $('#prenom').val('');
                    $('#password').val('');
                    $('#conf_password').val('');
                    $('#mail_user').val('');
                }
                else
                swal({   
                        title: "",   
                        text: "Une erreur s'est produite", 
                        type:"error",  
                        timer: 3000,   
                        showConfirmButton: false 
                   });
                //document.getElementById('reponse').innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/Utilisateur/Ajout_User.php?nomuser="+nomuser+"&mail_user="+mail_user+"&prenom="+prenom+"&password="+password+"&profil_id="+profil_id+"&login="+login+"&etat="+etat+"&iduser="+iduser,true);
        xhttp.send();
    }
}
function UpdateUser(iduser,nomuser,mail_user,role)
{ 
    var userName = $('#userName').val();
    //alert(nomuser+'    '+mail_user+'    '+password+' '+role);
    if(nomuser == "" || mail_user == ""  || role == "")
    {
        //alert('veuillez remplir tout le champ svp');
        swal({   
                        title: "Erreur!",   
                        text: "Veillez remplir tout les champs", 
                        //type:"success",  
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
                        title: "modification reussi!",   
                        text: "Vous venez de modifier cet utilisateur", 
                        type:"success",  
                        timer: 3000,   
                        showConfirmButton: false 
                   });
            }
        };
        xhttp.open("GET","ajax/Utilisateur/updateUser.php?iduser="+iduser+"&nomuser="+nomuser+"&mail_user="+mail_user+"&role="+role+"&userName="+userName,true);
        xhttp.send();
    }
}
function deleteUser(iduser)
{
    var userName = $('#userName').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("reponse").innerHTML = this.responseText;
            swal({   
                        title: "suppression reussi!",   
                        text: "Vous venez de supprimer cet utilisateur", 
                        type:"success",  
                        timer: 3000,   
                        showConfirmButton: false 
                   });
            //location.reload();
        }
    };
    xhttp.open("GET","ajax/Utilisateur/deleteUser.php?iduser="+iduser+"&userName="+userName,true);
    xhttp.send();
}
function setProfilUser()
{
    var nombrePage = $("input:checkbox:checked").length;
    if ($('#profile_name').val() == '' || nombrePage == 0) 
    {
        alert('Verifier si vous avez entre le profil \n ou si vous avez aumoin attribuer un droit');
        swal({   
                        title: "Echec!",   
                        text: "Verifier si vous avez entrez le profil \n ou si vous avez au moins attribuer un droit", 
                        //type:"success",  
                        timer: 3000,   
                        showConfirmButton: false 
                   });
    }
    else
    {
        $("#form-profil-user").submit();

    }
}
function cocherUneLigneOnCreerProfilUser(i)
{
    if (document.getElementById(i).checked == true) 
    {
        document.getElementById("l"+i).checked = true;
        document.getElementById("c"+i).checked = true;
        document.getElementById("m"+i).checked = true;
        document.getElementById("s"+i).checked = true;
    }
    else
    {
        document.getElementById("l"+i).checked = false;
        document.getElementById("c"+i).checked = false;
        document.getElementById("m"+i).checked = false;
        document.getElementById("s"+i).checked = false;
    }
}
/*$( "#form-profil-user" ).submit(function( event ) {
  if ($('#profile_name').val() == '') 
  {
    alert('Entrer le nom de profil');
  }
  else
  {
    $( "#target" ).submit();
  }
});*/
function getprofilPermission(profil)
{
    var droit = $('#droit').val();
    if (profil == "") 
    {
        //alert('choisissez le profil');
        swal({   
            title: "",   
            text: "choisissez le profil", 
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
                document.getElementById("rs").innerHTML = this.responseText;
                
            }
        };
        xhttp.open("GET","ajax/Utilisateur/affiche_profil.php?profil="+profil+"&droit="+droit+"&userName="+userName,true);
        xhttp.send();
    }
}
function update_profil(iduser,profil_id,nom_user)
{   
    //var userName = $('#userName').val();
    //alert(iduser+'    '+profil_id+'  '+nom_user);
    if(iduser == "" || profil_id == "")
    {
        //alert('veuillez remplir tout le champ svp');
        swal({   
            title: "Erreur!",   
            text: "Veillez remplir tout le champs svp", 
            //type:"success",  
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
                if (rep == "") 
                {
                    //document.getElementById("reponse").innerHTML = this.responseText;
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
                        text: "Une erreur s'est produite", 
                        type:"error",  
                        timer: 3000,   
                        showConfirmButton: false 
                   });
                }
            }
        };
        xhttp.open("GET","ajax/Utilisateur/updateprofil.php?iduser="+iduser+"&profil_id="+profil_id+"&userName="+nom_user,true);
        xhttp.send();
    }
}
function update_permission(idpermission,lire,creer,modifier,supprimer,i)
{   
    var userName = $('#userName').val();
    var page_accept = 0;

    //alert(idpermission+' '+lire+' '+creer+' '+modifier+' '+supprimer);
    if (lire == '' || creer == '' || modifier == '' || supprimer == '') 
    {
        //var msg = document.getElementById('msg'+i);
        //msg.style.color = 'red';
        //msg.innerHTML = '';
        swal({   
            title: "",   
            text: "Veillez preciser les droits", 
            type:"success",  
            timer: 3000,   
            showConfirmButton: false 
       });
    }
    /*else if (parseInt(lire) < 0 || parseInt(lire) > 1 || parseInt(creer) < 0 || parseInt(creer) > 1 || parseInt(modifier) < 0 || parseInt(modifier) > 1 || parseInt(supprimer) < 0 || parseInt(supprimer) >1) 
    {
        var msg = document.getElementById('msg'+i);
        msg.style.color = 'red';
        msg.innerHTML = 'le droit doit etre 0 ou 1';
        swal({   
            title: "Attention!",   
            text: "le droit doit etre 0 ou 1", 
            type:"success",  
            timer: 3000,   
            showConfirmButton: false 
       });
    }*/
    else
    {
        if (lire == 1) page_accept = 1;
        if (creer == 1) page_accept = 1;
        if (modifier == 1) page_accept = 1;
        if (supprimer == 1) page_accept = 1;
        var profil_id = $('#profile_name').val();
        var droit = $('#droit').val();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                var msg = document.getElementById('msg'+i);
                //msg.style.color = 'red';
                //location.reload();
                document.getElementById('rs').innerHTML = this.responseText;
                msg.innerHTML = this.responseText;
                swal({   
                    title: "",   
                    text: "", 
                    type:"success",  
                    timer: 3000,   
                    showConfirmButton: false 
               });
            }
        };
        xhttp.open("GET","ajax/Utilisateur/update_permission.php?idpermission="+idpermission+"&lire="+lire+"&creer="+creer+"&modifier="+modifier+"&supprimer="+supprimer+"&page_accept="+page_accept+"&profil_id="+profil_id+"&droit="+droit+"&userName="+userName,true);
        xhttp.send();
    }
}
function deletecet_utilisateur(iduser_delete)
{
    var userName = $('#userName').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("reponse").innerHTML = this.responseText;
                  swal({   
                        title: "suppression reussi!",   
                        text: "Vous venez de supprimer ce utilisateur", 
                        type:"success",  
                        timer: 3000,   
                        showConfirmButton: false 
                     });
        }
    };
    xhttp.open("GET","ajax/Utilisateur/supprimer_user.php?iduser_delete="+iduser_delete+"&userName="+userName,true);
    xhttp.send(); 
}
function changempmot_de_passe(nomss,confirmer,nouveaupassword)
{
    var userName = $('#userName').val();
    //alert(nomss+' '+confirmer+' '+nouveaupassword);
    if(nomss == "" || confirmer == "" || nouveaupassword == "")
    {
        //alert('veuillez remplir tout le champ svp');
         swal({   
            title: "",   
            text: "veuillez remplir tout le champ svp", 
            type:"error",  
            timer: 3000,   
            showConfirmButton: false 
         });
    }
    if (confirmer != nouveaupassword ) 
    {
        //alert('Veillez vonfirmer le mot de passe svp');
        swal({   
            title: "",   
            text: "Veillez vonfirmer le mot de passe svp", 
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
                    document.location.href = $('#WEBROOT').val()+"deconnexion";
                }
                else
                    swal({title: "",   
                        text: "Une erreur s'est produite!",
                        type:"error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
            }
        };
        xhttp.open("GET","ajax/Utilisateur/change_mot_depasse.php?nomss="+nomss+"&nouveaupassword="+nouveaupassword+"&userName="+userName,true);
        xhttp.send();
    }
}
function modifier_profil(idprof,nomprofil)
{
    var userName = $('#userName').val();
    //alert(idprof+nomprofil);
    if(idprof == "" || nomprofil == "")
    {
        
         swal({    
            title: "",   
            text: "veuillez remplir tout le champ svp!",
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
                document.getElementById("rs").innerHTML = this.responseText;
                swal({
                    title: "",   
                    text: "Modification reussie!",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                //location.reload();
            }
        };
        xhttp.open("GET","ajax/Utilisateur/modifierProfiluser.php?idprof="+idprof+"&nomprofil="+nomprofil+"&userName="+userName,true);
        xhttp.send();
    }
}
function modif_detailprofil(identifiant,nomuser,prenomuser,adresmail,loginuser)
{
    var userName = $('#userName').val();
    //alert(identifiant+'/'+nomuser+'/'+prenomuser+'/'+adresmail+'/'+loginuser);
    if(identifiant == "" || nomuser == "" || prenomuser == "" || adresmail == "" || loginuser == "")
    {
        alert('veuillez remplir tout le champ svp');
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
                    swal({title: "",   
                          text: "Modification reussie!",
                          type:"success",   
                          timer: 3000,   
                          showConfirmButton: false 
                      });
                }
                else
                    swal({title: "",   
                            text: "Une erreur s'est produite!",
                            type:"error",   
                            timer: 3000,   
                            showConfirmButton: false 
                        });
            }
        };
        xhttp.open("GET","ajax/Utilisateur/modifier_detail_profiluser.php?identifiant="+identifiant+"&nomuser="+nomuser+"&prenomuser="+prenomuser+"&adresmail="+adresmail+"&loginuser="+loginuser+"&userName="+userName,true);
        xhttp.send();
    }
}
function supprimeprofil(numprof)
{
    var userName = $('#userName').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rs").innerHTML = this.responseText;
             swal({    title: "Information!",   
                      text: "Suppression reussie",
                      type:"success",   
                      timer: 3000,   
                      showConfirmButton: false 
                  });
        }
    };
    xhttp.open("GET","ajax/Utilisateur/drop_profil.php?numprof="+numprof+"&userName="+userName,true);
    xhttp.send();
}
function setDashboardToProfil(profil_id,dashboard)
{
    var userName = $('#userName').val();
    //alert('profil_id: '+profil_id+' dashboard: '+dashboard);
    if (profil_id == '' || dashboard == '') 
    {
        swal({    
            title: "Information!",   
            text: "Veillez renseigner tous les champs",  
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
                if (rep == 'ok') 
                {
                    location.reload();
                    swal({    
                        title: "Information!",   
                        text: "Traitement reussie",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    swal({    
                        title: "Information!",   
                        text: this.responseText,   
                        timer: 10000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/Utilisateur/setDashboardToProfil.php?profil_id="+profil_id+"&dashboard="+dashboard+"&userName="+userName,true);
        xhttp.send();
    }
}
function updateDashboardToProfil(profil_id,dashboard)
{
    var userName = $('#userName').val();
    //alert('profil_id: '+profil_id+' dashboard: '+dashboard);
    if (profil_id == '' || dashboard == '') 
    {
        swal({    
            title: "Information!",   
            text: "Veillez renseigner tous les champs",  
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
                if (rep == 'ok') 
                {
                    location.reload();
                    swal({    
                        title: "Information!",   
                        text: "Traitement reussie",
                        type:"success",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
                else
                {
                    swal({    
                        title: "Information!",   
                        text: this.responseText,   
                        timer: 10000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/Utilisateur/updateDashboardToProfil.php?profil_id="+profil_id+"&dashboard="+dashboard+"&userName="+userName,true);
        xhttp.send();
    }
}
//updateInfoSociete(id_societe,shownom,ville,showadresse,showphone,showmail,shownif,showcentreFiscal,showsecteur,showboitepostal,showformejuridique)
function updateInfoSociete(id,nom,ville,adresse,phone,mail,nif,centreFiscal,secteur,boiteP,formeJuridique)
{
    var userName = $('#userName').val();
    //alert('nom: '+nom+' adresse: '+adresse+' phone: '+phone+' mail: '+mail+' nif: '+nif+' centreFiscal: '+centreFiscal+' secteur: '+secteur+' boiteP: '+boiteP+'formeJuridique: '+formeJuridique);
    
    if (nom == '' || adresse == '' || phone == '' || mail == '' || nif == '' || centreFiscal == '' || secteur == '' || formeJuridique == '') 
    {
        swal({    
            title: "Information!",   
            text: "Veillez renseigner tous les champs en *",
            type: "error",  
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
                if (rep == 'ok') 
                {
                    //location.reload();
                    document.location.href = $('#WEBROOT').val()+"deconnexion";
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
                    //document.getElementById('').innerHTML = this.responseText;
                    swal({    
                        title: "",   
                        text: "Une erreur c'est produite lors de la modification",
                        type: "error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/Utilisateur/updateInfoSociete.php?id="+id+"&nom="+nom+"&ville="+ville+"&adresse="+adresse+"&phone="+phone+"&email="+mail+"&nif="+nif+"&centreFiscal="+centreFiscal+"&secteur="+secteur+"&boiteP="+boiteP+"&formeJuridique="+formeJuridique+"&userName="+userName,true);
        xhttp.send();
    }
}
function creerInfoSociete(nom,adresse,phone,mail,nif,centreFiscal,secteur,boiteP,formeJuridique)
{
    var userName = $('#userName').val();
    //alert('nom: '+nom+' adresse: '+adresse+' phone: '+phone+' mail: '+mail+' nif: '+nif+' centreFiscal: '+centreFiscal+' secteur: '+secteur);
    if (nom == '' || adresse == '' || phone == '' || mail == '' || nif == '' || centreFiscal == '' || secteur == '') 
    {
        swal({    
            title: "Information!",   
            text: "Veillez renseigner tous les champs en *",
            type: 'error',  
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
                if (rep == 'ok') 
                {
                    location.reload();
                    swal({    
                        title: "Information!",   
                        text: "Traitement reussie",
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
                        type: "error",   
                        timer: 3000,   
                        showConfirmButton: false 
                    });
                }
            }
        };
        xhttp.open("GET","ajax/Utilisateur/creerInfoSociete.php?nom="+nom+"&adresse="+adresse+"&phone="+phone+"&email="+mail+"&nif="+nif+"&centreFiscal="+centreFiscal+"&secteur="+secteur+"&boiteP="+boiteP+"&formeJuridique="+formeJuridique+"&userName="+userName,true);
        xhttp.send();
    }
}
function bloqueruser(iduser,etat)
{
    var userName = $('#userName').val();
     //alert(iduser+' '+etat);
    if(iduser == "" || etat == "" )
    {
        //alert('veuillez remplir tout le champ svp');
        swal({   
                        title: "Erreur!",   
                        text: "Veillez remplir tout les champs", 
                        //type:"success",  
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
                        title: "modification reussi!",   
                        text: "Vous venez de bloquer cet utilisateur", 
                        type:"success",  
                        timer: 14000,   
                        showConfirmButton: false 
                   });
                
            }
            //location.reload();
        };
        xhttp.open("GET","ajax/Utilisateur/desactiver_user.php?iduser="+iduser+"&etat="+etat+"&userName="+userName,true);
        xhttp.send();
    }
}
function debloqueruser(iduser,new_etat)
{
    var userName = $('#userName').val();
     //alert(iduser+' '+new_etat);
    if(iduser == "" || new_etat == "" )
    {
        //alert('veuillez remplir tout le champ svp');
        swal({   
                        title: "Erreur!",   
                        text: "Veillez remplir tout les champs", 
                        type:"error",  
                        timer: 4000,   
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
                        title: "modification reussi!",   
                        text: "Vous venez de bloquer cet utilisateur", 
                        type:"success",  
                        timer: 3000,   
                        showConfirmButton: false 
                   });
               location.reload();
            }
        };
        xhttp.open("GET","ajax/Utilisateur/activer_un_utilisateur.php?iduser="+iduser+"&new_etat="+new_etat+"&userName="+userName,true);
        xhttp.send();
    }
}
function recoverPassword(password,repassword,token)
{
    //alert('password: '+password+' repassword: '+repassword+' token: '+token);

    if (password == '' || repassword == '') 
    {
        swal({   
            title: "",   
            text: "veuillez renseigner les mot de passe!", 
            type:"error",  
            timer: 3000,   
            showConfirmButton: false 
        });
    }
    else if (password != repassword) 
    {
        swal({   
            title: "",   
            text: "Veuillez confirmer le mot de passe!", 
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
                    /*location.reload();
                    swal({   
                        title: "",   
                        text: "", 
                        type:"success",  
                        timer: 3000,   
                        showConfirmButton: false 
                    });*/
                    $("#loginform").slideUp();
                    $("#recoverform").fadeIn();
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
        xhttp.open("GET","ajax/Utilisateur/recoverPassword.php?password="+password+"&token="+token,true);
        xhttp.send();
    }
}