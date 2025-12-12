<?php
define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $client;
	var $banque;

	function init($client)
	{
		$this->client = $client; 
	}
	function getClient()
	{
		return $this->client;
	}
	function setBanque($banque)
	{
		$this->banque = $banque;
	}
	function getBanque()
	{
		return $this->banque;
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
		$h=4*$nb;
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
			$this->MultiCell($w,4,$data[$i],0,$a);
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
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		/*$this->SetFont('Arial','B',10);
		$this->setY(40);
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
        $this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'BP: 1638 Tél: (257) 75990000/76004400'),0,1);
        $this->Cell(70,5,'Commune: MUKAZA Quartier: ASIATIQUE',0,1);
        $this->Cell(60,5,'Rue kirundo no 6',0,1);
        $this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA: Oui'),0,1);*/

		//$this->Cell(60,5,'',0,0,'C');
		/*$this->image('printing/fiches/logoajywa.png',15,10,50); 
		//$this->image('printing/fiches/logospnet.png',15,10,50);
		//$this->image('image_profil/702.jpg',5,10,200,280);
		$this->SetFont('Arial','B',10);
		$this->setY(15);
		$this->Cell(110,5,'',0,0);
		$this->Cell(60,5,'AJYWA TELECOM',0,1);
		$this->SetFont('Arial','',10);
		$this->Cell(110,5,'',0,0);
		$this->Cell(60,5,'Avenue maniema No. 044 commune IBANDA',0,1);
		$this->Cell(110,5,'',0,0);
		$this->Cell(60,5,'BUKAVU,SUD-KIVU',0,1);
		$this->Cell(110,5,'',0,0);
		$this->Cell(60,5,'+243 999 336 917, +243 858 666 617',0,1);
		$this->setXY(20,50);*/
		//$this->Ln(15);
		//$this->Cell(60,5,'',0,0,'C');
		//$this->Cell(60,10,'FACTURE No '.'  du '.date('d-m-Y'),0,1,'C');
		//$this->Line(61,30,149,30);
	}
	
	function footer()
	{
		$client = $this->getClient();
	    $this->Ln();
	    /*if ($client->tvci > 0) 
	    {
	    	$this->SetY(-85);
		    $this->SetFont('Arial','B',8);
		    $this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', "N.B :TCCV, veut dire taxe collectee sur les capacites vendues (cfr O.M No 540/997/2021 du 02/09/21)"),0,'L');
	    }*/
		//$this->SetY(-60);
		
		$this->SetY(-70);
		//$this->Line(15,262,195,262);
		$this->SetFont('Arial','',8);
		/*$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', 'N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d\'identification: NO 1928 Conformément a l\'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L\'interruption de la connexion se fait le 3 du mois pour non paiement.'),1,'L');*/


		if ($client->show_rate == 1) 
		$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', "N.B : Payable au taux vendeur du jour de la BRB: ".$client->exchange_rate."\n Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d'identification: NO ".$client->billing_number." Conformément a l'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L'interruption de la connexion se fait le 3 du mois pour non paiement."),1,'L');
		else
			$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', "N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d'identification: NO ".$client->billing_number." Conformément a l'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L'interruption de la connexion se fait le 3 du mois pour non paiement."),1,'L');



		$this->SetFont('Arial','',8);
		$this->Ln();
		$this->Cell(30,4,'N. Comptes',0,1);
		$y=$this->GetY();
		foreach ($this->getBanque() as $value) 
		{
			if ($this->GetY() == 277.00008333333) 
				$this->SetXY(60,$y);
			$this->Cell(60,4,$value->nom.' - '.$value->numero.' '.$value->monnaie,0,1);
		}
		//$this->SetY(-20);
		//$y=$this->GetY();
		//$this->Cell(30,4,$y,1,1);
		//this->Cell(30,4,'KCB - 6690353966 - USD',0,1);
		/*$this->SetXY(15,-40);
        $this->Cell(0,5, iconv('UTF-8', 'windows-1252', 'Abonné') , 0,0);
        $this->SetXY(-15,-40);
        $this->Cell(0,5, $_SESSION['nomSociete'] , 0,1,'R');
        //$this->Line(130,247,189,247);
        //$this->Ln();
        $this->SetXY(13,-23);
        $this->Line(15,265,195,265);
        $this->SetFont('Arial','',8);
        $this->Cell(0,5,$_SESSION['nomSociete'].' '.$_SESSION['adresse'],0,1,'C');
        $this->SetXY(15,-20);
        $this->Cell(0,5,$_SESSION['telephone'].' '.$_SESSION['email'],0,1,'C');*/
	}
	function headerTable()
	{
		/*$this->Ln(10);
		$this->SetFont('Arial','B',10);
		$this->Cell(60,5,'A. Identification du Vendeur',0,1);
		$this->Ln(3);
		$this->SetFont('Arial','',9);
		$this->Cell(100,5,'Raison Sociale: SPIDERNET S.A',0,0);
		$this->Cell(70,5,'Centre Fiscal: 19747',0,1,'L');
		$this->Cell(100,5,'NIF: 4000000408',0,0);
		$this->Cell(70,5,iconv('UTF-8', 'windows-1252', 'Secteur d\'activité: TELECOMMUNICATION'),0,1,'L');
		$this->Cell(100,5,'Registre de Commerce NO 67249',0,0);
		$this->Cell(70,5,'Forme Juridique: SA',0,1,'L');
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'BP: 1638 Tél: (257) 22 25 84 80/81'),0,1);
		$this->Cell(70,5,'Commune: MUKAZA Quartier: ASIATIQUE',0,1);
		$this->Cell(60,5,'Avenue kirundo no 6',0,1);
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA: Oui'),0,1);
		$this->Ln();
		$this->SetFont('Arial','B',10);
		$this->Cell(60,5,'B. Le Client',0,1);
		$this->Ln(3);
		$this->SetFont('Arial','',9);
		$this->Cell(60,5,'Raison Sociale : '.$this->getNomClient(),0,1);
		$this->Cell(60,5,'NIF : '.$this->getNif(),0,1);
		$this->Cell(60,5,'Resident a : '.$this->getAdresse(),0,1);
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA : '.$this->getAssujetiTva()),0,1);
		$this->Ln(10);*/
	}
	function viewTable($contract,$tb_factureId)
	{	
		//$this->SetFont('Arial','B',12);
		$y = 0;
		foreach ($tb_factureId as $value1) 
		{
			$y++;
			$i = 0;
			$prixU = 0;
			$totalTva = 0;
			$totalTvci = 0;
			$tatalTTC = 0;
            $totalOtt = 0;
			$this->SetFont('Arial','',12);
			$this->Ln(15);
			$this->Cell(60,5,'',0,0,'C');
			$this->Cell(60,5,'Facture No '.$value1->numero.'  du '.$value1->date_creation,0,1,'C');
			$this->Ln(10); 
			$this->SetFont('Arial','B',10);
			$this->Cell(60,5,'A. Identification du Vendeur',0,1);
			$this->Ln(3);
			$this->SetFont('Arial','',9);
			$this->Cell(100,5,'Raison Sociale: SPIDERNET S.A',0,0);
			$this->Cell(70,5,'Centre Fiscal: 19747',0,1,'L');
			$this->Cell(100,5,'NIF: 4000000408',0,0);
			$this->Cell(70,5,iconv('UTF-8', 'windows-1252', 'Secteur d\'activité: TELECOMMUNICATION'),0,1,'L');
			$this->Cell(100,5,'Registre de Commerce NO 67249',0,0);
			$this->Cell(70,5,'Forme Juridique: SA',0,1,'L');
			$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'BP: 1638 Tél: (257) 22 25 84 80/81'),0,1);
			$this->Cell(70,5,'Commune: MUKAZA Quartier: ASIATIQUE',0,1);
			$this->Cell(60,5,'Avenue kirundo no 6',0,1);
			$this->Cell(60,5,'Assujetti a la TVA : '.ucfirst($value1->assujettiTVA),0,1);
//			$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TCI: Oui'),0,1);
			$this->Ln();
			//$this->SetFont('Arial','B',10);
			$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
			$ligne1 = array();
			$showLines = array();
			$notShow = false;
			$monnaie = '';
			$next_billing_month = '';
			$next_billing_year = '';
			$totalprixU = 0;
			$totalPrixTva = 0;
			$totalPrixTvci = 0;

			//$client = $contract->get_client_by_facture_id($value1->facture_id)->fetch();

			//$this->Cell(60,5,'B. Le Client',0,1);
			$this->Ln(3);
			$this->SetFont('Arial','B',10);
			$this->Cell(20,5,'B. Le Client',0,1);
			$this->SetFont('Arial','',10);
            $this->Cell(60,5,'Raison Sociale: '.iconv('UTF-8', 'windows-1252', $value1->nom_client),0,1);
			//$this->Ln(3);
			$this->Cell(60,5,'NIF : '.$value1->nif,0,1);
			//$this->Ln(3);
            $this->Cell(60,5,'Resident a : '.iconv('UTF-8', 'windows-1252', $value1->adresse),0,1);
			//$this->Ln(3);
			 $this->Cell(60,5,iconv('UTF-8', 'windows-1252','Service : '. $value1->nomService),0,1);
           $this->Cell(60,5,iconv('UTF-8', 'windows-1252','Bande Passante : '. $value1->bandepassante),0,1);

	

			$this->SetFont('Arial','',9);
			$this->Ln(5);
			//$this->Cell(60,5,'NIF : '.$value2->nif,0,1);
			
			//$this->Cell(60,5,'Resident a : '.$value2->adresse,0,1);
			//$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA : '.$value2->assujettiTVA),0,1);
			/*$this->setX(117);
			$this->cell(35,5,'FACT #',1,0,'L');
			$this->cell(45,5,$value1->numero,1,1,'L');
			$this->setX(117);
			$this->cell(35,5,'DATE FACTURATION ',1,0,'L');
			$this->cell(45,5,$value1->date_creation,1,1,'L');*/
			/*$this->setX(105);
			$this->cell(45,5,'DATE AVANT COUPURE',1,0,'L');
			$this->cell(45,5,'17/2020',1,1,'L');*/

			//$this->Ln(5);

			$this->SetFont('Arial','B',8);
			
			$this->Ln();
			// $this->Cell(50,5,'Libelle',1,0,'C');
			// $this->Cell(20,5,'Quantite',1,0,'C');
			// $this->Cell(25,5,'PU',1,0,'C');
			// $this->Cell(25,5,'Total PU',1,0,'C');
			// $this->Cell(25,5,'TVA',1,0,'C');
			// //$this->Cell(25,5,'TCCV',1,0,'C');
			// $this->Cell(25,5,'TTC',1,1,'C');
            
           // if(strtolower($value1->exchange_currency) == 'usd' && strtolower($value1->monnaie) != 'bif')
           //     $this->Row(['Libelle','Quantite','PU','Total PU','TVA','TVAC','TVAC EN BIF']);
           // else
           //     $this->Row(['Libelle','Quantite','PU','Total PU','TVA','TVAC']);
            
           $this->Row(['Libelle','Quantite','PU','HTVA','TVA','TVAC','OTT','TTC']);
			foreach ($contract->recupererFactureToPrint($value1->facture_id) as $value2) 
			{
			 	$i++;
			 	//$JourDePlus = $value2->JourDePlus;
				//$montantJourDePlus = $value2->montantJourDePlus;
				//$prixTva = $value2->montant_total/100*$value2->tva;
				//$tolalTva += $prixTva;
                $tva = $value2->tva;
                $tvci = $value2->tvci;
				$creation_mode = $value2->creation_mode;
				$rediction = $value2->rediction;
				$enable_discounts = $value2->enable_discounts;
				if ($value2->fixe_rate == 1 AND $value2->monnaie != $value2->exchange_currency AND $value2->monnaie == 'USD') 
				{
					$prixTva = $value2->montant_tva*$value2->exchange_rate;
					$prixTvci = $value2->montant_tvci*$value2->exchange_rate;
					//$tolalTva += $prixTva;
					//$totalHTVA = $value2->montant*$value2->quantite;
					$prixU = $value2->montant*$value2->exchange_rate;
					//$sousTotalPrixU = $value2->montant_total*$value2->exchange_rate;
					//$prixTTC = $value2->montant_total*$value2->exchange_rate;
					//$totalTTC += $prixTTC;
					$monnaie = $value2->exchange_currency;
				}
				else
				{
					$prixTva = $value2->montant_tva;
					$prixTvci = $value2->montant_tvci;
					//$tolalTva += $prixTva;
					//$totalHTVA = $value2->montant*$value2->quantite;
					$prixU = $value2->montant;
					//$prixTTC = $value2->montant_total;
					//$totalTTC += $prixTTC;
					$monnaie = $value2->monnaie;
				}
                $ott = $value2->ott;
				$totalTva += $prixTva;
				$totalTvci += $prixTvci;
                $totalOtt += $ott;
				//$totalTTC += $prixTTC;
				$Libelle ='';
				$Lib = '';
				$quantite;
			 	
			 	$this->SetFont('Arial','',7);
					
				if ($value2->billing_cycle == 0) 
				{
					$Libelle .= str_replace(";", "\n", $value2->description);
                    $Libelle = iconv('UTF-8', 'windows-1252', $Libelle);
					$quantite = $value2->quantite.' Jours';
					$sousTotalPrixU = $prixU - $prixTva - $prixTvci;
					//$sousTotalPrixU = $value2->montant_total;
					//$totalprixU += $sousTotalPrixU;
					$totalprixU += $prixU;

					$totalPrixTva += $prixTva;
					$totalPrixTvci += $prixTvci;
					//$prixTTC = $sousTotalPrixU + $prixTva;
					//$prixTTC = $prixU + $prixTva;
					$prixTTC = $prixU + $prixTva + $prixTvci;

//					$ligne1 = [$Libelle,$quantite,number_format($prixU/$value2->quantite).' '.$monnaie,number_format($prixU).' '.$monnaie,number_format($prixTva).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
//					$this->Row($ligne1);
                    
//                    if(strtolower($monnaie) == 'usd')
//                        $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,number_format($prixU/$value2->quantite).' '.$monnaie,number_format($prixU).' '.$monnaie,number_format($prixTva).' '.$monnaie,number_format($prixTTC).' '.$monnaie,number_format($prixTTC*$value1->exchange_rate).' BIF'];
//                    else
//                        $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,number_format($prixU/$value2->quantite).' '.$monnaie,number_format($prixU).' '.$monnaie,number_format($prixTva).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
                    
                    $ligne1 = [iconv('UTF-8', 'windows-1252', $Libelle),$quantite,number_format($prixU/$value2->quantite).' '.$monnaie,number_format($prixU).' '.$monnaie,number_format($prixTva).' '.$monnaie,number_format($prixTTC).' '.$monnaie,$ott,number_format($prixTTC+$ott).' '.$monnaie];
                    $this->Row($ligne1);
				}
				else
				{
					$next_billing_month = $value2->mois_fin;
					$next_billing_year = $value2->annee_fin;
					//$Libelle .= iconv('UTF-8', 'windows-1252', $value2->description);
					$Libelle .= str_replace(";", "\n", $value2->description);
                    $Libelle = iconv('UTF-8', 'windows-1252', $Libelle);
					//$prixTvaU = $prixU * $tva /100;
					//$prixU = ($creation_mode == 'mail' ? $prixU+$prixTvaU : $prixU);

					//$sousTotalPrixUModeMail = round($prixU) * $value2->quantite;
					//$sousTotalPrixU = ($creation_mode == 'mail' ? $sousTotalPrixUModeMail : $prixU * $value2->quantite);
                    $sousTotalPrixU = $prixU * $value2->quantite;
					//$prixTvaShow = ($value2->creation_mode == 'mail' ? 0 : $prixTva);
                    $prixTvaShow = $prixTva + $prixTvci;

					$quantite = $value2->quantite.' Mois';
					
					$totalprixU += $sousTotalPrixU;
					$totalPrixTva += $prixTva;
					$totalPrixTvci += $prixTvci;
					//$prixTTC = ($creation_mode == 'mail' ? $sousTotalPrixU + $prixTvci : $sousTotalPrixU + $prixTva + $prixTvci);
                    $prixTTC = $sousTotalPrixU + $prixTva + $prixTvci;

					
//					$ligne1 = [$Libelle,$quantite,number_format($prixU).' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTvaShow).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
//					$this->Row($ligne1);
                    
//                    if(strtolower($monnaie) == 'usd')
//                        $ligne1 = [$Libelle,$quantite,number_format($prixU).' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTvaShow).' '.$monnaie,number_format($prixTTC).' '.$monnaie,number_format(round($prixTTC)*$value1->exchange_rate).' BIF'];
//                    else
//                        $ligne1 = [$Libelle,$quantite,number_format($prixU).' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTvaShow).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
                    
                    $ligne1 = [$Libelle,$quantite,number_format($prixU).' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTvaShow).' '.$monnaie,number_format($prixTTC).' '.$monnaie,$ott,number_format($prixTTC+$ott).' '.$monnaie];

                    $this->Row($ligne1);
                    
                    if ($rediction > 0) 
					{
						/*$prixReduction = $sousTotalPrixU * $rediction/100;
						//$prixTvaReduction = ($creation_mode == 'mail' ? 0 : $prixTva * $rediction/100);
                        $prixTvaReduction = $prixTva * $rediction/100;
						$prixTvciReduction = $prixTvci * $rediction/100;
                        $prixTaxeReduction = $prixTvaReduction + $prixTvciReduction;
						$totalReduction = $prixReduction+$prixTvaReduction+$prixTvciReduction;

						$totalprixU -= $prixReduction;
						$totalPrixTva -= $prixTvaReduction;
						$totalPrixTvci -= $prixTvciReduction;
						$this->Row(['Reduction de '.$rediction.' %','','','-'.number_format($prixReduction).' '.$monnaie,'-'.number_format($prixTvaReduction).' '.$monnaie,'-'.number_format($totalReduction).' '.$monnaie]);*/
                        
                        $prixReduction = $sousTotalPrixU * $rediction/100;
                        //$prixTvaReduction = ($creation_mode == 'mail' ? 0 : $prixTva * $rediction/100);
                        $prixTvaReduction = $prixTva * $rediction/100;
                        $prixTvciReduction = $prixTvci * $rediction/100;
                        $prixTaxeReduction = $prixTvaReduction + $prixTvciReduction;
                        $totalReduction = $prixReduction+$prixTaxeReduction;

                        $totalprixU -= $prixReduction;
                        $totalPrixTva -= $prixTvaReduction;
                        $totalPrixTvci -= $prixTvciReduction;
//                        $this->Row(['Reduction de '.$rediction.' %','','','-'.number_format($prixReduction).' '.$monnaie,'-'.number_format($prixTaxeReduction).' '.$monnaie,'-'.number_format($totalReduction).' '.$monnaie]);
                        
//                        if(strtolower($monnaie) == 'usd')
//                           $this->Row(['Reduction de '.$rediction.' %','','','-'.number_format($prixReduction).' '.$monnaie,'-'.number_format($prixTaxeReduction).' '.$monnaie,'-'.number_format($totalReduction).' '.$monnaie,number_format($totalReduction*$value1->exchange_rate).' BIF']);
//                        else
//                            $this->Row(['Reduction de '.$rediction.' %','','','-'.number_format($prixReduction).' '.$monnaie,'-'.number_format($prixTaxeReduction).' '.$monnaie,'-'.number_format($totalReduction).' '.$monnaie]);
                        
                        $this->Row(['Reduction de '.$rediction.' %','','','-'.number_format($prixReduction).' '.$monnaie,'-'.number_format($prixTaxeReduction).' '.$monnaie,'-'.number_format($totalReduction).' '.$monnaie,'','-'.number_format($totalReduction).' '.$monnaie]);
					}
				}
			}
			// Pied de tableau
			/*$prixReduction = $totalprixU * $rediction/100;
			$prixTvaReduction = ($creation_mode == 'mail' ? 0 : $totalPrixTva * $rediction/100);
			$prixTvciReduction = $totalPrixTvci * $rediction/100;
			$totalReduction = $prixReduction+$prixTvaReduction+$prixTvciReduction;*/
			/*if ($enable_discounts == 1 AND $rediction > 0)
				//$this->Row(['Reduction de '.$rediction.' %','','','-'.number_format($prixReduction).' '.$monnaie,'-'.number_format($prixTvaReduction).' '.$monnaie,'-'.number_format($prixTvciReduction).' '.$monnaie,'-'.number_format($totalReduction).' '.$monnaie]);
				$this->Row(['Reduction de '.$rediction.' %','','','-'.number_format($prixReduction).' '.$monnaie,'-'.number_format($prixTvaReduction).' '.$monnaie,'-'.number_format($totalReduction).' '.$monnaie]);*/
			
			// Pied de tableau
			/*$totalprixU -= $prixReduction;
			$totalPrixTvci -= $prixTvciReduction;*/
			//$totalPrixTvaShow = ($creation_mode == 'mail' ? 0 : $totalPrixTva);
            $totalPrixTvaShow = $totalPrixTva + $totalPrixTvci;
			//$totalTTC = ($creation_mode == 'mail' ? $totalprixU + $totalPrixTvci : $totalprixU + $totalPrixTva + $totalPrixTvci);
            $totalTTC = $totalprixU + $totalPrixTva + $totalPrixTvci;




	// handling the 7% reduction on all invoices



	$invoiceDate = new DateTime($value1->date_creation);
$may2025 = new DateTime('2025-04-14');
/*if ($invoiceDate >= $may2025) 
{
    $reductionRate = 7; // 7% reduction
    
    $prixReduction = $totalprixU * $reductionRate/100;
    $prixTvaReduction = $totalPrixTva * $reductionRate/100;
    $prixTvciReduction = $totalPrixTvci * $reductionRate/100;
    $prixTaxeReduction = $prixTvaReduction + $prixTvciReduction;
    $totalReduction = $prixReduction + $prixTaxeReduction;

    $totalprixU -= $prixReduction;
    $totalPrixTva -= $prixTvaReduction;
    $totalPrixTvci -= $prixTvciReduction;
    
    $this->Row(['Reduction de '.$reductionRate.' %','','','-'.number_format($prixReduction).' '.$monnaie,'-'.number_format($prixTaxeReduction).' '.$monnaie,'-'.number_format($totalReduction).' '.$monnaie,'','-'.number_format($totalReduction).' '.$monnaie]);
    
    // Recalculate total after reduction
    $totalTTC = $totalprixU + $totalPrixTva + $totalPrixTvci;
}*/



			$this->SetFont('Arial','B',8);
//			$this->Cell(50,5,'Total',1,0,'L');
//			$this->Cell(20,5,'',1,0,'C');
//			$this->Cell(25,5,'',1,0,'C');
//			$this->Cell(25,5,number_format($totalprixU).' '.$monnaie,1,0,'L');
//			$this->Cell(25,5,number_format($totalPrixTvaShow).' '.$monnaie,1,0,'L');
//			//$this->Cell(25,5,number_format($totalPrixTvci).' '.$monnaie,1,0,'L');
//			$this->Cell(25,5,number_format($totalTTC).' '.$monnaie,1,1,'L');
            
//            if(strtolower($value1->exchange_currency) == 'usd' && strtolower($value1->monnaie) != 'bif')
//              $this->Row(['Total','','',number_format($totalprixU).' '.$monnaie,number_format($totalPrixTvaShow).' '.$monnaie,number_format($totalTTC).' '.$monnaie,number_format(round($totalTTC)*$value1->exchange_rate).' BIF']);
//            else
//                $this->Row(['Total','','',number_format($totalprixU).' '.$monnaie,number_format($totalPrixTvaShow).' '.$monnaie,number_format($totalTTC).' '.$monnaie]);
            
            $this->Row(['Total','','',number_format($totalprixU).' '.$monnaie,number_format($totalPrixTvaShow).' '.$monnaie,number_format($totalTTC).' '.$monnaie,$totaltOtt,number_format($totalTTC+$totalOtt).' '.$monnaie]);
            

			
			// showing the id on the invoice.
			$datefact = preg_replace('#[^A-Za-z0-9]#', '', $value2->date_creation/*$client['date_creation']*/);
	                $datefact = str_replace('', '', $datefact);
            		$this->Cell(4, 5, 'ID :  4000000408/ws400000040800079/' . $datefact . '/FN' . $value2->numero/*$client['numero']*/, 0, 1);


			$this->Ln();
			$this->setXY(15,180); 
			$this->SetFont('Arial','',8);
			/*if ($next_billing_month == '') 
			{
				# code...
			}
			else
			{
				if ($next_billing_month == 12)
				{
					$next_billing_year+=1;
					$this->cell(70,5,'PROCHAINE FACTURATION : '.ucfirst($mois[1]).'/'.$next_billing_year,1,0,'L');
				}
				else
					$this->cell(70,5,'PROCHAINE FACTURATION : '.ucfirst($mois[$next_billing_month+1]).'/'.$next_billing_year,1,0,'L');
			}
			$this->setXY(15,180); 
			$this->SetFont('Arial','',8);
			if ($next_billing_month == '') 
			{
				# code...
			}
			else
			{
				if ($next_billing_month == 12)
				{
					$next_billing_year+=1;
					$this->cell(70,5,'PROCHAINE FACTURATION : '.ucfirst($mois[1]).'/'.$next_billing_year,1,0,'L');
				}
				else
					$this->cell(70,5,'PROCHAINE FACTURATION : '.ucfirst($mois[$next_billing_month+1]).'/'.$next_billing_year,1,0,'L');
			}*/
			//$next_billing_date = $contract->getNext_billing_date_dun_client($value1->ID_client)->fetch()['next_billing_date_format'];

			//$this->cell(70,5,'PROCHAINE FACTURATION : '.$next_billing_date,1,0,'L');
			if ($y < count($tb_factureId)) 
			{
				$this->init($value1);
//                if(strtolower($value1->exchange_currency) == 'usd' && strtolower($value1->monnaie) != 'bif')
//                    $this->SetWidths(array(40,20,20,20,20,25,25));
//                else
//                    $this->SetWidths(array(50,20,25,25,25,25,25));
				$this->AddPage($this->CurOrientation);
                
			}
			//$this->SetAutoPageBreak(true,$this->GetY()); 
		}
	}
}
 
$pdf = new myPDF();
$pdf->SetLeftMargin(15.2);
$pdf->AliasNbPages();
$pdf->setBanque($banque);
//$pdf->init($facture_id,$date_creation,$nif,$adresse,$assujettiTva,$nom_client);
$pdf->AddPage();
//$pdf->headerTable();
//$pdf->SetWidths(array(50,20,25,25,25,25));
$pdf->SetWidths(array(30,20,20,20,20,25,20,25));
$pdf->viewTable($contract,$tb_factureId);
$pdf->Output();
?>
