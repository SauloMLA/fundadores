<?php 
header('Refresh:10;url=view-lotes.php');
//Database
require_once('db-config.php');

//DElete Student 

$id = $_POST['Id'];
echo $id;
//Include Database
require_once('./db-config.php');
$verdadero = "verdadero";
$sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $proyecto =$row['Proyecto'];
}

//comprobar si fue configurado
$sql="Select TLote as TLote from Usuarios where Show=\"$verdadero\"";
$ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
  {
     $tLote =$row['TLote'];
   
  }

  if ($tLote == "verdadero") {
   $proyecto_formateado = str_replace(' ', '',  $proyecto);
//borrar pagos
$sql="Select count(*) as Counter from Lotes$proyecto_formateado";
$ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
  {
     $counter =$row['Counter'];
     
  }
  $recibidos = 0;
  $sql="Select Recibidos as Recibidos from Lotes$proyecto_formateado";
  $ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
  {
     $recibidos=$row['Recibidos'];
     
  }
  if ($recibidos > 0) {
 
    $sql ="DROP TABLE IF EXISTS Pagos$proyecto_formateado$id";
    $result= $db->exec($sql);
    if(!$result) {
    echo $db->lastErrorMsg();
    } else {
    }

}

  }
$sql ="delete from Lotes$proyecto_formateado where Id=$id";
   $ret = $db->exec($sql);
   if(!$ret) {
      echo $db->lastErrorMsg();
   } else {
      echo $db->changes(), "Lote borrado exitosamente\n";
   }

  


