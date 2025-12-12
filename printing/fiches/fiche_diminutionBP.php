<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $client;
	var $datedebut;
	var $datefin;
	var $bandepassante;
	var $generer;

	function init($client,$datedebut,$datefin,$bandepassante,$generer)
	{
		$this->client = $client;
		$this->datedebut = $datedebut;
		$this->datefin = $datefin;
		$this->bandepassante = $bandepassante;
		$this->generer = $generer;
	}
	function getClient()
	{
		return $this->client;
	}
	function getDateDebut()
	{
		return $this->datedebut;
	}
	function getDateFin()
	{
		return $this->datefin;
	}
	function getBandeP()
	{
		return $this->bandepassante;
	}
	function getGenerer()
	{
		return $this->generer;
	}

	function header()
	{
		$this->image('printing/fiches/logospnet.png',15,20,60);
		//$this->image('printing/fiches/logoajywa.png',15,10,50);
		$this->setMargins(15,100);
		$this->SetFont('Arial','',14);
		//$this->Cell(190,5,'',0,1);
		//$this->SetY(30);
		$this->Cell(180,5,'Le '.date('d-m-Y'),0,1,'R');
	}
	function footer()
	{
		$this->SetFont('Arial','',12);
		$this->SetY(-80);
		$this->Cell(95,5,iconv('UTF-8', 'windows-1252', 'Signature de l\'abonné'), 0,0);
		$this->Line(16,222,57,222);
	    $this->Cell(75,5, 'Adminstration' , 5,1,'R');
	    $this->Line(158,222,184,222);
		$this->SetY(-25);
		$this->Line(16,270,190,270);
		$this->SetFont('Arial','',8);
		$this->Cell(170,5,$_SESSION['nomSociete'].' '. $_SESSION['adresse'] ,0,1,'C');
		$this->Cell(170,5,$_SESSION['telephone'].'  '. $_SESSION['email'],0,1,'C');
		//$this->Cell(170,5,'AJYWA TELECOM BUKAVU,SUD-KIVU , Avenue maniema No. 044 commune IBANDA 06',0,1,'C');
		//$this->Cell(170,5,'Tel:+243 858 666 617 +243 999 336 917 email:info@ajywa.net',0,1,'C');
	}
	function headerTable()
	{
		$this->Ln(40);
		$this->SetFont('Arial','',14);
		$this->Cell(60,5,'',0,0,'C'); 
		$this->Cell(60,5,' FICHE DE REDUCTION DE LA BANDE PASSANTE',0,1,'C');
		$this->Line(47,60,164,60);
		$this->Ln(10);
		$this->SetFont('Arial','',12);
		$this->Cell(40,5,'Nom du client', 0,0);
		$this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252', $this->getClient()['Nom_client']), 0,1,'L');
		$this->Ln(3);
		$this->Cell(40,5,'ID', 0,0);
		$this->Cell(95,5,': '.$this->getClient()['billing_number'], 0,1,'L');
		$this->Ln(3);
		$this->Cell(40,5,'Telephone', 0,0);
		$this->Cell(95,5,': '.$this->getClient()['telephone'], 0,1,'L');
		$this->Ln(3);
		$this->Cell(40,5,'E-mail', 0,0);
		$this->Cell(95,5,': '.$this->getClient()['mail'], 0,1,'L');
		$this->Ln(3);
		$this->Cell(40,5,'Adresse', 0,0);
		//$this->Cell(95,5,iconv('UTF-8', 'windows-1252', $this->getClient()['adresse']), 0,1);
		$this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252', $this->getClient()['adresse']), 0,1,'L');
		$this->Ln(3);
		$this->Line(16,110,190,110);

		$this->Ln(10);

		// Corp du fiche
		$this->Cell(60,5,'Technicien responsable', 0,0);
			//$this->Ln(5);
		$this->Cell(80,5,':......................................................................', 0,1);
			$this->Ln(10);
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Réduction démandeé par :  Service commercial'), 0,0);
		/*if ($this->getGenerer()) 
		{
			$this->Cell(80,5,': '.$_SESSION['userName'], 0,1);
		}
		else $this->Cell(80,5,': '.$this->getClient()['nom_user'], 0,1);*/
		
		$this->Ln(10);
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Bande Passante à diminuer'), 0,0);
		$this->Cell(80,5,': '.iconv('UTF-8', 'windows-1252', $this->getBandeP()).' Mbps', 0,1);
    	$this->Ln(3);
    	$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Diminution à partir du'), 0,0);
    	$this->SetFont('Arial','B',12);
    	$this->Cell(30,5,': '.date('d-m-Y',strtotime($this->getDateDebut())), 0,0);
    	//$this->Cell(10,5,'au', 0,0);
    	//$this->Cell(25,5,date('d-m-Y',strtotime($this->getDateFin())), 0,0);
	}
	
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->init($dataClient,$datedebut,$datefin,$bandepassante,$generer);
$pdf->AddPage();
$pdf->headerTable();
$pdf->Output();
?>
