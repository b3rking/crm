$(document).ready(function(){

	$('.item').click(function(){
		var  client = this.getAttribute('idclient').split(/_/);
        $('#idclient_fiche_demenag').val(client[0]);
        //var oldAdresse = client[1];
        $('#oldAdresse').val(client[1]);
        $('#modal_demenag').slideUp(200);
	})

});