<?php
header('Refresh:0;url=view-lotes.php');
//Include Database
require_once('db-config.php');
require_once('./db-config.php');
$id = $_GET['Id'];
$falso ="falso";
$verdadero="verdadero";
$al = 1;
$sql ="Update Usuarios set Show=\"$falso\" where AlwaysId=$al ";
$ret = $db->exec($sql);
   if(!$ret) {
      echo $db->lastErrorMsg();
   } else {
      echo $db->changes(), "Venta actualizada exitosamente\n";
   }
   $sql ="Update Usuarios set Show=\"$verdadero\" where Id=$id ";
   $ret = $db->exec($sql);
      if(!$ret) {
         echo $db->lastErrorMsg();
      } else {
         echo $db->changes(), "Venta actualizada exitosamente\n";
      }
      $sql ="Update Usuarios set TLote=\"$verdadero\" where Id=$id ";
      $ret = $db->exec($sql);
         if(!$ret) {
            echo $db->lastErrorMsg();
         } else {
            echo $db->changes(), "Venta actualizada exitosamente\n";
         }      

?>