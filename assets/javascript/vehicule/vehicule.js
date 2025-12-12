
function ajouterVehicule(plaque,modele,marque)  
{
 	//alert(plaque+' '+modele+'  '+marque);
    if (plaque == '' || modele == '' || marque == '') 
    {
    	//alert('veuillez remplir tout le champ svp');
          swal({   
                                            title: "Erreur!",   
                                            text: "remplir tout les champs",
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
                                            title: "Information!",   
                                            text: "ajout vehicule reussie",
                                            type:"success",   
                                            timer: 3000,   
                                            showConfirmButton: false 
                                        });
    	    }
	    };
	    xhttp.open("GET","ajax/vehicules/ajouterVehicule.php?plaque="+plaque+"&modele="+modele+"&marque="+marque,true);
	    xhttp.send();
    }
}
function updateVehicule(plaque,newplaque,modele,marque)
{ 
    //alert(plaque+' '+modele+'  '+marque+'  '+newplaque);
 
    if (plaque == '' || modele == '' || marque == '' || newplaque == '') 
    {
        alert('veuillez remplir tout le champ svp');
          swal({   
                                            title: "Information!",   
                                            text: "veillez remplir tout les champs",
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
                                            text: "modification reussie",
                                            type:"success",   
                                            timer: 3000,   
                                            showConfirmButton: false 
                                        });
            }
        };
        xhttp.open("GET","ajax/vehicules/updateVehicule.php?newplaque="+newplaque+"&plaque="+plaque+"&modele="+modele+"&marque="+marque,true);
        xhttp.send();
    }
}
function deleteVehicule(plaque)
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
                                            text: "suppression reussie",
                                            type:"success",   
                                            timer: 3000,   
                                            showConfirmButton: false 
                                        });
        }
    };
    xhttp.open("GET","ajax/vehicules/deleteVehicule.php?plaque="+plaque,true);
    xhttp.send();
}