<?php
session_start();
include 'conexion.php'; // Incluir el archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['accion'] === 'agregar') {
        // Agregar producto al carrito
        $idProducto = $_POST['idProducto'];
        $cantidad = $_POST['cantidad'];

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Verificar si el producto ya está en el carrito
        if (isset($_SESSION['carrito'][$idProducto])) {
            $_SESSION['carrito'][$idProducto] += $cantidad;
        } else {
            $_SESSION['carrito'][$idProducto] = $cantidad;
        }
    } elseif ($_POST['accion'] === 'vaciar') {
        // Vaciar el carrito
        unset($_SESSION['carrito']);
    }
}

header('Location: index.php');
exit();
