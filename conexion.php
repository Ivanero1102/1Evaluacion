<?php
 $server = "localhost";
 $user = "root";
 $clave= "";
 $BD="pufosa";

 try {
     $conn = new PDO("mysql:host=$server;dbname=$BD", $user, $clave);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }catch(PDOException $e){
     echo "Conexion fallida". $e->getMessage();
 }
?>