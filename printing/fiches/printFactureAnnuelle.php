
<?php
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $nomBanque;
	var $montantTotal;
	var $devise;
	var $nomClient;
	var $billing_number;
	function init($nomBanque,$montantTotal,$devise,$nomClient,$billing_number)
	{
		$this->nomBanque = $nomBanque;
		$this->montantTotal = $montantTotal;
		$this->devise = $devise;
		$this->nomClient =$nomClient;
		$this->billing_number =$billing_number;
	}
	function getNombanque()
	{
		return $this->nomBanque;
	}
	function getMontantTotal()
	{
		return $this->montantTotal;
	}
	function getDevise()
	{
		return $this->devise;
	}
	function getNomclient()
	{
		return $this->nomClient;
	}
	function getBillingnumber()
	{
		return $this->billing_number;
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
		$h=6*$nb;
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
	/*function header()
	{
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		$this->SetFillColor('239', '125', '28'); 
		$this->setMargins(15,100);
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','',14);
		$this->Cell(190,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(5);
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		$this->Cell(60,5,'',0,0,'C');
		$this->SetFont('Arial','B',14);
		$this->Cell(60,5,'BORDEREAU DE DEPOT BANCAIRES   No : '.$this->getNomclient().'/'.$this->getBillingnumber().'/'. date('mY'),0,1,'C');
		$this->Line(24,40,186,40);
	}*/
	function footer()
	{

	}
	function headerTable()
	{
		$this->SetFont('Arial','',12);
		//$this->SetFillColor(204,85,0);
		$this->Cell(178,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(15);
		$this->Cell(50,5,"",0,0);
		$this->Cell(100,5,"RAPPORT DE LA FACTURATION",0,1);
		$this->Ln(15);
		$this->Cell(26,8,'MOIS',1,0,'C');
	    $this->Cell(50,8,'MONTANT EN BIF',1,0,'C');
		$this->Cell(50,8,'MONTANT EN USD',1,0,'C');
		
		$this->Ln(20);
		
		/*$this->Cell(26,8,'Date',1,0);
		$this->Cell(35,8,'Montant',1,0);
		$this->Cell(52,8,'Client',1,0);
		$this->Cell(68,8,'Description',1,1);*/
	}
	function viewTable($contract)
	{
		$this->SetFont('Arial','B',12);
		//$this->SetFillColor(204,85,0);
		$this->Cell(178,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(15);
		$this->Cell(50,5,"",0,0);
		$this->Cell(100,5,"RAPPORT DE LA FACTURATION",0,1);
		$this->Line(71,35,142,35);
		$this->Ln(15);

		$this->Cell(50,5,iconv('UTF-8', 'windows-1252' , 'Anneé : 2020'),0,0);

		$this->Ln(5);
		$this->Cell(50,8,'MOIS',1,0,'C');
	    $this->Cell(50,8,'MONTANT EN BIF',1,0,'C');
		$this->Cell(50,8,'MONTANT EN USD',1,1,'C');
		$this->SetFont('Arial','',12);

		$tb_mois= [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];

		$total_usd = 0;
		$total_bif = 0;
		for ($i=1; $i < 13 ; $i++) 
		{ 
			foreach ($contract->getfacture_total_dun_mois($i,2020) as $value) 
            {
                if ($value->monnaie == 'USD') 
                {
                    $montant_facture_USD = $value->montant;
                    $total_usd += $montant_facture_USD;
                }
                else
                {
                    $montant_facture_monnaie_locale = $value->montant;
                    $total_bif += $montant_facture_monnaie_locale;
                }
            }
			$this->Row([$tb_mois[$i],number_format($montant_facture_monnaie_locale),number_format($montant_facture_USD)]);
		}
		$this->SetFont('Arial','B',12);
		$this->Cell(50,8,'Total',1,0,'C');
	    $this->Cell(50,8,number_format($total_bif),1,0,'C');
		$this->Cell(50,8,number_format($total_usd),1,1,'C');

		$this->SetFont('Arial','B',12);
		$this->Ln(15);
		$this->Cell(50,5,iconv('UTF-8', 'windows-1252' , 'Anneé : 2021'),0,0);
		$this->Ln(5);
		$this->Cell(50,8,'MOIS',1,0,'C');
	    $this->Cell(50,8,'MONTANT EN BIF',1,0,'C');
		$this->Cell(50,8,'MONTANT EN USD',1,1,'C');
		$this->SetFont('Arial','',12);

		$total_usd = 0;
		$total_bif = 0;
		for ($i=1; $i < 13 ; $i++) 
		{ 
			foreach ($contract->getfacture_total_dun_mois($i,2021) as $value) 
            {
                if ($value->monnaie == 'USD') 
                {
                    $montant_facture_USD = $value->montant;
                    $total_usd += $montant_facture_USD;
                }
                else
                {
                    $montant_facture_monnaie_locale = $value->montant;
                    $total_bif += $montant_facture_monnaie_locale;
                }
            }
			$this->Row([$tb_mois[$i],number_format($montant_facture_monnaie_locale),number_format($montant_facture_USD)]);
		}
		$this->SetFont('Arial','B',12);
		$this->Cell(50,8,'Total',1,0,'C');
	    $this->Cell(50,8,number_format($total_bif),1,0,'C');
		$this->Cell(50,8,number_format($total_usd),1,1,'C');

		$this->SetFont('Arial','B',12);
		$this->Ln(30);
		$this->Cell(50,5,iconv('UTF-8', 'windows-1252' , 'Anneé : 2022'),0,0);
		$this->Ln(5);
		$this->Cell(50,8,'MOIS',1,0,'C');
	    $this->Cell(50,8,'MONTANT EN BIF',1,0,'C');
		$this->Cell(50,8,'MONTANT EN USD',1,1,'C');
		$this->SetFont('Arial','',12);

		$total_usd = 0;
		$total_bif = 0;
		for ($i=1; $i < 2 ; $i++) 
		{ 
			foreach ($contract->getfacture_total_dun_mois($i,2022) as $value) 
            {
                if ($value->monnaie == 'USD') 
                {
                    $montant_facture_USD = $value->montant;
                    $total_usd += $montant_facture_USD;
                }
                else
                {
                    $montant_facture_monnaie_locale = $value->montant;
                    $total_bif += $montant_facture_monnaie_locale;
                }
            }
			$this->Row([$tb_mois[1],number_format($montant_facture_monnaie_locale),number_format($montant_facture_USD)]);
		}
		$this->SetFont('Arial','B',12);
		$this->Cell(50,8,'Total',1,0,'C');
	    $this->Cell(50,8,number_format($total_bif),1,0,'C');
		$this->Cell(50,8,number_format($total_usd),1,1,'C');
	}
}
$pdf = new myPDF();
$pdf->SetLeftMargin(20.2);
//$pdf->SetRightMargin(15.2);
    
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetWidths(array(50,50,50));
//$pdf->headerTable();
$pdf->viewTable($contract);
$pdf->Output();
?>
