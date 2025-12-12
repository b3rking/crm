$(document).ready(function(){

	$('.item').click(function(){
		var  rep = this.getAttribute('idclient');
		var tb = rep.split(/_/);
        var client = tb[0].split(/-/);
        $('#idclient').val(client[1]);
        //$('#idclient_facture').val(client[0]+'-'+tb[2]+'-'+client[2]);
        $('#idclient_facture').val('tb[0]');
        $('#modal').slideUp(200);
        $('#idcontract').val(tb[1]);
        $('#billing_number').val(tb[2]);
        $('#next_billing_date').val(tb[3]);
        //recupererService(tb[1]);
        //getNextBillingDunClient(tb[0].split(/-/)[1]);
	})
});
function recupererService(val)
{
	$.post('ajax/autocomplete/includeServiceOnCreerfacture.php',{result:val},function(data){

            $('#service_contener').html(data);
        })
    //$('#nextbilling').value=val;
    //document.getElementById('nextbilling').value = 'oui';
}
function getNextBillingDunClient(idclient)
{
    /*$.post('ajax/autocomplete/getNextBillingDunClient.php',{result:idclient},function(data){

            $('#nextbilling').html(data);
        })*/
    $('#nextbilling').val(idclient);
}