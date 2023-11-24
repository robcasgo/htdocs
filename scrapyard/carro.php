<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['accion'] === 'agregar') {
        $idProducto = $_POST['idProducto'];
        $cantidad = $_POST['cantidad'];

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Agregar producto al carrito
        if (array_key_exists($idProducto, $_SESSION['carrito'])) {
            $_SESSION['carrito'][$idProducto] += $cantidad;
        } else {
            $_SESSION['carrito'][$idProducto] = $cantidad;
        }
        // Realizar la acción correspondiente
    } elseif ($_POST['accion'] === 'borrar' && isset($_POST['idProducto'])) {
        $idProductoEliminar = $_POST['idProducto'];

        // Verificar si el producto está en el carrito
        if (isset($_SESSION['carrito'][$idProductoEliminar])) {
            // Reducir la cantidad del producto en 1
            $_SESSION['carrito'][$idProductoEliminar]--;

            // Si la cantidad es 0, borrar el producto del carrito
            if ($_SESSION['carrito'][$idProductoEliminar] <= 0) {
                unset($_SESSION['carrito'][$idProductoEliminar]);
            }
        }
    } elseif ($_POST['accion'] === 'añadir' && isset($_POST['idProducto'])) {
        $idProductoEliminar = $_POST['idProducto'];

        // Verificar si el producto está en el carrito
        if (isset($_SESSION['carrito'][$idProductoEliminar])) {
            // Reducir la cantidad del producto en 1
            $_SESSION['carrito'][$idProductoEliminar]++;

            // Si la cantidad es 0, borrar el producto del carrito
            if ($_SESSION['carrito'][$idProductoEliminar] <= 0) {
                unset($_SESSION['carrito'][$idProductoEliminar]);
            }
        }
    } elseif ($_POST['accion'] === 'vaciar') {
        // Vaciar todo el carrito
        $_SESSION['carrito'] = [];
    }
}

header('Location: index.php');
exit();
