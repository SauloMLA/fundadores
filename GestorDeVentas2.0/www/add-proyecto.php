<?php
   require_once('db-config.php');
   require_once('navbar.php');
   ?>
<div class="container">
	<h3 class="page-title"> Guardar Proyecto
      <a href="index.php" class="btn btn-success float-right">
      	 Lista de Proyectos
      </a>
	</h3>

<form action="save-proyecto.php" method="post" enctype="multipart/form-data">
   <div class="form-group">
      <label>Nombre de Proyecto</label>

      <input type="text" class="form-control" name="Proyecto">

   </div>

   <div class="form-group">
      <label>Imagen de Inicio (Solo Imagenes JPEG/JPG)</label>

      <input type="file" class="form-control" name="Imagen">

   </div>
   <div class="form-group">
      <label>Logo(Solo Imagenes PNG)</label>

      <input type="file" class="form-control" name="Logo">

   </div>

   <button type="submit" class="btn btn-info" name="btn">Guardar Proyecto</button>



</form>


  
</div>


	
</body>
</html>