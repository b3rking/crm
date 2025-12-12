$(document).ready(function(){

    /*
    * MONTANT RECU
    */
    Morris.Bar({
    element: 'montant_recu_graph',
    data: montant_recu_graph,
    xkey: 'mois',
    ykeys: ['montant_recu'],
    labels: ['Montant recu',],
    barColors:['#03A9F3'],
    hideHover: 'auto',
    gridLineColor: '#eef0f2',
    resize: true
    });
})
