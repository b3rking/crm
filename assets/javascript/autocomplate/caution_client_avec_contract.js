$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
		var tb = idclient.split(/_/);
        $('#idclientCaution').val(tb[0]);
       // var factureData = tb[0].split(/-/);
        $('#modal_caution').slideUp(200);
        //$('#billing_number').val(tb[2]);
        //recupererService(factureData[1]);
	})
});
