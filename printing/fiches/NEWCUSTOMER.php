<?php
define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $widths;
	var $aligns;
	var $title;

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
	function setTitre($t)
	{
		$this->title = $t;
	}
	function getTitle()
	{
		return $this->title;
	}
	function header()
	{$tab_mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
		//$this->image('printing/fiches/logospnet.png',15,10,50);
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		$this->setXY(20,11);
		$this->SetFont('Arial','B',12);
		//$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,$this->getTitle(),0,1,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,'Generer le '.date('d-m-Y'),0,1,'C');
		//$this->Line(61,30,149,30);
		$this->Ln(4);
		$this->SetFont('Arial','B',9);

		$this->Ln();
		$this->Cell(10,5,'#',1,0,'C');
		$this->Cell(20,5,'Mois',1,0,'C');
		$this->Cell(30,5,'Date contrat',1,0,'C');
		$this->Cell(30,5,'Billing number',1,0,'C');
		$this->Cell(60,5,'Nom client',1,0,'C');
		$this->Cell(30,5,'Etat',1,1,'C');
	}
	function footer()
	{
		$this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

	}
	function viewTable($res,$tab_mois,$mois)
	{
		//$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
		$this->SetFont('Arial','',8);
	$cpt = 0;
		foreach ($res as $value1) 
		{$cpt++;
			
			$this->Row([$cpt,$tab_mois[$mois],$value1->date_creation,$value1->billing_number,$value1->Nom_client,$value1->etat]);	
		}
		


	}
} 

$pdf = new myPDF();
$pdf->SetLeftMargin(10.0);
$pdf->AliasNbPages();
$pdf->setTitre($title);
$pdf->AddPage();
//$pdf->headerTable();
$pdf->SetWidths(array(10,20,30,30,60,30));
$pdf->viewTable($res,$tab_mois,$mois);
$pdf->Output();
?>
