$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
		var tb = idclient.split(/_/);
        $('#idclientFiltre').val(tb[0]);
        $('#modal').slideUp(200);
	})
});