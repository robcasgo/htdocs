<?php
// Creamos la conexión
$conn = mysqli_connect('localhost', 'root', '', 'scrapyard');

// Comprobamos la conexión
if (!$conn) {
    // Si la conexión falla, mostramos un mensaje de error
    echo '<div class="error">Connection failed: ' . mysqli_connect_error() . '</div>';
    die(); // Detenemos la ejecución del script en caso de error de conexión
}

// Si la conexión es exitosa, no es necesario mostrar un mensaje aquí
