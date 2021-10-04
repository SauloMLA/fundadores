<?php 
header('Refresh:10;url=index.php');
//Database
require_once('db-config.php');
require_once('navbar.php');
//DElete Student 


//Include Database
require_once('./db-config.php');

//select name of the proyect
$id = $_POST['Id'];
$sql = "Select Proyecto as Proyecto from Usuarios where Id=$id";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $proyecto =$row['Proyecto'];
}

//comprobar si fue configurado
$sql="Select TLote as TLote from Usuarios where Id=$id";
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
  for ($i=0; $i <= $counter; $i++) { 
   $sql = "Select name FROM sqlite_master WHERE type = 'table' AND name LIKE '%Pagos$proyecto_formateado%'";
   $resultado2 = $db->query($sql);
   while($row = $resultado2->fetchArray(SQLITE3_ASSOC) ) 
{
        $name = $row['name'];
        
}
    $sql ="DROP TABLE IF EXISTS $name";
    $result= $db->exec($sql);
    if(!$result) {
    echo $db->lastErrorMsg();
    } else {
    }

}
  }
//lotes
$sql ="DROP TABLE IF EXISTS Lotes$proyecto_formateado";
$resultado = $db->exec($sql);
if(!$resultado) {
   echo $db->lastErrorMsg();
} else {
}

  }
///usuarios
$sql ="delete from Usuarios where Id=$id ";
   $ret = $db->exec($sql);
   if(!$ret) {
      echo $db->lastErrorMsg();
   } else {
      require_once('scripts.php')
      ?>
      <script>
      Swal.fire({
        icon: 'success',
        title: 'Eliminado Correctamente',
        text: 'La informacion fue eliminada exitosamente',
        showConfirmButton: false,
        allowOutsideClick: false,
        footer:`<a class="btn btn-success" href="index.php">OK</a>`
    })
    </script>
    <?php
   }
