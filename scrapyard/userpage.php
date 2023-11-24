<?php
include 'conexion.php'; // Incluir el archivo de conexión a la base de datos
include 'header.php'; // Incluir el archivo de cabecera
//include 'carro.php'; // Incluir el archivo de carro de compra

echo "<h1>Página de usuario</h1>";

// Verificar si hay un usuario autenticado en la sesión
if (!isset($_SESSION['rol'])) {
    header("Location: login.php"); // Redirigir a la página de login si no esta identifiado
    exit();
}

include 'footer.php'; // Incluir el archivo de pie de página
