<?php 
header('Refresh:10;url=view-lotes.php');
//Database
require_once('db-config.php');

//DElete Student 


//Include Database
require_once('./db-config.php');


$id = $_POST['Id'];
$LoteId = $_POST['LoteId'];

$verdadero = "verdadero";
$sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $proyecto =$row['Proyecto'];
}
$proyecto_formateado = str_replace(' ', '',  $proyecto);

$sql ="delete from Pagos$proyecto_formateado$LoteId where Id=$id ";
   $ret = $db->exec($sql);
   if(!$ret) {
      echo $db->lastErrorMsg();
   } else {
      echo $db->changes(), "Lote borrado exitosamente\n";
   }

 //Saldo
 $sql = "Select sum(Importe) as Suma from Pagos$proyecto_formateado$LoteId";
 $ret = $db->query($sql);
 while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
 {
    $suma =$row['Suma'];
    
 }

 if ($suma == NULL) {
   $suma = 0;
 }

 $sql ="update Lotes$proyecto_formateado set Suma=$suma where Id=$LoteId;";
 $ret = $db->exec($sql);
 if(!$ret) {
 echo $db->lastErrorMsg();
 }
 else {
  echo "Actualizar Suma";
 }
 
 $sql = "Select Price from Lotes$proyecto_formateado where Id=$LoteId";
 $ret = $db->query($sql);
 while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
 {
    $saldo =$row['Price'];
    $saldo = $saldo - $suma;
    echo $saldo;
 }

 $sql ="update Lotes$proyecto_formateado set Saldo=$saldo where Id=$LoteId;";
 $ret = $db->exec($sql);
 if(!$ret) {
 echo $db->lastErrorMsg();
 }
 else {
 echo "Venta guardada exitosamente";
 }   


  //Numero de pagos recibidos
  $sql = "Select Count(*) as Counter from Pagos$proyecto_formateado$LoteId";
  $ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
  {
     $counter =$row['Counter'];
     echo $counter;
  }

  $sql ="update Lotes$proyecto_formateado set Recibidos=$counter where Id=$LoteId;";
  $ret = $db->exec($sql);
  if(!$ret) {
  echo $db->lastErrorMsg();
  }
  else {
   echo "Venta guardada exitosamente";
  }


