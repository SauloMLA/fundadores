<?php
header('Refresh:10;url=index.php');
//Include Database
if( isset($_POST['btn']) ){
   require_once('navbar.php');
   require_once('db-config.php');

   $nombre = $_FILES[ 'Imagen' ][ 'name' ];
   $tmp = $_FILES[ 'Imagen' ][ 'tmp_name' ];
   $logo = $_FILES[ 'Logo' ][ 'name' ];
   $logo_tmp = $_FILES[ 'Logo' ][ 'tmp_name' ];
   $folder = 'imagenes';
   move_uploaded_file($tmp, $folder.'/'.$nombre);
   move_uploaded_file($logo_tmp, $folder.'/'.$logo);

   $proyecto = $_POST['Proyecto'];

   $sql ="insert into Usuarios(Id,Proyecto,Img,Logo) values(NULL, \"$proyecto\", \"$folder/$nombre\", \"$folder/$logo\");";
   $ret = $db->exec($sql);
     if(!$ret) {
    echo $db->lastErrorMsg();
    } else {
       require_once('scripts.php')
       ?>
       <script>
       Swal.fire({
         icon: 'success',
         title: 'Guardado Correcto',
         text: 'La informacion fue guardada exitosamente',
         showConfirmButton: false,
         allowOutsideClick: false,
         footer:`<a class="btn btn-success" href="index.php">OK</a>`
     })
     </script>
     <?php
    }
}

 ?>