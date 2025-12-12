<?php
	ob_start();
    $date = date_parse(date('Y-m-d'));
?>
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
                <h4 class="card-title">Graph de solde mensuel des clients</h4>
                <div id="solde-mensuel"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Solde mensuel des clients</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Facture</th>
                                <th>Montant recu</th>
                                <th>Solde</th>
                                <th>Tx recouvrement</th>
                            </tr>
                        </thead>
                        <tbody id="rep">
                        <?php                        
                            $resulta = array();

                             $mois = ['1','2','3','4','5','6','7','8','9','10','11','12'];

                            $tb_mois= [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
                            for ($i=1; $i < $date['month'] +1; $i++) 
                            { ?>
                                <tr>
                                    <td>
                                        <?php 
                                        echo $tb_mois[$i];
                                        ?>   
                                    </td>
                                <td><?php 
                                $resulta = $contract->getfacture_total($i,$annee = date('Y'));
                                echo number_format($resulta,2).'_USD';
                                ?>
                                </td>
                                <td>
                                    <?php 
                                    $nombre_jour = cal_days_in_month(CAL_GREGORIAN, $i, $annee);
                                    $date1 = $annee.'-'.$i.'-1';
                                    $date2 = $annee.'-'.$i.'-'.$nombre_jour;
                                    $resultapaye = $contract->getmontant_payer_dans_un_mois($date1,$date2);
                                    //$contract->getmontant_facture_payee($i,$annee = date('Y'));
                                echo number_format($resultapaye,2).'_USD';
                                ?>
                                    
                                </td>
                                <td><?php echo $solde =number_format($resulta - $resultapaye,2).'_USD';?></td>

                                <td><?php
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
                            if ($date['month'] < 12) 
                            {
                                $mois_debut = $date['month']+1;
                                $annee_debut = date('Y');
                            }
                            else
                            {
                                $mois_debut = 1;
                                $annee_debut = date('Y')+1;
                            }
                            if ($contract->verifierUnMoisDebutExiste($mois_debut,$annee_debut)) 
                            {
                            ?>
                                <tr>
                                <td>
                                    <?php 
                                    echo $tb_mois[$mois_debut];
                                    ?>   
                                </td>
                                <td><?php 
                                $resulta = $contract->getfacture_total($mois_debut,$annee_debut);
                                echo number_format($resulta,2).'_USD';
                                ?>
                                </td>
                                <td>
                                    <?php 
                                    $nombre_jour = cal_days_in_month(CAL_GREGORIAN, $mois_debut,$annee_debut);
                                    $date1 = $annee_debut.'-'.$mois_debut.'-1';
                                    $date2 = $annee_debut.'-'.$mois_debut.'-'.$nombre_jour;
                                    $resultapaye = $contract->getmontant_payer_dans_un_mois($date1,$date2);
                                    //$contract->getmontant_facture_payee($i,$annee = date('Y'));
                                echo number_format($resultapaye,2).'_USD';
                                ?>
                                    
                                </td>
                                <td><?php echo $solde =number_format($resulta - $resultapaye,2).'_USD';?></td>

                                <td><?php
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
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Clients</h4>
                <!--<form class="form-horizontal p-t-20">
                    <div class="row">
                        <div class="col-lg-5 col-md-10"> 
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-5 col-lg-4 control-label">Mois</label>
                                <div class="form-group col-sm-10 col-lg-8">
                                <select id="rapor_mois_courant" class="form-control">
                                    <option value="1">Janvier</option>
                                    <option value="2">Fevrier</option>
                                    <option value="3">Mars</option>
                                    <option value="4">Avril</option>
                                    <option value="5">Mai</option>
                                    <option value="6">Juin</option>
                                    <option value="7">Juillet</option>
                                    <option value="8">Aout</option>
                                    <option value="9">Septembre</option>
                                    <option value="10">Octobre</option>
                                    <option value="11">Novembre</option>
                                    <option value="12">Decembre</option>
                                </select>  
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-10">
                            <div class="row">
                                <label for="exampleInputEmail3" class="col-sm-5 col-lg-4 control-label"> Annee</label>
                                <div class="form-group col-sm-9 col-lg-8">
                                   <php
                                     $date = date_parse(date('Y-m-d'));
                                     $annee = $date['year'];
                                    ?>
                                     <input type="text" id="rapor_annee_courant" value="<?=$annee?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-10">
                            <div class="row">
                                
                                 <div class="form-group col-sm-9">
                                  <button type="button" class="btn waves-effect waves-light btn-md btn-success" _msthash="2884232" _msttexthash="299910"onclick="rapportAnnee_mois_courant($('#rapor_mois_courant').val(),$('#rapor_annee_courant').val())">valider</button>
                                 </div>
                            </div>
                        </div>
                    </div>
                </form>-->
                <div class="table-responsive">
                    <table class="table full-color-table full-warning-table hover-table">
                        <thead>
                            <tr>
                                <th>Total</th>
                                <th>Actif</th>
                                <th>En derogation</th>
                                <th>Sans dette</th>
                                <th>Clients en coupure</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="text" id="url" value="<?=WEBROOT?>printclientactif" hidden>
                            <tr onclick="printClientActif($('#url').val())">
                                <?php
                                $enderogation = $client->totalClientEnDerogation()->nb;
                                $endette = $client->totalClientSansDete()->nb;
                                $encoupure = $client->totalClientEnCoupure()->nb;
                                $actif = $enderogation + $endette;
                                $total = $actif + $encoupure;
                                ?>
                                <td><?=$total?></td>
                                <td><?=$actif?></td>
                                <td><?=$enderogation?></td>
                                <td><?=$endette?></td>
                                <td><?=$encoupure?></td>
                            </tr>  
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <h4 class="card-title">Facturation</h4>
                <div class="table-responsive">
                    <table class="table full-color-table full-warning-table hover-table">
                        <thead>
                            <tr>
                                <th>Facture total</th>
                                <th>En derogation</th>
                                <th>Coupure</th>
                                <th>Dette total en coupure</th>
                                <th>Total dette </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <?php
                                    $resulta = $contract->getfacture_total($date['month'],$annee = date('Y'));
                                echo number_format($resulta,2).'_USD';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $res = $contract->getMontantFactureEnDerogation()->fetch();
                                    if (!empty($res)) 
                                    {
                                        echo number_format($res['montant'],2).'_USD';
                                    }
                                    else echo "0.00_USD";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $res = $contract->getMontantCoupureEncours();
                                    echo number_format($res,2).'_USD';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $res = $contract->getMontantDetteClientEncoupure()->fetch();
                                    echo number_format($res['montant'],2).'_USD';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $res = $contract->getDetteTotal()->fetch();
                                    echo $res['montant'].' '.$res['monnaie'];
                                    ?>
                                </td>
                            </tr>           
                        </tbody>
                    </table>
                </div>
            </div>
             <div class="card-body">
                <h4 class="card-title">Depense</h4>
                <div class="table-responsive">
                    <table class="table full-color-table full-warning-table hover-table">
                        <thead>
                            <tr>
                                <th>Depense</th>
                                <th>Recette</th>
                                <th>Caisse</th>       
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                <?php
                                $resulta = $comptabilite->totalDepenseDunMois($date['month'],$date['year'])->fetch();
                                if (!empty($resulta)) 
                                {
                                    echo $resulta['montant'].' USD';
                                }
                                ?></td>
                                <td>0,00$</td>
                                <td>0,00$</td>
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