$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
        $('#nomprospect').val(idclient);
        $('#modal_nomprospect').slideUp(200);
	})
});