
function createCustomerNote(idclient,description,iduser)
{
	if (description == "")
	{
		swal({   
            title: "",   
            text: "Veuillez entrer la description", 
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
                //document.getElementById("rep_note").innerHTML = this.responseText;
                var rep = String(this.responseText).trim();
                if (rep == "") 
                {
                	document.location.reload();
                	swal({   
                        title: "",   
                        text: "Ajout reussi", 
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
        xhttp.open("GET","ajax/customerNote/addNote.php?iduser="+iduser+"&description="+description+"&idclient="+idclient,true);
        xhttp.send();
	}
}