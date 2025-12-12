
function ajouterTypeClient(type)
{
    var userName = $('#userName').val();
    if (type == '') 
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
                    text: "Ajout du nouveau type reussie",
                    type:"success",   
                    timer: 3000,   
                    showConfirmButton: false 
                });
                location.reload();
            }
        };
        xhttp.open("GET","ajax/typeclient/ajouterTypeClient.php?type="+type+"&userName="+userName,true);
        xhttp.send();
    }
}
function updateType(idtype,type)
{
    /*alert(type);*/
    var userName = $('#userName').val();
    if (type == '') 
    {
        alert('Veillez entrer le type');
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
        xhttp.open("GET","ajax/typeclient/updateType.php?idtype="+idtype+"&type="+type+"&userName="+userName,true);
        xhttp.send();
    }
}
function deleteType(idtype)
{
    var userName = $('#userName').val();
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("rep").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/typeclient/deleteType.php?idtype="+idtype+"&userName="+userName,true);
    xhttp.send();
}