$(document).ready(function(){

	$('.item').click(function(){
		var  client = this.getAttribute('idclient');
		var tb = client.split(/-/);
        $('#clientActiver').val(client);
        $('#modal-activeclient').slideUp(200);
        $('#idclient').val(tb[1]);
	})
});