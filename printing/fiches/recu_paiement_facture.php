<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $nomClient;
	var $dateRecu;
	var $billingNumber;


	function init($nomClient,$dateRecu,$billingNumber)
	{
		$this->nomClient = $nomClient;
		$this->dateRecu = $dateRecu;
		$this->billingNumber = $billingNumber;
	}
	
	function getNomClient()
	{
		return $this->nomClient;
	}
	function getDateRecu()
	{
		return $this->dateRecu;
	}
	function getBilling()
	{
		return $this->billingNumber;
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
		$h=10*$nb;
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
			$this->MultiCell($w,10,$data[$i],0,$a);
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

		$this->setY(10);
		$this->setMargins(15,100);
		$this->SetFillColor(204,85,0);
		$this->SetFont('Arial','B',12);
		$this->Ln(8);
		$this->Cell(60,5,$_SESSION['nomSociete'],0,1,'B');
		$this->Ln(5);
		$this->SetFont('Arial','',12);
		$this->Cell(100,5,$_SESSION['nomSociete'].' '.$_SESSION['adresse'] ,0,0);
		$this->Cell(100,5,' ',0,1);
		$this->Cell(60,5,'',0,0);
		$this->Ln();
		$this->SetFont('Arial','B',12);
		$this->Cell(60,5,'Recu NO :  ' .$this->getBilling() .'/'.  date('Ymd'),0,1,1);
		$this->Ln(5);
		$this->SetFont('Arial','',12);
		$this->Cell(100,5,'B.P.  1638 Bujumbura',0,0);
		$this->Cell(20,5,'',0,0);
		$this->SetFont('Arial','B',10);
		$this->Cell(100,5,'Date paiement   :   '  . $this->getDateRecu(),0,1);
		$this->Ln(5);
		$this->SetFont('Arial','B',10);
		$this->Cell(100,5,'R.C. 67249',0,1);
		//$this->Cell(60,5,'',0,0);
		$this->Cell(100,5,'NIF : 4000000408',0,0);
		//$this->Cell(60,5,'',0,0);
	
		$this->SetFont('Arial','B',12);
		$this->MultiCell(80,5,'CLIENT : '. $this->getNomClient(),0,'C');
		//$this->Cell(100,5,'Client          :     '  . $this->getNomClient(),0,1);

		$this->Ln(5); 
		$this->SetFont('Arial','',12);
		//$this->Cell(60,5,'RCCM /14-A-0-0811',0,1);
		$this->Ln(5);
		$this->Cell(60,5,'Tel :(+257)22 25 84 80 - 22258480',0,1);
		$this->Cell(60,5,'     (+257)71 32 03 20',0,1);
		$this->Cell(60,5,'     (+257)75 99 00 00',0,1);
		$this->Cell(60,5,'     (+257)76 00 44 00',0,1);
		$this->Ln(5);
		$this->Cell(60,5,'www.spidernet-bi.com',0,1);
		$this->Ln(20);
		

	}
	function footer()
	{
		//$this->SetY(-55);
	    $this->Cell(160,5, $_SESSION['userName'], 0,0,'R');
		$this->SetY(-20);
		$this->Line(15,275,195,275);
		$this->SetFont('Arial','',7);
		$this->Cell(180,5,$_SESSION['nomSociete'].' '.$_SESSION['adresse'].' Tel :'.$_SESSION['telephone'].' email : '.$_SESSION['email'].' RC :  67249 '.' NIF : 4000000408',0,1,'C');
	}
	function headerTable()
	{
		$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->Cell(110,8,'Designation',1,0,'C');
		$this->Cell(70,8,'Montant paye',1,1,'C');
	}
	function viewTable($recuData)
	{
		foreach ($recuData as $value) 
		{
            $tva = $value->tva;
			$methode = $value->methode;
			$devise = $value->devise;
			$total = $value->montant;
			$sousTotal = $total / 1.18;
			$taxe = $total - $sousTotal;
			$this->SetFont('Arial','',10,'R');
			//$this->Cell(110,25,iconv('UTF-8', 'windows-1252', $value->reference.' '.$value->methode),1,0);
			//$this->Cell(110,25,$value->reference.' '.$value->methode,1,0);
			if ($tva > 0) 
			{
				//$this->Cell(70,25,round($sousTotal).' '.$value->devise,1,1,'C');
				$this->Row([$value->reference,round($sousTotal).' '.$value->devise]);
			}
			else
			//$this->Cell(70,25,round($total).' '.$value->devise,1,1,'C');
			$this->Row([$value->reference,round($total).' '.$value->devise]);

			//$this->Row([$value->reference .' '. $value->methode,round($sousTotal).' '.$value->devise]);
			$nom_user = $value->nom_user;
		}
		if ($tva > 0) 
		{
			$this->Cell(110,10,'Sous total',0,0,'R');
			$this->Cell(70,10,round($sousTotal) . ' '. $value->devise,1,1,'R');
			$this->Cell(110,10,'TCI',0,0,'R');
			$this->Cell(70,10,$tva.' %',1,1,'R');
			$this->Cell(110,10,'Taxe',0,0,'R');
			$this->Cell(70,10,round($taxe).' '.$devise,1,1,'R');
		}
		$this->Cell(110,10,'Total',0,0,'R');
		$this->Cell(70,10,round($total) . ' '. $devise,1,1,'R');
		$this->Cell(110,10,'Mode de paiement',0,0,'R');
		$this->Cell(70,10,$methode,1,1,'R');
		$this->Ln(25);
		$this->Cell(160,5,iconv('UTF-8', 'windows-1252', 'Caissière: '.$nom_user), 0,0,'R');
	}
}

$pdf = new myPDF();
$pdf->SetLeftMargin(15);
$pdf->AliasNbPages();
$pdf->init($nomClient,$dateRecu,$billingNumber);
$pdf->AddPage();
$pdf->SetWidths(array(110,70));
$pdf->headerTable();
$pdf->viewTable($recuData);
$pdf->Output();
?>
