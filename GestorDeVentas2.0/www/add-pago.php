<?php
   require_once('db-config.php');
   require_once('navbar.php');
   ?>
<div class="container">
	<h3 class="page-title"> Guardar Pago
      <a href="<?=$_SERVER["HTTP_REFERER"]?>" class="btn btn-success float-right">
      	 Lista de Pagos
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
   $Id = $_GET['LoteId'];
   $sql ="Select * FROM Pagos$proyecto_formateado$Id";
   $ret = $db->query($sql);
   $row = $ret->fetchArray(SQLITE3_ASSOC);
   
?>
<?
$sql = "Select Recibidos as Recibidos From Lotes$proyecto_formateado where Id = $Id";
$ret = $db->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
{
   $recibidos =$row['Recibidos'];

   $sugerencia = $recibidos+1;
}
?>
<form action="save-pago.php?LoteId=<?=$Id ?>" method="post">
   <div class="form-group">
      <label>Numero de Pago</label>

      <input type="number" class="form-control" name="Numero" value="<?=$sugerencia?>">

   </div>

   <div class="form-group">
      <label>Fecha</label>

      <input type="date" class="form-control" name="Fecha">

   </div>

   <div class="form-group">
      <label>Importe</label>

      <input type="number" class="form-control" name="Importe" step="any">

   </div>
   <div class="form-group">
      <label>Referencia</label>

      <input type="text" class="form-control" name="Referencia">

   </div>
   

   <button type="submit" class="btn btn-info">Guardar Pago</button>



</form>


  
</div>


	
</body>
</html>