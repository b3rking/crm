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
		$this->setMargins(15,100);
		$this->SetFont('Arial','',14);
		$this->Cell(190,5,' ',0,1,'R');
		$this->Ln(5);
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		$this->Cell(60,5,'',0,0,'C');
		$this->SetFont('Arial','B',14);
		//$this->SetFillColor(206,102,28);
		$this->Cell(60,5,'FICHE DE PANNE',0,1,'C');
		//$this->Line(85,37,126,37);
	}
	function footer()
	{
		$this->SetY(-45);
		$this->Cell(80,5,'Signature du technicien  ',0,1);
		$this->Ln(18);
		$this->Cell(95,5,''/* $_SESSION['userName']*/, 0,0);

		$this->SetY(-45);
		$this->SetX(130);

		$this->Cell(140,5, 'Nom et signature du client ' , 0,1);
	    $this->Ln(18);
	    $this->SetX(130);
	    $this->Cell(140,5, 'Date :     /      /20  ', 0,1);

	   
		
		
	}
	function headerTable()
	{
		$this->Ln(3);
		$this->SetFont('Arial','',12);

		$this->Cell(40,5,'Nom du client  ', 0,0);
		
		$this->Cell(40,5,': ..........................................................', 0,1);
		$this->Ln(3);

        $this->Cell(40,5,'Adresse physique  ', 0,0);
		
		$this->Cell(40,5,': ..........................................................', 0,1);
		$this->Ln(3);
		$this->Cell(40,5,'Telephone   ', 0,0);
		
		$this->Cell(40,5,': ..........................................................', 0,1);
		$this->Ln(3);
		$this->Line(15,65,200,65);
		$this->Ln(8);
		
		//$this->Ln(8);
		$this->Cell(40,5,'IP Antenne  ', 0,0);
		
		$this->Cell(40,5,': ..........................................................', 0,1);
		$this->Ln(3);
		$this->Cell(40,5,'IP Routeur  ', 0,0);
		
		$this->Cell(40,5,': ..........................................................', 0,1);
		$this->Ln(3);
		$this->Cell(40,5,'Heure d\'arriver  ', 0,0);
		
		$this->Cell(40,5,': ..........................................................', 0,1);
		$this->Ln(3);
		$this->Cell(40,5,'Heure de depart  ', 0,0);
		
		$this->Cell(40,5,': ..........................................................', 0,1);
		$this->Ln(3);


		$this->Ln(6);

		// Corp du fiche
		    $this->Line(15,119,45,119);
		    $this->Cell(95,5,'Materiel utilises : ', 0,1);
	    	
	    	$this->Ln(10);
	    	$this->Cell(45,5,'Routeur MAC Adress  ', 0,0);
		
			$this->Cell(45,5,': ..........................................................', 0,1);
			$this->Ln(3);
			$this->Cell(45,5,'Antene MAC Adress  ', 0,0);
		
			$this->Cell(45,5,': ..........................................................', 0,1);
			$this->Ln(3);
			$this->Cell(45,5,'Cable en (metre)  ', 0,0);
		
			$this->Cell(45,5,': ..........................................................', 0,1);
			$this->Ln();
			$this->Cell(45,5,'Tuyau en (metre)  ', 0,0);
		
			$this->Cell(45,5,': ..........................................................', 0,1);
			$this->Ln();
			$this->Cell(45,5,'Connecteur (nombre)  ', 0,0);
		
			$this->Cell(45,5,': ..........................................................', 0,1);
			$this->Ln(8);
			
			}
	function viewTable()
	{
		    $this->Cell(200,5,'Nature de la panne    :',0,1);
			$this->Ln();
			$this->Rect(15,185,180,20);
			$this->Ln(25);
			$this->Cell(200,5,'Commentaire du client    :',0,1);
			$this->Ln(10);
            $this->Rect(15,220,180,25);
    }

	
}

$pdf = new myPDF();
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable();
$pdf->Output();
?>
