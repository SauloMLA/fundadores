<?php
   require_once('db-config.php');
   require_once('navbar.php');
   ?>
<div class="container">
	<h3 class="page-title"> Guardar Venta de Lote
      <a href="view-lotes.php" class="btn btn-success float-right">
      	 Lista de Lotes
      </a>
	</h3>

<form action="save-lote.php" method="post" onsubmit="return false;">
   <div class="form-group row">
   <label class="col-sm-1 col-form-label">Manzana: </label>
    <div class="col-sm-5">
      <input type="number" class="form-control"  name="Manzana">
    </div>
    <label class="col-sm-1 col-form-label">Lote: </label>
    <div class="col-sm-5">
      <input type="number" class="form-control"  name="Lote">
    </div>

   </div>

   <div class="form-group">
      <label>Cliente</label>

      <input type="text" class="form-control" name="Cliente">

   </div>
   <div class="form-group">
      <label>Fecha</label>

      <input type="date" class="form-control" name="Fecha">

   </div>

   <div class="form-group">
      <label>Precio de Venta</label>

      <input type="number" class="form-control" name="Precio" step="any">

   </div>
   <div class="form-group">
      <label>Plazo</label>

      <input type="text" class="form-control" name="Plazo">

   </div>
   

   <button type="button" class="btn btn-info" onClick="submit();">Guardar Venta</button>



</form>


  
</div>

	
</body>
</html>