/*$(document).ready(function(){
    "use strict";
    //Solde annuel d'un client
    var line = new Morris.Line({
        element: "solde_annuel",
        resize: true,
        //data:solde_annuel,
         data:solde_annuel_dun_client,
        xkey: "y",
        ykeys: "a",
        labels: ["balance"],
        parseTime:false,
        gridLineColor: "#00A86B",
        lineColors: ["#00A86B"],
        lineWidth: 5,
        hideHover: "auto"
      });
})*/
$(document).ready(function(){
    "use strict";
    //Solde annuel d'un client
    var line = new Morris.Line({
        element: "solde_annuel",
        resize: true,
        //data:solde_annuel,
         data:solde_annuel_dun_client,
        xkey: "y",
        ykeys: "a",
        labels: ["balance"],
        parseTime:false,
        gridLineColor: "#8b4513",
        lineColors: ["#8b4513"],
        lineWidth: 5,
        hideHover: "auto"
      });
})