$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
		var tb = idclient.split(/_/);
        $('#client_donner_caution').val(tb[0]);
        $('#modal_client_donner_caution').slideUp(200);
        $('#idClient').val(tb[0].split(/-/)[1]);
	})
});