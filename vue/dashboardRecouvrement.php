<?php
    ob_start();
    $date = date_parse(date('Y-m-d'));
    $tbMonnaie = ['USD','BIF'];
?>
<input type="text" id="WEBROOT" value="<?=WEBROOT?>" hidden>
<div class="card">
    <div class="card-body">
        <h6 class="card-title">Client</h6>
        <div class="row">
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-info text-center">
                        <h3 class="font-light text-white"><?php
                        $nbclient = 0;
                        if ($data = $client->getNewClients($date['month'],$date['year'])->fetch()) 
                        {
                            $nbclient = $data['nbclient'];
                        ?>
                        <form class="form-horizontal p-t-0" action="<?=WEBROOT?>nouveauclient" method="post" id="form_nouveau_client">
                      <button type="button" class="btn btn-sm btn-rounded btn-info" class="font-light text-white" onclick="form_nouveau_client()">Nouveau client &nbsp;<?= $data['nbclient']?></button>
                        <input type="text" id="mois" name="mois" value="<?php echo date('m');?>" hidden>
                        <input type="text" id="annee" name="annee" value="<?php echo date('Y');?>" hidden>
                    </form>
                        <?php
                        }
                        ?></h3>
                    </div> 
                </div>
            </div>
             <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-warning text-center">
                        <h3 class="font-light text-white">
                        <button type="button" class="btn btn-sm btn-rounded btn-warning"><a href="<?=WEBROOT;?>print_client_derogation" class="font-light text-white">Client en derogation </a><?=$client->totalClientEnDerogation()->nb?></button></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-primary text-center">
                        <h3 class="font-light text-white">
                        <button type="button" class="btn btn-sm btn-rounded btn-primary"><a href="<?=WEBROOT;?>printclient_coupure" class="font-light text-white">Client en coupure </a><?=$client->totalClientEnCoupure()->nb?></button>
                           </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-megna text-center">
                        <h3 class="font-light text-white">
                            <button type="button" class="btn btn-sm btn-rounded box bg-megna"><a href="<?=WEBROOT;?>client_delinquant" class="font-light text-white">Client avec dette <?= nbClientSoldeSupZero()?></a></button></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-success text-center">
                        <h3 class="font-light text-white">
                        <button type="button" class="btn btn-sm btn-rounded btn-success"><a href="<?=WEBROOT;?>client_sansdette" class="font-light text-white">Client sans dette </a><?= nbClientSoldeInfOuEgalZero()?></button></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-info text-center">
                        <h3 class="font-light text-white">
                            <?php $n = nbClientSoldeNegatif();?>
                        <button type="button" class="btn btn-sm btn-rounded btn-info" onclick="clientSoldeNegatif('<?=$n?>',$('#WEBROOT').val())">Client avec solde negatif <?= $n?></button></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-danger text-center">
                        <h3 class="font-light text-white">
                            <?php $k = nbClientPartiAvecDette();?>
                        <button type="button" class="btn btn-sm btn-rounded btn-danger" onclick="ClientPartiAvecDette('<?=$k?>',$('#WEBROOT').val())">Client parti avec dette <?= $k?></button></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-success text-center">
                        <h3 class="font-light text-white">
                            <?php $l = nbClientPartiSansDette();?>
                        <button type="button" class="btn btn-sm btn-rounded btn-success" onclick="ClientPartiSansDette('<?=$l?>',$('#WEBROOT').val())">Client parti sans dette <?= $l?></button></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-megna text-center">
                        <h3 class="font-light text-white">
                            <button type="button" class="btn btn-sm btn-rounded box bg-megna"><a href="<?=WEBROOT;?>client_actif" class="font-light text-white">Client actif <?= nbClientActif()?></a></button></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-warning text-center">
                        <h3 class="font-light text-white">
                        <button type="button" class="btn btn-sm btn-rounded btn-warning"><a href="<?=WEBROOT;?>print_client_en_pause" class="font-light text-white">Client en pause </a><?=$client->nbClientEnPause()?></button></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<div class="card">
    <div class="card-body">
        <h6 class="card-title">AUTRE DETAIL DES CLIENTS</h6>
        <div class="row m-t-0">
            <div class="col-md-4 col-lg-4 col-xlg-4">
                <div class="card">
                    <div class="box bg-info text-center">
                        <h7 class="font-light text-white"><button type="button" class="btn btn-sm btn-rounded btn-info"><?php $data =$client->client_sans_contrat()->fetch();echo $data['nb'];?><a href="<?=WEBROOT;?>print_clientSanscontrat" class="font-light text-white">  CLIENT SANS CONTRAT</a></button></h7>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 col-lg-4 col-xlg-4">
                <div class="card">
                    <div class="box bg-primary text-center">
                        <h7 class="font-light text-white"><button type="button" class="btn btn-sm btn-rounded btn-primary"><!--?php $data =$client->totalclientsans_facture()->fetch();echo $data['nb']?--><a href="<?=WEBROOT;?>print_clientSans_facture" class="font-light text-white">   CLIENT SANS FACTURE</a></button></h7>
                    </div>
                </div>
            </div>

             <div class="col-md-4 col-lg-4 col-xlg-4">
                <div class="card">
                    <div class="box bg-success text-center">
                        <h7 class="font-light text-white"><button type="button" class="btn btn-sm btn-rounded btn-success"><?php $data =$comptabilite->paiement_jour()->fetch();echo $data['nb'];?><a href="<?=WEBROOT;?>paiement_journalier" class="font-light text-white">   PAIEMENT DU JOUR</a></button></h7>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!--div class="col-md-4 col-lg-4 col-xlg-4">
                
                <div class="card">
                    <div class="box bg-success text-center">
                        <h7 class="font-light text-white"><a href="<    WEBROOT;?>paiement_journalier" class="font-light text-white"><button type="button" class="btn btn-sm btn-rounded btn-success">  PAIEMENT DU JOUR</a></button></h7>
                    </div>
                </div>
            </div-->
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h6 class="card-title">Factures du <?=date('m-Y')?></h6>
        <div class="row">
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-info text-center">
                        <h3 class="m-b-0 text-white">
                        <?php
                        $montant_facture_USD = 0;
                        $montant_facture_monnaie_locale = 0;
                        foreach ($contract->getfacture_total_dun_mois($date['month'],$date['year']) as $value) 
                        {
                            if ($value->monnaie == 'USD') 
                            {
                                $montant_facture_USD = $value->montant;
                            }
                            else
                            {
                                $montant_facture_monnaie_locale = $value->montant;
                            }
                        }
                        echo $montant_facture_USD.'_'.$tbMonnaie[0].' '.$montant_facture_monnaie_locale.'_'.$tbMonnaie[1];
                        ?>
                        </h3>
                        <h5 class="font-bold m-b-0">Total</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-warning text-center">
                        <h3 class="m-b-0 text-white">
                        <?php
                            $res = $contract->getMontantFactureEnDerogationDunMois($date['month'],$date['year'])->fetch();
                            if (!empty($res)) 
                            {
                                echo number_format($res['montant'],2).'_USD';
                            }
                            else echo "0.00_USD";
                        ?>
                        </h3>
                        <h5 class="font-bold m-b-0">Derogation</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-primary text-center">
                        <h3 class="m-b-0 text-white">
                        <?php
                            $res = $contract->getMontantCoupureDuMois($date['month'],$date['year']);
                            echo number_format($res,2).'_USD';
                        ?>
                        </h3>
                        <h5 class="font-bold m-b-0">Coupure</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card">
                    <div class="box bg-success text-center">
                        <h3 class="m-b-0 text-white">
                        <?php
                        $montant_facture_payee_USD = 0;
                        $montant_facture_payee_monnaie_locale = 0;
                        foreach ($contract->getmontant_facture_payee_dun_mois($date['month'],$date['year']) as $value) 
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
                        echo $montant_facture_payee_USD.'_'.$tbMonnaie[0].' '.$montant_facture_payee_monnaie_locale.'_'.$tbMonnaie[1];

                            //$facture_payee = $contract->getmontant_facture_payee($date['month'],$annee = date('Y'));
                            //echo number_format($facture_payee,2).'_USD';
                            ?>
                        </h3>
                        <h5 class=" m-b-0 font-bold">Payeés</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h6 class="card-title">TICKETS</h6>
        <div class="row m-t-0">
            <div class="col-md-4 col-lg-4 col-xlg-4">
                <div class="card">
                    <div class="box bg-warning text-center">
                        <h6 class="font-light text-white">TOTAL <?php $data =$ticket->ticketTotal()->fetch();echo $data['nb'];?></h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-xlg-4">
                <div class="card">
                    <div class="box bg-danger text-center">
                        <h7 class="font-light text-white"><button type="button" class="btn btn-sm btn-rounded btn-danger" onclick="submitTicketOuvertEtFermer('ouvert',$('#WEBROOT').val())">OUVERT <?php $data =$ticket->ticketAtendu()->fetch();echo $data['ch'];?></button></h7>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-4 col-lg-4 col-xlg-4">
                <div class="card">
                    <div class="box bg-success text-center">
                        <h7 class="font-light text-white"><button type="button" class="btn btn-sm btn-rounded btn-success" onclick="submitTicketOuvertEtFermer('fermer',$('#WEBROOT').val())">FERMER <?php $data =$ticket->ticketRepondu()->fetch();echo $data['nb'];?></button></h7>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Total des clients par type</h6>
                <div id="morris-donut-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3" hidden="">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Total des clients par localisation</h6>
                <div id="morris-donut-chart-localisation"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">STATUS CLIENT ACTIF</h6>
                <div id="morris-donut-chart-client-actif"></div>
            </div>
        </div>
    </div>
     <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Graph de montant recu</h4>
                <ul class="list-inline text-right">
                    <li>
                        <h5><i class="fa fa-circle m-r-5 text-info"></i><?=$tbMonnaie[0]?></h5>
                    </li>
                    <li>
                        <h5><i class="fa fa-circle m-r-5 text-success"></i><?=$tbMonnaie[1]?></h5>
                    </li>
                </ul>
                <div id="montant_recu_graph_dashboard"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Factures et montant recus</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
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
                                <td hidden=""><?php echo $solde =number_format($resulta - $resultapaye,2).'_USD';?></td>

                                <td hidden=""><?php
                                if ($resultapaye AND $resulta > 0)
                                {
                                   $pourcentage = $resultapaye * 100 / $resulta;

                                $tx_recouvrement =round($pourcentage,2);

                                echo $tx_recouvrement.'%'; 
                                }
                                else
                                    echo '0 %';
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
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>