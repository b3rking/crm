<?php
define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
//	var $facture_id;
    var $tva;
    var $client;

    protected $contract;
    protected $facture_id;

//    public function __construct($contract,$facture_id)
//    {
//        $this->contract = $contract;
//        $this->facture_id = $facture_id;
//    }
	function init($contract,$facture_id,$client)
	{
		$this->contract = $contract;
        $this->facture_id = $facture_id;
        $this->client = $client;
	}
	function getFactureId()
	{
		return $this->facture_id;
	}
	function getClient()
	{
		return $this->client;
	}
    function getFacture()
    {
        return $this->contract->recupererUnProformat($this->facture_id)->fetch();
    }
    function setTva()
    {
        $facture = $this->getFacture();
        $this->tva = $facture['tva'] + $facture['tvci'];
    }
	var $widths;
	var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}
	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++; 
		}
		return $nl;
	}


	function header() 
	{
		//$this->image('printing/fiches/logoajywa.png',15,10,50);
		//$this->image('image_profil/702.jpg',5,10,200,280);
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		/*$this->SetFont('Arial','B',10);
		$this->setY(15);
		$this->Cell(99,5,'',0,0);
		$this->Cell(60,5,$_SESSION['nomSociete'],0,1);
		$this->SetFont('Arial','',10);
		$this->Cell(99,5,'',0,0);
		$this->Cell(60,5,$_SESSION['adresse'],0,1);
		$this->Cell(99,5,'',0,0);
		$this->Cell(60,5,'UVIRA,SUD-KIVU',0,1);
		$this->Cell(99,5,'',0,0);
		$this->Cell(60,5,$_SESSION['telephone'],0,1);
		$this->setXY(20,50);
		$this->SetFont('Arial','',12);*/
		$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		//$this->Cell(60,10,'FACTURE No '.$this->getFactureId().'  du '.date('d-m-Y'),0,1,'C');
		//$this->Line(61,30,149,30);
	}
	function footer()
	{
		$client = $this->getClient();
	    $this->Ln();
		$this->SetY(-65);
		//$this->Line(15,262,195,262);

		$this->SetFont('Arial','',8);
		if ($client['show_rate'] == 1) 
		$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', "N.B : Payable en BIF au taux vendeur du jour de la BRB plus 100000 BIF de la taxe OTT"),1,'L');
		//$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', "N.B : Payable en BIF au taux vendeur du jour de la BRB: ".$client['exchange_rate']."\n"),1,'L');
		else
			$this->SetFont('Arial','',9);
		$this->Ln();
		$this->Cell(30,4,'Pour toute qustion concernant cette facture, veuillez contacter ',0,1);
		$this->Cell(0,5,iconv('UTF-8', 'windows-1252', 'Tél: (257) 65900006/76004400'),0,1);
			//$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', "N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d'identification: NO ".$client['billing_number']." Conformément a l'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L'interruption de la connexion se fait le 3 du mois pour non paiement."),1,'L');



		//$this->SetFont('Arial','',9);
		
		///$this->Cell(30,4,'Pour toute qustion concernant cette facture, veuillez contacter ',0,1);
		//$this->Cell(0,5,iconv('UTF-8', 'windows-1252', 'Tél: (257) 65900006/76004400'),0,1);
		//$this->SetFont('Arial','B',8);
		
		$this->Ln(10);
		$this->SetX(90);
		$this->Cell(30,5,' NOUS VOUS REMERCIONS DE VOTRE CONFIANCE',0,1,'C');
		
	}
	function headerTable()
	{
		$this->Ln(10);
		
	}
	function viewTable()
	{	
//		$facture = $this->contract->recupererUnProformat($this->facture_id)->fetch();
//        $this->tva = $facture['tva'] + $facture['tvci'];
        $facture = $this->getFacture();
		$this->SetFont('Arial','B',10);
		$this->setY(15);
		$this->Cell(180,5,'Facture pro-forma No '.$facture['numero'].' du '.$facture['date_creation'],0,1,'C');
		$this->setY(30);
        $this->Ln(10);
		$this->SetFont('Arial','B',10);
		$this->Cell(60,5,'A. Identification du Vendeur',0,1);
		$this->Ln(3);
		$this->SetFont('Arial','B',9);
		$this->Cell(100,5,'Raison Sociale: SPIDERNET S.A',0,0);
		$this->SetFont('Arial','',9);
		$this->Cell(70,5,'Centre Fiscal: 19747',0,1,'L');
		$this->Cell(100,5,'NIF: 4000000408',0,0);
		$this->Cell(70,5,iconv('UTF-8', 'windows-1252', 'Secteur d\'activité: TELECOMMUNICATION'),0,1,'L');
		$this->Cell(100,5,'Registre de Commerce NO 67249',0,0);
		$this->Cell(70,5,'Forme Juridique: SA',0,1,'L');
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'BP: 1638 Tél: (257) 65900006/76004400'),0,1);
		$this->Cell(70,5,'Commune: MUKAZA Quartier: ASIATIQUE',0,1);
		$this->Cell(60,5,'Rue kirundo no 6',0,1);
		//$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TCI: Oui'),0,1);
		$this->Ln(10);

		$i = 0;
		$prixU = 0;
		//$PU = 0;
		//$prixU_sousTotal = 0;
		$totalTva = 0;
        $totalTvci = 0;
		//$tolalTva_sousTotal = 0;
		//$totalTTC = 0;
		//$totalTTC_sousTotal = 0;
		$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
		$ligne1 = array();
		$showLines = array();
		$notShow = false;
		$next_billing_month = '';
		$next_billing_year = '';
		$totalprixU = 0;
		$totalPrixTva = 0;
        $totalPrixTvci = 0;
        // $ott = 0;
        $ott = 100000;
		//$billing_cycle = 0;
		

		$this->SetFont('Arial','B',10);
		$this->Cell(60,5,'B. Le Client',0,1);
		$this->Ln(3);
		$this->SetFont('Arial','',9);
        $this->Multicell(180,5,'Raison Sociale: '.iconv('UTF-8','windows-1252', $facture['nom_client']),0,1);
		//$this->Cell(60,5,'Raison Sociale: '.$value2->nom_client,0,1);
		//$this->Ln(3);
		$this->Cell(60,5,'NIF : '.$facture['nif'],0,1);
		//$this->Ln(3);
		$this->Cell(60,5,'Resident a : '.iconv('UTF-8','windows-1252', $facture['adresse']),0,1);
		//$this->Ln(3);
		//$this->Cell(60,5,'Assujetti a la TCI : Oui'/*.ucfirst($facture['assujettiTVA'])*/,0,1);
		
		$this->SetFont('Arial','',9);
		$this->Ln(5);

		$this->SetFont('Arial','B',8);
		//$this->Cell(110,5,'Doit ce qui suit:',0,1);
		$this->Ln();
		if ($facture['billing_date'] > '2023-09-01') 
		{
			$this->Cell(50,5,'Libelle',1,0,'C');
			$this->Cell(15,5,'Quantite',1,0,'C');
			$this->Cell(15,5,'PU',1,0,'C');
			$this->Cell(20,5,'Total PU',1,0,'C');
	        if($facture['tva'] + $facture['tvci'] > 0)
			$this->Cell(20,5,'TVA',1,0,'C');
		    $this->Cell(20,5,'TVAC',1,0,'C');
		    $this->Cell(20,5,'OTT',1,0,'C');
			$this->Cell(20,5,'TTC',1,1,'C');
		}
		else
		{
			$this->Cell(50,5,'Libelle',1,0,'C');
				$this->Cell(15,5,'Quantite',1,0,'C');
				$this->Cell(15,5,'PU',1,0,'C');
				$this->Cell(20,5,'Total PU',1,0,'C');
		        if($facture['tva'] + $facture['tvci'] > 0)
				$this->Cell(20,5,'TVA',1,0,'C');
			    $this->Cell(20,5,'TVAC',1,0,'C');
			   // $this->Cell(20,5,'OTT',1,0,'C');
				$this->Cell(20,5,'TTC',1,1,'C');
			}
		
		$this->SetFont('Arial','B',7);

		$enable_discounts = $facture['enable_discounts'];
	 	//$JourDePlus = $value2->JourDePlus;
		//$montantJourDePlus = $value2->montantJourDePlus;
		//$prixTva = $value2->montant_total/100*$value2->tva;
		//$tolalTva += $prixTva;
		$rediction = $facture['reduction'];
		$fixe_rate = $facture['fixe_rate'];
		$monnaie = $facture['monnaie'];
		$exchange_currency = $facture['exchange_currency'];
		$exchange_rate = $facture['exchange_rate'];

		$prixReduction = 0;
		$prixTvaReduction = 0;
        $prixTvciReduction = 0;
		$totalReduction = 0;
		$totalOtt = 0;
		//$totalOtt = 200000;
		foreach ($this->contract->recupererServicesDunProformat($this->facture_id) as $value2) 
		{
		 	//$i++;
		 
			if ($fixe_rate == 1 AND $monnaie != $exchange_currency AND $monnaie == 'USD') 
			{
				$prixTva = $value2->montant_tva*$exchange_rate;
                $prixTvci = $value2->montant_tvci*$exchange_rate;
				//$tolalTva += $prixTva;
				// $ott = $value2->ott;
				// $ott = 100000;
				//$totalHTVA = $value2->montant*$value2->quantite;
				$prixU = $value2->montant*$exchange_rate;
				//$sousTotalPrixU = $value2->montant_total*$value2->exchange_rate;
				//$prixTTC = $value2->montant_total*$value2->exchange_rate;
				//$totalTTC += $prixTTC;
				$monnaie = $exchange_currency;
			}
			else
			{
				$prixTva = $value2->montant_tva;
                $prixTvci = $value2->montant_tvci;

				// $prixTva = 0;
                // $prixTvci = 0;


				//$tolalTva += $prixTva;
				//$totalHTVA = $value2->montant*$value2->quantite;
				$prixU = $value2->montant;
				//$prixTTC = $value2->montant_total;
				//$totalTTC += $prixTTC;
			}
			$totalTva += $prixTva;
            $totalTvci += $prixTvci;
			//$totalTTC += $prixTTC;
			$Libelle ='';
			$Lib = '';
			$quantite;
			if ($value2->billing_cycle == 0) 
			{
				//$Libelle .= $value2->description;
                $Libelle .= str_replace(";", "\n", $value2->description);
				$quantite = $value2->quantite.' Jours';
				$sousTotalPrixU = $prixU;
			}
			else
			{
                $Libelle .= str_replace(";", "\n", $value2->description);
				//$Libelle .=$value2->description;
				$sousTotalPrixU = $prixU * $value2->quantite;
				
				$quantite = ($value2->billing_cycle == 1 ? $value2->quantite.' Mois' : $value2->quantite);
				
			
			}
		
			$totalprixU += $sousTotalPrixU;
			$totalPrixTva += $prixTva;
            $totalPrixTvci += $prixTvci;

            	$ott += $value2->ott;
            	if ($monnaie == 'USD') {
            		$ott *= 0;
            	}

			$prixTTC = $sousTotalPrixU + $prixTva + $prixTvci + $ott;
            // $prixTTC = $sousTotalPrixU + $prixTva + $prixTvci + ($ott * $quantite);

			if ($facture['billing_date'] > '2023-09-01') 
			{
				if ($value2->billing_cycle == 2 || $value2->ID_service == 1) 
					{
						if($facture['tva'] + $facture['tvci'] > 0)
				            {
				            	// TO DELETE, TEMPORARY SOLUTION
				            	$prixTTC = $sousTotalPrixU + $prixTva + $prixTvci;
				                
				            	// TO NOT BE CHANGED
				                $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTva+$prixTvci).' '.$monnaie,number_format($sousTotalPrixU+$prixTvci).' '.$monnaie,'0 BIF ',number_format($prixTTC).' '.$monnaie];
				            }
			            else
						$ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.'  '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
						$this->Row($ligne1);
					}
					else
					{
		               
						if($facture['tva'] + $facture['tvci'] > 0)
				            {
				                $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTva+$prixTvci).' '.$monnaie,number_format($sousTotalPrixU+$prixTvci).' '.$monnaie,$quantite * $ott.' BIF ',number_format($prixTTC).' '.$monnaie];
				            }
			            else
						$ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.'  '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
						$this->Row($ligne1);
					
					}
			}
			else
			{
				if ($value2->billing_cycle == 2 || $value2->ID_service == 1) 
				{
					if($facture['tva'] + $facture['tvci'] > 0)
			            {
			                $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTva+$prixTvci).' '.$monnaie,number_format($sousTotalPrixU+$prixTvci).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
			            }
		            else
					$ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.'  '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
					$this->Row($ligne1);
				}
				else
				{
	               
					if($facture['tva'] + $facture['tvci'] > 0)
			            {
			                $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTva+$prixTvci).' '.$monnaie,number_format($sousTotalPrixU+$prixTvci).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
			            }
		            else
					$ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.'  '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
					$this->Row($ligne1);
				
				}
			}
			/*if ($value2->billing_cycle == 2 || $value2->ID_service == 1) 
			{
				if($facture['tva'] + $facture['tvci'] > 0)
		            {
		                $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.' '.$monnaie,number_format($sousFTotalPrixU).' '.$monnaie,number_format($prixTva+$prixTvci).' '.$monnaie,number_format($sousTotalPrixU+$prixTvci).' '.$monnaie,'0 BIF ',number_format($prixTTC).' '.$monnaie];
		            }
	            else
				$ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.'  '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
				$this->Row($ligne1);
			}
			else
			{
               
				if($facture['tva'] + $facture['tvci'] > 0)
		            {
		                $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTva+$prixTvci).' '.$monnaie,number_format($sousTotalPrixU+$prixTvci).' '.$monnaie,$quantite * $ott.' BIF ',number_format($prixTTC).' '.$monnaie];
		            }
	            else
				$ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,$prixU.'  '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
				$this->Row($ligne1);
			
			}*/
			
				
		
			if ($value2->billing_cycle == 1) 
			{
				$prixReduction += $sousTotalPrixU * $rediction/100;
				$prixTvaReduction += $prixTva * $rediction/100;
                $prixTvciReduction += $prixTvci * $rediction/100;
				$totalReduction += $prixReduction+$prixTvaReduction+$prixTvciReduction+$ott;
				$totalOtt += $quantite * $ott;
				//$totalOtt = 200000;
			}
		}
	
		if ($enable_discounts == 1 AND $rediction > 0)
        {
            if($facture['tva'] + $facture['tvci'] > 0)
            {
                $this->Row(['Reduction de '.$rediction.' %','','','','-'.number_format(round($prixReduction)).' '.$monnaie,'-'.number_format($prixTvaReduction+$prixTvciReduction).' '.$monnaie,'','-'.number_format(round($totalReduction)).' '.$monnaie]);
            }
            else
                $this->Row(['Reduction de '.$rediction.' %','','','','-'.number_format(round($prixReduction)).' '.$monnaie,'','-'.number_format(round($totalReduction)).' '.$monnaie]);
        }
			
		
		// Pied de tableau
		$totalprixU -= $prixReduction;


		// CHANGES!!
		
		$totalPrixTva -= $prixTvaReduction;
        $totalPrixTvci -= $prixTvciReduction;
        
        // $totalPrixTva = 0;
        // $totalPrixTvci = 0;


		// $totalTTC = $totalprixU + $totalPrixTva + $totalPrixTvci;
		// $totalTTC = $totalprixU + $totalPrixTva + $totalPrixTvci + $totalOtt;
		
		$tott =0;
		// $tott =$totalOtt + $totalOtt;
		$tott =$totalOtt;
		$totalTTC = $totalprixU + $totalPrixTva + $totalPrixTvci + $tott;

		$this->SetFont('Arial','B',8);
		$this->Cell(50,5,'Total',1,0,'L');
		$this->Cell(15,5,'',1,0,'C');
		$this->Cell(15,5,'',1,0,'C');
		$this->Cell(20,5,number_format($totalprixU).' '.$monnaie,1,0,'L');
        
        if($facture['tva'] + $facture['tvci'] > 0)
		$this->Cell(20,5,number_format($totalPrixTva+$totalPrixTvci).' '.$monnaie,1,0,'L');
	   $this->Cell(20,5,number_format($totalprixU+$totalPrixTvci).' '.$monnaie,1,0,'L');
	   if ($facture['billing_date'] > '2023-09-01')
	   {
	   	$this->Cell(20,5,$tott.' BIF',1,0,'L');
	   }

	    
		$this->Cell(20,5,number_format($totalTTC).' '.$monnaie,1,1,'L');

		$this->Ln();

		if ($enable_discounts == 1) 
		{
			$this->Cell(20,5,'Reduction',0,1);
			$this->SetFont('Arial','',9);
			$this->Cell(70,5,'4% pour un payement anticipatif de 3 mois',0,1);
			$this->Cell(70,5,'8% pour un payement anticipatif de 6 mois',0,1);
			$this->Cell(70,5,'12% pour un payement anticipatif de 12 mois',0,1);
		}
		$this->SetFont('Arial','B',9);
		$this->Ln();
		//Arnauld demande de changer la validite du proformat de 90 a 30 jrs
		$this->Cell(20,5,iconv('UTF-8', 'windows-1252',' La durée de validité :       30 jours'),0,1);
		//$this->setXY(15,180); 
		$this->Ln(8);
		$this->SetFont('Arial','B',9);
		foreach ($this->contract->recupererServicesDunProformat($this->facture_id) as $data3) 
		{
			if ($exchange_currency == 'USD' AND $monnaie == 'USD') 
			{
				$this->Cell(20,5,iconv('UTF-8', 'windows-1252',' '),0,1);
				//$this->Cell(20,5,iconv('UTF-8', 'windows-1252',' Payable en BIF aux taux vendeur du jour de la BRB'),0,1);
		    }
		    else
		    {
		    	$this->Cell(20,5,iconv('UTF-8', 'windows-1252',' '),0,1);
		    }
	    }
	

	}
}

$pdf = new myPDF();

$pdf->SetLeftMargin(12.2);
$pdf->AliasNbPages();
$pdf->init($contract,$facture_id,$client);
$pdf->setTva();
$pdf->AddPage();
$pdf->headerTable();
//if($pdf->tva > 0)
    $pdf->SetWidths(array(50,15,15,20,20,20,20,20));
//else
   // $pdf->SetWidths(array(50,15,15,20,20,20,25));
$pdf->viewTable();

$pdf->Output();

