<?php
define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $facture_id;

	function init($facture_id)
	{
		$this->facture_id = $facture_id; 
	}
	function getFactureId()
	{
		return $this->facture_id;
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
		//$this->image('printing/fiches/logospnet.png',15,10,50);
		$this->setXY(15,5);
		$this->SetFont('Arial','B',12);
		$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'RAPPORT DES CLIENTS ACTIFS Generé le ').date('d-m-Y'),0,1,'C');
		//$this->Line(61,30,149,30);
	}*/
	function footer()
	{
	    $this->Ln();
		$this->SetY(-20);
		$this->SetFont('Arial','',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	function viewTable($client,$contract)
	{
		$this->SetFont('Arial','B',12);
		$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,'SPIDERNET SA',0,1,'C');
		$this->Ln();
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'RAPPORT DES CLIENTS ACTIFS Generé le ').date('d-m-Y'),0,1,'C');
		$this->SetFont('Arial','B',9);
		$this->Ln(10);
		$this->Cell(60,6,'',0,0);
		$this->Cell(60,6,'LES CLIENTS ACTIFS',0,1);
		$this->Cell(10,5,'#',1,0);
		$this->Cell(39,5,'NOM',1,0);
		$this->Cell(29,5,'TELEPHONE',1,0);
		$this->Cell(29,5,'EMAIL',1,0);
		$this->Cell(42,5,'ADRESSE',1,0);
		$this->Cell(36,5,'PERSO A CONTACTER',1,1);
		$this->SetFont('Arial','',8);
		$iActif = 0;
		foreach ($client->getClientActifs() as $value) 
		{
			$iActif++;
			$this->Row([$iActif,$value->Nom_client,$value->telephone,$value->mail,$value->adresse,$value->personneDeContact]);
		}
		$this->SetFont('Arial','B',9);
		$this->Ln(15);
		$this->Cell(60,6,'',0,0);
		$this->Cell(60,6,'CLIENT EN DEROGATION',0,1);
		$this->Cell(10,5,'#',1,0);
		$this->Cell(39,5,'NOM',1,0);
		$this->Cell(29,5,'TELEPHONE',1,0);
		$this->Cell(29,5,'EMAIL',1,0);
		$this->Cell(42,5,'ADRESSE',1,0);
		$this->Cell(36,5,'PERSO A CONTACTER',1,1);
		$this->SetFont('Arial','',8);
		$iDerogation = 0;
		foreach ($client->getClientEnDerogation() as $value) 
		{
			$iDerogation++;
			$this->Row([$iDerogation,$value->Nom_client,$value->telephone,iconv('UTF-8', 'windows-1252', $value->mail),iconv('UTF-8', 'windows-1252', $value->adresse),iconv('UTF-8', 'windows-1252', $value->personneDeContact)]);
		}
		$this->SetFont('Arial','B',9);
		$this->Ln(15);
		$this->Cell(60,6,'',0,0);
		$this->Cell(60,6,'LES CLIENTS ACTIFS SANS DETTE',0,1);
		$this->Cell(10,5,'#',1,0);
		$this->Cell(39,5,'NOM',1,0);
		$this->Cell(29,5,'TELEPHONE',1,0);
		$this->Cell(29,5,'EMAIL',1,0);
		$this->Cell(42,5,'ADRESSE',1,0);
		$this->Cell(36,5,'PERSO A CONTACTER',1,1);
		$this->SetFont('Arial','',8);
		$iActifSansDette = 0;
		foreach ($client->getClientActifSansDette() as $value) 
		{
			/*$solde = $contract->getSommeTotaleFactureDunClient($value->ID_client)->fetch()['montant'] - $contract->getSommeTotalePayementDunClient($value->ID_client)->fetch()['montant'];
            if ($solde <= 0) 
            {
            	$iActifSansDette++;
				$this->Row([$iActifSansDette,iconv('UTF-8', 'windows-1252', iconv('UTF-8', 'windows-1252', $value->Nom_client)),iconv('UTF-8', 'windows-1252', $value->telephone),iconv('UTF-8', 'windows-1252', $value->mail),iconv('UTF-8', 'windows-1252', $value->adresse),iconv('UTF-8', 'windows-1252', $value->personneDeContact)]);
            }*/
            $iActifSansDette++;
			$this->Row([$iActifSansDette,$value->Nom_client,$value->telephone,$value->mail,$value->adresse,$value->personneDeContact]);
    	}
		$this->SetFont('Arial','B',9);
		$this->Ln(15);
		$this->Cell(60,6,'',0,0);
		$this->Cell(60,6,'LES CLIENTS EN COUPURE',0,1);
		$this->Cell(10,5,'#',1,0);
		$this->Cell(39,5,'NOM',1,0);
		$this->Cell(29,5,'TELEPHONE',1,0);
		$this->Cell(29,5,'EMAIL',1,0);
		$this->Cell(42,5,'ADRESSE',1,0);
		$this->Cell(36,5,'PERSO A CONTACTER',1,1);
		$this->SetFont('Arial','',8);
		$iClientEnCoupure = 0;
		foreach ($client->getClientEnCoupure() as $value) 
		{
			$iClientEnCoupure++;
			$this->Row([$iClientEnCoupure,$value->Nom_client,$value->telephone,$value->mail,$value->adresse,iconv('UTF-8', 'windows-1252', $value->personneDeContact)]);
		}
		//$this->AddPage($this->CurOrientation);
		//$this->SetAutoPageBreak(true,$this->GetY()); 
	}
}

$pdf = new myPDF();

$pdf->SetLeftMargin(15.2);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetWidths(array(10,39,29,29,42,36));
$pdf->viewTable($client,$contract);
$pdf->Output();
?>
