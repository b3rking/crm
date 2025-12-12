 $(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
        $('#idclientFiltre').val(idclient);
        $('#modal_contrat').slideUp(200);
	})
});