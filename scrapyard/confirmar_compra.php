<?php
session_start();
include 'header.php'; // Incluye la cabecera
include 'conexion.php'; // Incluye la conexión a la base de datos

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Redirige a la página de inicio de sesión o maneja el caso en que el usuario no ha iniciado sesión
    header("Location: login.php");
    exit();
}

// Verifica si $_SESSION['carrito'] está definido y no está vacío
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    // Maneja el caso en que el carrito está vacío
    echo "Error: El carrito está vacío.";
    exit();
}

// Inserta un nuevo pedido en la tabla 'pedidos'
$idUsuario = $_SESSION['user_id'];
$total = calcularPrecioTotal($conn);

// Verifica si $total es numérico
if (!is_numeric($total)) {
    // Maneja el caso en que el total no es un número
    echo "Error: El total no es un número válido.";
    exit();
}

$sql_insertar_pedido = "INSERT INTO pedidos (idusuario, total) VALUES ($idUsuario, $total)";
$resultado_insertar_pedido = $conn->query($sql_insertar_pedido);

if ($resultado_insertar_pedido) {
    $idPedido = $conn->insert_id; // Obtiene el ID del pedido recién insertado

    // Inserta los detalles del pedido en la tabla 'detalles_pedido'
    foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
        $productoInfo = obtenerInformacionProducto($conn, $idProducto);

        // Verifica si $productoInfo no es null
        if ($productoInfo !== null) {
            $precioUnitario = $productoInfo['precio'];

            // Inserta detalles para cada producto en el carrito
            $sql_insertar_detalles = "INSERT INTO detalles_pedido (idpedido, idproducto, cantidad, precioUnitario) VALUES ($idPedido, $idProducto, $cantidad, $precioUnitario)";
            $resultado_insertar_detalles = $conn->query($sql_insertar_detalles);

            if (!$resultado_insertar_detalles) {
                // Maneja el caso en que la inserción de detalles falla
                // Puedes deshacer la inserción del pedido y mostrar un mensaje de error
                echo "Error al insertar detalles del pedido: " . $conn->error;
                // Deshace la inserción del pedido
                $sql_deshacer_pedido = "DELETE FROM pedidos WHERE id = $idPedido";
                $conn->query($sql_deshacer_pedido);
                exit();
            }
        } else {
            // Maneja el caso en que no se obtiene información del producto
            echo "Error: No se pudo obtener información del producto con ID $idProducto";
            exit();
        }
    }

    // Limpia el carrito de compras después de confirmar la compra
    unset($_SESSION['carrito']);

    // Redirige a la pagina del carrito de compras c
    header("Location: userpage.php");
    exit();
} else {
    // Maneja el caso en que la inserción del pedido falla
    echo "Error al insertar pedido: " . $conn->error;
    exit();
}

// Función para calcular el precio total del carrito
function calcularPrecioTotal($conn)
{
    $total = 0;

    foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
        $productoInfo = obtenerInformacionProducto($conn, $idProducto);

        // Verifica si $productoInfo no es null antes de acceder a sus propiedades
        if ($productoInfo !== null) {
            $total += $productoInfo['precio'] * $cantidad;
        } else {
            // Maneja el caso en que no se obtiene información del producto
            echo "Error: No se pudo obtener información del producto con ID $idProducto";
            exit();
        }
    }

    return $total;
}

// Función para obtener información del producto desde la base de datos
function obtenerInformacionProducto($conn, $idProducto)
{
    // Realizar la consulta SQL para obtener la información del producto
    $sql_informacion = "select nombre, precio from productos where id = $idProducto";
    $resultado_informacion = $conn->query($sql_informacion);

    // Verificar si la consulta fue exitosa
    if ($resultado_informacion && $resultado_informacion->num_rows > 0) {
        $row = $resultado_informacion->fetch_assoc();
        return $row;
    } else {
        // Producto no encontrado o vacio
        return ['nombre' => 'Producto no encontrado', 'precio' => 0.00];
    }
}
