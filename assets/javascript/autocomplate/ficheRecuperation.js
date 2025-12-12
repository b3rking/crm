$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
        $('#idclient_fiche_recup').val(idclient);
        $('#modal_recuper').slideUp(200);
	})

});