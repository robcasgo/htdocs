<?php
// creamos la conexión
$conn = mysqli_connect('localhost', 'root', '', 'scrapyard');

// comprobamos la conexión
if (!$conn) {
    // si la conexión falla, mostramos un mensaje de error
    echo '<div class="error">Connection failed: ' . mysqli_connect_error() . '</div>';
    // detenemos la ejecución del script en caso de error de conexión
    die();
}
