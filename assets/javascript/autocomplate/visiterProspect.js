$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
        $('#idprospects').val(idclient);
        $('#modal').slideUp(200);
	})

});