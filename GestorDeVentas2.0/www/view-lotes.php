<?php
   require_once('db-config.php');
   require_once('navbar.php');
   require_once('scripts.php')
   ?>

<div class="container">
	<h3 class="page-title">Lista de Lotes
      <a href="add-lote.php" class="btn btn-success float-right">
      	Nueva Venta
      </a>
   </h3>
   <div class="container margin-bottom-1">
   <a href="excel.php" class="btn btn-success float-right">
      	Exportar a Excel
      </a>
      <a href="./pdf.php" class="btn btn-info float-right margin-right-1">
      	Exportar a PDF
      </a>
   <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
      <input class="form-control mr-sm-2" type="text" placeholder="Busca por lote" name="Busqueda">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
    </form>
    </div>
  <!-- Table --->
  <div id="number1">

   <table class="table">
   	<tr>
       <th>Lote</th>
   		<th>Cliente</th>
   		<th>Fecha</th>
        <th>Precio de Venta</th>
        <th>Plazo</th>
        <th>Pagos R.</th>
        <th>Saldo</th>
        <th>Acciones</th>
</tr>
<?php
$verdadero = "verdadero";
$proyecto= "dont";
$sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $proyecto =$row['Proyecto'];
}

if ($proyecto == "dont") {
  ?>
    <a href="index.php" class="list-group-item list-group-item-action active">Ningun Proyecto Seleccionado, por favor selecciona un proyecto en inicio</a>
  <?php
}else{
$proyecto_formateado = str_replace(' ', '',  $proyecto);
$sql = "Create TABLE if not exists Lotes$proyecto_formateado(
   Id	INTEGER,
   Manzana INTEGER,
	Lote	INTEGER,
	Cliente	TEXT,
	Fecha	TEXT,
	Price	NUMERIC,
	Plazo	TEXT,
	Recibidos	INTEGER,
	Saldo	NUMERIC,
	Suma	NUMERIC,
	PRIMARY KEY(Id AUTOINCREMENT)
)";
$ret = $db->query($sql);
$sql ="Select * FROM Lotes$proyecto_formateado ORDER BY Manzana ASC,Lote ASC";

   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
      $numero = number_format($row['Price'], 2);
      $saldo = number_format($row['Saldo'], 2);
      $MM = $row['Manzana'];
      $M = "M$MM";
      $LL = $row['Lote'];
      $L = "L$LL";
      $MMLL = "$M$L";
      ?>
        <tr>
        <td><?=$MMLL;?></td>
	   		<td><?=$row['Cliente'];?></td>
	   		<td><?=$row['Fecha'];?></td>
            <td><?=$numero?></td>
	   		<td><?=$row['Plazo'];?></td>
            <td><?=$row['Recibidos'];?></td>
	   		<td><?=$saldo?></td>
	   		<td>
	   			<a href="edit-lote.php?Id=<?=$row['Id'];?>" class="btn btn-danger">
	   				Editar
               </a>
               <!-- <a href="delete-lote.php?Id=?=$row'Id'];?>"  class="btn btn-primary">Borrar</a> -->
               <button class="btn btn-primary" onClick="sweetDelete('<?=$row['Id'];?>')">Borrar</button>

               <a href="view-pagos.php?Id=<?=$row['Id'];?>" class="btn btn-success" >
	   				Nuevo Pago
	   			</a>
	   		</td>
         </tr>
     
      <?php
   }
}
?>
   </table>
   </div>
   <?
   $sql ="Select sum(Price) as PriceTotal FROM Lotes$proyecto_formateado";
   $ret = $db->query($sql);

   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
    $numero1 = number_format($row['PriceTotal'], 2);
    ?>
   <div class="container">
   <div class="row">
    <div class="ajustandoprice">
    <td><?=$numero1;?></td>
    </div>
    <?
   }
   $sql ="Select sum(Saldo) as SaldoTotal FROM Lotes$proyecto_formateado";
   $ret = $db->query($sql);

   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
    $numero = number_format($row['SaldoTotal'], 2);
    ?>
    <div class="ajustandosaldo">
      <td><?=$numero;?></td>
    </div>
  </div>
   </div>
   <?php
   }

?>
   
 <!-- Table End --->
</div> 
<script src="./jquery.min.js"></script>
<script>
function sweetDelete(Id){
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
    url:'./delete-lote.php',
    type:'POST',
    data: ({Id: Id}),
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