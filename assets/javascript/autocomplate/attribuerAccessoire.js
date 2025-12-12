$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
        $('#idclient_attribu_accessoir').val(idclient);
        $('#nom_client').val(idclient.split(/-/)[2]);
        $('#modalAtribu_accessoire').slideUp(200);
	})

});