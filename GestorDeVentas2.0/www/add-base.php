<?php
   require_once('db-config.php');
   require_once('navbar.php');
   ?>
<div class="container">
	<h3 class="page-title"> Guardar Base De Datos
      <a href="index.php" class="btn btn-success float-right">
      	 Lista de Proyectos
      </a>
	</h3>
<form action="save-base.php" method="post" enctype="multipart/form-data">
   <div class="form-group">
      <label>Archivo (Solo formato db y de nombre sms)</label>
      <input type="file" class="form-control" name="Database">
   </div>
   <button type="submit" class="btn btn-info" name="btn">Reemplazar base de datos</button>
</form>
</div>
</body>
</html>