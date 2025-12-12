<?php
define('FPDF_FONTPATH',ROOT.'printing/fiches/font');
require('fpdf.php');
require('phplot.php');

// Stream handler to read from global variables
class VariableStream
{
	private $varname;
	private $position;

	function stream_open($path, $mode, $options, &$opened_path)
	{
		$url = parse_url($path);
		$this->varname = $url['host'];
		if(!isset($GLOBALS[$this->varname]))
		{
			trigger_error('Global variable '.$this->varname.' does not exist', E_USER_WARNING);
			return false;
		}
		$this->position = 0;
		return true;
	}

	function stream_read($count)
	{
		$ret = substr($GLOBALS[$this->varname], $this->position, $count);
		$this->position += strlen($ret);
		return $ret;
	}

	function stream_eof()
	{
		return $this->position >= strlen($GLOBALS[$this->varname]);
	}

	function stream_tell()
	{
		return $this->position;
	}

	function stream_seek($offset, $whence)
	{
		if($whence==SEEK_SET)
		{
			$this->position = $offset;
			return true;
		}
		return false;
	}
	
	function stream_stat()
	{
		return array();
	}
}
/**
 * 
 */
class myPDF extends FPDF
{
	var $id;
	var $client;
	var $contract;

	function setId($id)
	{
		$this->id = $id;
	}
	function setClient($client)
	{
		$this->client = $client;
	}
	function setContract($contract)
	{
		$this->contract = $contract;
	}

	function getId()
	{
		return $this->id;
	}
	function getClient()
	{
		return $this->client;
	}
	function getContract()
	{
		return $this->contract;
	}
	/*function getSolde()
	{
		return $solde = $this->getContract()->getSommeTotaleFactureDunClient($this->getId())->fetch()['montant'] - $this->getContract()->getSommeTotalePayementDunClient($this->getId())->fetch()['montant'];
	}*/
	function getInfoClient()
	{
		return $this->getClient()->afficherUnClentAvecContract($this->getId())->fetchObject();
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
	function SetCol($col) 
    {
        // Set position at a given column
        $this->col = $col;
        if ($col == 1)
            $x = 10+$col*67;
        else $x = 10+$col*65;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

 /*   function AcceptPageBreak()
    {
        // Method accepting or not automatic page break
        if($this->col<1)
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
*/
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
		$this->SetFont('Arial','I',8);
        //$this->SetTextColor(128);
        $this->Cell(1,0,'Page '.$this->PageNo()/*.$_SESSION['client']*/,0,1,'L');
        $this->Ln(2);
        $data = $this->getInfoClient();
		
		$this->SetFont('Arial','B',11);
		$this->Cell(120,5,'',0,0);
		$this->MultiCell(100,5,iconv('UTF-8', 'windows-1252', 'Resumé de '.$data->Nom_client));
		$this->Ln(8);
		$this->SetFont('Arial','B',11);
		$this->Cell(10,5,'',0,0);
		$this->Cell(140,5,'Billing number  : '.$data->billing_number,0,0);
		$this->Cell(100,5,'Balance : '.$data->solde.' USD',0,1);
		$this->Cell(10,5,'',0,0);
		$this->Cell(140,5,'Telephone : '.$data->telephone,0,0);
		$this->Cell(100,5,'Service/connexion : '.$data->nomService.' '.$data->bandepassante.' Mbps',0,1);
		$this->Cell(10,5,'',0,0);
		$this->Cell(140,5,'Email : '.$data->mail,0,0);
		$this->Cell(100,5,'Payement mensuel : '.$data->montant.' '.$data->monnaieContract,0,1);
		$this->Cell(10,5,'',0,0);
		$this->Cell(140,5,'Adresse : '.$data->adresse,0,0);
		$this->Cell(100,5,'Etat contrat : '.$data->etat,0,1);
		$this->Cell(10,5,'',0,0);
		$this->Cell(140,5,'Personne de contact : '.$data->personneDeContact,0,0);
		if ($data->type_client == 'paying') $type_client = 'payant';
		if ($data->type_client == 'free') $type_client = 'gratuit';
		if ($data->type_client == 'gone') $type_client = 'partie';
		$this->Cell(100,5,'Type : '.$type_client,0,1);
		$this->Ln();
    }
	function headerTable($contract,$client,$id)
	{    
		//$_SESSION['client'] = $client->getnomclient($id)->fetch()['Nom_client'];
		$data = $this->getInfoClient();
		$balance_initial = $contract->getBalanceInitiale($id)->fetch()['montant'];
		$this->Cell(48,5,'ACTIF SANS DETTE ',1,1);

		$month_etiquete = [1=>'Janvier',2=>'Fevrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Aout',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Decembre'];
		$date = date_parse(date('Y-m-d'));
		$mois = $date['month'];
		$annee = $date['year'];
		$solde_mensuel_array = array();
		for ($i=1; $i < $date['month'] +1; $i++) 
		{ 
			$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $i, $annee);
			//$date1 = $annee.'-'.$i.'-1';
			$billing_date = $annee.'-'.$i.'-'.$nombre_jour;
			$month = ($i < 10 ? '0'.$i : $i);
			$year_month = $annee.$month;

			$taux = 1765;
			$facture_bif = 0;
			$paiement_bif = 0;
			foreach ($contract->getMontantFactureDunClientDuDebutAuneDate($billing_date,$id) as $value) 
			{
				$facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
			}
			foreach ($contract->getMontantPayementDunClientDuDebutAuneDate($year_month,$id) as $value) 
			{
				$paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
			}
			$balance = $facture_bif - $paiement_bif + $balance_initial;
			 
			$this->Cell(20,5,$month_etiquete[$i],1,0,'C');
			if ($balance <= 0) 
			{
				$this->cell(10,5,'ok',1,0,'C');
			}
			else
				$this->cell(10,5,'dero',1,0,'C');
				$this->Cell(18,5,$balance,1,1,'C');
		}
		//$this->setXY(58,-155);
		//$this->Cell(180,5 ,"" , 1,0, "C");

		//$this->setXY(53,58);
		//$this->Cell(187,5,'Graphe ',1,0,'C');
		$this->setXY(238,-150);
		$this->Cell(50,5,'DETAIL STATUT'.date('Y'),1,1,'C');

		for ($i=1; $i < $date['month'] +1; $i++) 
		{ 
			$nombre_jour = cal_days_in_month(CAL_GREGORIAN, $i, $annee);
			//$date1 = $annee.'-'.$i.'-1';
			//$date2 = $annee.'-'.$i.'-'.$nombre_jour;
			$this->setX(238);
			$this->Cell(25,5,$month_etiquete[$i],1,0,'C');
			$statut = $contract->getetatDunClientAuneDate($i,$annee,$id)->fetch();
			if (!empty($statut)) {
			$this->Cell(25,5,$statut['action'],1,1,'C');
			}
			else 
			$this->Cell(25,5,'Actif',1,1,'C');
		}

		$facture_bif = 0;
		$paiement_bif = 0;
		foreach ($contract->getSommeTotaleFactureDunClient($id) as $value) 
		{
			$facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
		}
		foreach ($contract->getSommeTotalePayementDunClient($id) as $value)
		{
			$paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
		}
		//$sommefacture = $contract->getSommeTotaleFactureDunClient($id)->fetch()['montant'];
		//$somme_paiement = $contract->getSommeTotalePayementDunClient($id)->fetch()['montant'];
		//if ($sommefacture == '') $sommefacture = 0;
		//if ($somme_paiement == '') $somme_paiement = 0;
		
		$this->setXY(10,123);
		$this->MultiCell(48,6 ,"Montant des factures :\n".number_format($facture_bif).' BIF' , 1, "C", 0,0,0);
		$this->setXY(58,123);
		$this->MultiCell(36,6 ,"Paiement total :\n". number_format($paiement_bif).' BIF' , 1, "C", 0,1,1);

		$this->setXY(94,123);
		if ($balance_initial == '') $balance_initial = 0;
		$this->MultiCell(33,6 ,"Solde initial\n ".number_format($balance_initial).'_BIF', 1, "C", 0,1,1);

		$this->setXY(127,123);
		$this->setFillColor(102,205,170);
		$this->MultiCell(28,6 ,"Solde :\n". number_format($data->solde).' BIF', 1, "C",1);

		if ($data->etat == 'actif') 
		{   $this->SetFont('Arial','B',14,'C');
			$this->setXY(155,123);
			$this->setFillColor(0,255,0);
			$this->Cell(23,12, $data->etat, 1,0,"C",1);
		}
		else
		{
			$this->SetFont('Arial','B',14,'C');
			$this->setXY(155,123);
			$this->setFillColor(255,0,0);
			$this->Cell(23,12 , $data->etat, 1,0, "C",1);
			//$this->Cell(81,5, $data->etat, 1,0,"C",1);
		}
		$this->SetFont('Arial','',12,'C');
		$this->setXY(178,123);
		$facture_bif += $balance_initial;
		$pourcentage = ($facture_bif == 0 ? 0 : $paiement_bif*100/ $facture_bif);
        //$pourcentage = $somme_paiement*100/ $sommefacture;
        $tx_recouvrement = round($pourcentage,2);
		$this->MultiCell(46,6 ,"Taux de recouvrement\n".$tx_recouvrement.' %' , 1, "C", 0,1,1);
		$this->setXY(224,123);
		$this->MultiCell(34,6 ,"Date echeance\n ".$data->date_creation , 1, "C", 0,1,1);
		/*$valeur = $contract->cautionTotaleDansUnMois($date['month'],$date['year'])->fetch();
        if(!empty($valeur))
        {
            //echo number_format($valeur['montant'],2).'_USD';
        }
        else $valeur ='0.00';*/
		$this->setXY(258,123);
		$montantCaution = $contract->getCautionDunClient($id)->fetch()['montant'];
		$monnaieCaution = $contract->getCautionDunClient($id)->fetch()['monnaie'];
		if ($montantCaution == '') 
		{
			$montantCaution = 0;
			$monnaieCaution = 'USD';
		}
		$this->MultiCell(30,6 ,"Caution:\n ".$montantCaution.' '.$monnaieCaution, 1, "C", 0,1,1);
		/*$this->setXY(255,123);
		$balance_initial = $contract->getBalanceInitiale($id)->fetch()['montant'];
		if ($balance_initial == '') $balance_initial = '0';
		$this->MultiCell(33,6 ,"Solde initial\n ".$balance_initial.'_BIF', 1, "C", 0,1,1);*/
		$this->Ln(10);
	}

	function viewTable($client,$contract,$id,$comptabilite)
	{	
		$this->Ln(10);
		$this->SetLeftMargin(10);
		$this->SetFont('Arial','B',11);
		$this->setXY(10,140);
		$this->SetFillColor(239, 150, 136);
		$this->Cell(45,6,'Date facture',1,0,"C",1); 
		$this->Cell(183,6,'Libelle',1,0,"C",1);
		$this->Cell(50,6,'Montant',1,1,"C",1);
		//$this->Cell(43,5,'Solde',1,1,"C",1);

		$this->SetFont('Arial','',10);

		/**FACTURE TOTALES DES CLIENTS**/
		foreach ($contract->recupererFacturesDunClient($id) as $value) 
		{
			//$solde=$contract->getMontantFactureDunClientDuDebutAuneDate($value->date_creation,$id)->fetch()['montant'] - $contract->getMontantPayementDunClientDuDebutAuneDate($value->date_creation,$id)->fetch()['montant'].' '.$value->monnaie;
			
			$this->Cell(45,6,$value->billing_date,1,0,"C");
			$this->Cell(183,6,' Facture No : '.$value->numero.' '.$value->nomService,1,0,'C');
			$this->Cell(50,6,$value->montant_total.' '.$value->monnaie,1,1);
			//$this->Cell(43,5,$solde .' '.$value->monnaie,1,1);
		}
		
		/********************************************************************   PAIEMENT *********************************************************/
		
		$this->SetFont('Arial','B',11);
		//$this->Cell(4,5,'',0,0);
		$this->SetFillColor(181,252,164);
		$this->setX(10);
		$this->Cell(45,6,'Paiement',1,0,"C",1);
		$this->Cell(183,6,'Libelle',1,0,"C",1);
		$this->Cell(50,6,'Montant',1,1,"C",1);
		//$this->Cell(43,5,'Solde',1,1,"C",1);
		//$this->setX(149);
        foreach ($comptabilite->getPayementsDunClient($id) as $value) 
        {
        	//$montantF =($contract->getMontantFactureDunClientDuDebutAuneDate($value->datepaiement,$id)->fetch()['montant'] == '' ? 0 : $contract->getMontantFactureDunClientDuDebutAuneDate($value->datepaiement,$id)->fetch()['montant']);

    		//$solde = $montantF- $contract->getMontantPayementDunClientDuDebutAuneDate($value->datepaiement,$id)->fetch()['montant'];

	        $this->SetFont('Arial','',10);
	        //$this->setX(10);
	        $this->Cell(45,6,$value->datepaiement,1,0,"C");
	  
			$this->Cell(183,6,' Paiement : '.$value->reference.' taux '.$value->Taux_change_courant,1,0,'C');
			
			$this->Cell(50,6,$value->montant.' '.$value->devise,1,1);
			//$this->Cell(43,5,$solde.' '.$value->devise,1,1);
        }               
	}
	function footer()
	{
        $this->SetY(-20);
        $this->SetFont('Arial','I',10);
       // $this->SetX(20);
        $this->Cell(300,5,$_SESSION['nomSociete'].' '.$_SESSION['adresse'].' '.$_SESSION['telephone'].' '.$_SESSION['email'],0,1,'C');
        //iconv('UTF-8', 'windows-1252', 'Fait à '.$_SESSION['ville']."  le ....../......./........" )
        //$this->Cell(2,2,,0,1,'L');
	}

	function __construct($orientation='L', $unit='mm', $size='A4')
	{
		parent::__construct($orientation, $unit, $size);
		// Register var stream protocol
		stream_wrapper_register('var', 'VariableStream');
	}

	function MemImage($data, $x=null, $y=null, $w=0, $h=0, $link='')
	{
		// Display the image contained in $data
		$v = 'img'.md5($data);
		$GLOBALS[$v] = $data;
		$a = getimagesize('var://'.$v);
		if(!$a)
			$this->Error('Invalid image data');
		$type = substr(strstr($a['mime'],'/'),1);
		$this->Image('var://'.$v, $x, $y, $w, $h, $type, $link);
		unset($GLOBALS[$v]);
	}

	function GDImage($im, $x=null, $y=null, $w=0, $h=0, $link='')
	{
		// Display the GD image associated with $im
		ob_start();
		imagepng($im);
		$data = ob_get_clean();
		$this->MemImage($data, $x, $y, $w, $h, $link);
	}
}

$graph = new PHPlot(500,180);
$graph->SetDataType('data-data');

$pdf = new myPDF();

//Specify some data
$data = array();
$date = date_parse(date('Y-m-d'));
$balance_initial = $contract->getBalanceInitiale($id)->fetch()['montant'];
for ($i=1; $i < $date['month'] +1; $i++) 
{ 
    $nombre_jour = cal_days_in_month(CAL_GREGORIAN, $i, $date['year']);
    //$date1 = $annee.'-'.$i.'-1';
    //$date2 = $date['year'].'-'.$i.'-'.$nombre_jour;
    //$reste_dusolde = $contract->getMontantFactureDunClientDuDebutAuneDate($date2,$id)->fetch()['montant'] - $contract->getMontantPayementDunClientDuDebutAuneDate($date2,$id)->fetch()['montant'];

    $billing_date = $date['year'].'-'.$i.'-'.$nombre_jour;
	$month = ($i < 10 ? '0'.$i : $i);
	$year_month = $date['year'].$month;

	$taux = 1765;
	$facture_bif = 0;
	$paiement_bif = 0;
	foreach ($contract->getMontantFactureDunClientDuDebutAuneDate($billing_date,$id) as $value) 
	{
		$facture_bif += ($value->monnaie == 'BIF' ? round($value->montant) : round($value->montant)*$taux);
	}
	foreach ($contract->getMontantPayementDunClientDuDebutAuneDate($year_month,$id) as $value) 
	{
		$paiement_bif += ($value->exchange_currency == 'BIF' ? $value->montant : $value->montant*$taux);
	}
	$reste_dusolde = $facture_bif - $paiement_bif+ $balance_initial;

    $data[] = array('',$i ,$reste_dusolde);
}
$graph->SetDataValues($data);

//Specify plotting area details
$graph->SetPlotType('lines');
$graph->SetTitleFontSize('2');
$graph->SetTitle('Solde mensuel ');
$graph->SetMarginsPixels(null,null,30,null);
$graph->SetPlotAreaWorld(1,null,null,null);
$graph->SetPlotBgColor('white');
$graph->SetPlotBorderType('left');
$graph->SetBackgroundColor('white');
$graph->SetDataColors(array('red'),array('black'));

//Define the X axis
$graph->SetXLabel('Mois');
$graph->SetXTickIncrement();

//Define the Y axis
$graph->SetYTickIncrement();
$graph->SetPrecisionY(0);
$graph->SetLightGridColor('blue');

//Disable image output
$graph->SetPrintImage(false);
//Draw the graph
$graph->DrawGraph();


//$pdf = new myPDF();

$pdf->SetLeftMargin(10);
$pdf->AliasNbPages();
$pdf->setId($id);
$pdf->setClient($client);
$pdf->setContract($contract);
//$pdf->init($contract,$client,$id);
$pdf->AddPage();
$pdf->headerTable($contract,$client,$id);

$pdf->SetWidths(array(45,150,40,43));
$pdf->GDImage($graph->img,58,58,180);
//$pdf->SetAutoPageBreak(true,55);
$pdf->viewTable($client,$contract,$id,$comptabilite);
$pdf->Output();

?>