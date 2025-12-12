<?php
require_once('model/comptabilite.class.php');
require_once('model/User.class.php');
require_once('model/client.class.php');
require_once("model/historique.class.php");
require_once("model/contract.class.php");

function monnaie()
{
	$comptabilite = new Comptabilite();
	require_once('vue/admin/finance/monnaie.php');
    /*$contract = new Contract();
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
	}*/
}
function inc_paiement()
{
	$comptabilite = new Comptabilite();
    $user = new User();
    $client = new Client();

    $billing_number = "";
    $nom_client = "";
    $date1 = "";
    $date2 = "";
    $mois_payement = "";
    $mois_facture = "";
    $mode_payement = "";
    $annee = "";
    $result = $comptabilite->getPayements();
	require_once('vue/admin/finance/paiement.php');
}
function payment_summary_report($year)
{
    $contract = new Contract();
    require_once('printing/fiches/printSummaryPayment.php');
}
function filtrePayement($billing_number,$nom_client,$date1,$date2,$mois_payement,$mois_facture,$annee,$mode_payement,$print)
{
	$comptabilite = new Comptabilite();
    $user = new User();
    $client = new Client();

    $condition1;
    $condition2;
    $condition3;
    $condition4;
    $condition5;
    $condition6; 
    $condition7;
    $condition8; 
    $condition = '';

    if ($nom_client == '') 
    {
        $condition1 = '';
    }
    else
    {
        $condition1 = " cl.Nom_client LIKE '%".$nom_client."%' ";
        $annee = "";
    }
    if ($date1 == '') 
    {
        $condition2 = '';
    }
    else
    {
        $condition2 = " p.datepaiement='".$date1."' ";
        $annee = "";
    }
    if ($date2 == '') 
    {
        $condition3 = '';
    }
    else
    {
        if ($date1 != '') 
        {
            //condition3 = " p.datepaiement BETWEEN '"+date1+"' AND '"+date2+"'";
            $condition3 = " p.datepaiement BETWEEN '".$date1."' AND '".$date2."'";
            $condition2 = '';
        }
        else $condition3 = " p.datepaiement='".$date2."' ";
        $annee = "";
    }
    if ($mois_payement == '') $condition4 = '';
    else $condition4 = " MONTH(p.datepaiement)=".$mois_payement." ";
    if ($annee == '') $condition5 = '';
    else $condition5 = " YEAR(p.datepaiement)=".$annee." ";
    //if ($condition1 != '') $condition5 = '';
    if ($billing_number == '') $condition6 = '';
    else
    {
        $condition6 = " cl.billing_number=".$billing_number;
        $condition5 = "";
    } 
    if ($mois_facture == '')
    {
    	$condition7 = '';
    	$tables = " paiement p,client cl ";
    } 
    else
    {
    	$tables = " paiement p,client cl,facture fc,facture_payer fp ";
    	$condition7 = " p.ID_paiement = fp.ID_paiement AND fc.facture_id = fp.facture_id AND MONTH(fc.billing_date) =".$mois_facture." AND YEAR(fc.billing_date) =".$annee." ";
    	$condition2 = "";
    	$condition3 = "";
//    	$condition4 = "";
//    	$condition5 = "";
    	$condition6 = "";
    }
    if ($mode_payement == "") 
    {
    	$condition8 = "";
    }
    else
    {
    	$condition8 = " methode = '".$mode_payement."' ";
    }

    $condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
    $condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
    $condition5 = ($condition5 == '' ? '' : 'AND' .$condition5);
    $condition6 = ($condition6 == '' ? '' : 'AND' .$condition6);
    $condition7 = ($condition7 == '' ? '' : 'AND' .$condition7);
    $condition8 = ($condition8 == '' ? '' : 'AND' .$condition8);
    $condition = $condition1.$condition2.$condition3.$condition4.$condition5.$condition6.$condition7.$condition8;
    if ($print == 1) 
    	require_once('printing/fiches/printFiltrePayement.php');
    else
    {
    	$result = $comptabilite->filtrePayement($condition,$tables);
		require_once('vue/admin/finance/paiement.php');
    }
}
function recu_paiement_facture($idpaiement)
{
	$comptabilite = new Comptabilite();
	$recuData = array();
	foreach ($comptabilite->affichage_detail_paiementRecu($idpaiement) as $value) 
	{
		$nomClient = $value->Nom_client;
		$dateRecu = $value->datepaiement;
		$billingNumber = $value->billing_number;
		$recuData[] = $value;
	}
	require_once('printing/fiches/recu_paiement_facture.php');
}
function print_filter_payement($condition)
{
	$comptabilite = new Comptabilite();
	require_once('printing/fiches/printFiltrePayement.php');
}
function rapport_payement_mensuel($mois,$annee)
{
	$comptabilite = new Comptabilite();
	if ($mois == date('m')) 
	{
		$date_debut = $annee.'/'.$mois.'/1';
		$dernierJour = date('d');
		$date_fin = $annee.'/'.$mois.'/'.$dernierJour;
	}
	else
	{
		$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
		$date_debut = $annee.'/'.$mois.'/1';
		$date_fin = $annee.'/'.$mois.'/'.$nombre_jour;
		//echo $date_debut.' '.$date_fin;
	}
	$res = $comptabilite->affichage_paiement_Mensuel($date_debut,$date_fin);
	require_once('printing/fiches/rapportPayementMensuel.php');
}

function inc_banque_de_versement()
{
    $user = new User();
	$comptabilite = new Comptabilite();
    $result = $comptabilite->getVersements();
	require_once('vue/admin/finance/banque_de_versement.php');
}
function filtreVerssement($banque,$date1,$date2,$reference)
{
    $user = new User();
    $comptabilite = new Comptabilite();

    $condition1;
    $condition2;
    $condition3;
    $condition = '';

    $condition1 = ($banque == "" ? "" : " b.ID_banque=".$banque." ");
    $condition2 = ($date1 == "" ? "": " bj.date_operation='".$date1."' ");
    if ($date2 == '') 
    {
        $condition3 = '';
    }
    else
    {
        if ($date1 != '') 
        {
            $condition3 = " bj.date_operation BETWEEN '".$date1."' AND '".$date2."'";
            $condition2 = '';
        }
        else $condition3 = " bj.date_operation='".$date2."' ";
    }
    $condition4 = ($reference == "" ? "" : " bj.reference=".$reference." ");

    $condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
    $condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
    $condition = $condition1.$condition2.$condition3.$condition4;

    $result = $comptabilite->filtreVerssement($condition);
    require_once('vue/admin/finance/banque_de_versement.php');
}
function saveVersement($idDestination,$monnaie,$reference,$dateversement,$paiement,$montant_total)
{
	//$checkMonnaie = true;
	//$montant_total = 0;
	$count_payement = count($paiement);
	/*foreach ($paiement as $key => $value) 
	{
		$paiement_array = preg_split("#[_]+#", $value);
        $montant_total += $paiement_array[1];
        /*if ($paiement_array[2] != $monnaie) 
        {
            $checkMonnaie = false;
        }*
	}*/
	//if ($checkMonnaie) 
	//{
    date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");
    //$started_at = date('H:i:s');

		$comptabilite = new Comptabilite();
        $historique = new Historique(); 
		$i = 0;
		if ($comptabilite->versement($idDestination,$reference,$dateversement,$_SESSION['ID_user'],$montant_total))  
		{
			$res = $comptabilite->getMaxIdVersement()->fetch();
			$idversement = $res['ID_versement'];
			
			/*if ($destination == 'banque') 
			{
				if ($comptabilite->augmanterMontantBanque($idDestination,$montant_total)) 
				{
					if ($comptabilite->diminuerMontantGrandeCaisse($montant_total,$monnaie) > 0) 
					{
					}
					if ($comptabilite->setHistoriqueEntrerBanque($idDestination,$montant_total,'payement',$dateversement)) 
					{
					}
					/*if ($comptabilite->versement_banque($idDestination,$idversement)) 
					{
						if ($comptabilite->setHistoriqueEntrerBanque($idDestination,$montant_total,'payement',$dateversement)) 
						{
						}
					}*
				}
			} */
			/*else
			{
				if ($comptabilite->augmenterMontantCaisse($idDestination,$montant_total)) 
				{
					if ($comptabilite->versement_caisse($idDestination,$idversement)) 
					{
						if ($comptabilite->setHistoriqueEntrerCaisse('payement','payement',$montant_total,$monnaie,$idDestination,$dateversement,$iduser_verser)) 
						{
						}
					}
				}
			}*/
			foreach ($paiement as $key => $value) 
			{
				$paiement_tab = preg_split("#[_]+#", $value);
	            $idpaiement = $paiement_tab[0];
	            $i++; 
				
				if ($comptabilite->setPaiement_verser($idpaiement,$idversement)) 
				{
                    if ($comptabilite->updatePayementDeposed($idpaiement,$idDestination,1) > 0) {
                        # code...
                    }
					if ($count_payement == $i) 
					{
                        if ($historique->setHistoriqueAction($idversement,'versement',$_SESSION['ID_user'],$created_at,'creer')) 
                        {
                        }
						require_once('printing/fiches/bordereau_de_versement.php');
					}
				}
			}
		}
	//}
	//else sendMsgError('La destination ne corespond pas aux payement!','banque_de_versement');
	$comptabilite = new Comptabilite();
}
function addPayementToVerssement($verssement_id,$paiement)
{
    $comptabilite = new Comptabilite();

    $versement = $comptabilite->getVersement($verssement_id)->fetch();
    $checkMonnaie = true;
    $montant_total = 0;
    foreach ($paiement as $key => $value) 
    {
        $paiement_array = preg_split("#[_]+#", $value);
        $montant_total += $paiement_array[1];
        if ($paiement_array[2] != $versement['monnaie']) 
        {
            $checkMonnaie = false;
        }
    }
    if ($checkMonnaie) 
    {
        if ($comptabilite->augmenterMontant_dans_versement($verssement_id,$montant_total) > 0) 
        {
            //$i = 0;
            foreach ($paiement as $key => $value) 
            {
                $paiement_tab = preg_split("#[_]+#", $value);
                $idpaiement = $paiement_tab[0];
                //$i++; 
                
                if ($comptabilite->setPaiement_verser($idpaiement,$verssement_id)) 
                {
                    if ($comptabilite->updatePayementDeposed($idpaiement,$versement['ID_banque'],1) > 0) 
                    {
                        # code...
                    }
                    /*if ($count_payement == $i) 
                    {
                        if ($historique->setHistoriqueAction($idversement,'versement',$_SESSION['ID_user'],$created_at,'creer')) 
                        {
                        }
                        require_once('printing/fiches/bordereau_de_versement.php');
                    }*/
                }
            }    
        }
    }
    else
    {
        $_SESSION['message'] = "La monnaie de payement ne coresponde pas à celle de la banque";
    }
    header('location:banque_de_versement');
}
function updateVerssement($idverssement,$idbanque,$monnaie,$reference,$dateversement,$paiement,$deletePayement)
{
    $comptabilite = new Comptabilite();
    $historique = new Historique();

    date_default_timezone_set("Africa/Bujumbura");
    $created_at = date("Y-m-d H:i:s");

    $montant = 0;
    foreach ($paiement as $value) 
    {
        $paiement_array = preg_split("#[_]+#", $value);
        $montant += $paiement_array[1];
    }

    $delete_paiement_array = preg_split("#[_]+#", $deletePayement);

    if ($comptabilite->update_Versement($idverssement,$reference,$dateversement,$idbanque,$montant) > 0) 
    {
        for ($i=0; $i < count($delete_paiement_array); $i++) 
        { 
            if ($comptabilite->delete_from_paiement_verserByIdPayement($delete_paiement_array[$i])) 
            {
                if ($comptabilite->updatePayementDeposed($delete_paiement_array[$i],NULL,0) > 0) 
                {
                    # code...
                }
            }
        }
        if ($historique->setHistoriqueAction($idverssement,'versement',$_SESSION['ID_user'],$created_at,'modifier')) 
        {
            //$return = "ok";
        }
    }
    header('location:banque_de_versement');
}
function sendMsgError($message,$url)
{header('location:'.$url);
}
function versementouvert()
{
	$comptabilite = new Comptabilite();
	require_once 'printing/fiches/versementouvert.php';
}
function printVersement($idversement)
{
	$comptabilite = new Comptabilite();
	require_once('printing/fiches/bordereau_de_versement.php');
}
function inc_banque()
{
    $user = new User();
	$comptabilite = new Comptabilite();
	require_once('vue/admin/finance/banque.php');
}
function inc_caisse()
{
	$comptabilite = new Comptabilite();
	$user = new User();
	require_once('vue/admin/finance/caisse.php');
}
function inc_approvisionnement()
{
	$comptabilite = new Comptabilite();
	$user = new User();
	require_once('vue/admin/finance/approvisionnement.php');
}
function detailbanque($id)
{
	$comptabilite = new Comptabilite();
	require_once('vue/admin/finance/detailbanque.php');
}
function generateBankRepport($date1,$date2,$mois,$annee,$banque)
{
	$mois_en_lettre = [1=>'Janvier',2=>'Fevriel',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];

	$condition1 = null;
    $condition2 = null;
    $condition3 = null;
    $condition4 = null;
    $condition5 = null;
    $condition6 = null;
    $condition7 = null;

    $condition = '';

    if ($date1 == '') 
    {
        $condition1 = '';
    }
    else
    {
        $condition1 = " date_operation='".$date1."' ";
        $dateAvantFiltre = $date1;
        $periode = 'Période du '.$date1;
    }
    if ($date2 == '') 
    {
        $condition2 = '';
    }
    else
    {
        if ($date1 !== '') 
        {
            $condition2 = " date_operation BETWEEN '".$date1."' AND '".$date2."' ";
            $condition1 = '';
            $periode = 'Période du '.$date1.' au '.$date2;
        }
        else
        {
        	$condition2 = " date_operation='".$date2."' ";
        	$dateAvantFiltre = $date2;
        	$periode = 'Période du '.$date2;
        } 
    }
    if ($mois == '') 
    {
        $condition3 = '';
    }
    else
    {
        $condition3 = " MONTH(date_operation)=".$mois." ";
        $dateAvantFiltre = $annee."-".$mois."-01";
        $periode = 'Mois de '.$mois_en_lettre[$mois].' '.$annee;
    }
    if ($annee == '') 
    {
        $condition4 = '';
    }
    else
    {
        $condition4 = " YEAR(date_operation)=".$annee." ";
    }
    $condition7 = " bj.ID_banque=".$banque." ";
    if ($condition1 != '' || $condition2 != '') $condition4 = '';

    $condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
    $condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
    //condition5 = (condition5 == '' ? '' : 'AND' +condition5);
    //condition6 = (condition6 == '' ? '' : 'AND' +condition6);
    $condition7 = ($condition7 == '' ? '' : 'AND' .$condition7);

    $comptabilite = new Comptabilite();
    $user = new User();

	$condition = $condition1.$condition2.$condition3.$condition4.$condition7;
	require_once('printing/fiches/bankReport.php');
}
function detailcaisse($idcaisse)
{
	$comptabilite = new comptabilite();
	$user = new User();
	require_once('vue/admin/finance/detail_caisse.php');
}
function ajoutcompte()
{
	$comptabilite = new Comptabilite();
	require_once('vue/admin/finance/ajoutcompte.php');
}
function inc_transaction()
{
	require_once('vue/admin/finance/transaction.php');
}
function inc_petite_depense()
{
	$comptabilite = new Comptabilite();
	$user = new User();
	require_once'vue/admin/finance/petiteDepense.php';
}
function inc_depense_administrative()
{
	$comptabilite = new Comptabilite();
    $user = new User();
    //$result = $comptabilite->getDepenses();
    $result = $comptabilite->getBanqueJournalCredits();
    $date1 = "";
    $date2 = "";
    $mois = "";
    $annee = "";
    $banque = "";
    $print = "";
	require_once('vue/admin/finance/depense_administrative.php');
}
function filtreDepense($date1,$date2,$mois,$annee,$banque,$print)
{
	$mois_en_lettre = [1=>'Janvier',2=>'Fevriel',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];

	$condition1 = null;
    $condition2 = null;
    $condition3 = null;
    $condition4 = null;
    $condition5 = null;
    $condition6 = null;
    $condition7 = null;

    $condition = '';

    if ($date1 == '') 
    {
        $condition1 = '';
    }
    else
    {
        $condition1 = " date_operation='".$date1."' ";
        $dateAvantFiltre = $date1;
        $periode = 'Période du '.$date1;
    }
    if ($date2 == '') 
    {
        $condition2 = '';
    }
    else
    {
        if ($date1 !== '') 
        {
            $condition2 = " date_operation BETWEEN '".$date1."' AND '".$date2."' ";
            $condition1 = '';
            $periode = 'Période du '.$date1.' au '.$date2;
        }
        else
        {
        	$condition2 = " date_operation='".$date2."' ";
        	$dateAvantFiltre = $date2;
        	$periode = 'Période du '.$date2;
        } 
    }
    if ($mois == '') 
    {
        $condition3 = '';
    }
    else
    {
        $condition3 = " MONTH(date_operation)=".$mois." ";
        $dateAvantFiltre = $annee."-".$mois."-01";
        $periode = 'Mois de '.$mois_en_lettre[$mois].' '.$annee;
    }
    if ($annee == '') 
    {
        $condition4 = '';
    }
    else
    {
        $condition4 = " YEAR(date_operation)=".$annee." ";
    }
    /*if (idcategorie == '') 
    {
        condition5 = '';
    }
    else condition5 = " d.ID_categorie_depense="+idcategorie+" ";
    if (type_categorie == '') 
    {
        condition6 = '';
    }
    else condition6 = " type_categorie='"+type_categorie+"' ";*/
    if ($banque == '') $condition7 = '';
    else $condition7 = " bj.ID_banque=".$banque." ";
    if ($condition1 != '' || $condition2 != '') $condition4 = '';

    $condition1 = ($condition1 == '' ? '' : 'AND' .$condition1);
    $condition2 = ($condition2 == '' ? '' : 'AND' .$condition2);
    $condition3 = ($condition3 == '' ? '' : 'AND' .$condition3);
    $condition4 = ($condition4 == '' ? '' : 'AND' .$condition4);
    //condition5 = (condition5 == '' ? '' : 'AND' +condition5);
    //condition6 = (condition6 == '' ? '' : 'AND' +condition6);
    $condition7 = ($condition7 == '' ? '' : 'AND' .$condition7);

    $comptabilite = new Comptabilite();
    $user = new User();
    if ($print == 0) 
    {
    	$condition = $condition1.$condition2.$condition3.$condition4.$condition7;
    	$result = $comptabilite->filtreDepenses($condition);
    	require_once('vue/admin/finance/depense_administrative.php');
    }
    else
    {
    	$condition = $condition1.$condition2.$condition3.$condition4;
    	require_once('printing/fiches/rapport_depenses.php');
    }
}
function genererPdfRapportDepense($condition)
{
	$comptabilite = new Comptabilite();
	//$mois_en_lettre = [1=>'Janvier',2=>'Fevriel',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
	require_once('printing/fiches/rapport_depenses.php');
}
function genererPdfRapportPetiteDepense($condition)
{
	$comptabilite = new Comptabilite();
	//$mois_en_lettre = [1=>'Janvier',2=>'Fevriel',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
	require_once('printing/fiches/rapportPetiteDepenses.php');
}
function genererPdfSortieCaisse($condition,$idcaisse)
{
	$comptabilite = new Comptabilite();
	require_once('printing/fiches/rapportSortieCaisse.php');
}
function genererPdfEntrerCaisse($condition,$idcaisse)
{
	//echo "condition: ".$condition;
	$comptabilite = new Comptabilite();
	require_once('printing/fiches/rapportEntrerCaisse.php');
}
function genererPdfEntrerBanque($condition,$idbanque)
{
	//echo "condition: ".$condition;
	$comptabilite = new Comptabilite();
	require_once('printing/fiches/rapportEntrerBanque.php');
}
function genererPdfSortieBanque($condition,$idbanque)
{
	//echo "condition: ".$condition;
	$comptabilite = new Comptabilite();
	require_once('printing/fiches/rapportSortieBanque.php');
}
function printHistoriquePayementDette($condition)
{
	$comptabilite = new Comptabilite();
	require_once('printing/fiches/printHistoriquePayementDette.php');
}
function inc_facture_fournisseur()
{
	require_once('vue/admin/finance/facture_fournisseur.php');
}
function extrat()
{	$comptabilite = new Comptabilite();
	require_once('vue/admin/finance/extrat.php');
}
function historique_payt()
{
	require_once('vue/admin/finance/historique_payt.php');
}
function type_extrat()
{
	$comptabilite = new Comptabilite();
	require_once('vue/admin/finance/typeExtrat.php'); 
}
function prevision()
{
    $comptabilite = new Comptabilite();
    $client = new Client();
    $customer_previsions = $client->getClientActifs_avec_mensualite();

    $months = [1=>'JAN',2=>'FEV',3=>'MARS',4=>'AVR',5=>'MAI',6=>'JUI',7=>'JUIL',8=>'AOUT',9=>'SEP',10=>'OCT',11=>'NOV',12=>'DEC'];
    $months_total = [1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
    $start_month = intval(date('m')) + 2;
    $start = date('Y-'.$start_month.'-01');
    $end = date('Y-12-31');
    $datetime1 = new DateTime($start);
    $datetime2 = new DateTime($end);
    $interval = $datetime2->diff($datetime1);
    $nbmonth = $interval->format('%m');
    foreach ($months_total as $key => $value) 
    {
      if ($key < $start_month) 
      {
        unset($months_total[$key]);
      }
      else continue;
    }
    require_once('vue/admin/finance/prevision.php');
}
function prevision_report_print($data)
{
    $months = [1=>'JAN',2=>'FEV',3=>'MARS',4=>'AVR',5=>'MAI',6=>'JUI',7=>'JUIL',8=>'AOUT',9=>'SEP',10=>'OCT',11=>'NOV',12=>'DEC'];
    require_once('printing/fiches/prevision_report.php');
}
function categorieDepense()
{
	$comptabilite = new Comptabilite();
	require_once('vue/admin/finance/categorieDepense.php'); 
}
function creance()
{
	$comptabilite = new Comptabilite();
	require_once('vue/admin/finance/creance.php');  
}
function chiffreAffaire()
{
    $contract = new Contract();
    require_once"printing/fiches/printChiffreAffaire.php";
}



// function to export to csv.


function exportToCSV($billing_number, $nom_client, $date1, $date2, $mois_payement, $mois_facture, $annee, $mode_payement) {
    $comptabilite = new Comptabilite();

    // Build the condition based on the filters
    $condition = ''; // Build your condition string based on the parameters

    // Fetch the data
    $result = $comptabilite->filtrePayement($condition, "paiement p, client cl");

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="paiements.csv"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Add CSV column headers
    fputcsv($output, ['Date paiement', 'Numero', 'Client', 'Montant', 'Taux', 'Montant converti', 'Description']);

    // Loop through the result and write to CSV
    foreach ($result as $data) {
        fputcsv($output, [
            $data->datepaiement,
            $data->numero,
            $data->Nom_client . '-' . $data->billing_number,
            $data->montant . ' ' . $data->devise,
            $data->Taux_change_courant,
            $data->montant_converti . ' ' . $data->exchange_currency,
            $data->methode . '-' . $data->reference
        ]);
    }

    // Close the output stream
    fclose($output);
    exit();
}