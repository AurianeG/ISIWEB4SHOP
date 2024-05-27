<?php

class PDF extends FPDF
{
function Footer()
{
    $this->SetY(-15);
    $this->SetFont('Arial','I',8);
    $this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function FancyTable($header, $data)
{
    $this->SetFillColor(104,105,255);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(70, 40, 40, 40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $txt= iconv('UTF-8', 'windows-1252', $row['name']);
        $this->Cell($w[0],6,$txt ,'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row['price'],'LR',0,'L',$fill);
        $sousTotal = $row['price']*$row['quantity'];
        $this->Cell($w[2],6,$row['quantity'],'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($sousTotal, 2, ',', ' '),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
    $this->Ln();
}
}

$order_id = $_GET['order_id'];
if (isset($_GET['paiement'])) {
    $paiement = $_GET['paiement'];
    setPayment($paiement,$order_id);
}
$details = getDetailsFactures($order_id);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Facture ISIWEb4SHOP',1,0,'C');
$pdf->Image('data/img/Web4ShopHeader.png',10,10,26);
$pdf->Ln(20);
$pdf->Cell(0,10,'Merci de votre achat '.$details['customer']['surname']. ' '. $details['customer']['forname']. ' !',0,1);

$txt = iconv('UTF-8', 'windows-1252', 'Votre commande a bien été prise en compte.');
$pdf->Cell(0,10,$txt,0,1);

$txt = iconv('UTF-8', 'windows-1252', 'Cette facture fait lieu de ticket de caisse, merci de la conserver pour toute réclamation.');
$pdf->Cell(0,5,$txt,0,1);

$txt = iconv('UTF-8', 'windows-1252', 'N° de commande : '.$order_id);
$pdf->Cell(0,15,$txt,0,1);

$txt = iconv('UTF-8', 'windows-1252', 'Adresse de livraison : '. $details['adresse']);
$pdf->Cell(0,5,$txt,0,1);

$pdf->Cell(0,10,'Produits de votre commande : ',0,1);

$header = array('Nom', 'Prix Unitaire', 'Quantite', 'Sous-total');
$data =$details['produits'];
$pdf->FancyTable($header,$data);
$pdf->Cell(0,20,'Total de votre commande : '.number_format($details['order'][0]['total'], 2, ',', ' ').' euros',0,1);

$txt = file_get_contents('data/payerParCheque.txt');
$txt = iconv('UTF-8', 'windows-1252', $txt);
$pdf->SetFont('Times','',12);
$pdf->MultiCell(0,5,$txt);
$pdf->Ln();

$pdf->AddPage();
 $txt = file_get_contents('data/ConditionDeVente.txt');
 $txt = iconv('UTF-8', 'windows-1252', $txt);
 $pdf->SetFont('Times','',12);
 $pdf->MultiCell(0,5,$txt);
 $pdf->Ln();

$pdf->Output();


?>