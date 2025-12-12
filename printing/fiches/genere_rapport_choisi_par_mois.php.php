<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
class myPDF extends FPDF
{
	var $facture_id;

	function init($facture_id)
	{
		$this->facture_id = $facture_id;
	}
	function getFactureId()
	{
		return $this->facture_id;
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
		//$this->image('printing/fiches/logospnet.png',15,10,50);
		$this->image('printing/fiches/logoajywa.png',15,10,50);
		$this->setXY(15,11);
		$this->SetFont('Arial','B',12);
		$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,'FACTURE No '.$this->getFactureId().'  du '.date('d-m-Y'),0,1,'C');
		//$this->Line(61,30,149,30);
	}
	function footer()
	{
	    $this->Ln();
		$this->SetY(-45);
		//$this->Line(15,262,195,262);
		$this->SetFont('Arial','',8);
		$this->MultiCell(180,5,iconv('UTF-8', 'windows-1252', 'N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d\'identification: NO 1928 Conformément a l\'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L\'interruption de la connexion se fait le 3 du mois pour non paiement.'),1,'L');
		$this->SetFont('Arial','B',8);
		$this->Ln();
		$this->Cell(30,4,'N. Comptes',0,1);
		$this->SetFont('Arial','',8);
		$this->Cell(30,4,'KCB - 6690353958 - BIF',0,1);
		$this->Cell(30,4,'KCB - 6690353966 - USD',0,1);
	}
	function headerTable()
	{
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
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'BP: 1638 Tél: (257) 22 25 84 80/81'),0,1);
		$this->Cell(70,5,'Commune: MUKAZA Quartier: ASIATIQUE',0,1);
		$this->Cell(60,5,'Avenue kirundo no 6',0,1);
		$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA: Oui'),0,1);
		$this->Ln(10);
	}
	function viewTable($contract,$facture_id)
	{	
		$data = array();
		$i = 0;
		$prixU = 0;
		$tolalTva = 0;
		$tatalTTC = 0;
		foreach ($contract->recupererFactureToPrint($facture_id) as $value2) 
		{
		 	$i++;
			$prixTva = $value2->montant/100*$value2->tva;
			$tolalTva += $prixTva;
			$totalHTVA = $value2->montant*$value2->quantite;
			$prixU += $totalHTVA;
			$prixTTC = $totalHTVA + $prixTva;
			$tatalTTC += $prixTTC;
			$monnaie = $value2->monnaie;
		 	if ($i == 1) 
			{
				/*if ($cle == 0) 
				{
					while ($mois_val = current($mois)) 
				    {
				        if ($mois_val == $value2->mois_debut) 
				        {
				            $cle =  key($mois);
				            break;
				        }
				        next($mois);
				    }
				}*/
				$this->Cell(60,5,'B. Le Client',0,1);
				$this->Ln(3);
				$this->SetFont('Arial','B',9);
				$this->Cell(60,5,'Raison Sociale : '.$value2->nom_client,0,1);
				$this->SetFont('Arial','',9);
				$this->Cell(60,5,'NIF : '.$value2->nif,0,1);
				$this->Cell(60,5,'Resident a : '.$value2->adresse,0,1);
				$this->Cell(60,5,iconv('UTF-8', 'windows-1252', 'Assujetti à la TVA : '.$value2->assujettiTVA),0,1);
				$this->Ln(10);

				$this->SetFont('Arial','B',8);
				$this->Cell(110,5,'Doit ce qui suit:',0,1);
				$this->Ln();
				$this->Cell(40,5,'Libelle',1,0,'C');
				$this->Cell(20,5,'Quantite',1,0,'C');
				$this->Cell(30,5,'PU',1,0,'C');
				$this->Cell(30,5,'Montant HTVA',1,0,'C');
				$this->Cell(30,5,'TVA',1,0,'C');
				$this->Cell(30,5,'Total TTC',1,1,'C');

				$this->SetFont('Arial','',8);

				$this->Cell(40,4,'Abonnement mensuel','LR',0);
				$this->Cell(20,4,$value2->quantite.' mois','LR',0);
				$this->Cell(30,4,$value2->montant.' '.$value2->monnaie,'LR',0,'R');
				$this->Cell(30,4,$totalHTVA.' '.$value2->monnaie,'LR',0,'R');
				$this->Cell(30,4,$prixTva.' '.$value2->monnaie,'LR',0,'R');
				$this->Cell(30,4,$prixTTC.' '.$value2->monnaie,'LR',1,'R');

				if ($value2->quantite > 1) 
				{
					if ($value2->annee == $value2->annee_fin) 
					{
						$this->Cell(40,3,iconv('UTF-8', 'windows-1252', 'mois de '.ucfirst($value2->mois_debut).' à '.ucfirst($value2->mois_fin).' '.$value2->annee),'LR',0);
					}
					else
					{
						$this->Cell(40,3,iconv('UTF-8', 'windows-1252', 'mois de '.ucfirst($value2->mois_debut).'/'.$value2->annee.' au '.ucfirst($value2->mois_fin).'/'.$value2->annee_fin),'LR',0);
					}
				}
				else
				{
					$this->Cell(40,3,'mois de '.ucfirst($value2->mois_debut).' '.$value2->annee,'LR',0);
				}
				$this->Cell(20,3,'','LR',0);
				$this->Cell(30,3,'','LR',0);
				$this->Cell(30,3,'','LR',0);
				$this->Cell(30,3,'','LR',0);
				$this->Cell(30,3,'','LR',1);

				$this->Cell(40,3,$value2->nomService,'LR',0);
				$this->Cell(20,3,'','LR',0);
				$this->Cell(30,3,'','LR',0);
				$this->Cell(30,3,'','LR',0);
				$this->Cell(30,3,'','LR',0);
				$this->Cell(30,3,'','LR',1);

				$this->Cell(40,3,$value2->bandepassante,'LR',0);
				$this->Cell(20,3,'','LR',0);
				$this->Cell(30,3,'','LR',0);
				$this->Cell(30,3,'','LR',0);
				$this->Cell(30,3,'','LR',0);
				$this->Cell(30,3,'','LR',1);

				// Pied de tableau
				/*$this->SetFont('Arial','B',8);
				$this->Cell(40,5,'Total ',1,0);
				$this->Cell(20,5,'',1,0);
				$this->Cell(30,5,'',1,0);
				$this->Cell(30,5,$prixU.' '.$value2->monnaie,1,0,'R');
				$this->Cell(30,5,$tolalTva.' '.$value2->monnaie,1,0,'R');
				$this->Cell(30,5,$tatalTTC.' '.$value2->monnaie,1,0,'R');*/
			}
			else
			{
				$this->Cell(40,5,$value2->nom_client,1,0);
				$this->Cell(20,5,$value2->quantite.' mois',1,0);
				$this->Cell(30,5,$value2->montant.' '.$value2->monnaie,1,0,'R');
				$this->Cell(30,5,$totalHTVA.' '.$value2->monnaie,1,0,'R');
				$this->Cell(30,5,$prixTva.' '.$value2->monnaie,1,0,'R');
				$this->Cell(30,5,$prixTTC.' '.$value2->monnaie,1,1,'R');
			}
		}
		// Pied de tableau
		$this->SetFont('Arial','B',8);
		$this->Cell(40,5,'Total ',1,0);
		$this->Cell(20,5,'',1,0);
		$this->Cell(30,5,'',1,0);
		$this->Cell(30,5,$prixU.' '.$monnaie,1,0,'R');
		$this->Cell(30,5,$tolalTva.' '.$monnaie,1,0,'R');
		$this->Cell(30,5,$tatalTTC.' '.$monnaie,1,0,'R');
		$this->Ln();
		//$this->AddPage($this->CurOrientation);
		//$this->SetAutoPageBreak(true,$this->GetY()); 
	}
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->init($facture_id);
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable($contract,$facture_id);
$pdf->Output();
?>
