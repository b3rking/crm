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
	/*function header()
	{
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		//$this->image('printing/fiches/logoajywa.png',15,10,30);

		$this->setXY(15,11);
		
		$this->SetFillColor(102,205,170);
		$this->Cell(140,5,'',0,0,'C');
		$this->SetFont('Arial','I',11);
		$this->Cell(40,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln();
		$this->Cell(30,5,'',0,0,'C');
		$this->SetFont('Arial','B',12);
		$this->Cell(70,5,'Rapport de depenses',0,0,'C',1);
			$this->Ln(10);
		//$this->Line(24,40,186,40);
	}*/
	/*function footer()
	{	
	}
	function headerTable()
	{
		$this->setXY(15,11);
		$this->SetFont('Arial','',12);
		//$this->Cell(105,8,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		//$this->Ln(5);
		$this->Cell(180,8,'Grand-livre des comptes',1,1,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(130,8,'Periode du 2021-08-01 au 2021-08-20',0,1,'C');
		

		/*$this->SetFillColor(102,205,170);
		$this->Cell(8,6,'#',1,0,'C',1);
		$this->Cell(22,6,"DATE",1,0,'C',1);
		$this->Cell(22,6,'MONTANT',1,0,'C',1);
		$this->Cell(35,6,'LIBELLE',1,0,'C',1);
		$this->Cell(30,6,'CATEGORIE',1,0,'C',1);
		$this->Cell(33,6,'PROVENANCE',1,0,'C',1);
		$this->Cell(33,6,'REFERENCE',1,1,'C',1);*
	}*/
	function viewTable($comptabilite,$date1,$date2,$mois,$annee,$idbanque,$condition,$dateAvantFiltre,$periode)
	{
		date_default_timezone_set("Africa/Bujumbura");
	    $created_at = date("d-m-Y").' à '.date('H:i:s');
		$this->setXY(15,11);
		$this->SetFont('Arial','',12);
		//$this->Cell(105,8,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		//$this->Ln(5);
		$this->Cell(180,8,'Grand-livre des comptes',1,1,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(130,8,iconv('UTF-8', 'windows-1252', $periode),0,0,'C');
		$this->Cell(50,8,iconv('UTF-8', 'windows-1252', 'Géneré le '.$created_at),0,1,'C');
		
    	$this->SetFont('Arial','B',12);
    	$this->Cell(25,8,'Date',1,0,'c');
		$this->Cell(50,8,'Libelle',1,0,'c');
		$this->Cell(35,8,'Debit',1,0,'C');
		$this->Cell(35,8,'Credit',1,0,'C');
		$this->Cell(35,8,'Solde progessif',1,1,'C');

		if (empty($idbanque)) 
	    	$banque = $comptabilite->getBanqqueActive();
    	else
			$banque = $comptabilite->getBanque($idbanque);

		foreach ($banque as $value) 
		{
			$debitInitial = $comptabilite->getDebitDuneBanqueAvantUneDate($value->ID_banque,$dateAvantFiltre);
			$creditInitial = $comptabilite->getCreditBuneBanqueAvantUneDate($value->ID_banque,$dateAvantFiltre);
			//$montant_initial = 0;
			$montant_initial = $value->montant_initial;
			$soldeInitial = $montant_initial+$debitInitial-$creditInitial;
			$soldeProgressif = 0;

			$this->SetFont('Arial','B',10);
			$this->Cell(180,8,$value->nom.' '.$value->monnaie.' '.$value->numero,1,1,'C');
			$this->SetFont('Arial','',10);
			//$this->Cell(35,8,number_format($montant_initial+$debitInitial),1,0,'L');
            //$this->Cell(35,8,number_format($soldeInitial),1,0,'L');
            /*$this->Cell(35,8,'',1,0,'L');
			//$this->Cell(35,8,number_format($creditInitial),1,0,'L');
            $this->Cell(35,8,'',1,0,'L');
			$this->SetFont('Arial','B',10);
			//$this->Cell(35,8,number_format($soldeInitial),1,1,'L');
			$this->Cell(35,8,'',1,1,'L');*/
			$this->SetFont('Arial','',10);

			$debitProgressif = 0;
			$creditProgressif = 0;
			if ($soldeInitial > 0) 
			{
				$debitProgressif = $soldeInitial;
				$this->Row([$dateAvantFiltre,'solde initial',number_format($soldeInitial),'',number_format($soldeInitial)]);
			}
			elseif($soldeInitial < 0)
			{
				$creditProgressif = $soldeInitial;
				$this->Row([$dateAvantFiltre,'solde initial','',number_format($soldeInitial),number_format($soldeInitial)]);
			}

			$condition7 = " AND bj.ID_banque=".$value->ID_banque." ";
			$condition1 =$condition.$condition7;
			foreach ($comptabilite->filtreBankJournal($condition1) as $value1) 
	    	{
	    		//$soldeProgressif += ($value->debit != '' ? $soldeInitial+$value->debit : $soldeInitial - $value->credit);
	    		$soldeInitial += ($value1->debit != '' ? $value1->debit : -$value1->credit);
	    		//$debitInitial += $value1->debit;
	    		//$creditInitial += $value1->credit;
	    		$debitProgressif += $value1->debit;
	    		$creditProgressif += $value1->credit;
                
                $debit = ($value1->debit != '' ? $value1->debit : '');
                $credit = ($value1->credit!= '' ? $value1->credit : '');
                
	    		$this->Row([$value1->date_operation,iconv('UTF-8', 'windows-1252', $value1->libelle),number_format($debit),number_format($credit),number_format($soldeInitial)]);
	    	}
	    	$this->SetFont('Arial','',10);
			$this->Cell(75,8,' ',1,0,'C');
			$this->SetFont('Arial','',10);
			//$this->Cell(35,8,number_format($debitInitial+$montant_initial),1,0,'L');
			//$this->Cell(35,8,number_format($creditInitial),1,0,'L');
			$this->Cell(35,8,number_format($debitProgressif),1,0,'L');
			$this->Cell(35,8,number_format($creditProgressif),1,0,'L');
			$this->SetFont('Arial','B',10);
			$this->Cell(35,8,number_format($soldeInitial),1,1,'L');
			//$this->SetFont('Arial','',10);
			$this->Ln();
            
		}
	}
}

$pdf = new myPDF();
$pdf->SetLeftMargin(15);
$pdf->AliasNbPages();
//$pdf->init($mois,$annee);
$pdf->AddPage();
//$pdf->headerTable();
$pdf->SetWidths(array(25,50,35,35,35));
$pdf->viewTable($comptabilite,$date1,$date2,$mois,$annee,$banque,$condition,$dateAvantFiltre,$periode);
$pdf->Output();
?>
