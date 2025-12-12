
<?php
define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
require('fpdf.php');

/**
 *  
 */
class myPDF extends FPDF
{
	
	var $datemission;
	var $dateRetour;

	function init($datemission,$dateRetour)
	{
		$this->datemission = $datemission;
		$this->dateRetour = $dateRetour;
	}
	function getDateRetour()
	{
		return $this->dateRetour;
	}
	function getDateMission()
	{
		return $this->datemission;
	}
	function header()
	{
		$this->SetY(20);
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		//$this->image('printing/fiches/logoajywa.png',15,10,40);
		$this->setMargins(15,100);
		$this->SetFont('Arial','',12);
		//$this->SetY();
		$this->Cell(180,1,'Le '.date('d-m-Y'),0,1,'R');
		
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		$this->Cell(60,5,'',0,0,'C');
		//$this->Line(85,39,126,39);
		$this->SetFont('Arial','',12);
		//$this->Line(85,39,126,39);
		$this->Cell(60,5,'FICHE DE MISSION',0,1,'C');
		$this->Line(85,39,126,39);
		$this->Ln(3);

	}
	function footer()
	{
		$this->SetY(-25);
		//$this->SetX(15);
		$this->Cell(200,5,'',0,1);
			
        $this->Rect(15,245,180,25);
    	$this->Cell(100,1,'',0,0);
	    $this->Cell(100,1,'Nom et signature du chef de service ' , 0,1,'L');
	    //$this->Ln(5);
	    //$this->SetX(200);
	    //$this->Ln(3);	
	}
	function headerTable()
	{

	}
	function viewTable($technicien,$user)
	{
            $this->Cell(150,10,'NOTE DE MISSION',1,0,'C');
			$this->Cell(30,10,'Num Ref',1,1);
			//$this->Cell(20,10,'',1,1);

			//.date('d-m-Y' ,strtotime($this->getdates()))
			$this->Cell(41,10,'Date de depart',1,0);
			$this->Cell(34,10,' '.date('d-m-Y' ,strtotime($this->getDateMission())),1,0);
            $this->Cell(41,10,'Date de retour',1,0);
            $this->Cell(34,10,' '.date('d-m-Y' ,strtotime($this->getDateRetour())),1,0);
            $this->Cell(30,10,'SP-04-2020-01'/*.rand()*/,1,1);
			$this->Cell(75,10,'Destination',1,0);$this->Cell(105,10,'',1,1);
			$this->Cell(75,10,'Objetctif de la mission',1,0);$this->Cell(105,10,'',1,1);
			//$this->Cell(75,10,' ',0,1);
			$this->Cell(20,10,'Technicien Spidernet',0,1);
			$this->Cell(20,10,'Numero',1,0);
			$this->Cell(88,10,'   Nom'.'   et      Prenom',1,0);
			$this->Cell(42,10,'Frais de mission',1,0);
			$this->Cell(30,10,'Reception',1,1);
			$i = 0;
			foreach ($technicien as $value) 
			{
				foreach ($user->afficheUser($value) as $value2) 
				{
					$i++;
					$this->Cell(20,10,$i,1,0);
					$this->Cell(88,10,$value2->nom_user,1,0);
					$this->Cell(42,10,'',1,0);
					$this->Cell(30,10,'',1,1);
				}
			}
			$this->Cell(20,10,'         ',0,0);
			$this->Cell(88,10,'      Total     ',0,0);
			$this->Cell(42,10,'',1,0);
			$this->Cell(30,10,'    ',1,1);
	
			$this->Cell(20,10,'Autres technicien',0,1);//en tete
			$this->Cell(20,10,'Numero',1,0);
			$this->Cell(88,10,'       Nom      prenom     et         entreprise',1,0);
			$this->Cell(42,10,'frais',1,0);
			$this->Cell(30,10,'reception',1,1);

			$this->Cell(20,10,'1',1,0);$this->Cell(88,10,'',1,0);$this->Cell(42,10,'',1,0);$this->Cell(30,10,'',1,1);
			$this->Cell(20,10,'2',1,0);$this->Cell(88,10,'',1,0);$this->Cell(42,10,'',1,0);$this->Cell(30,10,'',1,1);
			$this->Cell(20,10,'3',1,0);$this->Cell(88,10,'',1,0);$this->Cell(42,10,'',1,0);$this->Cell(30,10,'',1,1);
/*			

			*/
			$this->Cell(20,10,'Autres frais',0,1);
			$this->Cell(108,10,'Libelle',1,0);
			//$this->Cell(80,10,'Motif / Beneficiaire ',1,0);
			$this->Cell(42,10,'Montant',1,0);
			$this->Cell(30,10,'Reception',1,1);

			$this->Cell(108,10,'',1,0);
			//$this->Cell(80,10,'         ',1,0);
			$this->Cell(42,10,'',1,0);
			$this->Cell(30,10,'',1,1);


			$this->Cell(28,10,'',0,0);
			$this->Cell(80,10,'Total des frais',0,0);
			$this->Cell(42,10,'',1,0);
			$this->Cell(30,10,'',1,1);
			
			$this->Ln(7,5);
			$this->Cell(200,5,'Rapport de mission ',0,1);
			//$this->Ln(4);
		}
	}

$pdf = new myPDF();
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->init($datemission,$dateRetour);
$pdf->headerTable();
$pdf->viewTable($technicien,$user);
$pdf->Output();
?>
