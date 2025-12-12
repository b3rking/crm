
<?php
define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
require('fpdf.php');
//define('FPDF_FONTPATH','fpdf/font/');

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
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}
	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++; 
		}
		return $nl;
	}


	function header()
	{
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		//$this->image('printing/fiches/logoajywa.png',15,10,40);
		//$this->setMargins(10,100);
		$this->SetFont('Arial','',14);
		$this->Cell(190,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(5);
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		$this->Cell(60,5,'',0,0,'C');
		$this->SetFont('Arial','B',14);
		$this->Cell(60,5,'RAPPORT DE PAIEMENT',0,1,'C');
        
        $this->Ln(10);
		$this->SetFont('Arial','',10);
		//$this->Cell(70,8,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		$this->Ln(5);
		$this->SetFillColor(204,85,0);
		$this->Cell(22,8,'Date',1,0,'',1);
		$this->Cell(10,8,'ID',1,0,'',1);
		$this->Cell(42,8,'Nom client',1,0,'',1);
		$this->Cell(30,8,'Montant',1,0,'',1);
		$this->Cell(10,8,'Taux',1,0,'',1);
		$this->Cell(30,8,'Montant converti',1,0,'',1);
		$this->Cell(42,8,'Description',1,1,'',1);
		
		//$this->Line(24,40,186,40);
	}
	function footer()
	{	
	}
	function headerTable()
	{
		
		$this->Ln(10);
		$this->SetFont('Arial','',10);
		//$this->Cell(70,8,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		$this->Ln(5);
		$this->SetFillColor(204,85,0);
		$this->Cell(22,8,'Date',1,0,'',1);
		$this->Cell(10,8,'ID',1,0,'',1);
		$this->Cell(42,8,'Nom client',1,0,'',1);
		$this->Cell(30,8,'Montant',1,0,'',1);
		$this->Cell(10,8,'Taux',1,0,'',1);
		$this->Cell(30,8,'Montant converti',1,0,'',1);
		$this->Cell(42,8,'Description',1,1,'',1);
	}
	function viewTable($comptabilite,$condition,$tables)
	{
		$tbMonnaie = ['USD','BIF'];
		$this->SetFont('Arial','',8);
		$total_USD = 0;
		$total_monnaie_locale = 0;
        $paid_amount = 0;
        $taux = 1765;
		foreach ($comptabilite->filtrePayement($condition,$tables) as $value) 
		{
            $thisRate = $value->Taux_change_courant >= 500 ? $value->Taux_change_courant:$taux;
            $paid_amount += (strtolower($value->exchange_currency) == 'bif' ? $value->montant_converti : $value->montant_converti*$thisRate);
//			if ($value->devise == 'USD') 
//				$total_USD += $value->montant;
//			else $total_monnaie_locale += $value->montant;

        	$this->ROW([$value->datepaiement,$value->billing_number,$value->Nom_client.'-'.$value->billing_number,$value->montant.' '.$value->devise,$value->Taux_change_courant,$value->montant_converti.' '.$value->exchange_currency,$value->methode .'-'.$value->reference]);
		}
        $this->SetFont('Arial','B',10);
		$this->Cell(22,8,'Total '.$tbMonnaie[1],1,0);
		$this->Cell(10,8,'',1,0);
		$this->Cell(42,8,'',1,0);
		$this->Cell(30,8,number_format($paid_amount).'_'.$tbMonnaie[1],1,0);
		$this->Cell(10,8,'',1,0);
		$this->Cell(30,8,'',1,0);
		$this->Cell(42,8,'',1,1);
        
//		$this->SetFont('Arial','B',10);
//		$this->Cell(22,8,'Total '.$tbMonnaie[1],1,0);
//		$this->Cell(10,8,'',1,0);
//		$this->Cell(42,8,'',1,0);
//		$this->Cell(30,8,number_format($total_monnaie_locale).'_'.$tbMonnaie[1],1,0);
//		$this->Cell(10,8,'',1,0);
//		$this->Cell(30,8,'',1,0);
//		$this->Cell(42,8,'',1,1);
		
//		$this->Cell(22,8,'Total '.$tbMonnaie[0],1,0);
//		$this->Cell(10,8,'',1,0);
//		$this->Cell(42,8,'',1,0);
//		$this->Cell(30,8,number_format($total_USD).'_'.$tbMonnaie[0],1,0);
//		$this->Cell(10,8,'',1,0);
//		$this->Cell(30,8,'',1,0);
//		$this->Cell(42,8,'',1,1);
	}
}

$pdf = new myPDF();
$pdf->AliasNbPages();
//$pdf->init();
$pdf->AddPage();
//$pdf->headerTable();
$pdf->SetWidths(array(22,10,42,30,10,30,42));
$pdf->viewTable($comptabilite,$condition,$tables);
$pdf->Output();
?>
