$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
        $('#idclient').val(idclient);
        $('#modal').slideUp(200);
	})

});