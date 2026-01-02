<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH', ROOT . '/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{


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
        $h = 5 * $nb;
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
            $this->MultiCell($w, 5, $data[$i], 0, $a);
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
        //$this->image('printing/fiches/logospnet.png',15,10,50);
        $this->setXY(20, 11);
        $this->SetFont('Arial', 'B', 12);
        //$this->Ln(15);
        $this->Cell(60, 5, '', 0, 0, 'C');
        $this->Cell(60, 5, 'Raport de contrat', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 5, '', 0, 0, 'C');
        $this->Cell(60, 5, 'Generer le ' . date('d-m-Y'), 0, 1, 'C');
        //$this->Line(61,30,149,30);
        $this->Ln(4);
        $this->SetFont('Arial', 'B', 9);

        $this->Ln();
        $this->Cell(10, 5, '#', 1, 0, 'C');
        $this->Cell(10, 5, 'Id', 1, 0, 'C');
        $this->Cell(80, 5, 'Nom client', 1, 0, 'C');
        $this->Cell(25, 5, 'Date de creation', 1, 0, 'C');
        $this->Cell(30, 5, 'Mensualite', 1, 0, 'C');
        $this->Cell(20, 5, 'Monnaie', 1, 1, 'C');
    }
    function viewTable($contract, $result)
    {
        $mois = [1 => 'janvier', 2 => 'fevrier', 3 => 'mars', 4 => 'avril', 5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'aout', 9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'decembre'];
        $this->SetFont('Arial', '', 9);
        $total_usd = 0;
        $total_monnaie_locale = 0;
        $tbMonnaie = ['USD', 'BIF'];
        $i = 0;
        foreach ($result as $value) {
            $montant_total = 0;
            $i++;

            foreach ($contract->getServiceToPrintToContract($value->ID_contract) as $value2) {
                if ($value2->status == 0) {
                    $montant = $value2->montant * $value2->quantite;
                    $prixTva = $montant * $value->tva / 100;
                    $montant_total += $montant + $prixTva;
                }
            }
            if (strtoupper($value->monnaie) == 'USD') $total_usd += $montant_total;
            else $total_monnaie_locale += $montant_total;

            $this->Row([$i, $value->billing_number, $value->Nom_client, date('d-m-Y', strtotime($value->date_creation)), number_format($montant_total), $value->monnaie]);
        }
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(175, 5, 'Total USD: ' . number_format($total_usd), 1, 1);

        $this->Cell(175, 5, 'Total BIF: ' . number_format($total_monnaie_locale), 1, 0);
    }
}

$pdf = new myPDF();
$pdf->SetLeftMargin(20.0);
$pdf->AliasNbPages();
//$pdf->init();
$pdf->AddPage();
//$pdf->headerTable();
$pdf->SetWidths(array(10, 10, 80, 25, 30, 20));
$pdf->viewTable($contract, $result);
$pdf->Output();
