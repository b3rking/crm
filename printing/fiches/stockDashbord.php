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
		$this->setMargins(20,100);
		$this->SetFont('Arial','',14);
		$this->Cell(190,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(5);
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		$this->Cell(60,5,'',0,0,'C');
		$this->SetFont('Arial','B',14);
		//$this->Line(65,37,150,37);
		$this->Cell(60,5,'LISTE D\'EQUIPEMENT DANS LE STOCK',0,1,'C');
		
		$this->Line(63,37,158,37,'B');	
	}
	function footer()
	{
		/*$this->SetY(-48);
		//$this->Cell(80,5,'Directeur Technique  ',0,1);
		$this->Ln(18);
		$this->SetY(-48);
		$this->SetX(130);*/
	}
	function headerTable()
	{
		
		$this->setMargins(20,100);
	    $this->SetFont('Arial','',14);
	    $this->Ln(10);
		
		$this->Cell(80,8,'EQUIPEMENT  ', 1,0);

		$this->Cell(80,8,'QUANTITE', 1,1);
		$this->SetFont('Arial','',10);
		foreach ($_SESSION['dashbordNombreEquipement'] as $value) 
	    {  
	      	//$i++;

	        $this->Cell(80,5,$value->type_equipement.' '.$value->fabriquant.' '.$value->model, 1,0);
	        $this->Cell(80,5,$value->nb, 1,1);
	    }
		$this->Ln(40);
		$this->Cell(10,8,'',0,1,'L');
		$this->SetFont('Arial','',14);
		$this->Cell(150,5,'ACCESSOIRE',0,1,'C');
		$this->Cell(10,5,'',0,1,'R');
		$this->Ln(1);
		$this->Cell(80,8,'CATEGORIE  ', 1,0);
		$this->Cell(80,8,'QUANTITE', 1,1);	 
	}
	function viewTable()
    {
	     $this->SetFont('Arial','',10);
		foreach ($_SESSION['dashbordNombreAccessoir'] as $value) 
	    {  
	        $this->Cell(80,5,$value->categorie, 1,0);
	        $this->Cell(80,5,$value->quantite, 1,1);
	    }
	}
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable();
$pdf->Output();
?>
