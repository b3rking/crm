<?php
define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
require('fpdf.php');


/**
 * 
 */
class myPDF extends FPDF
{
	var $data;

	function init($data)
	{
		$this->data = $data; 
	}
	function getData()
	{
		return $this->data;
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
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		//$this->image('printing/fiches/logoajywa.png',15,10,40);
		//$this->setMargins(10,100);
		$this->SetFont('Arial','',14);
		// $this->Cell(145,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(5);
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		$this->Cell(40,5,'',0,0,'C');
		$this->SetFont('Arial','B',14);
		$this->Cell(10,4,'RAPPORT DE LA FACTURATION ',0,1,'C');
		
		$data = $this->getData();
		$this->SetFont('Arial','',12);
		$this->Cell(80,8,'Generer le '.$data['created_at'], 0,1,'C');
		$this->Ln(20);
	}
	function footer()
	{	
	}
	function headerTable()
	{
		/*$this->setMargins(50,100);
		$this->Ln(10);
		$this->SetFont('Arial','',12);
		$this->Cell(70,8,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		$this->Ln(5);
		$this->Cell(28,8,'DATE',1,0);
		$this->Cell(34,8,'BIF',1,0);
		$this->Cell(28,8,'USD',1,1);
		*/
       
	}

	function viewTable()
	{
		$data = $this->getData();
		$mois = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
		// $invoices_amount
		// $delinquent
		// $total_solde
		// $paid_amount
		// $remains_to_be_collected

		$this->Cell(40,8,'Facturation '.$data['id'],1,0);
		$this->Cell(42,8,number_format($data['invoices_amount'],2).' BIF',1,1);

		$this->Cell(40,8,'Delinquent ',1,0);
		$this->Cell(42,8,number_format($data['delinquent'],2).' BIF',1,1);
		
		$this->Cell(40,8,'Total',0,0);
		$this->Cell(42,8,number_format($data['total_solde'],2).' BIF',0,1);
		// $this->Ln(20);
		$this->Cell(40,8,iconv('UTF-8', 'windows-1252', 'Facture payeé'),1,0);
		$this->Cell(42,8,number_format($data['paid_amount'],2).' BIF',1,1);

		$this->Cell(40,8,iconv('UTF-8', 'windows-1252', 'Montant à collecter : '),0,0);
		$this->Cell(42,8,number_format($data['remains_to_be_collected'],2).' BIF',0,1);

	}
}

$pdf = new myPDF();
$pdf->SetLeftMargin(60.0);
$pdf->AliasNbPages();
$pdf->init($result);
$pdf->AddPage();
//$pdf->headerTable();
// $pdf->SetWidths(array(28,34,28));
$pdf->viewTable();
$pdf->Output();

?>
