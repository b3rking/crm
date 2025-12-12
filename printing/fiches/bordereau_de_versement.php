
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
	function headerTable($comptabilite,$idversement)
	{
		$res = $comptabilite->recuperer_un_versement($idversement)->fetch();
		$this->SetFont('Arial','',12);
		$this->SetFillColor(204,85,0);
		$this->Cell(178,5,'Creer Le '.$res['date_operation'],0,1,'R');
		$this->Ln(5);
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		//$this->Cell(30,5,'',0,0,'C');
		$this->SetFont('Arial','B',12);
		$this->Cell(180,5,"Reference de versement : ".$res['reference'],0,1,'C',1);
		//$this->Cell(60,5,$res['reference'],0,1,'C',1);
		$this->Ln(10);
		$this->SetFont('Arial','',12);
		$this->Ln(3);
        $this->Cell(40,5,'Banque  :', 0,0);
		//$this->Cell(40,5,$comptabilite->getBanqueDunVersement($idversement)->fetch()['nom'], 0,1);
        $this->Cell(40,5,$res['nom'], 0,1);
		$this->Ln(3);
		$this->Cell(40,5,iconv('UTF-8', 'windows-1252', 'Montant verssé  :'), 0,0);
		$this->Cell(40,5,number_format($res['debit']).' '.$res['monnaie'], 0,1);
		/*if ($res['destination'] == 'banque') 
		{
			$this->SetFillColor(204,85,0);
			$this->Cell(40,5,'Compte bancaire  :', 0,0);
			$this->Cell(40,5,$comptabilite->getBanqueDunVersement($idversement)->fetch()['nom'], 0,1);
			$this->Ln(3);
			$this->Cell(40,5,iconv('UTF-8', 'windows-1252', 'Montant verssé  :'), 0,0);
			$this->Cell(40,5,$res['montant'].' '.$res['monnaie_verser'], 0,1);
		}
		else
		{
			$this->SetFillColor(204,85,0);
			$this->Cell(40,5,'Compte bancaire  :', 0,0);
			$this->Cell(40,5,$comptabilite->getCaisseDunVersement($idversement)->fetch()['nomCaisse'], 0,1);
			$this->Ln(3);
			$this->Cell(40,5,iconv('UTF-8', 'windows-1252', 'Montant verssé   :'), 0,0);
			$this->Cell(40,5,$res['montant'].' '.$res['monnaie_verser'], 0,1);
		}*/
		
		$this->Ln(20);
		
		/*$this->Cell(26,8,'Date',1,0);
		$this->Cell(35,8,'Montant',1,0);
		$this->Cell(52,8,'Client',1,0);
		$this->Cell(68,8,'Description',1,1);*/
	}
	function viewTable($comptabilite,$idversement)
	{
		$this->SetFont('Arial','',12); 
		$this->Cell(61,5,'',0,0);
		$this->SetFillColor(204,85,0);
		$this->Cell(30,5,iconv('UTF-8', 'windows-1252', 'Paiements attachés'),0,1,1);
		$this->Ln();
		$this->Cell(26,8,'DATE',1,0,'C',1);
	    $this->Cell(35,8,'MONTANT',1,0,'C',1);
	    $this->Cell(50,8,'CLIENT',1,0,'C',1);
	    $this->Cell(65,8,'DESCRIPTION',1,1,'C',1);
	    $this->SetFont('Arial','',8);

		foreach ($comptabilite->getPaiements_attacher_a_un_versement($idversement) as $value) 
		{
			//$this->setFillColor(230,230,230);
			//$this->Cell(0,5,'',0,1,"L",1);

			//$this->SetFillColor(true);
			//$this->SetFillColor(192,192,192);
			/*$this->Cell(26,5,$value->datepaiement,1,0);
		    $this->Cell(35,5,$value->montant.''.$value->devise,1,0);
		    $this->Cell(50,5,$value->nom_client.' / ID#'.$value->billing_number,1,0);
		    $this->Cell(65,5,$value->reference,1,1);*/
		    $this->Row([$value->datepaiement,number_format($value->montant).' '.$value->devise,$value->nom_client.' / ID#'.$value->billing_number,$value->reference]);
		}
	}
}
$pdf = new myPDF();
$pdf->SetLeftMargin(15.2);
$pdf->SetRightMargin(15.2);
    
$pdf->AliasNbPages();
//$pdf->init($nomBanque,$montantTotal,$devise,$nomClient,$billing_number);
$pdf->AddPage();
$pdf->SetWidths(array(26,35,50,65));
$pdf->headerTable($comptabilite,$idversement);
$pdf->viewTable($comptabilite,$idversement);
$pdf->Output();
?>
