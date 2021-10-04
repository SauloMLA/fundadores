<?php
require_once('navbar.php');
//Include Database
require_once('db-config.php');
$Id = $_GET['LoteId'];
$numero = $_POST['Numero'] ;
$fecha = $_POST['Fecha'];
$importe = $_POST['Importe'];
$referencia = $_POST['Referencia'];

$verdadero = "verdadero";
    $sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
    $ret = $db->query($sql);
    while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
    {
       $proyecto =$row['Proyecto'];
    }
    $proyecto_formateado = str_replace(' ', '',  $proyecto);

 $sql ="insert into Pagos$proyecto_formateado$Id(Id,Numero,Fecha,Importe,Referencia)
 values(NULL, $numero, \"$fecha\", \"$importe\", \"$referencia\");";

   $ret = $db->exec($sql);
   if(!$ret) {
      echo $db->lastErrorMsg();
   } else {
      
   }

   //Saldo
   $sql = "Select sum(Importe) as Suma from Pagos$proyecto_formateado$Id";
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
      $suma =$row['Suma'];
   }

   $sql ="update Lotes$proyecto_formateado set Suma=$suma where Id=$Id;";
   $ret = $db->exec($sql);
   if(!$ret) {
   echo $db->lastErrorMsg();
   }
   else {
    
   }
   
   $sql = "Select Price from Lotes$proyecto_formateado where Id=$Id";
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
      $saldo =$row['Price'];
      $saldo = $saldo - $suma;
     
   }

   $sql ="update Lotes$proyecto_formateado set Saldo=$saldo where Id=$Id;";
   $ret = $db->exec($sql);
   if(!$ret) {
   echo $db->lastErrorMsg();
   }
   else {
   
   }


   //Numero de pagos recibidos
   $sql = "Select Count(*) as Counter from Pagos$proyecto_formateado$Id";
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
      $counter =$row['Counter'];
     
   }

   $sql ="update Lotes$proyecto_formateado set Recibidos=$counter where Id=$Id;";
   $ret = $db->exec($sql);
   if(!$ret) {
   echo $db->lastErrorMsg();
   }
   else {
      require_once('scripts.php')
      ?>
      <script src="./jquery.min.js"></script>
      <script>
       gotoPdf('<?=$Id?>')
      function gotoPdf(Id){
         console.log("Save Pago: "+Id)
       Swal.fire({
         icon: 'success',
         title: 'Guardado Correcto',
         text: 'Pago Guardado Exitosamente',
         showConfirmButton: true,
         allowOutsideClick: false,
         confirmButtonText: 'OK',
         confirmButtonClass: 'btn btn-primary'
     }).then((result) => {
   if (result.isConfirmed) {
   $.ajax({
     type:'GET',
     data: ({Id: Id}),
     success: function (data) {
         window.location.href = './view-pagos.php?Id=<?=$Id ?>';
     }
    });
 }
 })}
      
    </script>
    <?php
   }
