function includeTypeClient(idUser)
{
	var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("body-parametre").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/parametre/includeTypeClient.php?idUser="+idUser,true);
    xhttp.send();
}
function includeService(idUser)
{
	var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("body-parametre").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/parametre/includeService.php?idUser="+idUser,true);
    xhttp.send();
}
function includeContract(idUser)
{
	var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("body-parametre").innerHTML = this.responseText;
            //autocompleteClient();
        }
    };
    xhttp.open("GET","ajax/parametre/includeContract.php?idUser="+idUser,true);
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
function includeArticle()
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("body-parametre").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/parametre/includeArticle.php?",true);
    xhttp.send();
}
function includeVehicule()
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("body-parametre").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/parametre/includeVehicule.php?",true);
    xhttp.send();
}

function includeUtilisateur()
{
    var xhttp;
    xhttp = new XMLHttpRequest(); 
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            document.getElementById("body-parametre").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/parametre/includeUtilisateur.php?",true);
    xhttp.send();
}
 

function creerTaux(taux,description)
{
    //alert(taux+'  '+description);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            var rep = document.getElementById("rep");
             
             swal({   title: "vous venez de modifier l'ancien taux avec success!",   
                      text: "modification reussie",
                      type:"success",   
                      timer: 3000,   
                      showConfirmButton: false 
                  });
             $('#taux').val('');
             $('#description').val('');
        }
    };
    xhttp.open("GET","ajax/parametre/creerTaux.php?taux="+taux+"&description="+description,true);
    xhttp.send();
}
function cree_tva(tva,description,datetva)
{
    //alert(tva+'  '+description+'  '+datetva);
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4) 
        {
            var rep = document.getElementById("rep");
            rep.style.color = 'green';
            rep.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET","ajax/parametre/creerTva.php?tva="+tva+"&description="+description+"&datetva="+datetva,true);
    xhttp.send();
}