<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	/*var $nomBanque;
	var $montant;
	function init()
	{
		$this->nomBanque = $nomBanque;
		$this->montant = $montant;
	}
	function getNombanque()
	{
		return $this->nomBanque;
	}
	function getMontant()
	{
		return $this->montant;
	}
	*/


	function header()
	{
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		//$this->setMargins(10,100);
		$this->SetFont('Arial','',14);
		$this->Cell(190,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(5);
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		$this->Cell(60,5,'',0,0,'C');
		$this->SetFont('Arial','B',14);
		$this->Cell(60,5,'PAIEMENT HEBDOMADAIRE ',0,1,'C');
		
		//$this->Line(24,40,186,40);
	}
	function footer()
	{	
	}
	function headerTable()
	{
		
		$this->Ln(10);
		$this->SetFont('Arial','',12);
		$this->Cell(70,8,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		$this->Ln(5);
		$this->Cell(28,8,'Date du jour',1,0);
		$this->Cell(34,8,'Numero du client',1,0);
		$this->Cell(28,8,'Nom client',1,0);
		$this->Cell(24,8,'Montant',1,0);
		$this->Cell(48,8,'Taux de change jour',1,0);
		$this->Cell(28,8,'Description',1,1);
       
	}
	function viewTable()
	{

		
		$this->Cell(28,8,'March10,2001',1,0);
		$this->Cell(34,8,'#152',1,0);
		$this->Cell(28,8,'Christian',1,0);
		$this->Cell(24,8,'500.000 BIF',1,0);
		$this->Cell(48,8,'2050,0 BIF',1,0);
		$this->Cell(28,8,'PAIEMENT f',1,1);

		$this->Cell(28,8,'March10,2001',1,0);
		$this->Cell(34,8,'#34',1,0);
		$this->Cell(28,8,'Corine',1,0);
		$this->Cell(24,8,'850.000 BIF',1,0);
		$this->Cell(48,8,'2000,0 BIF',1,0);
		$this->Cell(28,8,'mois de mars',1,1);

		$this->Cell(28,8,'March10,2001',1,0);
		$this->Cell(34,8,'#152',1,0);
		$this->Cell(28,8,'Alain',1,0);
		$this->Cell(24,8,'500.000 BIF',1,0);
		$this->Cell(48,8,'2050,0 BIF',1,0);
		$this->Cell(28,8,'PAIEMENT f',1,1);

		$this->Cell(28,8,'March10,2001',1,0);
		$this->Cell(34,8,'#848',1,0);
		$this->Cell(28,8,'Hamed',1,0);
		$this->Cell(24,8,'650.000 BIF',1,0);
		$this->Cell(48,8,'1950,0 BIF',1,0);
		$this->Cell(28,8,'janvier',1,1);
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
