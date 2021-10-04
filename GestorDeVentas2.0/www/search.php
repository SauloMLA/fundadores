<?php
   require_once('db-config.php');
   require_once('navbar.php');

   $verdadero = "verdadero";
$sql = "Select Proyecto as Proyecto from Usuarios where Show=\"$verdadero\"";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $proyecto =$row['Proyecto'];
}
$proyecto_formateado = str_replace(' ', '',  $proyecto);
$busqueda = $_POST['Busqueda'];
$busqueda = strtoupper($busqueda);
   ?>
<div class="container">
	<h3 class="page-title">Resultado de Busqueda
      <a href="view-lotes.php" class="btn btn-primary float-right">
      	Volver a Lista Completa
      </a>
   </h3>
   <div class="container margin-bottom-1">
   <form class="form-inline my-2 my-lg-0" method="post" action="search.php">
      <input class="form-control mr-sm-2" type="text" placeholder="Busca por lote" name="Busqueda">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Buscar</button>
    </form>
    </div>

  <!-- Table --->
   <table class="table ">
   	<tr>
       <th>Lote</th>
   		<th>Cliente</th>
   		<th>Fecha</th>
        <th>Precio de Venta</th>
        <th>Plazo</th>
        <th>Pagos Recibidos</th>
        <th>Saldo</th>
        <th>Acciones</th>
   	</tr>
<?php
function strrevpos($instr, $needle)
{
    $rev_pos = strpos (strrev($instr), strrev($needle));
    if ($rev_pos===false) return false;
    else return strlen($instr) - $rev_pos - strlen($needle);
};
function after ($first, $text)
{
    if (!is_bool(strpos($text, $first)))
    return substr($text, strpos($text,$first)+strlen($first));
};
function before ($first, $text)
{
    return substr($text, 0, strpos($text, $first));
};
function between ($first, $second, $text)
{
    return before ($second, after($first, $text));
};
function after_last ($first, $text)
{
    if (!is_bool(strrevpos($text, $first)))
    return substr($text, strrevpos($text, $first)+strlen($first));
};

$manzana = between ('M', 'L', "$busqueda");
$lote = after_last ('L', "$busqueda");

$sql ="Select * FROM Lotes$proyecto_formateado where Manzana LIKE '%$manzana%' and Lote LIKE '%$lote%' ORDER BY Manzana ASC, Lote ASC";

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
        <td><?=$MMLL?></td>
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

	   			<a href="delete-lote.php?Id=<?=$row['Id'];?>" class="btn btn-primary">
	   				Borrar
	   			</a>
               <a href="view-pagos.php?Id=<?=$row['Id'];?>" class="btn btn-success">
	   				Nuevo Pago
	   			</a>
	   		</td>
	   	</tr>
      <?php
   }



?>

   	
   </table>

 <!-- Table End --->
</div>


	
</body>
</html>