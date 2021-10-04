<?php 
header('Refresh:10;url=view-lotes.php');
//Database
require_once('db-config.php');
require_once('navbar.php');

//Include Database
require_once('./db-config.php');

$id = $_GET['Id'];
$LoteId = $_GET['LoteId'];

$numero = $_POST['Numero'] ;
$fecha = $_POST['Fecha'];
$importe = $_POST['Importe'];
$referencia = $_POST['Referencia'];
$id = $_POST['Id'];

$verdadero = "verdadero";
  $sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
  $ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
  {
    $proyecto =$row['Proyecto'];
  }
  $proyecto_formateado = str_replace(' ', '',  $proyecto);

$sql ="update Pagos$proyecto_formateado$LoteId set Numero=$numero, Fecha =\"$fecha\" ,Importe =$importe ,Referencia=\"$referencia\" where Id=$id ";
   $ret = $db->exec($sql);
   if(!$ret) {
      echo $db->lastErrorMsg();
   } else {
      
   }


//Saldo
$sql = "Select sum(Importe) as Suma from Pagos$proyecto_formateado$LoteId";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $suma =$row['Suma'];
   
}

$sql ="update Lotes$proyecto_formateado set Suma=$suma where Id=$LoteId;";
$ret = $db->exec($sql);
if(!$ret) {
echo $db->lastErrorMsg();
}
else {

}

$sql = "Select Price from Lotes$proyecto_formateado where Id=$LoteId";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $saldo =$row['Price'];
   $saldo = $saldo - $suma;
}

$sql ="update Lotes$proyecto_formateado set Saldo=$saldo where Id=$LoteId;";
$ret = $db->exec($sql);
if(!$ret) {
echo $db->lastErrorMsg();
}
else {
   require_once('scripts.php')
   ?>
   <script>
   Swal.fire({
     icon: 'success',
     title: 'Guardado Correcto',
     text: 'Pago Actualizado Correctamente',
     showConfirmButton: false,
     allowOutsideClick: false,
     footer:`<a class="btn btn-success" href="./view-pagos.php?Id=<?=$LoteId ?>">OK</a>`
 })
 </script>
 <?php
}   


      