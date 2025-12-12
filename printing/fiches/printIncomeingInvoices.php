<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $next_billing_date;

	function init($next_billing_date)
	{
		$date = new DateTime($next_billing_date);
		$this->next_billing_date = $date->format('d-m-Y');
	}
	function getBilingDate()
	{
		return $this->next_billing_date;
	}

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
		//$this->image('printing/fiches/logospnet.png',15,10,50);
		$this->setXY(20,11);
		$this->SetFont('Arial','B',12);
		//$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,'Facturation du '.$this->getBilingDate(),0,1,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,'Generer le '.date('d-m-Y'),0,1,'C');
		//$this->Line(61,30,149,30);
		$this->Ln(4);
		$this->SetFont('Arial','B',9);

		$this->Ln();
        $this->Cell(10,5,'No',1,0,'C');
		$this->Cell(10,5,'Id',1,0,'C');
		$this->Cell(120,5,'Nom client',1,0,'C');
		$this->Cell(40,5,'Montant',1,1,'C');
	}
	function footer()
	{
	    /*$this->Ln();
		$this->SetY(-45);
		//$this->Line(15,262,195,262);
		$this->SetFont('Arial','',8);
		$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', 'N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d\'identification: NO 1928 Conformément a l\'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L\'interruption de la connexion se fait le 3 du mois pour non paiement.'),1,'L');
		$this->SetFont('Arial','B',8);
		$this->Ln();
		$this->Cell(30,4,'N. Comptes',0,1);
		$this->SetFont('Arial','',8);
		$this->Cell(30,4,'KCB - 6690353958 - BIF',0,1);
		$this->Cell(30,4,'KCB - 6690353966 - USD',0,1);*/
	}
	function viewTable($result)
	{
		$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
		$this->SetFont('Arial','',9);
		$total_usd = 0;
		$total_monnaie_locale = 0;
		$tbMonnaie = ['USD','BIF'];
        $i = 0;
		foreach ($result as $value) 
		{
            $i++;
			$montant = round($value->montant);
			$total_usd += ($value->monnaie == 'USD' ? $montant : 0);
			$total_monnaie_locale += ($value->monnaie == 'BIF' ? $montant : 0);

			$this->Row([$i,$value->billing_number,$value->nom_client,number_format($montant).' '.$value->monnaie]);	
		}
		$this->SetFont('Arial','B',9);
		$this->Cell(140,5,'Total '.$tbMonnaie[0],1,0);
		$this->Cell(40,5,number_format($total_usd).'_'.$tbMonnaie[0],1,1);

		$this->Cell(140,5,'Total '.$tbMonnaie[1],1,0);
		$this->Cell(40,5,number_format($total_monnaie_locale).'_'.$tbMonnaie[1],1,0);
	}
} 

$pdf = new myPDF();
$pdf->SetLeftMargin(20);
$pdf->AliasNbPages();
$pdf->init($next_billing_date);
$pdf->AddPage();
//$pdf->headerTable();
$pdf->SetWidths(array(10,10,120,40));
$pdf->viewTable($result);
$pdf->Output();

