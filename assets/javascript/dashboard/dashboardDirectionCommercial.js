$(document).ready(function(){
    "use strict";
    var donut_chart = Morris.Donut({
    element: 'morris-donut-chart',
    data: cType,
    resize: true,
    colors:['#009efb','#dc46f0','#55ce63','#8d89f5' ,'#FF8300', '#2f3d4a']
    });
    // Nombre de client par localisation
    /*Morris.Donut({
    element: 'morris-donut-chart-localisation',
    data: cLocal,
    resize: true,
    colors:['#009efb', '#55ce63', '#2f3d4a']
    });*/

    /*
    * STATUT CLIENT ACTIF
    */
    var donut_chart = Morris.Donut({
    element: 'morris-donut-chart-client-actif',
    data: cActif,
    resize: true,
    colors:['#f7340c','#8d89f5', 'chocolate','#999999','blue']
    /*colors:['#999999', '#FFFF00', 'chocolate','#2f3d4a','#0000FF']*/
    });
});
$(document).ready(function(){

    /*
    * MONTANT RECU
    */
    /*Morris.Bar({
    element: 'montant_recu_graph_dashboard',
    data: montant_recu_graph,
    xkey: 'mois',
    ykeys: ['montant_recu'],
    labels: ['Montant recu',],
    barColors:['#03A9F3'],
    hideHover: 'auto',
    gridLineColor: '#eef0f2',
    resize: true
    });*/ 

    Morris.Bar({
    element: 'montant_recu_graph_dashboard',
    data: montant_recu_graph,
    xkey: 'mois',
    ykeys: ['monnaie_USD','monnaie_locale'],
    labels: tbMonnaie,
    barColors:['#03A9F3','green'],
    hideHover: 'auto',
    gridLineColor: '#eef0f2',
    resize: true
    });
})