$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
        $('#idclient_bandepassante').val(idclient);
        $('#modal_bandeP').slideUp(200);
	})

});