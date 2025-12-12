<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');
 
/**
 *  
 */
class myPDF extends FPDF
{
	//var $new_adress;
	//var $dates;
	var $tb_client;
	//var $generer;

	function init($tb_client)
	{
		//$this->new_adress = $new_adress;
		$this->tb_client = $tb_client;
		//$this->dates = $dates;
		//$this->generer = $generer;
	}
	function getTb_client()
	{
		return $this->tb_client;
	}
	/*function getnew_adress()
	{
		return $this->new_adress;
	}
	function getdates()
	{
		return $this->dates;
	}
	function getTb_client()
	{
		return $this->tb_client;
	}
	function getGenerer()
	{
		return $this->generer;
	}*/

	function header()
	{
		$this->image('printing/fiches/logospnet.png',15.0,15,50);
		//$this->image('printing/fiches/logoajywa.png',15,10,50);
		$this->setMargins(15,100);
		$this->SetFont('Arial','',14);
		//$this->Cell(190,5,'Le '.date('d-m-Y'),0,1,'R');
		$this->Ln(20);
		$this->Cell(180,5,'FICHE DE DEMENAGEMENT',0,1,'C');
		$this->Line(72,40,138,40);		
	}
	function footer()
	{
		$this->SetY(-40);
		$this->Cell(95,5,'Signature de l\'abonne', 0,0);
		$this->Line(16,262,57,262);
		//$this->Cell(170,5,$_SESSION['nomSociete'].' '. $_SESSION['adresse'] ,0,1,'C');
		//$this->Cell(170,5,$_SESSION['telephone'].'  '. $_SESSION['email'],0,1,'C');
	    $this->Cell(75,5,'Administration', 5,1,'R');
	    $this->Line(157,262,184,262);
	    $this->Ln();
		$this->SetY(-15); 
	}

    function viewTable()
	{
        $customer_type = ['paying'=>'Payant','free'=>'Gratuit','gone'=>'Partie','staff'=>'Staff','potentiel'=>'Potentiel','unknown'=>'Inconnu'];
		$this->Ln(15);
		$this->SetFont('Arial','',12);
		//endroit de donnes du client
		$this->Cell(35,5,'Nom du client ', 0,0);
		$this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getTb_client()['Nom_client']),0,1);
		$this->Ln(3);
		$this->Cell(35,5,'ID                  ', 0,0);
		$this->Cell(95,5,': '.$this->getTb_client()['billing_number']/*['ID_client']*/,0,1);
		$this->Ln(3);
		$this->Cell(35,5,'Telephone                   ', 0,0);
		$this->Cell(95,5,': '.$this->getTb_client()['telephone'].' '.$this->getTb_client()['mobile_phone'],0,1);
		$this->Ln(3);
		$this->Cell(35,5,'E-mail                   ', 0,0);
		$this->Cell(95,5,': '.$this->getTb_client()['mail'],0,1);
		$this->Ln(3);
		$this->Cell(35,5,'Type client                   ', 0,0);
		$this->Cell(95,5,': '.$customer_type[$this->getTb_client()['type_client']],0,1);
		$this->Ln(3);
		/*if ($this->getGenerer()) 
		{
			$this->Cell(35,5,'Ancienne adresse', 0,0);
			$this->Cell(95,5,': '.$this->getTb_client()['adresse'],0,1);
			$this->Ln(3);
			$this->Cell(35,5,'Nouvelle adresse                   ', 0,0);
			$this->Cell(95,5,': '.$this->getnew_adress(),0,1);
		}
		else
		{
			$this->Cell(35,5,'Adresse', 0,0);
			$this->Cell(95,5,': '.$this->getTb_client()['adresse'],0,1);
		}*/
		$this->Cell(35,5,'Ancienne adresse', 0,0);
			$this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getTb_client()['old_adresse']),0,1);
		$this->Ln(3);
		$this->Cell(35,5,'Nouvelle adresse', 0,0);
			$this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getTb_client()['adresse']),0,1);
		$this->Ln(3);
		$this->Line(180,106,15,106);
		$this->Ln(20);

		$this->Cell(60,5,'Technicien responsable ', 0,0);
		
		$this->Cell(95,5,': .............................................................................', 0,1);
		$this->Ln(3);
		$this->Cell(60,5,'Demenagement demander par', 0,0);
		/*if ($this->getGenerer()) 
		{
			$this->Cell(95,5,': Service commercial'/*.$_SESSION['userName']*, 0,1);
		}
		else $this->Cell(95,5,': Service commercial'/*.$this->getTb_client()['nom_user'*, 0,1);*/
		$this->Cell(95,5,': Service commercial', 0,1);
		$this->Ln(3);
		$this->Cell(60,5,'Date de la demande ', 0,0);
		
		$this->Cell(95,5,': '.$this->getTb_client()['dateDemenager'], 0,1);
		$this->Ln(3);
		$this->Cell(60,5,'Date de demenagement ', 0,0);
		
		$this->Cell(95,5,': .......................................................', 0,1);
		$this->Ln(10);
		//.date('d-m-Y' ,strtotime($this->getdates()))
		//fontin view
		
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Materiel utilisés: '), 0,1);
		$this->Line(16,170,45,170);
		$this->Ln(8);
		$this->Cell(45,5,'Antenne MAC adresse', 0,0);
	    $this->Cell(95,5,':....................................................................................',0,1);
	    $this->Ln(3);
		
		$this->Cell(45,5,'Routeur MAC adresse', 0,0);
	    $this->Cell(95,5,':....................................................................................',0,1);
		$this->Ln(20);
		$this->Cell(45,5,'Cable en (metre)  ', 0,0);
	    $this->Cell(95,5,':....................................................................................',0,1);
	    $this->Ln(3);  
	    $this->Cell(45,5,'Tuyau (en metre)', 0,0);
		$this->Cell(95,5,':....................................................................................',0,1);
		
	    }

	
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->init($tb_client);
$pdf->AddPage();
$pdf->viewTable();
$pdf->Output();
?>
