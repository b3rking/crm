$(document).ready(function(){

	$('.item').click(function(){
		var  rep = this.getAttribute('idclient');
		var tb = rep.split(/_/);
        var client = tb[0].split(/-/);
        $('#idclient').val(client[1]);
        $('#idclient_paiement').val(client[0]+'-'+tb[2]+'-'+client[2]);
        $('#billing_number').val(tb[2]);
        //var factureData = tb[0].split(/-/);
        $('#autocomplete_conteneur').slideUp(200);
        recupererService(client[1]);
        //alert('factureData');

	})
});
function recupererService(val)
{
	$.post('ajax/facture/getFactureNonPayerDunClient.php',{result:val},function(data){

            $('#facturepaye').html(data);
        })
}