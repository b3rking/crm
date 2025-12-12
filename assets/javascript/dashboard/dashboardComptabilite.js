  $(document).ready(function(){
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
  })