<?php
//define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spidernet/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');


/**
 * 
 */
class myPDF extends FPDF
{
	var $mois;

	function setMois($mois)
	{
		$this->mois = $mois;
	}
	function getMois()
	{
		return $this->mois;
	}
	
	function header()
	{
		//$this->image('printing/fiches/logospnet.png',15.0,10,40);
		$this->image('printing/fiches/logospnet.png',15.0,10,40);
		//$this->setMargins(10,100);
		$this->SetFont('Arial','',14);

		$this->Cell(250,8,'Generer le '.date("F j, Y, g:i a"), 0,1,'C');
		//$this->Cell(190,5,'Le '.date('d-m-Y'),0,1,'C');
		$this->Ln(5);
		$this->Cell(100,10,'',0,1,'L');
		$this->Ln(2);
		$this->Cell(60,5,'',0,0,'C');
		$this->SetFont('Arial','B',14);
		$this->Cell(60,5,'Consommation de carburant mois de '.$this->getMois(),0,1,'C');
		//$this->Line(54,40,146,40);
	}
	function footer()
	{	
		$this->SetY(-60);
		
		$this->SetY(-25);
		$this->Line(16,270,190,270);
		$this->SetFont('Arial','',8);
		$this->Cell(170,5,'SPIDERNET s.a quartier asiatique rue kirundo Numero 06 B.P 1638 Bujumbura Burundi',0,1,'C');
		$this->Cell(170,5,'TEL: 257 22 25 84 80 257 22 25 84 81 Fax: 25722258428 info@spidernet-bi.com',0,1,'C');
	}
	function headerTable($equipement,$date_debut,$date_fin,$mois_avec_indice)
	{
		$this->setMargins(20,150);
		$this->Ln(10);
		$this->SetFont('Arial','',12);

		$this->Cell(180,8,'Situation d\'entree',0,1,'C');
		//$this->Line(92,63,130,63);
		//$this->Cell(10,8,'',0,1,'L');
		$this->Cell(28,6,'DATE',1,0);
		$this->Cell(34,6,'CARBURANT',1,0);
		$this->Cell(34,6,'NB LITRE',1,0);
		$this->Cell(28,6,'PRIX / LITRE',1,0);
		$this->Cell(40,6,'TOTAL EN BIF',1,1);

		//$mois = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
		$produit= 0;
		$somme=0;
		
		foreach ($equipement->affichage_stock_mensuel($date_debut,$date_fin) as $value) 
		{
			$produit = $value->quantite * $value->prix_par_litre;
			$somme += $produit;
			$date = date_parse($value->datestock);
			$jour = $date['day'];
			$month = $mois_avec_indice[$date['month']];
			$this->Cell(28,6,$jour.'/'.$month,1,0);
			$this->Cell(34,6,$value->nature,1,0);
			$this->Cell(34,6,$value->quantite,1,0);
			$this->Cell(28,6,$value->prix_par_litre,1,0);
			$this->Cell(40,6,$produit,1,1);
		}
		$this->Cell(124,10,'LA SOMME TOTALE DE CE MOI EST DE:',0,0,'C');
	    $this->Cell(40,10,$somme,1,1);
	}
	function viewTable($equipement,$date_debut,$date_fin,$mois_avec_indice)
	{
		
		$this->Ln(48);
		//$this->Line(16,130,190,130);
		$this->Cell(180,8,'Distribution',0,1,'C');
		//$this->Line(92,150,130,150);
		//$this->Cell(10,8,'',0,1,'L');
		$this->Cell(22,8,'Ref',1,0);
		$this->Cell(26,8,'DATE',1,0);
		$this->Cell(34,8,'CARBURANT',1,0);
		$this->Cell(42,8,'CONSOMMATEUR',1,0);
		$this->Cell(46,8,'NB LITRE',1,1);


		//$total = 0;
		foreach ($equipement->affichage_consommation_mensuel($date_debut,$date_fin) as $value) 
		{
			//$total += $value->quantite;
			$date = date_parse($value->datedistribution);
			$jour = $date['day'];
			$month = $mois_avec_indice[$date['month']];

			$this->Cell(22,6,$value->ID_distribution,1,0);
			$this->Cell(26,6,$jour.'/'.$month,1,0);
			$this->Cell(34,6,$value->carburant,1,0);
			$this->Cell(42,6,$value->consommateur,1,0);
			$this->Cell(46,6,$value->quantite,1,1);
			//$this->Cell(46,8,$total,1,1);
		}
	}
  
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->setMois($mois_en_lettre);
$pdf->AddPage();
$pdf->headerTable($equipement,$date_debut,$date_fin,$mois_avec_indice);
$pdf->viewTable($equipement,$date_debut,$date_fin,$mois_avec_indice);
$pdf->Output();


?>