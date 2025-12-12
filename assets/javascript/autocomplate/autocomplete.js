//Autocomplete sur le champ client parent pour la creation de sous client
//a inclure dans un cotract

$('#idclient_parent').keyup(function(){
        var result = $(this).val();
        if (result != " ") 
        {
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    //document.getElementById("modal1").innerHTML = this.responseText;
                    $('#modal1').html(this.responseText);
                    $('#modal1').slideDown(300);
                    //document.getElementById("modal1").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET","ajax/contract/autocomplateClientParent.php?client="+result,true);
            xhttp.send();
        } 
        else {
             //alert('le champ matricule est vide');
        }
    });
// AUTOCOMPLETE client sur la page Contract lors de la creation de contract

$('#idclientOnContract').keyup(function(){
        var result = $(this).val();
        if (result != " ") 
        {
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    $('#modal').html(this.responseText);
                    $('#modal').slideDown(300);
                    //document.getElementById("modal1").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET","ajax/autocomplete/autocomplateClientCreerContract.php?client="+result,true);
            xhttp.send();
        } 
        else {
             //alert('le champ matricule est vide');
        }
    });
$('#idclientOnFichierAtacher').keyup(function(){
    var result = $(this).val();
    if (result != " ") 
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                $('#modal').html(this.responseText);
                $('#modal').slideDown(300);
                //document.getElementById("modal1").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/autocomplete/autocomplateClientOnFichierAtacher.php?client="+result,true);
        xhttp.send();
    } 
    else {
         //alert('le champ matricule est vide');
    }
});
// AUTOCOMPLETE CLIENT SUR CREER TICKET
$('#idclientCreerTicket').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/clientCreerTicket.php',{result:result},function(data){

            $('#modalCreerTicket').html(data);
            $('#modalCreerTicket').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });
// AUTOCOMPLETE CLIENT FILTRE TICKET
$('#idclientFiltreTicket').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/clientFiltreTicket.php',{result:result},function(data){

            $('#modalFiltreTicket').html(data);
            $('#modalFiltreTicket').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });

// Autocomplete client pour la creation de facture sur la page facture

$('#idclient_facture').keyup(function(){
    var result = $(this).val();
    if (result != " ") {
      
    $.post('ajax/autocomplete/autocompeteClientOnCreeFacture.php',{result:result},function(data){

        $('#modal').html(data);
        $('#modal').slideDown(300);
    })

    } else {
         //alert('le champ matricule est vide');
    }
});
$('#clientAcouper').keyup(function(){
    var result = $(this).val();
    if (result != " ") {
      
    $.post('ajax/autocomplete/unClientAcouper.php',{result:result},function(data){

        $('#modal').html(data);
        $('#modal').slideDown(300);

    })

    } else {
         //alert('le champ matricule est vide');
    }
});
$('#clientActiver').keyup(function(){
    var result = $(this).val();
    if (result != " ") {
      
    $.post('ajax/autocomplete/activerClient.php',{result:result},function(data){

        $('#modal-activeclient').html(data);
        $('#modal-activeclient').slideDown(300);

    })

    } else {
         //alert('le champ matricule est vide');
    }
});
//AUTOCOMPLETE FACTURE PROFORMAT
function autocomplete_facture_proformat(val)
{
    var result = val;
    if (result != " ") {
      
    $.post('ajax/autocomplete/autocompeteclient_facture_proformat.php',{result:result},function(data){

        $('#modal').html(data);
        $('#modal').slideDown(300);

    })

    } else {
        // alert('le champs est vide ');
    }
}

// Autocomplete client sur la page paiement 

$('#idclient_paiement').keyup(function(){
    var result = $(this).val();
    if (result != " ") {
      
    $.post('ajax/autocomplete/autocompeteClientOnCreePaiement.php',{result:result},function(data){
        $('#autocomplete_conteneur').html(data);
        $('#autocomplete_conteneur').slideDown(300);
    })
    } else {
         //alert('le champ matricule est vide');
    }
});

// AUTOCOMPLETE CLIENT SUR LA PAGE CLIENT FILTRE

$('#idclientFiltre').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/filtreClient.php',{result:result},function(data){

            $('#modal').html(data);
            $('#modal').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });

/*
*  AUTOCOPLETE CLIENT SUR LA PAGE ATRIBUER ACCESSOIRE
*/
function getClientToAtrib_Accessoir(result)
{
    if (result != " ") {
      
    $.post('ajax/autocomplete/attribuerAccessoire.php',{result:result},function(data){

        $('#modalAtribu_accessoire').html(data);
        $('#modalAtribu_accessoire').slideDown(300);

    })

    } else {
         //alert('le champ matricule est vide');
    }
}
$('#idclient_attribu_accessoir').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/attribuerAccessoire.php',{result:result},function(data){

            $('#modalAtribu_accessoire').html(data);
            $('#modalAtribu_accessoire').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });

/*
* AUTOCOMPLETE CLIENT FICHE INSTALLATION
*/

$('#idclient_ficheInstallation').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/ficheInstallation.php',{result:result},function(data){

            $('#modal_fiche_instal').html(data);
            $('#modal_fiche_instal').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });
/*
* AUTOCOMPLETE CLIENT FICHE DEMENAGEMENT
*/

$('#idclient_fiche_demenag').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/ficheDemenagement.php',{result:result},function(data){

            $('#modal_demenag').html(data);
            $('#modal_demenag').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });
/*
* AUTOCOMPLETE CLIENT RECUPERATION
*/
$('#idclient_fiche_recup').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/ficheRecuperation.php',{result:result},function(data){

            $('#modal_recuper').html(data);
            $('#modal_recuper').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });
/*
* AUTOCOMPLETE CLIENT BANDE PASSANTE
*/
$('#idclient_bandepassante').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/ficheBandePassante.php',{result:result},function(data){

            $('#modal_bandeP').html(data);
            $('#modal_bandeP').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });

/*
* AUTOCOMPLETE PROSPECT SUR VITER PROSPECT
*/
$('#idprospects').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/visiteProspect.php',{result:result},function(data){

            $('#modal').html(data);
            $('#modal').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });

/*
* AUTOCOMPLETE NOM PROSPECT SUR LE FILTRE
*/
$('#nomprospect').keyup(function(){
    var result = $(this).val();
    if (result != " ") {
      
    $.post('ajax/autocomplete/nomProspectFiltre.php',{result:result},function(data){

        $('#modal_nomprospect').html(data);
        $('#modal_nomprospect').slideDown(300);

    })

    } else {
         //alert('le champ matricule est vide');
    }
});

/*
* AUTOCOMPLETE CLIENT SUR LA PAGE SUSPENSION
*/

$('#idclient_suspension').keyup(function(){
    var result = $(this).val();
    if (result != " ") {
      
    $.post('ajax/autocomplete/clientSuspesion.php',{result:result},function(data){

        $('#modal-suspension').html(data);
        $('#modal-suspension').slideDown(300);
    })

    } else {
         //alert('le champ matricule est vide');
    }
});
/* 
* AUTOCOMPLETE CLIENT SUR LE FILTRE FACTURE
*/
$('#client_filter_fact').keyup(function(){
    var result = $(this).val();
    if (result != " ") {
      
    $.post('ajax/autocomplete/client_filter_fact.php',{result:result},function(data){

        $('#modal_client_filter_fact').html(data);
        $('#modal_client_filter_fact').slideDown(300);
    })

    } else {
         //alert('le champ matricule est vide');
    }
});
// AUTOCOMPLETE client avec caution

$('#idclientCaution').keyup(function(){
        var result = $(this).val();
        if (result != " ") 
        {
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    $('#modal_caution').html(this.responseText);
                    $('#modal_caution').slideDown(300);
                    //document.getElementById("modal_caution").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET","ajax/autocomplete/autocomplete_client_cautionavecContrat.php?client="+result,true);
            xhttp.send();
        } 
        else {
             //alert('le champ matricule est vide');
        }
    });
// AUTOCOMPLETE CLIENT AVEC CONTRACT

$('#idclientFiltre').keyup(function(){
        var result = $(this).val();
        if (result != " ") 
        {
            var xhttp;
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4) 
                {
                    $('#modal_contrat').html(this.responseText);
                    $('#modal_contrat').slideDown(300);
                    //document.getElementById("modal_contrat").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET","ajax/autocomplete/autocomplete_contrat.php?client="+result,true);
            xhttp.send();
        } 
        else {
             //alert('le champ matricule est vide');
        }
    });
// AUTOCOMPLETE CLIENT DONNER CAUTION SUR EXTRACT
function clientDonnerCaution(result)
{
    if (result != "") 
    {
        $.post('ajax/autocomplete/client_donner_caution.php',{result:result},function(data){

            $('#modal_client_donner_caution').html(data);
            $('#modal_client_donner_caution').slideDown(300);
        })

    }
}
/*
* AUTOCOMPLETE CLIENT DIMINUER BANDE PASSANTE
*/
$('#idclient_diminuBP').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
          
        $.post('ajax/autocomplete/fiche_diminuerBP.php',{result:result},function(data){

            $('#modal_diminuer_bp').html(data);
            $('#modal_diminuer_bp').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });