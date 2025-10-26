<?php
$servername="localhost";
$username="root";
$password="";
$dbname="Banorte";

$conn=new mysqli($servername,$username,$password,$dbname);

if($conn){
    die("Conexion exitosa");
}else{
    die("Conexion fallida: " . $conn->connect_error);
}
?>