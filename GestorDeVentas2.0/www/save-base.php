<?php
header('Refresh:10;url=index.php');
//Include Database
if( isset($_POST['btn']) ){
   require_once('navbar.php');
   require_once('db-config.php');

   $nombre = $_FILES[ 'Database' ][ 'name' ];
   $tmp = $_FILES[ 'Database' ][ 'tmp_name' ];
   $folder = 'database';
   move_uploaded_file($tmp, $folder.'/'.$nombre);
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
 ?>