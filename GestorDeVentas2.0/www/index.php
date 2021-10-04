<?php
   require_once('db-config.php');
   require_once('navbar.php');
   require_once('scripts.php')
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/OwnCarousel/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" href="css/OwnCarousel/dist/assets/owl.theme.default.min.css">
</head>
<body>
<div class="container">
	<h3 class="page-title">Proyectos
      <a href="add-proyecto.php" class="btn btn-success float-right">
      	Nuevo Proyecto
      </a>
   </h3>
</div>   
<div class="container">             
<div class="owl-carousel owl-theme">
<?php
   require_once('db-config.php');
   $sql = "Select Count(*) as Counter from Usuarios";
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
      $counter =$row['Counter'];
   }
   $sql = "Select * From Usuarios";
   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ) 
   {
   ?>
   <div class="item">
   <img class="owl-lazy" data-src="<?=$row['Img'];?>" alt="" width="100" height="500">
   <h2 class="text-center"><?=$row['Proyecto'];?></h2>
   <form method="post" action="set-proyect.php?Id=<?=$row['Id'];?>">
   <button class="btn btn-info float-right">Lista de Lotes</button></form>
   <button class="btn btn-primary" onClick="sweetDelete('<?=$row['Id'];?>')">Borrar</button>
   </div>
   
<?php } 

$archivo = "sms.db"
?>

</div>
<div class="margin-top-1">
<a class="btn btn-info float-right" href="download.php?file=<?=$archivo?>">Descargar Base De Datos</a>
<button onclick="subirArchivo()" class="btn btn-success float-left">Subir Base de Datos</button>
</div>
</div>

<script src="./jquery.min.js"></script>
<script src="./css/OwnCarousel/dist/owl.carousel.min.js"></script>
<script type="text/javascript">
$('.owl-carousel').owlCarousel({
    items: 1,
    lazyLoad: true,
    loop: true,
    margin: 10
});
</script>
<script>
function sweetDelete(Id){
   Swal.fire({
  title: '¿Seguro que quieres borrarlo?',
  icon: 'warning',
  text: "No podras deshacer esta accion, se borraran los registros permanentemente",
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Si, Eliminar Proyecto!',
  cancelButtonText: 'No, cancelar!',
  confirmButtonClass: 'btn btn-primary',
  cancelButtonClass: 'btn btn-success',
  buttonsStyling: false
}).then((result) => {
  if (result.isConfirmed) {
  $.ajax({
    url:'./delete-proyect.php',
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
function subirArchivo(){
   Swal.fire({
  title: '¿Seguro que quieres subir una base de datos?',
  icon: 'warning',
  text: "No podras deshacer esta accion, se reemplazaran todos los registros previos",
  type: 'warning',
  showCancelButton: false,
  showConfirmButton: false,
  footer:`<a class="btn btn-success" href="add-base.php">Si, seguro</a> <a class="btn btn-primary" href="index.php">Cancelar</a>`
})
}
</script>
</body>
</html>
