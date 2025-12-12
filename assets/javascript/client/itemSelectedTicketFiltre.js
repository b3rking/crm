$(document).ready(function(){

        $('.item').click(function(){
        var  idclient = this.getAttribute('idclient');
        $('#idclientFiltre').val(idclient);
        $('#modalFiltre').slideUp(200);
        })

});