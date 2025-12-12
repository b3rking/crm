<?php
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');
class PDF extends FPDF
{
    
    var $client;
    var $datecreation;
    var $generer;

    function init($ticket,$client,$generer,$datecreation)
    {
        $this->client = $client;
        $this->generer = $generer;
    }
    function getClient()
    {
        return $this->client;
    }
    function getDate()
    {
        return $this->datecreation;
    }
    function getGenerer()
    {
        return $this->generer;
    }
    function Header()
    {
        $this->image('printing/fiches/logospnet.png',15,20,60);
        //$this->image('printing/fiches/logoajywa.png',15,10,50);
        $this->setMargins(15,100);
        $this->SetFont('Arial','',14);
        $this->Cell(190,5,' '/*.date('d-m-Y')*/,0,1,'R');
        $this->SetFont('Arial','B',14);
         $this->Ln(23);
        $this->Cell(60,5,'',0,0,'C');

        $this->Cell(60,5,'FICHE D\' INSTALLATION',0,0,'C');
        //$this->SetFont('Arial','B',12);
        //$this->Cell(60,5,'Le '.$this->getDate(),0,1,'C');
        $this->SetFont('Arial','B',14);
        $this->Line(76,46,134,46);
    }

    function Footer()
    {
       $this->SetY(-45);
        $this->Cell(95,5, 'Signature de l\'abonne' , 0,0);
        $this->Line(16,260,57,260);
        $this->Cell(75,5, 'Adminstration' , 5,1,'R');
        $this->Line(158,260,184,260);
        $this->SetY(-20);
        $this->Line(16,275,190,275);
        $this->SetFont('Arial','',8);
         //$this->Ln(5);
        $this->Cell(170,5,$_SESSION['nomSociete'].' '. $_SESSION['adresse'] ,0,1,'C');
        $this->Cell(170,5,$_SESSION['telephone'].'  '. $_SESSION['email'],0,1,'C');
        //$this->Cell(170,5,'AJYWA TELECOM BUKAVU,SUD-KIVU , Avenue maniema No. 044 commune IBANDA 06',0,1,'C');
        //$this->Cell(170,5,'Tel:+243 858 666 617 +243 999 336 917 email:info@ajywa.net',0,1,'C');
        //$this->Cell(170,5,'SPIDERNET s.a quartier asiatique rue kirundo Numero 06 B.P 1638 Bujumbura Burundi',0,1,'C');
        //$this->Cell(170,5,'TEL: 257 22 25 84 80 257 22 25 84 81 Fax: 25722258428 info@spidernet-bi.com',0,1,'C');
    }

    function viewTable($ticket)
    {
       $this->Ln(26);
        $this->SetFont('Arial','',12);
        $this->Cell(40,5,'Nom du client', 0,0);
        $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getClient()['Nom_client']), 0,1,'L');
        $this->Ln(3);
        $bande=0; 
        if ($this->getClient()['type_client']!='paying') 
        {
                //$this->Cell(40,5,'ID', 0,0);
            
                //$this->Cell(95,5,': '.$this->getClient()['ID_client'], 0,1,'L');
                $this->Ln(3);
                $this->Cell(40,5,'Telephone', 0,0);
                $this->Cell(95,5,': '.$this->getClient()['telephone'].'  '.$this->getClient()['mobile_phone'], 0,1,'L');
                $this->Ln(3);
                $this->Cell(40,5,'E-mail', 0,0);
                $this->Cell(95,5,': '.$this->getClient()['mail'], 0,1,'L');
                $this->Ln(3);
                $this->Cell(40,5,'Type connexion', 0,0);
               //$this->Cell(95,5,': '.$con, 0,1,'L');
                $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252','Connexion Gratuite'), 0,1,'L');
                
                $this->Ln(3);
                $this->Cell(40,5,'Adresse', 0,0);
                $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getClient()['adresse']), 0,1,'L');
                 $this->Ln(3);
                $this->Cell(40,5,'Adresse IP', 0,0);
                $this->Cell(95,5,': .....................................', 0,1,'L');
                $this->Line(16,122,190,122);
        }
        else
         {
                $bande = $ticket->getBande($this->getClient()['ID_client'])->fetch();
    
                $this->Cell(40,5,'ID', 0,0);
                $this->Cell(95,5,': '.$this->getClient()['billing_number'], 0,1,'L');
                $this->Ln(3);
                $this->Cell(40,5,'Telephone', 0,0);
                $this->Cell(95,5,': '.$this->getClient()['telephone'].' '.$this->getClient()['mobile_phone'], 0,1,'L');
                $this->Ln(3);
                $this->Cell(40,5,'E-mail', 0,0);
                $this->Cell(95,5,': '.$this->getClient()['mail'], 0,1,'L');
                $this->Ln(3);
                $this->Cell(40,5,'Type connexion', 0,0);
                $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$bande['nomService']), 0,1,'L');
                $this->Ln(3);
                $this->Cell(40,5,'Bande passante', 0,0);
                $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$bande['bandepassante']), 0,1,'L');
                
                $this->Ln(3);
                $this->Cell(40,5,'Adresse', 0,0);
                $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$this->getClient()['adresse']), 0,1,'L');
         

        $this->Ln();
        $this->Cell(40,5,'Adresse IP', 0,0);
        $this->Cell(95,5,'  : .....................................', 0,1,'L');
        $this->Line(16,135,190,135);
    }

        $this->Ln(15);

        // Corp du fiche
        
        $this->Cell(50,5,iconv('UTF-8', 'windows-1252','Installation demandée par'), 0,0);
        if ($this->getGenerer())
        {
            $this->Cell(95,5,':   Service commercial' /*$_SESSION['userName']*/, 0,1);
        }
        else $this->Cell(95,5,': Service commercial'/*.$this->getClient()['nom_user']*/, 0,1);
        $this->Ln(3);
        $this->Cell(50,5,iconv('UTF-8', 'windows-1252','Technicien résponsable'), 0,0);
        $this->Cell(95,5,': ......................................................................', 0,1);
        $this->Ln(3);
        $this->Cell(50,5,'Date de la demande', 0,0);
        $this->Cell(95,5,': ', 0,1);
        $this->Ln(3);
        $this->Cell(50,5,'Date d\' installation', 0,0);
        $this->Cell(95,5,': .....................................................................'/*.$this->getDate()*/, 0,1);
        $this->Ln(15);

        $this->setFillColor(112,114,110);
        $this->Cell(50,5,iconv('UTF-8', 'windows-1252','Matériels utilisés'), 0,0,'L',1);
        //$this->Cell(95,5,':......................................................................', 0,1);
        $this->Ln(8);
        $this->Cell(50,5,'Antene MAC Adress', 0,0);
        $this->Cell(95,5,': ......................................................................', 0,1);
        $this->Ln(3);
        $this->Cell(50,10,'Routeur MAC Adress', 0,0);
        $this->Cell(95,5,': ......................................................................', 0,1);
        $this->Ln(15);
        $this->Cell(50,5, 'Cable (en metre)', 0,0);
        $this->Cell(95,5,': ......................................................................', 0,1);
        $this->Ln(3);  
        $this->Cell(50,5,'Tuyau (en metre)',0,0);
        $this->Cell(95,5,': ...................................................................... ', 0,1);
        $this->Ln(3);  
        $this->Cell(50,5,'Connecteur (nombre)',0,0);
        $this->Cell(95,5,': ...................................................................... ', 0,1);

    }
}

$pdf = new PDF();
//$pdf->SetLeftMargin(auto);
//$pdf->SetAutoPageBreak(true,55);
$pdf->init($ticket,$dataClient,$generer,$datecreation);
$pdf->AddPage();
//$pdf->headerTable();
$pdf->viewTable($ticket);
$pdf->Output();
?>
