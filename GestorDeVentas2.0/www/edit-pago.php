<?php
   require_once('db-config.php');
   require_once('navbar.php');
   ?>
<div class="container">
	<h3 class="page-title"> Actualizar Pago
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
   $LoteId = $_GET['LoteId'];
   $Id = $_GET['Id'];
   $sql = "Select * FROM Pagos$proyecto_formateado$LoteId WHERE Id=$Id";
   $ret = $db->query($sql);
   $row = $ret->fetchArray(SQLITE3_ASSOC);
   

?>

 <form action="update-pago.php?LoteId=<?=$LoteId ?>&Id=<?=$Id ?>" method="post">
 <input type="hidden" name="Id" value="<?=$row['Id']?>">
   <div class="form-group">
      <label>Numero de Pago</label>

      <input type="number" class="form-control" name="Numero" value="<?=$row['Numero']?>">

   </div>

   <div class="form-group">
      <label>Fecha</label>

      <input type="text" class="form-control" name="Fecha" value="<?=$row['Fecha']?>">

   </div>

   <div class="form-group">
      <label>Importe</label>

      <input type="number" class="form-control" name="Importe" step="any" value="<?=$row['Importe']?>">

   </div>
   <div class="form-group">
      <label>Referencia</label>

      <input type="text" class="form-control" name="Referencia" value="<?=$row['Referencia']?>">

   </div>

   <button type="submit" class="btn btn-info">Save</button>



</form>


  
</div>


	
</body>
</html>