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
        //$this->image('printing/fiches/logoajywa.png',15,10,40);
        $this->image('printing/fiches/logospnet.png',15.0,10,40);
        $this->setMargins(15,100);
        $this->SetFont('Arial','B',12);
        $this->Ln(15);
        $this->Cell(60,5,'',0,0,'C');
        if ($this->getLangue() == 'anglais')
            $this->Cell(60,5,'CONTRACT No '.$this->getNumeroContrat(),0,1,'C');
        else
        $this->Cell(60,5,'CONTRAT No '.$this->getNumeroContrat(),0,1,'C');
    }

    function Footer()
    {
       
        $this->SetXY(78,-50);
        if ($this->getLangue() == 'anglais')
        {
             $this->Cell(0,5,iconv('UTF-8', 'windows-1252', 'Done at Bujumbura ....../......./20.....'),0,1,'L');
        }
        else
        {
             $this->Cell(0,5,iconv('UTF-8', 'windows-1252', 'Fait à Bujumbura le ....../......./20.....'),0,1,'L');
        }
       
        $this->SetXY(15,-40);
         if ($this->getLangue() == 'anglais')
        {
             $this->Cell(0,5,iconv('UTF-8', 'windows-1252', 'The subscriber'),0,1,'L');
        }
        else
        {
             $this->Cell(0,5, iconv('UTF-8', 'windows-1252', 'Abonné') , 0,0);
        }
       
        $this->SetXY(-15,-40);
        $this->Cell(0,5, $_SESSION['nomSociete'] , 0,1,'R');
        //$this->Line(130,247,189,247);
        $this->Ln(10);
        $this->SetXY(13,-23);
        $this->Line(15,280,195,280);
        $this->SetFont('Arial','B',6);
        $this->Ln(10);
        $this->SetX(45);
        $this->Cell(0,5,$_SESSION['nomSociete'].' '.$_SESSION['adresse'],0,1,'C');
        //$this->SetXY(15,-20);
        $this->SetX(45);
        $this->Cell(0,5,'Tel : '.$_SESSION['telephone'].' mail : ' . $_SESSION['email'],0,1,'C');
    }

    function SetCol($col)
    {
        // Set position at a given column
        $this->col = $col;
        if ($col == 1)
        {
            if($this->nb_article <= 10)
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
        $this->SetFont('Arial','B',10);
        $data = $contract->getClientToPrintToContract($this->getIDcontract())->fetch();
         if($data['langue'] == 'francais')
        {
            $genre = ['societe' => 'Nom de la société ','personnel' => 'Nom du client '];
        
            $this->Cell(37,5,'Contacts :', 0,1);
            $this->SetFont('Arial','',9);

            $this->Cell(46,5,iconv('UTF-8', 'windows-1252','Nom du client'), 0,0);
            $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$data['nom_client']), 0,1);
            $this->Cell(46,5,iconv('UTF-8', 'windows-1252','Personne de référence '), 0,0);
            $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$data['personneDeContact']), 0,1);
            $this->Cell(46,5,iconv('UTF-8', 'windows-1252','Adresse complète '), 0,0);
            $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$data['adresse']), 0,1);
            $this->Cell(46,5,iconv('UTF-8', 'windows-1252','Téléphone '), 0,0);
            $this->Cell(95,5,': '.$data['telephone'].'  '.$data['mobile_phone'], 0,1);
            $this->Cell(46,5,'Email ', 0,0);
            $this->Cell(95,5,': '.$data['mail'], 0,1);
            $this->Cell(46,5,'Type de connexion(s) ', 0,0);
        }
        else
        {
            $genre = ['societe' => 'Company ','personnel' => 'Customer name '];
        
            $this->Cell(37,5,'Contacts :', 0,1);
            $this->SetFont('Arial','',9);
            $this->Cell(46,5,iconv('UTF-8', 'windows-1252','Name of the Customer'), 0,0);
            //$this->Cell(7,5,'', 0,0);
            $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$data['nom_client']), 0,1);
            $this->Cell(46,5,iconv('UTF-8', 'windows-1252','Name of the contact Person '), 0,0); 
            //$this->Cell(7,5,'', 0,0);
            $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$data['personneDeContact']), 0,1);
            $this->Cell(46,5,iconv('UTF-8', 'windows-1252','Full Address '), 0,0);
            //$this->Cell(7,5,'', 0,0);
            $this->Cell(95,5,': '.iconv('UTF-8', 'windows-1252',$data['adresse']), 0,1);
            $this->Cell(46,5,iconv('UTF-8', 'windows-1252','phone number '), 0,0);
            //$this->Cell(7,5,'', 0,0);
            $this->Cell(95,5,': '.$data['telephone'].'  '.$data['mobile_phone'], 0,1);
            $this->Cell(46,5,'Email ', 0,0);
            //$this->Cell(7,5,'', 0,0);
            $this->Cell(95,5,': '.$data['mail'], 0,1);
            $this->Cell(46,5,'Type of the Connexion(s)', 0,0);
           
            
        }

        
        $i = 0;
        $montant_total = 0;
        $service = '';
        foreach ($contract->getServiceToPrintToContract($this->getIDcontract()) as $value) 
        {
            $i++;
            $monnaie = $value->monnaie;
            
            if ($value->status == 0) 
            {
                $montant = $value->montant*$value->quantite;
                $prixTva = $montant*$value->tva/100;
                $montant_total += $montant+$prixTva;
                $service .= '  '.$value->nomService.' '.$value->bandepassante.', ';
            }
          
        }
       // $tarif = ['francais' => 'Tarif mensuel tva comprise :','anglais' => 'Monthly rate VAT included'];
     $service = rtrim($service,'');
        $this->Cell(46,5,iconv('UTF-8', 'windows-1252',':'.$service), 0,1);
            
             if ($this->getLangue() == 'anglais')
              {
                $this->Cell(46,5,iconv('UTF-8', 'windows-1252','Monthly rate VAT included'), 0,0);
                 $this->Cell(95,5,': '.round($montant_total).' '.strtoupper ($monnaie),0,1);
              }
            else
              {
                 $this->Cell(46,5,iconv('UTF-8', 'windows-1252','Tarif Mensuel TTC : '), 0,0);
                  $this->Cell(95,5,': '.round($montant_total).' '.strtoupper ($monnaie),0,1);
              }


      
        $this->Cell(7,5,'', 0,0);
       // $this->Cell(95,5,$tarif[$data['langue']].'  '.round($montant_total).' '.strtoupper ($monnaie),0,1);
        $this->Ln(10);
        $this->y0 = $this->GetY();
    }
    function viewTable($article)
    {
        $this->SetFont('Arial','B',11);
        if ($this->getLangue() == 'anglais')
            $this->Cell(110,5,'Contract articles',0,1,'R');
        else
        $this->Cell(110,5,'Articles du contrat',0,1,'R');
        $this->Ln();
        $this->y0 = $this->GetY();
        //$this->SetFont('Arial','',10);
        $i = 0;
        $row = [];
        //$content = '';
        $article_data = $article->getArticlesDunContract($this->getIDcontract());

        $this->nb_article = count($article_data);
        foreach ($article_data as $value) 
        {
           
            $this->SetFont('Times','B',13);
            $this->Cell(15,5,'Article : '.iconv('UTF-8', 'windows-1252',$value->titre),0,1);
            $this->SetFont('Times','',11);
            $this->MultiCell(60,5,iconv('UTF-8', 'windows-1252',trim($value->corp)));
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