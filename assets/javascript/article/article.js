
function ajouterArticle(langue,corp_article)
{ 
    var userName = $('#userName').val();
    //alert(numero+' '+typecontrat+'  '+typearticle+' '+langue+'  '+titre+' '+corp_article)
 
   if (langue =='' || corp_article == '' ) 
    {
        //alert('veuillez remplir tout le champ svp');
        swal({    
            title: "Information!",   
            text: "veuillez remplir tout le champ svp",
            type:"success",   
            timer: 3000,   
            showConfirmButton: false 
            });
    }
    else
    {
        var corp_article = corp_article.trim();
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
             
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({    title: "Information!",   
                          text: "Ajout de l'article reussie",
                          type:"success",   
                          timer: 3000,   
                          showConfirmButton: false 
                    });
                $('#corp_article').val('');
                location.reload();
                
            }
        };
        xhttp.open("GET","ajax/articles/saveArticle.php?langue="+langue+"&corp_article="+corp_article+"&userName="+userName,true);
        xhttp.send();
    }
}
function updateArticle(numero,langue,corp_article)
{
    //alert(numero+'  '+langue+'  '+corp_article);
    var userName = $('#userName').val();
  
 
    if (numero === "" || langue === "" || corp_article === "") 
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
                
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Modification de l'article reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                location.reload();
            }
        };
        xhttp.open("GET","ajax/articles/modifierArticle.php?numero="+numero+"&langue="+langue+"&corp_article="+corp_article+"&userName="+userName,true);
        xhttp.send();
    }
}
function deleteArticle(numero)
{
    var userName = $('#userName').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("reponse").innerHTML = this.responseText;
            swal({    title: "Information!",   
                      text: "Suppression reussie",
                      type:"success",   
                      timer: 3000,   
                      showConfirmButton: false 
                  });
            location.reload();
        }
    };
    xhttp.open("GET","ajax/articles/DeleteArticle.php?numero="+numero+"&userName="+userName,true);
    xhttp.send();
}
function ajouterProfil(profil_name,profil_description)
{
    if (profil_name == '') 
    {
        swal({       
            title: "Erreur!",   
            text: "veuillez entrez le profil",
            type:"success",   
            timer: 1000,   
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
               
                    document.getElementById("profil").innerHTML = this.responseText;
                    swal({   
                        title: "Information!",   
                        text: "Profil ajouter avec succes",
                        type:"success",   
                        timer: 1000,   
                        showConfirmButton: false 
                    });
                    $('#profil_name').val('');
                    $('#profil_description').val('');
                    location.reload();
                
            }
           
        };
        xhttp.open("GET","ajax/articles/ajouterProfil.php?profil_name="+profil_name+"&description="+profil_description,true);
        xhttp.send();
    }
}
function showArtcleByProfil(profil)
{
    if (profil == '') 
    {
        swal({       
            title: "Erreur!",   
            text: "pas de profil",
            type:"error",   
            timer: 1000,   
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
            }
        };
        xhttp.open("GET","ajax/articles/showArtcleByProfil.php?profil="+profil,true);
        xhttp.send();
    }
}
function showArtcle(profil,langue)
{
    if (profil == '') 
    {
        swal({       
            title: "Erreur!",   
            text: "veuillez entrez la langue",
            type:"error",   
            timer: 1000,   
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
            }
        };
        xhttp.open("GET","ajax/articles/article_afficher_profil.php?profil="+profil+"&langue="+langue,true);
        xhttp.send();
    }
}
function modifier_titre(idatre,titre_attrib)
{
    //alert(idatre+titre_attrib);
     if (idatre === "" || titre_attrib === "") 
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
           
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Modification du titre reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                location.reload();
            }
        };
        xhttp.open("GET","ajax/articles/updatre_titre.php?idatre="+idatre+"&titre_attrib="+titre_attrib,true);
        xhttp.send();
    }
}
function modifier_titre_article(num,titre_article)
{
      if (num === "" || titre_article === "") 
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
           
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Modification du titre reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                location.reload();
            }
        };
        xhttp.open("GET","ajax/articles/update_titre_article.php?num="+num+"&titre_article="+titre_article,true);
        xhttp.send();
    }
}
function updateProfil(profil_id,profil_name)
{
   // alert(profil_id+profil_name);
      if (profil_id === "" || profil_name === "") 
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
           
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Modification du profil reussie",
                    type:"success",   
                    timer: 1000,   
                    showConfirmButton: false 
                });
                location.reload();
            }
        };
        xhttp.open("GET","ajax/articles/modifier_nomprofil.php?profil_id="+profil_id+"&profil_name="+profil_name,true);
        xhttp.send();
    }
}
function efface_profil(numprof,user_del)
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("reponse").innerHTML = this.responseText;
            swal({    title: "Information!",   
                      text: "Suppression reussie",
                      type:"success",   
                      timer: 2000,   
                      showConfirmButton: false 
                  });
            location.reload();
        }
    };
        xhttp.open("GET","ajax/articles/suprim_profil.php?numprof="+numprof+"&user_del="+user_del,true);
        xhttp.send();
    }
function showHideInput_titre(titre,i)
{
    //alert(titre+"/"+i);
    if (titre.checked) 
    {
       $("#contena_titre"+i).show();
        
    }
    else
    {
        $("#contena_titre"+i).hide();
    }
}
function numero_ordre(i)
{
    alert(i);
   /* for (var n =  1; n <= parseInt(j); n++) 
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
                            title:"Echec",
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
            }
        }
    }*/

}
function mettre_profil_global(profil_name,profil_id)
{
   
      var userName = $('#userName').val();
       //alert(new_profil+':  '+profil_id);
  if (profil_name == '') 
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
            document.getElementById("reponse").innerHTML = this.responseText;
            location.reload();
            swal({    title: "Information!",   
                      text: "reussie",
                      type:"success",   
                      timer: 2000,   
                      showConfirmButton: false 
                  });
             //   location.reload();
        }
            
        };
        xhttp.open("GET","ajax/articles/setProfil_global.php?profil_id="+profil_id+"&profil_name="+profil_name+"&userName="+userName,true);
        xhttp.send();
    }
}
function ajouterVersoArticle(titre,langue,corp_article,dateVerso)
{
    //alert(titre+langue+corp_article+dateVerso);
    var userName = $('#userName').val();
    if (titre === "" || langue === "" || corp_article === "" || dateVerso === "") 
    {
         alert('veuillez remplir tout le champ svp');
    }
    else
         {
            var corp_article = corp_article.trim();
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                 
                    document.getElementById("reponse").innerHTML = this.responseText;
                    swal({    title: "Information!",   
                              text: "Ajout de l'article reussie",
                              type:"success",   
                          timer:3000,   
                          showConfirmButton: false 
                    });
                $('#corp_article').val('');
               location.reload();
                
            }
        };
        xhttp.open("GET","ajax/articles/saveVerso.php?titre="+titre+"&langue="+langue+"&corp_article="+corp_article+"&dateVerso="+dateVerso+"&userName="+userName,true);
        xhttp.send();
    }
}
function updateVeso(numero,langue,corp_article)
{
    var userName = $('#userName').val();
      if (numero === "" || langue === "" ||corp_article === "" ) 
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
           
                document.getElementById("reponse").innerHTML = this.responseText;
                swal({   
                    title: "Information!",   
                    text: "Modification du profil reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                //location.reload();
            }
        };
        xhttp.open("GET","ajax/articles/modifierVerso.php?numero="+numero+"&langue="+langue+"&corp_article="+corp_article+"&userName="+userName,true);
        xhttp.send();
    }
}
function deleteVerso(numero)
{
    var userName = $('#userName').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("reponse").innerHTML = this.responseText;
            swal({    title: "Information!",   
                      text: "Suppression reussie",
                      type:"success",   
                      timer: 3000,   
                      showConfirmButton: false 
                  });
            location.reload();
        }
    };
    xhttp.open("GET","ajax/articles/DeleteVerso.php?numero="+numero+"&userName="+userName,true);
    xhttp.send();
}

