<?php
   require_once('db-config.php');
   require_once('navbar.php');
   ?>
<div class="container">
	<h3 class="page-title"> Actualizar Lote
      <a href="view-lotes.php" class="btn btn-success float-right">
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
   $sql ="Select * from Lotes$proyecto_formateado where Id=$Id";
   $ret = $db->query($sql);
   $row = $ret->fetchArray(SQLITE3_ASSOC);
   
   ?>

 <form action="update-lote.php" method="post">
   <input type="hidden" name="Id" value="<?=$row['Id']?>">
   <input type="hidden" name="Id" value="<?=$row['Id']?>">
   <div class="form-group row">
   <label class="col-sm-1 col-form-label">Manzana: </label>
    <div class="col-sm-5">
      <input type="number" class="form-control"  name="Manzana" value="<?=$row['Manzana']?>">
    </div>
    <label class="col-sm-1 col-form-label">Lote: </label>
    <div class="col-sm-5">
      <input type="number" class="form-control"  name="Lote" value="<?=$row['Lote']?>">
    </div>

   </div>

   <div class="form-group">
      <label>Cliente</label>

      <input type="text" class="form-control" name="Cliente" value="<?=$row['Cliente']?>">

   </div>
   <div class="form-group">
      <label>Fecha</label>

      <input type="text" class="form-control" name="Fecha" value="<?=$row['Fecha']?>">

   </div>

   <div class="form-group">
      <label>Precio de Venta</label>

      <input type="number" class="form-control" name="Precio" step="any" value="<?=$row['Price']?>">

   </div>
   <div class="form-group">
      <label>Plazo</label>

      <input type="text" class="form-control" name="Plazo" value="<?=$row['Plazo']?>">

   </div>

   <button type="submit" class="btn btn-info">Guardar</button>



</form>


  
</div>


	
</body>
</html>