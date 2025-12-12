$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
		//var tb = idclient.split(/_/);
        $('#idclient_facture_proformat').val(idclient);
        $('#modal').slideUp(200);
        //$('#billing_number').val(tb[2]);
        //recupererService(tb[1]);
	})
});
/*function recupererService(val)
{
	$.post('ajax/autocomplete/includeServiceOnCreerfacture_proformat.php',{result:val},function(data){

            $('#service_contener').html(data);
        })
}*/