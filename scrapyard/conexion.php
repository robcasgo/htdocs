<?php
// Creamos la conexión
$conn = mysqli_connect('localhost', 'root', '', 'scrapyard');

// Comprobamos la conexión
if (!$conn) {
    // Si la conexión falla, mostramos un mensaje de error
    echo '<div class="error">Connection failed: ' . mysqli_connect_error() . '</div>';
} else {
    // Si la conexión es exitosa, mostramos un mensaje de éxito
    echo '<div class="success">Connected successfully</div>';
}
