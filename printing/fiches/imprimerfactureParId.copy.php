<?php
// Define ROOT if not already defined (project root)
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
}

// FPDF font path
define('FPDF_FONTPATH', ROOT . 'printing' . DIRECTORY_SEPARATOR . 'fiches' . DIRECTORY_SEPARATOR . 'font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
    var $client;
    var $banque;

    function init($client)
    {
        $this->client = $client;
    }
    function getClient()
    {
        return $this->client;
    }
    function setBanque($banque)
    {
        $this->banque = $banque;
    }
    function getBanque()
    {
        return $this->banque;
    }

    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }
    function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 4, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }


    function header()
    {

        $logo = ROOT . 'printing' . DIRECTORY_SEPARATOR . 'fiches' . DIRECTORY_SEPARATOR . 'logospnet.png';
        if (file_exists($logo)) {
            $this->image($logo, 15.0, 10, 40);
        }
        //$this->image('image_profil/702.jpg',5,10,200,280);
        $this->SetFont('Arial', 'B', 10);
        $this->setY(5);

        $this->Cell(60, 5, '', 0, 0, 'C');
        //$this->Cell(60,10,'FACTURE No '.$this->getFactureId().'  du '.date('d-m-Y'),0,1,'C');
        //$this->Line(61,30,149,30);
    }
    function footer()
    {
        $client = $this->getClient();
        $this->Ln();
        /*if ($client['tvci'] > 0) 
	    {
	    	$this->SetY(-85);
		    $this->SetFont('Arial','B',8);
		    $this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', "N.B :TCCV, veut dire taxe collectee sur les capacites vendues (cfr O.M No 540/997/2021 du 02/09/21)"),0,'L');
	    }*/

        $this->SetY(-60);
        //$this->Line(15,262,195,262);
        $this->SetFont('Arial', '', 8);
        if ($client['show_rate'] == 1)
            $this->MultiCell(180, 5, iconv('UTF-8', 'windows-1252', "N.B : Payable au taux vendeur du jour de la BRB: " . $client['exchange_rate'] . "\n Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d'identification: NO " . $client['billing_number'] . " Conformément a l'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L'interruption de la connexion se fait le 3 du mois pour non paiement."), 1, 'L');
        else
            $this->MultiCell(180, 5, iconv('UTF-8', 'windows-1252', "N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d'identification: NO " . $client['billing_number'] . " Conformément a l'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L'interruption de la connexion se fait le 3 du mois pour non paiement."), 1, 'L');

        $this->SetFont('Arial', 'B', 8);
        $this->Ln();
        $this->Cell(30, 4, 'N. Comptes', 0, 1);
        $this->SetFont('Arial', '', 8);
        $y = $this->GetY();
        foreach ($this->getBanque() as $value) {
            if ($this->GetY() == 277.00008333333)
                $this->SetXY(60, $y);
            $this->Cell(60, 4, $value->nom . ' - ' . $value->numero . ' ' . $value->monnaie, 0, 1);
        }
    }
    function headerTable()
    {
        $this->Ln(10);
    }
    function viewTable($contract, $facture_id)
    {
        $client = $this->getClient();
        $this->Cell(180, 5, 'Facture No ' . $client['numero'] . ' du ' . $client['date_creation'], 0, 1, 'C');
        $this->Ln(10);

        $this->Cell(60, 5, 'A. Identification du Vendeur', 0, 1);
        $this->Ln(3);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(100, 5, 'Raison Sociale: SPIDERNET S.A', 0, 0);
        $this->SetFont('Arial', '', 9);
        $this->Cell(70, 5, 'Centre Fiscal: 19747', 0, 1, 'L');
        $this->Cell(100, 5, 'NIF: 4000000408', 0, 0);
        $this->Cell(70, 5, iconv('UTF-8', 'windows-1252', 'Secteur d\'activité: TELECOMMUNICATION'), 0, 1, 'L');
        $this->Cell(100, 5, 'Registre de Commerce NO 67249', 0, 0);
        $this->Cell(70, 5, 'Forme Juridique: SA', 0, 1, 'L');
        $this->Cell(60, 5, iconv('UTF-8', 'windows-1252', 'BP: 1638 Tél: (257) 65900006/76004400'), 0, 1);
        $this->Cell(70, 5, 'Commune: MUKAZA Quartier: ASIATIQUE', 0, 1);
        $this->Cell(60, 5, 'Rue kirundo no 6', 0, 1);
        $this->Cell(60, 5, iconv('UTF-8', 'windows-1252', 'Assujetti à la Tva : ') . ucfirst($client['assujettiTVA']), 0, 1);
        //        $this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la Tva: Oui'),0,1);

        $i = 0;
        $prixU = 0;
        //$PU = 0;
        //$prixU_sousTotal = 0;
        $totalTva = 0;
        $totalTvci = 0;
        //$tolalTva_sousTotal = 0;
        //$totalTTC = 0;
        //$totalTTC_sousTotal = 0;
        $mois = [1 => 'janvier', 2 => 'fevrier', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'aout', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'decembre'];
        $ligne1 = array();
        $showLines = array();
        $notShow = false;
        $monnaie = '';
        $next_billing_month = '';
        $next_billing_year = '';
        $totalprixU = 0;
        $totalPrixTva = 0;
        $totalPrixTvci = 0;
        //$billing_cycle = 0;



        //$this->Cell(60,5,'B. Le Client',0,1);
        $this->Ln(3);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 5, 'B. Le Client', 0, 1);
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 5, 'Raison Sociale: ' . iconv('UTF-8', 'windows-1252', $client['nom_client']), 0, 1);
        //$this->Ln(3);
        $this->Cell(60, 5, 'NIF : ' . $client['nif'], 0, 1);
        //$this->Ln(3);
        $this->Cell(60, 5, iconv('UTF-8', 'windows-1252', 'Résident à : ' . $client['adresse']), 0, 1);
        //$this->Ln(3);


        $this->SetFont('Arial', '', 9);
        $this->Ln(5);


        $this->SetFont('Arial', 'B', 8);
        //$this->Cell(110,5,'Doit ce qui suit:',0,1);
        //		$this->Ln();
        //		$this->Cell(40,5,'Libelle',1,0,'C');
        //		$this->Cell(20,5,'Quantite',1,0,'C');
        //		$this->Cell(20,5,'PU',1,0,'C');
        //		$this->Cell(20,5,'Total PU',1,0,'C');
        //		$this->Cell(20,5,'TVA',1,0,'C');
        //		//$this->Cell(25,5,'TCCV',1,0,'C');
        //		$this->Cell(25,5,'TTC',1,1,'C');
        if (strtolower($client['exchange_currency']) == 'usd' && strtolower($client['monnaie']) != 'bif')
            $this->Row(['Libelle', 'Quantite', 'PU', 'Total PU', 'TVA', 'TVAC']);
        else
            $this->Row(['Libelle', 'Quantite', 'PU', 'Total PU', 'TVA', 'TVAC']);

        foreach ($contract->recupererFactureToPrint($facture_id) as $value2) {
            $i++;
            //$JourDePlus = $value2->JourDePlus;
            //$montantJourDePlus = $value2->montantJourDePlus;
            //$prixTva = $value2->montant_total/100*$value2->tva;
            //$tolalTva += $prixTva;
            $tva = $value2->tva;
            $tvci = $value2->tvci;
            $creation_mode = $value2->creation_mode;
            $rediction = $value2->rediction;
            $enable_discounts = $value2->enable_discounts;
            if ($value2->fixe_rate == 1 and $value2->monnaie != $value2->exchange_currency and $value2->monnaie == 'USD') {
                $prixTva = $value2->montant_tva * $value2->exchange_rate;
                $prixTvci = $value2->montant_tvci * $value2->exchange_rate;
                //$tolalTva += $prixTva;
                //$totalHTVA = $value2->montant*$value2->quantite;
                $prixU = $value2->montant * $value2->exchange_rate;
                //$sousTotalPrixU = $value2->montant_total*$value2->exchange_rate;
                //$prixTTC = $value2->montant_total*$value2->exchange_rate;
                //$totalTTC += $prixTTC;
                $monnaie = $value2->exchange_currency;
            } else {
                $prixTva = $value2->montant_tva;
                $prixTvci = $value2->montant_tvci;

                $prixU = $value2->montant;
                //$prixTTC = $value2->montant_total;
                //$totalTTC += $prixTTC;
                $monnaie = $value2->monnaie;
            }
            $prixU = $prixU;
            $prixTva = $prixTva;
            // $prixTva = round($prixTva);
            $totalTva += $prixTva;
            $totalTvci += $prixTvci;
            //$totalTTC += $prixTTC;
            $Libelle = "";
            $Lib = "";
            $quantite;

            $this->SetFont('Arial', '', 7);

            if ($value2->billing_cycle == 0) {
                $Libelle .= str_replace(";", "\n", $value2->description);
                $quantite = $value2->quantite . ' Jours';
                //$sousTotalPrixU = $prixU - $prixTva;
                //$sousTotalPrixU = $value2->montant_total;
                //$totalprixU += $sousTotalPrixU;
                $totalprixU += $prixU;

                $totalPrixTva += $prixTva;
                $totalPrixTvci += $prixTvci;
                //$prixTTC = $sousTotalPrixU + $prixTva;
                $prixTTC = $prixU + $prixTva + $prixTvci;
                //$ligne1 = [$Libelle,$quantite,number_format($prixU/$value2->quantite).' '.$monnaie,number_format($prixU).' '.$monnaie,number_format($prixTva).' '.$monnaie,number_format($prixTvci).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
                if (strtolower($monnaie) == 'usd')
                    $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle), $quantite, number_format($prixU / $value2->quantite) . ' ' . $monnaie, number_format($prixU) . ' ' . $monnaie, number_format($prixTva) . ' ' . $monnaie, number_format($prixTTC) . ' ' . $monnaie, number_format($prixTTC * $client['exchange_rate']) . ' BIF'];
                else
                    $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle), $quantite, number_format($prixU / $value2->quantite) . ' ' . $monnaie, number_format($prixU) . ' ' . $monnaie, number_format($prixTva) . ' ' . $monnaie, number_format($prixTTC) . ' ' . $monnaie];
                $this->Row($ligne1);
            } elseif ($value2->billing_cycle == 2) {

                $Libelle .= str_replace(";", "\n", $value2->description);
                $Libelle = iconv('UTF-8', 'windows-1252', $Libelle);


                $sousTotalPrixU = $prixU; //* $value2->quantite;

                $prixTvaShow = $prixTva + $prixTvci;
                /*if ($JourDePlus > 0) 
				{
					$quantite = $value2->quantite.' Mois + '.$JourDePlus.' jours';
				}
				else*/
                $quantite = ($value2->billing_cycle == 1 ? $value2->quantite . ' Mois' : $value2->quantite);

                $totalprixU += $sousTotalPrixU;
                $totalPrixTva += $prixTva;
                $totalPrixTvci += $prixTvci;
                //$prixTTC = ($creation_mode == 'mail' ? $sousTotalPrixU + $prixTvci : $sousTotalPrixU + $prixTva + $prixTvci);
                $prixTTC = $sousTotalPrixU + $prixTva + $prixTvci;


                if (strtolower($monnaie) == 'usd')
                    $ligne1 = [$Libelle, $quantite, number_format($prixU) . ' ' . $monnaie, number_format($sousTotalPrixU) . ' ' . $monnaie, number_format($prixTvaShow) . ' ' . $monnaie, number_format($prixTTC) . ' ' . $monnaie, number_format($prixTTC * $client['exchange_rate']) . ' BIF'];
                else
                    $ligne1 = [$Libelle, $quantite, number_format($prixU) . ' ' . $monnaie, number_format($sousTotalPrixU) . ' ' . $monnaie, number_format($prixTvaShow) . ' ' . $monnaie, number_format($prixTTC) . ' ' . $monnaie];

                $this->Row($ligne1);

                if ($rediction > 0) {
                    $prixReduction = $sousTotalPrixU * $rediction / 100;
                    //$prixTvaReduction = ($creation_mode == 'mail' ? 0 : $prixTva * $rediction/100);
                    $prixTvaReduction = $prixTva * $rediction / 100;
                    $prixTvciReduction = $prixTvci * $rediction / 100;
                    $prixTaxeReduction = $prixTvaReduction + $prixTvciReduction;
                    $totalReduction = $prixReduction + $prixTaxeReduction;

                    $totalprixU -= $prixReduction;
                    $totalPrixTva -= $prixTvaReduction;
                    $totalPrixTvci -= $prixTvciReduction;

                    if (strtolower($monnaie) == 'usd')
                        $this->Row(['Reduction de ' . $rediction . ' %', '', '', '-' . number_format($prixReduction) . ' ' . $monnaie, '-' . number_format($prixTaxeReduction) . ' ' . $monnaie, '-' . number_format($totalReduction) . ' ' . $monnaie, number_format($totalReduction * $client['exchange_rate']) . ' BIF']);
                    else
                        $this->Row(['Reduction de ' . $rediction . ' %', '', '', '-' . number_format($prixReduction) . ' ' . $monnaie, '-' . number_format($prixTaxeReduction) . ' ' . $monnaie, '-' . number_format($totalReduction) . ' ' . $monnaie]);
                }
            } else {
                //$next_billing_month = $value2->mois_fin;
                //$next_billing_year = $value2->annee_fin;
                $Libelle .= str_replace(";", "\n", $value2->description);
                $Libelle = iconv('UTF-8', 'windows-1252', $Libelle);

                //$sousTotalPrixU = ($creation_mode == 'mail' ? $sousTotalPrixUModeMail : $prixU * $value2->quantite);
                $sousTotalPrixU = $prixU * $value2->quantite;
                //$prixTvaShow = ($value2->creation_mode == 'mail' ? 0 : $prixTva);
                $prixTvaShow = $prixTva + $prixTvci;
                /*if ($JourDePlus > 0) 
				{
					$quantite = $value2->quantite.' Mois + '.$JourDePlus.' jours';
				}
				else*/
                $quantite = ($value2->billing_cycle == 1 ? $value2->quantite . ' Mois' : $value2->quantite);

                $totalprixU += $sousTotalPrixU;
                $totalPrixTva += $prixTva;
                $totalPrixTvci += $prixTvci;
                //$prixTTC = ($creation_mode == 'mail' ? $sousTotalPrixU + $prixTvci : $sousTotalPrixU + $prixTva + $prixTvci);
                $prixTTC = $sousTotalPrixU + $prixTva + $prixTvci;


                if (strtolower($monnaie) == 'usd')
                    $ligne1 = [$Libelle, $quantite, number_format($prixU) . ' ' . $monnaie, number_format($sousTotalPrixU) . ' ' . $monnaie, number_format($prixTvaShow) . ' ' . $monnaie, number_format($prixTTC) . ' ' . $monnaie];
                else
                    $ligne1 = [$Libelle, $quantite, number_format($prixU) . ' ' . $monnaie, number_format($sousTotalPrixU) . ' ' . $monnaie, number_format($prixTvaShow) . ' ' . $monnaie, number_format($prixTTC) . ' ' . $monnaie];

                $this->Row($ligne1);

                if ($rediction > 0) {
                    $prixReduction = $sousTotalPrixU * $rediction / 100;
                    //$prixTvaReduction = ($creation_mode == 'mail' ? 0 : $prixTva * $rediction/100);
                    $prixTvaReduction = $prixTva * $rediction / 100;
                    $prixTvciReduction = $prixTvci * $rediction / 100;
                    $prixTaxeReduction = $prixTvaReduction + $prixTvciReduction;
                    $totalReduction = $prixReduction + $prixTaxeReduction;

                    $totalprixU -= $prixReduction;
                    $totalPrixTva -= $prixTvaReduction;
                    $totalPrixTvci -= $prixTvciReduction;

                    if (strtolower($monnaie) == 'usd')
                        $this->Row(['Reduction de ' . $rediction . ' %', '', '', '-' . number_format($prixReduction) . ' ' . $monnaie, '-' . number_format($prixTaxeReduction) . ' ' . $monnaie, '-' . number_format($totalReduction) . ' ' . $monnaie]);
                    else
                        $this->Row(['Reduction de ' . $rediction . ' %', '', '', '-' . number_format($prixReduction) . ' ' . $monnaie, '-' . number_format($prixTaxeReduction) . ' ' . $monnaie, '-' . number_format($totalReduction) . ' ' . $monnaie]);
                }
            }
        }

        $totalPrixTvaShow = $totalPrixTva + $totalPrixTvci;
        //$totalTTC = ($creation_mode == 'mail' ? $totalprixU + $totalPrixTvci : $totalprixU + $totalPrixTva + $totalPrixTvci);
        $totalTTC = $totalprixU + $totalPrixTva + $totalPrixTvci;
        $this->SetFont('Arial', 'B', 8);
        //		$this->Cell(50,5,'Total',1,0,'L');
        //		$this->Cell(20,5,'',1,0,'C');
        //		$this->Cell(25,5,'',1,0,'C');
        //		$this->Cell(25,5,number_format($totalprixU).' '.$monnaie,1,0,'L');
        //		$this->Cell(25,5,number_format($totalPrixTvaShow).' '.$monnaie,1,0,'L');
        //		//$this->Cell(25,5,number_format($totalPrixTvci).' '.$monnaie,1,0,'L');
        //		$this->Cell(25,5,number_format($totalTTC).' '.$monnaie,1,1,'L');

        if (strtolower($client['exchange_currency']) == 'usd' && strtolower($client['monnaie']) != 'bif')
            $this->Row(['Total', '', '', number_format($totalprixU) . ' ' . $monnaie, number_format($totalPrixTvaShow) . ' ' . $monnaie, number_format($totalTTC) . ' ' . $monnaie]);
        else
            $this->Row(['Total', '', '', number_format($totalprixU) . ' ' . $monnaie, number_format($totalPrixTvaShow) . ' ' . $monnaie, number_format($totalTTC) . ' ' . $monnaie]);

        //$this->setXY(15,180); 
        $this->SetFont('Arial', '', 8);
    }
}
