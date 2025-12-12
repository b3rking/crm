$(document).ready(function(){

	$('.item').click(function(){
		var  client = this.getAttribute('idclient');
		var tb = client.split(/-/);
        $('#clientAcouper').val(tb[0]+'-'+tb[1]+'-'+tb[2]);
        $('#modal').slideUp(200);
        $('#idclient').val(tb[1]);
        $('#type_client').val(tb[3]);
	})
});