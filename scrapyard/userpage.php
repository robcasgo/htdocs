<?php
session_start();
include 'header.php'; // Incluir el archivo de cabecera
include 'conexion.php'; // Incluir la conexión a la base de datos

echo "<h1>Carrito de Compras</h1>";

if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    echo "<table>";
    echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr>";

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

    // Recorrer el carrito
    foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
        // Obtener información del producto desde la base de datos
        $productoInfo = obtenerInformacionProducto($conn, $idProducto);

        // Mostrar fila del carrito
        echo "<tr>";
        echo "<td>{$productoInfo['nombre']}</td>";
        echo "<td>$cantidad</td>";
        echo "<td>$ {$productoInfo['precio']}</td>";
        echo "<td>$ " . ($productoInfo['precio'] * $cantidad) . "</td>";
        echo "</tr>";

        // Sumara 1 producto del carrito
        echo "<tr><td colspan='4'><form action='carro.php' method='post'>";
        echo "<input type='hidden' name='accion' value='añadir'>";
        echo "<input type='hidden' name='idProducto' value='$idProducto'>";
        echo "<input type='hidden' name='accion' value='añadir'>";
        echo "<input type='submit' value='+'>";
        echo "</form></td></tr>";

        // Borrar 1 producto del carrito
        echo "<tr><td colspan='4'><form action='carro.php' method='post'>";
        echo "<input type='hidden' name='accion' value='borrar'>";
        echo "<input type='hidden' name='idProducto' value='$idProducto'>";
        echo "<input type='hidden' name='accion' value='borrar'>";
        echo "<input type='submit' value='-'>";
        echo "</form></td></tr>";

        // Elimina el porducto del carrito
        echo "<tr><td colspan='4'><form action='carro.php' method='post'>";
        echo "<input type='hidden' name='accion' value='eliminar'>";
        echo "<input type='hidden' name='idProducto' value='$idProducto'>";
        echo "<input type='hidden' name='accion' value='eliminar'>";
        echo "<input type='submit' value='Eliminar'>";
        echo "</form></td></tr>";
    }

    // Mostrar precio total
    echo "<tr><td colspan='3'><strong>Total</strong></td><td>$ " . calcularPrecioTotal($conn) . "</td></tr>";

    echo "</table>";

    // Formulario para confirmar la compra
    echo "<form action='confirmar_compra.php' method='post'>";
    echo "<input type='submit' value='Confirmar Compra'>";
    echo "</form>";

    // Agregar botones para vaciar el carrito
    echo "<form action='carro.php' method='post'>";
    echo "<input type='hidden' name='accion' value='vaciar'>";
    echo "<input type='submit' value='Vaciar Carrito'>";
    echo "</form>";
} else {
    echo "<p>El carrito está vacío.</p>";
}

include 'footer.php'; // Incluir el archivo de pie de página

// Función para calcular el precio total del carrito
function calcularPrecioTotal($conn)
{
    $total = 0;

    foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
        $productoInfo = obtenerInformacionProducto($conn, $idProducto);
        $total += $productoInfo['precio'] * $cantidad;
    }

    return $total;
}
