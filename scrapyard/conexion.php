<?php
// Creamos la conexion
$conn = mysqli_connect('localhost', 'root', '', 'scrapyard');

// Comprobamos conexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
