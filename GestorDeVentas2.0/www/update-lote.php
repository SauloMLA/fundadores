<?php 
header('Refresh:10;url=view-lotes.php');
//Database
require_once('db-config.php');
require_once('navbar.php');

//Include Database
require_once('./db-config.php');

$manzana = $_POST['Manzana'] ;
$lote = $_POST['Lote'] ;
$cliente = $_POST['Cliente'];
$fecha = $_POST['Fecha'];
$precio = $_POST['Precio'];
$plazo = $_POST['Plazo'];
$id = $_POST['Id'];

$verdadero = "verdadero";
   $sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
      $proyecto =$row['Proyecto'];
   }
   $proyecto_formateado = str_replace(' ', '',  $proyecto);

   $min = NULL;

$sql="Select min(Id) as MIN From Lotes$proyecto_formateado where Manzana = $manzana";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $min = $row['MIN'];
   
}
$sql="Select max(Id) as MAX From Lotes$proyecto_formateado where Manzana = $manzana";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $max = $row['MAX'];
   
}

if ($min != NULL) {
for ($i=$min; $i < $max; ++$i) { 
   
   $sql="Select Id From Lotes$proyecto_formateado where Id = $i and Manzana = $manzana";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $id_igual = $row['Id'];
   
}
   
$sql="Select Lote From Lotes$proyecto_formateado where Id = $id_igual";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $lote_igual = $row['Lote'];
   
}
if ($lote_igual == $lote and $id_igual != $id) {
   require_once('scripts.php')
   ?>
   <script>
   Swal.fire({
  icon: 'error',
  title: 'Lote Duplicado',
  text: 'Parece que este lote ya fue vendido',
  showConfirmButton: false,
  footer: '<a class="btn btn-success" href="edit-lote.php?Id=<?=$id ?>">OK</a>'
})
 </script>
 
 <?php
 
 break;
}
}
if ($lote_igual != $lote) {
   $sql ="update Lotes$proyecto_formateado set Manzana=\"$manzana\", Lote=\"$lote\", Cliente =\"$cliente\" ,Fecha =\"$fecha\" ,Price=$precio, Plazo=\"$plazo\" where Id=$id ";
   $ret = $db->exec($sql);
   if(!$ret) {
      require_once('scripts.php')
?>
<script type="text/javascript">
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Algo Salio Mal!, vuelvelo a intentar y si el sistema persiste consulta soporte tecnico',
  footer: '<a href="view-lotes.php">Volver a Inicio</a>'
})
</script>
<?php
   } else {
      
   }


//Saldo
//comprobar si fue configurado
$recibidos = 0;
$suma = 0;
  $sql="Select Recibidos as Recibidos from Lotes$proyecto_formateado where Id = $id";
  $ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
  {
     $recibidos=$row['Recibidos'];
     
  }
  if ($recibidos > 0) {
$sql = "Select sum(Importe) as Suma from Pagos$proyecto_formateado$id";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $suma = $row['Suma'];
}
  }
$sql ="Update Lotes$proyecto_formateado set Suma=$suma where Id=$id;";
$ret = $db->exec($sql);
if(!$ret) {
require_once('scripts.php')
?>
<script type="text/javascript">
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Algo Salio Mal!, vuelvelo a intentar y si el sistema persiste consulta soporte tecnico',
  footer: '<a href="view-lotes.php">Volver a Inicio</a>'
})
</script>
<?php
}
else {

}

$sql = "Select Price from Lotes$proyecto_formateado where Id=$id";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $saldo =$row['Price'];
   $saldo = $saldo - $suma;
   
}

$sql ="Update Lotes$proyecto_formateado set Saldo=$saldo where Id=$id;";
$ret = $db->exec($sql);
if(!$ret) {
require_once('scripts.php')
?>
<script type="text/javascript">
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Algo Salio Mal!, vuelvelo a intentar y si el sistema persiste consulta soporte tecnico',
  footer: '<a href="view-lotes.php">Volver a Inicio</a>'
})
</script>
<?php
}
else {
   require_once('scripts.php')
   ?>
   <script type="text/javascript">
   Swal.fire({
     icon: 'success',
     title: 'Guardado Correcto',
     text: 'La informacion fue actualizada exitosamente',
     showConfirmButton: false,
     allowOutsideClick: false,
     footer:`<a class="btn btn-success" href="view-lotes.php">OK</a>`
 })
 </script>
 <?php
}
}
}else{
   $sql ="update Lotes$proyecto_formateado set Manzana=\"$manzana\", Lote=\"$lote\", Cliente =\"$cliente\" ,Fecha =\"$fecha\" ,Price=$precio, Plazo=\"$plazo\" where Id=$id ";
   $ret = $db->exec($sql);
   if(!$ret) {
      require_once('scripts.php')
?>
<script type="text/javascript">
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Algo Salio Mal!, vuelvelo a intentar y si el sistema persiste consulta soporte tecnico',
  footer: '<a href="view-lotes.php">Volver a Inicio</a>'
})
</script>
<?php
   } else {
      
   }


//Saldo
//comprobar si fue configurado
$recibidos = 0;
$suma = 0;
  $sql="Select Recibidos as Recibidos from Lotes$proyecto_formateado where Id = $id";
  $ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
  {
     $recibidos=$row['Recibidos'];
     
  }
  if ($recibidos > 0) {
$sql = "Select sum(Importe) as Suma from Pagos$proyecto_formateado$id";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $suma = $row['Suma'];
}
  }
$sql ="Update Lotes$proyecto_formateado set Suma=$suma where Id=$id;";
$ret = $db->exec($sql);
if(!$ret) {
require_once('scripts.php')
?>
<script type="text/javascript">
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Algo Salio Mal!, vuelvelo a intentar y si el sistema persiste consulta soporte tecnico',
  footer: '<a href="view-lotes.php">Volver a Inicio</a>'
})
</script>
<?php
}
else {

}

$sql = "Select Price from Lotes$proyecto_formateado where Id=$id";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $saldo =$row['Price'];
   $saldo = $saldo - $suma;
   
}

$sql ="Update Lotes$proyecto_formateado set Saldo=$saldo where Id=$id;";
$ret = $db->exec($sql);
if(!$ret) {
require_once('scripts.php')
?>
<script type="text/javascript">
Swal.fire({
  icon: 'error',
  title: 'Oops...',
  text: 'Algo Salio Mal!, vuelvelo a intentar y si el sistema persiste consulta soporte tecnico',
  footer: '<a href="view-lotes.php">Volver a Inicio</a>'
})
</script>
<?php
}
else {
   require_once('scripts.php')
   ?>
   <script type="text/javascript">
   Swal.fire({
     icon: 'success',
     title: 'Guardado Correcto',
     text: 'La informacion fue actualizada exitosamente',
     showConfirmButton: false,
     allowOutsideClick: false,
     footer:`<a class="btn btn-success" href="view-lotes.php">OK</a>`
 })
 </script>
 <?php
}
}
