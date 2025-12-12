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
	    //$this->image('printing/fiches/logoajywa.png',15,10,50);
		$this->image('printing/fiches/logospnet.png',15,10,50);

		//$this->setXY(15,11);
		$this->SetFont('Arial','B',12);
		$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		$this->Ln(2);
		$this->Cell(140,5,'Le '.date('d-m-Y'),0,1,'R');

		$this->Cell(160,5,'Client actifs ',0,1,'C');
			$this->Ln(8);
	}
	function footer()
	{
	    $this->Ln();
		$this->SetY(-20);
		$this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	function headerTable() 
	{
		/*$this->Ln(10);
		$this->SetFont('Arial','',10);
		$this->Cell(70,5,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		$this->Ln(5);
		$this->Cell(60,5,'Nom client',1,0);
		$this->Cell(28,5,'phone',1,0);
		$this->Cell(60,5,'Adresse',1,0);
		$this->Cell(45,5,'Mail',1,1);*/
	}
	function viewTable($client,$contract,$comptabilite)
	{	$this->SetFont('Arial','B',11);
		$this->Cell(80,5,'',0,0);
		//$this->Cell(30,5,iconv('UTF-8', 'windows-1252', 'Facture impayeé '));
		$this->Ln(10);
		$this->SetFont('Arial','B',9);
			$this->setFillColor(206,102,28);
		$this->Cell(8,5,'No',1,0,'',1);
		$this->Cell(17,5,'ID_Client',1,0,'',1);
		$this->Cell(115,5,'Client',1,0,'',1);
		$this->Cell(35,5,'Solde',1,1,'',1);
		$this->SetFont('Arial','',9); 
		
		$i = 0;
		//$total_dette_USD = 0;
		$total_dette_monnaie_locale = 0;
		foreach ($comptabilite->getMonnaies() as $value) 
		{
		    $tbMonnaie[] = $value->libelle;
		}
		foreach ($client->getClientActifs() as $value) 
		{
			/*$facture = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch();
			$solde = $facture['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
            $i++;
            $this->Row([$i,$value->ID_client,$value->Nom_client,round($solde).' '.$facture['monnaie']]);
            
            if ($facture['monnaie'] == 'USD')
                	$total_dette_USD += $solde;
            else $total_dette_monnaie_locale += $solde;*/
            $i++;
            $total_dette_monnaie_locale += $value->solde;
            $this->Row([$i,$value->billing_number,$value->Nom_client,number_format(round($value->solde)).' '.$tbMonnaie[0]]);
    	}
    	/*$this->SetFont('Arial','B',9);
    	$this->Cell(120,10,'Total '.$tbMonnaie[0],'TLB',0);
    	$this->Cell(40,10,round($total_dette_USD).' '.$tbMonnaie[0],'TRB',1);*/

    	$this->SetFont('Arial','B',9);
    	$this->Cell(135,10,'Total '.$tbMonnaie[0],'TLB',0);
    	$this->Cell(40,10,number_format(round($total_dette_monnaie_locale)).' '.$tbMonnaie[0],'TRB',0);
	}
}

$pdf = new myPDF();

$pdf->SetLeftMargin(15.2);
$pdf->AliasNbPages();
//$pdf->init($facture_id);
$pdf->AddPage();
$pdf->headerTable();

$pdf->SetWidths(array(8,17,115,35));
$pdf->viewTable($client,$contract,$comptabilite);
$pdf->Output();
?>
