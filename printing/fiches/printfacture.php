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
	var $date_creation;
	var $nif;
	var $adresse;
	var $assujettiTva;
	var $nom_client;
	var $mois_debut;
	var $annee;
	var $quantite;
	var $monnaie;
	var $montant;
	var $prixTva;
	var $prixTTC;
	var $nomService;
	var $bandepassante;

	function init($facture_id,$date_creation,$nif,$adresse,$assujettiTva,$nom_client,$mois_debut,$annee,$quantite,$monnaie,$montant,$prixTva,$prixTTC,$nomService,$bandepassante)
	{
		$this->facture_id = $facture_id;
		$this->date_creation = $date_creation;
		$this->nif = $nif;
		$this->adresse = $adresse;
		$this->assujettiTva = $assujettiTva;
		$this->nom_client = $nom_client;
		$this->mois_debut = $mois_debut;
		$this->annee = $annee;
		$this->quantite = $quantite;
		$this->monnaie = $monnaie;
		$this->montant = $montant;
		$this->prixTva = $prixTva;
		$this->prixTTC = $prixTTC;
		$this->nomService = $nomService;
		$this->bandepassante = $bandepassante;
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
	}
	function getMoisDebut()
	{
		return $this->mois_debut;
	}
	function getAnnee()
	{
		return $this->annee;
	}
	function getQuantite()
	{
		return $this->quantite;
	}
	function getMonnaie()
	{
		return $this->monnaie;
	}
	function getMontant()
	{
		return $this->montant;
	}
	function getPrixTva()
	{
		return $this->prixTva;
	}
	function getPrixTTC()
	{
		return $this->prixTTC;
	}
	function getNomService()
	{
		return $this->nomService;
	}
	function getBanteP()
	{
		return $this->bandepassante;
	}

	function header()
	{
		$this->image('printing/fiches/logospnet.png',15,10,50);
		$this->setMargins(15,100);
		$this->SetFont('Arial','B',12);
		$this->Ln(15);
		$this->Cell(60,5,'',0,0,'C');
		$this->Cell(60,5,'FACTURE No '.$this->getFactureId().'  du '.$this->getDateCreation(),0,1,'C');
		$this->Line(61,30,149,30);
	}
	function footer()
	{
	    $this->Ln();
		$this->SetY(-45);
		//$this->Line(15,262,195,262);
		$this->SetFont('Arial','',8);
		$this->MultiCell(180,4,iconv('UTF-8', 'windows-1252', 'N.B : Pour tous vos paiements, nous vous prions de mentionner la periode payée ainsi que votre numéro d\'identification: NO 1928 Conformément a l\'article 3 du contrat, le paiement est anticipatif, et se fait avant le 1er de chaque mois. L\'interruption de la connexion se fait le 3 du mois pour non paiement.'),1,'L');
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
		$this->Ln(10);
	}
	function viewTable()
	{
		$this->SetFont('Arial','B',9);
		$this->Cell(110,5,'Doit ce qui suit:',0,1);
		$this->Ln();
		$this->Cell(30,5,'Libelle',1,0);
		$this->Cell(30,5,'Quantite',1,0);
		$this->Cell(30,5,'PU',1,0);
		$this->Cell(30,5,'Montant HTVA',1,0);
		$this->Cell(30,5,'TVA',1,0);
		$this->Cell(30,5,'Total TTC',1,1);
		$this->SetFont('Arial','',8);
		$this->Cell(30,4,'Abonnement mensuel','LR',0);
		$this->Cell(30,4,$this->getQuantite().' mois','LR',0);
		$this->Cell(30,4,$this->getMontant().' '.$this->getMonnaie(),'LR',0);
		$this->Cell(30,4,$this->getMontant().' '.$this->getMonnaie(),'LR',0);
		$this->Cell(30,4,$this->getPrixTva().' '.$this->getMonnaie(),'LR',0);
		$this->Cell(30,4,$this->getPrixTTC().' '.$this->getMonnaie(),'LR',1);

		$this->Cell(30,3,'mois de '.$this->getMoisDebut().' '.$this->getAnnee(),'LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',1);

		$this->Cell(30,3,$this->getNomService(),'LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',1);

		$this->Cell(30,3,$this->getBanteP(),'LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',0);
		$this->Cell(30,3,'','LR',1);

		// Pied de tableau
		$this->SetFont('Arial','B',8);
		$this->Cell(30,5,'Total ',1,0);
		$this->Cell(30,5,'',1,0);
		$this->Cell(30,5,'',1,0);
		$this->Cell(30,5,$this->getMontant().' '.$this->getMonnaie(),1,0);
		$this->Cell(30,5,$this->getPrixTva().' '.$this->getMonnaie(),1,0);
		$this->Cell(30,5,$this->getPrixTTC().' '.$this->getMonnaie(),1,0);
	}
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->init($facture_id,$date_creation,$nif,$adresse,$assujettiTva,$nom_client,$mois_debut,$annee,$quantite,$monnaie,$montant,$prixTva,$prixTTC,$nomService,$bandepassante);
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable();
$pdf->Output();
?>
