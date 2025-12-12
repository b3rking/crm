<?php
ob_start(); 
$date = date_parse(date('Y-m-d'));
?> 
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">RAPPORTS SYNTHESE DU  <?php
                echo date("d/m/Y"); // Affiche la date du jour
                //echo "Il est " . date("H:i:s") ; // Affiche l'heure
                ?></h4>
                <div class="table-responsive">
                    <table class="table color-table nowrap success-table">
                        <thead>
                            <tr>
                                <th>Libelle</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ANCIEN SOLDE</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>SOLDE ACTUEL</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>TOTAL ENTREE</td>
                                <td>
                                    <?php    
                                        $payement = $comptabilite->getPaiementTotalParMois($date['year'],$date['month'])->fetch();
                                        $extrat = $comptabilite->total_extrat($date['month'],$date['year'])->fetch();
                                        $total_entre = number_format($payement['montant'],2) + $extrat['montant'];
                                            echo number_format($total_entre).' USD';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>FACTURE IMPRIMEZ</td>
                                <td>
                                    <?php 
                                    $facture_imprimer = $contract->getfacture_total($date['month'],$annee = date('Y'));
                                    echo number_format($facture_imprimer,2).'_USD';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>FACTURE PAYEZ</td>
                                <td>
                                    <?php
                                    $facture_payee = $contract->getmontant_facture_payee($date['month'],$annee = date('Y'));
                                    echo number_format($facture_payee,2).'_USD';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>SURPLUS</td>
                                <td>
                                    <?php
                                    $extrat = $comptabilite->total_extrat($date['month'],$annee = date('Y'))->fetch();
                                    if (!empty($extrat)) 
                                    {
                                        echo number_format($extrat['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>DEROGATION EN COURS</td>
                                <td>
                                    <?php
                                    // derogation mois passer
                                    if ($date['month'] == 1) 
                                    {
                                        $mois_derogation = 12;
                                        $annee_derogation = $date['year']-1;
                                    }
                                    else
                                    {
                                        $mois_derogation = $date['month'];
                                        $annee_derogation = $date['year'];
                                    }
                                    $res = $contract->getMontantFactureEnDerogationDunMois($mois_derogation,$annee_derogation)->fetch();
                                    if (!empty($res)) 
                                    {
                                        echo number_format($res['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>EN DEROGATION</td>
                                <td>
                                    <?php
                                    // derogation mois courant
                                    $res = $contract->getMontantFactureEnDerogationDunMois($date['month'],$date['year'])->fetch();
                                    if (!empty($res)) 
                                    {
                                        echo number_format($res['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>DEPENSE</td>
                                <td>
                                    <?php

                                        $depenseTotal = $comptabilite->totalDepenseDunMois($date['month'],$date['year'])->fetch();
                                        if (!empty($depenseTotal['montant'])) 
                                        {
                                            echo $depenseTotal['montant'].' USD';
                                        }
                                        else echo "0.00 USD";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>SOLDE CAUTION</td>
                                <td> 
                                    <?php
                                    $valeur = $contract->cautionTotaleDansUnMois($date['month'],$date['year'])->fetch();
                                    if(!empty($valeur))
                                    {
                                        echo number_format($valeur['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>FRAIS BANCAIRE</td>
                                <td></td>
                            </tr>
                            <!--th>CREDIT</th-->
                            <tr>
                                <td>COUPURE DU MOIS </td>
                                <td>
                                    <?php
                                    $res = $contract->getMontantCoupureDuMois($date['month'],$date['year']);
                                    echo number_format($res,2).'_USD';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>RESULTAT</td>
                                <td> 
                                    <?php
                                    $resultat = $total_entre - $depenseTotal['montant'];
                                    echo number_format($resultat).' USD';
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
                <h4 class="card-title">BANQUE</h4>
                <div class="table-responsive">
                    <table class="table color-table nowrap success-table">
                        <thead>
                            <tr>
                                <th>Banque</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resultat =0;
                            foreach ($comptabilite->get_rapport_banque() as $value) 
                            {
                                $resultat += $value->montantVersser;
                            ?>
                            <tr>
                                <td><?=$value->nom?></td>
                                <td><?php echo number_format($value->montantVersser).' '.$value->monnaie?></td>
                            </tr>
                            <?php
                            }
                            
                            foreach ($comptabilite->getGrandeCaisses() as $value) 
                            {
                                $resultat += $value->montantCaisse;
                            ?>
                                <tr>
                                    <td><?=$value->nomCaisse?></td>
                                    <td><?=number_format($value->montantCaisse).' '.$value->devise?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td>Total General</td>
                                <td>
                                    <?php echo number_format($resultat);?> 
                                </td>
                            </tr> 
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