<?php
define('FPDF_FONTPATH', ROOT.'printing/fiches/font');
require('fpdf.php');

/**
 *  
 */
class myPDF extends FPDF
{
    var $dates;
    var $tb_client;
    var $generer;

    function init($dates, $tb_client, $generer)
    {
        $this->tb_client = $tb_client;
        $this->dates = $dates;
        $this->generer = $generer;
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
    }
    
    function header()
    {
        $this->image('printing/fiches/logospnet.png', 15.0, 15, 50);
        $this->setMargins(15, 100);
        $this->SetFont('Arial', 'B', 12);
        
        $this->Ln(25); // Increased from 15 to 25 or more
        
        $this->Cell(180, 5, 'FICHE DE RECUPERATION', 0, 1, 'C');
        // $this->Line(73, 40, 137, 40);
    }
    
    function footer()
    { 
        $this->SetY(-60);
        $this->Cell(95, 5, 'Signature de l\'abonne', 0, 0);
        $this->Line(16, 242, 57, 242);
        $this->Cell(75, 5, 'Adminstration', 5, 1, 'R');
        $this->Line(158, 242, 184, 242);
        $this->SetY(-25);
        $this->Line(16, 270, 190, 270);
        $this->SetFont('Arial', '', 8);
        $this->Cell(170, 5, iconv('UTF-8', 'windows-1252', $_SESSION['nomSociete'].' '. $_SESSION['adresse']), 0, 1, 'C');
        $this->Cell(170, 5, $_SESSION['telephone'].'  '. $_SESSION['email'], 0, 1, 'C');
    }

    function getFirstEmail($emailString) {
        // Split by common delimiters
        $emails = preg_split('/[,\s;]+/', $emailString);
        
        // Find first valid email
        foreach ($emails as $email) {
            $email = trim($email);
            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            }
        }
        
        // Return first non-empty string if no valid email found
        return trim($emails[0]) ?? '';
    }
    
    function viewTable()
    {
        $this->Ln(10); // Réduit de 15 à 10
        $this->SetFont('Arial', '', 10); // Réduit de 12 à 10
        //endroit de donnes du client
        $this->Cell(35, 4, 'Nom du client ', 0, 0); // Réduit de 5 à 4
        $this->Cell(95, 4, ': '.iconv('UTF-8', 'windows-1252', $this->getTb_client()['Nom_client']), 0, 1);
        $this->Ln(2); // Réduit de 3 à 2
        $this->Cell(35, 4, 'ID                  ', 0, 0);
        $this->Cell(95, 4, ': '.$this->getTb_client()['billing_number'], 0, 1);
        $this->Ln(2);
        $this->Cell(35, 4, 'Telephone                   ', 0, 0);
        $this->Cell(95, 4, ': '.$this->getTb_client()['telephone'].' '.$this->getTb_client()['mobile_phone'], 0, 1);
        $this->Ln(2);
        $this->Cell(35, 4, 'E-mail                   ', 0, 0);
        $email = $this->getFirstEmail($this->getTb_client()['mail']);
        $this->Cell(95, 4, ': '.$email, 0, 1);
        $this->Ln(2);
        $this->Cell(35, 4, 'Adresse', 0, 0);
        $this->Cell(95, 4, ': '.iconv('UTF-8', 'windows-1252', $this->getTb_client()['adresse']), 0, 1);
        $this->Ln(2);
        $this->Cell(35, 4, 'Montant', 0, 0);
        $amount = $this->getTb_client()['amount'] ?? 'N/A';
        $monnaie = $this->getTb_client()['monnaie'] ?? '';
        $this->Cell(95, 4, ': '.$amount.' '.$monnaie, 0, 1);
        
        // $this->Line(180, 88, 15, 88); // Corrigé: changé de 95 à 88
        
        // CHAMP POUR LA RAISON DE LA RECUPERATION
        $this->Ln(8); // Réduit de 10 à 8
        $this->SetFont('Arial', 'B', 10); // Réduit de 12 à 10
        $this->Cell(60, 4, 'Motif de la recuperation', 0, 1);
        // Obtenir la position Y actuelle
        $y_after_title = $this->GetY();
        // Line removed here - only comment kept for reference
        // $this->Line(16, $y_after_title, 60, $y_after_title); // REMOVED LINE
        $this->Ln(6); // Réduit de 8 à 6
        // Lignes pour ecrire la raison (2-3 phrases)
        $this->SetFont('Arial', '', 10); // Assure la cohérence
        $this->Cell(180, 4, '..............................................................................................................................................', 0, 1);
        $this->Ln(3); // Réduit de 5 à 3
        $this->Cell(180, 4, '..............................................................................................................................................', 0, 1);
        $this->Ln(3);
        $this->Cell(180, 4, '..............................................................................................................................................', 0, 1);
        $this->Ln(10); // Réduit de 15 à 10
        
        $this->SetFont('Arial', '', 10); // Réduit de 12 à 10
        $this->Cell(60, 4, 'Technicien responsable ', 0, 0);
        $this->Cell(95, 4, ': .............................................................................', 0, 1);
        $this->Ln(2);
        $this->Cell(60, 4, 'Recuperation demandee par', 0, 0);
        if ($this->getGenerer()) 
        {
            $this->Cell(95, 4, ': Service commercial', 0, 1);
        }
        else {
            $this->Cell(95, 4, ': Service commercial', 0, 1);
        }
        $this->Ln(2);
        $this->Cell(60, 4, 'Date de la demande ', 0, 0);
        $this->Cell(95, 4, ': '.date('d-m-Y', strtotime($this->getdates())), 0, 1);
        $this->Ln(2);
        $this->Cell(60, 4, 'Date de la recuperation ', 0, 0);
        $this->Cell(95, 4, ': .......................................', 0, 1);
        $this->Ln(8); // Réduit de 10 à 8
        
        $this->SetFont('Arial', '', 10); // Réduit de 12 à 10
        $this->Cell(60, 4, iconv('UTF-8', 'windows-1252', 'Materiels recuperes: '), 0, 1);
        $y_after_materiel = $this->GetY();
        // $this->Line(16, $y_after_materiel, 53, $y_after_materiel);
        $this->Ln(6); // Réduit de 8 à 6
        $this->Cell(45, 4, 'Antenne MAC adresse', 0, 0);
        $this->Cell(95, 4, ':....................................................................................', 0, 1);
        $this->Ln(2);
        
        $this->Cell(45, 4, 'Routeur MAC adresse', 0, 0);
        $this->Cell(95, 4, ':....................................................................................', 0, 1);
        $this->Ln(15); // Réduit de 20 à 15
        $this->Cell(45, 4, 'Tuyau (en metre)', 0, 0);
        $this->Cell(95, 4, ':....................................................................................', 0, 1);
        $this->Ln(2);  
        $this->Cell(45, 4, 'Connecteur (nombre)', 0, 0);
        $this->Cell(95, 4, ':....................................................................................', 0, 1);
    }
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->init($dates, $tb_client, $generer);
$pdf->AddPage();
$pdf->viewTable();
$pdf->Output();














// define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
// require('fpdf.php');
 
// /**
//  *  
//  */
// class myPDF extends FPDF
// {
	
// 	var $dates;
// 	var $tb_client;
// 	var $generer;

// 	function init($dates,$tb_client,$generer)
// 	{
// 		$this->tb_client = $tb_client;
// 		$this->dates = $dates;
// 		$this->generer = $generer;
// 	}
// 	function getdates()
// 	{
// 		return $this->dates;
// 	}
// 	function getTb_client()
// 	{
// 		return $this->tb_client;
// 	}
// 	function getGenerer()
// 	{
// 		return $this->generer;
// 	}
// 	function header()
//     {
//         $this->image('printing/fiches/logospnet.png', 15.0, 15, 50);
//         $this->setMargins(15, 100);
//         $this->SetFont('Arial', '', 12);
        
//         $this->Ln(25); // Increased from 15 to 25 or more
        
//         $this->Cell(180, 5, 'FICHE DE RECUPERATION', 0, 1, 'C');
//         $this->Line(73, 40, 137, 40);
//     }
    
// 	function footer()
// 	{ 
// 		$this->SetY(-60);
// 		$this->Cell(95,5, 'Signature de l\'abonne' , 0,0);
// 		$this->Line(16,242,57,242);
// 	    $this->Cell(75,5, 'Adminstration' , 5,1,'R');
// 	    $this->Line(158,242,184,242);
// 		$this->SetY(-25);
// 		$this->Line(16,270,190,270);
// 		$this->SetFont('Arial','',8);
// 		$this->Cell(170,5,iconv('UTF-8', 'windows-1252',$_SESSION['nomSociete'].' '. $_SESSION['adresse']) ,0,1,'C');
// 		$this->Cell(170,5,$_SESSION['telephone'].'  '. $_SESSION['email'],0,1,'C');
// 		// $this->Cell(170,5,'AJYWA TELECOM BUKAVU,SUD-KIVU , Avenue maniema No. 044 commune IBANDA 06',0,1,'C');
// 		// $this->Cell(170,5,'Tel:+243 858 666 617 +243 999 336 917 email:info@ajywa.net',0,1,'C');
// 	}
//     function viewTable()
// 	{
// 		$this->Ln(10); // Réduit de 15 à 10
// 		$this->SetFont('Arial','',10); // Réduit de 12 à 10
// 		//endroit de donnes du client
// 		$this->Cell(35,4,'Nom du client ', 0,0); // Réduit de 5 à 4
// 		$this->Cell(95,4,': '.iconv('UTF-8', 'windows-1252',$this->getTb_client()['Nom_client']),0,1);
// 		$this->Ln(2); // Réduit de 3 à 2
// 		$this->Cell(35,4,'ID                  ', 0,0);
// 		$this->Cell(95,4,': '.$this->getTb_client()['billing_number'],0,1);
// 		$this->Ln(2);
// 		$this->Cell(35,4,'Telephone                   ', 0,0);
// 		$this->Cell(95,4,': '.$this->getTb_client()['telephone'].' '.$this->getTb_client()['mobile_phone'],0,1);
// 		$this->Ln(2);
// 		$this->Cell(35,4,'E-mail                   ', 0,0);
// 		$this->Cell(95,4,': '.$this->getTb_client()['mail'],0,1);
// 		$this->Ln(2);
// 		$this->Cell(35,4,'adresse', 0,0);
// 		$this->Cell(95,4,': '.iconv('UTF-8', 'windows-1252',$this->getTb_client()['adresse']),0,1);
		
// 		$this->Line(180,88,15,88); // Corrigé: changé de 95 à 88
		
// 		// CHAMP POUR LA RAISON DE LA RECUPERATION
// 		$this->Ln(8); // Réduit de 10 à 8
// 		$this->SetFont('Arial','B',10); // Réduit de 12 à 10
// 		$this->Cell(60,4,'Motif de la recuperation', 0,1);
// 		// Obtenir la position Y actuelle
// 		// $y_after_title = $this->GetY();
// 		// $this->Line(16, $y_after_title, 60, $y_after_title);
// 		// $this->Ln(6); // Réduit de 8 à 6
// 		// Lignes pour ecrire la raison (2-3 phrases)
// 		$this->SetFont('Arial','',10); // Assure la cohérence
// 		$this->Cell(180,4,'..............................................................................................................................................', 0,1);
// 		$this->Ln(3); // Réduit de 5 à 3
// 		$this->Cell(180,4,'..............................................................................................................................................', 0,1);
// 		$this->Ln(3);
// 		$this->Cell(180,4,'..............................................................................................................................................', 0,1);
// 		$this->Ln(10); // Réduit de 15 à 10
		
// 		$this->SetFont('Arial','',10); // Réduit de 12 à 10
// 		$this->Cell(60,4,'Technicien responsable ', 0,0);
		
// 		$this->Cell(95,4,': .............................................................................', 0,1);
// 		$this->Ln(2);
// 		$this->Cell(60,4,'Recuperation demandee par', 0,0);
// 		if ($this->getGenerer()) 
// 		{
// 			$this->Cell(95,4,': Service commercial', 0,1);
// 		}
// 		else $this->Cell(95,4,': Service commercial'/*.$this->getTb_client()['nom_user']*/, 0,1);
// 		$this->Ln(2);
// 		$this->Cell(60,4,'Date de la demande ', 0,0);
		
// 		$this->Cell(95,4,': '.date('d-m-Y' ,strtotime($this->getdates())), 0,1);
// 		$this->Ln(2);
// 		$this->Cell(60,4,'Date de la recuperation ', 0,0);
		
// 		$this->Cell(95,4,': .......................................' , 0,1);
// 		$this->Ln(8); // Réduit de 10 à 8
		
// 	//.date('d-m-Y' ,strtotime($this->getdates()))
// 	//fontin view
		
// 		$this->SetFont('Arial','',10); // Réduit de 12 à 10
// 		$this->Cell(60,4,iconv('UTF-8', 'windows-1252', 'Materiels recuperes: '), 0,1);
// 		$y_after_materiel = $this->GetY();
// 		$this->Line(16, $y_after_materiel, 53, $y_after_materiel);
// 		$this->Ln(6); // Réduit de 8 à 6
// 		$this->Cell(45,4,'Antenne MAC adresse', 0,0);
// 	    $this->Cell(95,4,':....................................................................................',0,1);
// 	    $this->Ln(2);
		
// 		$this->Cell(45,4,'Routeur MAC adresse', 0,0);
// 	    $this->Cell(95,4,':....................................................................................',0,1);
// 		$this->Ln(15); // Réduit de 20 à 15
// 		//$this->Cell(45,5,'Cable (en metre)  ', 0,0);
// 	    //$this->Cell(95,5,':....................................................................................',0,1);
// 	    $this->Ln(2);  
// 	    $this->Cell(45,4,'Tuyau (en metre)', 0,0);
// 		$this->Cell(95,4,':....................................................................................',0,1);
// 		 $this->Ln(2);  
// 	    $this->Cell(45,4,'Connecteur (nombre)', 0,0);
// 		$this->Cell(95,4,':....................................................................................',0,1);
		
// 	    }
// }

// $pdf = new myPDF();
// $pdf->AliasNbPages();
// $pdf->init($dates,$tb_client,$generer);
// $pdf->AddPage();
// $pdf->viewTable();
// $pdf->Output();
?>
































// define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
// require('fpdf.php');
 
// /**
//  *  
//  */
// class myPDF extends FPDF
// {
	
// 	var $dates;
// 	var $tb_client;
// 	var $generer;

// 	function init($dates,$tb_client,$generer)
// 	{
// 		$this->tb_client = $tb_client;
// 		$this->dates = $dates;
// 		$this->generer = $generer;
// 	}
// 	function getdates()
// 	{
// 		return $this->dates;
// 	}
// 	function getTb_client()
// 	{
// 		return $this->tb_client;
// 	}
// 	function getGenerer()
// 	{
// 		return $this->generer;
// 	}
// 	function header()
// 	{
// 		$this->image('printing/fiches/logospnet.png',15.0,15,50);
// 		//$this->image('printing/fiches/logoajywa.png',15,10,50);
// 		$this->setMargins(15,100);
// 		$this->SetFont('Arial','',14);
// 		//$this->Cell(190,5,'Le '.date('d-m-Y'),0,1,'R');
// 		$this->Ln(20);
// 		$this->Cell(180,5,'FICHE DE RECUPERATION',0,1,'C');
// 		$this->Line(73,40,137,40);	
// 	}
// 	function footer()
// 	{ 
// 		$this->SetY(-60);
// 		$this->Cell(95,5, 'Signature de l\'abonne' , 0,0);
// 		$this->Line(16,242,57,242);
// 	    $this->Cell(75,5, 'Adminstration' , 5,1,'R');
// 	    $this->Line(158,242,184,242);
// 		$this->SetY(-25);
// 		$this->Line(16,270,190,270);
// 		$this->SetFont('Arial','',8);
// 		$this->Cell(170,5,iconv('UTF-8', 'windows-1252',$_SESSION['nomSociete'].' '. $_SESSION['adresse']) ,0,1,'C');
// 		$this->Cell(170,5,$_SESSION['telephone'].'  '. $_SESSION['email'],0,1,'C');
// 		// $this->Cell(170,5,'AJYWA TELECOM BUKAVU,SUD-KIVU , Avenue maniema No. 044 commune IBANDA 06',0,1,'C');
// 		// $this->Cell(170,5,'Tel:+243 858 666 617 +243 999 336 917 email:info@ajywa.net',0,1,'C');
// 	}
//     function viewTable()
// 	{
// 		$this->Ln(15);
// 		$this->SetFont('Arial','',12);
// 		//endroit de donnes du client
// 		$this->Cell(35,5,'Nom du client ', 0,0);
// 		$this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getTb_client()['Nom_client']),0,1);
// 		$this->Ln(3);
// 		$this->Cell(35,5,'ID                  ', 0,0);
// 		$this->Cell(95,5,': '.$this->getTb_client()['billing_number'],0,1);
// 		$this->Ln(3);
// 		$this->Cell(35,5,'Telephone                   ', 0,0);
// 		$this->Cell(95,5,': '.$this->getTb_client()['telephone'].' '.$this->getTb_client()['mobile_phone'],0,1);
// 		$this->Ln(3);
// 		$this->Cell(35,5,'E-mail                   ', 0,0);
// 		$this->Cell(95,5,': '.$this->getTb_client()['mail'],0,1);
// 		//$this->Ln(3);
// 		//$this->Cell(35,5,'Type connexion                   ', 0,0);
// 		//$this->Cell(95,5,': '.$this->getTb_client()['nomService'],0,1);
// 		$this->Ln(3);
// 		$this->Cell(35,5,'adresse', 0,0);
// 		$this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getTb_client()['adresse']),0,1);
		
// 		$this->Line(180,102,15,102);
		
// 		// CHAMP POUR LA RAISON DE LA RECUPERATION
// 		$this->Ln(10);
// 		$this->SetFont('Arial','B',12);
// 		$this->Cell(60,5,'Motif de la recuperation', 0,1);
// 		$this->SetFont('Arial','',12);
// 		$this->Line(16,125,60,125);
// 		$this->Ln(8);
// 		// Lignes pour ecrire la raison (2-3 phrases)
// 		$this->Cell(180,5,'..............................................................................................................................................', 0,1);
// 		$this->Ln(5);
// 		$this->Cell(180,5,'..............................................................................................................................................', 0,1);
// 		$this->Ln(5);
// 		$this->Cell(180,5,'..............................................................................................................................................', 0,1);
// 		$this->Ln(15);
		
// 		$this->Cell(60,5,'Technicien responsable ', 0,0);
		
// 		$this->Cell(95,5,': .............................................................................', 0,1);
// 		$this->Ln(3);
// 		$this->Cell(60,5,'Recuperation demandee par', 0,0);
// 		if ($this->getGenerer()) 
// 		{
// 			$this->Cell(95,5,': Service commercial', 0,1);
// 		}
// 		else $this->Cell(95,5,': Service commercial'/*.$this->getTb_client()['nom_user']*/, 0,1);
// 		$this->Ln(3);
// 		$this->Cell(60,5,'Date de la demande ', 0,0);
		
// 		$this->Cell(95,5,': '.date('d-m-Y' ,strtotime($this->getdates())), 0,1);
// 		$this->Ln(3);
// 		$this->Cell(60,5,'Date de la recuperation ', 0,0);
		
// 		$this->Cell(95,5,': .......................................' , 0,1);
// 		$this->Ln(10);
// 	//.date('d-m-Y' ,strtotime($this->getdates()))
// 	//fontin view
		
// 		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Materiels recuperes: '), 0,1);
// 		$this->Line(16,159,53,159);
// 		$this->Ln(8);
// 		$this->Cell(45,5,'Antenne MAC adresse', 0,0);
// 	    $this->Cell(95,5,':....................................................................................',0,1);
// 	    $this->Ln(3);
		
// 		$this->Cell(45,5,'Routeur MAC adresse', 0,0);
// 	    $this->Cell(95,5,':....................................................................................',0,1);
// 		$this->Ln(20);
// 		//$this->Cell(45,5,'Cable (en metre)  ', 0,0);
// 	    //$this->Cell(95,5,':....................................................................................',0,1);
// 	    $this->Ln(3);  
// 	    $this->Cell(45,5,'Tuyau (en metre)', 0,0);
// 		$this->Cell(95,5,':....................................................................................',0,1);
// 		 $this->Ln(3);  
// 	    $this->Cell(45,5,'Connecteur (nombre)', 0,0);
// 		$this->Cell(95,5,':....................................................................................',0,1);
		
// 	    }
// }

// $pdf = new myPDF();
// $pdf->AliasNbPages();
// $pdf->init($dates,$tb_client,$generer);
// $pdf->AddPage();
// $pdf->viewTable();
// $pdf->Output();














// define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
// require('fpdf.php');
 
// /**
//  *  
//  */
// class myPDF extends FPDF
// {
	
// 	var $dates;
// 	var $tb_client;
// 	var $generer;

// 	function init($dates,$tb_client,$generer)
// 	{
// 		$this->tb_client = $tb_client;
// 		$this->dates = $dates;
// 		$this->generer = $generer;
// 	}
// 	function getdates()
// 	{
// 		return $this->dates;
// 	}
// 	function getTb_client()
// 	{
// 		return $this->tb_client;
// 	}
// 	function getGenerer()
// 	{
// 		return $this->generer;
// 	}
// 	function header()
// 	{
// 		$this->image('printing/fiches/logospnet.png',15.0,15,50);
// 		//$this->image('printing/fiches/logoajywa.png',15,10,50);
// 		$this->setMargins(15,100);
// 		$this->SetFont('Arial','',14);
// 		//$this->Cell(190,5,'Le '.date('d-m-Y'),0,1,'R');
// 		$this->Ln(20);
// 		$this->Cell(180,5,'FICHE DE RECUPERATION',0,1,'C');
// 		$this->Line(73,40,137,40);	
// 	}
// 	function footer()
// 	{ 
// 		$this->SetY(-60);
// 		$this->Cell(95,5, 'Signature de l\'abonne' , 0,0);
// 		$this->Line(16,242,57,242);
// 	    $this->Cell(75,5, 'Adminstration' , 5,1,'R');
// 	    $this->Line(158,242,184,242);
// 		$this->SetY(-25);
// 		$this->Line(16,270,190,270);
// 		$this->SetFont('Arial','',8);
// 		$this->Cell(170,5,iconv('UTF-8', 'windows-1252',$_SESSION['nomSociete'].' '. $_SESSION['adresse']) ,0,1,'C');
// 		$this->Cell(170,5,$_SESSION['telephone'].'  '. $_SESSION['email'],0,1,'C');
// 		// $this->Cell(170,5,'AJYWA TELECOM BUKAVU,SUD-KIVU , Avenue maniema No. 044 commune IBANDA 06',0,1,'C');
// 		// $this->Cell(170,5,'Tel:+243 858 666 617 +243 999 336 917 email:info@ajywa.net',0,1,'C');
// 	}
//     function viewTable()
// 	{
// 		$this->Ln(15);
// 		$this->SetFont('Arial','',12);
// 		//endroit de donnes du client
// 		$this->Cell(35,5,'Nom du client ', 0,0);
// 		$this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getTb_client()['Nom_client']),0,1);
// 		$this->Ln(3);
// 		$this->Cell(35,5,'ID                  ', 0,0);
// 		$this->Cell(95,5,': '.$this->getTb_client()['billing_number'],0,1);
// 		$this->Ln(3);
// 		$this->Cell(35,5,'Telephone                   ', 0,0);
// 		$this->Cell(95,5,': '.$this->getTb_client()['telephone'].' '.$this->getTb_client()['mobile_phone'],0,1);
// 		$this->Ln(3);
// 		$this->Cell(35,5,'E-mail                   ', 0,0);
// 		$this->Cell(95,5,': '.$this->getTb_client()['mail'],0,1);
// 		//$this->Ln(3);
// 		//$this->Cell(35,5,'Type connexion                   ', 0,0);
// 		//$this->Cell(95,5,': '.$this->getTb_client()['nomService'],0,1);
// 		$this->Ln(3);
// 		$this->Cell(35,5,'adresse', 0,0);
// 		$this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getTb_client()['adresse']),0,1);
		
// 		$this->Line(180,102,15,102);
// 		$this->Ln(20);

// 		$this->Cell(60,5,'Technicien responsable ', 0,0);
		
// 		$this->Cell(95,5,': .............................................................................', 0,1);
// 		$this->Ln(3);
// 		$this->Cell(60,5,iconv('UTF-8', 'windows-1252','Récupération demandée par'), 0,0);
// 		if ($this->getGenerer()) 
// 		{
// 			$this->Cell(95,5,': Service commercial', 0,1);
// 		}
// 		else $this->Cell(95,5,': Service commercial'/*.$this->getTb_client()['nom_user']*/, 0,1);
// 		$this->Ln(3);
// 		$this->Cell(60,5,'Date de la demande ', 0,0);
		
// 		$this->Cell(95,5,': '.date('d-m-Y' ,strtotime($this->getdates())), 0,1);
// 		$this->Ln(3);
// 		$this->Cell(60,5,'Date de la recuperation ', 0,0);
		
// 		$this->Cell(95,5,': .......................................' , 0,1);
// 		$this->Ln(10);
// 	//.date('d-m-Y' ,strtotime($this->getdates()))
// 	//fontin view
		
// 		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Materiels recuperés: '), 0,1);
// 		$this->Line(16,159,53,159);
// 		$this->Ln(8);
// 		$this->Cell(45,5,'Antenne MAC adresse', 0,0);
// 	    $this->Cell(95,5,':....................................................................................',0,1);
// 	    $this->Ln(3);
		
// 		$this->Cell(45,5,'Routeur MAC adresse', 0,0);
// 	    $this->Cell(95,5,':....................................................................................',0,1);
// 		$this->Ln(20);
// 		//$this->Cell(45,5,'Cable (en metre)  ', 0,0);
// 	    //$this->Cell(95,5,':....................................................................................',0,1);
// 	    $this->Ln(3);  
// 	    $this->Cell(45,5,'Tuyau (en metre)', 0,0);
// 		$this->Cell(95,5,':....................................................................................',0,1);
// 		 $this->Ln(3);  
// 	    $this->Cell(45,5,'Connecteur (nombre)', 0,0);
// 		$this->Cell(95,5,':....................................................................................',0,1);
		
// 	    }
// }

// $pdf = new myPDF();
// $pdf->AliasNbPages();
// $pdf->init($dates,$tb_client,$generer);
// $pdf->AddPage();
// $pdf->viewTable();
// $pdf->Output();
