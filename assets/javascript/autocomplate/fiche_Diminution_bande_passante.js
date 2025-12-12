$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
        $('#idclient_diminuBP').val(idclient);
        $('#modal_diminuer_bp').slideUp(200);
	})

});
