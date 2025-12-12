function installation()
{
	var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("fiche-body").innerHTML = this.responseText;
        	autocompleteClient();
        }
    };
    xhttp.open("GET","ajax/fiches/installation.php?",true);
    xhttp.send();
}
function demenagement()
{
	var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("fiche-body").innerHTML = this.responseText;
        	autocompleteClient();
        }
    };
    xhttp.open("GET","ajax/fiches/demenagement.php?",true);
    xhttp.send();
}
function recuperation()
{
	var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("fiche-body").innerHTML = this.responseText;
        	autocompleteClient();
        }
    };
    xhttp.open("GET","ajax/fiches/recuperation.php?",true);
    xhttp.send();
}
function intervention(iduser)
{
	var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("fiche-body").innerHTML = this.responseText;
        	autocompleteClient();
        }
    };
    xhttp.open("GET","ajax/fiches/intervention.php?iduser="+iduser,true);
    xhttp.send();
}
function resetFiltreFicheIntervention()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"inc_ficheintervention";
}
function resetFiltreFicheInstallation()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"inc_ficheinstation";
}
function resetFiltreFicheDemenagement()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"inc_fichedemenagement";
}
function resetFiltreFicheRecuperation()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"inc_ficherecuperation";
}
function resetFiltreFicheAugmentationBp()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"inc_ficheaugmentationbp";
}
function resetFiltreFicheDiminutionBp()
{
    var WEBROOT = $('#WEBROOT').val();
    document.location.href = WEBROOT+"inc_fichediminutionbp";
}
function bandepassante()
{
	var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("fiche-body").innerHTML = this.responseText;
        	autocompleteClient();
        }
    };
    xhttp.open("GET","ajax/fiches/bandepassante.php?",true);
    xhttp.send();
}
function autocompleteClient()
{
    $('#idclient').keyup(function(){
        var result = $(this).val();
        if (result != " ") {
              
        $.post('ajax/client/autocompeteClient.php',{result:result},function(data){

            $('#modal').html(data);
        $('#modal').slideDown(300);

        })

        } else {
             //alert('le champ matricule est vide');
        }
    });
}
function Ordremission()
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("fiche-body").innerHTML = this.responseText;
            autocompleteClient();
        }
    };
    xhttp.open("GET","ajax/fiches/ficheMission.php?",true);
    xhttp.send();
}
function supprimer_fiche(idfiche,userName)
{
    //alert(idfiche);
   var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            location.reload();
            //document.getElementById("rep").innerHTML = this.responseText;
            swal({   
                title: "",   
                text: "suppression reussie",
                type:"success",   
                timer: 3000,   
                showConfirmButton: false 
            });
            //localtion.reload();
        }
    };
    xhttp.open("GET","ajax/fiches/deleteFiche.php?idfiche="+idfiche+"&userName="+userName,true);
    xhttp.send();
}
var ticketCount = 0;
function verifierTicketCocher(element)
{
    if (element.checked) 
    {
        ticketCount++;
        $('#counterTicketSelected').val(ticketCount);
    }
    else
    {
        ticketCount--;
        $('#counterTicketSelected').val(ticketCount);
    }
}
function validateFormFicheIntervention()
{
    var ticketSelect = $('#counterTicketSelected').val();
    var vehicule = $('#vehicule').val();
    var technicien = $('#technicien').val();
    if (vehicule == '' || technicien == '' || ticketSelect == 0) 
    {
        swal({
            title:"",
            text:"Veillez renseigner les champs en *",
            type:"error",
            timer:3000,
            showConfirmButton:false
        });
    }
    else document.getElementById('form-fiche-intervention').submit();
}

const selectCustomerToCreateFiche = document.getElementById('selectCustomerToCreateFiche');
if(selectCustomerToCreateFiche === null){}
else
{
    const options = Array.from(selectCustomerToCreateFiche.options);
    const input = document.getElementById('seachCustomerToCreateFiche');
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
        selectCustomerToCreateFiche.append(...matchArray);
    }

    input.addEventListener('keyup', filterOptions);
}
