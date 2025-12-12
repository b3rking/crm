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
	var $categorie_accessoire;

	function init($categorie_accessoire)
	{
		$this->categorie_accessoire = $categorie_accessoire;
	}
	function getcategorie_accessoire()
	{
		return $this->categorie_accessoire;
	}


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

		$this->setXY(150,11);
		$this->SetFont('Arial','B',12);
		
		$this->Cell(100,5,'',0,0);
		$this->Ln(2);
		$this->Cell(180,5,'Generer le '.date("j,F Y, g:i a"), 0,1,'R');
		//$this->Cell(180,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(15);
		$this->Cell(180,5,'FICHE DE STOCK POUR : '.$this->getcategorie_accessoire(),0,1,'C');
			//$this->Ln(8);
		
	}
	function footer()
	{
	    /*$this->Ln();
		$this->SetY(-45);
		//$this->Line(15,262,195,262);
		$this->SetFont('Arial','',8);
		$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', 'N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d\'identification: NO 1928 Conformément a l\'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L\'interruption de la connexion se fait le 3 du mois pour non paiement.'),1,'L');
		$this->SetFont('Arial','B',8);
		$this->Ln();
		$this->Cell(30,4,'N. Comptes',0,1);
		$this->SetFont('Arial','',8);
		$this->Cell(30,4,'KCB - 6690353958 - BIF',0,1);
		$this->Cell(30,4,'KCB - 6690353966 - USD',0,1);*/
	}
	function headerTable() 
	{
		$this->Ln(10);
		$this->SetFont('Arial','',10);
		
		$this->Ln(5);
		$this->SetFont('Arial','B',9);
		$this->setFillColor(239,127,34);
		$this->Cell(169,5,'FICHE DE STOCK ',1,1,'C',1);
		$this->Cell(8,5,'No',1,0,'C');
		$this->Cell(30,5,'DATE',1,0,'C');
		$this->Cell(25,5,'MOUVEMENT',1,0,'C');
		$this->Cell(15,5,'Quantite',1,0,'C');
		$this->Cell(15,5,'S.Initial',1,0,'C');
		$this->Cell(16,5,'S.Restant',1,0,'C');
		$this->Cell(30,5,'UTILISATION',1,0,'C');
		$this->Cell(30,5,'RESPONSABLE',1,1,'C');
	}
	function viewTable($equipement,$categorie_accessoire)
	{
		$this->SetFont('Arial','',9);
		
		$i = 0;
		$stock_initial =0;
		$stock_restant =0;
		//$stockPrecedent = 0;
		$stock=0;
		
			foreach ($equipement->detailFiche_stockparCategorie($categorie_accessoire)as $value) 
			{
				$i++;
				$stockPrecedent =$value->qte_stock;
		 // $this->Row([$i,$value->date_entre,$value->mouvement,$value->quantite,$value->quantite,$value->motif,$value->nom_user]);
				if ($value->mouvement =='entree') 
				{	//accessoire.quantite AS qte_stock,historique_accessoire.categorie,historique_accessoire.quantite,historique_accessoire.commentaire,historique_accessoire.date_entre,responsable,mouvement,nom_user
					//$stock_initial = $value->qte_stock+$value->quantite;
					//$stock_restant = $stock_initial;
					$stock_restant=$stock_initial+$value->quantite;
					$this->Cell(8,5,$i,1,0);
					$this->Cell(30,5,$value->date_entre,1,0);
					$this->Cell(25,5,$value->mouvement,1,0,'C');
					$this->Cell(15,5,$value->quantite,1,0,'C');
					$this->Cell(15,5,$stock_initial,1,0);
					$this->Cell(16,5,$stock_restant,1,0);
					$this->Cell(30,5,$value->commentaire,1,0);
					$this->Cell(30,5,$value->responsable,1,1);
				}
				else
				{
					$stock_initial =$stock_restant;
					// $stock_initial - $value->quantite;
					$stock_restant = $stock_initial-$value->quantite;
					$this->setFillColor(124,74,44);
					$this->Cell(8,5,$i,1,0);
					$this->Cell(30,5,$value->date_entre,1,0);
					$this->Cell(25,5,$value->mouvement,1,0,'C');
					$this->Cell(15,5,$value->quantite,1,0,'C');
					$this->Cell(15,5,$stock_initial,1,0);
					$this->Cell(16,5,$stock_restant,1,0);
					$this->Cell(30,5,$value->commentaire,1,0);
					$this->Cell(30,5,$value->nom_user,1,1);
				}
				
	    	}
	    	//$this->Ln(2);
			//$this->Cell(16,5,'Stock precent     :',0,0,'C');$this->Cell(16,5,$stockPrecedent,0,1);
			

		//}
		
    

	}
}

$pdf = new myPDF();

$pdf->SetLeftMargin(25);
$pdf->AliasNbPages();
$pdf->init($categorie_accessoire);
$pdf->AddPage();
$pdf->headerTable();
$pdf->SetWidths(array(8,30,25,15,15,16,30,30));
$pdf->viewTable($equipement,$categorie_accessoire);
$pdf->Output();
?>
