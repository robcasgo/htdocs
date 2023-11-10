<?php
include("conexion.php");

// Recojo los parámetros enviados  
$name = $_POST["username"];
$score = $_POST["password"];

// Construyo la consulta
$sql = "insert into users (username, password) values ('$name', '$password')";

// ejecuto la consulta
$conn->query($sql);

//cierro la conexión
$conn->close();
?>