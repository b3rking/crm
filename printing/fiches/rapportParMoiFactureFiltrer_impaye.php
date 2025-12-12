<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/** 
 * 
 */
class myPDF extends FPDF
{
	
	

	function header()
	{
		//$this->image('printing/fiches/logospnet.png',15,10,50);
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		$this->setXY(15,11);
		$this->SetFont('Arial','B',12);
		$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,'FACTURE No  du '.date('d-m-Y'),0,1,'C');
		//$this->Line(61,30,149,30);
	}
	function footer()
	{
	    $this->Ln();
		$this->SetY(-45);
		//$this->Line(15,262,195,262);
		$this->SetFont('Arial','',8);
		$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', 'N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d\'identification: NO 1928 Conformément a l\'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L\'interruption de la connexion se fait le 3 du mois pour non paiement.'),1,'L');
		$this->SetFont('Arial','B',8);
		$this->Ln();
		$this->Cell(30,4,'N. Comptes',0,1);
		$this->SetFont('Arial','',8);
		$this->Cell(30,4,'KCB - 6690353958 - BIF',0,1);
		$this->Cell(30,4,'KCB - 6690353966 - USD',0,1);
	}
	function headerTable()
	{
		/*$this->Ln(10);
		$this->SetFont('Arial','B',10);
		$this->Cell(60,5,'A. Identification du Vendeur',0,1);
		$this->Ln(3);
		$this->SetFont('Arial','B',9);
		$this->Cell(100,5,'Raison Sociale: SPIDERNET S.A',0,0);
		$this->SetFont('Arial','',9);
		$this->Cell(70,5,'Centre Fiscal: 19747',0,1,'L');
		$this->Cell(100,5,'NIF: 4000000408',0,0);
		$this->Cell(70,5,iconv('UTF-8', 'windows-1252', 'Secteur d\'activité: TELECOMMUNICATION'),0,1,'L');
		$this->Cell(100,5,'Registre de Commerce NO 67249',0,0);
		$this->Cell(70,5,'Forme Juridique: SA',0,1,'L');
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'BP: 1638 Tél: (257) 22 25 84 80/81'),0,1);
		$this->Cell(70,5,'Commune: MUKAZA Quartier: ASIATIQUE',0,1);
		$this->Cell(60,5,'Avenue kirundo no 6',0,1);
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA: Oui'),0,1);
		$this->Ln(10);*/
	}
	function viewTable()
	{		
		//$this->Cell(60,5,'B. Le Client',0,1);
		$this->Ln(4);
		$this->SetFont('Arial','B',9);
		/*$this->Cell(60,5,'Raison Sociale : ',0,1);
		$this->SetFont('Arial','',9);
		$this->Cell(60,5,'NIF : ',0,1);
		$this->Cell(60,5,'Resident a : ',0,1);
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA : '),0,1);
		$this->Ln(10);

		$this->SetFont('Arial','B',8);
		$this->Cell(110,5,'Doit ce qui suit:',0,1);*/
		$this->Ln();
		$this->Cell(40,5,'Nom client',1,0,'C');
		$this->Cell(20,5,'Services',1,0,'C');
		$this->Cell(30,5,'Montant',1,0,'C');
		$this->Cell(30,5,'Taux change',1,0,'C');
		$this->Cell(30,5,'Mois',1,0,'C');
		$this->Cell(30,5,'Annee',1,1,'C');

		$this->SetFont('Arial','',8);

		$this->Cell(40,5,'Alain',1,0,'C');
		$this->Cell(20,5,'connexion or',1,0,'C');
		$this->Cell(30,5,'1000 USD',1,0,'C');
		$this->Cell(30,5,'1900',1,0,'C');
		$this->Cell(30,5,'mai',1,0,'C');
		$this->Cell(30,5,'2020',1,1,'C');

		$this->Cell(40,5,'Christian',1,0,'C');
		$this->Cell(20,5,'dedie',1,0,'C');
		$this->Cell(30,5,'85600 BIF',1,0,'C');
		$this->Cell(30,5,'1920',1,0,'C');
		$this->Cell(30,5,'juin',1,0,'C');
		$this->Cell(30,5,'2020',1,1,'C');

		$this->Cell(40,5,'Total USD',1,0,'C');
		$this->Cell(20,5,'',1,0,'C');
		$this->Cell(30,5,'1000',1,0,'C');
		$this->Cell(30,5,'',1,0,'C');
		$this->Cell(30,5,'',1,0,'C');
		$this->Cell(30,5,'',1,1,'C');

		$this->Cell(40,5,'Total BIF',1,0,'C');
		$this->Cell(20,5,'',1,0,'C');
		$this->Cell(30,5,'85600',1,0,'C');
		$this->Cell(30,5,'',1,0,'C');
		$this->Cell(30,5,'',1,0,'C');
		$this->Cell(30,5,'',1,1,'C');
	}
}

$pdf = new myPDF();
$pdf->AliasNbPages();
//$pdf->init();
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable();
$pdf->Output();
?>
