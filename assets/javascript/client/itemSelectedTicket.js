$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
		var tb = idclient.split(/_/);
        $('#idclient').val(tb[0]);
        $('#con').val(tb[1]);
        $('#modal').slideUp(200);
	})
});