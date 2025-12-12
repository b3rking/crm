<?php
///define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spi.uva/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $mois;
	var $annee;
	//var $idUser;
	//var $date_debut;
	//var $date_fin;
	
	function init($mois,$annee/*,$idUser,$date_debut,$date_fin*/)
	{
		$this->mois = $mois;
		$this->annee = $annee;
		//$this->idUser = $idUser;
		//$this->date_debut = $date_debut;
		//$this->date_fin = $date_fin;
	}
	function getMois()
	{
		return $this->mois;
	}
	function getAnnee()
	{
		return $this->annee;
	}
	function getIdUser()
	{
		return $this->idUser;
	}
	function getDateDebut()
	{
		return $this->date_debut;
	}
	function getDateFin()
	{
		return $this->date_fin;
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
		//$this->image('printing/fiches/logoajywa.png',15,10,30);
		$this->setY(20);
		//$this->Cell(60,5, 'Le '.date('Y-m-d'),0,0,'R');
		$this->Cell(60,5,'',0,0,'C');
		$this->SetFont('Arial','B',12);
		$this->Cell(70,5,'Rapport d\'entrees de la banque',0,0,'C');
		$this->Cell(50,5,'Le '.date("d-m-Y"), 0,1,'R');
		
		//$this->Line(24,40,186,40);
	}
	function footer()
	{	
	}
	function headerTable($comptabilite,$idbanque)
	{
		$this->setMargins(15,100);
		$this->Ln(15);
		$this->SetFont('Arial','',12);
		//$this->Cell(105,8,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		$this->Cell(60,5,'',0,0);
		$this->Cell(70,5,'Banque: '.$comptabilite->getNomBanque($idbanque)->fetch()['nom'],0,0);
		$this->Ln();
		$this->Cell(10,5,'#',1,0);
		$this->Cell(22,5,'DATE',1,0);
		$this->Cell(30,5,'MONTANT',1,0);
		$this->Cell(110,5,'PROVENANCE',1,1);
	}
	function viewTable($comptabilite,$condition)
	{
		$total = 0;
		$monnaie ;
		$this->SetFont('Arial','',10);
		$i =0;
		foreach ($comptabilite->filtreEntrerBanque($condition) as $value) 
		{
			$i++;
			$total +=$value->montantVersser;
			$monnaie = $value->monnaie;
			$this->Row([$i,$value->date_creation,$value->montantVersser.' '.$value->monnaie,$value->provenance]);
		}
		$this->SetFont('Arial','B',10);
		$this->Cell(172,5,'Total :  '.$total.' '.$monnaie,1,0);
	}
}

$pdf = new myPDF();
$pdf->AliasNbPages();
//$pdf->init($mois,$annee);
$pdf->AddPage();
$pdf->headerTable($comptabilite,$idbanque);
$pdf->SetWidths(array(10,22,30,110));
$pdf->viewTable($comptabilite,$condition);
$pdf->Output();
?>
