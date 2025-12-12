$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
        $('#idclient_ficheInstallation').val(idclient);
        $('#modal_fiche_instal').slideUp(200);
	})

});