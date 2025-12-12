<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $action;
	var $coupure_id;
	//var $mois;
	//var $annee;

	function init($action,$coupure_id)
	{
		$this->action = $action;
		$this->coupure_id = $coupure_id;
		//$this->mois = $mois;
		//$this->annee = $annee;
	}
	function getAction()
	{
		return $this->action;
	}
	function get_coupure_id()
	{
		return $this->coupure_id;
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
		//$this->setMargins(15,100);
		$this->SetFont('Arial','B',12);
		$this->Cell(60,5,'',0,1,'C');
		$this->Cell(60,5,'SPIDERNET s.a ',0,0,'L');
		$this->Cell(100,5,'Date '.date('d-m-Y'),0,1,'R');
		$this->Ln();
		$this->Cell(150,5,iconv('UTF-8', 'windows-1252', 'Liste des clients à '.$this->getAction()),0,0,'C');
		$this->Ln(10);
		$this->SetFont('Arial','B',10);
		$this->Cell(50,5,'',0,0);
		$this->Cell(60,5,'');
		$this->Ln();
		$this->Cell(10,7,'#',1,0);
		$this->Cell(10,7,'ID',1,0);
		$this->Cell(70,7,'Client ', 1,0);
		//$this->Cell(27,7,'Montant', 1,0);
		$this->Cell(27,7,'Action', 1,0);
		$this->Cell(37,7,'Observation', 1,1);
	}
	function footer()
	{
	    $this->Ln();
		$this->SetY(-25);
		$this->Line(15,272,195,272);
		$this->SetFont('Arial','',8);
		$this->Cell(170,5,'SPIDERNET s.a quartier asiatique rue kirundo Numero 06 B.P 1638 Bujumbura Burundi',0,1,'C');
		$this->Cell(170,5,'TEL: 257 22 25 84 80 257 22 25 84 81 Fax: 25722258428 info@spidernet-bi.com',0,1,'C');
	}
	function headerTable()
	{
		//$month_etiquete = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
		$this->Ln(10);
		$this->SetFont('Arial','B',10);
		$this->Cell(50,5,'',0,0);
		$this->Cell(60,5,'');
		$this->Ln();
		$this->Cell(10,7,'#',1,0);
		$this->Cell(10,7,'ID',1,0);
		$this->Cell(70,7,'Client ', 1,0);
		//$this->Cell(27,7,'Montant', 1,0);
		$this->Cell(27,7,'Action', 1,0);
		$this->Cell(37,7,'Observation', 1,1);
	}
	function viewTable($contract)
	{
		$this->SetFont('Arial','',10);
		$i=0;
		foreach ($contract->detailCoupure($this->getAction(),$this->get_coupure_id()) as $value) 
		{
			$i++;
			$this->Row([$i,$value->billing_number,$value->nom_client,$value->action,$value->comment]);
		}
	}
}

$pdf = new myPDF();
$pdf->SetLeftMargin(15.2);
$pdf->AliasNbPages();
$pdf->init($action,$coupure_id);
$pdf->AddPage();
//$pdf->headerTable();
$pdf->SetWidths(array(10,10,70,27,37));
$pdf->viewTable($contract);
$pdf->Output();
?>
