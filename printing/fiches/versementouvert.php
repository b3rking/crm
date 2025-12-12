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
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		//$this->image('printing/fiches/logoajywa.png',15,10,40);
		$this->SetFillColor('239', '125', '28'); 
		$this->setMargins(15,100);
		$this->SetFillColor(206,102,28);
		$this->SetFont('Arial','',12);
		$this->Cell(100,10,'',0,1,'L');
		$this->Cell(190,5,'Les verssements non clotures ',0,1,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',10);
		$this->Cell(110,5,'Generer le : '.date('d-m-Y'),0,1,'R');
		//$this->Line(24,40,186,40);
	}
	function footer()
	{

	}
	function headerTable()
	{
		$this->Ln(10);
		$this->SetFont('Arial','',12);
		$this->Ln(3);
		$this->Cell(40,7,'Banque', 1,0);
		$this->Cell(40,7,'Numero', 1,0);
		$this->Cell(40,7,'Montant versse', 1,0);
		$this->Cell(40,7,'Date', 1,1);  
	}
	function viewTable($comptabilite)
	{
		$this->SetFont('Arial','',10);
		foreach ($comptabilite->getVersementOuvert() as $value) 
		{
			$this->Cell(40,5,$value->nom.'_'.$value->monnaie, 1,0);
			$this->Cell(40,5,$value->numero, 1,0);
			$this->Cell(40,5,$value->montant.'_'.$value->monnaie, 1,0);
			$this->Cell(40,5,$value->dateversement, 1,1);
		}
	}
}
$pdf = new myPDF();
    
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable($comptabilite);
$pdf->Output();
?>
