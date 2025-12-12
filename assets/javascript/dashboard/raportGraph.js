if (action == 'rapports') 
{
    $(document).ready(function(){
        // Nombre de client par type
        var donut_chart = Morris.Donut({
        element: 'morris-donut-chart-client-actif',
        data: cActif,
        resize: true,
        colors:['#999999', '#FFFF00', 'chocolate','#0000FF']
        });
        // Nombre de client par localisation
        /*Morris.Donut({
        element: 'morris-donut-chart-localisation',
        data: cloc,0000FF
        resize: true,
        colors:['#009efb', '#55ce63', '#2f3d4a']
        });*/
    })
    $(document).ready(function(){
        // Solde mensuel des clients
        Morris.Bar({
        element: 'solde-mensuel',
        data: soldemensuel,
        xkey: 'mois',
        ykeys: ['solde'],
        labels: ['solde',],
        barColors:['#03A9F3'],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
        });
    })
}
