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
    $this->Ln(15);
}
}
$Id = $_GET['Id'];
$sql ="Select * FROM Lotes$proyecto_formateado where Id=$Id";

$ret = $db->query($sql); 
   
// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(30);
$sql ="Select MAX(id) AS idpagos FROM Pagos$proyecto_formateado$Id";
$pdf->SetFont('Arial','',12);
   $retidpagos = $db->query($sql);
   while($row = $retidpagos->fetchArray(SQLITE3_ASSOC)){
    $idpagos = $row['idpagos'];
   }
   $sql="Select Fecha as Fecha from Pagos$proyecto_formateado$Id where Id = $idpagos";
   $resultadofecha = $db->query($sql);
   while($row = $resultadofecha->fetchArray(SQLITE3_ASSOC)){
       $fecha = $row['Fecha'];
       setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
       $d = "$fecha";
       $fecha_base = strftime("%d de %B de %Y", strtotime($d));
       $fecha_mayus = strtoupper($fecha_base);
       $prefijo_fecha = 'CULIACÁN, SINALOA A';
       $fecha__final = " $prefijo_fecha $fecha_mayus.";
    $pdf->Cell(80);
    $pdf->Cell(1, 10, utf8_decode($fecha__final), 0,1,'A',0);
    $pdf->Ln(5);
    $pdf->Cell(68);
    // Título
      $pdf->Cell(85, 10, 'RECIBO DE DINERO');
      // Salto de línea
      $pdf->Ln(15);
  
     }
   $pdf->SetFont('Arial','',12);
   $pdf->Cell(7);
   $sql ="Select Cliente as Cliente FROM Lotes$proyecto_formateado where Id=$Id";
   $ret = $db->query($sql); 
   while($row = $ret->fetchArray(SQLITE3_ASSOC)){
    $cliente = $row['Cliente'];
    $cliente_format = strtoupper($cliente);
   $pdf->Cell(80, 5, utf8_decode( "RECIBÍ DEL $cliente_format"),0,0,'F',0);
   }
   $pdf->Cell(15);
   $sql="Select Importe as Importe from Pagos$proyecto_formateado$Id where Id = $idpagos";
   $resultadoImporte = $db->query($sql);
   while($row = $resultadoImporte->fetchArray(SQLITE3_ASSOC)){
  
    $importe_limpio = $row['Importe'];
    $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
    $numero_letra =  $f->format($importe_limpio);
    $numero_letramayus = strtoupper($numero_letra);
    $numero = number_format($row['Importe'], 2);
    $pdf->Cell(80, 5, utf8_decode("LA CANTIDAD DE $$numero"),0,1,'A',0);
    $pdf->Cell(7);
    $pdf->Cell(80, 5, utf8_decode( "($numero_letramayus PESOS 00/100 M.N.), POR CONCEPTO DE PAGO A CUENTA DE"),0,1,'A',0);
    $pdf->Cell(7);
    }
    $sql ="Select * FROM Lotes$proyecto_formateado where Id=$Id";
    $ret = $db->query($sql); 
    while($row = $ret->fetchArray(SQLITE3_ASSOC)){
     $MM = $row['Manzana'];
     $LL = $row['Lote'];
    $pdf->Cell(80, 5, utf8_decode( "TERRENO EN PARQUE FUNDADORES UBICADO EN MANZANA $MM LOTE $LL."),0,0,'A',0);
    }
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(80);
  // Título
    $pdf->Cell(85, 10, 'RECIBE:');
$pdf->Ln(15);
$pdf->Line(50, 107, 210-50, 107); // 50mm from each edge 
$pdf->Cell(55);
$pdf->Cell(85, 10, 'DESARROLLOS QUIYIRA, S.A. DE C.V.');
$pdf->Ln(15);
$pdf->Cell(10);
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(209, 209, 209  );
// $pdf->Cell(0,6,"Capítulo",0,1,'L',true);
$pdf->Cell(170, 8, 'ESTADO DE CUENTA A LA FECHA DE ESTE RECIBO:', 1, 1, 'L', true);
$pdf->Ln(5);
$pdf->Cell(10);
$pdf->Cell(60, 8, 'FECHA', 1, 0, 'C', 0);
$pdf->Cell(60, 8,'IMPORTE PAGADO', 1, 0, 'C', 0);
$pdf->Cell(50, 8, 'SALDO', 1, 1, 'C', 0);

$sql ="Select Recibidos as Recibidos FROM Lotes$proyecto_formateado where Id=$Id";
$resultado = $db->query($sql);
while($row = $resultado->fetchArray(SQLITE3_ASSOC)){
    $recibidos = $row['Recibidos'];
}
$sql ="Select Price as Price FROM Lotes$proyecto_formateado where Id=$Id";
$resultado = $db->query($sql);
while($row = $resultado->fetchArray(SQLITE3_ASSOC)){
    $price = $row['Price'];
}


//tabla con valores

$sql = "Select min(id) as MIN from Pagos$proyecto_formateado$Id";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC)){
    $min = $row['MIN'];
}
$sql = "Select max(id) as MAX from Pagos$proyecto_formateado$Id";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC)){
    $max = $row['MAX'];
}
for ($i=$min; $i <= $max ; $i++) { 
 $id = NULL;
$sql ="Select * FROM Pagos$proyecto_formateado$Id where Id = $i";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC)){
    $id = $row['Id'];
    $importe = number_format($row['Importe'], 2);
    $importeFormatless = $row['Importe'];
    $referencia =  $row['Referencia'];
    if ($i == $max) {
        $importe_referencia = "$importe ESTE RECIBO";
    }
    else{
        $importe_referencia = "$importe  $referencia";
    }
    $pdf->Cell(10);
    $pdf->Cell(60, 8, $row['Fecha'], 1, 0, 'C', 0);
    $pdf->Cell(60, 8, $importe_referencia, 1, 0, 'C', 0);
    
}
if ($id != NULL) {
$sql ="Select sum(Importe) AS Importe FROM Pagos$proyecto_formateado$Id where Id <= $id";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC)){
    $saldo2= $row['Importe'];
    if ($saldo2 >= $importeFormatless) {
    $saldo = $price-$saldo2;
    $saldo_final = number_format($saldo, 2);
    $pdf->Cell(50, 8, "$saldo_final", 1, 1, 'C', 0);
    }
}
}
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',11);
$pdf->Output();


?>