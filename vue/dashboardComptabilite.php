<?php
	ob_start(); 
    //$date = date_parse(date('Y-m-d'));
    $tbMonnaie = ['USD','BIF'];
?>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">RAPPORTS SYNTHESE DU MOIS <?php
                echo date("m/Y"); // Affiche la date du jour
                //echo "Il est " . date("H:i:s") ; // Affiche l'heure
                ?></h4>
                <div class="table-responsive">
                    <table class="table color-table nowrap">
                        <thead style="background-color: #ef7f22" class="text-white">
                            <tr>
                                <th>Libelle</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SOLDE MOIS PRECEDENT</td>
                                <td>
                                    <?php
                                    $date = date_parse(date("d-m-Y",strtotime("-1 Months")));
                                    $mois = $date['month'];
                                    $annee = $date['year'];
                                    $payement_precedent_USD = 0;
                                    $payement_precedent_monnaie_local = 0;
                                    $extrat_precedent_USD = 0;
                                    $extrat_precedent_monnaie_locale = 0;
                                    $depense_precedente_USD = 0;
                                    $depense_precedente_monnaie_locale = 0;

                                    foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->devise == 'USD')
                                        {
                                            $payement_precedent_USD = $value->montant;
                                            //$payementTotalMensuel_USD += $value->montant;
                                        }
                                        else
                                        {
                                            $payement_precedent_monnaie_local = $value->montant;
                                            //$payementTotalMensuel_monnaie_locale += $value->montant;
                                        }
                                    }
                                    foreach ($comptabilite->total_extrat_dun_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->monnaie == 'USD')
                                        {
                                            $extrat_precedent_USD = $value->montant;
                                            //$total_extrat_mensuel_USD += $value->montant;
                                        }
                                        else
                                        {
                                            $extrat_precedent_monnaie_locale = $value->montant;
                                            //$total_extrat_mensuel_monnaie_local += $value->montant;
                                        }
                                    }
                                    /*foreach ($comptabilite->totalDepenseDunMois($mois,$annee) as $value) 
                                    {
                                        if ($value->monnaie == 'USD') 
                                        {
                                            $depense_precedente_USD = $value->montant;
                                            //$total_depense_mensuel_USD += $value->montant;
                                        }
                                        else
                                        {
                                            $depense_precedente_monnaie_locale = $value->montant;
                                            //$total_depense_mensuel_monnaie_locale += $value->montant;
                                        }
                                    }*/
                                    foreach ($comptabilite->getMontantDepenseGrandeCaisseDunMois($mois,$annee) as $value) 
                                    {
                                        if ($value->monnaie == 'USD') 
                                        {
                                            $depense_precedente_USD += $value->montant;
                                            //$total_depense_mensuel_USD += $value->montant;
                                        }
                                        else
                                        {
                                            $depense_precedente_monnaie_locale += $value->montant;
                                            //$total_depense_mensuel_monnaie_locale += $value->montant;
                                        }
                                    }
                                    foreach ($comptabilite->getMontantDepenseBanqqueDunMois($mois,$annee) as $value) 
                                    {
                                        if ($value->monnaie == 'USD') 
                                        {
                                            $depense_precedente_USD += $value->montant;
                                            //$total_depense_mensuel_USD += $value->montant;
                                        }
                                        else
                                        {
                                            $depense_precedente_monnaie_locale += $value->montant;
                                            //$total_depense_mensuel_monnaie_locale += $value->montant;
                                        }
                                    }
                                    foreach ($comptabilite->getMontantApprovisionnementDunMois($mois,$annee) as $value) 
                                    {
                                        if ($value->monnaie == 'USD') 
                                        {
                                            $depense_precedente_USD += $value->montant;
                                            //$total_depense_mensuel_USD += $value->montant;
                                        }
                                        else
                                        {
                                            $depense_precedente_monnaie_locale += $value->montant;
                                            //$total_depense_mensuel_monnaie_locale += $value->montant;
                                        }
                                    }
                                    $solde_precedent_USD = $payement_precedent_USD + $extrat_precedent_USD - $depense_precedente_USD;
                                    echo number_format($solde_precedent_USD).'_'.$tbMonnaie[0];
                                    $solde_precedent_monnaie_locale = $payement_precedent_monnaie_local + $extrat_precedent_monnaie_locale - $depense_precedente_monnaie_locale;
                                    echo ' '.number_format($solde_precedent_monnaie_locale).'_'.$tbMonnaie[1];
                                    ?>
                                </td>
                            </tr>
                            <!--<tr>
                                <td>SOLDE CAUTION</td>
                                <td> 
                                    <php
                                    $valeur = $contract->cautionTotaleDansUnMois($date['month'],$date['year'])->fetch();
                                    if(!empty($valeur))
                                    {
                                        echo number_format($valeur['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";
                                    ?>
                                </td>
                            </tr>-->
                            <!--<tr>
                                <td>SUR PLUS</td>
                                <td>
                                    <php
                                    $extrat = $comptabilite->total_extrat($date['month'],$annee = date('Y'))->fetch();
                                    if (!empty($extrat)) 
                                    {
                                        echo number_format($extrat['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";
                                    ?>
                                </td>
                            </tr>-->
                            <tr>
                                <td>FACTURE DU MOIS</td>
                                <td>
                                    <?php 
                                    $date = date_parse(date("Y-m-d"));
                                    $mois = $date['month'];
                                    $annee = $date['year'];
                                    $montant_facture_USD = 0;
                                    $montant_facture_monnaie_locale = 0;
                                    foreach ($contract->getfacture_total_dun_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->monnaie == 'USD') 
                                        {
                                            $montant_facture_USD = $value->montant;
                                            //$monnaie_facture_USD = $value->monnaie;
                                        }
                                        else
                                        {
                                            $montant_facture_monnaie_locale = $value->montant;
                                            //$monnaie_facture_locale = $value->monnaie;
                                        }
                                    }
                                    echo number_format(round($montant_facture_USD)).'_'.$tbMonnaie[0].' '.number_format(round($montant_facture_monnaie_locale)).'_'.$tbMonnaie[1];
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <!--<td>FACTURE PAYEE</td>-->
                                <td>MONTANT RECU</td>
                                <td>
                                    <?php
                                    $date = date_parse(date("Y-m-d"));
                                    $mois = $date['month'];
                                    $annee = $date['year'];
                                    /*$montant_facture_payee_USD = 0;
                                    $montant_facture_payee_monnaie_locale = 0;
                                    foreach ($contract->getmontant_facture_payee_dun_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->devise == 'USD') 
                                        {
                                            $montant_facture_payee_USD += $value->montant;
                                        }
                                        else
                                        {
                                            $montant_facture_payee_monnaie_locale += $value->montant;
                                        }
                                    }
                                    echo $montant_facture_payee_USD.'_'.$tbMonnaie[0].' '.$montant_facture_payee_monnaie_locale.'_'.$tbMonnaie[1];*/
                                    $montant_payer_USD = 0;
                                    $montant_payer_monnaie_local = 0;
                                    foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->devise == 'USD')
                                            $montant_payer_USD = $value->montant;
                                        else $montant_payer_monnaie_local = $value->montant;
                                    }
                                    echo number_format($montant_payer_USD).' '.$tbMonnaie[0].' '.number_format($montant_payer_monnaie_local).' '.$tbMonnaie[1];
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td hidden="">DEROGATIONS PRECEDENTES</td>
                                <td hidden="">
                                    <?php
                                    // derogation mois passer
                                    $date = date_parse(date("d-m-Y",strtotime("-1 Months")));
                                    $mois = $date['month'];
                                    $annee = $date['year'];
                                    /*$res = $contract->getMontantFactureEnDerogationDunMois($mois_derogation,$annee_derogation)->fetch();
                                    if (!empty($res)) 
                                    {
                                        echo number_format($res['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";*/
                                    $solde_en_derogation = 0;
                                    foreach ($contract->getClientEnDerrogationCreerAunMois($mois,$annee) as $value) 
                                    {
                                        $solde_en_derogation += $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
                                    }
                                    echo number_format($solde_en_derogation,2).'_USD';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td hidden="">DEROGATIONS DU MOIS</td>
                                <td hidden="">
                                    <?php
                                    // derogation mois courant
                                    /*$res = $contract->getMontantFactureEnDerogationDunMois($date['month'],$date['year'])->fetch();
                                    if (!empty($res)) 
                                    {
                                        echo number_format($res['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";*/
                                    $date = date_parse(date("Y-m-d"));
                                    $mois = $date['month'];
                                    $annee = $date['year'];

                                    $solde_en_derogation = 0;
                                    foreach ($contract->getClientEnDerrogationCreerAunMois($mois,$annee) as $value) 
                                    {
                                        $solde_en_derogation += $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
                                    }
                                    echo number_format($solde_en_derogation,2).'_USD';
                                    ?>
                                </td>
                            </tr>
                            <tr hidden="">
                                <td>COUPURE DU MOIS </td>
                                <td>
                                    <?php
                                    /*$res = $contract->getMontantCoupureDuMois($date['month'],$date['year']);
                                    echo number_format($res,2).'_USD';*/
                                    $solde_en_coupure = 0;
                                    foreach ($contract->getClientEnCoupureCreerAunMois($mois,$annee) as $value) 
                                    {
                                        $solde_en_coupure += $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
                                    }
                                    echo number_format($solde_en_coupure,2).'_USD';
                                    ?>
                                </td>
                            </tr>
                            <!--<tr>
                                <td>SOLDE CAUTION</td>
                                <td> 
                                    <php
                                    $valeur = $contract->cautionTotaleDansUnMois($date['month'],$date['year'])->fetch();
                                    if(!empty($valeur))
                                    {
                                        echo number_format($valeur['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";
                                    ?>
                                </td>
                            </tr>-->
                            <!--<tr>
                                <td>SUR PLUS</td>
                                <td>
                                    <php
                                    $extrat = $comptabilite->total_extrat($date['month'],$annee = date('Y'))->fetch();
                                    if (!empty($extrat)) 
                                    {
                                        echo number_format($extrat['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";
                                    ?>
                                </td>
                            </tr>-->
                            <tr>
                                <td>TOTAL ENTREE</td>
                                <td>
                                    <?php
                                    $montant_recu_USD = 0;
                                    $montant_recu_monnaie_local = 0;
                                    foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->devise == 'USD')
                                        {
                                            $montant_recu_USD = $value->montant;
                                        }
                                        else
                                        {
                                            $montant_recu_monnaie_local = $value->montant;
                                        }
                                    }
                                    $extrat_USD = 0;
                                    $extrat_monnaie_locale = 0;
                                    foreach ($comptabilite->total_extrat_dun_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->monnaie == 'USD')
                                        {
                                            $extrat_USD = $value->montant;
                                        }
                                        else
                                        {
                                            $extrat_monnaie_locale = $value->montant;
                                        }
                                    }
                                    $entree_mois_courant_USD = $montant_recu_USD + $extrat_USD;
                                    $entree_mois_courant_monnaie_locale = $montant_recu_monnaie_local + $extrat_monnaie_locale;   
                                        echo number_format($entree_mois_courant_USD).'_'.$tbMonnaie[0].' '.number_format($entree_mois_courant_monnaie_locale).'_'.$tbMonnaie[1];
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>TOTAL DEPENSE</td>
                                <td>
                                <?php
                                $depense_mois_courant_USD = 0;
                                $depense_mois_courant_monnaie_locale = 0;
                                /*foreach ($comptabilite->totalDepenseDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_mois_courant_USD  = $value->montant;
                                    }
                                    else
                                    {
                                        $depense_mois_courant_monnaie_locale = $value->montant;
                                    }
                                }*/
                                foreach ($comptabilite->getMontantDepenseGrandeCaisseDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_mois_courant_USD+= $value->montant;
                                        //$total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_mois_courant_monnaie_locale += $value->montant;
                                        //$total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                foreach ($comptabilite->getMontantDepenseBanqqueDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_mois_courant_USD+= $value->montant;
                                        //$total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_mois_courant_monnaie_locale += $value->montant;
                                        //$total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                foreach ($comptabilite->getMontantApprovisionnementDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_mois_courant_USD+= $value->montant;
                                        //$total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_mois_courant_monnaie_locale += $value->montant;
                                        //$total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                echo $depense_mois_courant_USD.'_'.$tbMonnaie[0].' '.$depense_mois_courant_monnaie_locale.'_'.$tbMonnaie[1];
                                ?>
                                </td>
                            </tr>
                            <tr>
                            <td>RESULTAT</td>
                            <td> 
                                <?php
                                $resultat_mois_courant_USD = $entree_mois_courant_USD - $depense_mois_courant_USD;
                                $resultat_mois_courant_monnaie_locale = $entree_mois_courant_monnaie_locale - $depense_mois_courant_monnaie_locale;
                                if ($resultat_mois_courant_USD <= 0) 
                                {
                                ?>
                                    <span class="label label-danger">
                                        <h5><?php echo number_format($resultat_mois_courant_USD).'_'.$tbMonnaie[0]?>
                                        </h5>
                                    </span>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <span class="label label-success">
                                        <h5><?php echo number_format($resultat_mois_courant_USD).'_'.$tbMonnaie[0]?></h5>
                                    </span>
                                <?php
                                }
                                if ($resultat_mois_courant_monnaie_locale <= 0) 
                                {
                                ?>
                                    <span class="label label-danger">
                                        <h5><?php echo number_format($resultat_mois_courant_monnaie_locale).'_'.$tbMonnaie[1]?>
                                        </h5>
                                    </span>
                                <?php
                                }
                                else
                                {
                                ?>
                                    <span class="label label-success">
                                        <h5><?php echo number_format($resultat_mois_courant_monnaie_locale).'_'.$tbMonnaie[1]?></h5>
                                    </span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Factures et montant recus</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead style="background-color: #ef7f22" class="text-white">
                            <tr>
                                <th>Mois</th>
                                <th>Facture</th>
                                <th>Montant recu</th>
                                <th hidden="">Solde</th>
                                <th hidden="">Tx recouvrement</th>
                            </tr>
                        </thead>
                        <tbody id="rep">
                        <?php                        
                            $montant_facture_USD = 0;
                            $montant_facture_monnaie_locale = 0;
                            $montant_facture_USD = $tbMonnaie[0];
                            $monnaie_facture_locale = $tbMonnaie[1];

                            $montant_recu_USD = 0;
                            $montant_recu_monnaie_local = 0;
                            $monnaie_recu_USD = $tbMonnaie[0];
                            $monnaie_recu_locale = $tbMonnaie[1];

                            $tb_mois= [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
                            for ($i=6; $i > 0; $i--) 
                            {
                                $date = date_parse(date("d-m-Y",strtotime(-$i." Months")));
                                $mois = $date['month'];
                                $annee = $date['year'];
                            ?>
                                <tr>
                                <td>
                                    <?php 
                                    echo $tb_mois[$mois].'/'.$annee;
                                    ?>   
                                </td> 
                                <td><?php 
                                foreach ($contract->getfacture_total_dun_mois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $montant_facture_USD = $value->montant;
                                        $monnaie_facture_USD = $value->monnaie;
                                    }
                                    else
                                    {
                                        $montant_facture_monnaie_locale = $value->montant;
                                        $monnaie_facture_locale = $value->monnaie;
                                    }
                                }
                                echo round($montant_facture_USD).'_'.$monnaie_facture_USD.' '.round($montant_facture_monnaie_locale).'_'.$monnaie_facture_locale;
                                ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->devise == 'USD')
                                        {
                                            $montant_recu_USD = $value->montant;
                                            $monnaie_recu_USD = $value->devise;
                                        }
                                        else
                                        {
                                            $montant_recu_monnaie_local = $value->montant;
                                            $monnaie_recu_locale = $value->devise;
                                        }
                                    }
                                    echo round($montant_recu_USD).'_'.$monnaie_recu_USD.' '.round($montant_recu_monnaie_local).'_'.$monnaie_recu_locale;
                                    //$contract->getmontant_facture_payee($i,$annee = date('Y'));
                                //echo number_format($resultapaye,2).'_USD';
                                ?>
                                    
                                </td>
                                <!--td><php echo $solde =number_format($resultapaye - $resulta,2).'_USD';?></td>

                                <td "><php
                                if ($resultapaye AND $resulta > 0)
                                {
                                   $pourcentage = $resultapaye * 100 / $resulta;

                                $tx_recouvrement =round($pourcentage,2);

                                echo $tx_recouvrement.'%'; 
                                }
                                else
                                    echo '0 %';
                                ?>   
                                </td-->
                            </tr>
                            <?php
                                if ($i == 1) 
                                {
                                    $date = date_parse(date("d-m-Y"));
                                    $mois = $date['month'];
                                    $annee = $date['year'];

                                    $montant_facture_USD = 0;
                                    $montant_facture_monnaie_locale = 0;
                                    $montant_recu_USD = 0;
                                    $montant_recu_monnaie_local = 0;
                            ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            echo $tb_mois[$mois].'/'.$annee;
                                            ?>   
                                        </td> 
                                        <td><?php 
                                        foreach ($contract->getfacture_total_dun_mois($mois,$annee) as $value) 
                                        {
                                            if ($value->monnaie == 'USD') 
                                            {
                                                $montant_facture_USD = $value->montant;
                                                $monnaie_facture_USD = $value->monnaie;
                                            }
                                            else
                                            {
                                                $montant_facture_monnaie_locale = $value->montant;
                                                $monnaie_facture_locale = $value->monnaie;
                                            }
                                        }
                                        echo round($montant_facture_USD).'_'.$monnaie_facture_USD.' '.round($montant_facture_monnaie_locale).'_'.$monnaie_facture_locale;
                                        ?>
                                        </td>
                                        <td >
                                            <?php
                                            foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
                                            {
                                                if ($value->devise == 'USD')
                                                {
                                                    $montant_recu_USD = $value->montant;
                                                    $monnaie_recu_USD = $value->devise;
                                                }
                                                else
                                                {
                                                    $montant_recu_monnaie_local = $value->montant;
                                                    $monnaie_recu_locale = $value->devise;
                                                }
                                            }
                                            echo round($montant_recu_USD).'_'.$monnaie_recu_USD.' '.round($montant_recu_monnaie_local).'_'.$monnaie_recu_locale;
                                        ?>
                                        </td>
                                        <!--td><php echo $solde =number_format($resultapaye - $resulta,2).'_USD';?></td>

                                        <td "><php
                                        if ($resultapaye AND $resulta > 0)
                                        {
                                           $pourcentage = $resultapaye * 100 / $resulta;

                                        $tx_recouvrement =round($pourcentage,2);

                                        echo $tx_recouvrement.'%'; 
                                        }
                                        else
                                            echo '0 %';
                                        ?>   
                                        </td-->
                                    </tr>
                            <?php
                                }
                            }
                            $date = date_parse(date("d-m-Y",strtotime("+1 Months")));
                            $mois = $date['month'];
                            $annee = $date['year'];

                            $montant_facture_USD = 0;
                            $montant_facture_monnaie_locale = 0;
                            $montant_facture_USD = $tbMonnaie[0];
                            $monnaie_facture_locale = $tbMonnaie[1];

                            $montant_recu_USD = 0;
                            $montant_recu_monnaie_local = 0;
                            $monnaie_recu_USD = $tbMonnaie[0];
                            $monnaie_recu_locale = $tbMonnaie[1];
                            if ($contract->verifierUnMoisDebutExiste($mois,$annee)) 
                            {
                            ?>
                                <tr>
                                <td>
                                    <?php 
                                    echo ucfirst($tb_mois[$mois].'/'.$annee);
                                    ?>   
                                </td>
                                <td><?php 
                                foreach ($contract->getfacture_total_dun_mois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $montant_facture_USD = $value->montant;
                                        $monnaie_facture_USD = $value->monnaie;
                                    }
                                    else
                                    {
                                        $montant_facture_monnaie_locale = $value->montant;
                                        $monnaie_facture_locale = $value->monnaie;
                                    }
                                }
                                echo round($montant_facture_USD).'_'.$monnaie_facture_USD.' '.round($montant_facture_monnaie_locale).'_'.$monnaie_facture_locale;
                                ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->devise == 'USD')
                                        {
                                            $montant_recu_USD = $value->montant;
                                            $monnaie_recu_USD = $value->devise;
                                        }
                                        else
                                        {
                                            $montant_recu_monnaie_local = $value->montant;
                                            $monnaie_recu_locale = $value->devise;
                                        }
                                    }
                                    echo round($montant_recu_USD).'_'.$monnaie_recu_USD.' '.round($montant_recu_monnaie_local).'_'.$monnaie_recu_locale;
                                ?>
                                </td>
                                <td hidden=""><?php //echo $solde =number_format($resulta - $resultapaye,2).'_USD';?></td>

                                <td hidden=""><?php/*
                                if ($resultapaye AND $resulta > 0)
                                {
                                   $pourcentage = $resultapaye * 100 / $resulta;

                                $tx_recouvrement =round($pourcentage,2);

                                echo $tx_recouvrement.'%'; 
                                }
                                else
                                    echo '0 %';*/
                                ?>   
                                </td>
                            </tr>
                        <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Recettes et Depense</h6>
                <div class="table-responsive">
                    <table class="table color-table">
                        <thead style="background-color: #ef7f22" class="text-white">
                            <tr>
                                <th class="font-bold">Mois</th>
                                <th class="font-bold">Payement</th>
                                <th class="font-bold">Extra USD</th>
                                <th class="font-bold">Depense</th>
                                <th class="font-bold">Solde</th>
                            </tr>
                        </thead>
                        <tbody id="rep">
                        <?php

                            $tb_mois= [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
                            $payementTotalMensuel_USD = 0;
                            $payementTotalMensuel_monnaie_locale = 0;
                            $total_extrat_mensuel_USD = 0;
                            $total_extrat_mensuel_monnaie_local = 0;
                            $total_depense_mensuel_USD = 0;
                            $total_depense_mensuel_monnaie_locale = 0;
                            $solde_total_mensuel_USD = 0;
                            $solde_total_mensuel_monnaie_locale = 0;

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
                            ?>
                                <tr>
                                <td>
                                    <?php 
                                    echo ucfirst($tb_mois[$mois]);
                                    ?>   
                                </td>
                                <td><?php 
                                foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
                                {
                                    if ($value->devise == 'USD')
                                    {
                                        $montant_payer_USD = $value->montant;
                                        $payementTotalMensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $montant_payer_monnaie_local = $value->montant;
                                        $payementTotalMensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                echo number_format($montant_payer_USD,2).' '.$tbMonnaie[0].' '.number_format($montant_payer_monnaie_local).' '.$tbMonnaie[1];
                                /*if (!empty($resulta))
                                    echo number_format($resulta['montant'],2).'_USD';*/
                                ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($comptabilite->total_extrat_dun_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->monnaie == 'USD')
                                        {
                                            $extrat_USD = $value->montant;
                                            $total_extrat_mensuel_USD += $value->montant;
                                        }
                                        else
                                        {
                                            $extrat_monnaie_locale = $value->montant;
                                            $total_extrat_mensuel_monnaie_local += $value->montant;
                                        }
                                    }
                                    echo $extrat_USD.'_'.$tbMonnaie[0].' '.$extrat_monnaie_locale.'_'.$tbMonnaie[1];
                                    /*if (!empty($extrat)) 
                                    {
                                        echo number_format($extrat['montant'],2).'_USD';
                                        $total_extrat_mensuel +=$extrat['montant'];
                                    }
                                    else echo "0.00_USD";*/
                                    ?>
                                </td>
                                <td><?php
                                /*foreach ($comptabilite->totalDepenseDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_USD = $value->montant;
                                        $total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_monnaie_locale = $value->montant;
                                        $total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }*/

                                foreach ($comptabilite->getMontantDepenseGrandeCaisseDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_USD += $value->montant;
                                        $total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_monnaie_locale += $value->montant;
                                        $total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                foreach ($comptabilite->getMontantDepenseBanqqueDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_USD += $value->montant;
                                        $total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_monnaie_locale += $value->montant;
                                        $total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                foreach ($comptabilite->getMontantApprovisionnementDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_USD += $value->montant;
                                        $total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_monnaie_locale += $value->montant;
                                        $total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                echo $depense_USD.'_'.$tbMonnaie[0].' '.$depense_monnaie_locale.'_'.$tbMonnaie[1];
                                /*if (!empty($depense['montant']))
                                {
                                    $total_depense_mensuel +=$depense['montant'];
                                    echo $depense['montant'].' USD';
                                }
                                else
                                    echo '0.00 USD';*/
                                ?>
                                </td>
                                <td>
                                    <?php $solde_USD = $montant_payer_USD + $extrat_USD - $depense_USD;

                                    $solde_monnaie_locale = $montant_payer_monnaie_local + $extrat_monnaie_locale - $depense_monnaie_locale;

                                    $solde_total_mensuel_USD += $solde_USD;
                                    $solde_total_mensuel_monnaie_locale += $solde_monnaie_locale;
                                    echo $solde_USD.'_'.$tbMonnaie[0].' '.$solde_monnaie_locale.'_'.$tbMonnaie[1];
                                    ?>
                                </td>
                            </tr>
                            <?php
                                if ($i == 1) 
                                {
                                    $date = date_parse(date("Y-m-d"));
                                    $mois = $date['month'];
                                    $annee = $date['year'];

                                    $depense_USD = 0;
                                    $depense_monnaie_locale = 0;
                                    $montant_payer_USD = 0;
                                    $montant_payer_monnaie_local = 0;
                                    $extrat_USD = 0;
                                    $extrat_monnaie_locale = 0;
                                    $solde_USD = 0;
                                    $solde_monnaie_locale = 0; 
                                        ?>
                                    <tr>
                                <td>
                                    <?php 
                                    echo ucfirst($tb_mois[$mois]);
                                    ?>   
                                </td>
                                <td><?php 
                                foreach ($contract->getmontant_payer_dans_un_mois($mois,$annee) as $value) 
                                {
                                    if ($value->devise == 'USD')
                                    {
                                        $montant_payer_USD = $value->montant;
                                        $payementTotalMensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $montant_recu_monnaie_local = $value->montant;
                                        $payementTotalMensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                echo number_format($montant_payer_USD,2).' '.$tbMonnaie[0].' '.$montant_payer_monnaie_local.' '.$tbMonnaie[1];
                                /*if (!empty($resulta))
                                    echo number_format($resulta['montant'],2).'_USD';*/
                                ?>
                                </td>
                                <td>
                                    <?php
                                    foreach ($comptabilite->total_extrat_dun_mois($mois,$annee) as $value) 
                                    {
                                        if ($value->monnaie == 'USD')
                                        {
                                            $extrat_USD = $value->montant;
                                            $total_extrat_mensuel_USD += $value->montant;
                                        }
                                        else
                                        {
                                            $extrat_monnaie_locale = $value->montant;
                                            $total_extrat_mensuel_monnaie_local += $value->montant;
                                        }
                                    }
                                    
                                    echo $extrat_USD.'_'.$tbMonnaie[0].' '.$extrat_monnaie_locale.'_'.$tbMonnaie[1];
                                    /*if (!empty($extrat)) 
                                    {
                                        echo number_format($extrat['montant'],2).'_USD';
                                        $total_extrat_mensuel +=$extrat['montant'];
                                    }
                                    else echo "0.00_USD";*/
                                    ?>
                                </td>
                                <td><?php
                                foreach ($comptabilite->getMontantDepenseGrandeCaisseDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_USD += $value->montant;
                                        $total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_monnaie_locale += $value->montant;
                                        $total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                foreach ($comptabilite->getMontantDepenseBanqqueDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_USD += $value->montant;
                                        $total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_monnaie_locale += $value->montant;
                                        $total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                foreach ($comptabilite->getMontantApprovisionnementDunMois($mois,$annee) as $value) 
                                {
                                    if ($value->monnaie == 'USD') 
                                    {
                                        $depense_USD += $value->montant;
                                        $total_depense_mensuel_USD += $value->montant;
                                    }
                                    else
                                    {
                                        $depense_monnaie_locale += $value->montant;
                                        $total_depense_mensuel_monnaie_locale += $value->montant;
                                    }
                                }
                                echo $depense_USD.'_'.$tbMonnaie[0].' '.$depense_monnaie_locale.'_'.$tbMonnaie[1];
                                /*if (!empty($depense['montant']))
                                {
                                    $total_depense_mensuel +=$depense['montant'];
                                    echo $depense['montant'].' USD';
                                }
                                else
                                    echo '0.00 USD';*/
                                ?>
                                </td>
                                <td>
                                    <?php $solde_USD = $montant_payer_USD + $extrat_USD - $depense_USD;

                                    $solde_monnaie_locale = $montant_payer_monnaie_local + $extrat_monnaie_locale - $depense_monnaie_locale;

                                    $solde_total_mensuel_USD += $solde_USD;
                                    $solde_total_mensuel_monnaie_locale += $solde_monnaie_locale;
                                    echo $solde_USD.'_'.$tbMonnaie[0].' '.$solde_monnaie_locale.'_'.$tbMonnaie[1];
                                    ?>
                                </td>
                            </tr>
                                <?php
                                }// IF $i == 1
                            }// Foreach 
                            ?>
                            <tr style="background-color: #ef7f22" class="text-white">
                                <td>Total</td>
                                <td>
                                     <?php
                                    /*$total_pyts = $comptabilite->total_payment()->fetch();
                                    if (!empty($total_pyts)) 
                                    {
                                        echo number_format($total_pyts['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";*/
                                    echo number_format($payementTotalMensuel_USD,2).'_'.$tbMonnaie[0].' '.$payementTotalMensuel_monnaie_locale.'_'.$tbMonnaie[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo number_format($total_extrat_mensuel_USD,2).'_'.$tbMonnaie[0].' '.$total_extrat_mensuel_monnaie_local.'_'.$tbMonnaie[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo number_format($total_depense_mensuel_USD,2).'_'.$tbMonnaie[0].' '.$total_depense_mensuel_monnaie_locale.'_'.$tbMonnaie[1];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo number_format($solde_total_mensuel_USD,2).'_'.$tbMonnaie[0].' '.$solde_total_mensuel_monnaie_locale;
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">SITUATION MENSUEL DE LA TRESORERIE</h4>
                <ul class="list-inline text-right">
                    <li>
                        <h5><i class="fa fa-circle m-r-5 text-inverse"></i>USD</h5>
                    </li>
                    <li>
                        <h5><i class="fa fa-circle m-r-5 text-info"></i>BIF</h5>
                    </li>
                </ul>
                <div id="situation-mensuel-tresorerie"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">DEPENSE PAR MOIS</h4>
                <div id="depense-mensuel"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">BANQUE ET CAISSE</h4>
                <div class="table-responsive">
                    <table class="table color-table nowrap">
                        <thead style="background-color: #ef7f22" class="text-white">
                            <tr>
                                <th>Banque</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resultat_USD =0;
                            $resultat_monnaie_locale = 0;
                            foreach ($comptabilite->getBanqqueActive() as $value) 
                            {
                                if ($value->monnaie == 'USD')
                                    $resultat_USD += $value->montant;
                                else $resultat_monnaie_locale += $value->montant;
                            ?>
                            <tr>
                                <td><?=$value->nom?></td>
                                <td><?php echo number_format($value->montant).' '.$value->monnaie?></td>
                            </tr>
                            <?php
                            }
                            foreach ($comptabilite->getGrandeCaisses() as $value) 
                            {
                                if ($value->devise == 'USD')
                                    $resultat_USD += $value->montantCaisse;
                                else $resultat_monnaie_locale += $value->montantCaisse;
                            ?>
                                <tr>
                                    <td><?=$value->nomCaisse?></td>
                                    <td><?=number_format($value->montantCaisse).' '.$value->devise?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr class="font-bold">
                                <td>Total General</td>
                                <td>
                                    <?php echo number_format($resultat_USD).' '.$tbMonnaie[0].' '.number_format($resultat_monnaie_locale).' '.$tbMonnaie[1];?> 
                                </td>
                            </tr> 
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" hidden="">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Solde mensuel des clients</h4>
                <div id="solde-mensuel"></div>
            </div>
        </div>
    </div>
</div>
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>