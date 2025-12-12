
function filtreHistorique(type,date1,date2,action)
{
	//alert('type: '+type+' date1: '+date1+' date2: '+date2+' action: '+action);

	//var WEBROOT = $('#WEBROOT').val();
    var condition1 = null;
    var condition2 = null;
    var condition3 = null;
    var condition4 = null;
    var condition = '';
    if (type == '') 
    {
        condition1 = '';
    }
    else
    {
        condition1 = " type='"+type+"' ";
    }
    if (date1 == '') 
    {
        condition2 = '';
    }
    else
    {
        condition2 = " dateAction='"+date1+"' ";
    }
    if (date2 == '') 
    {
        condition3 = '';
    }
    else
    {
        if (date1 !== '') 
        {
            condition3 = " dateAction BETWEEN '"+date1+"' AND '"+date2+"' ";
            condition2 = '';
        }
        else condition3 = " dateAction='"+date2+"' ";
    }
    if (action == '') 
    {
    	condition4 = '';
    }
    else
    {
    	condition4 = " action='"+action+"' ";
    }

    condition1 = (condition1 == '' ? '' : 'AND' +condition1);
    condition2 = (condition2 == '' ? '' : 'AND' +condition2);
    condition3 = (condition3 == '' ? '' : 'AND' +condition3);
    condition4 = (condition4 == '' ? '' : 'AND' +condition4);

    condition = condition1+condition2+condition3+condition4;

    if (condition == '') 
    {
    }
    else
    {
    	//condition = condition.substr(3);
    	var xhttp;
	    xhttp = new XMLHttpRequest();
	    xhttp.onreadystatechange = function()
	    {
	        if (this.readyState == 4) 
	        {
	        	$('#myTable').DataTable().destroy(); 
	            document.getElementById('rep').innerHTML = this.responseText;
	            $('#myTable').DataTable(); 
	        }
	    };
	    xhttp.open("GET","ajax/historique/filtreHistorique.php?condition="+condition,true);
	    xhttp.send();
    }
}
function resetFiltreHistorique()
{
	document.location.reload();
} 