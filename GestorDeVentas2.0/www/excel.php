<?php 

//Database
require_once('db-config.php');

//Include Database
require_once('./db-config.php');

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte.xls");
header("Pragma: no-cache");
?>

<table class="table">
   	<tr>
       <th>Lote</th>
   		<th>Cliente</th>
   		<th>Fecha</th>
        <th>Precio de Venta</th>
        <th>Plazo</th>
        <th>Pagos Recibidos</th>
        <th>Saldo</th>
</tr>
<?php
$verdadero = "verdadero";
$sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $proyecto =$row['Proyecto'];
}
$proyecto_formateado = str_replace(' ', '',  $proyecto);

$sql ="Select * FROM Lotes$proyecto_formateado ORDER BY Manzana ASC,Lote ASC";

   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
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
            <td><?=$row['Price'];?></td>
	   		<td><?=$row['Plazo'];?></td>
            <td><?=$row['Recibidos'];?></td>
	   		<td><?=$row['Saldo'];?></td>
         </tr>

      <?php
   }
?>
   </table>
  
   </div>
 <!-- Table End --->
</div>