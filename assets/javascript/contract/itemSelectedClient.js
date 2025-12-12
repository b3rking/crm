$(document).ready(function(){

	$('.item').click(function(){
		var  res = this.getAttribute('idclient');
		var tb = res.split(/_/);
        $('#idclient_parent').val(tb[0]);
        $('#num_contract').val(tb[1]);
        $('#id_parent').val(tb[2]);
        $('#monnaie_montract').val(tb[3]);
        $('#modal1').slideUp(200);
	})
});