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
    $this->SetFont('Arial','B',12);
    // Movernos a la derecha
    $this->Cell(75);
    // Título
    $this->Cell(40,10,'Reporte de Pagos');
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
$Id = $_GET['Id'];
$sql ="Select * FROM Pagos$proyecto_formateado$Id  ORDER BY Numero ASC";

$resultado = $db->query($sql);
$sql ="Select * FROM Lotes$proyecto_formateado where Id=$Id";

$ret = $db->query($sql); 
   
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$sql ="Select * FROM Usuarios where Show=\"$verdadero\"";
   
   $retimage = $db->query($sql);
   while($row = $retimage->fetchArray(SQLITE3_ASSOC)){
    $filepath = $row['Logo'];
  $pdf->Image($filepath, 10,7,30);
   }
$pdf->SetFont('Arial','B',12);
while($row = $ret->fetchArray(SQLITE3_ASSOC)){
    $MM = $row['Manzana'];
      $M = "M$MM";
      $LL = $row['Lote'];
      $L = "L$LL";
      $MMLL = "$M$L";
    $numero = number_format($row['Price'], 2);
    $pdf->Cell(10);
    $pdf->Cell(85, 10, 'Lote:', 0, 0, 'A', 0);
    $pdf->Cell(85, 10, $MMLL, 0, 1, 'C', 0);   
    $pdf->Cell(10); 
    $pdf->Cell(85, 10, 'Cliente', 0, 0, 'A', 0);
    $pdf->Cell(85, 10,$row['Cliente'], 0, 1, 'C', 0);
    $pdf->Cell(10);
    $pdf->Cell(85, 10, 'Precio de Venta', 0, 0, 'A', 0);
    $pdf->Cell(85, 10,$numero, 0, 1, 'C', 0);
    $pdf->Cell(10);
    $pdf->Cell(85, 10, 'Fecha' , 0, 0, 'A', 0);
    $pdf->Cell(85, 10, $row['Fecha'], 0, 1, 'C', 0);
    $pdf->Cell(10);
    $pdf->Cell(85, 10, 'Plazo' , 0, 0, 'A', 0);
    $pdf->Cell(85, 10, $row['Plazo'], 0, 1, 'C', 0);
}
$pdf->Ln(5);
$pdf->Cell(10);
$pdf->Cell(170, 10, 'Pagos Recibidos', 0, 1, 'B', 0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(10);
$pdf->Cell(30, 10, 'Numero', 0, 0, 'C', 0);
$pdf->Cell(60, 10, 'Fecha', 0, 0, 'C', 0);
$pdf->Cell(50, 10,'Importe', 0, 0, 'C', 0);
$pdf->Cell(30, 10, 'Referencia', 0, 1, 'C', 0);
$pdf->SetFont('Arial','',11);
while($row = $resultado->fetchArray(SQLITE3_ASSOC)){
    $importe = number_format($row['Importe'], 2);
    $pdf->Cell(10);
    $pdf->Cell(30, 10, $row['Numero'], 0, 0, 'C', 0);
    $pdf->Cell(60, 10, $row['Fecha'], 0, 0, 'C', 0);
    $pdf->Cell(50, 10, $importe, 0, 0, 'C', 0);
    $pdf->Cell(30, 10, $row['Referencia'], 0, 1, 'C', 0);
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
while($row = $ret->fetchArray(SQLITE3_ASSOC)){
    $saldo = number_format($row['Saldo'], 2);
    $suma = number_format($row['Suma'], 2);
    $pdf->Cell(10);
    $pdf->Cell(85, 10, 'Suma', 0, 0, 'A', 0);
    $pdf->Cell(85, 10, $suma, 0, 1, 'C', 0);   
    $pdf->Cell(10); 
    $pdf->Cell(85, 10, 'Saldo', 0, 0, 'A', 0);
    $pdf->Cell(85, 10,$saldo, 0, 1, 'C', 0);
}
$pdf->Output();
?>