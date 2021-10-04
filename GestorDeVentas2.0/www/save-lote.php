<?php
header('Refresh:10;url=view-lotes.php');
//Include Database
require_once('navbar.php');
require_once('db-config.php');

$manzana = $_POST['Manzana'] ;
$lote = $_POST['Lote'] ;
$cliente = $_POST['Cliente'];
$fecha = $_POST['Fecha'];
$precio = $_POST['Precio'];
$plazo = $_POST['Plazo'];
$recibido = 0;
$saldo = $_POST['Precio'];
$verdadero = "verdadero";

$sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $proyecto =$row['Proyecto'];
}
$proyecto_formateado = str_replace(' ', '',  $proyecto);

$min = NULL;

if ($manzana === '' || $lote === '' || $cliente === '' || $fecha === '' || $precio === '' || $plazo === '') {
   require_once('scripts.php')
   ?>
   <script type="text/javascript">
   Swal.fire({
     icon: 'error',
     title: 'Oops...',
     showConfirmButton: false,
     text: 'Introduce todos los campos',
     footer: '<a href="view-lotes.php">Volver a Inicio</a>'
   })
   </script>
   <?php
}else{
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
for ($i=$min; $i <= $max; ++$i) { 
   
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
if ($lote_igual == $lote) {
   require_once('scripts.php')
   ?>
   <script>
   Swal.fire({
  icon: 'error',
  title: 'Lote Duplicado',
  text: 'Parece que este lote ya fue vendido',
  showConfirmButton: false,
  footer: '<a class="btn btn-success" href="add-lote.php">OK</a>'
})
 </script>
 
 <?php
 
 break;
}
}
if ($lote_igual != $lote) {
   $sql ="insert into Lotes$proyecto_formateado(Id,Manzana,Lote,Cliente,Fecha,Price,Plazo,Recibidos,Saldo)
   values(NULL,\"$manzana\", \"$lote\", \"$cliente\" , \"$fecha\" , $precio, \"$plazo\", $recibido, $saldo);";

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
      require_once('scripts.php')
      ?>
      <script>
      Swal.fire({
        icon: 'success',
        title: 'Guardado Correcto',
        text: 'La informacion fue guardada exitosamente',
        showConfirmButton: false,
        allowOutsideClick: false,
        footer:`<a class="btn btn-success" href="view-lotes.php">OK</a>`
    })
    </script>
    <?php
}
}
}else{
   $sql ="insert into Lotes$proyecto_formateado(Id,Manzana,Lote,Cliente,Fecha,Price,Plazo,Recibidos,Saldo)
   values(NULL,\"$manzana\", \"$lote\", \"$cliente\" , \"$fecha\" , $precio, \"$plazo\", $recibido, $saldo);";

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
       require_once('scripts.php')
       ?>
       <script>
       Swal.fire({
         icon: 'success',
         title: 'Guardado Correcto',
         text: 'La informacion fue guardada exitosamente',
         showConfirmButton: false,
         allowOutsideClick: false,
         footer:`<a class="btn btn-success" href="view-lotes.php">OK</a>`
     })
     </script>
     <?php
}
}
}


