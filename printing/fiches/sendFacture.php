<?php
define('FPDF_FONTPATH','/var/www/crm.buja/printing/fiches/font');
//define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{

	var $client;
    var $numero;
	var $facture_id;

	function init($client,$numero,$facture_id)
	{
		$this->client = $client;
        $this->numero = $numero;
		$this->facture_id = $facture_id; 
	}

    function getClient()
	{
		return $this->client;
	}
	function getNumero()
	{
		return $this->numero;
	}
	function getFactureId()
	{
		return $this->facture_id;
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
	/*var $date_creation;
	var $nif;
	var $adresse;
	var $assujettiTva;
	var $nom_client;

	function init($facture_id,$date_creation,$nif,$adresse,$assujettiTva,$nom_client)
	{
		$this->facture_id = $facture_id;
		$this->date_creation = $date_creation;
		$this->nif = $nif;
		$this->adresse = $adresse;
		$this->assujettiTva = $assujettiTva;
		$this->nom_client = $nom_client;
	}
	function getFactureId()
	{
		return $this->facture_id;
	}
	function getDateCreation()
	{
		return $this->date_creation;
	}
	function getNif()
	{
		return $this->nif;
	}
	function getAdresse()
	{
		return $this->adresse;
	}
	function getAssujetiTva()
	{
		return $this->assujettiTva;
	}
	function getNomClient()
	{
		return $this->nom_client;
	}*/

	function header()  
	{
		//$this->image('printing/fiches/logoajywa.png',15,10,50);
		$this->image('/var/www/crm.buja/printing/fiches/logospnet.png',15.0,10,40);
		//$this->image('image_profil/702.jpg',5,10,200,280);
		$this->SetFont('Arial','B',10);
		$this->setY(5);
		/*$this->Cell(60,5,'A. Identification du Vendeur',0,1);
		//$this->Ln(10);
        $this->SetFont('Arial','B',10);
        //$this->Cell(99,5,'',0,0);
        $this->Cell(60,5,'Raison Sociale: '.$_SESSION['nomSociete'],0,1);
        $this->SetFont('Arial','',10);
        //$this->Cell(99,5,'',0,0);
        $this->Cell(60,5,'Adresse : '.$_SESSION['adresse'],0,1);
        //$this->Cell(99,5,'',0,0);
        $this->Cell(60,5,'Bujumbura',0,1); 
        //$this->Cell(99,5,'',0,0);
        $this->Cell(60,5,'Tel : '.$_SESSION['telephone'],0,1);*/
        /*$this->Cell(60,5,'A. Identification du Vendeur',0,1);
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

		/*$this->Cell(99,5,'',0,0);
		$this->Cell(60,5,$_SESSION['nomSociete'],0,1);
		$this->SetFont('Arial','',10);
		//$this->Cell(99,5,'',0,0);
		$this->Cell(60,5,$_SESSION['adresse'],0,1);
		//$this->Cell(99,5,'',0,0);
		$this->Cell(60,5,'Bujumbura',0,1); 
		//$this->Cell(99,5,'',0,0);
		$this->Cell(60,5,$_SESSION['telephone'],0,1);
		$this->setXY(20,50);
		$this->SetFont('Arial','',12);*/
		//$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		//$this->Cell(60,10,'FACTURE No '.$this->getFactureId().'  du '.date('d-m-Y'),0,1,'C');
		//$this->Line(61,30,149,30);
	}
	function footer()
	{
		$client = $this->getClient();
	    $this->Ln();
		$this->SetY(-45);
		//$this->Line(15,262,195,262);
		$this->SetFont('Arial','',8);
		if ($client['show_rate'] == 1) 
		$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', "N.B : Payable au taux vendeur du jour de la BRB: ".$client['exchange_rate']."\n Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d'identification: NO ".$client['billing_number']." Conformément a l'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L'interruption de la connexion se fait le 3 du mois pour non paiement."),1,'L');
		else
			$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', "N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d'identification: NO ".$client['billing_number']." Conformément a l'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L'interruption de la connexion se fait le 3 du mois pour non paiement."),1,'L');

		$this->SetFont('Arial','B',8);
		$this->Ln();
		$this->Cell(30,4,'N. Comptes',0,1);
		$this->SetFont('Arial','',8);
		$this->Cell(30,4,'KCB - 6690353958 - BIF',0,1);
		$this->Cell(30,4,'KCB - 6690353966 - USD',0,1);
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
		$this->Ln(10);
		/*$this->SetFont('Arial','B',10);
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
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'BP: 1638 Tél: (257) 22 25 84 80/81'),0,1);
		$this->Cell(70,5,'Commune: MUKAZA Quartier: ASIATIQUE',0,1);
		$this->Cell(60,5,'Avenue kirundo no 6',0,1);
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA: Oui'),0,1);
		$this->Ln(10);*/
	}
	function viewTable($contract,$facture_id)
	{
		$client = $this->getClient();
		$this->Cell(180,5,'Facture No '.$client['numero'].' du '.$client['date_creation'],0,1,'C');
		$this->Ln(10);

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
        $this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA: Oui'),0,1);

		$i = 0;
		$prixU = 0;
		//$PU = 0;
		//$prixU_sousTotal = 0;
		$totalTva = 0;
		//$tolalTva_sousTotal = 0;
		//$totalTTC = 0;
		//$totalTTC_sousTotal = 0;
		$mois = [1=>'janvier',2=>'fevrier',3=>'mars',4=>'avril',5=>'mai',6=>'juin',7=>'juillet',8=>'aout',9=>'septembre',10=>'octobre',11=>'novembre',12=>'decembre'];
		$ligne1 = array();
		$showLines = array();
		$notShow = false;
		$monnaie = '';
		$next_billing_month = '';
		$next_billing_year = '';
		$totalprixU = 0;
		$totalPrixTva = 0;
		//$billing_cycle = 0;

		

		//$this->Cell(60,5,'B. Le Client',0,1);
		$this->Ln(3);
		$this->SetFont('Arial','B',10);
		$this->Cell(20,5,'B. Le Client',0,1);
		$this->SetFont('Arial','',10);
		$this->Cell(60,5,'Raison Sociale: '.$client['nom_client'],0,1);
		//$this->Ln(3);
		$this->Cell(60,5,'NIF : '.$client['nif'],0,1);
		//$this->Ln(3);
		$this->Cell(60,5,'Resident a : '.$client['adresse'],0,1);
		//$this->Ln(3);
		$this->Cell(60,5,'Assujetti a la TVA : '.ucfirst($client['assujettiTVA']),0,1);

		$this->SetFont('Arial','',9);
		$this->Ln(5);
		//$this->Cell(60,5,'NIF : '.$value2->nif,0,1);
		
		//$this->Cell(60,5,'Resident a : '.$value2->adresse,0,1);
		//$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA : '.$value2->assujettiTVA),0,1);
		/*$this->setX(117);
		$this->cell(35,5,'FACT #',1,0,'L');
		$this->cell(45,5,$client['numero'],1,1,'L');
		$this->setX(117);
		$this->cell(35,5,'DATE FACTURATION ',1,0,'L');
		$this->cell(45,5,$client['date_creation'],1,1,'L');*/
		/*$this->setX(105);
		$this->cell(45,5,'DATE AVANT COUPURE',1,0,'L');
		$this->cell(45,5,'17/2020',1,1,'L');*/

		//$this->Ln(5);

		$this->SetFont('Arial','B',8);
		//$this->Cell(110,5,'Doit ce qui suit:',0,1);
		$this->Ln();
		$this->Cell(50,5,'Libelle',1,0,'C');
		$this->Cell(20,5,'Quantite',1,0,'C');
		$this->Cell(27,5,'PU',1,0,'C');
		$this->Cell(30,5,'Total PU',1,0,'C');
		$this->Cell(30,5,'TVA',1,0,'C');
		$this->Cell(25,5,'Total TVAC',1,1,'C');

		foreach ($contract->recupererFactureToPrint($facture_id) as $value2) 
		{
		 	$i++;
		 	//$JourDePlus = $value2->JourDePlus;
			//$montantJourDePlus = $value2->montantJourDePlus;
			//$prixTva = $value2->montant_total/100*$value2->tva;
			//$tolalTva += $prixTva;
			$rediction = $value2->reduction;
			$enable_discounts = $value2->enable_discounts;
			if ($value2->fixe_rate == 1 AND $value2->monnaie != $value2->exchange_currency AND $value2->monnaie == 'USD') 
			{
				$prixTva = $value2->montant_tva*$value2->exchange_rate;
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
				//$tolalTva += $prixTva;
				//$totalHTVA = $value2->montant*$value2->quantite;
				$prixU = $value2->montant;
				//$prixTTC = $value2->montant_total;
				//$totalTTC += $prixTTC;
				$monnaie = $value2->monnaie;
			}
			$totalTva += $prixTva;
			//$totalTTC += $prixTTC;
			$Libelle ='';
			$Lib = '';
			$quantite;
		 	
		 	$this->SetFont('Arial','',7);
				
			if ($value2->billing_cycle == 0) 
			{
				$Libelle .= $value2->description;
				$quantite = $value2->quantite.' Jours';
				$sousTotalPrixU = $prixU - $prixTva;
				//$sousTotalPrixU = $value2->montant_total;
				//$totalprixU += $sousTotalPrixU;
				$totalprixU += $prixU;

				$totalPrixTva += $prixTva;
				//$prixTTC = $sousTotalPrixU + $prixTva;
				$prixTTC = $prixU + $prixTva;
				$ligne1 = [$Libelle,$quantite,number_format($prixU/$value2->quantite).' '.$monnaie,number_format($prixU).' '.$monnaie,number_format($prixTva).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
				$this->Row($ligne1);
			}
			else
			{
				$next_billing_month = $value2->mois_fin;
				$next_billing_year = $value2->annee_fin;
				//$Libelle .= iconv('UTF-8', 'windows-1252', $value2->description);
				$Libelle .=$value2->description;
				$sousTotalPrixU = $prixU * $value2->quantite;
				/*if ($JourDePlus > 0) 
				{
					$quantite = $value2->quantite.' Mois + '.$JourDePlus.' jours';
				}
				else*/
				$quantite = ($value2->billing_cycle == 1 ? $value2->quantite.' Mois' : $value2->quantite);
				
				$totalprixU += $sousTotalPrixU;
				$totalPrixTva += $prixTva;
				$prixTTC = $sousTotalPrixU + $prixTva;
				$ligne1 = [$Libelle,$quantite,number_format($prixU).' '.$monnaie,number_format($sousTotalPrixU).' '.$monnaie,number_format($prixTva).' '.$monnaie,number_format($prixTTC).' '.$monnaie];
				$this->Row($ligne1);
			}
		}
		$prixReduction = $totalprixU * $rediction/100;
		$prixTvaReduction = $totalPrixTva * $rediction/100;
		$totalReduction = $prixReduction+$prixTvaReduction;
		if ($enable_discounts == 1 AND $rediction > 0)
			$this->Row(['Reduction de '.$rediction.' %','','','-'.number_format(round($prixReduction)).' '.$monnaie,'-'.number_format(round($prixTvaReduction)).' '.$monnaie,'-'.number_format(round($totalReduction)).' '.$monnaie]);
		
		// Pied de tableau
		$totalprixU -= $prixReduction;
		$totalPrixTva -= $prixTvaReduction;
		$totalTTC = $totalprixU + $totalPrixTva; 
		$this->SetFont('Arial','B',8);
		$this->Cell(50,5,'Total',1,0,'L');
		$this->Cell(20,5,'',1,0,'C');
		$this->Cell(27,5,'',1,0,'C');
		$this->Cell(30,5,number_format($totalprixU).' '.$monnaie,1,0,'L');
		$this->Cell(30,5,number_format($totalPrixTva).' '.$monnaie,1,0,'L');
		$this->Cell(25,5,number_format($totalTTC).' '.$monnaie,1,1,'L');
		$this->Ln();
		$this->setXY(15,180); 
		$this->SetFont('Arial','',8);
        //$next_billing_date = $contract->getNext_billing_date_dun_client($client['ID_client'])->fetch()['next_billing_date_format'];

		//$this->cell(70,5,'PROCHAINE FACTURATION : '.$next_billing_date,1,0,'L');
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
		}*/
				//$this->cell(45,5,'',0,1,'L');
		//$this->AddPage($this->CurOrientation);
		//$this->SetAutoPageBreak(true,$this->GetY()); 

	}
}

/*$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->init($facture_id);
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable($contract,$facture_id);
//$pdf->Output();
$attachment = $pdf->Output('facture_'.$pdf->getFactureId().'.pdf', 'S');
	/*$mail = new PHPMailer;
	$mail->setFrom($_from);
	$mail->addAddress($pdf->getMailAdress());
	$mail->Subject = 'Envoie facture';
	$mail->Body = 'Bonjour! Voici la facture du mois '.$mois;
	$mail->AddStringAttachment($attachment, 'facture_'.$pdf->getFactureId().'.pdf');
	$mail->IsSMTP();
	$mail->SMTPSecure = $_smtp_secure;
	$mail->Host = $_host;
	$mail->SMTPAuth = true;
	$mail->Port = $_port;
	$mail->Username = $_username;
	$mail->Password = $_password;
	if(!$mail->send()) {
	  echo 'Email is not sent.';
	  echo 'Email error: ' . $mail->ErrorInfo;
	} else {
	  echo 'L\'envoie reussie.';
	}
	unset($pdf);
	unset($mail);*/
?>
