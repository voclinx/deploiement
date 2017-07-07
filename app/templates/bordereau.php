<?php
/**
 * Created by PhpStorm.
 * User: SBOUGH
 * Date: 14/02/2017
 * Time: 17:46
 */
require('pdf/librairies/tcpdf/tcpdf.php');
require('pdf/librairies/tcpdf/tcpdf_import.php');
require('pdf/librairies/fpdi/fpdi.php');

$directory = __dir__;
$directory .= "/pdf/files/hardisLivraison.pdf";
$pdf = new FPDI('P', 'pt');
$pageCount = $pdf->setSourceFile($directory);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPagebreak(true, 50);
//page1
$pdf->addPage();
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
//version
$x = 91.94131274131273;
$y = 711.7789961389961;
$h = 22.985328185328058;
$w = 179.68247104247105;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 14);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell($w, intval($h), $data["version"], false, 1, 'L', true);
//environnement
$x = 40.90594594594594;
$y = 650.4847876447876;
$h = 20.68679536679531;
$w = 162.4296525096525;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 14);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell($w, intval($h), $data["environnement"], false, 1, 'L', true);
//date
$date = explode("-", $_GET['id']);
setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
$x = 40.90594594594594;
$y = 675.0024710424709;
$h = 33.711814671814636;
$w = 138.6781467181467;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 14);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(45, 175, 229);
$pdf->Cell($w, intval($h), strftime("%d %B %Y.", $date[0]), false, 1, 'L', true);

//page 2
$pdf->SetTextColor(0, 0, 0);
$pdf->addPage();
$tplIdx = $pdf->importPage(2);
$pdf->useTemplate($tplIdx);
//environnement
$x = 222.19150579150576;
$y = 170.85760617760616;
$h = 11.492664092664086;
$w = 168.55907335907332;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->SetFillColor(242, 242, 242);
$pdf->Cell($w, intval($h), $data["environnement"], false, 1, 'L', true);
//date
$date = explode("-", $_GET['id']);
$x = 220.65915057915055;
$y = 186.1811583011583;
$h = 11.492664092664086;
$w = 170.85760617760616;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->SetFillColor(242, 242, 242);
$pdf->Cell($w, intval($h), trim(date('d/m/Y', $date[0])), false, 1, 'L', true);
//version
$x = 219.89297297297296;
$y = 232.15181467181463;
$h = 12.258841698841707;
$w = 172.38996138996137;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->SetFillColor(242, 242, 242);
$pdf->Cell($w, intval($h), $data["version"], false, 1, 'L', true);
//environnement
$x = 217.59444015444012;
$y = 247.47536679536677;
$h = 13.791196911196892;
$w = 173.15613899613896;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->SetFillColor(242, 242, 242);
$pdf->Cell($w, intval($h), $data["environnement"], false, 1, 'L', true);
//date
$date = explode("-", $data['id']);
$x = 152.0016988416988;
$y = 362.4020077220077;
$h = 13.791196911196892;
$w = 136.37961389961387;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->SetFillColor(242, 242, 242);
$pdf->Cell($w, intval($h), trim(date('d/m/Y', $date[0])), false, 1, 'L', true);
//Nom du client
$x = 363.9343629343629;
$y = 345.54610038610036;
$h = 13.02501930501927;
$w = 161.66347490347493;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->SetFillColor(242, 242, 242);
$pdf->Cell($w, intval($h), $data["nom_client"], false, 1, 'L', true);
// Signature du client
$x = 363.1681853281853;
$y = 376.9593822393822;
$h = 13.025019305019327;
$w = 161.66347490347488;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->SetFillColor(242, 242, 242);
$pdf->Cell($w, intval($h), $data["signature_client"], false, 1, 'L', true);
//page3

$pdf->SetTextColor(0, 0, 0);
$pdf->addPage();
$tplIdx = $pdf->importPage(3);
$pdf->useTemplate($tplIdx);
//Réserve = commentaires
$x = 75.0854054054054;
$y = 405.3079536679536;
$h = 19.15444015444018;
//$h = 27.58239382239401;
$w = 455.10949806949804;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->MultiCell($w, intval($h), $data["commentaires"], false, 1, 'L', true);
//page4---instructions
$pdf->SetTextColor(0, 0, 0);
$pdf->addPage();
$tplIdx = $pdf->importPage(4);
$pdf->useTemplate($tplIdx);
$x = 75.0854054054054;
$y = 123.35459459459459;
$h = 52.8662548262548;
//$h = 27.58239382239401;
$w = 436.7212355212355;
$pdf->SetMargins($x, $y, 82.34996138996132, false);
$html = tidy_repair_string($data["instructions"]);
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->writeHTML($html, true, false, true, false, 'L');

//page 5
$pdf->SetTextColor(0, 0, 0);
$pdf->addPage();
$tplIdx = $pdf->importPage(5);
$pdf->useTemplate($tplIdx);
//annexe
$x = 75.0854054054054;
$y = 75.0854054054054;
$h = 410.6662548262548;
$w = 685.8884942084942;
$pdf->SetMargins($x, $y, 82.34996138996132, false);
$html = tidy_repair_string($data["annexe"]);
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 11);
$pdf->writeHTML($html, true, false, true, false, 'L');
//couleur blanche pour le nombre des fiches livrés
$x = 403.08138996138996;
$y = 78.0157528957529;
$h = 27.08880308880309;
$w = 117.0236293436293;
$pdf->SetXY($x, $y);
$pdf->SetFont('', '', 14);
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell($w, intval($h), '', false, 1, 'L', true);

if ($data['environnement'] == "Recette") {
    $prefix_environnement = "MASTER";
} elseif ($data['environnement'] == "Preproduction") {
    $prefix_environnement = "PREPROD";
} elseif ($data['environnement'] == "Production") {
    $prefix_environnement = "PROD";
}
$date1 = date("ymd", strtotime($date[3]));
$date2 = date("Ymd", strtotime($date[3]));
$nomfichier = "HARDIS-OPCAIM-PV livraison-Refonte extranet-" . $prefix_environnement . " " . "V" . $data['version'] . "P" . $date1 . "-" . $date2;

if ($pdf) {
    // clean the output buffer to avoid random bugs with tcpdf
    ob_end_clean();
}


$pdf->Output($nomfichier);




