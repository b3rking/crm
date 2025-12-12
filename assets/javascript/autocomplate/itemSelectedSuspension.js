$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
		var tb = idclient.split(/_/);
        $('#idclient_suspension').val(tb[0]);
        $('#service').val(tb[1]);
        $('#modal-suspension').slideUp(200);
	})
});
