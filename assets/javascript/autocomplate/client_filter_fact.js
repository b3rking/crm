$(document).ready(function(){

	$('.item').click(function(){
		var  idclient = this.getAttribute('idclient');
		var tb = idclient.split(/_/);
        $('#client_filter_fact').val(tb[0]);
        $('#modal_client_filter_fact').slideUp(200);
	})
});
