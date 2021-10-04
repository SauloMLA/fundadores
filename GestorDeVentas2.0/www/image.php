<?php 
require_once('db-config.php');

//DElete Student 


//Include Database
require_once('./db-config.php');


$id = $_GET['Id'];
$sql = "Select Img FROM Usuarios WHERE Id=$id";                                                          
$query = $db->query($sql);
$row = $query->fetchArray(SQLITE3_ASSOC);

header('Content-Type: image/jpg');
echo $row['Img'];