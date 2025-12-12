function NouvelleLocalisation(locationS)
{
      //alert(locationS+' );
 
     if (locationS == '') 
    {
        //alert('veuillez ajouter la localisation');
        swal({   
                                            title: " Erreur!",   
                                            text: " veuillez ajouter la localisation",
                                            type:"success",   
                                            timer: 3000,   
                                            showConfirmButton: false 
                                        });
                                            $('#locationS').val('');
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
                                            title: " La nouvelle localisation a été enregistré avec succès!",   
                                            text: " merci de continuez",
                                            type:"success",   
                                            timer: 3000,   
                                            showConfirmButton: false 
                                        });
                                            $('#locationS').val('');
            }
        };
        xhttp.open("GET","ajax/localisation/AjoutLocation.php?locationS="+locationS,true);
        xhttp.send();
    }

}
function afficheLocalisation()
{
    //alert(locationS+' );
    if (locationS == "")
    {
        alert('vous devez completer le nom de la localisation ');
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
        xhttp.open("GET","ajax/localisation/afficheLocalisation.php?locationS="+locationS,true);
        xhttp.send();
    }
}
function Updatelocalisation(idlocalisation,location)
{ 
    //alert(idlocalisation+'    '+location);
 
    if(locationS == "" )
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
                document.getElementById("rep").innerHTML = this.responseText;
                swal({   
                                            title: " modification reussie avec success!",   
                                            text: " merci de continuez",
                                            type:"success",   
                                            timer: 3000,   
                                            showConfirmButton: false 
                                        });

            }
        };
         xhttp.open("GET","ajax/localisation/updatelocalisation.php?idlocalisation="+idlocalisation+"&locationS="+location,true);
        xhttp.send();
    }
}
function deletelocalisation(idlocalisation)
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rep").innerHTML = this.responseText;
            swal({   
                                            title: " vous avez supprimer avec succès!",   
                                            text: " merci de continuez",
                                            type:"success",   
                                            timer: 3000,   
                                            showConfirmButton: false 
                                        });
        }
    };
        xhttp.open("GET","ajax/localisation/deletelocalisation.php?idlocalisation="+idlocalisation,true);
        xhttp.send();
}