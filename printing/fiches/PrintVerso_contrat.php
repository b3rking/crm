<?php
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');
class PDF extends FPDF
{
    protected $col = 0; // Current column
    protected $y0;      // Ordinate of column start
    
    var $nb_article;
    var $idcontract;
    var $numero;
    var $langue;

    function init($idcontract,$numero,$langue)
    {
        $this->numero = $numero;
        $this->idcontract = $idcontract;
        $this->langue = $langue;
    }
    function getIDcontract()
    {
        return $this->idcontract;
    }
    function getNumeroContrat()
    {
        return $this->numero;
    }
    function getLangue()
    {
        return $this->langue;
    }
    function Header()
    {
        $this->image('printing/fiches/logospnet.png',15.0,10,40);
        $this->setMargins(15,100);
        $this->SetFont('Arial','B',12);
        $this->Ln(15);
        $this->Cell(60,5,'',0,0,'C');
       
        $this->Cell(60,5,'CONTRAT DE PRET A INTERET OU COMODAT POUR EQUIPEMENT ',0,1,'C');
    }

    function Footer()
    {
       $this->Rect(15,258,180,25);
         $this->Ln(15);

        $this->SetXY(20,-25);
    
        $this->Cell(10,5,iconv('UTF-8', 'windows-1252', 'A ........... le ....../......./.......'),0,0,'L');
        $this->Cell(110,5,' ',0,0);
        $this->Cell(50,5,iconv('UTF-8', 'windows-1252', 'A Bujumbura le ....../......./20...'),0,1,'L');
       
         $this->SetFont('Arial','',8);
            $this->SetXY(20,-32);
        $this->Cell(10,5, iconv('UTF-8', 'windows-1252', 'Pour l\'abonné / Emprunteur') , 0,0);
        $this->Cell(110,5,' ',0,0);
        $this->SetFont('Arial','B',8);
        $this->Cell(60,5, iconv('UTF-8', 'windows-1252', 'Pour SPIDERNET / Prêteur') , 0,1);
        $this->Ln(10);
        $this->SetXY(13,-23);
      ///  $this->Line(15,280,195,280);
        $this->SetFont('Arial','B',8);
        $this->Ln(10);
        $this->SetX(45);
        $this->Cell(30,5,' ',0,0);
        //$this->Ln(35);
        $this->Cell(5,5,iconv('UTF-8', 'windows-1252', '(1) faire obligatoirement précéder la signature de la mention manuscrite "Lu et accepté".'),0,1,'C');
        
    }

    function SetCol($col)
    {
        // Set position at a given column
        $this->col = $col;
        if ($col == 1)
        {
            if($this->nb_article <= 9)
                $x = 60+$col*67;
            else
                $x = 10+$col*67;
        } 
        else $x = 10+$col*65;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

    function AcceptPageBreak()
    {
        // Method accepting or not automatic page break
        if($this->col<2)
        {
            // Go to next column
            $this->SetCol($this->col+1);
            // Set ordinate to top
            $this->SetY($this->y0);
            // Keep on page
            return false;
        }
        else
        {
            // Go back to first column
            $this->SetCol(0);
            // Page break
            return true;
        }
    }
    function headerTable($contract)
    {
        $this->Ln(10);
        $this->SetFont('Arial','',10);
        $this->Cell(200,5,iconv('UTF-8', 'windows-1252', 'Entre SPIDERNET, ci après dénommé <<Le prêteur>>, d\'une part,') ,0,1);
        $this->Cell(200,5,'Et ...................................................................................................................',0,1);
        $this->Cell(200,5,iconv('UTF-8', 'windows-1252', 'Représenté(e) par : .........................................................................................'),0,1);
        $this->Cell(200,5,iconv('UTF-8', 'windows-1252', 'Ci-après dénommé <<Le prêteur>>, d\'une part,') ,0,1);
            $this->Ln();
            $this->Rect(15,35,180,26);
    }
    function viewTable($article)
    {
        $this->SetFont('Arial','B',11);
        
        $this->Cell(110,5,'Il est convenu ce qui suit :',0,1,'R');
        $this->Ln();
        $this->y0 = $this->GetY();
        $i = 0;
        $row = [];
        $articleVerso = $article->getVersoArticle();

        $this->nb_article = count($articleVerso);
        foreach ($articleVerso as $value) 
        {
            
            $this->SetFont('Times','B',12);
            $this->Cell(15,5,'ARTICLE : '.iconv('UTF-8', 'windows-1252',$value->titre),0,1);
            $this->SetFont('Times','',10);
            $this->MultiCell(60,5,iconv('UTF-8', 'windows-1252',trim($value->contenu)));
            $this->Ln();
        }
    }
}

$pdf = new PDF();
$pdf->SetLeftMargin(15);
$pdf->SetAutoPageBreak(true,55);
$pdf->init($idcontract,$numero,$langue);
$pdf->AddPage();
$pdf->headerTable($contract);
$pdf->viewTable($article);
$pdf->Output();
?>