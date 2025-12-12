$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
		var tb = idclient.split(/-/);
        $('#idclientOnFichierAtacher').val(tb[2]);
        $('#idclient').val(tb[1]);
        $('#modal').slideUp(200);
	})
});
