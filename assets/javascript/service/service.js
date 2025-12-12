
function ajouterService(nom,montant,monnaie,description)
{
    if(isNaN(montant))
    {
        //alert('Veuillez entreer un montant');
        swal({   
            title: "Information!",   
            text: "Veuillez entrez le montant",
            type:"success",   
            timer: 3000,   
            showConfirmButton: false 
        });
    }
	//alert('nom : '+nom+' montant : '+montant+' monnaie : '+monnaie+' description : '+description);
	else if (nom == '' || monnaie == '' || montant == '' || montant < 0) 
	{
		//alert('Veillez remplir tous les champs!');
        swal({    
            title: "Information!",   
            text: "Veillez remplir tout le champs",
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
                swal({    title: "",   
                          text: "Creation reussie",
                          type:"success",   
                          timer: 3000,   
                          showConfirmButton: false 
                    });
                $('#nom').val('');
                $('#montant').val('');
                $('#description').val('');
                 location.reload();
            }
        };
        xhttp.open("GET","ajax/service/ajouterService.php?nom="+nom+"&montant="+montant+"&monnaie="+monnaie+"&description="+description+"&userName="+userName,true);
        xhttp.send();
	}
}
function recupererServiceDunClient(idclient)
{
    //alert(idclient);
    if (idclient == '') 
    {
        alert('Veuiller entrer le client');
    }
    else
    {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4) 
            {
                document.getElementById("con").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET","ajax/service/recupererServiceDunClient.php?idclient="+idclient,true);
        xhttp.send();
    }
}
function updateService(idservice,nom,montant,monnaie,description)
{
    if (nom == '' || montant == '' || montant <= 0 || isNaN(montant)) 
    {
        alert('Le nom et le montant ne doivent pas etre vide et le montant ne doit pas etre <= 0');
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
                    title :"Modification du service reusie",
                    text :"Information",
                    timer :3000,
                    type :"success",
                    showConfirmButton: false
                });
                location.reload();
            }
        };
        xhttp.open("GET","ajax/service/updateService.php?idservice="+idservice+"&nom="+nom+"&montant="+montant+"&monnaie="+monnaie+"&description="+description+"&userName="+userName,true);
        xhttp.send();
    }
}
function deleteService(idservice)
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
                title: "Vous venez de supprimer ce service!",   
                      text: "Information",
                      type:"success",   
                      timer: 3000,   
                      showConfirmButton: false 
                });
            location.reload();
        }
    };
    xhttp.open("GET","ajax/service/deleteService.php?idservice="+idservice+"&userName="+userName,true);
    xhttp.send();
}