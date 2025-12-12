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
		//$this->image('printing/fiches/logospnet.png',15.0,10,40);
		//$this->image('printing/fiches/logoajywa.png',15,10,30);
        $this->image('printing/fiches/logospnet.png',15.0,10,40);

		$this->setXY(15,11);
		
		$this->SetFillColor(102,205,170);
		$this->Cell(140,5,'',0,0,'C');
		$this->SetFont('Arial','I',11);
		$this->Cell(40,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(18);
		$this->Cell(60,5,'',0,0,'C');
		$this->SetFont('Arial','B',12);
		$this->Cell(70,5,'Rapport de depenses',0,0,'C',1);
			$this->Ln(10);
		//$this->Line(24,40,186,40);
	}
	function footer()
	{	
	}
	function headerTable()
	{
		$this->setMargins(15,100);
		$this->Ln(8);
		$this->SetFont('Arial','',12);
		$this->Cell(105,8,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		$this->Ln(5);
		$this->SetFillColor(102,205,170);
		$this->Cell(8,6,'#',1,0,'C',1);
		$this->Cell(22,6,'DATE',1,0,'C',1);
		$this->Cell(32,6,'MONTANT',1,0,'C',1);
		$this->Cell(50,6,'LIBELLE',1,0,'C',1);
		$this->Cell(30,6,'CATEGORIE',1,0,'C',1);
		$this->Cell(33,6,'CAISSE',1,1,'C',1);
	}
	function viewTable($comptabilite,$condition)
	{
		$total_USD = 0;
		$total_monnaie_locale = 0;
		foreach ($comptabilite->getMonnaies() as $value) 
		{
		    $tbMonnaie[] = $value->libelle;
		}
		$this->SetFont('Arial','',9);
		$i =0;
		foreach ($comptabilite->filtrePetiteDepense($condition,$_SESSION['ID_user']) as $value) 
		{
			$i++;
			
			if ($value->monnaie == 'USD') 
				$total_USD +=$value->montantdepense;
			else $total_monnaie_locale +=$value->montantdepense;
			/*if ($value->provenance == 'caisse') 
	        {
	        	$caisse = $comptabilite->getCaisseProvenanceDepense($value->ID_depense)->fetch();
	        	$provenance = $caisse['nomcaisse'];
	        }
	        else
	        {
	        	$banque = $comptabilite->getBanqueProvenanceDepense($value->ID_depense)->fetch();
	        	$provenance = $banque['nom'];
	        }*/
			$this->Row([$i,$value->datedepense,$value->montantdepense.' '.$value->monnaie,$value->motifdepense,$value->description,$value->nomCaisse]);
		}
		$this->SetFont('Arial','B',10);
		$this->Cell(30,6,'Total '.$tbMonnaie[1],1,0,'C');
		$this->Cell(32,6,$total_USD.' '.$tbMonnaie[1],1,0,'C');
		$this->Cell(50,6,'',1,0,'C');
		$this->Cell(30,6,'',1,0,'C');
		$this->Cell(33,6,'',1,1,'C');

		$this->Cell(30,6,'Total '.$tbMonnaie[0],1,0,'C');
		$this->Cell(32,6,$total_monnaie_locale.' '.$tbMonnaie[0],1,0,'C');
		$this->Cell(50,6,'',1,0,'C');
		$this->Cell(30,6,'',1,0,'C');
		$this->Cell(33,6,'',1,0,'C');
		//$this->Cell(183,5,'Total : '.$total.'_USD',0,0);
		//$this->Cell(105,5,'',0,0);
		//$this->Cell(33,5,$total.'_USD',1,1);
		/*foreach ($comptabilite->depenseDunePeriodeDunUser($this->getMois(),$this->getAnnee()/*,$this->getIdUser()*) as $value) 
		{
			$total +=$value->montantdepense;
			$monnaie =$value->monnaie;
			/*$this->Cell(28,5,$value->datedepense,1,0);
			$this->Cell(77,5,$value->motifdepense,1,0);
			$this->Cell(38,5,$value->categorie,1,0);
			$this->Cell(33,5,$value->montantdepense.' '.$value->monnaie,1,1);*
			$this->Row([$value->datedepense,$value->motifdepense,$value->categorie,$value->montantdepense.' '.$value->monnaie]);
		}
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(143,5,'Total',0,0);
		//$this->Cell(105,5,'',0,0);
		$this->Cell(33,5,$total.'_'.$monnaie,0,1);

		/*$this->Cell(33,8,'Total ','LB',0);
		
		$this->Cell(34,8,$total,'B',0,'C');
		$this->Cell(105,8,'','B',0);
		$this->Cell(38,8,'','B','R'0,);*/
	}
}

$pdf = new myPDF();
$pdf->AliasNbPages();
//$pdf->init($mois,$annee);
$pdf->AddPage();
$pdf->headerTable();
$pdf->SetWidths(array(8,22,32,50,30,33,33));
$pdf->viewTable($comptabilite,$condition);
$pdf->Output();
?>
