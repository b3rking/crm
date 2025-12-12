
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
		//$this->setMargins(2,100);
		$this->SetFont('Arial','',14);
		$this->Cell(190,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(5);
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		$this->Cell(60,5,'',0,0,'C');
		$this->SetFont('Arial','B',8);
		$this->Ln(5);
	}
	function footer()
	{	
	}
	function headerTable()
	{
		$this->Cell(50,10,'',0,0,'C');
		$this->Cell(60,5,'RAPPORT SUR LE TICKET',0,1,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',8);
		//$this->Ln(5);
		$this->SetFillColor(204,85,0);
		$this->Cell(8,5,'N0',1,0,'',1);
		//$this->Cell(15,5,'ID- Ticket',1,0,'',1);
		$this->Cell(65,5,'Nom client',1,0,'',1);
		//$this->Cell(15,5,'billing N',1,0,'',1);
		$this->Cell(40,5,'Adresse',1,0,'',1);
		//$this->Cell(25,5,'Type',1,0,'',1);
		$this->Cell(30,5,'Date',1,0,'',1);
		$this->Cell(40,5,'Phone',1,0,'',1);
		$this->Cell(9,5,'Statut',1,1,'',1);
	}
	function viewTable($ticket,$condition)
	{
	
		$this->SetFont('Arial','',6);
		$cpt =0;
		foreach ($ticket->filtreTickets($condition) as $value) 
		{
			$cpt++;
			$this->ROW([$cpt,/*$value->id,*/$value->Nom_client/*,$value->billing_number*/,$value->adresse/*,$value->ticket_type*/,$value->created_at,$value->telephone.' '.$value->mobile_phone,$value->status]);
			/*$this->ROW([$cpt,$value->id,$value->Nom_client.'- ID :'.$value->billing_number,$value->adresse.'/ '.$value->mobile_phone,$value->ticket_type,$value->created_at,$value->nom_user,$value->status]);*/
		}
		
	} 
}

$pdf = new myPDF();
$pdf->AliasNbPages();
//$pdf->SetLeftMargin(auto);
//$pdf->init();
$pdf->AddPage();
$pdf->headerTable();
$pdf->SetWidths(array(8,65,40/*,25*/,30,40,9));
$pdf->viewTable($ticket,$condition);
$pdf->Output();
?>
