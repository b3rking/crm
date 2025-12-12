<?php
    $tbMonnaie = ['USD','BIF'];
    $tbMonnaie = json_encode($tbMonnaie);
    $client = new Client();
    $localisation = new Localisation();
    $data = $client->totalClientParType();
    $contract = new Contract();
    $comptabilite = new Comptabilite();

    $data_local = array();
    $query_local = $localisation->nombreClientParLocalisation();
    foreach ($query_local as $value) 
    {
        $data_local[] = array(
        'label'  => $value->nom_localisation,
        'value'  => $value->nb
        );
    }
    $data_local = json_encode($data_local);

    // DATA GRAPH CLIENTS ACTIFS
    //$clSansDette = nbClientSoldeInfOuEgalZero();
    $clSansDette = $client->get_nombre_clientActif_sans_Dette();
    $clEnCoupure = $client->totalClientEnCoupure()->nb;
    $clEnDerogation = $client->totalClientEnDerogation()->nb;
    $clEnPause = $client->totalClientEnPause()->nb;
    $cActif = $client->totalClientsActif()->nb;
    $dataClActif = array(['label' => 'Sans dette','value' => $clSansDette],['label' => 'Client en coupure','value' => $clEnCoupure],['label' => 'En derogation','value' => $clEnDerogation],['label' => 'Pause','value' => $clEnPause],['label' => 'Client actif','value' => $cActif]);
    $dataClActif = json_encode($dataClActif);

    // MONTANT RECUS

    $tb_mois= [1=>'jan',2=>'fev',3=>'mars',4=>'avr',5=>'mai',6=>'juin',7=>'juil',8=>'aout',9=>'sep',10=>'oct',11=>'nov',12=>'dec'];
    $date = date_parse(date('Y-m-d'));
    $montant_recu_graph = '';
    $tx_recouvrement = 0;
    $montant_recu_USD = 0;
    $montant_recu_monnaie_local = 0;
    for ($i=6; $i > 0; $i--) 
    {
        //$facture = $contract->getfacture_total($i,date('Y'));
        //$montant_recu = $contract->getmontant_facture_payee($i,date('Y'));
        $date = date_parse(date("d-m-Y",strtotime(-$i." Months")));
        $mois = $date['month'];
        $annee = $date['year'];
        foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
        {
            if ($value->devise == 'USD')
                $montant_recu_USD = $value->montant;
            else $montant_recu_monnaie_local = $value->montant;
        }
        //$solde = $montant_recu - $facture;
        /*if (empty($montant_recu)) 
            $montant_recu = 0;*/
        $month = $tb_mois[$mois].'/'.$annee;
        $montant_recu_graph .= "{mois:'".$month."',monnaie_USD:'".$montant_recu_USD."',monnaie_locale:".$montant_recu_monnaie_local."}, ";
        if ($i == 1) 
        {
            $date = date_parse(date("d-m-Y"));
            $mois = $date['month'];
            $annee = $date['year'];
            $montant_recu_USD = 0;
            $montant_recu_monnaie_local = 0;
            //$montant_recu = $contract->getmontant_payer_dans_un_mois($mois,$annee);
            //$solde = $montant_recu - $facture;
            foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
            {
                if ($value->devise == 'USD')
                    $montant_recu_USD = $value->montant;
                else $montant_recu_monnaie_local = $value->montant;
            }
            /*if (empty($montant_recu)) 
                $montant_recu = 0;*/
            $month = $tb_mois[$mois].'/'.$annee;
            $montant_recu_graph .= "{mois:'".$month."',monnaie_USD:'".$montant_recu_USD."',monnaie_locale:".$montant_recu_monnaie_local."}, ";
            //$montant_recu_graph .= "{mois:'".$month."',montant_recu:".$montant_recu."}, ";
        }
    }
    $montant_recu_graph = substr($montant_recu_graph, 0,-2);

    // DEPENSE ET SITUATION TRESORERIE PAR MOIS

    $date = date_parse(date('Y-m-d'));
    $depense_mensuel_graph = '';
    $situation_mensuel_tresorerie_graph = '';
    $depense = 0;
    $depense_USD = 0;
    $depense_monnaie_locale = 0;
    $montant_payer_USD = 0;
    $montant_payer_monnaie_local = 0;
    $extrat_USD = 0;
    $extrat_monnaie_locale = 0;
    $solde_USD = 0;
    $solde_monnaie_locale = 0;
    for ($i=6; $i > 0; $i--) 
    {
        $date = date_parse(date("d-m-Y",strtotime(-$i." Months")));
        $mois = $date['month'];
        $annee = $date['year']; 
        //$resulta = $comptabilite->totalDepenseDunMois($mois,$annee)->fetch();
        foreach ($comptabilite->totalDepenseDunMois($mois,$annee) as $value) 
        {
            if ($value->monnaie == 'USD') 
                $depense_USD = $value->montant;
            else $depense_monnaie_locale = $value->montant;
        }
        /*foreach ($comptabilite->getMontantDepenseGrandeCaisseDunMois($mois,$annee) as $value) 
        {
            if ($value->monnaie == 'USD') 
            {
                $depense_USD += $value->montant;
                //$total_depense_mensuel_USD += $value->montant;
            }
            else
            {
                $depense_monnaie_locale += $value->montant;
                //$total_depense_mensuel_monnaie_locale += $value->montant;
            }
        }
        foreach ($comptabilite->getMontantDepenseBanqqueDunMois($mois,$annee) as $value) 
        {
            if ($value->monnaie == 'USD') 
            {
                $depense_USD += $value->montant;
                //$total_depense_mensuel_USD += $value->montant;
            }
            else
            {
                $depense_monnaie_locale += $value->montant;
                //$total_depense_mensuel_monnaie_locale += $value->montant;
            }
        }
        foreach ($comptabilite->getMontantApprovisionnementDunMois($mois,$annee) as $value) 
        {
            if ($value->monnaie == 'USD') 
            {
                $depense_USD += $value->montant;
                //$total_depense_mensuel_USD += $value->montant;
            }
            else
            {
                $depense_monnaie_locale += $value->montant;
                //$total_depense_mensuel_monnaie_locale += $value->montant;
            }
        }*/
        //$payement = $comptabilite->getPayementTotalDunMois($mois,$annee)->fetch();
        foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
        {
            if ($value->devise == 'USD')
                $montant_payer_USD = $value->montant;
            else $montant_payer_monnaie_local = $value->montant;
        }
        $month = $tb_mois[$mois].'/'.$annee;
        /*if (!empty($payement['montant']))
            $montant_payer = $payement['montant'];*/
        /*if (!empty($resulta['montant']))
            $depense = $resulta['montant'];*/

            $depense_USD = ($depense_USD == "" ? 0 : $depense_USD);
            $depense_monnaie_locale = ($depense_monnaie_locale == "" ? 0 : $depense_monnaie_locale);

            $depense_mensuel_graph .= "{mois:'".$month."',a:".$depense_USD.",b:".$depense_monnaie_locale."}, ";
        //$extrat = $comptabilite->total_extrat($mois,$annee)->fetch();
        foreach ($comptabilite->total_extrat_dun_mois($mois,$annee) as $value) 
        {
            if ($value->monnaie == 'USD')
                $extrat_USD = $value->montant;
            else $extrat_monnaie_locale = $value->montant;
        }
        /*if (!empty($extrat)) 
        {
            $extrat_month = $extrat['montant'];
        }*/
        //$solde = $montant_payer + $extrat_month - $depense;
        $solde_monnaie_locale = $montant_payer_monnaie_local+$extrat_monnaie_locale-$depense_monnaie_locale;
            $solde_USD = $montant_payer_USD+$extrat_USD-$depense_USD;

        $situation_mensuel_tresorerie_graph .= "{y: '".$month."',a: ".$solde_USD.",b: ".$solde_monnaie_locale."}, ";
        if ($i == 1) 
        {
            $date = date_parse(date("d-m-Y"));
            $mois = $date['month'];
            $annee = $date['year'];

            $depense_USD = 0;
            $depense_monnaie_locale = 0; 
            $montant_payer_USD = 0;
            $montant_payer_monnaie_local = 0;
            $extrat_USD = 0;
            $extrat_monnaie_locale = 0;
            //$resulta = $comptabilite->totalDepenseDunMois($mois,$annee)->fetch();
            foreach ($comptabilite->totalDepenseDunMois($mois,$annee) as $value) 
            {
                if ($value->monnaie == 'USD') 
                    $depense_USD = $value->montant;
                else $depense_monnaie_locale = $value->montant;
            }
            /*foreach ($comptabilite->getMontantDepenseGrandeCaisseDunMois($mois,$annee) as $value) 
            {
                if ($value->monnaie == 'USD') 
                {
                    $depense_USD += $value->montant;
                    //$total_depense_mensuel_USD += $value->montant;
                }
                else
                {
                    $depense_monnaie_locale += $value->montant;
                    //$total_depense_mensuel_monnaie_locale += $value->montant;
                }
            }
            foreach ($comptabilite->getMontantDepenseBanqqueDunMois($mois,$annee) as $value) 
            {
                if ($value->monnaie == 'USD') 
                {
                    $depense_USD += $value->montant;
                    //$total_depense_mensuel_USD += $value->montant;
                }
                else
                {
                    $depense_monnaie_locale += $value->montant;
                    //$total_depense_mensuel_monnaie_locale += $value->montant;
                }
            }
            foreach ($comptabilite->getMontantApprovisionnementDunMois($mois,$annee) as $value) 
            {
                if ($value->monnaie == 'USD') 
                {
                    $depense_USD += $value->montant;
                    //$total_depense_mensuel_USD += $value->montant;
                }
                else
                {
                    $depense_monnaie_locale += $value->montant;
                    //$total_depense_mensuel_monnaie_locale += $value->montant;
                }
            }*/
            foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
            {
                if ($value->devise == 'USD')
                    $montant_payer_USD = $value->montant;
                else $montant_payer_monnaie_local = $value->montant;
            }
            //$payement = $comptabilite->getPayementTotalDunMois($mois,$annee)->fetch();
            
            $month = $tb_mois[$mois].'/'.$annee;
            /*if (!empty($payement['montant']))
                $montant_payer = $payement['montant'];*/
            /*if (!empty($resulta['montant']))
                $depense = $resulta['montant'];*/
                //$depense_mensuel_graph .= "{mois:'".$month."',depense:".$depense."}, ";

            $depense_USD = ($depense_USD == "" ? 0 : $depense_USD);
            $depense_monnaie_locale = ($depense_monnaie_locale == "" ? 0 : $depense_monnaie_locale);
            $depense_mensuel_graph .= "{mois:'".$month."',a:".$depense_USD.",b:".$depense_monnaie_locale."}, ";
            //$extrat = $comptabilite->total_extrat($mois,$annee)->fetch();
            foreach ($comptabilite->total_extrat_dun_mois($mois,$annee) as $value) 
            {
                if ($value->monnaie == 'USD')
                    $extrat_USD = $value->montant;
                else $extrat_monnaie_locale = $value->montant;
            }
            if (!empty($extrat)) 
            {
                $extrat_month = $extrat['montant'];
            }
            //$solde = $montant_payer + $extrat_month - $depense;
            $solde_monnaie_locale = $montant_payer_monnaie_local+$extrat_monnaie_locale-$depense_monnaie_locale;
            $solde_USD = $montant_payer_USD+$extrat_USD-$depense_USD;

            $situation_mensuel_tresorerie_graph .= "{y: '".$month."',a: ".$solde_USD.",b: ".$solde_monnaie_locale."}, ";
        }
    }
    $depense_mensuel_graph = substr($depense_mensuel_graph, 0,-2);
    $situation_mensuel_tresorerie_graph=substr($situation_mensuel_tresorerie_graph, 0,-2);


    // GRAPHE DU SOLDE CLIENT
        $tb_mois= [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
        $date = date_parse(date('Y-m-d'));
        $balance = '';
        $tx_recouvrement =0;
        for ($i=1; $i < $date['month'] +1; $i++) 
        { 
            $solde = $contract->getMontantFactureAnnuel($i,date('Y'))->fetch()['montant'] - $contract->getPaiementAnnuel($i,date('Y'))->fetch()['montant'];
        
            if (empty($solde)) 
               $solde = 0;

            $balance .= "{mois:'".$tb_mois[$i]."',solde:".$solde."},";
            //echo $solde;
        }
            $solde = substr($solde, 0,-2);

    //GRAPHE SOLDE SITUATION CLIENT PAR MOIS

    /*$date = date_parse(date('Y-m-d'));
     $solde_mensuel_graph ="";
    $solde_graphe = '';
    $depense = 0;
    $montant_payer = 0;
    $extrat_month = 0;
    for ($i=1; $i < $date['month'] +1; $i++) 
    { 
        $resulta = $comptabilite->totalDepenseDunMois($i,date('Y'))->fetch();
        $payement = $comptabilite->getPayementTotalDunMois($i,$annee = date('Y'))->fetch();
        if (!empty($payement['montant']))
            $montant_payer = $payement['montant'];
        if (!empty($resulta['montant']))
            $depense = $resulta['montant'];
        $solde_mensuel_graph .= "{mois:'".$tb_mois[$i]."',depense:".$depense."}, ";
        $extrat = $comptabilite->total_extrat($i,date('Y'))->fetch();
        if (!empty($extrat)) 
        {
            $extrat_month = $extrat['montant'];
        }
        $solde = $montant_payer + $extrat_month - $depense;
        $solde_graphe .= "{y:'".$tb_mois[$i]."',a:".$solde."}, ";
    }
        $solde_mensuel_graph = substr($solde_mensuel_graph, 0,-2);
        $solde_graphe = substr($solde_graphe, 0,-2);*/
