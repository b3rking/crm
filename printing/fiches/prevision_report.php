<?php
///define('FPDF_FONTPATH','/opt/lampp/htdocs/crm.spi.uva/printing/fiches/font');
define('FPDF_FONTPATH',ROOT.'/printing/fiches/font');
require('fpdf.php');

/**
 * 
 */
/*class myPDF extends FPDF
{
}*/
$pdf = new FPDF('L','mm','A4');
$pdf->AddPage();

$pdf->setFont('Arial','B',14);
$pdf->setXY(80,20);

$pdf->Cell(30,5,iconv('UTF-8', 'windows-1252', 'RAPPORT DE PREVISION'));
$pdf->Ln(20);
$pdf->setX(20);
foreach ($data as $key => $value) 
{
	$pdf->Cell(30,8,$months[$key],1,0,'',0);
}
$pdf->Ln();
$pdf->setX(20);
$pdf->setFont('Arial','',12);
foreach ($data as $key => $value) 
{
	$pdf->Cell(30,8,number_format($value),1,0,'',0);
}





// Chart properties

// position
$chartX=20;
$chartY=80;

// Dimension

$chartWidth=180;
$chartHeight=100;

// Padding

$chartTopPadding=10;
$chartLeftPadding=20;
$chartBottomPadding=10;
$chartRightPadding=5;

// Chart box
$chartBoxX=$chartX+$chartLeftPadding;
$chartBoxY=$chartY+$chartTopPadding;
$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
$chartBoxHeigth=$chartHeight-$chartTopPadding-$chartBottomPadding;

// Chart box

$barWidth=10;

// Chart data

/*$data = array(
	'lorem' =>[
		'color' => [255,0,0],
		'value' => 100
		],
	'ipsum' =>[
		'color' => [255,255,0],
		'value' => 300
		],
	'dolor' =>[
		'color' => [50,0,255],
		'value' => 150
		],
	'sit' =>[
		'color' => [255,0,255],
		'value' => 50
		],
	'amet' =>[
		'color' => [0,255,0],
		'value' => 240
	]
);*/

// Data max

$dataMax=0;

foreach ($data as $item) {
	$item = round($item);
	if ($item > $dataMax) $dataMax=$item;
}

// Data step

$dataStep=50000000;

// set font, line width and color

$pdf->setFont('Arial','',9);
$pdf->setLineWidth(0,2);
$pdf->setDrawColor(0);

// chart boundary

//$pdf->Rect($chartX,$chartY,$chartWidth,$chartHeight);

// verticle axis line

$pdf->Line(
	$chartBoxX,
	$chartBoxY,
	$chartBoxX,
	$chartBoxY+$chartBoxHeigth
);

// horizontal axis line

$pdf->Line(
	$chartBoxX-2,
	$chartBoxY+$chartBoxHeigth,
	$chartBoxX+$chartBoxWidth,
	$chartBoxY+$chartBoxHeigth
);

// verticle axis

// calculate chart'is y axis scale unit
$yAxisUnits=$chartBoxHeigth / $dataMax;

// draw the verticle (y) axis labels
for ($i=0; $i <= $dataMax; $i+=$dataStep) 
{ 
	// y position

	$yAxisPos=$chartBoxY + ($yAxisUnits * $i);

	// draw y axis lines
	$pdf->Line(
		$chartBoxX - 2,
		$yAxisPos,
		$chartBoxX,
		$yAxisPos
	);

	// set cell position for y axis labels
	$pdf->setXY($chartBoxX - $chartLeftPadding,$yAxisPos -2);
	// write labels
	$pdf->Cell($chartLeftPadding - 4,5,number_format($dataMax - $i),0,0,'R');
}
// horizontal axis

// set cell position

$pdf->setXY($chartBoxX,$chartBoxY + $chartBoxHeigth);

// Cell's width

$xLabelWidth=$chartBoxWidth / count($data);

// loop horizontal axis and draw the bars
$barXPos=0;
foreach ($data as $itemName => $item) 
{
	// print the label
	$pdf->Cell($xLabelWidth,5,$months[$itemName],0,0,'C');
	// drawing the bar
	// bar color
	$pdf->setFillColor(124,74,47);
	// bar height
	$barHeight=$yAxisUnits * round($item);
	// bar x position
	$barX=($xLabelWidth / 2) + ($xLabelWidth * $barXPos);
	$barX=$barX-($barWidth/2);
	$barX=$barX+$chartBoxX;

	// bar y position
	$barY=$chartBoxHeigth - $barHeight;
	$barY=$barY+$chartBoxY;

	// draw the bar
	$pdf->Rect($barX,$barY,$barWidth,$barHeight,'DF');

	// increment barXPos
	$barXPos++;

}


$pdf->Output();