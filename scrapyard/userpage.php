<?php
include 'header.php'; // Incluir el archivo de cabecera
include 'conexion.php'; // Incluir el archivo de connexion

echo "<h1>Carrito de Compras</h1>";

if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    echo "<table>";
    echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr>";

    // Función para obtener información del producto desde la base de datos (puedes adaptarla según tu estructura)
    function obtenerInformacionProducto($idProducto)
    {
        // Implementa la lógica para obtener la información del producto según su ID desde la base de datos
        // Puedes realizar una consulta SQL aquí
        // Devuelve un array con la información del producto
        return ['nombre' => 'Producto de prueba', 'precio' => 10.99];
    }

    // Recorrer el carrito
    foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
        // Obtener información del producto desde la base de datos
        $productoInfo = obtenerInformacionProducto($idProducto);

        // Mostrar fila del carrito
        echo "<tr>";
        echo "<td>{$productoInfo['nombre']}</td>";
        echo "<td>$cantidad</td>";
        echo "<td>$ {$productoInfo['precio']}</td>";
        echo "<td>$ " . ($productoInfo['precio'] * $cantidad) . "</td>";
        echo "</tr>";

        // Puedes agregar un formulario para permitir eliminar productos del carrito
        echo "<tr><td colspan='4'><form action='carro.php' method='post'>";
        echo "<input type='hidden' name='accion' value='eliminar'>";
        echo "<input type='hidden' name='idProducto' value='$idProducto'>";
        echo "<input type='submit' value='Eliminar'>";
        echo "</form></td></tr>";
    }

    // Mostrar precio total
    echo "<tr><td colspan='3'><strong>Total</strong></td><td>$ " . calcularPrecioTotal() . "</td></tr>";

    echo "</table>";

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
function calcularPrecioTotal()
{
    $total = 0;

    foreach ($_SESSION['carrito'] as $idProducto => $cantidad) {
        $productoInfo = obtenerInformacionProducto($idProducto);
        $total += $productoInfo['precio'] * $cantidad;
    }

    return $total;
}
