$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
		var tb = idclient.split(/_/);
        $('#idclientFiltreTicket').val(tb[0]);
        $('#modalFiltreTicket').slideUp(200);
	})
});