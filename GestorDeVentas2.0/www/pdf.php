<?php
require('fpdf/fpdf.php');
require_once('db-config.php');
$verdadero = "verdadero";
   $sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
      $proyecto =$row['Proyecto'];
   }
   $proyecto_formateado = str_replace(' ', '',  $proyecto);

   class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Arial bold 15
    $this->SetFont('Arial','B',11);
    // Movernos a la derecha
    $this->Cell(75);
    // Título
    $this->Cell(40,10,'Reporte de Lotes');
    // Salto de línea
    $this->Ln(30);


}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$verdadero = "verdadero";

   $sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
      $proyecto =$row['Proyecto'];
   }
   $proyecto_formateado = str_replace(' ', '',  $proyecto);
   $sql ="Select * FROM Lotes$proyecto_formateado ORDER BY Manzana ASC,Lote ASC";
   
   $ret = $db->query($sql);
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$sql ="Select * FROM Usuarios where Show=\"$verdadero\"";
   
   $resultado = $db->query($sql);
   while($row = $resultado->fetchArray(SQLITE3_ASSOC)){
    $filepath = $row['Logo'];
  $pdf->Image($filepath, 10,7,30);
   }
$pdf->SetFont('Arial','B',11);
    $pdf->Cell(15, 10, 'Lote', 1, 0, 'C', 0);
    $pdf->Cell(60, 10, 'Cliente', 1, 0, 'C', 0);
    $pdf->Cell(25, 10,'Fecha', 1, 0, 'C', 0);
    $pdf->Cell(32, 10, 'Precio de V.', 1, 0, 'C', 0);
    $pdf->Cell(20, 10, 'Plazo', 1, 0, 'C', 0);
    $pdf->Cell(10, 10, 'P.R', 1, 0, 'C', 0);
    $pdf->Cell(32, 10, 'Saldo', 1, 1, 'C', 0);
    $pdf->SetFont('Arial','',8.5);
while($row = $ret->fetchArray(SQLITE3_ASSOC)){
   $MM = $row['Manzana'];
      $M = "M$MM";
      $LL = $row['Lote'];
      $L = "L$LL";
      $MMLL = "$M$L";
    $numero = number_format($row['Price'], 2);
    $saldo = number_format($row['Saldo'], 2);
    $pdf->Cell(15, 10, $MMLL, 1, 0, 'C', 0);
    $pdf->Cell(60, 10, $row['Cliente'], 1, 0, 'C', 0);
    $pdf->Cell(25, 10, $row['Fecha'], 1, 0, 'C', 0);
    $pdf->Cell(32, 10, $numero, 1, 0, 'C', 0);
    $pdf->Cell(20, 10, $row['Plazo'], 1, 0, 'C', 0);
    $pdf->Cell(10, 10, $row['Recibidos'], 1, 0, 'C', 0);
    $pdf->Cell(32, 10, $saldo, 1, 1, 'C', 0);
}

$sql ="Select sum(Price) as PriceTotal FROM Lotes$proyecto_formateado";
$ret = $db->query($sql);

while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
 $numero1 = number_format($row['PriceTotal'], 2);
 $pdf->Cell(100);
 $pdf->Cell(32, 10, $numero1, 1, 0, 'C', 0);

}
$sql ="Select sum(Saldo) as SaldoTotal FROM Lotes$proyecto_formateado";
$ret = $db->query($sql);

while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
 $numero = number_format($row['SaldoTotal'], 2);
 $pdf->Cell(30);
 $pdf->Cell(32, 10, $numero, 1, 1, 'C', 0);

}

$pdf->Output();
