$(document).ready(function(){
    "use strict";
    // Nombre de client par type
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
    colors:['green','#f7340c','#8d89f5', 'chocolate','#999999','blue']
    });

    /*
    * MONTANT RECU
    */
    Morris.Bar({
    element: 'montant_recu_graph',
    data: montant_recu_graph,
    xkey: 'mois',
    ykeys: ['monnaie_USD','monnaie_locale'],
    labels: tbMonnaie,
    barColors:['#03A9F3','FF8300'],
    hideHover: 'auto',
    gridLineColor: '#eef0f2',
    resize: true
    });

    /**************************************
    ** SITUATION MENSUELLE DE LA TRESORERIE
    ***************************************/
    var line = new Morris.Line({
        element: 'situation-mensuel-tresorerie',
        resize: true,
        data: situation_mensuel_tresorerie_graph,
        xkey: 'y',
        ykeys: ['a','b'],
        labels: tbMonnaie,
        parseTime:false,
        gridLineColor: '#eef0f2',
        lineColors: ['#2f3d4a','#009efb'],
        lineWidth: 1,
        hideHover: 'auto'
      });

    /*
    * DEPENSE MENSUEL
    */
      Morris.Bar({
      element: 'depense-mensuel',
      data: depense_mensuel,
      xkey: 'mois',
      ykeys: ['a','b'],
      labels: tbMonnaie,
      barColors:['#03A9F3','FF8300'],
      hideHover: 'auto',
      gridLineColor: '#eef0f2',
      resize: true
      });
})
function printClientActif(url)
{
    document.location.href = url;
}