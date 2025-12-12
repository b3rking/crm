<?php
require_once("model/service.class.php");
require_once("model/contract.class.php");
require_once("model/User.class.php");
require_once("model/client.class.php");
require_once("model/localisation.class.php");
require_once("model/comptabilite.class.php");  

function inc_facture_client()
{
	$service = new Service();
	$contract = new Contract();
	$user = new User();
	$comptabilite = new Comptabilite();
    $client = new Client();
    
    $result = $contract->recupererFactures();
    
    $billing_number = "";
	$nom_client = "";
	$date1 = "";
	$date2 = "";
	$mode_creation = "";
	$mois_creation = "";
	$annee_creation = date('Y');
	require_once('vue/admin/facture/facture_client.php');
}
function miseajoursolde()
{
	$comptabilite = new Comptabilite();
	$contract = new Contract();
	$client = new Client();

	$date = date_parse(date('Y-m-d'));
	//$jour = $date['day'];
	$mois_debut = $date['month'];
	$annee_debut = $date['year']; 
    $taux = 1765;

if ($contract->updateEtatFactureDeMoisCourant(date('Y-m-01')) > 0) 
{
	foreach ($contract->get_Clients_Par_Mois_De_Facturation(date('Y-m-01')) as $value) 
	{
		/*$facture_bif = 0;
		$paiement_bif = 0;
		foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value2) 
		{
			$facture_bif += ($value2->monnaie == 'BIF' ? round($value2->montant) : round($value2->montant)*$taux);
		}
		foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value2) 
		{
			$paiement_bif += ($value2->exchange_currency == 'BIF' ? $value2->montant : $value2->montant*$taux);
		}
        
        $balanceInitiale = ($contract->getBalanceInitiale($value->ID_client)->fetch() ? $contract->getBalanceInitiale($value->ID_client)->fetch() : 0);
	    $balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
        $solde = $facture_bif + $balanceInitiale - $paiement_bif;
        
		$client->updateSoldeClient($value->ID_client,$solde);*/
        
		$facture_bif = 0;
		$paiement_bif = 0;
        foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value2) 
        {
            $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
            $facture_bif += (strtolower($value2->monnaie) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
        }
        foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value2) 
        {
            $thisRate = $value2->exchange_rate >= 500 ? $value2->exchange_rate:$taux;
            $paiement_bif += (strtolower($value2->exchange_currency) == 'bif' ? $value2->montant : $value2->montant*$thisRate);
        }
//		foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value2) 
//		{
//			$facture_bif += ($value2->monnaie == 'BIF' ? round($value2->montant) : round($value2->montant)*$taux);
//		}
//		foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value2) 
//		{
//			$paiement_bif += ($value2->exchange_currency == 'BIF' ? $value2->montant : $value2->montant*$taux);
//		}
		
		$balanceInitiale = ($contract->getBalanceInitiale($value->ID_client)->fetch() ? $contract->getBalanceInitiale($value->ID_client)->fetch() : 0);
		$balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
		$solde = $facture_bif + $balanceInitiale - $paiement_bif;
		$client->updateSoldeClient($value->ID_client,$solde);
	}
}


}







function nouveauclient($mois,$annee)
{
	$client = new Client();
	require_once('printing/fiches/nouveauclient_facturation.php');
}
function filtreFactures($billing_number,$nom_client,$date1,$date2,$mode_creation,$mois_creation,$annee_creation,$print)
{
	$service = new Service();
	$contract = new Contract();
	$user = new User();
	$comptabilite = new Comptabilite();
    $client = new Client();
	

	$condition1 = null;
    $condition2 = null;
    $condition3 = null;
    $condition4 = null;
    $condition5 = null;
    $condition6 = null;
    $con = '';
    //if (typeof idclient == 'undefined') {idclient = '';}
    if ($billing_number == '') 
    {
        $condition1 = '';
    }
    else
    {
        $condition1 = " billing_number='".$billing_number."' ";
    }
    if ($nom_client == '') 
    {
        $condition2 = '';
    }
    else
    {
        //condition2 = " cl.ID_client="+idclient+" ";
        $condition2 = " nom_client LIKE '%".$nom_client."%' ";
    }
    if ($mode_creation == '') 
    {
        $condition3 = '';
    }
    else
    {
        $condition3 = " fac.creation_mode='".$mode_creation."' ";
    }
    if ($date1 == '') 
    {
        $condition4 = '';
    }
    else
    {
        $condition4 = " fac.date_creation='".$date1."' ";
    }
    if ($date2 == '') 
    {
        $condition5 = '';
    }
    else
    {
        if ($date1 !== '') 
        {
            $condition5 = " fac.date_creation BETWEEN '".$date1."' AND '".$date2."'";
            $condition4 = '';
        }
        else $condition5 = " fac.date_creation='".$date2."' ";
    }
    if ($mois_creation == '') 
    {
        $condition6 = '';
    }
    else
    {
        if ($annee_creation != '') 
        {
            $condition6 = " fs.mois_debut='".$mois_creation."' AND fs.annee=".$annee_creation;
        }
    }

    $condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
    $condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
    $condition5 = ($condition5 == '' ? '' : 'AND' .$condition5);
    $condition6 = ($condition6 == '' ? '' : 'AND' .$condition6);

    $cond = $condition1.$condition2.$condition3.$condition4.$condition5.$condition6;
    
	/*if($print == 1)
    {
        $result = $contract->filtreFactures($cond);
        
        $fileName = "liste-des-factures-mai-".date('d-m-Y').".xls";

        //Set header information to export data in excel format
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$fileName);

        //Add the MySQL table data to excel file
        if(!empty($result)) 
        {
            $total_usd = 0;
            $total_bif = 0;
            echo implode("\t", ["ID","NOM","MENSUALITE","MONNAIE","JANVIER","FEVRIER","MARS","AVRIL","MAI","JUIN","JUILLET","AOUT","SEPTEMBRE","OCTOBRE","NOVEMBRE","DECEMBRE"]) . "\n";
            foreach($result as $item) 
            {
                //$prixTva = $item->montant*18/100;

                $total_bif += $item->monnaie == 'BIF' ? $item->montant_total:0;
                $total_usd += $item->monnaie == 'USD' ? $item->montant_total:0;
                echo implode("\t", [$item->billing_number,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $item->nom_client),$item->montant_total,$item->monnaie,"","","","","","","","","","","",""]) . "\n";
            }
            echo implode("\t", ["TOTAL BIF",$total_bif,"","","","","","","","","","","","","",""]) . "\n";
            echo implode("\t", ["TOTAL USD",$total_usd,"","","","","","","","","","","","","",""]) . "\n";
        }
    }*/
	if ($print == 1)
    {
        /*$total_usd = 0;
		$total_monnaie_locale = 0;
        $fileName = "factures-juillet-".date('Y').".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$fileName);
        echo implode("\t", ["ID","NOM","MONTANT","MONNAIE"]) . "\n";
        foreach ($contract->filtreFactures($cond) as $value) 
		{
            $i++;
			if ($value->monnaie == 'USD') $total_usd +=$value->montant_total;
			else $total_monnaie_locale +=$value->montant_total;
			/*$month_draw;
            
			$this->Row([$i,$value->billing_number,$value->nom_client,$value->nomService,number_format($value->montant_total).' '.$value->monnaie,$value->exchange_rate.'_'.$value->exchange_currency,$mois[$value->mois_debut].'/'.$value->annee]);*

            //Set header information to export data in excel format
            
            
            echo implode("\t", [$value->billing_number,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $value->nom_client),round($value->montant_total),$value->monnaie]) . "\n";
		}
        echo implode("\t", ["TOTAL BIF","",round($total_monnaie_locale),""]) . "\n";
        echo implode("\t", ["TOTAL USD","",round($total_usd),""]) . "\n";
        exit();*/
        /*$fileName = "liste-des-clients-payant-".date('Y').".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$fileName);
        echo implode("\t", ["BILLING NUMBER","NOM","NEXT BILLING DATE","LOCALISATION","ETAT","SOLDE"]) . "\n";
        foreach ($contract->filtreFactures($cond) as $value) 
		{
            echo implode("\t", [$value->billing_number,iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $value->Nom_client),$value->next_billing_date,$value->nom_localisation,$value->etat,$value->solde]) . "\n";
		}*/
    	require_once("printing/fiches/printFactureFiltrer.php");
    }
    else
    {
    	$result = $contract->filtreFactures($cond);
		require_once('vue/admin/facture/facture_client.php');
    }
    
    
}
function incomeingInvoices()
{
	$contract = new Contract();
	$date = new DateTime(date('Y-m-01'));
	$date->add(new DateInterval('P1M'));
	$next_billing_date = $date->format('Y-m-d');
	$result = $contract->incomeingInvoices($next_billing_date);
	require_once 'printing/fiches/printIncomeingInvoices.php';
}
function inc_factureReport()
{
	$service = new Service();
	$contract = new Contract();
	$user = new User();
	
//	require_once 'vue/admin/facture/raportFacture.php';
    $result = $contract->monthly_amount_to_be_collected();
	require_once 'vue/admin/facture/monthly_amount_to_be_collected.php';
}
function printInvoiceMonthlyCollected($repport_id)
{
	$contract = new Contract();
	$result = $contract->monthly_amount_to_be_collected_by_id($repport_id)->fetch();
	
	require_once 'printing/fiches/printInvoiceMonthlyCollected.php';
}
function printfactureApreCreerContract()
{
	/*$contract = new Contract();
	$data = $contract->recupererFactureIdMaxToPrint()->fetch();
	$facture_id = $data['facture_id'];
	$date_creation = $data['date_creation'];
	$nif = $data['nif'];
	$adresse = $data['adresse'];
	$assujettiTva = $data['assujettiTVA'];
	$nom_client = $data['nom_client'];
	$mois_debut = $data['mois_debut'];
	$annee = $data['annee'];
	$quantite = $data['quantite'];
	$monnaie = $data['monnaie'];
	$montant = $data['montant'];
	$prixTva = $montant/100*$data['tva'];
	$prixTTC = $montant + $prixTva;
	$nomService = $data['nomService'];
	$bandepassante = $data['bandepassante'];
	require_once('printing/fiches/printfacture.php');*/

	$contract = new Contract();
	$data = array();
	$i = 0;
	foreach ($contract->recupererFactureIdMaxToPrint() as $value) 
	{
		$i++;
		$data[] = $value;
		$facture_id = $value->facture_id;
		$date_creation = $value->date_creation;
		$nif = $value->nif;
		$adresse = $value->adresse;
		$assujettiTva = $value->assujettiTVA;
		$mois_debut = $value->mois_debut;
		if ($i == 1) 
		{
			$show_rate = $value->show_rate;
			$taux = $value->exchange_rate;
			$nom_client = $value->nom_client;
		}
	}
	$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
    /*while ($mois_val = current($mois)) 
    {
        if ($mois_val == $mois_debut) 
        {
            $cle =  key($mois);
            break;
        }
        next($mois);
    }*/
	require_once('printing/fiches/imprimerfactureParId.php');
}
function imprimerfactureParId($facture_id)
{
	$contract = new Contract();
    $comptabilite = new Comptabilite();
	$banque = $comptabilite->getBanqueActiveAndVisibleOnInvoice();
    $client = $contract->get_client_by_facture_id($facture_id)->fetch();
	require_once('printing/fiches/imprimerfactureParId.php');
    $pdf = new myPDF();

    $pdf->SetLeftMargin(15.2);
    $pdf->AliasNbPages();
    $pdf->init($client);
    $pdf->setBanque($banque);
    $pdf->AddPage();
    $pdf->headerTable();
//    if(strtolower($client['exchange_currency']) == 'usd' && strtolower($client['monnaie']) != 'bif')
//        $pdf->SetWidths(array(30,20,20,20,20,25,20,25));
//    else
//        $pdf->SetWidths(array(50,20,25,25,25,25));
    
    $columns = ['Libelle','Quantite','PU','Total PU','TVA','TVAC'];
    $widths = [50,20,25,25,25,25];
    if($client['billing_date'] >= '2023-09-01')
    {
        if(strtolower($client['exchange_currency']) == 'bif')
        {
            $widths =[30,20,20,20,20,25,20,25];
            $columns = ['Libelle','Quantite','PU','Total PU','TVA','TVAC','OTT','TTC'];
        }
    }
    
    $pdf->SetWidths($widths);
    $pdf->viewTable($contract,$facture_id,$columns);
    $pdf->Output();
}
function imprimerProformatParId($facture_id)
{
	$contract = new Contract();
	$client = $contract->recupererUnProformat($facture_id)->fetch();
	require_once('printing/fiches/imprimerProformatParId.php');
}
function creatMassInvoice($mode,$datefacture,$mois,$annee,$taux,$userName)
{
	$contract = new Contract();
	$user = new User();
	$comptabilite = new Comptabilite();
    $client = new Client();
	//$taux = $user->getTaux()->fetch();
	$mois_array = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
    $english_months = [1=>'January',2=>'February',3=>'March',4=>'April',5=>'May',6=>'June',7=>'July',8=>'August',9=>'September',10=>'October',11=>'November',12=>'December'];
    $periode = [1 => 'mensuel',3 => 'trimestriel',6 => 'semestriel',12 => 'annuel'];
    $english_period = [1 => 'monthly',3 => 'quarterly',6 => 'half-yearly',12 => 'annualy'];
	$quantite;
	$mois_debut = $mois;
	$mois_fin;
	$annee_debut = $annee;
	$annee_fin;
	$startDate = null;
	$endDate = null;
	//$tva = 18;
	$reduction = 0;
	$billing_date = ($mois < 10 ? $annee.'-0'.$mois.'-01' : $annee.'-'.$mois.'-01');
    $etat_facture = 'actif';
    $tvci = 18;
    $tva = 0;
    if ($billing_date > date('Y-m-01')) 
    {
    	$etat_facture = 'attante';
    	//$tvci = 18;
    }
    /*$quantite = ['mensuelle'=>1,'trimestrielle'=>3,'semestrielle'=>6,'annuelle'=>12];
    $reduction = ['mensuelle'=>0,'trimestrielle'=>5,'semestrielle'=>10,'annuelle'=>15];*/
    $quantite = [1=>1,3=>3,6=>6,12=>12];
    $reduction = [1=>0,3=>5,6=>10,12=>15];
	foreach ($contract->getDataToPrintOnFactureEnMasse($mode,$billing_date) as $value)
	{
		//if (empty($contract->getMoisFactureDunClient($value->ID_client,$mois_debut,$annee_debut)->fetch()['ID_client'])) 
		//{
			/*$reduction = 0;
			if ($value->facturation == 'mensuelle') 
				$quantite = 1;
			elseif ($value->facturation == 'trimestrielle') 
			{
				$quantite = 3;
				$reduction = 5;
			}
			elseif ($value->facturation == 'semestrielle') 
			{
				$quantite = 6;
				$reduction = 10;
			}
			else
			{
				$quantite = 12;
				$reduction = 20;
			}
            $rep = 12 - $mois + 1;
			$res = $quantite - $rep;
			if ($res < 0 ) 
			{
				$mois_fin = $res + 12;
				$annee_fin = $annee;
			}
			elseif ($res == 0) 
			{
				$mois_fin = 12;
				$annee_fin = $annee;
			}
			else
			{
				$mois_fin = $res;
				$annee_fin = $annee +1;
			}
			if ($mois_fin == 12) 
			{
				$nextMoth = 1;
				$nextYear = $annee_fin + 1;
			}
			else
			{
				$nextMoth = $mois_fin+1;
				$nextYear = $annee_fin;
			}*/
			$interval = $quantite[$value->facturation]-1;
			$date = new DateTime($annee.'-'.$mois.'-01');
			$date->add(new DateInterval('P'.$interval.'M'));
			$mois_fin = intval($date->format('m'));
			$annee_fin = $date->format('Y');
			
			$date = new DateTime($annee_fin.'-'.$mois_fin.'-01');
			$date->add(new DateInterval('P1M'));
			$next_billing_date = $date->format('Y-m-d');
        
			$description = $value->langue == 'anglais' ? $english_period[$value->facturation].' subscription ' : 'Abonnement '.$periode[$value->facturation];
			if ($quantite[$value->facturation] > 1) 
			{
				if ($annee_debut == $annee_fin) 
				{
					$description .= $value->langue == 'anglais' ? ';'.ucfirst($english_months[$mois_debut]).' to '.ucfirst($english_months[$mois_fin]).' '.$annee_debut : '; mois de '.ucfirst($mois_array[$mois_debut]).' a '.ucfirst($mois_array[$mois_fin]).' '.$annee_debut;
				}
				else
				{
					$description .= $value->langue == 'anglais' ? ';'.ucfirst($english_months[$mois_debut]).' '.$annee_debut.' to '.ucfirst($english_months[$mois_fin]).' '.$annee_fin : '; mois de '.ucfirst($mois_array[$mois_debut]).' '.$annee_debut.' a '.ucfirst($mois_array[$mois_fin]).' '.$annee_fin;
				}
			}
			else
			{
				$description .= $value->langue == 'anglais' ? ucfirst($english_months[$mois_debut]).' '.$annee_debut : ' mois de '.ucfirst($mois_array[$mois_debut]).' '.$annee_debut;
			}
			$billing_number = $value->billing_number;

			$mois_debut_f = ($mois_debut < 10 ? '0'.$mois_debut : $mois_debut);
			$numero = $value->billing_number.'/'.$annee_debut.$mois_debut_f.'01';

			$monnaie = $value->monnaie;
//			$exchange_currency = $value->monnaie_facture;
            $exchange_currency = 'BIF';
			//if ($value->monnaie == $value->monnaie_facture) 
			//{
				//$exchange_rate = 1;
				//$fixe_rate = 0;
				//$show_rate = 0;
			//}
			//else 
			//{
				//$exchange_rate = $taux;
				$fixe_rate = 1;
				//$show_rate = 1;
			//}
			$exchange_rate = $taux;
			$show_rate = 1;
			//$tva = $value->tva;
            
			if ($contract->creeFacture($numero,$value->ID_client,$show_rate,$value->enable_discounts,$reduction[$value->facturation],$monnaie,$tva,$tvci,$datefacture,$exchange_rate,$exchange_currency,$fixe_rate,$nextMoth=0,$nextYear=0,$billing_date,$etat_facture,$mode)) 
			{
				$facture_id = $contract->getFactureId_par_IdClient($value->ID_client)->fetch()['facture_id'];
				foreach ($contract->getClientEnfantToPrintOnFactureEnMasse($value->ID_contract) as $value2) 
				{
					$montant = $value2->montant;
					$totalHTVA = $montant * $quantite[$value->facturation];
					$montant_tva = $totalHTVA/100*$tva;
					$montant_tvci = $totalHTVA/100*$tvci;
					$montant_total_avant_reduction = $totalHTVA + $montant_tva + $montant_tvci;

					$prixRediction = $montant_total_avant_reduction/100*$reduction[$value->facturation];
					$montant_total_ttc = $montant_total_avant_reduction - $prixRediction;
                    
                    $ott = 0;
                    if($billing_date >= '2023-09-01')
                       // ott pour turame a 500000
                    if ($value->ID_client != 1157) 
                    	{
                    		$ott = 100000 * $quantite[$value->facturation];
                    	} 
                    	else 
                    	{
                    		$ott = 500000; 
                    	}

					$service = ';'.$value2->nomService/*.' '.$value2->bandepassante*/;
					$description .= $service;
                    if ($value2->show_on_facture == 1 AND $value2->nom != "") 
					{
						$description = $value2->nom;
					}
					if ($contract->creerFactureService($facture_id,$value2->ID_service,$value2->bandepassante,$montant,$montant_total_avant_reduction,$montant_total_ttc,$montant_tva,$montant_tvci,$mois_debut,$mois_fin,$quantite[$value->facturation],$annee_debut,$annee_fin,$description,$startDate,$endDate,$billing_cycle=1,$reduction[$value->facturation],$ott))
					{

					}
				}
				if ($etat_facture == 'actif') 
				{
					$taux2 = 1765;
                    //$taux = 2000;
					$facture_bif = 0;
					$paiement_bif = 0;
                    foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value3) 
                    {
                        $thisRate = $value3->exchange_rate >= 500 ? $value3->exchange_rate:$taux2;
                        $facture_bif += (strtolower($value3->monnaie) == 'bif' ? $value3->montant : $value3->montant*$thisRate);
                        $facture_bif += $value2->ott;
                    }
                    foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value3) 
                    {
                        $thisRate = $value3->exchange_rate >= 500 ? $value3->exchange_rate:$taux2;
                        $paiement_bif += (strtolower($value3->exchange_currency) == 'bif' ? $value3->montant : $value3->montant*$thisRate);
                    }
//					foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value3) 
//					{
//						$facture_bif += ($value3->monnaie == 'BIF' ? round($value3->montant) : round($value3->montant)*$taux2);
//					}
//					foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value3) 
//					{
//						$paiement_bif += ($value3->exchange_currency == 'BIF' ? $value3->montant : $value3->montant*$taux2);
//					}
					$balanceInitiale = ($contract->getBalanceInitiale($value->ID_client)->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($value->ID_client)->fetch()['montant']);
					$solde = $facture_bif + $balanceInitiale - $paiement_bif;
					$client->updateSoldeClient($value->ID_client,$solde);
				}
				if ($contract->updateNext_billing_date($value->ID_contract,$next_billing_date) > 0) 
				{
					# code...
				}
				if ($contract->update_Facture_next_billing_date($facture_id,$next_billing_date) > 0) 
				{}
				if ($comptabilite->setHistoriqueAction($facture_id,'facture',$_SESSION['ID_user'],date('Y-m-d'),'creer')) 
				{
				}
			}
		//}
	}
	$tb_factureId = array();
	$annee_raport = $annee_debut;
	//if ($mode == 'impression') 
	//{
		foreach ($contract->recupereIdfactureCreerAuneDate($mois_debut,$annee_raport,$mode) as $value) 
		{
			$tb_factureId[] = $value;
		}
		if (!empty($tb_factureId)) 
		{
            $banque = $comptabilite->getBanqueActiveAndVisibleOnInvoice();
			require_once("printing/fiches/printMassInvoice.php");
		}
		else
		header('location:facture_client');
	//}
}

function printInvoiceMonthly($mois_debut,$annee_raport,$mode)
{
	$contract = new Contract();
    $comptabilite = new Comptabilite();
	$annee_debut = $annee_raport;
	$tb_factureId = array();
	foreach ($contract->recupereIdfactureCreerAuneDate($mois_debut,$annee_raport,$mode) as $value) 
	{
		$tb_factureId[] = $value;
	}
	if (!empty($tb_factureId)) 
	{
        $banque = $comptabilite->getBanqueActiveAndVisibleOnInvoice();
		require_once("printing/fiches/printMassInvoice.php");
	}
	else
		header('location:facture_client');
	
}
function print_rapport_mois($mois_selectionné,$annee_raport)
{
	$contract = new Contract();
	require_once("printing/fiches/printrapport_choisi_par_mois.php");
}
function report_fact($cond)
{
	//echo "cond = ".$cond;
	$contract = new Contract();
	require_once("printing/fiches/printFactureFiltrer.php");
	//require_once("printing/fiches/rapportParMoiFactureFiltrer_impaye.php");
}
function printraportfactPayerImpayer($condition,$type)
{
	$contract = new Contract();
	$title;
	if ($type == 'paying') 
	{
		$res = $contract->raportFacturePayer($condition);
		$title = iconv('UTF-8', 'windows-1252', 'Facture payeé');
	}
	else 
	{
		$title = iconv('UTF-8', 'windows-1252', 'Facture impayeé');
		$res = $contract->raportFactureImpayer($condition);
	}
	require 'printing/fiches/raportFacturePayerEtImpayer.php';
}
function printInvoiceCreerAuneDate($date_creation)
{
	$contract = new Contract();

	$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
	$cle = 0;
	require_once("printing/fiches/printMassInvoice.php");
}
function genere_rapport_choisi_par_mois()
{
	$contract = new Contract();
	require_once("printing/fiches/genere_rapport_choisi_par_mois.php");

}
function inc_balance_initiale()
{
	$contract = new Contract();
	$comptabilite = new Comptabilite();
    $client = new Client();

	require_once('vue/admin/facture/balance_initiale.php');
}
function inc_suspension()
{
	$contract = new Contract();
	require_once('vue/admin/facture/pauseClient.php');
}
function inc_coupure()
{
	$contract = new Contract();
    $client = new Client();
	require_once('vue/admin/facture/coupure.php');
}
function genererListeDesClientsAderoguer()
{
	$contract = new Contract();
    
	require_once('vue/admin/facture/genererClientAderoguer.php');
}
function detail_coupure($action,$cutoff_id)
{
	$contract = new Contract();
    $client = new Client();
    $result = $contract->detailCoupure($action,$cutoff_id);
    //$result = $client->getClientActifs_avec_mensualite();
	$libelle = ['couper' => 'coupure','recouvrer'=>'recouvrement'];
	require_once('vue/admin/facture/detail_coupure.php');
}
function print_coupure_action($action,$coupure_id)
{
	$contract = new Contract();
	require_once("printing/fiches/print_coupure_action.php");
}
function inc_proforma_facture()
{	
	$contract = new Contract();
	$user = new User();
	$service = new Service();
	$localisation = new Localisation();
    $comptabilite = new Comptabilite();
	$numero = "";
    $nom_client = "";
    $date1 = "";
    $date2 = "";
    $result = $contract->recupererProformats();
	require_once('vue/admin/facture/proforma_facture.php');
}
function filtreProformats($numero,$nom_client,$date1,$date2)
{
	$condition1;
    $condition2;
    $condition3;
    $condition4;
    $condition5;
    $condition6;
    $condition = '';

    if ($numero == '') 
    {
        $condition1 = '';
    }
    else
    {
        $condition1 = " pro.numero = '".$numero."' ";
    }
    if ($nom_client == '') 
    {
        $condition2 = '';
    }
    else
    {
        $condition2 = " nom_client LIKE '%".$nom_client."%' ";
    }
    if ($date1 == '') 
    {
        $condition3 = '';
    }
    else
    {
        $condition3 = " pro.date_creation = '".$date1."' ";
    }
    if ($date2 == '') 
    {
        $condition4 = '';
    }
    else
    {
        if ($date1 !== '') 
        {
            $condition4 = " pro.date_creation BETWEEN '".$date1."' AND '".$date2."'";
            $condition3 = '';
        }
        else $condition4 = " pro.date_creation='".$date2."' ";
    }

    $condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
    $condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);

    $condition = $condition1.$condition2.$condition3.$condition4;
    $contract = new Contract();
	$user = new User();
	$service = new Service();
	$localisation = new Localisation();
    $comptabilite = new Comptabilite();

    $result = $contract->filtreProformats($condition);
	require_once('vue/admin/facture/proforma_facture.php');
}
function inc_ordre_d_achat()
{
	require_once('vue/admin/facture/ordre_d_achat.php');
}
function rapportchoisi_par_moi()
{
	$contract = new Contract();
	require_once("printing/fiches/rapportParMoiFactureFiltrer.php");
}


function importDataFacture()
{
	$contract = new Contract();
    $client = new Client();

	//$taux = 2000;
    $taux = 1765;
	foreach ($contract->importDataFacture() as $value)
	{

		$facture_bif = 0;
		$paiement_bif = 0;
		foreach ($contract->getSommeTotaleFactureDunClient($value->ID_client) as $value1) 
		{
			$facture_bif += ($value1->monnaie == 'BIF' ? round($value1->montant) : round($value1->montant)*$taux);
		}
		foreach ($contract->getSommeTotalePayementDunClient($value->ID_client) as $value1) 
		{
			$paiement_bif += ($value1->exchange_currency == 'BIF' ? $value1->montant : $value1->montant*$taux);
		}
		//$balanceInitiale = ($contract->getBalanceInitiale($_GET['client_parent'])->fetch()['montant'] == '' ? 0 : $contract->getBalanceInitiale($_GET['client_parent'])->fetch()['montant']);
		$balanceInitiale = ($contract->getBalanceInitiale($value->ID_client)->fetch() ? $contract->getBalanceInitiale($value->ID_client)->fetch() : 0);
		$balanceInitiale = ($balanceInitiale != 0 ? $balanceInitiale['montant'] : 0);
		$solde = $facture_bif + $balanceInitiale - $paiement_bif;
		$client->updateSoldeClient($value->ID_client,$solde);
	}
	function newClient()
	{
		//$service = new Service();
		$client = new Client();
		$contract = new Contract();
		$user = new User();
		var_dump('ok');require_once 'vue/admin/facture/monthly_amount_to_be_collected.php';
		require_once 'vue/admin/facture/raportFacture.php';
		//$result = $contract->monthly_amount_to_be_collected();
	}
function printraportclient($mois,$annee)
{
	$contract = new Contract();
	 $client = new Client();
	$title;
	$tab_mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];

		$res = $client->getallClient($mois,$annee);
		$title = iconv('UTF-8', 'windows-1252', 'Client du mois de : '.$tab_mois[$mois]);

	require 'printing/fiches/NEWCUSTOMER.php';
}

	/*$verifierCreation = 0;
	foreach ($contract->importDataFacture() as $value)
	{
		$rep = 12 - $value->mois + 1;
		$res = $value->quantite - $rep;
		if ($res < 0 ) 
		{
			$mois_debut = $value->mois;
			//$mois_fin = $res + 12;
			$mois_fin = $res + 12;
			$annee_debut = date('Y');
			$annee_fin = date('Y');
		}
		elseif ($res == 0) 
		{
			$mois_debut = $value->mois;
			$mois_fin = 12;
			$annee_debut = date('Y');
			$annee_fin = date('Y');
		}
		else
		{
			$mois_debut = $value->mois;
			$mois_fin = $res;
			$annee_debut = date('Y');
			$annee_fin = 2021;
		}

		$date = date_parse(date('Y-m-d'));
		$mois_courant =$date['month'];
		//$facture_id = $value->billing_number.'/'.date('Ymd');
		$billing_number = $value->billing_number;
		$facture_id = $billing_number.'_'.$annee_debut.$mois_debut.'1';

		if ($mois_fin == 12) 
		{
			$nextMoth = 1;
			$nextYear = $annee_fin+1;
		}
		else
		{
			$nextMoth = $mois_fin+1;
			$nextYear = $annee_fin;
		}
		$mois_array = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
		$description='Abonnement mensuel ';
		if ($value->quantite > 1) 
		{
			if ($annee_debut == $annee_fin) 
			{
				$description .= 'mois de '.ucfirst($mois_array[$mois_debut]).' à '.ucfirst($mois_array[$mois_fin]).' '.$annee_debut;
			}
			else
			{
				$description .= 'mois de '.ucfirst($mois_array[$mois_debut]).'/'.$annee_debut.' au '.ucfirst($mois_array[$mois_fin]).'/'.$annee_fin;
			}
		}
		else
		{
			$description .='mois de '.ucfirst($mois_array[$mois_debut]).' '.$annee_debut;
		}
		if ($contract->creeFacture($facture_id,$show_rate=0,$value->monnaie,$tva=0,$value->date_creation,$taux=1,$nextMoth,$nextYear)) 
		{
			$montantConverti = $value->montant;
			$montant_total = $montantConverti * $value->quantite;
			if ($contract->creerFactureService($facture_id,$value->ID_client,$value->ID_service,$montantConverti,$montant_total,$value->reduction,$mois_debut,$mois_fin,$value->quantite,$annee_debut,$annee_fin,$description)) 
			{
				$verifierCreation = true;
				if ($contract->augmanterBalanceInitiale($value->ID_client,$montant_total) > 0) 
				{
					$b = $contract->getmontaTotalBalanceInitiale($value->ID_client)->fetch();
					if ($contract->setAccountHistory($facture_id,'facture',$taux=1,$b['solde'],$b['montant_total'],$value->date_creation,$value->ID_client)) 
					{
						if ($value->quantite > 1) 
						{
							$y = 0;
							for ($i=0; $i < $value->quantite; $i++) 
							{ 
								$mois = $mois_debut+$i;
								if ($mois <= 12) 
								{
									if ($contract->setEcheance($value->ID_client,$mois,$annee_debut,$value->montant,$etat ='non consommer',$facture_id)) 
									{
										$verifierCreation = true;
									}
								}
								else
								{
									$y++;
									$mois = $mois_debut+$y;
									if ($contract->setEcheance($value->ID_client,$mois,$annee_fin,$value->montant,$etat ='non consommer',$facture_id)) 
									{
										$verifierCreation = true;
									}
								}
							}
						}
						else
						{
							if ($contract->setEcheance($value->ID_client,$mois_debut,$annee_debut,$value->montant,$etat ='non consommer',$facture_id)) 
							{
								$verifierCreation = true;
							}
						}
					}
				}
			}
		 }
	}
	echo $verifierCreation;*/
}
function setMoisFacture()
{
	$contract = new Contract();
	foreach ($contract->getFactureJanvier() as $value) 
	{
		if ($value->billing_cycle == 1) 
		{ 
			for ($i=0; $i < $value->quantite; $i++) 
			{ 
				$mois = $value->mois_debut+$i;
				if ($mois <= 12) 
				{
					if (empty($contract->getMoisFactureDunClient($value->ID_client,$mois,$value->annee)->fetch()['ID_client'])) 
					{
						$contract->setMoisFactureDunClient($value->ID_client,$mois,$value->annee,$value->facture_id);
					}
					else echo $value->ID_client.'=>'.$mois.';';
				}
				else
				{
					$y++;
					$mois = $y;
					if (empty($contract->getMoisFactureDunClient($value->ID_client,$mois,$value->annee_fin)->fetch()['ID_client'])) 
					{
						$contract->setMoisFactureDunClient($value->ID_client,$mois,$value->annee_fin,$value->facture_id);
					}
					else echo $value->ID_client.'=>'.$mois.';';
				}
			}
		}
	}
}

function importFactureService()
{
	$contract = new Contract();
	//$i=0;
	//foreach ($contract->importDataFacture() as $value)
	//{
		foreach ($contract->getInvoiceServices() as $value2) 
		{
			if ($value2->billing_cycle == 1) 
			{
				$rep = 12 - $value2->mois_debut + 1;
				$res = $value2->quantite - $rep;
				if ($res < 0 ) 
				{
					$mois_debut = $value2->mois_debut;
					//$mois_fin = $res + 12;
					$mois_fin = $res + 12;
					$annee_debut = $value2->annee;
					$annee_fin = $value2->annee;
				}
				elseif ($res == 0) 
				{
					$mois_debut = $value2->mois_debut;
					$mois_fin = 12;
					$annee_debut = $value2->annee;
					$annee_fin = $value2->annee;
				}
				else
				{
					$mois_debut = $value2->mois_debut;
					$mois_fin = $res;
					$annee_debut = $value2->annee;
					$annee_fin = $value2->annee +1;
				}
			}
			elseif($value2->billing_cycle == 0)
			{
				$date_debut = date_parse($value2->startDate);
				$mois_debut = $date_debut['month'];
				$annee_debut = $date_debut['year'];

				$date_fin = date_parse($value2->endDate);
			    $mois_fin = $date_fin['month'];
			    $annee_fin = $date_fin['year'];
			}
			else
			{
				$mois_debut = $value2->mois_debut;
				$mois_fin = $value2->mois_debut;
				$annee_debut = $value2->annee;
				$annee_fin = $value2->annee;
			}
			//$montant = $value2->montant;
			$montant_total_htva = $value2->montant_total;
			$montant_tva = $montant_total_htva * $value2->tva/100;
			$montant_total_ttc = $montant_total_htva + $montant_tva;
			$montant_reduction = $montant_total_ttc*$value2->reduction/100;
			$montant_total_ttc -= $montant_reduction;

			$billing_date = $annee_debut.'-'.$mois_debut.'-1';

			$contract->updateFactureServiceImport($value2->id,$montant_total_ttc,$montant_tva,$mois_fin,$annee_fin);
			$contract->updateBiling_date_facture($value2->facture_id,$billing_date);
			//$contract->setImportFactureService($value2->id,$value2->invoice_id,$value->customer_id,$value2->service_id,$value2->bandwidth,$montant,$montant_total_ttc,$montant_tva,$value2->start_date,$value2->end_date,$mois_debut,$mois_fin,$value2->quantity,$annee_debut,$annee_fin,$value2->description,$value2->billing_cycle);
		}
	//}
}
function updateMontantFacture()
{
	$contract = new Contract();
	foreach ($contract->getFactureServiceViaMmail() as  $value) 
	{
		$tva = 18;
		//$montant = $value2->montant_total;
		$totalHTVA = $value->montant_total;
		$montant_tva = $totalHTVA/100*$tva;
		//$montant_total_avant_reduction = $totalHTVA + $montant_tva;
		//$prixRediction = $montant_total_avant_reduction/100*$reduction;
		$montant_total_ttc = $totalHTVA + $montant_tva;
		if ($contract->updateMontantService($value->id,$montant_total_ttc,$montant_tva) > 0) 
		{
			// code...
		}
	}
}
function factureAnnuelle()
{
	$contract = new Contract();
	require_once"printing/fiches/printFactureAnnuelle.php";
}
function client_super()
{
	$client = new Client();
	$contract = new Contract();
	$comptabilite = new Comptabilite();
	require_once"printing/fiches/client_speciaux.php";
}