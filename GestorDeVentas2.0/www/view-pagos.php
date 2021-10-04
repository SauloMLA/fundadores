<?php
   require_once('db-config.php');
   require_once('navbar.php');
   require_once('scripts.php');
   ?>
<div class="container">
	<h3 class="page-title">Lista de Pagos
      <a href="view-lotes.php" class="btn btn-primary float-right">
      	Lista de Lotes
      </a>
	</h3>
   <?php

  $verdadero = "verdadero";
  $sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
  $ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
  {
    $proyecto =$row['Proyecto'];
  }
  $proyecto_formateado = str_replace(' ', '',  $proyecto);
    $Id = $_GET['Id'];
   $sql ="Select * FROM Lotes$proyecto_formateado where Id=$Id";
   $ret = $db->query($sql);

   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
    $numero = number_format($row['Price'], 2);
    $MM = $row['Manzana'];
      $M = "M$MM";
      $LL = $row['Lote'];
      $L = "L$LL";
      $MMLL = "$M$L";
      ?>
   <div class="container">
   <div class="row">
    <div class="col">
      <h3>Lote</h3>
    </div>
    <div class="col">
     <h3><?=$MMLL;?></h3>
    </div>
  </div>
   </div>
   <div class="container">
   <div class="row">
    <div class="col">
      <h3>Cliente</h3>
    </div>
    <div class="col">
      <h3><?=$row['Cliente'];?></h3>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h3>Precio De Venta </h3>
    </div>
    <div class="col">
      <h3><?=$numero?></h3>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h3>Fecha De Compra</h3>
    </div>
    <div class="col">
      <h3><?=$row['Fecha'];?></h3>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <h3>Plazo</h3>
    </div>
    <div class="col">
      <h3><?=$row['Plazo'];?></h3>
    </div>
  </div>
   </div>
   <?php
   }

?>
<div class="container">
  <!-- Table --->
  <h3>Pagos Recibidos</h3>
  <div id="number2">
   <table class="table table-borderless">
   	<tr>
       <th>Numero de Pago</th>
       <th>Fecha</th>
   		<th>Importe</th>
        <th>Referencia</th>
        <th>Acciones</th>
   	</tr>
<?php

$Id = $_GET['Id'];


$sql = "Create TABLE if not exists Pagos$proyecto_formateado$Id(
	 Id INTEGER,
	 Numero	INTEGER,
	 Fecha	TEXT,
	 Importe	NUMERIC,
	 Referencia	TEXT,
	PRIMARY KEY( Id AUTOINCREMENT)
)";
$ret = $db->query($sql);

$sql ="Select * FROM Pagos$proyecto_formateado$Id  ORDER BY Numero ASC";
$ret = $db->query($sql);

   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
    $importe = number_format($row['Importe'], 2);
      ?>
        <tr>
        <td><?=$row['Numero'];?></td>
	   		<td><?=$row['Fecha'];?></td>
	   		<td><?=$importe?></td>
            <td><?=$row['Referencia'];?></td>
	   		<td>
	   			<a href="edit-pago.php?Id=<?=$row['Id'];?>&LoteId=<?=$Id ?>" class="btn btn-danger">
	   				Editar
	   			</a>

	   			 <!-- <a href="delete-pago.php?Id=?=$row['Id'];?>&LoteId=?=$Id ?>" class="btn btn-primary">
	   				Borrar directo
	   			</a>  -->
           <button class="btn btn-primary" onClick="sweetDelete('<?=$row['Id'];?>', '<?=$Id?>')">Borrar</button>
	   		</td>
	   	</tr>
      <?php
   }
?>  
 	
   </table>
   </div>
   </div>
   <div class="container">
   <?php
   $Id = $_GET['Id'];
   $sql ="Select * FROM Lotes$proyecto_formateado where Id=$Id";
   $ret = $db->query($sql);

   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
     $recibidos = $row['Recibidos'];
    $suma = number_format($row['Suma'], 2);
    $saldo = number_format($row['Saldo'], 2);
      ?>
     <div class="row">
    <div class="col-5">
      <h3>Suma</h3>
    </div>
    <div class="col-7">
    <p><?=$suma;?></p>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-5">
      <h3>Saldo</h3>
    </div>
    <div class="col-sm-7">
      <p><?=$saldo?></p>
    </div>
  </div>
   <?php
   }?>  
   </div>   	
 <!-- Table End --->
 <a href="add-pago.php?LoteId=<?=$Id ?>" class="btn btn-success float-left">
      	Capturar Pago
      </a>
      <a href="./pdfpagos.php?Id=<?=$Id ?>" class="btn btn-info float-right margin-right-1">
      	Exportar a PDF
      </a>
      <?php if ($recibidos > 0) { ?>
      <a href="./recibidospdf.php?Id=<?=$Id ?>" class="btn btn-danger float-right margin-right-1">
      Ver Ultimo Recibo
      </a> <? } ?>
</div>


<script src="./jquery.min.js"></script>
<script>
function sweetDelete(Id, LoteId){
   Swal.fire({
  title: '¿Seguro que quieres borrarlo?',
  icon: 'warning',
  text: "No podras deshacer esta accion, se borraran los registros permanentemente",
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Si, Eliminar Lote!',
  cancelButtonText: 'No, cancelar!',
  confirmButtonClass: 'btn btn-primary',
  cancelButtonClass: 'btn btn-success',
  buttonsStyling: false
}).then((result) => {
  if (result.isConfirmed) {
  $.ajax({
    url:'./delete-pago.php',
    type:'POST',
    data: ({Id: Id, LoteId: LoteId}),
    success: function(html){
                    location.reload();
                }
   });
   Swal.fire(
      'Eliminado!',
      'Eliminado Correctamente',
      'success'
    )
}
}
)
}

</script>
</body>
</html>