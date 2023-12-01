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
        header('Location: index.php');
        // Accion de borrar un producto del carrito
    } elseif ($_POST['accion'] === 'borrar' && isset($_POST['idProducto'])) {
        $idProductoBorrar = $_POST['idProducto'];

        // Verificar si el producto está en el carrito
        if (isset($_SESSION['carrito'][$idProductoBorrar])) {
            // Reducir la cantidad del producto en 1
            $_SESSION['carrito'][$idProductoBorrar]--;

            // Si la cantidad es 0, borrar el producto del carrito
            if ($_SESSION['carrito'][$idProductoBorrar] <= 0) {
                unset($_SESSION['carrito'][$idProductoBorrar]);
            }
        }
        header('Location: userpage.php');
        // Accion de eliminar el producto totalmente del carrito
    } elseif ($_POST['accion'] === 'eliminar' && isset($_POST['idProducto'])) {
        $idProductoEliminar = $_POST['idProducto'];

        // Verificar si el producto está en el carrito
        if (isset($_SESSION['carrito'][$idProductoEliminar])) {
            // Eliminar el producto del carrito
            unset($_SESSION['carrito'][$idProductoEliminar]);
        }
        header('Location: userpage.php');
        // Accion de añadir un producto al carrito
    } elseif ($_POST['accion'] === 'añadir' && isset($_POST['idProducto'])) {
        $idProductoAñadir = $_POST['idProducto'];

        // Verificar si el producto está en el carrito
        if (isset($_SESSION['carrito'][$idProductoAñadir])) {
            // Aumentar la cantidad del producto en 1
            $_SESSION['carrito'][$idProductoAñadir]++;
        }
        header('Location: userpage.php');
        // Accion de vaciar el carrito
    } elseif ($_POST['accion'] === 'vaciar') {
        // Vaciar todo el carrito
        $_SESSION['carrito'] = [];
        header('Location: userpage.php');
    }
}

exit();
