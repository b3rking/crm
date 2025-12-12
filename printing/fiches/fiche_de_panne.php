
<?php
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $date_creation;
	var $createur;

	function init($nom_user,$date_creation)
	{
		$this->date_creation = $date_creation;
		$this->createur = $nom_user;
	}
	function getDateCreation()
	{
		return $this->date_creation;
	}
	function getCreateur()
	{
		return $this->createur;
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
		$this->image('printing/fiches/logospnet.png',15,20,60);
		//$this->image('printing/fiches/logoajywa.png',15,10,50);
		$this->setMargins(10,100);
		$this->SetFont('Arial','',14);
		$this->Cell(190,5,'Le '.$this->getDateCreation(),0,1,'R');
		$this->Ln(40);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,'FICHE D\'INTERVENTION',0,1,'C');
		$this->Line(70,60,130,60);
	}
	function footer()
	{

		$this->SetY(-55);
		$this->Cell(95,5, 'Signature du technicien' , 0,0);
		$this->Line(11,247,42,247);
	    $this->Cell(80,5, 'Nom et Signature du coordonateur' , 0,1,'R');
	    $this->Line(140,247,184,247);
	    $this->Ln();
	    $this->Cell(160,5, $this->getCreateur(), 0,0,'R');
		$this->SetY(-25);
		$this->Line(15,272,195,272);
		$this->SetFont('Arial','',8);
		$this->Cell(170,5,$_SESSION['nomSociete'].' '. $_SESSION['adresse'] ,0,1,'C');
		$this->Cell(170,5,$_SESSION['telephone'].'  '. $_SESSION['email'],0,1,'C');
		/*$this->Cell(170,5,'SPIDERNET s.a quartier asiatique rue kirundo Numero 06 B.P 1638 Bujumbura Burundi',0,1,'C');
		$this->Cell(170,5,'TEL: 257 22 25 84 80 257 22 25 84 81 Fax: 25722258428 info@spidernet-bi.com',0,1,'C');*/
	}
	function headerTable($idfiche,$ticket)
	{
		$fiche = $ticket->getTechnicienByFicheIntervention($idfiche)->fetch();
		$vehicule = $ticket->getVehiculeByFicheIntervention($idfiche)->fetch();
		$this->Ln(10);
		$this->SetFont('Arial','',11);
		$this->Cell(35,5,' Nom du technicien', 0,0);
		$this->Cell(95,5,' :  '  .$fiche['nom_user'], 0,1);
		$this->Cell(35,5,' Vehicule ', 0,0);
		$this->Cell(95,5,' : '.$vehicule['marque'].'-'.$vehicule['immatriculation'], 0,1);
		$this->Cell(35,5,' Heure de depart ', 0,0);
		$this->Cell(95,5,' : ' .date('H:i:s'), 0,1);
		$this->Cell(35,5,' Heure d\'arrivee ', 0,0);
		$this->Cell(95,5,' : .........................................', 0,1);
		$this->Ln(10);
	}
	function viewTable($idfiche,$ticket)
	{

		$this->SetFont('Arial','',12); 
		// ENTETE TABLEAU
		$this->Cell(10,5,'No', 1,0);
		$this->Cell(60,5,'NOM DES CLIENTS', 1,0);
		$this->Cell(55,5,'ADRESSE', 1,0);
		$this->Cell(35,5,'TELEPHONE', 1,0);
		$this->Cell(32,5,'OBSERVATION',1,1);/*
		$this->Cell(61,5,'',0,0);
		$this->SetFillColor(204,85,0);
		$this->Cell(30,5,iconv('UTF-8', 'windows-1252', 'Paiements attachés'),0,1,1);
		$this->Ln();
		$this->Cell(26,8,'DATE',1,0,'C',1);
	    $this->Cell(35,8,'MONTANT',1,0,'C',1);
	    $this->Cell(50,8,'CLIENT',1,0,'C',1);
	    $this->Cell(65,8,'DESCRIPTION',1,1,'C',1);*/
	    $this->SetFont('Arial','',8);


		$i =0;
		foreach ($ticket->getContenuDuneFiche($idfiche) as $key => $value) 
		{ 
			$i++;
			//$this->Cell(10,5, $i, 1,0);
			foreach ($ticket->selectionTicketFiche($value->ID_ticket) as $value2) 
		   	{
		    	$this->Row([$i,$value2->Nom_client,$value2->adresse,$value2->telephone." ".$value2->mobile_phone,$value2->ticket_type]);
			}
			//$this->Cell(30,5, "", 1,1);// Observation
		}
	}
}
$pdf = new myPDF();
$pdf->SetLeftMargin(15);
$pdf->SetRightMargin(8);
    
$pdf->AliasNbPages();
$pdf->init($nom_user,$date_creation);

$pdf->AddPage();
$pdf->SetWidths(array(10,60,55,35,32));
$pdf->headerTable($idfiche,$ticket);
$pdf->viewTable($idfiche,$ticket);
$pdf->Output();
?>
